<?php

namespace backend\controllers;

use Yii;
use common\models\Customer;
use common\models\SearchCustomer;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Dompdf\Dompdf;
use common\models\CustomerContactpersonAddress;

/**
 * CustomerController implements the CRUD actions for Customer model.
 */
class CustomerController extends Controller
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
     * Lists all Customer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchCustomer();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new Customer();

        $getLastId = $model->getLastId();
        $yearNow = date('Y');
        $customerCode = 'CUSTOMER' . $yearNow . sprintf('%005d', $getLastId);

        $getLastCompanyInfoId = $model->getLastCompanyInformationId();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'customerCode' => $customerCode,
            'getLastCompanyInfoId' => $getLastCompanyInfoId
        ]);
    }

    /**
     * Displays a single Customer model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
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

               return json_encode(['message' => 'Your record was successfully added in the database.', 'status' => 'Success']);

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
            $model->customer_code = strtolower(Yii::$app->request->post('customerCode'));
            $model->fullname = strtolower(Yii::$app->request->post('fullname'));
            $model->location = strtolower(Yii::$app->request->post('location'));
            $model->nric = strtolower(Yii::$app->request->post('customerNric'));
            $model->address = strtolower(Yii::$app->request->post('customerAddress'));
            $model->shipping_address = strtolower(Yii::$app->request->post('customerShippingAddress'));
            $model->race_id = Yii::$app->request->post('customerRace');
            $model->email = strtolower(Yii::$app->request->post('customerEmail'));
            $model->phone_number = Yii::$app->request->post('customerPhoneNumber');
            $model->mobile_number = Yii::$app->request->post('customerOficeNumber');
            $model->fax_number = Yii::$app->request->post('customerFaxNumber');
            $model->remarks = strtolower(Yii::$app->request->post('customerRemarks'));
            $model->status = 1;
            $model->created_at = date('Y-m-d H:i:s');
            $model->created_by = Yii::$app->user->identity->id;

            if($model->validate()) {
               $model->save();
               return json_encode(['message' => 'Your record was successfully added in the database.', 'status' => 'Success']);

            } else {
               return json_encode(['message' => $model->errors, 'status' => 'Error']);
            
            }

        }
    }

    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdateCompany()
    {
        $model = $this->findModel(Yii::$app->request->post('id'));

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
            $model->updated_at = date('Y-m-d H:i:s');
            $model->updated_by = Yii::$app->user->identity->id;

            if($model->validate()) {
               $model->save();

                $customerId = Yii::$app->request->post('id');

                CustomerContactpersonAddress::deleteAll(['customer_id' => $customerId]);

               if( !empty(Yii::$app->request->post('selectedCompanyContactPerson')) || !empty(Yii::$app->request->post('selectedCompanyAddress'))) {

                       $selectedContactPerson = Yii::$app->request->post('selectedCompanyContactPerson');
                       $selectedAddress = Yii::$app->request->post('selectedCompanyAddress');

                       foreach($selectedContactPerson as $scKey => $scValue){
                            
                            $scompanyInfo = new CustomerContactpersonAddress();
                            
                            $scompanyInfo->customer_id = $customerId;
                            $scompanyInfo->address = $selectedAddress[$scKey]['value'];
                            $scompanyInfo->contact_person = $selectedContactPerson[$scKey]['value'];
                            $scompanyInfo->status = 1;
                            $scompanyInfo->created_at = date('Y-m-d H:i:s');
                            $scompanyInfo->created_by = Yii::$app->user->identity->id;
                            $scompanyInfo->save();

                       }

               }

               if( !empty(Yii::$app->request->post('companyAddress')) || !empty(Yii::$app->request->post('companyContactPerson'))) {

                       $contactPerson = Yii::$app->request->post('companyContactPerson');
                       $companyAddress = Yii::$app->request->post('companyAddress');

                       foreach($contactPerson as $cKey => $cValue){
                            
                            $companyInfo = new CustomerContactpersonAddress();
                            
                            $companyInfo->customer_id = $customerId;
                            $companyInfo->address = $companyAddress[$cKey]['value'];
                            $companyInfo->contact_person = $contactPerson[$cKey]['value'];
                            $companyInfo->status = 1;
                            $companyInfo->created_at = date('Y-m-d H:i:s');
                            $companyInfo->created_by = Yii::$app->user->identity->id;
                            $companyInfo->save();

                       }

               }
               

               return json_encode(['message' => 'Your record was successfully updated in the database.', 'status' => 'Success']);

            } else {
               return json_encode(['message' => $model->errors, 'status' => 'Error']);
            
            }

        }
    }

    public function actionUpdateCustomer()
    {
        $model = $this->findModel(Yii::$app->request->post('id'));

        if ( Yii::$app->request->post() ) {
            
            $model->type = 2;
            $model->customer_code = strtolower(Yii::$app->request->post('customerCode'));
            $model->fullname = strtolower(Yii::$app->request->post('fullname'));
            $model->location = strtolower(Yii::$app->request->post('location'));
            $model->nric = strtolower(Yii::$app->request->post('customerNric'));
            $model->address = strtolower(Yii::$app->request->post('customerAddress'));
            $model->shipping_address = strtolower(Yii::$app->request->post('customerShippingAddress'));
            $model->race_id = Yii::$app->request->post('customerRace');
            $model->email = strtolower(Yii::$app->request->post('customerEmail'));
            $model->phone_number = Yii::$app->request->post('customerPhoneNumber');
            $model->mobile_number = Yii::$app->request->post('customerOficeNumber');
            $model->fax_number = Yii::$app->request->post('customerFaxNumber');
            $model->remarks = strtolower(Yii::$app->request->post('customerRemarks'));
            $model->status = 1;
            $model->updated_at = date('Y-m-d H:i:s');
            $model->updated_by = Yii::$app->user->identity->id;

            if($model->validate()) {
               $model->save();
               return json_encode(['message' => 'Your record was successfully updated in the database.', 'status' => 'Success']);

            } else {
               return json_encode(['message' => $model->errors, 'status' => 'Error']);
            
            }

        }
    }

    public function actionGetData()
    {  
        $model = new Customer();
        $getCustomers = Customer::find()->where(['id' => Yii::$app->request->get('id')])->one();
        $getCustomerCompanyInfo = $model->getCompanyContactpersonAddress(Yii::$app->request->get('id'));

        $data = array();
        $data['id'] = $getCustomers['id'];
        $data['type'] = $getCustomers['type'];
        $data['customer_code'] = $getCustomers['customer_code'];
        $data['company_name'] = $getCustomers['company_name'];
        $data['location'] = $getCustomers['location'];
        $data['uen_no'] = $getCustomers['uen_no'];
        $data['fullname'] = $getCustomers['fullname'];
        $data['nric'] = $getCustomers['nric'];
        $data['address'] = $getCustomers['address'];
        $data['shipping_address'] = $getCustomers['shipping_address'];
        $data['race_id'] = $getCustomers['race_id'];
        $data['email'] = $getCustomers['email'];
        $data['phone_number'] = $getCustomers['phone_number'];
        $data['mobile_number'] = $getCustomers['mobile_number'];
        $data['fax_number'] = $getCustomers['fax_number'];
        $data['remarks'] = $getCustomers['remarks'];
        $data['status'] = $getCustomers['status'];

        return json_encode(['status' => 'Success', 'result' => $data, 'companyInformation' => $getCustomerCompanyInfo ]);
    }

    /**
     * Deletes an existing Customer model.
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

    /**
     * Finds the Customer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionExportPdf() 
    {
        $result = Customer::find()->all();
        $content = $this->renderPartial('_pdf', ['result' => $result]);

        $dompdf = new Dompdf();

        $dompdf->loadHtml($content);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream('CustomerList-' . date('m-d-Y'));
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

    public function actionEditCompanyContactpersonAddress()
    {
        $contact_person = Yii::$app->request->post('companyContactPerson');
        $address = Yii::$app->request->post('companyAddress');
        $n = Yii::$app->request->post('n');

        $this->layout = false;

        return $this->render('_edit-company-contactperson-address', [
                'contact_person' => $contact_person,
                'address' => $address,
                'ctr' => $n,
            ]);
    }

}
