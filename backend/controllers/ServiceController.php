<?php

namespace backend\controllers;

use Yii;
use common\models\Service;
use common\models\SearchService;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\ActiveRecord;

use common\models\ServiceCategory;

use Dompdf\Dompdf;

/**
 * ServiceController implements the CRUD actions for Service model.
 */
class ServiceController extends Controller
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
     * Lists all Service models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchService();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new Service();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Service model.
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
     * Creates a new Service model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Service();

        if ( Yii::$app->request->post() ) {
            
            $model->service_category_id = Yii::$app->request->post('serviceCategory');
            $model->service_name = strtolower(Yii::$app->request->post('serviceName'));
            $model->description = strtolower(Yii::$app->request->post('description'));
            $model->price = Yii::$app->request->post('price');
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
     * Updates an existing Service model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $model = $this->findModel(Yii::$app->request->post('id'));

        if ( Yii::$app->request->post() ) {
            
            $model->service_category_id = Yii::$app->request->post('serviceCategory');
            $model->service_name = strtolower(Yii::$app->request->post('serviceName'));
            $model->description = strtolower(Yii::$app->request->post('description'));
            $model->price = Yii::$app->request->post('price');
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
        $getServices = Service::findOne(Yii::$app->request->get('id'));

        $data = array();
        $data['id'] = $getServices->id;
        $data['service_category_id'] = $getServices->service_category_id;
        $data['service_name'] = $getServices->service_name;
        $data['description'] = $getServices->description;
        $data['price'] = $getServices->price;
        $data['status'] = $getServices->status;

        return json_encode(['status' => 'Success', 'result' => $data ]);
    }

    public function actionGetDataForView()
    {  
        $model = new Service();
        
        $getServices = $model->getServiceById(Yii::$app->request->get('id')); 

        $data = array();
        $data['id'] = $getServices['id'];
        $data['service_name'] = $getServices['service_name'];
        $data['description'] = $getServices['description'];
        $data['price'] = $getServices['price'];
        $data['status'] = $getServices['status'];
        $data['service_category_name'] = $getServices['name'];

        return json_encode(['status' => 'Success', 'result' => $data ]);
    }
    /**
     * Deletes an existing Service model.
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
     * Finds the Service model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Service the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Service::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionExportPdf()
    {
        $model = new Service();
        
        $result = $model->getServiceList(); 
        $content = $this->renderPartial('_pdf', ['result' => $result]);

        $dompdf = new Dompdf();

        $dompdf->loadHtml($content);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream('ServiceList-' . date('m-d-Y'));
    }
}
