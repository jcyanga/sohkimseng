<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use common\models\Role;

$dataRole = ArrayHelper::map(Role::find()->where(['status' => 1])->all(),'id', 'name');

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchUser */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Maintenance';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-index divContainer">

<div class="row containerHeadWrapper">
    
    <div class="col-md-12 col-sm-12 col-xs-12">
        
        <div>
            <h4 class="divHeaderLabel"><i class="fa fa-user"></i> <?= Html::encode($this->title) ?></h4>
        </div>
        <hr/>

    <?php  echo $this->render('_search', [
                            'model' => $searchModel ]); 
                        ?>    

    </div>

</div>
<br/>

<div class="row containerContentWrapper">
<?php
$gridColumns = [
    [
        'class' => 'yii\grid\SerialColumn',
        'options' => ['style' => 'color: #444']
    ],
        [
            'attribute' => 'role_id',
            'value' => 'role.name',
            'header' => 'User Role',     
            'options' => ['style' => 'color: #444']       
        ],
        [
            'label' => 'FULLNAME',
            'value' => 'fullname',
            'options' => ['style' => 'color: #444']
        ],
        [
            'label' => 'EMAIL',
            'value' => 'email',
            'options' => ['style' => 'color: #444']
        ],
    [
        'class' => 'yii\grid\ActionColumn',
        'header' => 'Action',
        'options' => ['style' => 'color: #444'],
        'template' => '{preview}{update}{delete}',
        'buttons' => [
            'preview' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-eye-open"></span> ', $url, ['class' => '_showViewUserModal', 'id' => $model->id, 'title' => Yii::t('app', 'Preview'),
                ]);
            },
            'update' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-pencil"></span> ', $url, ['class' => '_showUpdateUserModal', 'id' => $model->id, 'title' => Yii::t('app', 'Update'),
                ]);
            },
            'delete' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-trash"></span> ', $url, ['class' => 'userDeleteColumn', 'id' => $model->id, 'title' => Yii::t('app', 'Delete'),
                ]);
            },
        ],
        'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'preview') {
                $url ='#';
                return $url;
            }   
            if ($action === 'update') {
                $url ='#';
                return $url;
            }
            if ($action === 'delete') {
                $url ='#';
                return $url;
            }
        }
    ],
]
?>

<div class="col-md-12 col-sm-12 col-xs-12 btnsContainer">
<div class="row">

    <div class="col-md-2 pull-right">  
        <?= Html::button('<li class=\'fa fa-user-plus\'></li> New User -',['class' => '_showCreateUserModal formBtn btn btn-block btn-success btn-sm']) ?>
    </div>

</div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 table table-striped table-responsive contentWrapper">
    <?=
        GridView::widget([
            'id' => 'tableID',
            'class' => 'table table-hover',
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
            'showFooter'=> false,
        ]); 
    ?>
</div>
<br/>

<div class="col-md-12 col-sm-12 col-xs-12">
<div class="row">

<div class="col-md-4 pull-right">

    <div class="row">    
        <div class="col-md-6">
            <?= Html::button('<li class=\'fa fa-download\'></li> Export to Excel -',['class' => 'formBtn btn btn-block btn-warning btn-xs', 'onclick' => "excelExportUser()"]) ?>
        </div>
        <div class="col-md-6">
            <a href="?r=user/export-pdf"onclick="return pdfExport()" class="formBtn btn btn-block btn-danger btn-xs">
                <i class="fa fa-download"></i> Export to PDF -
            </a>
        </div>
    </div>

</div>
</div>
<br/><br/>

</div>

</div>

