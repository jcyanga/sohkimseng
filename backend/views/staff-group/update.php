<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\StaffGroup */

$this->title = 'Update Staff Group: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Staff Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="staff-group-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
