<?php

namespace backend\controllers;

use Yii;
use common\models\Parts;
use common\models\SearchParts;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use common\models\PartsInventory;

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

            $model->storage_location_id = Yii::$app->request->post('storageLocation');
            $model->supplier_id = Yii::$app->request->post('supplier');
            $model->parts_code = strtolower(Yii::$app->request->post('partsCode'));
            $model->parts_category_id = Yii::$app->request->post('partsCategory');
            $model->parts_name = strtolower(Yii::$app->request->post('partsName'));
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

                $partsinventoryModel = new PartsInventory();

                $partsinventoryModel->parts_id = $model->id;
                $partsinventoryModel->old_quantity = Yii::$app->request->post('quantity');
                $partsinventoryModel->new_quantity = Yii::$app->request->post('quantity');
                $partsinventoryModel->type = 1;
                $partsinventoryModel->datetime_imported = date('Y-m-d H:i:s');
                $partsinventoryModel->status = 1;
                $partsinventoryModel->created_at = date('Y-m-d H:i:s');
                $partsinventoryModel->created_by = Yii::$app->user->identity->id;
                $partsinventoryModel->updated_at = date('Y-m-d H:i:s');
                $partsinventoryModel->updated_by = Yii::$app->user->identity->id;
                $partsinventoryModel->save();

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
            
            $model->storage_location_id = Yii::$app->request->post('storageLocation');
            $model->supplier_id = Yii::$app->request->post('supplier');
            $model->parts_code = strtolower(Yii::$app->request->post('partsCode'));
            $model->parts_category_id = Yii::$app->request->post('partsCategory');
            $model->parts_name = strtolower(Yii::$app->request->post('partsName'));
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
        $getParts = Parts::findOne(Yii::$app->request->get('id'));

        $data = array();
        $data['id'] = $getParts->id;
        $data['storage_location_id'] = $getParts->storage_location_id;
        $data['supplier_id'] = $getParts->supplier_id;
        $data['parts_code'] = $getParts->parts_code;
        $data['parts_category_id'] = $getParts->parts_category_id;
        $data['parts_name'] = $getParts->parts_name;
        $data['unit_of_measure'] = $getParts->unit_of_measure;
        $data['quantity'] = $getParts->quantity;
        $data['cost_price'] = $getParts->cost_price;
        $data['gst_price'] = $getParts->gst_price;
        $data['selling_price'] = $getParts->selling_price;
        $data['reorder_level'] = $getParts->reorder_level;
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
        $data['quantity'] = $getParts['quantity'];
        $data['cost_price'] = $getParts['cost_price'];
        $data['gst_price'] = $getParts['gst_price'];
        $data['selling_price'] = $getParts['selling_price'];
        $data['reorder_level'] = $getParts['reorder_level'];
        $data['unit_of_measure'] = $getParts['unit_of_measure'];
        $data['status'] = $getParts['status'];
        $data['parts_category_name'] = $getParts['name'];
        $data['supplier_name'] = $getParts['supplierName'];
        $data['storage_location_name'] = $getParts['storagelocationName'];

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
        $model = $this->findModel(Yii::$app->request->post('id'));
        $model->status = 0;
        $model->save();
        
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

    public function actionGetSelectedPartsinfo()
    {
        $getParts = Parts::find()->where(['id' => Yii::$app->request->get('partsId')])->andWhere(['status' => 1])->one(); 

        $data = array();
        $data['id'] = $getParts['id'];
        $data['parts_name'] = $getParts['parts_name'];
        $data['quantity'] = $getParts['quantity'];

        return json_encode(['status' => 'Success', 'result' => $data ]);
    }

    public function actionSaveUpdatedPartsQty()
    {
        foreach( Yii::$app->request->post('partsId') as $pkey => $pvalue ) {

            $partsInfo = Parts::find()->where(['id' => Yii::$app->request->post('partsId')[$pkey]['value'] ])->one();
            $partsInfo->quantity = Yii::$app->request->post('newQty')[$pkey]['value'];
            $partsInfo->save();
            
            $partsinventoryModel = new PartsInventory();
            $partsinventoryModel->parts_id = Yii::$app->request->post('partsId')[$pkey]['value'];
            $partsinventoryModel->old_quantity = Yii::$app->request->post('oldQty')[$pkey]['value'];
            $partsinventoryModel->new_quantity = Yii::$app->request->post('newQty')[$pkey]['value'];
            $partsinventoryModel->type = 3;
            $partsinventoryModel->datetime_imported = date('Y-m-d H:i:s');
            $partsinventoryModel->status = 1;
            $partsinventoryModel->created_at = date('Y-m-d H:i:s');
            $partsinventoryModel->created_by = Yii::$app->user->identity->id;
            $partsinventoryModel->updated_at = date('Y-m-d H:i:s');
            $partsinventoryModel->updated_by = Yii::$app->user->identity->id;
            $partsinventoryModel->save();
        
        }

        return json_encode(['status' => 'Success', 'message' => 'Your record was successfully updated in the database.']);   
    }

    public function actionUpdateStockQuantity()
    {
        $partsinventoryModel = new PartsInventory();
        $partsinventoryModel->parts_id = Yii::$app->request->post('partsId');
        $partsinventoryModel->old_quantity = Yii::$app->request->post('partsOldQty');
        $partsinventoryModel->new_quantity = Yii::$app->request->post('partsNewQty');
        $partsinventoryModel->type = 3;
        $partsinventoryModel->datetime_imported = date('Y-m-d H:i:s');
        $partsinventoryModel->status = 1;
        $partsinventoryModel->created_at = date('Y-m-d H:i:s');
        $partsinventoryModel->created_by = Yii::$app->user->identity->id;
        $partsinventoryModel->updated_at = date('Y-m-d H:i:s');
        $partsinventoryModel->updated_by = Yii::$app->user->identity->id;
        $partsinventoryModel->save();

        $partsInfo = Parts::find()->where(['id' => Yii::$app->request->post('partsId') ])->one();
        $partsInfo->quantity = Yii::$app->request->post('partsNewQty');
        $partsInfo->save();

        return json_encode(['status' => 'Success', 'message' => 'Your record was successfully updated in the database.']);  
    }

}
