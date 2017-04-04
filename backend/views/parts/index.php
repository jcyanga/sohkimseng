<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use common\models\PartsCategory;

$dataPartsCategory = ArrayHelper::map(PartsCategory::find()->all(),'id', 'name');

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchParts */
/* @var $dataProvider yii\data\ActiveDataProvider */

$partsCode = 'PARTS' . '-' .  date('Y') . '-' .  substr(uniqid('', true), -5);

$this->title = 'Auto-Parts List';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="parts-index divContainer">

<div class="row containerHeadWrapper">
    
    <div class="col-md-12 col-sm-12 col-xs-12">
        
        <div>
            <h4 class="divHeaderLabel"><i class="fa fa-cogs"></i> <?= Html::encode($this->title) ?></h4>
        </div>
        <hr/>

    <?php  echo $this->render('_search', [
                            'model' => $searchModel, 'dataPartsCategory' => $dataPartsCategory ]); 
                        ?>    
    </div>

</div>
<br/>

<div class="row containerContentWrapper">
<?php
$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'parts_category_id',
            'value' => 'partsCategory.name',
            'label' => 'Parts Category',
        ],
        'parts_code',
        'parts_name',
        'unit_of_measure',
    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{preview}{update}{delete}',
        'buttons' => [
            'preview' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-eye-open"></span> ', $url, ['class' => '_showViewPartsModal', 'id' => $model->id, 'title' => Yii::t('app', 'Preview'),
                ]);
            },
            'update' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-pencil"></span> ', $url, ['class' => '_showUpdatePartsModal', 'id' => $model->id, 'title' => Yii::t('app', 'Update'),
                ]);
            },
            'delete' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-trash"></span> ', $url, ['class' => 'partsDeleteColumn', 'id' => $model->id, 'title' => Yii::t('app', 'Delete'),
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
        <?= Html::button('<li class=\'fa fa-plus-square\'></li> New Auto-Part',['class' => '_showCreatePartsModal formBtn btn btn-block btn-success btn-xs']) ?>
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
            <?= Html::button('<li class=\'fa fa-download\'></li> Export to Excel',['class' => 'formBtn btn btn-block btn-warning btn-xs', 'onclick' => "excelExportParts()"]) ?>
        </div>
        <div class="col-md-6">
            <a href="?r=parts/export-pdf"onclick="return pdfExport()" class="formBtn btn btn-block btn-danger btn-xs"><i class="fa fa-download"></i> Export to PDF
            </a>
        </div>
    </div>

</div>
</div>
<br/><br/>

</div>

</div>

<!-- Create -->
<div class="modal fade" id="modal-launcher-create-parts" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-user-plus"></i> New Auto-Parts Information</h5>
            </div>

        <div class="modal-body">
            <?php $form = ActiveForm::begin(['method' => 'post', 'id' => 'partsFormCreate']); ?>
                
                <label class="labelStyle">Auto-Parts Code</label>
                <?= $form->field($model, 'parts_code')->textInput(['class' => 'inputForm form-control', 'id' => 'partsCode', 'value' => $partsCode, 'readonly' => 'readonly'])->label(false) ?>

                <label class="labelStyle">Auto-Parts Category</label>
                <?= $form->field($model, 'parts_category_id')->dropdownList($dataPartsCategory,['style' => 'width: 100%;', 'class' => 'inputForm select2', 'id' => 'partsCategory'])->label(false) ?>

                <label class="labelStyle">Auto-Parts Name</label>
                <?= $form->field($model, 'parts_name')->textInput(['class' => 'inputForm form-control', 'id' => 'partsName', 'placeholder' => 'Enter Auto-Parts name here.'])->label(false) ?>

                <label class="labelStyle">Description</label>
                <?= $form->field($model, 'description')->textarea(['class' => 'inputForm form-control', 'id' => 'description', 'placeholder' => 'Enter Auto-Parts description here.'])->label(false) ?>

                <label class="labelStyle">Unit of Measure</label>
                <?= $form->field($model, 'unit_of_measure')->textInput(['class' => 'inputForm form-control', 'id' => 'uom', 'placeholder' => 'Enter Unit of Measure here.'])->label(false) ?>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="modal-footer">
            <?= Html::button('<li class=\'fa fa-refresh\'></li> Clear', ['id' => 'clearPartsForms', 'class' => 'formBtn btn btn-default']) ?>
            <?= Html::submitButton('<li class=\'fa fa-check\'></li> Submit', ['id' => 'submitPartsFormCreate', 'class' => 'formBtn btn btn-primary']) ?>
        </div>

        </div>
    </div>
</div>

<!-- Update -->
<div class="modal fade" id="modal-launcher-update-parts" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-wrench"></i> Update Auto-Parts Information</h5>
            </div>

        <div class="modal-body">
            <?php $form = ActiveForm::begin(['method' => 'post', 'id' => 'partsFormUpdate']); ?>
                <input type="hidden" name="id" id="id" />

                <label class="labelStyle">Auto-Parts Code</label>
                <?= $form->field($model, 'parts_code')->textInput(['class' => 'inputForm form-control', 'id' => 'updatePartsCode', 'readonly' => 'readonly'])->label(false) ?>

                <label class="labelStyle">Auto-Parts Category</label>
                <?= $form->field($model, 'parts_category_id')->dropdownList($dataPartsCategory,['style' => 'width: 100%;', 'class' => 'inputForm select2', 'id' => 'updatePartsCategory'])->label(false) ?>

                <label class="labelStyle">Auto-Parts Name</label>
                <?= $form->field($model, 'parts_name')->textInput(['class' => 'inputForm form-control', 'id' => 'updatePartsName', 'placeholder' => 'Enter Auto-Parts name here.'])->label(false) ?>

                <label class="labelStyle">Description</label>
                <?= $form->field($model, 'description')->textarea(['class' => 'inputForm form-control', 'id' => 'updateDescription', 'placeholder' => 'Enter Auto-Parts description here.'])->label(false) ?>

                <label class="labelStyle">Unit of Measure</label>
                <?= $form->field($model, 'unit_of_measure')->textInput(['class' => 'inputForm form-control', 'id' => 'updateUom', 'placeholder' => 'Enter Unit of Measure here.'])->label(false) ?>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="modal-footer">
            <?= Html::button('<li class=\'fa fa-refresh\'></li> Clear', ['id' => 'clearPartsForms', 'class' => 'formBtn btn btn-default']) ?>
            <?= Html::submitButton('<li class=\'fa fa-check\'></li> Submit', ['id' => 'submitPartsFormUpdate', 'class' => 'formBtn btn btn-primary']) ?>
        </div>

        </div>
    </div>
</div>

<!-- View -->
<div class="modal fade" id="modal-launcher-view-parts" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-desktop"></i> View Parts Information</h5>
            </div>

            <div class="modal-body" id="viewParts">
                <!-- Information Content -->
            </div>

            <div class="modal-footer">
            <?= Html::button('<li class=\'fa fa-minus-square\'></li> Close', ['id' => 'closePartsForms', 'class' => 'formBtn btn btn-default']) ?>
            </div>

        </div>
    </div>
</div>

<!-- Export to Excel -->
<a id="divLink" style="display: none;"></a>

</div>