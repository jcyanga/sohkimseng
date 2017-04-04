<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\StaffGroup;
use common\models\Race;
use common\models\DesignatedPosition;

$dataStaffGroup = ArrayHelper::map(StaffGroup::find()->where(['status' => 1])->all(),'id', 'name');
$dataDesignatedPosition = ArrayHelper::map(DesignatedPosition::find()->where(['status' => 1])->all(),'id', 'name');
$dataRace = ArrayHelper::map(Race::find()->where(['status' => 1])->all(),'id', 'name');

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchStaff */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Staff Maintenance';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="staff-index divContainer">

<div class="row containerHeadWrapper">
    
    <div class="col-md-12 col-sm-12 col-xs-12">
        
        <div>
            <h4 class="divHeaderLabel"><i class="fa fa-address-card"></i> <?= Html::encode($this->title) ?></h4>
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
    ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'staff_group_id',
            'value' => 'staffGroup.name',
            'label' => 'Department',
        ],
        [
            'attribute' => 'designated_position_id',
            'value' => 'designatedPosition.name',
            'label' => 'Designated Position',
        ],
        'fullname',
        'address',
        'email',
        'mobile_number',
    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{preview}{update}{delete}',
        'buttons' => [
            'preview' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-eye-open"></span> ', $url, ['class' => '_showViewStaffModal', 'id' => $model->id, 'title' => Yii::t('app', 'Preview'),
                ]);
            },
            'update' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-pencil"></span> ', $url, ['class' => '_showUpdateStaffModal', 'id' => $model->id, 'title' => Yii::t('app', 'Update'),
                ]);
            },
            'delete' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-trash"></span> ', $url, ['class' => 'staffDeleteColumn', 'id' => $model->id, 'title' => Yii::t('app', 'Delete'),
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
        <?= Html::button('<li class=\'fa fa-user-plus\'></li> New Staff -',['class' => '_showCreateStaffModal formBtn btn btn-block btn-success btn-sm']) ?>
    </div>

</div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 table-responsive contentWrapper">
    <?=
        GridView::widget([
            'id' => 'tableID',
            'class' => 'table table-hover',
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
            'showFooter'=>true,
        ]); 
    ?>
</div>
<br/>

<div class="col-md-12 col-sm-12 col-xs-12">
<div class="row">

<div class="col-md-4 pull-right">

    <div class="row">    
        <div class="col-md-6">
            <?= Html::button('<li class=\'fa fa-download\'></li> Export to Excel -',['class' => 'formBtn btn btn-block btn-warning btn-xs', 'onclick' => "excelExportStaff()"]) ?>
        </div>
        <div class="col-md-6">
            <a href="?r=staff/export-pdf"onclick="return pdfExport()" class="formBtn btn btn-block btn-danger btn-xs"><i class="fa fa-download"></i> Export to PDF -
            </a>
        </div>
    </div>

</div>
</div>
<br/><br/>

</div>

</div>

<!-- Create -->
<div class="modal fade modalBackground" id="modal-launcher-create-staff" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close closeNewStaff" >&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-laptop"></i> New Staff </h5>
            </div>

        <div class="modal-body">
            <?php $form = ActiveForm::begin(['method' => 'post', 'id' => 'staffFormCreate']); ?>
                
                <label class="labelStyle">Department</label>
                <?= $form->field($model, 'staff_group_id')->dropdownList(['0' => ' - CHOOSE DEPARTMENT HERE - '] + $dataStaffGroup,['style' => 'width: 100%;', 'class' => 'inputForm select2', 'id' => 'staffGroup', 'data-placeholder' => 'PLEASE CHOOSE DEPARTMENT HERE'])->label(false) ?>

                <label class="labelStyle">Designated Position</label>
                <?= $form->field($model, 'designated_position_id')->dropdownList(['0' => ' - CHOOSE DESIGNATED POSITION HERE - '] + $dataDesignatedPosition,['style' => 'width: 100%;', 'class' => 'inputForm select2', 'id' => 'designatedPosition', 'data-placeholder' => 'PLEASE CHOOSE DESIGNATED POSITION HERE'])->label(false) ?>

                <label class="labelStyle">Fullname</label>
                <?= $form->field($model, 'fullname')->textInput(['class' => 'inputForm form-control', 'id' => 'fullname', 'placeholder' => 'Enter Fullname here.'])->label(false) ?>

                <label class="labelStyle">Address</label>
                <?= $form->field($model, 'address')->textarea(['rows' => '3', 'cols' => '2', 'class' => 'inputForm form-control', 'id' => 'address', 'placeholder' => 'Enter Address here.'])->label(false) ?>

                <label class="labelStyle">Race</label>
                <?= $form->field($model, 'race_id')->dropdownList(['0' => ' - CHOOSE RACE HERE - '] + $dataRace,['style' => 'width: 100%;', 'class' => 'inputForm select2', 'id' => 'race', 'data-placeholder' => 'PLEASE CHOOSE RACE HERE'])->label(false) ?>

                <label class="labelStyle">Email</label>
                <?= $form->field($model, 'email')->textInput(['class' => 'inputForm form-control', 'id' => 'email', 'placeholder' => 'Enter Email here.'])->label(false) ?>

                <label class="labelStyle">Mobile Number</label>
                <?= $form->field($model, 'mobile_number')->textInput(['class' => 'inputForm form-control', 'id' => 'mobileNumber', 'placeholder' => 'Enter Mobile number here.'])->label(false) ?>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="modal-footer">
            <?= Html::button('<li class=\'fa fa-refresh\'></li> Clear', ['id' => 'clearStaffForms', 'class' => 'formBtn btn btn-default']) ?>
            <?= Html::submitButton('<li class=\'fa fa-paper-plane-o\'></li> Submit Record', ['id' => 'submitStaffFormCreate', 'class' => 'formBtn btn btn-primary']) ?>
        </div>

        </div>
    </div>
