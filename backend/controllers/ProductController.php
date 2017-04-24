<?php

namespace backend\controllers;

use Yii;
use common\models\Product;
use common\models\SearchProduct;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\ProductInventory;

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
            
            $model->storage_location_id = Yii::$app->request->post('storageLocation');
            $model->supplier_id = Yii::$app->request->post('supplier');
            $model->product_code = strtolower(Yii::$app->request->post('productCode'));
            $model->product_category_id = Yii::$app->request->post('productCategory');
            $model->product_name = strtolower(Yii::$app->request->post('productName'));
            $model->unit_of_measure = strtolower(Yii::$app->request->post('uom'));
            $model->quantity = Yii::$app->request->post('quantity');
            $model->cost_price = Yii::$app->request->post('costPrice');
            $model->gst_price = Yii::$app->request->post('gstPrice');
            $model->selling_price = Yii::$app->request->post('sellingPrice');
            $model->reorder_level = Yii::$app->request->post('reorderLevel'); 
            $model->status = 1;
            $model->created_at = date('Y-m-d H:i:s');
            $model->created_by = Yii::$app->user->identity->id;

            if($model->validate()) {
               $model->save();

                $productinventoryModel = new ProductInventory();

                $productinventoryModel->product_id = $model->id;
                $productinventoryModel->old_quantity = Yii::$app->request->post('quantity');
                $productinventoryModel->new_quantity = Yii::$app->request->post('quantity');
                $productinventoryModel->type = 1;
                $productinventoryModel->datetime_imported = date('Y-m-d H:i:s');
                $productinventoryModel->status = 1;
                $productinventoryModel->created_at = date('Y-m-d H:i:s');
                $productinventoryModel->created_by = Yii::$app->user->identity->id;
                $productinventoryModel->updated_at = date('Y-m-d H:i:s');
                $productinventoryModel->updated_by = Yii::$app->user->identity->id;
                $productinventoryModel->save();

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
            
            $model->storage_location_id = Yii::$app->request->post('storageLocation');
            $model->supplier_id = Yii::$app->request->post('supplier');
            $model->product_code = strtolower(Yii::$app->request->post('productCode'));
            $model->product_category_id = Yii::$app->request->post('productCategory');
            $model->product_name = strtolower(Yii::$app->request->post('productName'));
            $model->unit_of_measure = strtolower(Yii::$app->request->post('uom'));
            $model->quantity = Yii::$app->request->post('quantity');
            $model->cost_price = Yii::$app->request->post('costPrice');
            $model->gst_price = Yii::$app->request->post('gstPrice');
            $model->selling_price = Yii::$app->request->post('sellingPrice');
            $model->reorder_level = Yii::$app->request->post('reorderLevel'); 
            $model->status = 1;
            $model->created_at = date('Y-m-d H:i:s');
            $model->created_by = Yii::$app->user->identity->id;

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
        $data['storage_location_id'] = $getProducts->storage_location_id;
        $data['supplier_id'] = $getProducts->supplier_id;
        $data['product_code'] = $getProducts->product_code;
        $data['product_category_id'] = $getProducts->product_category_id;
        $data['product_name'] = $getProducts->product_name;
        $data['unit_of_measure'] = $getProducts->unit_of_measure;
        $data['quantity'] = $getProducts->quantity;
        $data['cost_price'] = $getProducts->cost_price;
        $data['gst_price'] = $getProducts->gst_price;
        $data['selling_price'] = $getProducts->selling_price;
        $data['reorder_level'] = $getProducts->reorder_level;
        $data['status'] = $getProducts->status;

        return json_encode(['status' => 'Success', 'result' => $data ]);
    }

    public function actionGetDataForView()
    {  
        $model = new Product();
        
        $getProducts = $model->getProductById(Yii::$app->request->get('id')); 

        $data = array();
        $data['id'] = $getProducts['id'];
        $data['product_name'] = $getProducts['product_name'];
        $data['product_code'] = $getProducts['product_code'];
        $data['quantity'] = $getProducts['quantity'];
        $data['cost_price'] = $getProducts['cost_price'];
        $data['gst_price'] = $getProducts['gst_price'];
        $data['selling_price'] = $getProducts['selling_price'];
        $data['reorder_level'] = $getProducts['reorder_level'];
        $data['unit_of_measure'] = $getProducts['unit_of_measure'];
        $data['status'] = $getProducts['status'];
        $data['product_category_name'] = $getProducts['name'];
        $data['supplier_name'] = $getProducts['supplierName'];
        $data['storage_location_name'] = $getProducts['storagelocationName'];

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
        $model = $this->findModel(Yii::$app->request->post('id'));
        $model->status = 0;
        $model->save();
        
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

    public function actionGetSelectedProductinfo()
    {
        $getProducts = Product::find()->where(['id' => Yii::$app->request->get('productId')])->andWhere(['status' => 1])->one(); 

        $data = array();
        $data['id'] = $getProducts['id'];
        $data['product_name'] = $getProducts['product_name'];
        $data['quantity'] = $getProducts['quantity'];

        return json_encode(['status' => 'Success', 'result' => $data ]);
    }

    public function actionSaveUpdatedProductQty()
    {
        foreach( Yii::$app->request->post('productId') as $pkey => $pvalue ) {

            $productInfo = Product::find()->where(['id' => Yii::$app->request->post('productId')[$pkey]['value'] ])->one();
            $productInfo->quantity = Yii::$app->request->post('newProductQty')[$pkey]['value'];
            $productInfo->save();
            
            $productinventoryModel = new ProductInventory();
            $productinventoryModel->product_id = Yii::$app->request->post('productId')[$pkey]['value'];
            $productinventoryModel->old_quantity = Yii::$app->request->post('oldProductQty')[$pkey]['value'];
            $productinventoryModel->new_quantity = Yii::$app->request->post('newProductQty')[$pkey]['value'];
            $productinventoryModel->type = 3;
            $productinventoryModel->datetime_imported = date('Y-m-d H:i:s');
            $productinventoryModel->status = 1;
            $productinventoryModel->created_at = date('Y-m-d H:i:s');
            $productinventoryModel->created_by = Yii::$app->user->identity->id;
            $productinventoryModel->updated_at = date('Y-m-d H:i:s');
            $productinventoryModel->updated_by = Yii::$app->user->identity->id;
            $productinventoryModel->save();
        
        }

        return json_encode(['status' => 'Success', 'message' => 'Your record was successfully updated in the database.']);   
    }

    public function actionUpdateStockQuantity()
    {
        $productinventoryModel = new ProductInventory();
        $productinventoryModel->product_id = Yii::$app->request->post('productId');
        $productinventoryModel->old_quantity = Yii::$app->request->post('productOldQty');
        $productinventoryModel->new_quantity = Yii::$app->request->post('productNewQty');
        $productinventoryModel->type = 3;
        $productinventoryModel->datetime_imported = date('Y-m-d H:i:s');
        $productinventoryModel->status = 1;
        $productinventoryModel->created_at = date('Y-m-d H:i:s');
        $productinventoryModel->created_by = Yii::$app->user->identity->id;
        $productinventoryModel->updated_at = date('Y-m-d H:i:s');
        $productinventoryModel->updated_by = Yii::$app->user->identity->id;
        $productinventoryModel->save();

        $productInfo = Product::find()->where(['id' => Yii::$app->request->post('productId') ])->one();
        $productInfo->quantity = Yii::$app->request->post('productNewQty');
        $productInfo->save();

        return json_encode(['status' => 'Success', 'message' => 'Your record was successfully updated in the database.']);  
    }

}
