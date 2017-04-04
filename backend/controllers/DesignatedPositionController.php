<?php

namespace backend\controllers;

use Yii;
use common\models\DesignatedPosition;
use common\models\SearchDesignatedPosition;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use Dompdf\Dompdf;
/**
 * DesignatedPositionController implements the CRUD actions for DesignatedPosition model.
 */
class DesignatedPositionController extends Controller
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
     * Lists all DesignatedPosition models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchDesignatedPosition();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new DesignatedPosition();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    /**
     * Displays a single DesignatedPosition model.
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
     * Creates a new DesignatedPosition model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DesignatedPosition();

         if ( Yii::$app->request->post() ) {
            
            $model->name = strtolower(Yii::$app->request->post('name'));
            $model->description = strtolower(Yii::$app->request->post('description'));
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

    public function actionGetData()
    {  
        $getDesignatedPositions = DesignatedPosition::findOne(Yii::$app->request->get('id'));

        $data = array();
        $data['id'] = $getDesignatedPositions->id;
        $data['name'] = $getDesignatedPositions->name;
        $data['description'] = $getDesignatedPositions->description;
        $data['status'] = $getDesignatedPositions->status;

        return json_encode(['status' => 'Success', 'result' => $data ]);
    }

    /**
     * Updates an existing DesignatedPosition model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $model = $this->findModel(Yii::$app->request->post('id'));

        if ( Yii::$app->request->post() ) {
            
            $model->name = strtolower(Yii::$app->request->post('name'));
            $model->description = strtolower(Yii::$app->request->post('description'));
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

    /**
     * Deletes an existing DesignatedPosition model.
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
     * Finds the DesignatedPosition model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DesignatedPosition the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DesignatedPosition::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionExportPdf() 
    {
        $result = DesignatedPosition::find()->where(['status' => 1])->all();
        $content = $this->renderPartial('_pdf', ['result' => $result]);

        $dompdf = new Dompdf();

        $dompdf->loadHtml($content);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream('DesignatedPositionList-' . date('m-d-Y'));
    }
}
