<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\DeliveryOrder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="delivery-order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'delivery_order_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'invoice_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'customer_id')->textInput() ?>

    <?= $form->field($model, 'date_issue')->textInput() ?>

    <?= $form->field($model, 'grand_total')->textInput() ?>

    <?= $form->field($model, 'gst')->textInput() ?>

    <?= $form->field($model, 'gst_value')->textInput() ?>

    <?= $form->field($model, 'net')->textInput() ?>

    <?= $form->field($model, 'remarks')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'payment_type_id')->textInput() ?>

    <?= $form->field($model, 'discount_amount')->textInput() ?>

    <?= $form->field($model, 'discount_remarks')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <?= $form->field($model, 'paid')->textInput() ?>

    <?= $form->field($model, 'deleted')->textInput() ?>

    <?= $form->field($model, 'condition')->textInput() ?>

    <?= $form->field($model, 'action_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
