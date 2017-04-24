<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PartsInventory */

$this->title = 'Create Parts Inventory';
$this->params['breadcrumbs'][] = ['label' => 'Parts Inventories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parts-inventory-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
