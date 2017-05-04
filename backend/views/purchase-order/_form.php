<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\PurchaseOrder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="purchase-order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'purchase_order_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'supplier_id')->textInput() ?>

    <?= $form->field($model, 'date_issue')->textInput() ?>

    <?= $form->field($model, 'grand_total')->textInput() ?>

    <?= $form->field($model, 'gst')->textInput() ?>

    <?= $form->field($model, 'gst_value')->textInput() ?>

    <?= $form->field($model, 'net')->textInput() ?>

    <?= $form->field($model, 'remarks')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'payment_type_id')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'paid')->textInput() ?>

    <?= $form->field($model, 'deleted')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
