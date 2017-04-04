<?php

namespace backend\controllers;

use Yii;
use common\models\Staff;
use common\models\SearchStaff;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use Dompdf\Dompdf;
/**
 * StaffController implements the CRUD actions for Staff model.
 */
class StaffController extends Controller
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
     * Lists all Staff models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchStaff();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new Staff();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Staff model.
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
     * Creates a new Staff model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Staff();

        if ( Yii::$app->request->post() ) {
            
            $model->staff_group_id = Yii::$app->request->post('staffGroup');
            $model->designated_position_id = Yii::$app->request->post('designatedPosition');
            $model->fullname = Yii::$app->request->post('fullname');
            $model->address = Yii::$app->request->post('address');
            $model->race_id = Yii::$app->request->post('race');
            $model->email = Yii::$app->request->post('email');
            $model->mobile_number = Yii::$app->request->post('mobileNumber');
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
     * Updates an existing Staff model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $model = $this->findModel(Yii::$app->request->post('id'));

        if ( Yii::$app->request->post() ) {
            
            $model->staff_group_id = Yii::$app->request->post('staffGroup');
            $model->designated_position_id = Yii::$app->request->post('designatedPosition');
            $model->fullname = Yii::$app->request->post('fullname');
            $model->address = Yii::$app->request->post('address');
            $model->race_id = Yii::$app->request->post('race');
            $model->email = Yii::$app->request->post('email');
            $model->mobile_number = Yii::$app->request->post('mobileNumber');
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
        $model = new Staff();
        $getStaffs = $model->getStaffs(Yii::$app->request->get('id'));

        $data = array();
        $data['id'] = $getStaffs['id'];
        $data['staff_group_id'] = $getStaffs['staff_group_id'];
        $data['designated_position_id'] = $getStaffs['designated_position_id'];
        $data['fullname'] = $getStaffs['fullname'];
        $data['address'] = $getStaffs['address'];
        $data['race'] = $getStaffs['race_id'];
        $data['name'] = $getStaffs['name'];
        $data['email'] = $getStaffs['email'];
        $data['mobile_number'] = $getStaffs['mobile_number'];
        $data['status'] = $getStaffs['status'];

        return json_encode(['status' => 'Success', 'result' => $data ]);
    }

    public function actionGetDataForView()
    {  
        $model = new Staff();
        
        $getStaffs = $model->getStaffById(Yii::$app->request->get('id')); 

        $data = array();
        $data['id'] = $getStaffs['id'];
        $data['fullname'] = $getStaffs['fullname'];
        $data['address'] = $getStaffs['address'];
        $data['race'] = $getStaffs['race_id'];
        $data['race_name'] = $getStaffs['raceName'];
        $data['email'] = $getStaffs['email'];
        $data['mobile_number'] = $getStaffs['mobile_number'];
        $data['status'] = $getStaffs['status'];
        $data['staff_group_name'] = $getStaffs['name'];
        $data['designated_position_name'] = $getStaffs['positionName'];

        return json_encode(['status' => 'Success', 'result' => $data ]);
    }

    /**
     * Deletes an existing Staff model.
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
     * Finds the Staff model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Staff the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Staff::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionExportPdf() 
    {
        $model = new Staff();
        
        $result = $model->getStaffList(Yii::$app->request->get('id')); 
        $content = $this->renderPartial('_pdf', ['result' => $result]);

        $dompdf = new Dompdf();

        $dompdf->loadHtml($content);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream('StaffList-' . date('m-d-Y'));
    }
}
