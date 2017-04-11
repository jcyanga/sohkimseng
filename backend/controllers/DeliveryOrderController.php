<?php

namespace backend\controllers;

use Yii;
use common\models\DeliveryOrder;
use common\models\SearchDeliveryOrder;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\helpers\ArrayHelper;

use common\models\DeliveryOrderDetail;
use common\models\Customer;
use common\models\User;
use  common\models\Service;
use common\models\Parts;
use common\models\PartsInventory;

/**
 * DeliveyOrderController implements the CRUD actions for DeliveryOrder model.
 */
class DeliveryOrderController extends Controller
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
     * Lists all DeliveryOrder models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchDeliveryOrder();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new DeliveryOrder();
        $customerModel = new Customer();

        // Last ID and code for delivery order // 
        $deliveryorderId = $model->getDeliveryOrderId();
        $yrNow = date('Y');
        $monthNow = date('m');
        $deliveryorderCode = 'DO' . $yrNow . $monthNow . sprintf('%003d', $deliveryorderId); 
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
                        'deliveryorderCode' => $deliveryorderCode,
                        'dateNow' => $dateNow,
                        'dataCustomer' => $dataCustomer,
                        'dataUser' => $dataUser,
                        'partsResult' => $partsResult,
                        'servicesResult' => $servicesResult,
                        'customerModel' => $customerModel,
                    ]);

    }

    /**
     * Displays a single DeliveryOrder model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = new DeliveryOrder();
        $getDeliveryOrderInfo = $model->getDeliveryOrderByIdForPreview($id);
        $getDeliveryOrderServicesInfo = $model->getDeliveryOrderServiceForPreview($id);
        $getDeliveryOrderPartsInfo = $model->getDeliveryOrderPartsForPreview($id);    

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
            'getDeliveryOrderInfo' => $getDeliveryOrderInfo,
            'getDeliveryOrderServicesInfo' => $getDeliveryOrderServicesInfo,
            'getDeliveryOrderPartsInfo' => $getDeliveryOrderPartsInfo,
            'dateNow' => $dateNow,
            'dataCustomer' => $dataCustomer,
            'dataUser' => $dataUser,
            'partsResult' => $partsResult,
            'servicesResult' => $servicesResult,

        ]);
    }

    /**
     * Creates a new DeliveryOrder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DeliveryOrder();

        if ( Yii::$app->request->post() ) {
            
            $model->delivery_order_code = Yii::$app->request->post('deliveryorderCode');
            $model->invoice_no = 0;
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
            $model->discount_remarks = Yii::$app->request->post('discountRemarks');
            $model->status = 1;
            $model->created_at = date('Y-m-d H:i:s');
            $model->created_by = Yii::$app->user->identity->id;
            $model->paid = 0;
            $model->deleted = 0;

            if($model->validate()) {
                $model->save();
                $deliveryorderId = $model->id;

                $parts_services = Yii::$app->request->post('parts_services');
                $parts_services_qty = Yii::$app->request->post('parts_services_qty');
                $parts_services_price = Yii::$app->request->post('parts_services_price');
                $parts_services_subtotal = Yii::$app->request->post('parts_services_subtotal');
                
                foreach($parts_services_qty as $key => $quoteRow){
                    $deliveryorderD = new DeliveryOrderDetail();

                    $getServicePart = explode('-', $parts_services[$key]['value']);
                    $type = $getServicePart[0];
                    $service_part_id = $getServicePart[1];

                    $deliveryorderD->description = $service_part_id;
                    $deliveryorderD->delivery_order_id = $deliveryorderId;
                    $deliveryorderD->quantity = $parts_services_qty[$key]['value'];
                    $deliveryorderD->unit_price = $parts_services_price[$key]['value'];
                    $deliveryorderD->sub_total = $parts_services_subtotal[$key]['value'];
                    $deliveryorderD->type = $type;
                    $deliveryorderD->created_at = date('Y-m-d H:i:s');
                    $deliveryorderD->created_by = Yii::$app->user->identity->id;
                    $deliveryorderD->updated_at = date('Y-m-d H:i:s');
                    $deliveryorderD->updated_by = Yii::$app->user->identity->id;
                    $deliveryorderD->status = 1;
                    $deliveryorderD->deleted = 0;

                    $deliveryorderD->save();

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
                        $partsinventoryModel->invoice_no = Yii::$app->request->post('deliveryorderCode');
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

                return json_encode(['message' => 'Delivery Order was successfully saved.', 'status' => 'Success', 'id' => $deliveryorderId ]);

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
            $model->company_name = strtolower(Yii::$app->request->post('companyName'));
            $model->uen_no = strtolower(Yii::$app->request->post('companyUenNo'));
            $model->fullname = strtolower(Yii::$app->request->post('companyContactPerson'));
            $model->address = strtolower(Yii::$app->request->post('companyAddress'));
            $model->shipping_address = strtolower(Yii::$app->request->post('companyShippingAddress'));
            $model->email = strtolower(Yii::$app->request->post('companyEmail'));
            $model->phone_number = Yii::$app->request->post('companyPhoneNumber');
            $model->mobile_number = Yii::$app->request->post('companyOfficeNumber');
            $model->fax_number = Yii::$app->request->post('companyFaxNumber');
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
     * Updates an existing DeliveryOrder model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        if ( Yii::$app->request->post() ) {
            
            $model = DeliveryOrder::findOne(Yii::$app->request->post('deliveryorderId'));

            $model->delivery_order_code = Yii::$app->request->post('deliveryorderCode');
            $model->invoice_no = 0;
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
            $model->discount_remarks = Yii::$app->request->post('discountRemarks');
            $model->status = 1;
            $model->updated_at = date('Y-m-d H:i:s');
            $model->updated_by = Yii::$app->user->identity->id;
            $model->paid = 0;
            $model->deleted = 0;

            if($model->validate()) {
                $model->save();
                
                $deliveryorderId = Yii::$app->request->post('deliveryorderId');
                
                $getQty = DeliveryOrderDetail::find()->where(['delivery_order_id' => $deliveryorderId])->andWhere('type = 1')->all();
                        
                foreach( $getQty as $partsInfo ) {
                    $partsid = $partsInfo['description'];
                     
                    $findPartModel = Parts::findOne($partsid);
                    $findPartModel->quantity += $partsInfo['quantity'];
                    $findPartModel->save();
                }

                DeliveryOrderDetail::deleteAll(['delivery_order_id' => $deliveryorderId]);

                foreach( Yii::$app->request->post('parts_services_qty') as $key => $invRow){
                    $deliveryorderD = new DeliveryOrderDetail();

                    $getServicePart = explode('-', Yii::$app->request->post('parts_services')[$key]['value'] );
                    $type = $getServicePart[0];
                    $service_part_id = $getServicePart[1];

                    $deliveryorderD->description = $service_part_id;
                    $deliveryorderD->delivery_order_id = $deliveryorderId;
                    $deliveryorderD->quantity = Yii::$app->request->post('parts_services_qty')[$key]['value'];
                    $deliveryorderD->unit_price = Yii::$app->request->post('parts_services_price')[$key]['value'];
                    $deliveryorderD->sub_total = Yii::$app->request->post('parts_services_subtotal')[$key]['value'];
                    $deliveryorderD->type = $type;
                    $deliveryorderD->created_at = date('Y-m-d H:i:s');
                    $deliveryorderD->created_by = Yii::$app->user->identity->id;
                    $deliveryorderD->updated_at = date('Y-m-d H:i:s');
                    $deliveryorderD->updated_by = Yii::$app->user->identity->id;
                    $deliveryorderD->status = 1;
                    $deliveryorderD->deleted = 0;

                    $deliveryorderD->save();

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
                        $partsinventoryModel->invoice_no = Yii::$app->request->post('deliveryorderCode');
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
                        $doselectedSD = new DeliveryOrderDetail();

                        $getSelectedServicePart = explode('-', Yii::$app->request->post('selected_parts_services')[$Skey]['value'] );
                        $selected_type = $getSelectedServicePart[0];
                        $selected_service_part_id = $getSelectedServicePart[1];

                        $doselectedSD->description = $selected_service_part_id;
                        $doselectedSD->delivery_order_id = $deliveryorderId;
                        $doselectedSD->quantity = Yii::$app->request->post('selected_parts_services_qty')[$Skey]['value'];
                        $doselectedSD->unit_price = Yii::$app->request->post('selected_parts_services_price')[$Skey]['value'];
                        $doselectedSD->sub_total = Yii::$app->request->post('selected_parts_services_subtotal')[$Skey]['value'];
                        $doselectedSD->type = $selected_type;
                        $doselectedSD->created_at = date('Y-m-d H:i:s');
                        $doselectedSD->created_by = Yii::$app->user->identity->id;
                        $doselectedSD->updated_at = date('Y-m-d H:i:s');
                        $doselectedSD->updated_by = Yii::$app->user->identity->id;
                        $doselectedSD->status = 1;
                        $doselectedSD->deleted = 0;

                        $doselectedSD->save();

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
                            $partsinventoryModel->invoice_no = Yii::$app->request->post('deliveryorderCode');
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

                return json_encode(['message' => 'Delivery Order was successfully updated.', 'status' => 'Success', 'id' => $deliveryorderId ]);

            }else{
                return json_encode(['message' => $model->errors, 'status' => 'Error']);
            
            }

        }
    }

    public function actionGetData($id)
    {
        $model = new DeliveryOrder();
        $getDeliveryOrderInfo = $model->getDeliveryOrderByIdForPreview(Yii::$app->request->get('id'));
        $getDeliveryOrderServicesInfo = $model->getDeliveryOrderServiceForPreview(Yii::$app->request->get('id'));
        $getDeliveryOrderPartsInfo = $model->getDeliveryOrderPartsForPreview(Yii::$app->request->get('id'));   

        $data = array();
        $data['delivery_order_code'] = $getDeliveryOrderInfo['delivery_order_code'];
        $data['invoice_no'] = $getDeliveryOrderInfo['invoice_no'];
        $data['user_id'] = $getDeliveryOrderInfo['user_id']; 
        $data['payment_type_id'] = $getDeliveryOrderInfo['payment_type_id']; 
        $data['remarks'] = $getDeliveryOrderInfo['remarks'];
        $data['date_issue'] = date('d-m-Y', strtotime($getDeliveryOrderInfo['date_issue']));      
        $data['customer_id'] = $getDeliveryOrderInfo['customer_id']; 
        
        $data['grand_total'] = $getDeliveryOrderInfo['grand_total'];
        $data['gst'] = $getDeliveryOrderInfo['gst'];
        $data['gst_value'] = $getDeliveryOrderInfo['gst_value']; 
        $data['net'] = $getDeliveryOrderInfo['net'];

        $data['discount_amount'] = $getDeliveryOrderInfo['discount_amount'];
        $data['discount_remarks'] = $getDeliveryOrderInfo['discount_remarks']; 

        $data['type'] = $getDeliveryOrderInfo['type'];
        $data['fullname'] = $getDeliveryOrderInfo['customerName'];
        $data['company_name'] = $getDeliveryOrderInfo['company_name'];
        $data['uen_no'] = $getDeliveryOrderInfo['uen_no']; 
        $data['nric'] = $getDeliveryOrderInfo['nric']; 
        $data['address'] = $getDeliveryOrderInfo['address']; 
        $data['shipping_address'] = $getDeliveryOrderInfo['shipping_address']; 
        $data['email'] = $getDeliveryOrderInfo['email']; 
        $data['phone_number'] = $getDeliveryOrderInfo['phone_number']; 
        $data['mobile_number'] = $getDeliveryOrderInfo['mobile_number']; 
        $data['fax_number'] = $getDeliveryOrderInfo['fax_number']; 
        
        return json_encode([ 'result' => $data, 'services' => $getDeliveryOrderServicesInfo, 'parts' => $getDeliveryOrderPartsInfo ]);
    }

    /**
     * Deletes an existing DeliveryOrder model.
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
        $model = DeliveryOrder::findOne(Yii::$app->request->post('id'));
        $model->condition = 1;
        $model->action_by = Yii::$app->user->identity->id;
        $model->save();
        
        return json_encode(['status' => 'Success', 'message' => 'Your delivery order was successfully approved.']);
    }

    public function actionCancelColumn()
    {
        $model = DeliveryOrder::findOne(Yii::$app->request->post('id'));
        $model->condition = 2;
        $model->action_by = Yii::$app->user->identity->id;
        $model->save();
        
        return json_encode(['status' => 'Success', 'message' => 'Your delivery order was successfully approved.']);
    }

    public function actionCloseColumn()
    {
        $model = DeliveryOrder::findOne(Yii::$app->request->post('id'));
        $model->condition = 3;
        $model->action_by = Yii::$app->user->identity->id;
        $model->save();
        
        return json_encode(['status' => 'Success', 'message' => 'Your delivery order was successfully approved.']);
    }

    /**
     * Finds the DeliveryOrder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DeliveryOrder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DeliveryOrder::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    // ===== invoice ajax function ===== //

    public function actionGetPartsPriceAndQty()
    {
        $model = new DeliveryOrder();
        $partsInfo = $model->getPartsById(Yii::$app->request->get('parts_id'));
        
        if(Yii::$app->request->get('parts_id') > 0) {
            return json_encode(['status' => 'success', 'result' => $partsInfo]);
        }else{
            return json_encode(['status' => 'error']);
        }
    }

    public function actionInsertAutoPartsInList()
    {
        $model = new DeliveryOrder();
    
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
        $model = new DeliveryOrder();
        $servicesInfo = $model->getServicesById(Yii::$app->request->get('services_id'));
        
        if(Yii::$app->request->get('services_id') > 0) {
            return json_encode(['status' => 'success', 'result' => $servicesInfo]);
        }else{
            return json_encode(['status' => 'error']);
        }
    }

    public function actionInsertServicesInList()
    {
        $model = new DeliveryOrder();
    
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
        $model = new DeliveryOrder();
    
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
        $model = new DeliveryOrder();
    
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
        $data['address'] = $customerInfo['address'];
        $data['shipping_address'] = $customerInfo['shipping_address'];
        $data['email'] = $customerInfo['email'];
        $data['phone_number'] = $customerInfo['phone_number'];
        $data['mobile_number'] = $customerInfo['mobile_number'];
        $data['fax_number'] = $customerInfo['fax_number'];

        return json_encode([ 'status' => 'Success', 'result' => $data ]);
    }

    // ===== create delivery order from customer created ===== //

    public function actionCreateDeliveryOrder($id)
    {
        $customerInfo = Customer::findOne($id);
        $model = new DeliveryOrder();
        $customerModel = new Customer();

        // Last ID and code for delivery order code // 
        $deliveryorderId = $model->getDeliveryOrderId();
        $yrNow = date('Y');
        $monthNow = date('m');
        $deliveryorderCode = 'QUO' . $yrNow . $monthNow . sprintf('%003d', $deliveryorderId); 
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

        return $this->render('_delivery-order-form', [
                        'model' => $model,
                        'deliveryorderCode' => $deliveryorderCode,
                        'dateNow' => $dateNow,
                        'dataUser' => $dataUser,
                        'partsResult' => $partsResult,
                        'servicesResult' => $servicesResult,
                        'customerModel' => $customerModel,
                        'customerInfo' => $customerInfo,
                        'dataCustomer' => $dataCustomer,
                        
                    ]);
    }
    
}
