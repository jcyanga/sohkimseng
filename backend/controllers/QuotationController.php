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

        // Last ID and code for quotation code // 
        $quotationId = $model->getQuotationId();
        $yrNow = date('Y');
        $monthNow = date('m');
        $quotationCode = 'QUO' . $yrNow . $monthNow . sprintf('%003d', $quotationId); 
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

        return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'model' => $model,
                        'quotationCode' => $quotationCode,
                        'dateNow' => $dateNow,
                        'dataCustomer' => $dataCustomer,
                        'dataUser' => $dataUser,
                        'partsResult' => $partsResult,
                        'servicesResult' => $servicesResult,
                        'customerModel' => $customerModel,
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
        $dataCustomer = ArrayHelper::map(Customer::find()->where('status = 1')->all(),'id', 'fullname');
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
            'dataCustomer' => $dataCustomer,
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
            
            $model->quotation_code = Yii::$app->request->post('quotation_code');
            $model->user_id = Yii::$app->request->post('sales_person');
            $model->customer_id = Yii::$app->request->post('customer_name');
            $model->date_issue = date('Y-m-d', strtotime(Yii::$app->request->post('date_issue')));
            $model->grand_total = Yii::$app->request->post('grand_total');
            $model->gst = Yii::$app->request->post('gst_amount');
            $model->net = Yii::$app->request->post('net_total');
            $model->remarks = Yii::$app->request->post('remarks');
            $model->created_at = date('Y-m-d H:i:s');
            $model->created_by = Yii::$app->user->identity->id;
            $model->status = 1;
            $model->invoice_created = 0;
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

    public function actionCreateCustomer()
    {
        $customerModel = new Customer();

        if ( Yii::$app->request->post() ) {
            
            $customerModel->fullname = Yii::$app->request->post('fullname');
            $customerModel->address = Yii::$app->request->post('address');
            $customerModel->race_id = Yii::$app->request->post('race');
            $customerModel->email = Yii::$app->request->post('email');
            $customerModel->phone_number = Yii::$app->request->post('phoneNumber');
            $customerModel->mobile_number = Yii::$app->request->post('mobileNumber');
            $customerModel->status = 1;
            $customerModel->created_at = date('Y-m-d H:i:s');
            $customerModel->created_by = Yii::$app->user->identity->id;

            if($customerModel->validate()) {
               $customerModel->save();

               return json_encode(['message' => 'Your record was successfully added in the database.', 'status' => 'Success', 'id' => $customerModel->id ]);

            } else {
               return json_encode(['message' => $customerModel->errors, 'status' => 'Error']);
            
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

            $model->quotation_code = Yii::$app->request->post('quotation_code');
            $model->user_id = Yii::$app->request->post('sales_person');
            $model->customer_id = Yii::$app->request->post('customer_name');
            $model->date_issue = date('Y-m-d', strtotime(Yii::$app->request->post('date_issue')));
            $model->grand_total = Yii::$app->request->post('grand_total');
            $model->gst = Yii::$app->request->post('gst_amount');
            $model->net = Yii::$app->request->post('net_total');
            $model->remarks = Yii::$app->request->post('remarks');
            $model->updated_at = date('Y-m-d H:i:s');
            $model->updated_by = Yii::$app->user->identity->id;
            $model->status = 1;
            $model->invoice_created = 0;
            $model->deleted = 0;

            if($model->validate()) {
                $model->save();
                
                $quotationId = Yii::$app->request->post('quotationId');
                $parts_services = Yii::$app->request->post('parts_services');
                $parts_services_qty = Yii::$app->request->post('parts_services_qty');
                $parts_services_price = Yii::$app->request->post('parts_services_price');
                $parts_services_subtotal = Yii::$app->request->post('parts_services_subtotal');

                QuotationDetail::deleteAll(['quotation_id' => $quotationId]);

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

                return json_encode(['message' => 'Quotation was successfully updated.', 'status' => 'Success', 'id' => $quotationId ]);

            }else{
                return json_encode(['message' => $model->errors, 'status' => 'Error']);
            
            }

        }
    }

    public function actionGetData($id)
    {
        $model = new Quotation();
        $getQuoteInfo = $model->getQuotationByIdForPreview($id);
        $getQuoteServicesInfo = $model->getQuotationServiceForPreview($id);
        $getQuotePartsInfo = $model->getQuotationPartsForPreview($id);   

        $data = array();
        $data['quotation_code'] = $getQuoteInfo['quotation_code'];
        $data['customer_id'] = $getQuoteInfo['customer_id']; 
        $data['user_id'] = $getQuoteInfo['user_id']; 
        $data['date_issue'] = date('d-m-Y', strtotime($getQuoteInfo['date_issue']));      
        $data['remarks'] = $getQuoteInfo['remarks'];
        $data['grand_total'] = $getQuoteInfo['grand_total'];
        $data['gst'] = $getQuoteInfo['gst'];
        $data['net'] = $getQuoteInfo['net']; 
        
        return json_encode([ 'result' => $data, 'services' => $getQuoteServicesInfo, 'parts' => $getQuotePartsInfo ]);
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
        $this->findModel(Yii::$app->request->post('id'))->delete();
        
        return json_encode(['status' => 'Success', 'message' => 'Your record was successfully deleted in the database.']);
    }

    public function actionApproveColumn()
    {
        $model = Quotation::findOne(Yii::$app->request->post('id'));
        $model->status = 2;
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
        $quotationCode = 'QUO' . $yrNow . $monthNow . sprintf('%003d', $quotationId); 
        // for date issue //
        $dateNow = date('d-m-Y');
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
                    ]);
    }

    // =============== Create Invoice =============== //

    public function actionInsertIntoInvoice()
    {
        $model = new Quotation();

        $id = Yii::$app->request->post('id');

        $getQuoteInfo = $model->getQuotationByIdForPreview($id);
        $getQuoteServicesInfo = $model->getQuotationServiceForPreview($id);
        $getQuotePartsInfo = $model->getQuotationPartsForPreview($id); 
        
        // Last ID and code for invoice no // 
        $invoiceId = $model->getInvoiceId();
        $yrNow = date('Y');
        $monthNow = date('m');
        $invoiceNo = 'INV' . $yrNow . $monthNow . sprintf('%003d', $invoiceId); 

        $getInvoice = Invoice::find()->where(['quotation_code' => $getQuoteInfo['quotation_code'] ])->one();
     
        if( empty($getInvoice) ) {

            $invoiceModel = new Invoice();

            $invoiceModel->quotation_code = $getQuoteInfo['quotation_code'];
            $invoiceModel->invoice_no = $invoiceNo;
            $invoiceModel->user_id = $getQuoteInfo['user_id'];
            $invoiceModel->customer_id = $getQuoteInfo['customer_id'];
            $invoiceModel->date_issue = date('Y-m-d', strtotime($getQuoteInfo['user_id']));
            $invoiceModel->grand_total = $getQuoteInfo['grand_total'];
            $invoiceModel->gst = $getQuoteInfo['gst'];
            $invoiceModel->net = $getQuoteInfo['net'];
            $invoiceModel->remarks = $getQuoteInfo['remarks'];
            $invoiceModel->status = $getQuoteInfo['status'];
            $invoiceModel->created_at = date('Y-m-d H:i:s');
            $invoiceModel->created_by = Yii::$app->user->identity->id;
            $invoiceModel->do = 0;
            $invoiceModel->paid = 0;
            $invoiceModel->deleted = 0;
            
            $invoiceId = $invoiceModel->id;

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
            }

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
            }

            return json_encode(['status' => 'Success', 'message' => 'Invoice was successfully created.', 'id' => $invoiceId ]);

        }else{
            
            return json_encode(['status' => 'Success', 'message' => 'Invoice was successfully created.', 'id' => $invoiceId ]);
        }

    }
}
