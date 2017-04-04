<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use common\models\SearchUser;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Dompdf\Dompdf;
/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchUser();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new User();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ( Yii::$app->request->post() ) {
            
            $model->role_id = Yii::$app->request->post('role');
            $model->roles = 20;
            $model->fullname = strtolower(Yii::$app->request->post('fullname'));
            $model->email = strtolower(Yii::$app->request->post('email'));
            $model->username = strtolower(Yii::$app->request->post('username'));
            $model->password = strtolower(Yii::$app->request->post('password'));
            $model->image = 'user.png';
            $model->status = 1;
            $model->created_at = date('Y-m-d H:i:s');
            $model->created_by = Yii::$app->user->identity->id;
            $model->deleted = 0;

            if($model->validate()) {
                if ( !empty( $model->password ) ) {
                    $model->password_hash = Yii::$app->security->generatePasswordHash($model->password); 
                    $model->generateAuthKey();
                }

                if( $model->save() ) {
            
                   $auth = Yii::$app->authManager;
                   $userRoleId = $model->role_id;

                    if ( $userRoleId == 1) {
                        $userRole = $auth->getRole('developer');
                        $auth->assign($userRole, $model->id);
                    }
                    if ( $userRoleId == 2) {
                        $userRole = $auth->getRole('admin');
                        $auth->assign($userRole, $model->id);
                    }
                    if ( $userRoleId == 3) {
                        $userRole = $auth->getRole('sales');
                        $auth->assign($userRole, $model->id);
                    }
                    if ( $userRoleId == 4) {
                        $userRole = $auth->getRole('technician');
                        $auth->assign($userRole, $model->id);
                    }
                    if ( $userRoleId == 4) {
                        $userRole = $auth->getRole('technician');
                        $auth->assign($userRole, $model->id);
                    }

                    return json_encode(['message' => 'Your record was successfully added in the database.', 'status' => 'Success']);
                }

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
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $model = $this->findModel(Yii::$app->request->post('id'));

        if ( Yii::$app->request->post() ) {
            
            $model->role_id = Yii::$app->request->post('role');
            $model->roles = 20;
            $model->fullname = strtolower(Yii::$app->request->post('fullname'));
            $model->email = strtolower(Yii::$app->request->post('email'));
            $model->username = strtolower(Yii::$app->request->post('username'));
            $model->password = strtolower(Yii::$app->request->post('password'));
            $model->image = 'user.png';
            $model->status = 1;
            $model->updated_at = date('Y-m-d H:i:s');
            $model->updated_by = Yii::$app->user->identity->id;
            $model->deleted = 0;

            if ( !empty( $model->password ) ) {
                $model->password_hash = Yii::$app->security->generatePasswordHash($model->password); 
                $model->generateAuthKey();
            }

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
        $getUsers = User::findOne(Yii::$app->request->get('id'));

        $data = array();
        $data['id'] = $getUsers->id;
        $data['role_id'] = $getUsers->role_id;
        $data['fullname'] = $getUsers->fullname;
        $data['email'] = $getUsers->email;
        $data['username'] = $getUsers->username;
        $data['email'] = $getUsers->email;
        $data['password'] = $getUsers->password;
        $data['status'] = $getUsers->status;

        return json_encode(['status' => 'Success', 'result' => $data ]);
    }

    public function actionGetDataForView()
    {  
        $model = new User();
        
        $getUsers = $model->getUserById(Yii::$app->request->get('id')); 

        $data = array();
        $data['id'] = $getUsers['id'];
        $data['name'] = $getUsers['name'];
        $data['fullname'] = $getUsers['fullname'];
        $data['email'] = $getUsers['email'];
        $data['username'] = $getUsers['username'];
        $data['status'] = $getUsers['status'];

        return json_encode(['status' => 'Success', 'result' => $data ]);
    }

    /**
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionExportPdf() 
    {
        $model = new User();
        $result = $model->getUserList();

        $content = $this->renderPartial('_pdf', ['result' => $result]);

        $dompdf = new Dompdf();

        $dompdf->loadHtml($content);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream('UserList-' . date('m-d-Y'));
    }
}
