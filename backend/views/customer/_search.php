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
        <?= $form->field($model, 'fullname')->textInput(['class' => 'inputForm form-control', 'placeholder' => 'Enter Customer fullname here.'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'company_name')->textInput(['class' => 'inputForm form-control', 'placeholder' => 'Enter Company name here.'])->label(false) ?>
    </div>

</div>

<div class="row">
    
    <div class="col-md-6">
        <div style="text-align: right;">
            <?= Html::resetButton('<li class=\'fa fa-refresh\'></li> Clear', ['class' => 'formBtn btn btn-default']) ?>
            <?= Html::submitButton('<li class=\'fa fa-search\'></li> Search', ['class' => 'formBtn btn btn-primary']) ?>
        </div>
    </div>

</div>

 <?php ActiveForm::end(); ?>

</div>
<br/>