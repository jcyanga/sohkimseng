<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ProductInventory */

$this->title = 'Create Product Inventory';
$this->params['breadcrumbs'][] = ['label' => 'Product Inventories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-inventory-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
