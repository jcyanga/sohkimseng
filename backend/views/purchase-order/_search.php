<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SearchPurchaseOrder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="purchase-order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'purchase_order_code') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'supplier_id') ?>

    <?= $form->field($model, 'date_issue') ?>

    <?php // echo $form->field($model, 'grand_total') ?>

    <?php // echo $form->field($model, 'gst') ?>

    <?php // echo $form->field($model, 'gst_value') ?>

    <?php // echo $form->field($model, 'net') ?>

    <?php // echo $form->field($model, 'remarks') ?>

    <?php // echo $form->field($model, 'payment_type_id') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'paid') ?>

    <?php // echo $form->field($model, 'deleted') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
