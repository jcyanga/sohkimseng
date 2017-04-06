<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use  yii\helpers\ArrayHelper;

use common\models\Parts;
use common\models\PartsCategory;
use common\models\Supplier;

$dataParts = ArrayHelper::map(Parts::find()->where(['status' => 1])->all(),'id', 'parts_name');
$dataPartsCategory = ArrayHelper::map(PartsCategory::find()->where(['status' => 1])->all(),'id', 'name');
$dataSupplier = ArrayHelper::map(Supplier::find()->where(['status' => 1])->all(),'id', 'name');

$supplierCode = 'SUPPLIERS' . '-' .  date('Y') . '-' .  substr(uniqid('', true), -5);
$partsCode = 'PARTS' . '-' .  date('Y') . '-' .  substr(uniqid('', true), -5);

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchPartsInventory */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Parts Inventory';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="parts-inventory-index divContainer">

<div class="row containerHeadWrapper">
    
    <div class="col-md-12 col-sm-12 col-xs-12">
        
        <div>
            <h4 class="divHeaderLabel"><i class="fa fa-cogs"></i> <?= Html::encode($this->title) ?></h4>
        </div>
        <hr/>

    <?php  echo $this->render('_search', [
                            'model' => $searchModel, 
                            'dataParts' => $dataParts,
                            'dataSupplier' => $dataSupplier,
                         ]); 
                    ?>    
    </div>

</div>
<br/>

<div class="row containerContentWrapper">
<?php
$gridColumns = [

    ['class' => 'yii\grid\SerialColumn'],
        [
            'label' => 'Type',
            'value' => function($model)
            {   
                switch($model->type){
                    case 1:
                        return 'Stock-In';
                    break;

                    case 2:
                        return 'Stock-Out';
                    break;

                    case 3:
                        return 'Stock-Adjustment';
                    break;

                    default:
                        return 'No Record Found';
                }
            },
        ],

        [
            'attribute' => 'parts_name',
            'value' => 'parts.parts_name',
            'label' => 'Parts Name',
        ],
        'old_quantity',
        'new_quantity',
]
?>

<div class="col-md-12 col-sm-12 col-xs-12 btnsContainer">
<div class="row">

    <div class="col-md-2 pull-right">  
        <?= Html::button('<li class=\'fa fa-cogs\'></li> New Auto-Parts -',['class' => '_showCreatePartsModal formBtn btn btn-block btn-success btn-sm']) ?>
    </div>

    <div class="col-md-2 pull-right">  
        <?= Html::button('<li class=\'fa fa-cog\'></li> New Auto-Parts Category -',['class' => '_showCreatePCModal formBtn btn btn-block btn-info btn-sm']) ?>
    </div>

    <div class="col-md-2 pull-right">  
        <?= Html::button('<li class=\'fa fa-truck\'></li> New Supplier -',['class' => '_showCreateSupplierModal formBtn btn btn-block btn-danger btn-sm']) ?>
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
            <?= Html::button('<li class=\'fa fa-download\'></li> Export to Excel',['class' => 'formBtn btn btn-block btn-warning btn-xs', 'onclick' => "excelExportPI()"]) ?>
        </div>
        <div class="col-md-6">
            <a href="?r=parts-inventory/export-pdf"onclick="return pdfExport()" class="formBtn btn btn-block btn-danger btn-xs"><i class="fa fa-download"></i> Export to PDF
            </a>
        </div>
    </div>

</div>
</div>
<br/><br/>

</div>

</div>

<!-- Export to Excel -->
<a id="divLink" style="display: none;"></a>

</div>

<!-- Create Supplier -->
<div class="modal fade modalBackground" id="modal-launcher-create-supplier" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close closeNewSupplier" >&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-laptop"></i> New Supplier </h5>
            </div>

        <div class="modal-body">
            <?php $form = ActiveForm::begin(['method' => 'post', 'id' => 'supplierFormCreate']); ?>
    
                <label class="labelStyle">Supplier Code</label>
                <?= $form->field($supplierModel, 'supplier_code')->textInput(['class' => 'inputForm form-control', 'id' => 'supplierCode', 'value' => $supplierCode, 'readonly' => 'readonly'])->label(false) ?>

                <label class="labelStyle">Supplier Name</label>
                <?= $form->field($supplierModel, 'name')->textInput(['class' => 'inputForm form-control', 'id' => 'name', 'placeholder' => 'Enter Supplier name here.'])->label(false) ?>

                <label class="labelStyle">Address</label>
                <?= $form->field($supplierModel, 'address')->textarea(['rows' => '3', 'cols' => '2', 'class' => 'inputForm form-control', 'id' => 'address', 'placeholder' => 'Enter Address here.'])->label(false) ?>

                <label class="labelStyle">Contact Number</label>
                <?= $form->field($supplierModel, 'contact_number')->textInput(['class' => 'inputForm form-control', 'id' => 'contactNumber', 'placeholder' => 'Enter Contact number here.'])->label(false) ?>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="modal-footer">
            <?= Html::button('<li class=\'fa fa-refresh\'></li> Clear', ['id' => 'clearSupplierForms', 'class' => 'formBtn btn btn-default']) ?>
            <?= Html::submitButton('<li class=\'fa fa-paper-plane-o\'></li> Submit Record', ['id' => 'submitSupplierFormCreate', 'class' => 'formBtn btn btn-primary']) ?>
        </div>

        </div>
    </div>
