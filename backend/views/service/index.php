<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use common\models\serviceCategory;

$dataServiceCategory = ArrayHelper::map(ServiceCategory::find()->where(['status' => 1])->all(),'id', 'name');
/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchService */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Services List';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="service-index divContainer">

<div class="row containerHeadWrapper">
    
    <div class="col-md-12 col-sm-12 col-xs-12">
        
        <div>
            <h4 class="divHeaderLabel"><i class="fa fa-battery-full"></i> <?= Html::encode($this->title) ?></h4>
        </div>
        <hr/>

    <?php  echo $this->render('_search', [
                            'model' => $searchModel, 'dataServiceCategory' => $dataServiceCategory ]); 
                        ?>    
    </div>

</div>
<br/>

<div class="row containerContentWrapper">
<?php
$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'service_category_id',
            'value' => 'serviceCategory.name',
            'label' => 'Service Category',
        ],
        'service_name',
        'description',
        'price',
    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{preview}{update}{delete}',
        'buttons' => [
            'preview' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-eye-open"></span> ', $url, ['class' => '_showViewServiceModal', 'id' => $model->id, 'title' => Yii::t('app', 'Preview'),
                ]);
            },
            'update' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-pencil"></span> ', $url, ['class' => '_showUpdateServiceModal', 'id' => $model->id, 'title' => Yii::t('app', 'Update'),
                ]);
            },
            'delete' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-trash"></span> ', $url, ['class' => 'serviceDeleteColumn', 'id' => $model->id, 'title' => Yii::t('app', 'Delete'),
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
        <?= Html::button('<li class=\'fa fa-user-plus\'></li> New Service -',['class' => '_showCreateServiceModal formBtn btn btn-block btn-success btn-sm']) ?>
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
            <?= Html::button('<li class=\'fa fa-download\'></li> Export to Excel -',['class' => 'formBtn btn btn-block btn-warning btn-xs', 'onclick' => "excelExportService()"]) ?>
        </div>
        <div class="col-md-6">
            <a href="?r=service/export-pdf"onclick="return pdfExport()" class="formBtn btn btn-block btn-danger btn-xs"><i class="fa fa-download"></i> Export to PDF -
            </a>
        </div>
    </div>

</div>
</div>
<br/><br/>

</div>

</div>

<!-- Create -->
<div class="modal fade modalBackground" id="modal-launcher-create-service" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close closeNewService" >&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-laptop"></i> New Service</h5>
            </div>

        <div class="modal-body">
            <?php $form = ActiveForm::begin(['method' => 'post', 'id' => 'serviceFormCreate']); ?>
                
                <label class="labelStyle">Service Category</label>
                <?= $form->field($model, 'service_category_id')->dropdownList(['0' => '- CHOOSE SERVICE CATEGORY HERE -'] + $dataServiceCategory,['style' => 'width: 100%;', 'class' => 'inputForm select2', 'id' => 'serviceCategory', 'data-placeholder' => 'PLEASE SELECT SERVICE CATEGORY HERE' ])->label(false) ?>

                <label class="labelStyle">Service Name</label>
                <?= $form->field($model, 'service_name')->textInput(['class' => 'inputForm form-control', 'id' => 'serviceName', 'placeholder' => 'Enter Service name here.'])->label(false) ?>

                <label class="labelStyle">Description</label>
                <?= $form->field($model, 'description')->textarea(['class' => 'inputForm form-control', 'id' => 'description', 'placeholder' => 'Enter Service description here.'])->label(false) ?>

                <label class="labelStyle">Price</label>
                <?= $form->field($model, 'price')->textInput(['class' => 'inputForm form-control', 'id' => 'price', 'placeholder' => 'Enter Price here.'])->label(false) ?>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="modal-footer">
            <?= Html::button('<li class=\'fa fa-refresh\'></li> Clear', ['id' => 'clearServiceForms', 'class' => 'formBtn btn btn-default']) ?>
            <?= Html::submitButton('<li class=\'fa fa-paper-plane-o\'></li> Submit Record', ['id' => 'submitServiceFormCreate', 'class' => 'formBtn btn btn-primary']) ?>
        </div>

        </div>
    </div>
</div>

<!-- Update -->
<div class="modal fade modalBackground" id="modal-launcher-update-service" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close closeUpdateService" >&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-edit"></i> Update Service</h5>
            </div>

        <div class="modal-body">
            <?php $form = ActiveForm::begin(['method' => 'post', 'id' => 'serviceFormUpdate']); ?>
                <input type="hidden" name="id" id="id" />

                <label class="labelStyle">Service Category</label>
                <?= $form->field($model, 'service_category_id')->dropdownList(['0' => '- CHOOSE SERVICE CATEGORY HERE -'] + $dataServiceCategory,['style' => 'width: 100%;', 'class' => 'inputForm select2', 'id' => 'updateServiceCategory', 'data-placeholder' => 'PLEASE SELECT SERVICE CATEGORY HERE' ])->label(false) ?>

                <label class="labelStyle">Service Name</label>
                <?= $form->field($model, 'service_name')->textInput(['class' => 'inputForm form-control', 'id' => 'updateServiceName', 'placeholder' => 'Enter Service name here.'])->label(false) ?>

                <label class="labelStyle">Description</label>
                <?= $form->field($model, 'description')->textarea(['class' => 'inputForm form-control', 'id' => 'updateDescription', 'placeholder' => 'Enter Service description here.'])->label(false) ?>

                <label class="labelStyle">Price</label>
                <?= $form->field($model, 'price')->textInput(['class' => 'inputForm form-control', 'id' => 'updatePrice', 'placeholder' => 'Enter Price here.'])->label(false) ?>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="modal-footer">
            <?= Html::button('<li class=\'fa fa-refresh\'></li> Clear', ['id' => 'clearServiceForms', 'class' => 'formBtn btn btn-default']) ?>
            <?= Html::submitButton('<li class=\'fa fa-paper-plane-o\'></li> Save Record', ['id' => 'submitServiceFormUpdate', 'class' => 'formBtn btn btn-primary']) ?>
        </div>

        </div>
    </div>
</div>

<!-- View -->
<div class="modal fade modalBackground" id="modal-launcher-view-service" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close closeViewService" >&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-desktop"></i> View Service Information</h5>
            </div>

            <div class="modal-body" id="viewService">
                <!-- Information Content -->
            </div>

            <div class="modal-footer">
            <?= Html::button('<li class=\'fa fa-minus-square\'></li> Close', ['id' => 'closeServiceForms', 'class' => 'formBtn btn btn-default']) ?>
            </div>

        </div>
    </div>
</div>

<!-- Export to Excel -->
<a id="divLink" style="display: none;"></a>

</div>