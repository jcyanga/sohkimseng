<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchPartsCategory */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Auto-Parts Category';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="parts-category-index divContainer">

<div class="row containerHeadWrapper">
    
    <div class="col-md-12 col-sm-12 col-xs-12">
        
        <div>
            <h4 class="divHeaderLabel"><i class="fa fa-cogs"></i> <?= Html::encode($this->title) ?></h4>
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
        'name',
        'description',
    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{preview}{update}{delete}',
        'buttons' => [
            'preview' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-eye-open"></span> ', $url, ['class' => '_showViewPCModal', 'id' => $model->id, 'title' => Yii::t('app', 'Preview'),
                ]);
            },
            'update' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-pencil"></span> ', $url, ['class' => '_showUpdatePCModal', 'id' => $model->id, 'title' => Yii::t('app', 'Update'),
                ]);
            },
            'delete' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-trash"></span> ', $url, ['class' => 'pcDeleteColumn', 'id' => $model->id, 'title' => Yii::t('app', 'Delete'),
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
        <?= Html::button('<li class=\'fa fa-user-plus\'></li> New Auto-Parts Category -',['class' => '_showCreatePCModal formBtn btn btn-block btn-success btn-sm']) ?>
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

<div class="col-md-4">

    <div class="row">    
        <div class="col-md-6">
            <?= Html::button('<li class=\'fa fa-download\'></li> Export to Excel -',['class' => 'formBtn btn btn-block btn-warning btn-xs', 'onclick' => "excelExportPC()"]) ?>
        </div>
        <div class="col-md-6">
            <a href="?r=parts-category/export-pdf"onclick="return pdfExport()" class="formBtn btn btn-block btn-danger btn-xs"><i class="fa fa-download"></i> Export to PDF -
            </a>
        </div>
    </div>

</div>
</div>
<br/><br/>

</div>

</div>

<!-- Create -->
<div class="modal fade" id="modal-launcher-create-pc" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-laptop"></i> New Auto-Parts Category</h5>
            </div>

        <div class="modal-body">
            <?php $form = ActiveForm::begin(['method' => 'post', 'id' => 'pcFormCreate']); ?>
    
                <label class="labelStyle">Auto-Parts Category Name</label>
                <?= $form->field($model, 'name')->textInput(['class' => 'inputForm form-control', 'id' => 'name', 'placeholder' => 'Enter Auto-Parts Category name here.'])->label(false) ?>

                <label class="labelStyle">Description</label>
                <?= $form->field($model, 'description')->textarea(['class' => 'inputForm form-control', 'id' => 'description', 'placeholder' => 'Enter Auto-Parts Category description here.'])->label(false) ?>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="modal-footer">
            <?= Html::button('<li class=\'fa fa-refresh\'></li> Clear', ['id' => 'clearPCForms', 'class' => 'formBtn btn btn-default']) ?>
            <?= Html::submitButton('<li class=\'fa fa-paper-plane-o\'></li> Submit Auto-Parts Information', ['id' => 'submitPCFormCreate', 'class' => 'formBtn btn btn-primary']) ?>
        </div>

        </div>
    </div>
</div>

<!-- Update -->
<div class="modal fade" id="modal-launcher-update-pc" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-edit"></i> Update Auto-Parts Category</h5>
            </div>

        <div class="modal-body">
            <?php $form = ActiveForm::begin(['method' => 'post', 'id' => 'pcFormUpdate']); ?>
                <input type="hidden" name="id" id="id" />

                <label class="labelStyle">Auto-Parts Category Name</label>
                <?= $form->field($model, 'name')->textInput(['class' => 'inputForm form-control', 'id' => 'updateName', 'placeholder' => 'Enter Auto-Parts Category name here.'])->label(false) ?>

                <label class="labelStyle">Description</label>
                <?= $form->field($model, 'description')->textarea(['class' => 'inputForm form-control', 'id' => 'updateDescription', 'placeholder' => 'Enter Auto-Parts Category description here.'])->label(false) ?>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="modal-footer">
            <?= Html::button('<li class=\'fa fa-refresh\'></li> Clear', ['id' => 'clearPCForms', 'class' => 'formBtn btn btn-default']) ?>
            <?= Html::submitButton('<li class=\'fa fa-paper-plane-o\'></li> Save Auto-Parts Information', ['id' => 'submitPCFormUpdate', 'class' => 'formBtn btn btn-primary']) ?>
        </div>

        </div>
    </div>
</div>

<!-- View -->
<div class="modal fade" id="modal-launcher-view-pc" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-desktop"></i> View Auto-Parts Category Information</h5>
            </div>

            <div class="modal-body" id="viewPC">
                <!-- Information Content -->
            </div>

            <div class="modal-footer">
            <?= Html::button('<li class=\'fa fa-minus-square\'></li> Close', ['id' => 'closePCForms', 'class' => 'formBtn btn btn-default']) ?>
            </div>

        </div>
    </div>
</div>

<!-- Export to Excel -->
<a id="divLink" style="display: none;"></a>

</div>