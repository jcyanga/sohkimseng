<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PartsInventory */

$this->title = 'Update Parts Inventory: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Parts Inventories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="parts-inventory-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
