<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use common\models\Product;
use common\models\Supplier;
use common\models\ProductCategory;
use yii\db\Query;

$rows = new Query();

$dataProductCategory = ArrayHelper::map(ProductCategory::find()->where(['status' => 1])->all(),'id', 'name');
$dataSupplier = ArrayHelper::map(Supplier::find()->where(['status' => 1])->all(),'id', 'name');
$dataStorageLocation = ArrayHelper::map(
                    $rows->select(['concat("[ ", rack," ] ",bay," - ",level," - ",position) as slName', 'id'])
                    ->from('storage_location')->where(['status' => 1])->all(),
                'id', 'slName');

$dataProduct = ArrayHelper::map(Product::find()->where(['status' => 1])->all(),'id', 'product_name');
$supplierCode = 'SUPPLIERS' . '-' .  date('Y') . '-' .  substr(uniqid('', true), -5);

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchProductInventory */
/* @var $dataProvider yii\data\ActiveDataProvider */

$productCode = 'PRODUCT' . '-' .  date('Y') . '-' .  substr(uniqid('', true), -5);

$this->title = 'Product Inventory';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="product-inventory-index divContainer">

<div class="row containerHeadWrapper">
    
    <div class="col-md-12 col-sm-12 col-xs-12">
        
        <div>
            <h4 class="divHeaderLabel"><i class="fa fa-cubes"></i> <?= Html::encode($this->title) ?></h4>
        </div>
        <hr/>

    <?php  echo $this->render('_search', [
                            'model' => $searchModel, 
                            'dataProduct' => $dataProduct,
                            'dataSupplier' => $dataSupplier,
                         ]); 
                    ?>    
    </div>

</div>
<br/>

<div class="row containerContentWrapper">
<div class="row containerContentWrapper">
<?php
$gridColumns = [

    [
        'class' => 'yii\grid\SerialColumn',
        'options' => ['style' => 'color: #444']
    ],
        [
            'label' => 'INVENTORY TYPE',
            'options' => ['style' => 'color: #444'],
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
            'attribute' => 'product_name',
            'value' => 'product.product_name',
            'header' => 'PRODUCT NAME',
            'options' => ['style' => 'color: #444']
        ],
        [
            'label' => 'OLD QUANTITY',
            'value' => 'old_quantity',
            'options' => ['style' => 'color: #444']
        ],
        [
            'label' => 'NEW QUANTITY',
            'value' => 'new_quantity',
            'options' => ['style' => 'color: #444']
        ],
]
?>

<div class="col-md-12 col-sm-12 col-xs-12 btnsContainer">
<div class="row">

    <div class="col-md-2 pull-right">  
        <?= Html::button('<li class=\'fa fa-cogs\'></li> New Product -',['class' => '_showCreateProductModal formBtn btn btn-block btn-success btn-sm']) ?>
    </div>

    <div class="col-md-2 pull-right">  
        <?= Html::button('<li class=\'fa fa-cog\'></li> New Category -',['class' => '_showCreatePRCModal formBtn btn btn-block btn-info btn-sm']) ?>
    </div>

    <div class="col-md-2 pull-right">  
        <?= Html::button('<li class=\'fa fa-truck\'></li> New Supplier -',['class' => '_showCreateSupplierModal formBtn btn btn-block btn-danger btn-sm']) ?>
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
            <?= Html::button('<li class=\'fa fa-download\'></li> Export to Excel',['class' => 'formBtn btn btn-block btn-warning btn-xs', 'onclick' => "excelExportPRI()"]) ?>
        </div>
        <div class="col-md-6">
            <a href="?r=product-inventory/export-pdf"onclick="return pdfExport()" class="formBtn btn btn-block btn-danger btn-xs"><i class="fa fa-download"></i> Export to PDF
            </a>
        </div>
    </div>

</div>
</div>
<br/><br/>

</div>

</div>

