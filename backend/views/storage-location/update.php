<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\StorageLocations */

$this->title = 'Update Storage Locations: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Storage Locations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="storage-locations-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
