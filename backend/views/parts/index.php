<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\db\Query;

use common\models\PartsCategory;
use common\models\Supplier;

$rows = new Query();

$dataPartsCategory = PartsCategory::find()->where(['status' => 1])->all();
$dataSupplier = ArrayHelper::map(Supplier::find()->where(['status' => 1])->all(),'id', 'name');
$dataStorageLocation = ArrayHelper::map(
                    $rows->select(['concat("[ ", rack," ] ",bay," - ",level," - ",position) as slName', 'id'])
                    ->from('storage_location')->where(['status' => 1])->all(),
                'id', 'slName');

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
                            'model' => $searchModel ]); 
                        ?>    
    </div>

</div>
<br/>

<div class="row containerContentWrapper">
<?php
$gridColumns = [
    [
        'class' => 'yii\grid\CheckboxColumn',
        'checkboxOptions' => ['value' => $model->id, 'class' => 'autopartsSelected', 'id' => 'autopartsSelected' ],
        'header' => '<span class="glyphicon glyphicon-check"></span>' 
    ],
    [
        'class' => 'yii\grid\SerialColumn',
        'options' => ['style' => 'color: #444']
    ],
            [
                'label' => 'AUTO-PARTS CODE',
                'value' => 'parts_code',
                'options' => ['style' => 'color: #444']
            ],
            [
                'label' => 'AUTO-PARTS NAME',
                'value' => 'parts_name',
                'options' => ['style' => 'color: #444']
            ],
            [
                'label' => 'QUANTITY',
                'value' => 'quantity',
                'options' => ['style' => 'color: #444']
            ],
            [
                'label' => 'AMOUNT',
                'value' => 'selling_price',
                'options' => ['style' => 'color: #444']
            ],
        [
        'class' => 'yii\grid\ActionColumn',
        'header' => 'Action',
        'options' => ['style' => 'color: #444'],
        'template' => '{preview}{update}{changeqty}{delete}',
        'buttons' => [
            'preview' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-eye-open"></span> ', $url, ['class' => '_showViewPartsModal', 'id' => $model->id, 'title' => Yii::t('app', 'Preview'),
                ]);
            },
            'update' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-pencil"></span> ', $url, ['class' => '_showUpdatePartsModal', 'id' => $model->id, 'title' => Yii::t('app', 'Update'),
                ]);
            },
            'changeqty' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-hourglass"></span> ', $url, ['class' => '_showUpdatePartsQtyModal', 'id' => $model->id, 'title' => Yii::t('app', 'ChangeQty'),
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
            if ($action === 'changeqty') {
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
        <?= Html::button('<li class=\'fa fa-user-plus\'></li> New Auto-Parts -',['class' => '_showCreatePartsModal formBtn btn btn-block btn-success btn-sm']) ?>
    </div>

    <div class="col-md-2 pull-right">  
        <?= Html::button('<li class=\'fa fa-edit\'></li> Edit Auto-Parts Qty -',['class' => '_showUpdateQtySelectedPartsModal formBtn btn btn-block btn-info btn-sm']) ?>
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
<div class="modal fade modalBackground" id="modal-launcher-create-parts" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close closeNewParts" >&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-user-plus"></i> New Auto-Parts </h5>
            </div>

        <div class="modal-body">
            <?php $form = ActiveForm::begin(['method' => 'post', 'id' => 'partsFormCreate']); ?>
                
                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <label class="labelStyle">Storage Location</label>
                        <?= $form->field($model, 'storage_location_id')->dropdownList(['0' => '- CHOOSE STORAGE LOCATION HERE -'] + $dataStorageLocation,['style' => 'width: 100%;', 'class' => 'inputForm select2', 'id' => 'storageLocation', 'data-placeholder' => 'PLEASE SELECT STORAGE LOCATION HERE' ])->label(false) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <label class="labelStyle">Supplier Name</label>
                        <?= $form->field($model, 'supplier_id')->dropdownList(['0' => '- CHOOSE SUPPLIER HERE -'] + $dataSupplier,['style' => 'width: 100%;', 'class' => 'inputForm select2', 'id' => 'supplier', 'data-placeholder' => 'PLEASE SELECT SUPPLIER HERE' ])->label(false) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <label class="labelStyle">Auto-Parts Code</label>
                        <?= $form->field($model, 'parts_code')->textInput(['class' => 'inputForm form-control', 'id' => 'partsCode', 'value' => $partsCode, 'readonly' => 'readonly'])->label(false) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <label class="labelStyle">Auto-Parts Category</label>
                        <br/>

                        <?php foreach($dataPartsCategory as $pcKey => $pcRow): ?>
                            <input type="checkbox" name="partsCategory[]" class="minimal partsCategory" id="partsCategory" value="<?= $pcRow['id'] ?>" /> <span class="inputChkbox" ><?= $pcRow['name'] ?></span>&nbsp;
                        <?php endforeach; ?>

                    </div>
                </div>
                <br/>

                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <label class="labelStyle">Auto-Parts Name</label>
                        <?= $form->field($model, 'parts_name')->textInput(['class' => 'inputForm form-control', 'id' => 'partsName', 'placeholder' => 'Enter Auto-Parts name here.'])->label(false) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-xs-6 col-sm-6">
                        <label class="labelStyle">Quantity</label>
                        <?= $form->field($model, 'quantity')->textInput(['class' => 'inputForm form-control', 'id' => 'quantity', 'placeholder' => 'Enter Quantity here.'])->label(false) ?>

                        <label class="labelStyle">Unit of Measure</label>
                        <?= $form->field($model, 'unit_of_measure')->textInput(['class' => 'inputForm form-control', 'id' => 'uom', 'placeholder' => 'Enter Unit of Measure here.'])->label(false) ?>
                        
                        <label class="labelStyle">Cost Price</label>
                        <?= $form->field($model, 'cost_price')->textInput(['class' => 'inputForm form-control', 'id' => 'costPrice', 'placeholder' => 'Enter Cost Price here.'])->label(false) ?>
                    </div>
                
                    <div class="col-md-6 col-xs-6 col-sm-6">
                        <label class="labelStyle">Re-Order Level</label>
                        <?= $form->field($model, 'reorder_level')->textInput(['class' => 'inputForm form-control', 'id' => 'reorderLevel', 'placeholder' => 'Enter Re-Order Level here.'])->label(false) ?>

                        <label class="labelStyle">Gst Price</label>
                        <?= $form->field($model, 'gst_price')->textInput(['class' => 'inputForm form-control', 'id' => 'gstPrice', 'placeholder' => 'Enter Gst Price here.'])->label(false) ?>

                        <label class="labelStyle">Selling Price</label>
                        <?= $form->field($model, 'selling_price')->textInput(['class' => 'inputForm form-control', 'id' => 'sellingPrice', 'placeholder' => 'Enter Selling Price here.'])->label(false) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <label class="labelStyle">Remarks</label>
                        <?= $form->field($model, 'remarks')->textarea(['class' => 'inputForm form-control', 'rows' => 5, 'id' => 'remarks', 'placeholder' => 'Enter Remarks here.'])->label(false) ?>
                    </div>
                </div>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="modal-footer">
            <?= Html::button('<li class=\'fa fa-refresh\'></li> Clear', ['id' => 'clearPartsForms', 'class' => 'formBtn btn btn-default']) ?>
            <?= Html::submitButton('<li class=\'fa fa-check\'></li> Submit Record', ['id' => 'submitPartsFormCreate', 'class' => 'formBtn btn btn-primary']) ?>
        </div>

        </div>
    </div>
</div>

<!-- Update -->
<div class="modal fade modalBackground" id="modal-launcher-update-parts" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close closeUpdateParts" >&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-wrench"></i> Update Auto-Parts </h5>
            </div>

        <div class="modal-body">
            <?php $form = ActiveForm::begin(['method' => 'post', 'id' => 'partsFormUpdate']); ?>
                <input type="hidden" name="id" id="id" />

                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <label class="labelStyle">Storage Location</label>
                        <?= $form->field($model, 'storage_location_id')->dropdownList(['0' => '- CHOOSE STORAGE LOCATION HERE -'] + $dataStorageLocation,['style' => 'width: 100%;', 'class' => 'inputForm select2', 'id' => 'updateStorageLocation', 'data-placeholder' => 'PLEASE SELECT STORAGE LOCATION HERE' ])->label(false) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <label class="labelStyle">Supplier Name</label>
                        <?= $form->field($model, 'supplier_id')->dropdownList(['0' => '- CHOOSE SUPPLIER HERE -'] + $dataSupplier,['style' => 'width: 100%;', 'class' => 'inputForm select2', 'id' => 'updateSupplier', 'data-placeholder' => 'PLEASE SELECT SUPPLIER HERE' ])->label(false) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <label class="labelStyle">Auto-Parts Code</label>
                        <?= $form->field($model, 'parts_code')->textInput(['class' => 'inputForm form-control', 'id' => 'updatePartsCode', 'value' => $partsCode, 'readonly' => 'readonly'])->label(false) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <label class="labelStyle">Auto-Parts Category</label>
                        <br/>

                        <?php foreach($dataPartsCategory as $pcKey => $pcRow): ?>
                            <input type="checkbox" name="updatePartsCategory[]" class="minimal updatePartsCategory" id="updatePartsCategory-<?= $pcRow['id'] ?>" value="<?= $pcRow['id'] ?>" /> <span class="inputChkbox" ><?= $pcRow['name'] ?></span>&nbsp;
                        <?php endforeach; ?>

                    </div>
                </div>
                <br/>

                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <label class="labelStyle">Auto-Parts Name</label>
                        <?= $form->field($model, 'parts_name')->textInput(['class' => 'inputForm form-control', 'id' => 'updatePartsName', 'placeholder' => 'Enter Auto-Parts name here.'])->label(false) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-xs-6 col-sm-6">
                        <label class="labelStyle">Quantity</label>
                        <?= $form->field($model, 'quantity')->textInput(['class' => 'inputForm form-control', 'id' => 'updateQuantity', 'placeholder' => 'Enter Quantity here.'])->label(false) ?>

                        <label class="labelStyle">Unit of Measure</label>
                        <?= $form->field($model, 'unit_of_measure')->textInput(['class' => 'inputForm form-control', 'id' => 'updateUom', 'placeholder' => 'Enter Unit of Measure here.'])->label(false) ?>

                        <label class="labelStyle">Cost Price</label>
                        <?= $form->field($model, 'cost_price')->textInput(['class' => 'inputForm form-control', 'id' => 'updateCostPrice', 'placeholder' => 'Enter Cost Price here.'])->label(false) ?>
                    </div>

                    <div class="col-md-6 col-xs-6 col-sm-6">
                        <label class="labelStyle">Re-Order Level</label>
                        <?= $form->field($model, 'reorder_level')->textInput(['class' => 'inputForm form-control', 'id' => 'updateReorderLevel', 'placeholder' => 'Enter Re-Order Level here.'])->label(false) ?>

                        <label class="labelStyle">Gst Price</label>
                        <?= $form->field($model, 'gst_price')->textInput(['class' => 'inputForm form-control', 'id' => 'updateGstPrice', 'placeholder' => 'Enter Gst Price here.'])->label(false) ?>

                        <label class="labelStyle">Selling Price</label>
                        <?= $form->field($model, 'selling_price')->textInput(['class' => 'inputForm form-control', 'id' => 'updateSellingPrice', 'placeholder' => 'Enter Selling Price here.'])->label(false) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <label class="labelStyle">Remarks</label>
                        <?= $form->field($model, 'remarks')->textarea(['class' => 'inputForm form-control', 'id' => 'updateRemarks', 'rows' => 5, 'placeholder' => 'Enter Remarks here.'])->label(false) ?>
                    </div>
                </div>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="modal-footer">
            <?= Html::button('<li class=\'fa fa-refresh\'></li> Clear', ['id' => 'clearPartsForms', 'class' => 'formBtn btn btn-default']) ?>
            <?= Html::submitButton('<li class=\'fa fa-check\'></li> Save Record', ['id' => 'submitPartsFormUpdate', 'class' => 'formBtn btn btn-primary']) ?>
        </div>

        </div>
    </div>
</div>

<!-- View -->
<div class="modal fade modalBackground" id="modal-launcher-view-parts" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close closeViewParts" >&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-desktop"></i> View Parts Information</h5>
            </div>

            <div class="modal-body" id="viewPartsCategory">
                <!-- Information Content -->
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

<!-- Update Selected Qty -->
<div class="modal fade modalBackground" id="modal-launcher-updateqty-selected-parts" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close closeUpdateQtySelectedParts" >&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-edit"></i> Update Auto-Pars Quantity </h5>
            </div>

            <?php $form = ActiveForm::begin(['method' => 'post', 'id' => 'partsQtyFormUpdate']); ?>
            <div class="modal-body" id="viewSelectedParts">
                <!-- Information Content -->
            </div>
            <?php ActiveForm::end(); ?>

            <div class="modal-footer">
                <?= Html::submitButton('<li class=\'fa fa-check\'></li> Save Record', ['id' => 'submitPartsQtyFormUpdate', 'class' => 'formBtn btn btn-primary']) ?>
            </div>

        </div>
    </div>
</div>

<div class="modal fade modalBackground" id="modal-launcher-update-partsqty" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close closeUpdatePartsQty" >&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-edit"></i> Update Auto-Pars Quantity </h5>
            </div>

            <div class="modal-body">

            <form id="p-modal-form" class="p-modal-form" method="POST">
                
                <div style="font-size:11px;" id="parts_information" class="parts_information"></div>
                <input type="hidden" id="partsId" class="partsId" />
                <input type="hidden" id="partsOldQty" class="partsOldQty" />
                <input type="hidden" id="partsNewQty" class="partsNewQty" />

            </form>

            </div>

            <div class="modal-footer">
                <button type="button" id="modal-submit-partsqty" class="formBtn btn btn-primary"><i class="fa fa-save"></i> Save Record</button>
            </div>

        </div>
    </div>
</div>

<!-- Export to Excel -->
<a id="divLink" style="display: none;"></a>

</div>