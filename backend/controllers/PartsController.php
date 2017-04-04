<?php

namespace backend\controllers;

use Yii;
use common\models\Parts;
use common\models\SearchParts;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use Dompdf\Dompdf;

/**
 * PartsController implements the CRUD actions for Parts model.
 */
class PartsController extends Controller
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
     * Lists all Parts models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchParts();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new Parts();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Parts model.
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
     * Creates a new Parts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Parts();

        if ( Yii::$app->request->post() ) {
            
            $model->parts_category_id = Yii::$app->request->post('partsCategory');
            $model->parts_code = Yii::$app->request->post('partsCode');
            $model->parts_name = Yii::$app->request->post('partsName');
            $model->description = Yii::$app->request->post('description');
            $model->unit_of_measure = Yii::$app->request->post('uom');
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
     * Updates an existing Parts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $model = $this->findModel(Yii::$app->request->post('id'));

        if ( Yii::$app->request->post() ) {
            
            $model->parts_category_id = Yii::$app->request->post('partsCategory');
            $model->parts_name = Yii::$app->request->post('partsName');
            $model->parts_code = Yii::$app->request->post('partsCode');
            $model->description = Yii::$app->request->post('description');
            $model->unit_of_measure = Yii::$app->request->post('uom');
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
        $getParts = Parts::findOne(Yii::$app->request->get('id'));

        $data = array();
        $data['id'] = $getParts->id;
        $data['parts_category_id'] = $getParts->parts_category_id;
        $data['parts_code'] = $getParts->parts_code;
        $data['parts_name'] = $getParts->parts_name;
        $data['description'] = $getParts->description;
        $data['unit_of_measure'] = $getParts->unit_of_measure;
        $data['status'] = $getParts->status;

        return json_encode(['status' => 'Success', 'result' => $data ]);
    }

    public function actionGetDataForView()
    {  
        $model = new Parts();
        
        $getParts = $model->getPartsById(Yii::$app->request->get('id')); 

        $data = array();
        $data['id'] = $getParts['id'];
        $data['parts_name'] = $getParts['parts_name'];
        $data['parts_code'] = $getParts['parts_code'];
        $data['description'] = $getParts['description'];
        $data['unit_of_measure'] = $getParts['unit_of_measure'];
        $data['status'] = $getParts['status'];
        $data['parts_category_name'] = $getParts['name'];

        return json_encode(['status' => 'Success', 'result' => $data ]);
    }

    /**
     * Deletes an existing Parts model.
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

    /**
     * Finds the Parts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Parts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Parts::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionExportPdf()
    {
        $model = new Parts();
        
        $result = $model->getPartsList(); 
        $content = $this->renderPartial('_pdf', ['result' => $result]);

        $dompdf = new Dompdf();

        $dompdf->loadHtml($content);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream('AutoPartsList-' . date('m-d-Y'));
    }
}
