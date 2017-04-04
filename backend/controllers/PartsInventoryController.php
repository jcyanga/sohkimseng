<?php

namespace backend\controllers;

use Yii;
use common\models\PartsInventory;
use common\models\SearchPartsInventory;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use common\models\Parts;
use common\models\Supplier;

use Dompdf\Dompdf;

/**
 * PartsInventoryController implements the CRUD actions for PartsInventory model.
 */
class PartsInventoryController extends Controller
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
     * Lists all PartsInventory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchPartsInventory();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new PartsInventory();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    /**
     * Displays a single PartsInventory model.
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
     * Creates a new PartsInventory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $parts = Yii::$app->request->post('parts');
        $supplier = Yii::$app->request->post('supplier');
        $quantity = Yii::$app->request->post('quantity');
        $price = Yii::$app->request->post('price');

        foreach( $parts as $key => $pValue ) {
            $model = new PartsInventory();
            $model->parts_id = $parts[$key]['value'];
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
     * Updates an existing PartsInventory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $model = $this->findModel(Yii::$app->request->post('id'));

        $model->parts_id = Yii::$app->request->post('parts');
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
        $getParts = PartsInventory::findOne(Yii::$app->request->get('id'));

        $data = array();
        $data['id'] = $getParts->id;
        $data['parts_id'] = $getParts->parts_id;
        $data['supplier_id'] = $getParts->supplier_id;
        $data['quantity'] = $getParts->quantity;
        $data['price'] = $getParts->price;
        $data['status'] = $getParts->status;

        return json_encode(['status' => 'Success', 'result' => $data ]);
    }

    /**
     * Deletes an existing PartsInventory model.
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
     * Finds the PartsInventory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PartsInventory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PartsInventory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionInsertItemInList()
    {
        $this->layout = false;

        $partsId = Yii::$app->request->post('parts');
        $supplierId = Yii::$app->request->post('supplier');

        $partsModel = Parts::findOne($partsId);
        $supplierModel = Supplier::findOne($supplierId);

        $parts = false;
        $supplier = false;
        $quantity = false;
        $price = false;

        return $this->render('insert-item-in-list', [
                           'ctr' => Yii::$app->request->post('ctr'),
                           'parts_id' => $partsModel->id,
                           'parts' => $partsModel->parts_name,
                           'supplier_id' => $supplierModel->id,
                           'supplier' => $supplierModel->name,
                           'quantity' => Yii::$app->request->post('quantity'),
                           'price' => Yii::$app->request->post('price'),
                        ]);

    }

    public function actionExportPdf()
    {
        $model = new PartsInventory();
        
        $result = $model->getPartsInventoryList(); 
        $content = $this->renderPartial('_pdf', ['result' => $result]);

        $dompdf = new Dompdf();

        $dompdf->loadHtml($content);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream('AutoPartsInventoryList-' . date('m-d-Y'));
    }
}