<!-- Create -->
<div class="modal fade modalBackground" id="modal-launcher-create-user" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close closeCreateUser" >&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-laptop"></i> New System User </h5>
            </div>

        <div class="modal-body">
            <?php $form = ActiveForm::begin(['method' => 'post', 'id' => 'userFormCreate']); ?>
                
                <label class="labelStyle">User Role</label>
                <?= $form->field($model, 'role_id')->dropdownList(['0' => ' - CHOOSE USER ROLE HERE - '] + $dataRole,['style' => 'width: 100%;', 'class' => 'inputForm select2', 'id' => 'role', 'data-placeholder' => 'PLEASE CHOOSE USER-ROLE HERE'])->label(false) ?>

                <label class="labelStyle">Fullname</label>
                <?= $form->field($model, 'fullname')->textInput(['class' => 'inputForm form-control', 'id' => 'fullname', 'placeholder' => 'Enter Fullname here.'])->label(false) ?>

                <label class="labelStyle">Email</label>
                <?= $form->field($model, 'email')->textInput(['class' => 'inputForm form-control', 'id' => 'email', 'placeholder' => 'Enter email here.'])->label(false) ?>

                <label class="labelStyle">Username</label>
                <?= $form->field($model, 'username')->textInput(['class' => 'inputForm form-control', 'id' => 'username', 'placeholder' => 'Enter Username here.'])->label(false) ?>

                <label class="labelStyle">Password</label>
                <?= $form->field($model, 'password')->passwordInput(['class' => 'inputForm form-control', 'id' => 'password', 'placeholder' => 'Enter Password here.'])->label(false) ?>

                <label class="labelStyle">Confirm Password</label>
                <input type="password" name="cpassword" class="inputForm form-control" id="cpassword" placeholder="Re-type your password here.">

            <?php ActiveForm::end(); ?>
        </div>

        <div class="modal-footer">
            <?= Html::button('<li class=\'fa fa-refresh\'></li> Clear', ['id' => 'clearUserForms', 'class' => 'formBtn btn btn-default']) ?>
            <?= Html::submitButton('<li class=\'fa fa-paper-plane-o\'></li> Submit Record', ['id' => 'submitUserFormCreate', 'class' => 'formBtn btn btn-primary']) ?>
        </div>

        </div>
    </div>
</div>

<!-- Update -->
<div class="modal fade modalBackground" id="modal-launcher-update-user" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close closeUpdateUser" >&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-edit"></i> Update System User </h5>
            </div>

        <div class="modal-body">
            <?php $form = ActiveForm::begin(['method' => 'post', 'id' => 'userFormUpdate']); ?>
                <input type="hidden" id="id" name="id" />

                <label class="labelStyle">User Role</label>
                <?= $form->field($model, 'role_id')->dropdownList(['0' => ' - CHOOSE USER ROLE HERE - '] + $dataRole,['style' => 'width: 100%;', 'class' => 'inputForm select2', 'id' => 'updateRole', 'data-placeholder' => 'PLEASE CHOOSE USER-ROLE HERE'])->label(false) ?>

                <label class="labelStyle">Fullname</label>
                <?= $form->field($model, 'fullname')->textInput(['class' => 'inputForm form-control', 'id' => 'updateFullname', 'placeholder' => 'Enter Fullname here.'])->label(false) ?>

                <label class="labelStyle">Email</label>
                <?= $form->field($model, 'email')->textInput(['class' => 'inputForm form-control', 'id' => 'updateEmail', 'placeholder' => 'Enter email here.'])->label(false) ?>

                <label class="labelStyle">Username</label>
                <?= $form->field($model, 'username')->textInput(['class' => 'inputForm form-control', 'id' => 'updateUsername', 'placeholder' => 'Enter Username here.'])->label(false) ?>

                <input type="checkbox" id="showChangePassword" class="showChangePassword" /> Change password?

                <div id="changePassword">
                    <label class="labelStyle">Password</label>
                    <?= $form->field($model, 'password')->passwordInput(['class' => 'inputForm form-control', 'id' => 'updatePassword', 'placeholder' => 'Enter Password here.'])->label(false) ?>

                    <label class="labelStyle">Confirm Password</label>
                    <input type="password" name="cpassword" class="inputForm form-control" id="updateCpassword" placeholder="Re-type your password here.">
                </div>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="modal-footer">
            <?= Html::button('<li class=\'fa fa-refresh\'></li> Clear', ['id' => 'clearUserForms', 'class' => 'formBtn btn btn-default']) ?>
            <?= Html::submitButton('<li class=\'fa fa-paper-plane-o\'></li> Save Record', ['id' => 'submitUserFormUpdate', 'class' => 'formBtn btn btn-primary']) ?>
        </div>

        </div>
    </div>
</div>

<!-- View -->
<div class="modal fade modalBackground" id="modal-launcher-view-user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close closeViewUser" >&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-windows"></i> View System User Information</h5>
            </div>

            <div class="modal-body" id="viewUser">
                <!-- Information Content -->
            </div>

            <div class="modal-footer">
            <?= Html::button('<li class=\'fa fa-minus-square\'></li> Close', ['id' => 'closeUserForms', 'class' => 'formBtn btn btn-default']) ?>
            </div>

        </div>
    </div>
</div>

<!-- Export to Excel -->
<a id="divLink" style="display: none;"></a>

</div>