<!-- Create Product -->
<div class="modal fade modalBackground" id="modal-launcher-create-product" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close closeNewProduct" >&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-user-plus"></i> New Product </h5>
            </div>

        <div class="modal-body">
            <?php $form = ActiveForm::begin(['method' => 'post', 'id' => 'productFormCreate']); ?>
                
                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <label class="labelStyle">Storage Location</label>
                        <?= $form->field($productModel, 'storage_location_id')->dropdownList(['0' => '- CHOOSE STORAGE LOCATION HERE -'] + $dataStorageLocation,['style' => 'width: 100%;', 'class' => 'inputForm select2', 'id' => 'storageLocation', 'data-placeholder' => 'PLEASE SELECT STORAGE LOCATION HERE' ])->label(false) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <label class="labelStyle">Supplier Name</label>
                        <?= $form->field($productModel, 'supplier_id')->dropdownList(['0' => '- CHOOSE SUPPLIER HERE -'] + $dataSupplier,['style' => 'width: 100%;', 'class' => 'inputForm select2', 'id' => 'supplier', 'data-placeholder' => 'PLEASE SELECT SUPPLIER HERE' ])->label(false) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <label class="labelStyle">Product Code</label>
                        <?= $form->field($productModel, 'product_code')->textInput(['class' => 'inputForm form-control', 'id' => 'productCode', 'value' => $productCode, 'readonly' => 'readonly'])->label(false) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <label class="labelStyle">Product Category</label>
                        <?= $form->field($productModel, 'product_category_id')->dropdownList(['0' => '- CHOOSE PRODUCT CATEGORY HERE -'] + $dataProductCategory,['style' => 'width: 100%;', 'class' => 'inputForm select2', 'id' => 'productCategory', 'data-placeholder' => 'PLEASE SELECT CATEGORY HERE' ])->label(false) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <label class="labelStyle">Product Name</label>
                        <?= $form->field($productModel, 'product_name')->textInput(['class' => 'inputForm form-control', 'id' => 'productName', 'placeholder' => 'Enter Product name here.'])->label(false) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-xs-6 col-sm-6">
                        <label class="labelStyle">Quantity</label>
                        <?= $form->field($productModel, 'quantity')->textInput(['class' => 'inputForm form-control', 'id' => 'quantity', 'placeholder' => 'Enter Quantity here.'])->label(false) ?>

                        <label class="labelStyle">Unit of Measure</label>
                        <?= $form->field($productModel, 'unit_of_measure')->textInput(['class' => 'inputForm form-control', 'id' => 'uom', 'placeholder' => 'Enter Unit of Measure here.'])->label(false) ?>
                        
                        <label class="labelStyle">Cost Price</label>
                        <?= $form->field($productModel, 'cost_price')->textInput(['class' => 'inputForm form-control', 'id' => 'costPrice', 'placeholder' => 'Enter Cost Price here.'])->label(false) ?>
                    </div>
                
                    <div class="col-md-6 col-xs-6 col-sm-6">
                        <label class="labelStyle">Re-Order Level</label>
                        <?= $form->field($productModel, 'reorder_level')->textInput(['class' => 'inputForm form-control', 'id' => 'reorderLevel', 'placeholder' => 'Enter Re-Order Level here.'])->label(false) ?>

                        <label class="labelStyle">Gst Price</label>
                        <?= $form->field($productModel, 'gst_price')->textInput(['class' => 'inputForm form-control', 'id' => 'gstPrice', 'placeholder' => 'Enter Gst Price here.'])->label(false) ?>

                        <label class="labelStyle">Selling Price</label>
                        <?= $form->field($productModel, 'selling_price')->textInput(['class' => 'inputForm form-control', 'id' => 'sellingPrice', 'placeholder' => 'Enter Selling Price here.'])->label(false) ?>
                    </div>
                </div>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="modal-footer">
            <?= Html::button('<li class=\'fa fa-refresh\'></li> Clear', ['id' => 'clearProductForms', 'class' => 'formBtn btn btn-default']) ?>
            <?= Html::submitButton('<li class=\'fa fa-check\'></li> Submit Record', ['id' => 'submitProductFormCreate', 'class' => 'formBtn btn btn-primary']) ?>
        </div>

        </div>
    </div>
</div>

<!-- Create Product Category -->
<div class="modal fade modalBackground" id="modal-launcher-create-prc" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close closeNewPrc" >&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-user-plus"></i> New Product Category </h5>
            </div>

        <div class="modal-body">
            <?php $form = ActiveForm::begin(['method' => 'post', 'id' => 'prcFormCreate']); ?>
    
                <label class="labelStyle">Product Category Name</label>
                <?= $form->field($prcModel, 'name')->textInput(['class' => 'inputForm form-control', 'id' => 'name', 'placeholder' => 'Enter Product Category name here.'])->label(false) ?>

                <label class="labelStyle">Description</label>
                <?= $form->field($prcModel, 'description')->textarea(['class' => 'inputForm form-control', 'id' => 'description', 'placeholder' => 'Enter Product Category description here.'])->label(false) ?>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="modal-footer">
            <?= Html::button('<li class=\'fa fa-refresh\'></li> Clear', ['id' => 'clearPRCForms', 'class' => 'formBtn btn btn-default']) ?>
            <?= Html::submitButton('<li class=\'fa fa-check\'></li> Submit Record', ['id' => 'submitPRCFormCreate', 'class' => 'formBtn btn btn-primary']) ?>
        </div>

        </div>
    </div>
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


<!-- Export to Excel -->
<a id="divLink" style="display: none;"></a>

</div>