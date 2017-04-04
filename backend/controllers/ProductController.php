<?php

namespace backend\controllers;

use Yii;
use common\models\Product;
use common\models\SearchProduct;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use Dompdf\Dompdf;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
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
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchProduct();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new Product();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Product model.
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
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();

        if ( Yii::$app->request->post() ) {
            
            $model->product_code = Yii::$app->request->post('productCode');
            $model->product_category_id = Yii::$app->request->post('productCategory');
            $model->product_name = Yii::$app->request->post('productName');
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
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $model = $this->findModel(Yii::$app->request->post('id'));

        if ( Yii::$app->request->post() ) {
            
            $model->product_code = Yii::$app->request->post('productCode');
            $model->product_category_id = Yii::$app->request->post('productCategory');
            $model->product_name = Yii::$app->request->post('productName');
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
        $getProducts = Product::findOne(Yii::$app->request->get('id'));

        $data = array();
        $data['id'] = $getProducts->id;
        $data['product_code'] = $getProducts->product_code;
        $data['product_category_id'] = $getProducts->product_category_id;
        $data['product_name'] = $getProducts->product_name;
        $data['description'] = $getProducts->description;
        $data['unit_of_measure'] = $getProducts->unit_of_measure;
        $data['status'] = $getProducts->status;

        return json_encode(['status' => 'Success', 'result' => $data ]);
    }

    public function actionGetDataForView()
    {  
        $model = new Product();
        
        $getProducts = $model->getProductById(Yii::$app->request->get('id')); 

        $data = array();
        $data['id'] = $getProducts['id'];
        $data['product_code'] = $getProducts['product_code'];
        $data['product_name'] = $getProducts['product_name'];
        $data['description'] = $getProducts['description'];
        $data['unit_of_measure'] = $getProducts['unit_of_measure'];
        $data['status'] = $getProducts['status'];
        $data['product_category_name'] = $getProducts['name'];

        return json_encode(['status' => 'Success', 'result' => $data ]);
    }

    /**
     * Deletes an existing Product model.
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
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionExportPdf()
    {
        $model = new Product();
        
        $result = $model->getProductList(); 
        $content = $this->renderPartial('_pdf', ['result' => $result]);

        $dompdf = new Dompdf();

        $dompdf->loadHtml($content);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream('ProductList-' . date('m-d-Y'));
    }
}
