<?php

namespace backend\controllers;

use Yii;
use common\models\Quotation;
use common\models\SearchQuotation;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\helpers\ArrayHelper;

use common\models\QuotationDetail;
use common\models\Customer;
use common\models\User;
use common\models\Service;
use common\models\Invoice;
use common\models\InvoiceDetail;
use common\models\Parts;
use common\models\PartsInventory;
use common\models\CustomerContactpersonAddress;

/**
 * QuotationController implements the CRUD actions for Quotation model.
 */
class QuotationController extends Controller
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
     * Lists all Quotation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchQuotation();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new Quotation();
        $customerModel = new Customer();

        $getLastId = $customerModel->getLastId();
        $yearNow = date('Y');
        $customerCode = 'CUSTOMER' . $yearNow . sprintf('%005d', $getLastId);

        // Last ID and code for quotation code // 
        $quotationId = $model->getQuotationId();
        $yrNow = date('Y');
        $monthNow = date('m');
        $quotationCode = 'QUO' . $yrNow . $monthNow . sprintf('%005d', $quotationId); 
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
                        'quotationCode' => $quotationCode,
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
     * Displays a single Quotation model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = new Quotation();
        $getQuoteInfo = $model->getQuotationByIdForPreview($id);
        $getQuoteServicesInfo = $model->getQuotationServiceForPreview($id);
        $getQuotePartsInfo = $model->getQuotationPartsForPreview($id);    

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
            'getQuoteInfo' => $getQuoteInfo,
            'getQuoteServicesInfo' => $getQuoteServicesInfo,
            'getQuotePartsInfo' => $getQuotePartsInfo,
            'dateNow' => $dateNow,
            'dataCustomerList' => $dataCustomerList,
            'dataUser' => $dataUser,
            'partsResult' => $partsResult,
            'servicesResult' => $servicesResult,

        ]);
    }

    /**
     * Creates a new Quotation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Quotation();

        if ( Yii::$app->request->post() ) {
            
            $model->quotation_code = Yii::$app->request->post('quotationCode');
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
            $model->invoice_created = 0;
            $model->condition = 0;
            $model->deleted = 0;

            if($model->validate()) {
                $model->save();
                $quotationId = $model->id;

                $parts_services = Yii::$app->request->post('parts_services');
                $parts_services_qty = Yii::$app->request->post('parts_services_qty');
                $parts_services_price = Yii::$app->request->post('parts_services_price');
                $parts_services_subtotal = Yii::$app->request->post('parts_services_subtotal');
                
                foreach($parts_services_qty as $key => $quoteRow){
                    $quoteD = new QuotationDetail();

                    $getServicePart = explode('-', $parts_services[$key]['value']);
                    $type = $getServicePart[0];
                    $service_part_id = $getServicePart[1];

                    $quoteD->description = $service_part_id;
                    $quoteD->quotation_id = $quotationId;
                    $quoteD->quantity = $parts_services_qty[$key]['value'];
                    $quoteD->unit_price = $parts_services_price[$key]['value'];
                    $quoteD->sub_total = $parts_services_subtotal[$key]['value'];
                    $quoteD->type = $type;
                    $quoteD->created_at = date('Y-m-d H:i:s');
                    $quoteD->created_by = Yii::$app->user->identity->id;
                    $quoteD->updated_at = date('Y-m-d H:i:s');
                    $quoteD->updated_by = Yii::$app->user->identity->id;
                    $quoteD->status = 1;
                    $quoteD->deleted = 0;

                    $quoteD->save();
                }

                return json_encode(['message' => 'Quotation was successfully saved.', 'status' => 'Success', 'id' => $quotationId ]);

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
     * Updates an existing Quotation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        if ( Yii::$app->request->post() ) {
            
            $model = Quotation::findOne(Yii::$app->request->post('quotationId'));

            $model->quotation_code = Yii::$app->request->post('quotationCode');
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
            $model->invoice_created = 0;
            $model->condition = 0;
            $model->deleted = 0;

            if($model->validate()) {
                $model->save();

                $quotationId = Yii::$app->request->post('quotationId');

                QuotationDetail::deleteAll(['quotation_id' => $quotationId]);

                foreach( Yii::$app->request->post('parts_services_qty') as $key => $quoteRow){
                    $quoteD = new QuotationDetail();

                    $getServicePart = explode('-', Yii::$app->request->post('parts_services')[$key]['value'] );
                    $type = $getServicePart[0];
                    $service_part_id = $getServicePart[1];

                    $quoteD->description = $service_part_id;
                    $quoteD->quotation_id = $quotationId;
                    $quoteD->quantity = Yii::$app->request->post('parts_services_qty')[$key]['value'];
                    $quoteD->unit_price = Yii::$app->request->post('parts_services_price')[$key]['value'];
                    $quoteD->sub_total = Yii::$app->request->post('parts_services_subtotal')[$key]['value'];
                    $quoteD->type = $type;
                    $quoteD->created_at = date('Y-m-d H:i:s');
                    $quoteD->created_by = Yii::$app->user->identity->id;
                    $quoteD->updated_at = date('Y-m-d H:i:s');
                    $quoteD->updated_by = Yii::$app->user->identity->id;
                    $quoteD->status = 1;
                    $quoteD->deleted = 0;

                    $quoteD->save();
                }

                if(count(Yii::$app->request->post('selected_parts_services_qty')) > 0)
                {
                    foreach( Yii::$app->request->post('selected_parts_services_qty') as $Skey => $quoteSRow){
                        $quoteselectedSD = new QuotationDetail();

                        $getSelectedServicePart = explode('-', Yii::$app->request->post('selected_parts_services')[$Skey]['value'] );
                        $selected_type = $getSelectedServicePart[0];
                        $selected_service_part_id = $getSelectedServicePart[1];

                        $quoteselectedSD->description = $selected_service_part_id;
                        $quoteselectedSD->quotation_id = $quotationId;
                        $quoteselectedSD->quantity = Yii::$app->request->post('selected_parts_services_qty')[$Skey]['value'];
                        $quoteselectedSD->unit_price = Yii::$app->request->post('selected_parts_services_price')[$Skey]['value'];
                        $quoteselectedSD->sub_total = Yii::$app->request->post('selected_parts_services_subtotal')[$Skey]['value'];
                        $quoteselectedSD->type = $selected_type;
                        $quoteselectedSD->created_at = date('Y-m-d H:i:s');
                        $quoteselectedSD->created_by = Yii::$app->user->identity->id;
                        $quoteselectedSD->updated_at = date('Y-m-d H:i:s');
                        $quoteselectedSD->updated_by = Yii::$app->user->identity->id;
                        $quoteselectedSD->status = 1;
                        $quoteselectedSD->deleted = 0;

                        $quoteselectedSD->save();
                    }
                }

                return json_encode(['message' => 'Quotation was successfully updated.', 'status' => 'Success', 'id' => $quotationId ]);

            }else{
                return json_encode(['message' => $model->errors, 'status' => 'Error']);
            
            }

        }
    }

    public function actionGetData()
    {
        $model = new Quotation();
        $getQuoteInfo = $model->getQuotationByIdForPreview(Yii::$app->request->get('id'));
        $getQuoteServicesInfo = $model->getQuotationServiceForPreview(Yii::$app->request->get('id'));
        $getQuotePartsInfo = $model->getQuotationPartsForPreview(Yii::$app->request->get('id'));   

        $data = array();
        $data['quotation_code'] = $getQuoteInfo['quotation_code'];
        $data['user_id'] = $getQuoteInfo['user_id']; 
        $data['payment_type_id'] = $getQuoteInfo['payment_type_id']; 
        $data['remarks'] = $getQuoteInfo['remarks'];
        $data['date_issue'] = date('d-m-Y', strtotime($getQuoteInfo['date_issue']));      
        $data['customer_id'] = $getQuoteInfo['customer_id']; 
        
        $data['grand_total'] = $getQuoteInfo['grand_total'];
        $data['gst'] = $getQuoteInfo['gst'];
        $data['gst_value'] = $getQuoteInfo['gst_value']; 
        $data['net'] = $getQuoteInfo['net'];

        $data['discount_amount'] = $getQuoteInfo['discount_amount'];
        $data['discount_remarks'] = $getQuoteInfo['discount_remarks']; 

        $data['type'] = $getQuoteInfo['type'];
        $data['fullname'] = $getQuoteInfo['customerName'];
        $data['company_name'] = $getQuoteInfo['company_name'];
        $data['uen_no'] = $getQuoteInfo['uen_no']; 
        $data['nric'] = $getQuoteInfo['nric']; 
        $data['address'] = $getQuoteInfo['address']; 
        $data['shipping_address'] = $getQuoteInfo['shipping_address']; 
        $data['email'] = $getQuoteInfo['email']; 
        $data['phone_number'] = $getQuoteInfo['phone_number']; 
        $data['mobile_number'] = $getQuoteInfo['mobile_number']; 
        $data['fax_number'] = $getQuoteInfo['fax_number']; 
        
        return json_encode([ 'result' => $data, 'parts' => $getQuotePartsInfo, 'services' => $getQuoteServicesInfo ]);
    }

    /**
     * Deletes an existing Quotation model.
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
        $model = Quotation::findOne(Yii::$app->request->post('id'));
        $model->condition = 1;
        $model->action_by = Yii::$app->user->identity->id;
        $model->save();
        
        return json_encode(['status' => 'Success', 'message' => 'Your quotation was successfully approved.']);
    }

    public function actionCancelColumn()
    {
        $model = Quotation::findOne(Yii::$app->request->post('id'));
        $model->condition = 2;
        $model->action_by = Yii::$app->user->identity->id;
        $model->save();
        
        return json_encode(['status' => 'Success', 'message' => 'Your quotation was successfully approved.']);
    }

    public function actionCloseColumn()
    {
        $model = Quotation::findOne(Yii::$app->request->post('id'));
        $model->condition = 3;
        $model->action_by = Yii::$app->user->identity->id;
        $model->save();
        
        return json_encode(['status' => 'Success', 'message' => 'Your quotation was successfully approved.']);
    }

    /**
     * Finds the Quotation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Quotation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Quotation::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    // ===== quotation ajax function ===== //

    public function actionGetPartsPriceAndQty()
    {
        $model = new Quotation();
        $partsInfo = $model->getPartsById(Yii::$app->request->get('parts_id'));
        
        if(Yii::$app->request->get('parts_id') > 0) {
            return json_encode(['status' => 'success', 'result' => $partsInfo]);
        }else{
            return json_encode(['status' => 'error']);
        }
    }

    public function actionInsertAutoPartsInList()
    {
        $model = new Quotation();
    
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
        $model = new Quotation();
        $servicesInfo = $model->getServicesById(Yii::$app->request->get('services_id'));
        
        if(Yii::$app->request->get('services_id') > 0) {
            return json_encode(['status' => 'success', 'result' => $servicesInfo]);
        }else{
            return json_encode(['status' => 'error']);
        }
    }

    public function actionInsertServicesInList()
    {
        $model = new Quotation();
    
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
        $model = new Quotation();
    
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
        $model = new Quotation();
    
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

    // ===== create quotation from customer created ===== //

    public function actionCreateQuotation($id)
    {
        $customerInfo = Customer::findOne($id);
        $model = new Quotation();
        $customerModel = new Customer();

        // Last ID and code for quotation code // 
        $quotationId = $model->getQuotationId();
        $yrNow = date('Y');
        $monthNow = date('m');
        $quotationCode = 'QUO' . $yrNow . $monthNow . sprintf('%005d', $quotationId); 
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

        return $this->render('_quotation-form', [
                        'model' => $model,
                        'quotationCode' => $quotationCode,
                        'dateNow' => $dateNow,
                        'dataUser' => $dataUser,
                        'partsResult' => $partsResult,
                        'servicesResult' => $servicesResult,
                        'customerModel' => $customerModel,
                        'customerInfo' => $customerInfo,
                        'dataCustomer' => $dataCustomer,
                        
                    ]);
    }

    // =============== Create Invoice =============== //

    public function actionInsertIntoInvoice()
    {
        $model = new Quotation();

        $getQuoteInfo = $model->getQuotationByIdForPreview(Yii::$app->request->post('id'));
        $getQuoteServicesInfo = $model->getQuotationServiceForPreview(Yii::$app->request->post('id'));
        $getQuotePartsInfo = $model->getQuotationPartsForPreview(Yii::$app->request->post('id')); 
        
        // Last ID and code for invoice no // 
        $invoiceId = $model->getInvoiceId();
        $yrNow = date('Y');
        $monthNow = date('m');
        $invoiceNo = 'INV' . $yrNow . $monthNow . sprintf('%005d', $invoiceId); 

        $getInvoice = Invoice::find()->where(['quotation_code' => $getQuoteInfo['quotation_code'] ])->one();

        if( empty($getInvoice) ) {

            $invoiceModel = new Invoice();

            $invoiceModel->quotation_code = $getQuoteInfo['quotation_code'];
            $invoiceModel->invoice_no = $invoiceNo;
            $invoiceModel->user_id = $getQuoteInfo['user_id'];
            $invoiceModel->customer_id = $getQuoteInfo['customer_id'];
            $invoiceModel->date_issue = date('Y-m-d', strtotime($getQuoteInfo['date_issue']));
            $invoiceModel->grand_total = $getQuoteInfo['grand_total'];
            $invoiceModel->gst = $getQuoteInfo['gst'];
            $invoiceModel->gst_value = $getQuoteInfo['gst_value'];
            $invoiceModel->net = $getQuoteInfo['net'];
            $invoiceModel->remarks = strtolower($getQuoteInfo['remarks']);
            $invoiceModel->payment_type_id = $getQuoteInfo['payment_type_id'];
            $invoiceModel->discount_amount = $getQuoteInfo['discount_amount'];
            $invoiceModel->discount_remarks = $getQuoteInfo['discount_remarks'];
            $invoiceModel->status = $getQuoteInfo['status'];
            $invoiceModel->created_at = date('Y-m-d H:i:s');
            $invoiceModel->created_by = Yii::$app->user->identity->id;
            $invoiceModel->do = 0;
            $invoiceModel->paid = 0;
            $invoiceModel->deleted = 0;
            $invoiceModel->condition = 0;
            $invoiceModel->action_by = 0;
            
            $invoiceModel->save();

            $invoiceId = $invoiceModel->id;

            if( !empty($getQuoteServicesInfo) ){

                foreach($getQuoteServicesInfo as $serviceRow){
                    $invSD = new InvoiceDetail();

                    $invSD->invoice_id = $invoiceId;
                    $invSD->description = $serviceRow['description'];
                    $invSD->quantity = $serviceRow['quantity'];
                    $invSD->unit_price = $serviceRow['unit_price'];
                    $invSD->sub_total = $serviceRow['sub_total'];
                    $invSD->type = $serviceRow['type'];
                    $invSD->status = $serviceRow['status'];
                    $invSD->created_at = date('Y-m-d H:i:s');
                    $invSD->created_by = Yii::$app->user->identity->id;
                    $invSD->deleted = 0;

                    $invSD->save();
                }

            }

            if( !empty($getQuotePartsInfo) ){

                foreach($getQuotePartsInfo as $partsRow){
                    $invPD = new InvoiceDetail();

                    $invPD->invoice_id = $invoiceId;
                    $invPD->description = $partsRow['description'];
                    $invPD->quantity = $partsRow['quantity'];
                    $invPD->unit_price = $partsRow['unit_price'];
                    $invPD->sub_total = $partsRow['sub_total'];
                    $invPD->type = $partsRow['type'];
                    $invPD->status = $partsRow['status'];
                    $invPD->created_at = date('Y-m-d H:i:s');
                    $invPD->created_by = Yii::$app->user->identity->id;
                    $invPD->deleted = 0;

                    $invPD->save();

                    $getPart = Parts::find()->where(['id' => $partsRow['description'] ])->one();
                    $old_qty = $getPart->quantity;
                    $new_qty = $getPart->quantity - $partsRow['quantity'];

                    $partsinventoryModel = new PartsInventory();
                                
                    $partsinventoryModel->parts_id = $partsRow['description'];
                    $partsinventoryModel->old_quantity = $old_qty;
                    $partsinventoryModel->new_quantity = $new_qty;
                    $partsinventoryModel->qty_purchased = $partsRow['quantity'];
                    $partsinventoryModel->type = 3;
                    $partsinventoryModel->invoice_no = $invoiceNo;
                    $partsinventoryModel->datetime_purchased = date('Y-m-d H:i:s', strtotime($getQuoteInfo['date_issue']));
                    $partsinventoryModel->created_at = date('Y-m-d H:i:s');
                    $partsinventoryModel->created_by = Yii::$app->user->identity->id;
                    $partsinventoryModel->status = 1;
                    
                    $partsinventoryModel->save();

                    $getPart = Parts::find()->where(['id' => $partsRow['description'] ])->one();
                    $getPart->quantity -= $partsRow['quantity'];
                    $getPart->save();

                }

            }

            $quoteModel = $this->findModel($invoiceId);
            $quoteModel->invoice_created = 1;
            $quoteModel->save();
            
            return json_encode(['status' => 'Success', 'message' => 'Invoice was successfully created.', 'id' => $invoiceId ]);

        }else{
            
            return json_encode(['status' => 'Success', 'message' => 'Invoice was successfully created.', 'id' => $invoiceId ]);
        }

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
}