</div>

<!-- Create Auto-Parts Category -->
<div class="modal fade modalBackground" id="modal-launcher-create-pc" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close closeNewPc" >&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-laptop"></i> New Auto-Parts Category</h5>
            </div>

        <div class="modal-body">
            <?php $form = ActiveForm::begin(['method' => 'post', 'id' => 'pcFormCreate']); ?>
    
                <label class="labelStyle">Auto-Parts Category Name</label>
                <?= $form->field($partscategoryModel, 'name')->textInput(['class' => 'inputForm form-control', 'id' => 'name', 'placeholder' => 'Enter Auto-Parts Category name here.'])->label(false) ?>

                <label class="labelStyle">Description</label>
                <?= $form->field($partscategoryModel, 'description')->textarea(['class' => 'inputForm form-control', 'id' => 'description', 'placeholder' => 'Enter Auto-Parts Category description here.'])->label(false) ?>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="modal-footer">
            <?= Html::button('<li class=\'fa fa-refresh\'></li> Clear', ['id' => 'clearPCForms', 'class' => 'formBtn btn btn-default']) ?>
            <?= Html::submitButton('<li class=\'fa fa-paper-plane-o\'></li> Submit Record', ['id' => 'submitPCFormCreate', 'class' => 'formBtn btn btn-primary']) ?>
        </div>

        </div>
    </div>
</div>

<!-- Create Auto-Parts -->
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
                        <label class="labelStyle">Auto-Parts Code</label>
                        <?= $form->field($partsModel, 'parts_code')->textInput(['class' => 'inputForm form-control', 'id' => 'partsCode', 'value' => $partsCode, 'readonly' => 'readonly'])->label(false) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <label class="labelStyle">Supplier Name</label>
                        <?= $form->field($partsModel, 'supplier_id')->dropdownList(['0' => '- CHOOSE SUPPLIER HERE -'] + $dataSupplier,['style' => 'width: 100%;', 'class' => 'inputForm select2', 'id' => 'supplier', 'data-placeholder' => 'PLEASE SELECT SUPPLIER HERE' ])->label(false) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <label class="labelStyle">Auto-Parts Category</label>
                        <?= $form->field($partsModel, 'parts_category_id')->dropdownList(['0' => '- CHOOSE AUTO-PARTS CATEGORY HERE -'] + $dataPartsCategory,['style' => 'width: 100%;', 'class' => 'inputForm select2', 'id' => 'partsCategory', 'data-placeholder' => 'PLEASE SELECT SUPPLIER HERE' ])->label(false) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <label class="labelStyle">Auto-Parts Name</label>
                        <?= $form->field($partsModel, 'parts_name')->textInput(['class' => 'inputForm form-control', 'id' => 'partsName', 'placeholder' => 'Enter Auto-Parts name here.'])->label(false) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-xs-6 col-sm-6">
                        <label class="labelStyle">Quantity</label>
                        <?= $form->field($partsModel, 'quantity')->textInput(['class' => 'inputForm form-control', 'id' => 'quantity', 'placeholder' => 'Enter Quantity here.'])->label(false) ?>

                        <label class="labelStyle">Unit of Measure</label>
                        <?= $form->field($partsModel, 'unit_of_measure')->textInput(['class' => 'inputForm form-control', 'id' => 'uom', 'placeholder' => 'Enter Unit of Measure here.'])->label(false) ?>
                        
                        <label class="labelStyle">Cost Price</label>
                        <?= $form->field($partsModel, 'cost_price')->textInput(['class' => 'inputForm form-control', 'id' => 'costPrice', 'placeholder' => 'Enter Cost Price here.'])->label(false) ?>
                    </div>
                
                    <div class="col-md-6 col-xs-6 col-sm-6">
                        <label class="labelStyle">Re-Order Level</label>
                        <?= $form->field($partsModel, 'reorder_level')->textInput(['class' => 'inputForm form-control', 'id' => 'reorderLevel', 'placeholder' => 'Enter Re-Order Level here.'])->label(false) ?>

                        <label class="labelStyle">Gst Price</label>
                        <?= $form->field($partsModel, 'gst_price')->textInput(['class' => 'inputForm form-control', 'id' => 'gstPrice', 'placeholder' => 'Enter Gst Price here.'])->label(false) ?>

                        <label class="labelStyle">Selling Price</label>
                        <?= $form->field($partsModel, 'selling_price')->textInput(['class' => 'inputForm form-control', 'id' => 'sellingPrice', 'placeholder' => 'Enter Selling Price here.'])->label(false) ?>
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