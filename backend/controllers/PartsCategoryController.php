<?php

namespace backend\controllers;

use Yii;
use common\models\PartsCategory;
use common\models\SearchPartsCategory;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use Dompdf\Dompdf;

/**
 * PartsCategoryController implements the CRUD actions for PartsCategory model.
 */
class PartsCategoryController extends Controller
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
     * Lists all PartsCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchPartsCategory();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new PartsCategory();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    /**
     * Displays a single PartsCategory model.
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
     * Creates a new PartsCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PartsCategory();

        if ( Yii::$app->request->post() ) {
            
            $model->name = Yii::$app->request->post('name');
            $model->description = Yii::$app->request->post('description');
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
     * Updates an existing PartsCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $model = $this->findModel(Yii::$app->request->post('id'));

        if ( Yii::$app->request->post() ) {
            
            $model->name = Yii::$app->request->post('name');
            $model->description = Yii::$app->request->post('description');
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
        $getPartsCategories = PartsCategory::findOne(Yii::$app->request->get('id'));

        $data = array();
        $data['id'] = $getPartsCategories->id;
        $data['name'] = $getPartsCategories->name;
        $data['description'] = $getPartsCategories->description;
        $data['status'] = $getPartsCategories->status;

        return json_encode(['status' => 'Success', 'result' => $data ]);
    }

    /**
     * Deletes an existing PartsCategory model.
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
     * Finds the PartsCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PartsCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PartsCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionExportPdf() 
    {
        $result = PartsCategory::find()->all();
        $content = $this->renderPartial('_pdf', ['result' => $result]);

        $dompdf = new Dompdf();

        $dompdf->loadHtml($content);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream('AutoPartsCategoryList-' . date('m-d-Y'));
    }
}
