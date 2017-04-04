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
use  common\models\Service;

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

        // Last ID and code for invoice no // 
        $invoiceId = $model->getInvoiceId();
        $yrNow = date('Y');
        $monthNow = date('m');
        $invoiceNo = 'INV' . $yrNow . $monthNow . sprintf('%003d', $invoiceId); 
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

        return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'model' => $model,
                        'invoiceNo' => $invoiceNo,
                        'dateNow' => $dateNow,
                        'dataCustomer' => $dataCustomer,
                        'dataUser' => $dataUser,
                        'partsResult' => $partsResult,
                        'servicesResult' => $servicesResult,
                        'customerModel' => $customerModel,
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
        $dataCustomer = ArrayHelper::map(Customer::find()->where('status = 1')->all(),'id', 'fullname');
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
            'dataCustomer' => $dataCustomer,
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
            $model->do = 0;
            $model->paid = 0;
            $model->deleted = 0;

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
                }

                return json_encode(['message' => 'Invoice was successfully saved.', 'status' => 'Success', 'id' => $invoiceId ]);

            }else{
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

            $model->invoice_no = Yii::$app->request->post('invoice_no');
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
            $model->do = 0;
            $model->paid = 0;
            $model->deleted = 0;

            if($model->validate()) {
                $model->save();
                
                $invoiceId = Yii::$app->request->post('invoiceId');
                $parts_services = Yii::$app->request->post('parts_services');
                $parts_services_qty = Yii::$app->request->post('parts_services_qty');
                $parts_services_price = Yii::$app->request->post('parts_services_price');
                $parts_services_subtotal = Yii::$app->request->post('parts_services_subtotal');

                InvoiceDetail::deleteAll(['invoice_id' => $invoiceId]);

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
        $getInvoiceInfo = $model->getInvoiceByIdForPreview($id);
        $getInvoiceServicesInfo = $model->getInvoiceServiceForPreview($id);
        $getInvoicePartsInfo = $model->getInvoicePartsForPreview($id);   

        $data = array();
        $data['quotation_code'] = $getInvoiceInfo['quotation_code'];
        $data['invoice_no'] = $getInvoiceInfo['invoice_no'];
        $data['customer_id'] = $getInvoiceInfo['customer_id']; 
        $data['user_id'] = $getInvoiceInfo['user_id']; 
        $data['date_issue'] = date('d-m-Y', strtotime($getInvoiceInfo['date_issue']));      
        $data['remarks'] = $getInvoiceInfo['remarks'];
        $data['grand_total'] = $getInvoiceInfo['grand_total'];
        $data['gst'] = $getInvoiceInfo['gst'];
        $data['net'] = $getInvoiceInfo['net']; 
        
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
        $this->findModel(Yii::$app->request->post('id'))->delete();
        
        return json_encode(['status' => 'Success', 'message' => 'Your record was successfully deleted in the database.']);
    }

    public function actionApproveColumn()
    {
        $model = Invoice::findOne(Yii::$app->request->post('id'));
        $model->status = 2;
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

    // =============== payment =============== //

    public function actionInvoicePayment($id)
    {
        return $id;
    }

}
