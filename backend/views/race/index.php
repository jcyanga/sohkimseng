<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchRace */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Race';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="race-index divContainer">

<div class="row containerHeadWrapper">
    
    <div class="col-md-12 col-sm-12 col-xs-12">
        
        <div>
            <h4 class="divHeaderLabel"><i class="fa fa-globe"></i> <?= Html::encode($this->title) ?></h4>
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
                return Html::a(' <span class="glyphicon glyphicon-eye-open"></span> ', $url, ['class' => '_showViewRaceModal', 'id' => $model->id, 'title' => Yii::t('app', 'Preview'),
                ]);
            },
            'update' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-pencil"></span> ', $url, ['class' => '_showUpdateRaceModal', 'id' => $model->id, 'title' => Yii::t('app', 'Update'),
                ]);
            },
            'delete' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-trash"></span> ', $url, ['class' => 'raceDeleteColumn', 'id' => $model->id, 'title' => Yii::t('app', 'Delete'),
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
        <?= Html::button('<li class=\'fa fa-user-plus\'></li> New Race -',['class' => '_showCreateRaceModal formBtn btn btn-block btn-success btn-sm']) ?>
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
            <?= Html::button('<li class=\'fa fa-download\'></li> Export to Excel',['class' => 'formBtn btn btn-block btn-warning btn-xs', 'onclick' => "excelExportRace()"]) ?>
        </div>
        <div class="col-md-6">
            <a href="?r=race/export-pdf"onclick="return pdfExport()" class="formBtn btn btn-block btn-danger btn-xs"><i class="fa fa-download"></i> Export to PDF
            </a>
        </div>
    </div>

</div>
</div>
<br/><br/>

</div>

</div>

<!-- Create -->
<div class="modal fade modalBackground" id="modal-launcher-create-race" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close closeNewRace" >&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-user-plus"></i> New Race </h5>
            </div>

        <div class="modal-body">
            <?php $form = ActiveForm::begin(['method' => 'post', 'id' => 'raceFormCreate']); ?>

                <label class="labelStyle">Race Name</label>
                <?= $form->field($model, 'name')->textInput(['class' => 'inputForm form-control', 'id' => 'name', 'placeholder' => 'Enter Race name here.'])->label(false) ?>

                <label class="labelStyle">Description</label>
                <?= $form->field($model, 'description')->textarea(['class' => 'inputForm form-control', 'id' => 'description', 'placeholder' => 'Enter Race description here.'])->label(false) ?>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="modal-footer">
            <?= Html::button('<li class=\'fa fa-refresh\'></li> Clear', ['id' => 'clearRaceForms', 'class' => 'formBtn btn btn-default']) ?>
            <?= Html::submitButton('<li class=\'fa fa-paper-plane-o\'></li> Submit Record', ['id' => 'submitRaceFormCreate', 'class' => 'formBtn btn btn-primary']) ?>
        </div>

        </div>
    </div>
</div>

<!-- Update -->
<div class="modal fade modalBackground" id="modal-launcher-update-race" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close closeUpdateRace" >&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-edit"></i> Update Race </h5>
            </div>

        <div class="modal-body">
            <?php $form = ActiveForm::begin(['method' => 'post', 'id' => 'raceFormUpdate']); ?>
                <input type="hidden" name="id" id="id" />

                <label class="labelStyle">Race Name</label>
                <?= $form->field($model, 'name')->textInput(['class' => 'inputForm form-control', 'id' => 'updateName', 'placeholder' => 'Enter Race name here.'])->label(false) ?>

                <label class="labelStyle">Description</label>
                <?= $form->field($model, 'description')->textarea(['class' => 'inputForm form-control', 'id' => 'updateDescription', 'placeholder' => 'Enter Race description here.'])->label(false) ?>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="modal-footer">
            <?= Html::button('<li class=\'fa fa-refresh\'></li> Clear', ['id' => 'clearRaceForms', 'class' => 'formBtn btn btn-default']) ?>
            <?= Html::submitButton('<li class=\'fa fa-paper-plane-o\'></li> Save Record', ['id' => 'submitRaceFormUpdate', 'class' => 'formBtn btn btn-primary']) ?>
        </div>

        </div>
    </div>
</div>

<!-- View -->
<div class="modal fade modalBackground" id="modal-launcher-view-race" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close closeViewRace" >&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-desktop"></i> View Race Information</h5>
            </div>

            <div class="modal-body" id="viewRace">
                <!-- Information Content -->
            </div>

            <div class="modal-footer">
            <?= Html::button('<li class=\'fa fa-minus-square\'></li> Close', ['id' => 'closeRaceForms', 'class' => 'formBtn btn btn-default']) ?>
            </div>

        </div>
    </div>
</div>

<!-- Export to Excel -->
<a id="divLink" style="display: none;"></a>

</div>