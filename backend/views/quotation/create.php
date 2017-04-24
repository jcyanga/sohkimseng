<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Quotation */

$this->title = 'Create Quotation';

$this->params['breadcrumbs'][] = ['label' => 'Quotation List', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="quotation-create divContainer">

    <?= $this->render('_form', [
        			'model' => $model,
    			]) ?>

</div>
