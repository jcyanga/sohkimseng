<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SearchCustomer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-search">

 <?php $form = ActiveForm::begin(['action' => ['index'], 'method' => 'get']); ?>

<div class="row">

    <div class="col-md-12">
        <div class="search-label-container">
            <span class="search-label"><i class="fa fa-pencil"></i> Enter keyword here</span>
        </div> 
    </div>
    <br/>

    <div class="col-md-3">
        <?= $form->field($model, 'customer_code')->textInput(['class' => 'inputForm form-control', 'placeholder' => 'Enter Customer code here.'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'company_name')->textInput(['class' => 'inputForm form-control', 'placeholder' => 'Enter Company name here.'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'location')->textInput(['class' => 'inputForm form-control', 'placeholder' => 'Enter Customer location here.'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'remarks')->textInput(['class' => 'inputForm form-control', 'placeholder' => 'Enter Customer remarks here.'])->label(false) ?>
    </div>

</div>

<div class="row">
    
    <div class="col-md-12">
        <div style="text-align: right;">
            <?= Html::resetButton('<li class=\'fa fa-refresh\'></li> Clear', ['class' => 'formBtn btn btn-default']) ?>
            <?= Html::submitButton('<li class=\'fa fa-search\'></li> Search', ['class' => 'formBtn btn btn-primary']) ?>
        </div>
    </div>

</div>

 <?php ActiveForm::end(); ?>

</div>
<br/>