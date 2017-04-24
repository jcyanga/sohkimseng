<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Soh Kim Seng Engineering and Trading Pte Ltd.';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginPage() ?>

<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= Html::encode($this->title) ?></title>

      <!-- CSS -->
      <!-- Bootstrap 3.3.6 -->
      <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
      <!-- Font Awesome -->
      <link rel="stylesheet" href="assets/bootstrap/font-awesome/css/font-awesome.min.css" />
      <!-- Theme style -->
      <link rel="stylesheet" href="assets/dist/css/AdminLTE.min.css">
      <!-- iCheck -->
      <link rel="stylesheet" href="assets/plugins/iCheck/square/blue.css">
      <!-- other -->
      <link rel="stylesheet" href="css/login.style.css">

      <style>
        #bodyDesign {
          background: url('images/login/background.png') no-repeat center center fixed; 
          -webkit-background-size: cover;
          -moz-background-size: cover;
          -o-background-size: cover;
          background-size: cover;
        }
      </style>
</head>

<body id="bodyDesign" class="hold-transition login-page">

<div class="login-box">
  
  <div class="login-logo">
    <a id="clientTitle" class="_clientTitle" href="#" ><i class="fa fa-opencart"></i> Soh Kim Seng</a>
  </div>

  <div id="divLoginContainer" class="login-box-body">

    <p class="login-box-msg"><span class="_subHeader"><i class="fa fa-key"></i> Login your credentials.</span></p>

    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
      
        <div class="form-group has-feedback">
            <label class="_loginFormLabel" >Username</label>
                <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'class' => '_inputForm form-control', 'placeholder' => 'Enter username here.' ])->label(false) ?>
            <span class="fa fa-user-circle form-control-feedback"></span>
        </div>

        <div class="form-group has-feedback">
            <label class="_loginFormLabel" >Password</label>
                <?= $form->field($model, 'password')->passwordInput(['autofocus' => true, 'class' => '_inputForm form-control', 'placeholder' => 'Enter password here.' ])->label(false) ?>
            <span class="fa fa-unlock-alt form-control-feedback"></span>
        </div>

        <div class="row">
        
            <div class="col-md-12">
                <div style="text-align: right;">
                <?= Html::submitButton('Sign-in <i class=\'fa fa-sign-in\'></i>', ['class' => 'btn btn-success', 'name' => 'login-button']) ?>       
                </div>
            </div>
        </div>

    <?php ActiveForm::end() ?>
    <br/>

  </div>

</div>

    <!-- Javascript -->
    <!-- jQuery 2.2.3 -->
    <script src="assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="assets/plugins/iCheck/icheck.min.js"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
            
    </body>
   
</html>

<?php $this->endPage() ?>

