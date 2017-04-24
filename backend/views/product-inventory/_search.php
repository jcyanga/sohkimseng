<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SearchProductInventory */
/* @var $form yii\widgets\ActiveForm */

$dataInventoryType = array('0' => '- CHOOSE TYPE HERE - ', '1' => 'STOCK-IN', '2' => 'STOCK-OUT', '3' => 'STOCK-ADJUSTMENT' );

?>

<div class="product-inventory-search">

<?php $form = ActiveForm::begin(['action' => ['index'], 'method' => 'get']); ?>

<div class="row">

    <div class="col-md-12">
        <div class="search-label-container">
            <span class="search-label"><i class="fa fa-pencil"></i> Enter keyword here</span>
        </div> 
    </div>
    <br/>

    <div class="col-md-3">
        <?= $form->field($model, 'type')->dropdownList($dataInventoryType, ['style' => 'width: 100%;', 'class' => 'inputForm select2'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'product_id')->dropdownList(['0' => '- CHOOSE PRODUCT HERE -'] + $dataProduct, ['style' => 'width: 100%;', 'class' => 'inputForm select2'])->label(false) ?>
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
