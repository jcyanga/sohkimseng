<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchSupplier */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Suppliers Maintenance';
$this->params['breadcrumbs'][] = $this->title;

$supplierCode = 'SUPPLIERS' . '-' .  date('Y') . '-' .  substr(uniqid('', true), -5);
?>

<div class="supplier-index divContainer">

<div class="row containerHeadWrapper">
    
    <div class="col-md-12 col-sm-12 col-xs-12">
        
        <div>
            <h4 class="divHeaderLabel"><i class="fa fa-truck"></i> <?= Html::encode($this->title) ?></h4>
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
        'supplier_code',
        'name',
        'address',
        'contact_number',
    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{preview}{update}{delete}',
        'buttons' => [
            'preview' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-eye-open"></span> ', $url, ['class' => '_showViewSupplierModal', 'id' => $model->id, 'title' => Yii::t('app', 'Preview'),
                ]);
            },
            'update' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-pencil"></span> ', $url, ['class' => '_showUpdateSupplierModal', 'id' => $model->id, 'title' => Yii::t('app', 'Update'),
                ]);
            },
            'delete' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-trash"></span> ', $url, ['class' => 'supplierDeleteColumn', 'id' => $model->id, 'title' => Yii::t('app', 'Delete'),
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
        <?= Html::button('<li class=\'fa fa-user-plus\'></li> New Supplier -',['class' => '_showCreateSupplierModal formBtn btn btn-block btn-success btn-sm']) ?>
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
            <?= Html::button('<li class=\'fa fa-download\'></li> Export to Excel -',['class' => 'formBtn btn btn-block btn-warning btn-xs', 'onclick' => "excelExportSupplier()"]) ?>
        </div>
        <div class="col-md-6">
            <a href="?r=supplier/export-pdf"onclick="return pdfExport()" class="formBtn btn btn-block btn-danger btn-xs">
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
                <?= $form->field($model, 'supplier_code')->textInput(['class' => 'inputForm form-control', 'id' => 'supplierCode', 'value' => $supplierCode, 'readonly' => 'readonly'])->label(false) ?>

                <label class="labelStyle">Supplier Name</label>
                <?= $form->field($model, 'name')->textInput(['class' => 'inputForm form-control', 'id' => 'name', 'placeholder' => 'Enter Supplier name here.'])->label(false) ?>

                <label class="labelStyle">Address</label>
                <?= $form->field($model, 'address')->textarea(['rows' => '3', 'cols' => '2', 'class' => 'inputForm form-control', 'id' => 'address', 'placeholder' => 'Enter Address here.'])->label(false) ?>

                <label class="labelStyle">Contact Number</label>
                <?= $form->field($model, 'contact_number')->textInput(['class' => 'inputForm form-control', 'id' => 'contactNumber', 'placeholder' => 'Enter Contact number here.'])->label(false) ?>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="modal-footer">
            <?= Html::button('<li class=\'fa fa-refresh\'></li> Clear', ['id' => 'clearSupplierForms', 'class' => 'formBtn btn btn-default']) ?>
            <?= Html::submitButton('<li class=\'fa fa-paper-plane-o\'></li> Submit Record', ['id' => 'submitSupplierFormCreate', 'class' => 'formBtn btn btn-primary']) ?>
        </div>

        </div>
    </div>
</div>

<!-- Update -->
<div class="modal fade modalBackground" id="modal-launcher-update-supplier" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close closeUpdateSupplier" >&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-edit"></i> Update Supplier </h5>
            </div>

        <div class="modal-body">
            <?php $form = ActiveForm::begin(['method' => 'post', 'id' => 'supplierFormUpdate']); ?>
                <input type="hidden" name="id" id="id" />

                <label class="labelStyle">Supplier Code</label>
                <?= $form->field($model, 'supplier_code')->textInput(['class' => 'inputForm form-control', 'id' => 'updateSupplierCode', 'readonly' => 'readonly'])->label(false) ?>

                <label class="labelStyle">Supplier Name</label>
                <?= $form->field($model, 'name')->textInput(['class' => 'inputForm form-control', 'id' => 'updateName', 'placeholder' => 'Enter Supplier name here.'])->label(false) ?>

                <label class="labelStyle">Address</label>
                <?= $form->field($model, 'address')->textarea(['rows' => '3', 'cols' => '2', 'class' => 'inputForm form-control', 'id' => 'updateAddress', 'placeholder' => 'Enter Address here.'])->label(false) ?>

                <label class="labelStyle">Contact Number</label>
                <?= $form->field($model, 'contact_number')->textInput(['class' => 'inputForm form-control', 'id' => 'updateContactNumber', 'placeholder' => 'Enter Contact number here.'])->label(false) ?>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="modal-footer">
            <?= Html::button('<li class=\'fa fa-refresh\'></li> Clear', ['id' => 'clearSupplierForms', 'class' => 'formBtn btn btn-default']) ?>
            <?= Html::submitButton('<li class=\'fa fa-paper-plane-o\'></li> Save Record', ['id' => 'submitSupplierFormUpdate', 'class' => 'formBtn btn btn-primary']) ?>
        </div>

        </div>
    </div>
</div>

<!-- View -->
<div class="modal fade modalBackground" id="modal-launcher-view-supplier" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close closeViewSupplier" >&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-desktop"></i> View Supplier Information</h5>
            </div>

            <div class="modal-body" id="viewSupplier">
                <!-- Information Content -->
            </div>

            <div class="modal-footer">
            <?= Html::button('<li class=\'fa fa-minus-square\'></li> Close', ['id' => 'closeSupplierForms', 'class' => 'formBtn btn btn-default']) ?>
            </div>

        </div>
    </div>
</div>

<!-- Export to Excel -->
<a id="divLink" style="display: none;"></a>

</div>