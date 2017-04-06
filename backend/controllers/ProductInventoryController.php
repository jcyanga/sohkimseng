<?php

namespace backend\controllers;

use Yii;
use common\models\ProductInventory;
use common\models\SearchProductInventory;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use common\models\Product;
use common\models\Supplier;
use common\models\ProductCategory;

use Dompdf\Dompdf;

/**
 * ProductInventoryController implements the CRUD actions for ProductInventory model.
 */
class ProductInventoryController extends Controller
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
     * Lists all ProductInventory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchProductInventory();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new ProductInventory();
        $supplierModel = new Supplier();
        $prcModel = new ProductCategory();
        $productModel = new Product();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'supplierModel' => $supplierModel,
            'prcModel' => $prcModel,
            'productModel' => $productModel
        ]);
    }

    /**
     * Displays a single ProductInventory model.
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
     * Creates a new ProductInventory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $products = Yii::$app->request->post('products');
        $supplier = Yii::$app->request->post('supplier');
        $quantity = Yii::$app->request->post('quantity');
        $price = Yii::$app->request->post('price');

        foreach( $products as $key => $pValue ) {
            $model = new ProductInventory();
            $model->product_id = $products[$key]['value'];
            $model->supplier_id = $supplier[$key]['value'];
            $model->quantity = $quantity[$key]['value'];
            $model->price = $price[$key]['value'];
            $model->status = 1;
            $model->date_imported = date('Y-m-d');
            $model->created_at = date('Y-m-d H:i:s');
            $model->created_by = 1;
            $model->updated_at = date('Y-m-d H:i:s');
            $model->updated_by = 1;

            $model->save();
        }

        return json_encode(['status' => 'Success', 'message' => 'Your record was successfully added in the database.' ]);
    }

    /**
     * Updates an existing ProductInventory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $model = $this->findModel(Yii::$app->request->post('id'));

        $model->product_id = Yii::$app->request->post('product');
        $model->supplier_id = Yii::$app->request->post('supplier');
        $model->quantity = Yii::$app->request->post('quantity');
        $model->price = Yii::$app->request->post('price');
        $model->status = 1;
        $model->date_imported = date('Y-m-d');
        $model->created_at = date('Y-m-d H:i:s');
        $model->created_by = 1;
        $model->updated_at = date('Y-m-d H:i:s');
        $model->updated_by = 1;

        $model->save();
        
        return json_encode(['status' => 'Success', 'message' => 'Your record was successfully updated in the database.' ]);
    }

    public function actionGetData()
    {  
        $getProducts = ProductInventory::findOne(Yii::$app->request->get('id'));

        $data = array();
        $data['id'] = $getProducts->id;
        $data['product_id'] = $getProducts->product_id;
        $data['supplier_id'] = $getProducts->supplier_id;
        $data['quantity'] = $getProducts->quantity;
        $data['price'] = $getProducts->price;
        $data['status'] = $getProducts->status;

        return json_encode(['status' => 'Success', 'result' => $data ]);
    }

    /**
     * Deletes an existing ProductInventory model.
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
     * Finds the ProductInventory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductInventory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductInventory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionInsertItemInList()
    {
        $this->layout = false;

        $productId = Yii::$app->request->post('product');
        $supplierId = Yii::$app->request->post('supplier');

        $productModel = Product::findOne($productId);
        $supplierModel = Supplier::findOne($supplierId);

        $product = false;
        $supplier = false;
        $quantity = false;
        $price = false;

        return $this->render('insert-item-in-list', [
                           'ctr' => Yii::$app->request->post('ctr'),
                           'product_id' => $productModel->id,
                           'product' => $productModel->product_name,
                           'supplier_id' => $supplierModel->id,
                           'supplier' => $supplierModel->name,
                           'quantity' => Yii::$app->request->post('quantity'),
                           'price' => Yii::$app->request->post('price'),
                        ]);

    }

    public function actionExportPdf()
    {
        $model = new ProductInventory();
        
        $result = $model->getProductInventoryList(); 
        $content = $this->renderPartial('_pdf', ['result' => $result]);

        $dompdf = new Dompdf();

        $dompdf->loadHtml($content);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream('ProductInventoryList-' . date('m-d-Y'));
    }
}
