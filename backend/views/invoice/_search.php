<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SearchInvoice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="quotation-search">

 <?php $form = ActiveForm::begin(['action' => ['index'], 'method' => 'get']); ?>

<div class="row">

    <div class="col-md-12">
        <div class="search-label-container">
            <span class="search-label"><i class="fa fa-edit"></i> Enter keyword here</span>
        </div> 
    </div>
    <br/>

    <div class="col-md-4">
        <?= $form->field($model, 'customer_id')->textInput(['class' => 'inputForm form-control', 'placeholder' => 'Enter Customer name here.'])->label(false) ?>
    </div>

</div>

<div class="row">

    <div class="col-md-4">
        <div style="text-align: right;">
            <?= Html::resetButton('<li class=\'fa fa-refresh\'></li> Clear', ['class' => 'formBtn btn btn-default']) ?>
            <?= Html::submitButton('<li class=\'fa fa-search\'></li> Search', ['class' => 'formBtn btn btn-primary']) ?>
        </div>
    </div>

</div>

<?php ActiveForm::end(); ?>

</div>
<br/>