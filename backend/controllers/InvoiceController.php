<?php

namespace backend\controllers;

use Yii;
use common\models\Invoice;
use common\models\SearchInvoice;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\helpers\ArrayHelper;

use common\models\InvoiceDetail;
use common\models\Customer;
use common\models\User;
use common\models\Service;
use common\models\Parts;
use common\models\PartsInventory;
use common\models\CustomerContactpersonAddress;
use common\models\DeliveryOrder;
use common\models\DeliveryOrderDetail;

/**
 * InvoiceController implements the CRUD actions for Invoice model.
 */
class InvoiceController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Invoice models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchInvoice();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new Invoice();
        $customerModel = new Customer();

        $getLastId = $customerModel->getLastId();
        $yearNow = date('Y');
        $customerCode = 'CUSTOMER' . $yearNow . sprintf('%005d', $getLastId);

        // Last ID and code for invoice no // 
        $invoiceId = $model->getInvoiceId();
        $yrNow = date('Y');
        $monthNow = date('m');
        $invoiceNo = 'INV' . $yrNow . $monthNow . sprintf('%005d', $invoiceId); 
        // for date issue //
        $dateNow = date('d-m-Y');
        // get customer list //
        $dataCustomerList = $model->getCustomerList();
        // get user list //
        $dataUser = ArrayHelper::map(User::find()->where('role_id <> 1', ['status' => 1])->all(),'id', 'fullname');
        // get parts //
        $partsResult = $model->getPartsList();
        // get services //
        $servicesResult = $model->getServicesList();

        return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'model' => $model,
                        'invoiceNo' => $invoiceNo,
                        'dateNow' => $dateNow,
                        'dataCustomerList' => $dataCustomerList,
                        'dataUser' => $dataUser,
                        'partsResult' => $partsResult,
                        'servicesResult' => $servicesResult,
                        'customerModel' => $customerModel,
                        'customerCode' => $customerCode,

                    ]);
    }

    /**
     * Displays a single Invoice model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = new Invoice();
        $getInvoiceInfo = $model->getInvoiceByIdForPreview($id);
        $getInvoiceServicesInfo = $model->getInvoiceServiceForPreview($id);
        $getInvoicePartsInfo = $model->getInvoicePartsForPreview($id);    

        // for date issue //
        $dateNow = date('d-m-Y');
        // get customer list //
        $dataCustomerList = $model->getCustomerList();
        // get user list //
        $dataUser = ArrayHelper::map(User::find()->where('role_id <> 1', ['status' => 1])->all(),'id', 'fullname');
        // get parts //
        $partsResult = $model->getPartsList();
        // get services //
        $servicesResult = $model->getServicesList();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'getInvoiceInfo' => $getInvoiceInfo,
            'getInvoiceServicesInfo' => $getInvoiceServicesInfo,
            'getInvoicePartsInfo' => $getInvoicePartsInfo,
            'dateNow' => $dateNow,
            'dataCustomerList' => $dataCustomerList,
            'dataUser' => $dataUser,
            'partsResult' => $partsResult,
            'servicesResult' => $servicesResult,

        ]);
    }

    /**
     * Creates a new Invoice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Invoice();

        if ( Yii::$app->request->post() ) {
            
            $model->quotation_code = 0;
            $model->invoice_no = Yii::$app->request->post('invoice_no');
            $model->user_id = Yii::$app->request->post('salesPerson');
            $model->customer_id = Yii::$app->request->post('customerName');
            $model->date_issue = date('Y-m-d', strtotime(Yii::$app->request->post('dateIssue')));
            $model->grand_total = Yii::$app->request->post('grandTotal');
            $model->gst = Yii::$app->request->post('gst_amount');
            $model->gst_value = Yii::$app->request->post('gst_value');
            $model->net = Yii::$app->request->post('netTotal');
            $model->remarks = strtolower(Yii::$app->request->post('remarks'));
            $model->payment_type_id = Yii::$app->request->post('paymentType');
            $model->discount_amount = Yii::$app->request->post('discountAmount');
            $model->discount_remarks = strtolower(Yii::$app->request->post('discountRemarks'));
            $model->status = 1;
            $model->created_at = date('Y-m-d H:i:s');
            $model->created_by = Yii::$app->user->identity->id;
            $model->do = 0;
            $model->paid = 0;
            $model->deleted = 0;
            $model->condition = 0;

            if($model->validate()) {
                $model->save();
                $invoiceId = $model->id;

                $parts_services = Yii::$app->request->post('parts_services');
                $parts_services_qty = Yii::$app->request->post('parts_services_qty');
                $parts_services_price = Yii::$app->request->post('parts_services_price');
                $parts_services_subtotal = Yii::$app->request->post('parts_services_subtotal');
                
                foreach($parts_services_qty as $key => $quoteRow){
                    $invD = new InvoiceDetail();

                    $getServicePart = explode('-', $parts_services[$key]['value']);
                    $type = $getServicePart[0];
                    $service_part_id = $getServicePart[1];

                    $invD->description = $service_part_id;
                    $invD->invoice_id = $invoiceId;
                    $invD->quantity = $parts_services_qty[$key]['value'];
                    $invD->unit_price = $parts_services_price[$key]['value'];
                    $invD->sub_total = $parts_services_subtotal[$key]['value'];
                    $invD->type = $type;
                    $invD->created_at = date('Y-m-d H:i:s');
                    $invD->created_by = Yii::$app->user->identity->id;
                    $invD->updated_at = date('Y-m-d H:i:s');
                    $invD->updated_by = Yii::$app->user->identity->id;
                    $invD->status = 1;
                    $invD->deleted = 0;

                    $invD->save();

                    if( $type == 1 ){
                        $getPart = Parts::find()->where(['id' => $service_part_id ])->one();
                        $old_qty = $getPart->quantity;
                        $new_qty = $getPart->quantity - $parts_services_qty[$key]['value'];

                        $partsinventoryModel = new PartsInventory();
                                    
                        $partsinventoryModel->parts_id = $service_part_id;
                        $partsinventoryModel->old_quantity = $old_qty;
                        $partsinventoryModel->new_quantity = $new_qty;
                        $partsinventoryModel->qty_purchased = $parts_services_qty[$key]['value'];
                        $partsinventoryModel->type = 3;
                        $partsinventoryModel->invoice_no = Yii::$app->request->post('invoice_no');
                        $partsinventoryModel->datetime_purchased = date('Y-m-d', strtotime(Yii::$app->request->post('dateIssue')));
                        $partsinventoryModel->created_at = date('Y-m-d H:i:s');
                        $partsinventoryModel->created_by = Yii::$app->user->identity->id;
                        $partsinventoryModel->status = 1;
                        
                        $partsinventoryModel->save();

                        $getPart = Parts::find()->where(['id' => $service_part_id ])->one();
                        $getPart->quantity -= $parts_services_qty[$key]['value'];
                        $getPart->save();
                    }

                }

                return json_encode(['message' => 'Invoice was successfully saved.', 'status' => 'Success', 'id' => $invoiceId ]);

            }else{
                return json_encode(['message' => $model->errors, 'status' => 'Error']);
            
            }

        }
    }

    public function actionCreateCompany()
    {
        $model = new Customer();

         if ( Yii::$app->request->post() ) {
            
            $model->type = 1;
            $model->customer_code = strtolower(Yii::$app->request->post('companyCode'));
            $model->company_name = strtolower(Yii::$app->request->post('companyName'));
            $model->location = strtolower(Yii::$app->request->post('companyLocation'));
            $model->uen_no = strtolower(Yii::$app->request->post('companyUenNo'));
            $model->email = strtolower(Yii::$app->request->post('companyEmail'));
            $model->phone_number = Yii::$app->request->post('companyPhoneNumber');
            $model->mobile_number = Yii::$app->request->post('companyOfficeNumber');
            $model->fax_number = Yii::$app->request->post('companyFaxNumber');
            $model->remarks = strtolower(Yii::$app->request->post('companyRemarks'));
            $model->status = 1;
            $model->created_at = date('Y-m-d H:i:s');
            $model->created_by = Yii::$app->user->identity->id;            

            if($model->validate()) {
               $model->save();

               $contactPerson = Yii::$app->request->post('companyContactPerson');
               $companyAddress = Yii::$app->request->post('companyAddress');

               foreach($contactPerson as $cKey => $cValue){
                    
                    $companyInfo = new CustomerContactpersonAddress();
                    
                    $companyInfo->customer_id = $model->id;
                    $companyInfo->address = $companyAddress[$cKey]['value'];
                    $companyInfo->contact_person = $contactPerson[$cKey]['value'];
                    $companyInfo->status = 1;
                    $companyInfo->created_at = date('Y-m-d H:i:s');
                    $companyInfo->created_by = Yii::$app->user->identity->id;
                    $companyInfo->save();

               }

               return json_encode(['message' => 'Your record was successfully added in the database.', 'status' => 'Success', 'id' => $model->id ]);

            } else {
               return json_encode(['message' => $model->errors, 'status' => 'Error']);
            
            }

        }
    }

    public function actionCreateCustomer()
    {
        $model = new Customer();

        if ( Yii::$app->request->post() ) {
            
            $model->type = 2;
            $model->fullname = strtolower(Yii::$app->request->post('fullname'));
            $model->nric = strtolower(Yii::$app->request->post('customerNric'));
            $model->address = strtolower(Yii::$app->request->post('customerAddress'));
            $model->shipping_address = strtolower(Yii::$app->request->post('customerShippingAddress'));
            $model->race_id = Yii::$app->request->post('customerRace');
            $model->email = strtolower(Yii::$app->request->post('customerEmail'));
            $model->phone_number = Yii::$app->request->post('customerPhoneNumber');
            $model->mobile_number = Yii::$app->request->post('customerOficeNumber');
            $model->fax_number = Yii::$app->request->post('customerFaxNumber');
            $model->status = 1;
            $model->created_at = date('Y-m-d H:i:s');
            $model->created_by = Yii::$app->user->identity->id;

            if($model->validate()) {
               $model->save();
               return json_encode(['message' => 'Your record was successfully added in the database.', 'status' => 'Success', 'id' => $model->id ]);

            } else {
               return json_encode(['message' => $model->errors, 'status' => 'Error']);
            
            }

        }
    }

    /**
     * Updates an existing Invoice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        if ( Yii::$app->request->post() ) {
            
            $model = Invoice::findOne(Yii::$app->request->post('invoiceId'));

            $model->quotation_code = 0;
            $model->invoice_no = Yii::$app->request->post('invoice_no');
            $model->user_id = Yii::$app->request->post('salesPerson');
            $model->customer_id = Yii::$app->request->post('customerName');
            $model->date_issue = date('Y-m-d', strtotime(Yii::$app->request->post('dateIssue')));
            $model->grand_total = Yii::$app->request->post('grandTotal');
            $model->gst = Yii::$app->request->post('gst_amount');
            $model->gst_value = Yii::$app->request->post('gst_value');
            $model->net = Yii::$app->request->post('netTotal');
            $model->remarks = strtolower(Yii::$app->request->post('remarks'));
            $model->payment_type_id = Yii::$app->request->post('paymentType');
            $model->discount_amount = Yii::$app->request->post('discountAmount');
            $model->discount_remarks = strtolower(Yii::$app->request->post('discountRemarks'));
            $model->status = 1;
            $model->updated_at = date('Y-m-d H:i:s');
            $model->updated_by = Yii::$app->user->identity->id;
            $model->do = 0;
            $model->paid = 0;
            $model->deleted = 0;
            $model->condition = 0;

            if($model->validate()) {
                $model->save();
                
                $invoiceId = Yii::$app->request->post('invoiceId');
                
                $getQty = InvoiceDetail::find()->where(['invoice_id' => $invoiceId])->andWhere('type = 1')->all();
                        
                foreach( $getQty as $partsInfo ) {
                    $partsid = $partsInfo['description'];
                     
                    $findPartModel = Parts::findOne($partsid);
                    $findPartModel->quantity += $partsInfo['quantity'];
                    $findPartModel->save();
                }

                InvoiceDetail::deleteAll(['invoice_id' => $invoiceId]);

                foreach( Yii::$app->request->post('parts_services_qty') as $key => $invRow){
                    $invD = new InvoiceDetail();

                    $getServicePart = explode('-', Yii::$app->request->post('parts_services')[$key]['value'] );
                    $type = $getServicePart[0];
                    $service_part_id = $getServicePart[1];

                    $invD->description = $service_part_id;
                    $invD->invoice_id = $invoiceId;
                    $invD->quantity = Yii::$app->request->post('parts_services_qty')[$key]['value'];
                    $invD->unit_price = Yii::$app->request->post('parts_services_price')[$key]['value'];
                    $invD->sub_total = Yii::$app->request->post('parts_services_subtotal')[$key]['value'];
                    $invD->type = $type;
                    $invD->created_at = date('Y-m-d H:i:s');
                    $invD->created_by = Yii::$app->user->identity->id;
                    $invD->updated_at = date('Y-m-d H:i:s');
                    $invD->updated_by = Yii::$app->user->identity->id;
                    $invD->status = 1;
                    $invD->deleted = 0;

                    $invD->save();

                    if( $type == 1 ){
                        $getPart = Parts::find()->where(['id' => $service_part_id ])->one();
                        $old_qty = $getPart->quantity;
                        $new_qty = $getPart->quantity - Yii::$app->request->post('parts_services_qty')[$key]['value'];

                        $partsinventoryModel = new PartsInventory();
                                    
                        $partsinventoryModel->parts_id = $service_part_id;
                        $partsinventoryModel->old_quantity = $old_qty;
                        $partsinventoryModel->new_quantity = $new_qty;
                        $partsinventoryModel->qty_purchased = Yii::$app->request->post('parts_services_qty')[$key]['value'];
                        $partsinventoryModel->type = 3;
                        $partsinventoryModel->invoice_no = Yii::$app->request->post('invoice_no');
                        $partsinventoryModel->datetime_purchased = date('Y-m-d', strtotime(Yii::$app->request->post('dateIssue')));
                        $partsinventoryModel->created_at = date('Y-m-d H:i:s');
                        $partsinventoryModel->created_by = Yii::$app->user->identity->id;
                        $partsinventoryModel->status = 1;
                        
                        $partsinventoryModel->save();

                        $getPart = Parts::find()->where(['id' => $service_part_id ])->one();
                        $getPart->quantity -= Yii::$app->request->post('parts_services_qty')[$key]['value'];
                        $getPart->save();
                    }

                }

                if(count(Yii::$app->request->post('selected_parts_services_qty')) > 0)
                {
                    foreach( Yii::$app->request->post('selected_parts_services_qty') as $Skey => $invSRow){
                        $invselectedSD = new InvoiceDetail();

                        $getSelectedServicePart = explode('-', Yii::$app->request->post('selected_parts_services')[$Skey]['value'] );
                        $selected_type = $getSelectedServicePart[0];
                        $selected_service_part_id = $getSelectedServicePart[1];

                        $invselectedSD->description = $selected_service_part_id;
                        $invselectedSD->invoice_id = $invoiceId;
                        $invselectedSD->quantity = Yii::$app->request->post('selected_parts_services_qty')[$Skey]['value'];
                        $invselectedSD->unit_price = Yii::$app->request->post('selected_parts_services_price')[$Skey]['value'];
                        $invselectedSD->sub_total = Yii::$app->request->post('selected_parts_services_subtotal')[$Skey]['value'];
                        $invselectedSD->type = $selected_type;
                        $invselectedSD->created_at = date('Y-m-d H:i:s');
                        $invselectedSD->created_by = Yii::$app->user->identity->id;
                        $invselectedSD->updated_at = date('Y-m-d H:i:s');
                        $invselectedSD->updated_by = Yii::$app->user->identity->id;
                        $invselectedSD->status = 1;
                        $invselectedSD->deleted = 0;

                        $invselectedSD->save();

                        if( $selected_type == 1 ){
                            $getSelectedPart = Parts::find()->where(['id' => $selected_service_part_id ])->one();
                            $selectedpart_old_qty = $getSelectedPart->quantity;
                            $selectedpart_new_qty = $getSelectedPart->quantity - Yii::$app->request->post('selected_parts_services_qty')[$Skey]['value'];

                            $partsinventoryModel = new PartsInventory();
                                        
                            $partsinventoryModel->parts_id = $selected_service_part_id;
                            $partsinventoryModel->old_quantity = $selectedpart_old_qty;
                            $partsinventoryModel->new_quantity = $selectedpart_new_qty;
                            $partsinventoryModel->qty_purchased = Yii::$app->request->post('selected_parts_services_qty')[$Skey]['value'];
                            $partsinventoryModel->type = 3;
                            $partsinventoryModel->invoice_no = Yii::$app->request->post('invoice_no');
                            $partsinventoryModel->datetime_purchased = date('Y-m-d', strtotime(Yii::$app->request->post('dateIssue')));
                            $partsinventoryModel->created_at = date('Y-m-d H:i:s');
                            $partsinventoryModel->created_by = Yii::$app->user->identity->id;
                            $partsinventoryModel->status = 1;
                            
                            $partsinventoryModel->save();

                            $getSelectedPart = Parts::find()->where(['id' => $selected_service_part_id ])->one();
                            $getSelectedPart->quantity -= Yii::$app->request->post('selected_parts_services_qty')[$Skey]['value'];
                            $getSelectedPart->save();
                        }
                    }
                }

                return json_encode(['message' => 'Invoice was successfully updated.', 'status' => 'Success', 'id' => $invoiceId ]);

            }else{
                return json_encode(['message' => $model->errors, 'status' => 'Error']);
            
            }

        }
    }

    public function actionGetData($id)
    {
        $model = new Invoice();
        $getInvoiceInfo = $model->getInvoiceByIdForPreview(Yii::$app->request->get('id'));
        $getInvoiceServicesInfo = $model->getInvoiceServiceForPreview(Yii::$app->request->get('id'));
        $getInvoicePartsInfo = $model->getInvoicePartsForPreview(Yii::$app->request->get('id'));   

        $data = array();
        $data['quotation_code'] = $getInvoiceInfo['quotation_code'];
        $data['invoice_no'] = $getInvoiceInfo['invoice_no'];
        $data['user_id'] = $getInvoiceInfo['user_id']; 
        $data['payment_type_id'] = $getInvoiceInfo['payment_type_id']; 
        $data['remarks'] = $getInvoiceInfo['remarks'];
        $data['date_issue'] = date('d-m-Y', strtotime($getInvoiceInfo['date_issue']));      
        $data['customer_id'] = $getInvoiceInfo['customer_id']; 
        
        $data['grand_total'] = $getInvoiceInfo['grand_total'];
        $data['gst'] = $getInvoiceInfo['gst'];
        $data['gst_value'] = $getInvoiceInfo['gst_value']; 
        $data['net'] = $getInvoiceInfo['net'];

        $data['discount_amount'] = $getInvoiceInfo['discount_amount'];
        $data['discount_remarks'] = $getInvoiceInfo['discount_remarks']; 

        $data['type'] = $getInvoiceInfo['type'];
        $data['fullname'] = $getInvoiceInfo['customerName'];
        $data['company_name'] = $getInvoiceInfo['company_name'];
        $data['uen_no'] = $getInvoiceInfo['uen_no']; 
        $data['nric'] = $getInvoiceInfo['nric']; 
        $data['address'] = $getInvoiceInfo['address']; 
        $data['shipping_address'] = $getInvoiceInfo['shipping_address']; 
        $data['email'] = $getInvoiceInfo['email']; 
        $data['phone_number'] = $getInvoiceInfo['phone_number']; 
        $data['mobile_number'] = $getInvoiceInfo['mobile_number']; 
        $data['fax_number'] = $getInvoiceInfo['fax_number']; 
        
        return json_encode([ 'result' => $data, 'services' => $getInvoiceServicesInfo, 'parts' => $getInvoicePartsInfo ]);
    }

    /**
     * Deletes an existing Invoice model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeleteColumn()
    {
        $model = $this->findModel(Yii::$app->request->post('id'));
        $model->status = 0;
        $model->save();
        
        return json_encode(['status' => 'Success', 'message' => 'Your record was successfully deleted in the database.']);
    }

    public function actionApproveColumn()
    {
        $model = Invoice::findOne(Yii::$app->request->post('id'));
        $model->condition = 1;
        $model->action_by = Yii::$app->user->identity->id;
        $model->save();
        
        return json_encode(['status' => 'Success', 'message' => 'Your invoice was successfully approved.']);
    }

    public function actionCancelColumn()
    {
        $model = Invoice::findOne(Yii::$app->request->post('id'));
        $model->condition = 2;
        $model->action_by = Yii::$app->user->identity->id;
        $model->save();
        
        return json_encode(['status' => 'Success', 'message' => 'Your invoice was successfully approved.']);
    }

    public function actionCloseColumn()
    {
        $model = Invoice::findOne(Yii::$app->request->post('id'));
        $model->condition = 3;
        $model->action_by = Yii::$app->user->identity->id;
        $model->save();
        
        return json_encode(['status' => 'Success', 'message' => 'Your invoice was successfully approved.']);
    }

    /**
     * Finds the Invoice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Invoice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Invoice::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    // ===== invoice ajax function ===== //

    public function actionGetPartsPriceAndQty()
    {
        $model = new Invoice();
        $partsInfo = $model->getPartsById(Yii::$app->request->get('parts_id'));
        
        if(Yii::$app->request->get('parts_id') > 0) {
            return json_encode(['status' => 'success', 'result' => $partsInfo]);
        }else{
            return json_encode(['status' => 'error']);
        }
    }

    public function actionInsertAutoPartsInList()
    {
        $model = new Invoice();
    
        $partsId = Yii::$app->request->post('parts_id');
        $partsQty = Yii::$app->request->post('parts_qty');
        $partsPrice = Yii::$app->request->post('parts_price');
        $partsSubtotal = Yii::$app->request->post('parts_subtotal');
        $ctr = Yii::$app->request->post('ctr');

        $partsInfo = $model->getPartsById($partsId);

        $this->layout = false;

        return $this->render('insert-item-in-list',[
                            'services_id' => false,
                            'services_name' => false,
                            'services_description' => false,
                            'parts_id' => $partsId,
                            'parts_name' => $partsInfo['parts_name'],
                            'quantity' => $partsQty,
                            'unit_price' => $partsPrice,
                            'sub_total' => $partsSubtotal,
                            'ctr' => $ctr,
                            'type' => 1,
                        ]);

    }

    public function actionGetServicesPriceAndQty()
    {
        $model = new Invoice();
        $servicesInfo = $model->getServicesById(Yii::$app->request->get('services_id'));
        
        if(Yii::$app->request->get('services_id') > 0) {
            return json_encode(['status' => 'success', 'result' => $servicesInfo]);
        }else{
            return json_encode(['status' => 'error']);
        }
    }

    public function actionInsertServicesInList()
    {
        $model = new Invoice();
    
        $servicesId = Yii::$app->request->post('services_id');
        $servicesQty = Yii::$app->request->post('services_qty');
        $servicesPrice = Yii::$app->request->post('services_price');
        $servicesSubtotal = Yii::$app->request->post('services_subtotal');
        $ctr = Yii::$app->request->post('ctr');

        $servicesInfo = $model->getServicesById($servicesId);

        $this->layout = false;

        return $this->render('insert-item-in-list',[
                            'services_id' => $servicesId,
                            'services_name' => $servicesInfo['service_name'],
                            'services_description' => $servicesInfo['description'],
                            'parts_id' => false,
                            'parts_name' => false,
                            'quantity' => $servicesQty,
                            'unit_price' => $servicesPrice,
                            'sub_total' => $servicesSubtotal,
                            'ctr' => $ctr,
                            'type' => 0,
                        ]);

    }

    public function actionSaveServiceDetails()
    {
        $service = Service::findOne(Yii::$app->request->post('service_id'));
        $service->service_name = Yii::$app->request->post('service_details');
        
        if($service->save()){
            return json_encode(['status' => 'success']);
        }else{
            return json_encode(['status' => 'error']);
        }
    }

    public function actionUpdateAutoPartsInList()
    {
        $model = new Invoice();
    
        $partsId = Yii::$app->request->post('parts_id');
        $partsQty = Yii::$app->request->post('parts_qty');
        $partsPrice = Yii::$app->request->post('parts_price');
        $partsSubtotal = Yii::$app->request->post('parts_subtotal');
        $ctr = Yii::$app->request->post('ctr');

        $partsInfo = $model->getPartsById($partsId);

        $this->layout = false;

        return $this->render('update-item-in-list',[
                            'services_id' => false,
                            'services_name' => false,
                            'services_description' => false,
                            'parts_id' => $partsId,
                            'parts_name' => $partsInfo['parts_name'],
                            'quantity' => $partsQty,
                            'unit_price' => $partsPrice,
                            'sub_total' => $partsSubtotal,
                            'ctr' => $ctr,
                            'type' => 1,
                        ]);

    }

    public function actionUpdateServicesInList()
    {
        $model = new Invoice();
    
        $servicesId = Yii::$app->request->post('services_id');
        $servicesQty = Yii::$app->request->post('services_qty');
        $servicesPrice = Yii::$app->request->post('services_price');
        $servicesSubtotal = Yii::$app->request->post('services_subtotal');
        $ctr = Yii::$app->request->post('ctr');

        $servicesInfo = $model->getServicesById($servicesId);

        $this->layout = false;

        return $this->render('update-item-in-list',[
                            'services_id' => $servicesId,
                            'services_name' => $servicesInfo['service_name'],
                            'services_description' => $servicesInfo['description'],
                            'parts_id' => false,
                            'parts_name' => false,
                            'quantity' => $servicesQty,
                            'unit_price' => $servicesPrice,
                            'sub_total' => $servicesSubtotal,
                            'ctr' => $ctr,
                            'type' => 0,
                        ]);

    }

    public function actionGetCustomerInformation()
    {
        $customerInfo = Customer::findOne(Yii::$app->request->get('customerId'));

        $data = array();
        $data['id'] = $customerInfo['id'];
        $data['type'] = $customerInfo['type'];
        $data['company_name'] = $customerInfo['company_name'];
        $data['uen_no'] = $customerInfo['uen_no'];
        $data['fullname'] = $customerInfo['fullname'];
        $data['nric'] = $customerInfo['nric'];
        $data['location'] = $customerInfo['location'];
        $data['address'] = $customerInfo['address'];
        $data['shipping_address'] = $customerInfo['shipping_address'];
        $data['email'] = $customerInfo['email'];
        $data['phone_number'] = $customerInfo['phone_number'];
        $data['mobile_number'] = $customerInfo['mobile_number'];
        $data['fax_number'] = $customerInfo['fax_number'];
        $data['remarks'] = $customerInfo['remarks'];

        return json_encode([ 'status' => 'Success', 'result' => $data ]);
    }

    // ===== create invoice from customer created ===== //

    public function actionCreateInvoice($id)
    {
        $customerInfo = Customer::findOne($id);
        $model = new Invoice();
        $customerModel = new Customer();

        // Last ID and code for invoice number // 
        $invoiceId = $model->getInvoiceId();
        $yrNow = date('Y');
        $monthNow = date('m');
        $invoiceNo = 'QUO' . $yrNow . $monthNow . sprintf('%005d', $invoiceId); 
        // for date issue //
        $dateNow = date('d-m-Y');
        // get customer list //
        $dataCustomer = ArrayHelper::map(Customer::find()->where(['status' => 1])->all(),'id', 'fullname');
        // get user list //
        $dataUser = ArrayHelper::map(User::find()->where('role_id <> 1', ['status' => 1])->all(),'id', 'fullname');
        // get parts //
        $partsResult = $model->getPartsList();
        // get services //
        $servicesResult = $model->getServicesList();

        return $this->render('_invoice-form', [
                        'model' => $model,
                        'invoiceNo' => $invoiceNo,
                        'dateNow' => $dateNow,
                        'dataUser' => $dataUser,
                        'partsResult' => $partsResult,
                        'servicesResult' => $servicesResult,
                        'customerModel' => $customerModel,
                        'customerInfo' => $customerInfo,
                        'dataCustomer' => $dataCustomer,
                        
                    ]);
    }

    public function actionInsertCompanyContactpersonAddress()
    {
        $contact_person = Yii::$app->request->post('companyContactPerson');
        $address = Yii::$app->request->post('companyAddress');
        $ctr = Yii::$app->request->post('ctr');

        $this->layout = false;

        return $this->render('_insert-company-contactperson-address', [
                'contact_person' => $contact_person,
                'address' => $address,
                'ctr' => $ctr,
            ]);
    }

    // =============== Create Delivery Order =============== //

    public function actionInsertIntoDeliveryOrder()
    {
        $model = new Invoice();

        $getInvoiceInfo = $model->getInvoiceByIdForPreview(Yii::$app->request->post('id'));
        $getInvoiceServicesInfo = $model->getInvoiceServiceForPreview(Yii::$app->request->post('id'));
        $getInvoicePartsInfo = $model->getInvoicePartsForPreview(Yii::$app->request->post('id')); 
        
        // Last ID and code for delivery order no // 
        $deliveryorderId = $model->getDeliveryOrderId();
        $yrNow = date('Y');
        $monthNow = date('m');
        $deliveryorderCode = 'DO' . $yrNow . $monthNow . sprintf('%005d', $deliveryorderId); 

        $getDeliveryOrder = DeliveryOrder::find()->where(['invoice_no' => $getInvoiceInfo['invoice_no'] ])->one();

        if( empty($getDeliveryOrder) ) {

            $deliveryorderModel = new DeliveryOrder();

            $deliveryorderModel->delivery_order_code = $deliveryorderCode;
            $deliveryorderModel->invoice_no = $getInvoiceInfo['invoice_no'];
            $deliveryorderModel->user_id = $getInvoiceInfo['user_id'];
            $deliveryorderModel->customer_id = $getInvoiceInfo['customer_id'];
            $deliveryorderModel->date_issue = date('Y-m-d', strtotime($getInvoiceInfo['date_issue']));
            $deliveryorderModel->grand_total = $getInvoiceInfo['grand_total'];
            $deliveryorderModel->gst = $getInvoiceInfo['gst'];
            $deliveryorderModel->gst_value = $getInvoiceInfo['gst_value'];
            $deliveryorderModel->net = $getInvoiceInfo['net'];
            $deliveryorderModel->remarks = strtolower($getInvoiceInfo['remarks']);
            $deliveryorderModel->payment_type_id = $getInvoiceInfo['payment_type_id'];
            $deliveryorderModel->discount_amount = $getInvoiceInfo['discount_amount'];
            $deliveryorderModel->discount_remarks = $getInvoiceInfo['discount_remarks'];
            $deliveryorderModel->status = $getInvoiceInfo['status'];
            $deliveryorderModel->created_at = date('Y-m-d H:i:s');
            $deliveryorderModel->created_by = Yii::$app->user->identity->id;
            $deliveryorderModel->paid = 0;
            $deliveryorderModel->deleted = 0;
            $deliveryorderModel->condition = 0;
            $deliveryorderModel->action_by = 0;
            
            $deliveryorderModel->save();

            $deliveryorderId = $deliveryorderModel->id;

            if( !empty($getInvoiceServicesInfo) ){

                foreach($getInvoiceServicesInfo as $serviceRow){
                    $doSD = new DeliveryOrderDetail();

                    $doSD->delivery_order_id = $deliveryorderId;
                    $doSD->description = $serviceRow['description'];
                    $doSD->quantity = $serviceRow['quantity'];
                    $doSD->unit_price = $serviceRow['unit_price'];
                    $doSD->sub_total = $serviceRow['sub_total'];
                    $doSD->type = $serviceRow['type'];
                    $doSD->status = $serviceRow['status'];
                    $doSD->created_at = date('Y-m-d H:i:s');
                    $doSD->created_by = Yii::$app->user->identity->id;
                    $doSD->deleted = 0;

                    $doSD->save();
                }

            }

            if( !empty($getInvoicePartsInfo) ){

                foreach($getInvoicePartsInfo as $partsRow){
                    $doPD = new DeliveryOrderDetail();

                    $doPD->delivery_order_id = $deliveryorderId;
                    $doPD->description = $partsRow['description'];
                    $doPD->quantity = $partsRow['quantity'];
                    $doPD->unit_price = $partsRow['unit_price'];
                    $doPD->sub_total = $partsRow['sub_total'];
                    $doPD->type = $partsRow['type'];
                    $doPD->status = $partsRow['status'];
                    $doPD->created_at = date('Y-m-d H:i:s');
                    $doPD->created_by = Yii::$app->user->identity->id;
                    $doPD->deleted = 0;

                    $doPD->save();

                    $getPart = Parts::find()->where(['id' => $partsRow['description'] ])->one();
                    $old_qty = $getPart->quantity;
                    $new_qty = $getPart->quantity - $partsRow['quantity'];

                    $partsinventoryModel = new PartsInventory();
                                
                    $partsinventoryModel->parts_id = $partsRow['description'];
                    $partsinventoryModel->old_quantity = $old_qty;
                    $partsinventoryModel->new_quantity = $new_qty;
                    $partsinventoryModel->qty_purchased = $partsRow['quantity'];
                    $partsinventoryModel->type = 3;
                    $partsinventoryModel->invoice_no = $getInvoiceInfo['invoice_no'];
                    $partsinventoryModel->datetime_purchased = date('Y-m-d H:i:s', strtotime($getInvoiceInfo['date_issue']));
                    $partsinventoryModel->created_at = date('Y-m-d H:i:s');
                    $partsinventoryModel->created_by = Yii::$app->user->identity->id;
                    $partsinventoryModel->status = 1;
                    
                    $partsinventoryModel->save();

                    $getPart = Parts::find()->where(['id' => $partsRow['description'] ])->one();
                    $getPart->quantity -= $partsRow['quantity'];
                    $getPart->save();

                }

            }

            $doModel = $this->findModel($deliveryorderId);
            $doModel->do = 1;
            $doModel->save();

            return json_encode(['status' => 'Success', 'message' => 'Delivery order was successfully created.', 'id' => $deliveryorderId ]);

        }else{
            
            return json_encode(['status' => 'Success', 'message' => 'Delivery order was successfully created.', 'id' => $deliveryorderId ]);
        }

    }

    // =============== payment =============== //

    public function actionInvoicePayment($id)
    {
        return $id;
    }

}
