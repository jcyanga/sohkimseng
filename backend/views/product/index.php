<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\db\Query;

use common\models\ProductCategory;
use common\models\Supplier;

$rows = new Query();

$dataProductCategory = ArrayHelper::map(ProductCategory::find()->where(['status' => 1])->all(),'id', 'name');
$dataSupplier = ArrayHelper::map(Supplier::find()->where(['status' => 1])->all(),'id', 'name');
$dataStorageLocation = ArrayHelper::map(
                    $rows->select(['concat("[ ", rack," ] ",bay," - ",level," - ",position) as slName', 'id'])
                    ->from('storage_location')->where(['status' => 1])->all(),
                'id', 'slName');

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchProduct */
/* @var $dataProvider yii\data\ActiveDataProvider */

$productCode = 'PRODUCT' . '-' .  date('Y') . '-' .  substr(uniqid('', true), -5);

$this->title = 'Product List';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="product-index divContainer">

<div class="row containerHeadWrapper">
    
    <div class="col-md-12 col-sm-12 col-xs-12">
        
        <div>
            <h4 class="divHeaderLabel"><i class="fa fa-cubes"></i> <?= Html::encode($this->title) ?></h4>
        </div>
        <hr/>

    <?php  echo $this->render('_search', [
                            'model' => $searchModel, 'dataProductCategory' => $dataProductCategory ]); 
                        ?>    
    </div>

</div>
<br/>

