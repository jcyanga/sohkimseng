<?php

namespace backend\controllers;

use Yii;
use common\models\Supplier;
use common\models\SearchSupplier;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use Dompdf\Dompdf;

/**
 * SupplierController implements the CRUD actions for Supplier model.
 */
class SupplierController extends Controller
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
     * Lists all Supplier models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchSupplier();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new Supplier();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Supplier model.
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
     * Creates a new Supplier model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Supplier();

        if ( Yii::$app->request->post() ) {
            
            $model->supplier_code = strtolower(Yii::$app->request->post('supplierCode'));
            $model->name = strtolower(Yii::$app->request->post('name'));
            $model->location = strtolower(Yii::$app->request->post('location'));
            $model->address = strtolower(Yii::$app->request->post('address'));
            $model->contact_number = Yii::$app->request->post('contactNumber');
            $model->remarks = strtolower(Yii::$app->request->post('remarks'));
            $model->status = 1;
            $model->created_at = date('Y-m-d H:i:s');
            $model->created_by = Yii::$app->user->identity->id;

            if($model->validate()) {
               $model->save();
               return json_encode(['message' => 'Your record was successfully added in the database.', 'status' => 'Success']);

            } else {
               return json_encode(['message' => $model->errors, 'status' => 'Error']);
            
            }

        } else {
            
            // return $this->render('create', [
            //     'model' => $model,
            // ]);
        
        }
    }

    /**
     * Updates an existing Supplier model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $model = $this->findModel(Yii::$app->request->post('id'));

        if ( Yii::$app->request->post() ) {
            
            $model->supplier_code = strtolower(Yii::$app->request->post('supplierCode'));
            $model->name = strtolower(Yii::$app->request->post('name'));
            $model->location = strtolower(Yii::$app->request->post('location'));
            $model->address = strtolower(Yii::$app->request->post('address'));
            $model->contact_number = Yii::$app->request->post('contactNumber');
            $model->remarks = strtolower(Yii::$app->request->post('remarks'));
            $model->status = 1;
            $model->updated_at = date('Y-m-d H:i:s');
            $model->updated_by = Yii::$app->user->identity->id;

            if($model->validate()) {
               $model->save();
               return json_encode(['message' => 'Your record was successfully updated in the database.', 'status' => 'Success']);

            } else {
               return json_encode(['message' => $model->errors, 'status' => 'Error']);
            
            }

        } else {
            // return $this->render('update', [
            //     'model' => $model,
            // ]);
        
        }
    }

    public function actionGetData()
    {  
        $getSuppliers = Supplier::findOne(Yii::$app->request->get('id'));

        $data = array();
        $data['id'] = $getSuppliers->id;
        $data['supplier_code'] = $getSuppliers->supplier_code;
        $data['name'] = $getSuppliers->name;
        $data['location'] = $getSuppliers->location;
        $data['address'] = $getSuppliers->address;
        $data['contact_number'] = $getSuppliers->contact_number;
        $data['remarks'] = $getSuppliers->remarks;
        $data['status'] = $getSuppliers->status;

        return json_encode(['status' => 'Success', 'result' => $data ]);
    }

    /**
     * Deletes an existing Supplier model.
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
     * Finds the Supplier model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Supplier the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Supplier::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionExportPdf() 
    {
        $result = Supplier::find()->where(['status' => 1])->all();
        $content = $this->renderPartial('_pdf', ['result' => $result]);

        $dompdf = new Dompdf();

        $dompdf->loadHtml($content);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream('SupplierList-' . date('m-d-Y'));
    }
}
