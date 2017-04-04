<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\ProductCategory;

$dataProductCategory = ArrayHelper::map(ProductCategory::find()->all(),'id', 'name');

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
    ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'product_category_id',
            'value' => 'productCategory.name',
            'label' => 'Product Category',
        ],
        'product_code',
        'description',
        'unit_of_measure',
    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{preview}{update}{delete}',
        'buttons' => [
            'preview' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-eye-open"></span> ', $url, ['class' => '_showViewProductModal', 'id' => $model->id, 'title' => Yii::t('app', 'Preview'),
                ]);
            },
            'update' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-pencil"></span> ', $url, ['class' => '_showUpdateProductModal', 'id' => $model->id, 'title' => Yii::t('app', 'Update'),
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
        <?= Html::button('<li class=\'fa fa-plus-square\'></li> New Product',['class' => '_showCreateProductModal formBtn btn btn-block btn-success btn-xs']) ?>
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
<div class="modal fade" id="modal-launcher-create-product" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-user-plus"></i> New Product Information</h5>
            </div>

        <div class="modal-body">
            <?php $form = ActiveForm::begin(['method' => 'post', 'id' => 'productFormCreate']); ?>
                
                <label class="labelStyle">Product Code</label>
                <?= $form->field($model, 'product_code')->textInput(['class' => 'inputForm form-control', 'id' => 'productCode', 'value' => $productCode, 'placeholder' => 'Enter Product code here.', 'readonly' => 'readonly'])->label(false) ?>

                <label class="labelStyle">Product Category</label>
                <?= $form->field($model, 'product_category_id')->dropdownList($dataProductCategory,['style' => 'width: 100%;', 'class' => 'inputForm select2', 'id' => 'productCategory'])->label(false) ?>

                <label class="labelStyle">Product Name</label>
                <?= $form->field($model, 'product_name')->textInput(['class' => 'inputForm form-control', 'id' => 'productName', 'placeholder' => 'Enter Product name here.'])->label(false) ?>

                <label class="labelStyle">Description</label>
                <?= $form->field($model, 'description')->textarea(['class' => 'inputForm form-control', 'id' => 'description', 'placeholder' => 'Enter Product description here.'])->label(false) ?>

                <label class="labelStyle">Unit of Measure</label>
                <?= $form->field($model, 'unit_of_measure')->textInput(['class' => 'inputForm form-control', 'id' => 'uom', 'placeholder' => 'Enter Unit of Measure here.'])->label(false) ?>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="modal-footer">
            <?= Html::button('<li class=\'fa fa-refresh\'></li> Clear', ['id' => 'clearProductForms', 'class' => 'formBtn btn btn-default']) ?>
            <?= Html::submitButton('<li class=\'fa fa-check\'></li> Submit', ['id' => 'submitProductFormCreate', 'class' => 'formBtn btn btn-primary']) ?>
        </div>

        </div>
    </div>
</div>

<!-- Update -->
<div class="modal fade" id="modal-launcher-update-product" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-edit"></i> Update Product Information</h5>
            </div>

        <div class="modal-body">
            <?php $form = ActiveForm::begin(['method' => 'post', 'id' => 'productFormUpdate']); ?>
                <input type="hidden" name="id" id="id" />

                <label class="labelStyle">Product Code</label>
                <?= $form->field($model, 'product_code')->textInput(['class' => 'inputForm form-control', 'id' => 'updateProductCode', 'placeholder' => 'Enter Product code here.', 'readonly' => 'readonly'])->label(false) ?>

                <label class="labelStyle">Product Category</label>
                <?= $form->field($model, 'product_category_id')->dropdownList($dataProductCategory,['style' => 'width: 100%;', 'class' => 'inputForm select2', 'id' => 'updateProductCategory'])->label(false) ?>

                <label class="labelStyle">Product Name</label>
                <?= $form->field($model, 'product_name')->textInput(['class' => 'inputForm form-control', 'id' => 'updateProductName', 'placeholder' => 'Enter Product name here.'])->label(false) ?>

                <label class="labelStyle">Description</label>
                <?= $form->field($model, 'description')->textarea(['class' => 'inputForm form-control', 'id' => 'updateDescription', 'placeholder' => 'Enter Product description here.'])->label(false) ?>

                <label class="labelStyle">Unit of Measure</label>
                <?= $form->field($model, 'unit_of_measure')->textInput(['class' => 'inputForm form-control', 'id' => 'updateUom', 'placeholder' => 'Enter Unit of Measure here.'])->label(false) ?>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="modal-footer">
            <?= Html::button('<li class=\'fa fa-refresh\'></li> Clear', ['id' => 'clearProductForms', 'class' => 'formBtn btn btn-default']) ?>
            <?= Html::submitButton('<li class=\'fa fa-check\'></li> Submit', ['id' => 'submitProductFormUpdate', 'class' => 'formBtn btn btn-primary']) ?>
        </div>

        </div>
    </div>
</div>

<!-- View -->
<div class="modal fade" id="modal-launcher-view-product" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
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

<!-- Export to Excel -->
<a id="divLink" style="display: none;"></a>

</div>