<div class="row containerContentWrapper">
<?php
$gridColumns = [
    [
        'class' => 'yii\grid\CheckboxColumn',
        'checkboxOptions' => ['value' => $model->id, 'class' => 'productSelected', 'id' => 'productSelected' ],
        'header' => '<span class="glyphicon glyphicon-check"></span>' 
    ],

    ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'supplier_id',
            'value' => 'supplier.name',
            'label' => 'Supplier',
        ],

        [
            'attribute' => 'product_category_id',
            'value' => 'productCategory.name',
            'label' => 'Category',
        ],

            'product_code',
            'product_name',
            'quantity',
            'selling_price',

        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{preview}{update}{changeqty}{delete}',
            'buttons' => [
                'preview' => function ($url, $model) {
                    return Html::a(' <span class="glyphicon glyphicon-eye-open"></span> ', $url, ['class' => '_showViewProductModal', 'id' => $model->id, 'title' => Yii::t('app', 'Preview'),
                    ]);
                },
                'update' => function ($url, $model) {
                    return Html::a(' <span class="glyphicon glyphicon-pencil"></span> ', $url, ['class' => '_showUpdateProductModal', 'id' => $model->id, 'title' => Yii::t('app', 'Update'),
                    ]);
                },
                'changeqty' => function ($url, $model) {
                    return Html::a(' <span class="glyphicon glyphicon-hourglass"></span> ', $url, ['class' => '_showUpdateProductQtyModal', 'id' => $model->id, 'title' => Yii::t('app', 'ChangeQty'),
                    ]);
                },
                'delete' => function ($url, $model) {
                    return Html::a(' <span class="glyphicon glyphicon-trash"></span> ', $url, ['class' => 'productDeleteColumn', 'id' => $model->id, 'title' => Yii::t('app', 'Delete'),
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
        <?= Html::button('<li class=\'fa fa-user-plus\'></li> New Product -',['class' => '_showCreateProductModal formBtn btn btn-block btn-success btn-sm']) ?>
    </div>

    <div class="col-md-2 pull-right">  
        <?= Html::button('<li class=\'fa fa-edit\'></li> Update Product Qty -',['class' => '_showUpdateQtySelectedProductModal formBtn btn btn-block btn-info btn-sm']) ?>
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
            <?= Html::button('<li class=\'fa fa-download\'></li> Export to Excel',['class' => 'formBtn btn btn-block btn-warning btn-xs', 'onclick' => "excelExportProduct()"]) ?>
        </div>
        <div class="col-md-6">
            <a href="?r=product/export-pdf"onclick="return pdfExport()" class="formBtn btn btn-block btn-danger btn-xs"><i class="fa fa-download"></i> Export to PDF
            </a>
        </div>
    </div>

</div>
</div>
<br/><br/>

</div>

</div>

<!-- Create -->
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
                        <label class="labelStyle">Product Code</label>
                        <?= $form->field($model, 'product_code')->textInput(['class' => 'inputForm form-control', 'id' => 'productCode', 'value' => $productCode, 'readonly' => 'readonly'])->label(false) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <label class="labelStyle">Product Category</label>
                        <?= $form->field($model, 'product_category_id')->dropdownList(['0' => '- CHOOSE PRODUCT CATEGORY HERE -'] + $dataProductCategory,['style' => 'width: 100%;', 'class' => 'inputForm select2', 'id' => 'productCategory', 'data-placeholder' => 'PLEASE SELECT CATEGORY HERE' ])->label(false) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <label class="labelStyle">Product Name</label>
                        <?= $form->field($model, 'product_name')->textInput(['class' => 'inputForm form-control', 'id' => 'productName', 'placeholder' => 'Enter Product name here.'])->label(false) ?>
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

            <?php ActiveForm::end(); ?>
        </div>

        <div class="modal-footer">
            <?= Html::button('<li class=\'fa fa-refresh\'></li> Clear', ['id' => 'clearProductForms', 'class' => 'formBtn btn btn-default']) ?>
            <?= Html::submitButton('<li class=\'fa fa-check\'></li> Submit Record', ['id' => 'submitProductFormCreate', 'class' => 'formBtn btn btn-primary']) ?>
        </div>

        </div>
    </div>
</div>

<!-- Update -->
<div class="modal fade modalBackground" id="modal-launcher-update-product" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close closeUpdateProduct" >&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-edit"></i> Update Product </h5>
            </div>

        <div class="modal-body">
            <?php $form = ActiveForm::begin(['method' => 'post', 'id' => 'productFormUpdate']); ?>
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
                        <label class="labelStyle">Product Code</label>
                        <?= $form->field($model, 'product_code')->textInput(['class' => 'inputForm form-control', 'id' => 'updateProductCode', 'value' => $productCode, 'readonly' => 'readonly'])->label(false) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <label class="labelStyle">Product Category</label>
                        <?= $form->field($model, 'product_category_id')->dropdownList(['0' => '- CHOOSE PRODUCT CATEGORY HERE -'] + $dataProductCategory,['style' => 'width: 100%;', 'class' => 'inputForm select2', 'id' => 'updateProductCategory', 'data-placeholder' => 'PLEASE SELECT CATEGORY HERE' ])->label(false) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <label class="labelStyle">Product Name</label>
                        <?= $form->field($model, 'product_name')->textInput(['class' => 'inputForm form-control', 'id' => 'updateProductName', 'placeholder' => 'Enter Product name here.'])->label(false) ?>
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

            <?php ActiveForm::end(); ?>
        </div>

        <div class="modal-footer">
            <?= Html::button('<li class=\'fa fa-refresh\'></li> Clear', ['id' => 'clearProductForms', 'class' => 'formBtn btn btn-default']) ?>
            <?= Html::submitButton('<li class=\'fa fa-check\'></li> Save Record', ['id' => 'submitProductFormUpdate', 'class' => 'formBtn btn btn-primary']) ?>
        </div>

        </div>
    </div>
</div>

<!-- View -->
<div class="modal fade modalBackground" id="modal-launcher-view-product" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close closeViewProduct" >&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-desktop"></i> View Product Information</h5>
            </div>

            <div class="modal-body" id="viewProduct">
                <!-- Information Content -->
            </div>

            <div class="modal-footer">
            <?= Html::button('<li class=\'fa fa-minus-square\'></li> Close', ['id' => 'closeProductForms', 'class' => 'formBtn btn btn-default']) ?>
            </div>

        </div>
    </div>
</div>

<!-- Update Selected Qty -->
<div class="modal fade modalBackground" id="modal-launcher-updateqty-selected-product" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close closeUpdateQtySelectedProduct" >&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-edit"></i> Update Product Quantity </h5>
            </div>

            <?php $form = ActiveForm::begin(['method' => 'post', 'id' => 'productQtyFormUpdate']); ?>
            <div class="modal-body" id="viewSelectedProduct">
                <!-- Information Content -->
            </div>
            <?php ActiveForm::end(); ?>

            <div class="modal-footer">
                <?= Html::submitButton('<li class=\'fa fa-check\'></li> Save Record', ['id' => 'submitProductQtyFormUpdate', 'class' => 'formBtn btn btn-primary']) ?>
            </div>

        </div>
    </div>
</div>

<div class="modal fade modalBackground" id="modal-launcher-update-productqty" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close closeUpdateProductQty" >&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-edit"></i> Update Product Quantity </h5>
            </div>

            <div class="modal-body">

            <form id="product-modal-form" class="product-modal-form" method="POST">
                
                <div style="font-size:11px;" id="product_information" class="product_information"></div>
                <input type="hidden" id="productId" class="productId" />
                <input type="hidden" id="productOldQty" class="productOldQty" />
                <input type="hidden" id="productNewQty" class="productNewQty" />

            </form>

            </div>

            <div class="modal-footer">
                <button type="button" id="modal-submit-productqty" class="formBtn btn btn-primary"><i class="fa fa-save"></i> Save Record</button>
            </div>

        </div>
    </div>
</div>

<!-- Export to Excel -->
<a id="divLink" style="display: none;"></a>

</div>