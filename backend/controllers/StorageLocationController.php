<?php

namespace backend\controllers;

use Yii;
use common\models\StorageLocations;
use common\models\SearchStorageLocations;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use Dompdf\Dompdf;

/**
 * StorageLocationController implements the CRUD actions for StorageLocations model.
 */
class StorageLocationController extends Controller
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
     * Lists all StorageLocations models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchStorageLocations();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new StorageLocations();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    /**
     * Displays a single StorageLocations model.
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
     * Creates a new StorageLocations model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new StorageLocations();

        if ( Yii::$app->request->post() ) {
            
            $model->rack = strtolower(Yii::$app->request->post('rack'));
            $model->bay = strtolower(Yii::$app->request->post('bay'));
            $model->level = strtolower(Yii::$app->request->post('level'));
            $model->position = strtolower(Yii::$app->request->post('position'));
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
     * Updates an existing StorageLocations model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $model = $this->findModel(Yii::$app->request->post('id'));

        if ( Yii::$app->request->post() ) {
            
            $model->rack = strtolower(Yii::$app->request->post('rack'));
            $model->bay = strtolower(Yii::$app->request->post('bay'));
            $model->level = strtolower(Yii::$app->request->post('level'));
            $model->position = strtolower(Yii::$app->request->post('position'));
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
        $getStorageLocations = StorageLocations::findOne(Yii::$app->request->get('id'));

        $data = array();
        $data['id'] = $getStorageLocations->id;
        $data['rack'] = $getStorageLocations->rack;
        $data['bay'] = $getStorageLocations->bay;
        $data['level'] = $getStorageLocations->level;
        $data['position'] = $getStorageLocations->position;
        $data['status'] = $getStorageLocations->status;

        return json_encode(['status' => 'Success', 'result' => $data ]);
    }

    /**
     * Deletes an existing StorageLocations model.
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
     * Finds the StorageLocations model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StorageLocations the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StorageLocations::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionExportPdf() 
    {
        $result = StorageLocations::find()->where(['status' => 1])->all();
        $content = $this->renderPartial('_pdf', ['result' => $result]);

        $dompdf = new Dompdf();

        $dompdf->loadHtml($content);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream('StorageLocationList-' . date('m-d-Y'));
    }
}
