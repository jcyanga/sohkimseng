<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchUserPermission */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Permission Maintenance';
$this->params['breadcrumbs'][] = $this->title;

print_r($controllerActions);

?>

<div class="user-permission-index divContainer">

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
        'label' => 'SYSTEM CONTROLLER',
        'value' => 'controller',
        'options' => ['style' => 'color: #444']
    ],
    [
        'label' => 'CONTROLLER ACTION',
        'value' => 'action',
        'options' => ['style' => 'color: #444']
    ],
        [
            'attribute' => 'role_id',
            'value' => 'role.name',
            'header' => 'User Role',
            'options' => ['style' => 'color: #444']
        ],
    [
        'class' => 'yii\grid\ActionColumn',
        'header' => 'Action',
        'options' => ['style' => 'color: #444'],
        'template' => '{delete}',
        'buttons' => [
            'delete' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-trash"></span> ', $url, ['class' => 'upDeleteColumn', 'id' => $model->id, 'title' => Yii::t('app', 'Delete'),
                ]);
            },
        ],
        'urlCreator' => function ($action, $model, $key, $index) {
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

    <div class="col-md-3 pull-right">  
        <?= Html::button('<li class=\'fa fa-user-plus\'></li> New User Permission -',['class' => '_showCreateUPModal formBtn btn btn-block btn-success btn-flat btn-sm']) ?>
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

<div class="col-md-12 col-sm-12 col-xs-12">
<div class="row">

<div class="col-md-4 pull-right">

    <div class="row">    
        <div class="col-md-6">
            <?= Html::button('<li class=\'fa fa-download\'></li> Export to Excel -',['class' => 'formBtn btn btn-block btn-warning btn-xs', 'onclick' => "excelExportUP()"]) ?>
        </div>
        <div class="col-md-6">
            <a href="?r=role/export-pdf"onclick="return pdfExport()" class="formBtn btn btn-block btn-danger btn-xs">
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
<div class="modal fade modalBackground" id="modal-launcher-create-up" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog modalUPDesign">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close closeCreateUp" >&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-laptop"></i> New User Permission </h5>
            </div>

        <div class="modal-body">
            <?php $form = ActiveForm::begin(['class' => 'form-inline']); ?>

            <div class="row">

            <div class="col-md-6">
                <label style="font-size: 12px;">Controller List</label>
                <select id="controllerName" style="width: 100%;" name="controllerName" class="form_input select2">
                    <option vale="0"> - CHOOSE CONTROLLER HERE - </option>
                    <?php foreach ( $controllerList as $cName => $cL ) {  ?>
                        <?php  $selected = $controllerNameChosen == $cName ?  'selected' : ''?>
                        <option <?= $selected ?>><?= $cName ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-md-6">
                <label style="font-size: 12px;">Role List</label>
                <select id="userRole" style="width: 100%;" name="userRole" class="form_input select2">
                    <option vale="0"> - CHOOSE USER ROLE HERE - </option>
                    <?php foreach ( $userRole as $uR ) { ?>
                        <?php  $selected = $userRoleId == $uR->id ?  'selected' : ''?>
                        <option value="<?= $uR->id ?>" <?= $selected ?>><?= $uR->name ?></option>
                    <?php } /* foreach */ ?>
                </select>
            </div>

            </div>

            <?php ActiveForm::end(); ?>
            <br/>

            <?php $form = ActiveForm::begin(['id' => 'upFormCreate']); ?>
            <div class="row">
            <div class="col-md-12">

            <input type="hidden" name="controllerName" id="selectedControllerName" />
            <input type="hidden" name="controllerNameChosen" id="selectedControllerNameChosen" />
            <input type="hidden" name="userRole" id="selectedUserRole" />

            <div id="selectedMethods"></div>

            </div>
            </div>
            <?php ActiveForm::end(); ?>

        <div class="modal-footer">
            <?= Html::button('<li class=\'fa fa-check-square\'></li> Select All', ['id' => 'select-all', 'class' => 'formBtn btn btn-info']) ?>
            <?= Html::submitButton('<li class=\'fa fa-paper-plane-o\'></li> Save Record', ['id' => 'submitUPFormCreate', 'class' => 'formBtn btn btn-primary']) ?>
        </div>

        </div>
    </div>
</div>

<!-- Export to Excel -->
<a id="divLink" style="display: none;"></a>

</div>