</div>

<!-- Update -->
<div class="modal fade modalBackground" id="modal-launcher-update-staff" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close closeUpdateStaff" >&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-edit"></i> Update Staff </h5>
            </div>

        <div class="modal-body">
            <?php $form = ActiveForm::begin(['method' => 'post', 'id' => 'staffFormUpdate']); ?>
                <input type="hidden" name="id" id="id" />

                <label class="labelStyle">Department</label>
                <?= $form->field($model, 'staff_group_id')->dropdownList(['0' => ' - CHOOSE STAFF GROUP HERE - '] + $dataStaffGroup,['style' => 'width: 100%;', 'class' => 'inputForm select2', 'id' => 'updateStaffGroup', 'data-placeholder' => 'PLEASE CHOOSE STAFF GROUP HERE'])->label(false) ?>

                <label class="labelStyle">Designated Position</label>
                <?= $form->field($model, 'designated_position_id')->dropdownList(['0' => ' - CHOOSE DESIGNATED POSITION HERE - '] + $dataDesignatedPosition,['style' => 'width: 100%;', 'class' => 'inputForm select2', 'id' => 'updateDesignatedPosition', 'data-placeholder' => 'PLEASE CHOOSE DESIGNATED POSITION HERE'])->label(false) ?>

                <label class="labelStyle">Fullname</label>
                <?= $form->field($model, 'fullname')->textInput(['class' => 'inputForm form-control', 'id' => 'updateFullname', 'placeholder' => 'Enter Fullname here.'])->label(false) ?>

                <label class="labelStyle">Address</label>
                <?= $form->field($model, 'address')->textarea(['rows' => '3', 'cols' => '2', 'class' => 'inputForm form-control', 'id' => 'updateAddress', 'placeholder' => 'Enter Address here.'])->label(false) ?>

                <label class="labelStyle">Race</label>
                <?= $form->field($model, 'race_id')->dropdownList(['0' => ' - CHOOSE RACE HERE - '] + $dataRace,['style' => 'width: 100%;', 'class' => 'inputForm select2', 'id' => 'updateRace', 'data-placeholder' => 'PLEASE CHOOSE RACE HERE'])->label(false) ?>

                <label class="labelStyle">Email</label>
                <?= $form->field($model, 'email')->textInput(['class' => 'inputForm form-control', 'id' => 'updateEmail', 'placeholder' => 'Enter Email here.'])->label(false) ?>

                <label class="labelStyle">Mobile Number</label>
                <?= $form->field($model, 'mobile_number')->textInput(['class' => 'inputForm form-control', 'id' => 'updateMobileNumber', 'placeholder' => 'Enter Mobile number here.'])->label(false) ?>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="modal-footer">
            <?= Html::button('<li class=\'fa fa-refresh\'></li> Clear', ['id' => 'clearStaffForms', 'class' => 'formBtn btn btn-default']) ?>
            <?= Html::submitButton('<li class=\'fa fa-paper-plane-o\'></li> Save Record', ['id' => 'submitStaffFormUpdate', 'class' => 'formBtn btn btn-primary']) ?>
        </div>

        </div>
    </div>
</div>

<!-- View -->
<div class="modal fade modalBackground" id="modal-launcher-view-staff" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close closeViewStaff" >&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-desktop"></i> View Staff Information</h5>
            </div>

            <div class="modal-body" id="viewStaff">
                <!-- Information Content -->
            </div>

            <div class="modal-footer">
            <?= Html::button('<li class=\'fa fa-minus-square\'></li> Close', ['id' => 'closeStaffForms', 'class' => 'formBtn btn btn-default']) ?>
            </div>

        </div>
    </div>
</div>

<!-- Export to Excel -->
<a id="divLink" style="display: none;"></a>

</div>