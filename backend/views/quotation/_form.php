<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Quotation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="quotation-form divContainer">

    <?php $form = ActiveForm::begin(); ?>

    <div style="border: solid 1px #eee; box-shadow: 1px 1px 1px 1px; background: #ffffff; max-width: 90%; margin: 0 auto;  font-family: Tahoma; opacity: 0.6;
    filter: alpha(opacity=60);">
        
        <div style="max-width: 99%; margin: 0 auto;">
            <h3 class="divHeaderLabel"><i class="fa fa-desktop"></i> <?= Html::encode($this->title) ?></h3>
        </div>
        <hr/>

        <div style="background: #dd4b39; color: #ffffff;">
            <span>&nbsp;<i class="fa fa-users"></i> Customer Information</span>
        </div>

        <div class="row">
            <div class="col-md-12">
                
            <div class="row">
                <div class="col-md-6">a</div>
                <div class="col-md-6">b</div>
            </div>

            </div>
        </div>
        <br/>

    </div>
    <br/>

    <div style="max-width: 90%; margin: 0 auto; border: solid 1px #eee; box-shadow: 1px 1px 1px 1px;">
    
                
            <div style="max-width: 99%; margin: 0 auto;" class="row">
                <div style="border: solid 1px #eee; box-shadow: 1px 1px 1px 1px; border-radius: 25px; background: #ffffff;" class="col-md-4">

                <div style="background: #dd4b39; color: #ffffff;">
                    <span>&nbsp;<i class="fa fa-users"></i> Customer Information</span>
                </div>

                a
                </div>

                <div style="border: solid 1px #eee; box-shadow: 1px 1px 1px 1px; border-radius: 25px; background: #ffffff;" class="col-md-8">b</div>
            </div>

        <br/>

    </div>

    <?php ActiveForm::end(); ?>

</div>
