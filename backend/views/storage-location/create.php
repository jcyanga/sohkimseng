<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\StorageLocations */

$this->title = 'Create Storage Locations';
$this->params['breadcrumbs'][] = ['label' => 'Storage Locations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="storage-locations-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
