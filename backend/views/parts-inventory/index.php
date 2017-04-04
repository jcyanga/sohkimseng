<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use  yii\helpers\ArrayHelper;

use common\models\Parts;
use common\models\Supplier;

$dataParts = ArrayHelper::map(Parts::find()->all(),'id', 'parts_name');
$dataSupplier = ArrayHelper::map(Supplier::find()->all(),'id', 'name');

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
            'attribute' => 'supplier_id',
            'value' => 'supplier.name',
            'label' => 'Supplier Name',
        ],
        [
            'attribute' => 'parts_id',
            'value' => 'parts.parts_name',
            'label' => 'Parts Name',
        ],
        'quantity',
        'price',
    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{update}{delete}',
        'buttons' => [
            'update' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-pencil"></span> ', $url, ['class' => '_showUpdatePIModal', 'id' => $model->id, 'title' => Yii::t('app', 'Update'),
                ]);
            },        
            'delete' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-trash"></span> ', $url, ['class' => 'piDeleteColumn', 'id' => $model->id, 'title' => Yii::t('app', 'Delete'),
                ]);
            },
        ],
        'urlCreator' => function ($action, $model, $key, $index) {
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

    <div class="col-md-3 pull-right">  
        <?= Html::button('<li class=\'fa fa-plus-square\'></li> New Auto-Parts in Inventory',['class' => '_showCreatePIModal formBtn btn btn-block btn-success btn-xs']) ?>
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

<!-- Create -->
<div class="modal fade" id="modal-launcher-create-pi" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog modalInventoryDesign" >
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-user-plus"></i> New Auto-Parts in Inventory Information</h5>
            </div>

        <div class="modal-body">
            <?php $form = ActiveForm::begin(['method' => 'post', 'id' => 'piFormCreate']); ?>
                
                <div class="row">
                    
                    <div class="col-md-4 modalInventoryDesignRside">
                        
                        <label class="labelStyle">Supplier Name</label>
                        <?= $form->field($model, 'supplier_id')->dropdownList($dataSupplier,['style' => 'width: 100%;', 'class' => 'inputForm select2', 'id' => 'supplier'])->label(false) ?>

                        <label class="labelStyle">Auto-Parts Name</label>
                        <?= $form->field($model, 'parts_id')->dropdownList($dataParts,['style' => 'width: 100%;', 'class' => 'inputForm select2', 'id' => 'parts'])->label(false) ?>

                        <label class="labelStyle">Quantity</label>
                        <?= $form->field($model, 'quantity')->textInput(['class' => 'inputForm form-control', 'id' => 'quantity', 'placeholder' => 'Enter Quantity here.'])->label(false) ?>

                        <label class="labelStyle">Price</label>
                        <?= $form->field($model, 'price')->textInput(['class' => 'inputForm form-control', 'id' => 'price', 'placeholder' => 'Enter Price here.'])->label(false) ?>

                        <input type="hidden" id="ctr" value="0" />
                        
                        <div class="pull-right">
                            <button type="button" class=" formBtn btn btn-link add_item" ><i class="fa fa-cart-plus"></i> <b>Add Item</b> </button>
                        </div>
                        <br/>

                    </div>

                    <div class="col-md-8 modalInventoryDesignLside">
                        <div class="insert-in-list selectedItemContainer" id="insert-in-list">
                        <div class="selectedItemContent">
                           <i class="fa fa-list-alt"></i> Selected Item in List
                        </div>  
                        <hr/>

                        </div>
                    </div>

                </div>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="modal-footer">
            <?= Html::button('<li class=\'fa fa-refresh\'></li> Clear', ['id' => 'clearPIForms', 'class' => 'formBtn btn btn-default']) ?>
            <?= Html::submitButton('<li class=\'fa fa-check\'></li> Submit', ['id' => 'submitPIFormCreate', 'class' => 'formBtn btn btn-primary']) ?>
        </div>

        </div>
    </div>
</div>

<!-- Update -->
<div class="modal fade" id="modal-launcher-update-pi" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-edit"></i> Update Auto-Parts in Inventory Information</h5>
            </div>

        <div class="modal-body">
            <?php $form = ActiveForm::begin(['method' => 'post', 'id' => 'piFormUpdate']); ?>
                <input type="hidden" name="id" id="id" />

                <label class="labelStyle">Supplier Name</label>
                <?= $form->field($model, 'supplier_id')->dropdownList($dataSupplier,['style' => 'width: 100%;', 'class' => 'inputForm select2', 'id' => 'updateSupplier'])->label(false) ?>

                <label class="labelStyle">Auto-Parts Name</label>
                <?= $form->field($model, 'parts_id')->dropdownList($dataParts,['style' => 'width: 100%;', 'class' => 'inputForm select2', 'id' => 'updateParts'])->label(false) ?>

                <label class="labelStyle">Quantity</label>
                <?= $form->field($model, 'quantity')->textInput(['class' => 'inputForm form-control', 'id' => 'updateQuantity', 'placeholder' => 'Enter Quantity here.'])->label(false) ?>

                <label class="labelStyle">Price</label>
                <?= $form->field($model, 'price')->textInput(['class' => 'inputForm form-control', 'id' => 'updatePrice', 'placeholder' => 'Enter Price here.'])->label(false) ?>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="modal-footer">
            <?= Html::button('<li class=\'fa fa-refresh\'></li> Clear', ['id' => 'clearPIForms', 'class' => 'formBtn btn btn-default']) ?>
            <?= Html::submitButton('<li class=\'fa fa-check\'></li> Submit', ['id' => 'submitPIFormUpdate', 'class' => 'formBtn btn btn-primary']) ?>
        </div>

        </div>
    </div>
</div>

<!-- Export to Excel -->
<a id="divLink" style="display: none;"></a>

</div>