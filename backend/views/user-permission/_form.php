<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UserPermission */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-permission-form">

    <?php foreach($actions as $row): ?>
    <?php
    	$checked = '';
		if ( in_array($row, $permission, true) ){
			$checked = 'checked';
		}
    ?>
        <input type="checkbox" name="chkboxMethods[]" value="<?php echo $row ?>" id="chkboxMethods" class="chkboxMethods" <?= $checked ?> /> <?php echo $row ?>
        <br/>
    <?php endforeach; ?>

</div>
