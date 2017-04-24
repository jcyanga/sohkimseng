<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\StaffGroup */

$this->title = 'Create Staff Group';
$this->params['breadcrumbs'][] = ['label' => 'Staff Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staff-group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
