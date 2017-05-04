<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

AppAsset::register($this);

$this->title = 'Soh Kim Seng | Dashboard';

$userFullname = Yii::$app->user->identity->fullname;
$photo = Yii::$app->user->identity->image;

$isDashboard = false;
$isUser = false;
$isRole = false;
$isModule = false;
$isCustomer = false;
$isUsers = false;
$isEmployee = false;
$isStaffGroup = false;
$isDesignatedPosition = false;
$isStaff = false;
$isSupplier = false;
$isStorageLocation = false;
$isServices = false;
$isServiceCategory = false;
$isService = false;
$isParts = false;
$isPartsCategory = false;
$isPart = false;
$isPartsInventory = false;
$isProducts = false;
$isProductCategory = false;
$isProduct = false;
$isProductInventory = false;
$isPurchaseOrder = false;
$isQuotation = false;
$isInvoice = false;
$isDeliveryOrder = false;
$isUserPermission = false;
$isUtilities = false;
$isRace = false;
$isPaymentType = false;

 if ( isset ( $_GET['r'] ) ) {
      $getClass = $_GET['r'];
      $url = explode('/', $_GET['r']);

      if ( $url ) {
        $getClass = $url[0];
      }

      if ( $getClass == 'role' ) { 
            $isUser = true;
            $isRole = true;
      }

      if ( $getClass == 'module' ) { 
            $isUser = true;
            $isModule = true;
      }

      if ( $getClass == 'user-permission' ) { 
            $isUser = true;
            $isUserPermission = true;
      }

      if ( $getClass == 'user' ) {
            $isUser = true; 
            $isUsers = true;
      }

      if ( $getClass == 'staff-group' ) {
            $isEmployee = true; 
            $isStaffGroup = true;
      }

      if ( $getClass == 'designated-position' ) {
            $isEmployee = true; 
            $isDesignatedPosition = true;
      }

      if ( $getClass == 'staff' ) {
            $isEmployee = true; 
            $isStaff = true;
      }

      if ( $getClass == 'customer' ) { 
            $isCustomer = true;
      }
      
      if ( $getClass == 'supplier' ) {
            $isSupplier = true;
      }

      if ( $getClass == 'storage-location' ) {
            $isStorageLocation = true;
      }

      if ( $getClass == 'service-category' ) {
            $isServices = true; 
            $isServiceCategory = true;
      }

      if ( $getClass == 'service' ) {
            $isServices = true; 
            $isService = true;
      }

      if ( $getClass == 'parts-category' ) {
            $isPartsCategory = true; 
            $isParts = true;
      }

      if ( $getClass == 'parts' ) {
            $isPart = true; 
            $isParts = true;
      }

      if ( $getClass == 'parts-inventory' ) {
            $isPartsInventory = true; 
            $isParts = true;
      }

      if ( $getClass == 'product-category' ) {
            $isProductCategory = true; 
            $isProducts = true;
      }

      if ( $getClass == 'product' ) {
            $isProduct = true; 
            $isProducts = true;
      }

      if ( $getClass == 'product-inventory' ) {
            $isProductInventory = true; 
            $isProducts = true;
      }

      if ( $getClass == 'quotation' ) {
            $isStockInAndOut = true; 
      }

      if ( $getClass == 'purchase-order' ) {
            $isPurchaseOrder = true; 
      }

      if ( $getClass == 'invoice' ) {
            $isInvoice = true; 
      }

      if ( $getClass == 'delivery-order' ) {
            $isDeliveryOrder = true; 
      }

      if ( $getClass == 'race' ) {
            $isUtilities = true;
            $isRace = true; 
      }

      if ( $getClass == 'payment-type' ) {
            $isUtilities = true;
            $isPaymentType = true; 
      }

 }else{
    $isDashboard = true;
 
 }

?>

<?php $this->beginPage() ?>

<!DOCTYPE html>

<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>

    <!-- CSS -->
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/bootstrap/font-awesome/css/font-awesome.min.css" />
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="assets/dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="assets/plugins/iCheck/flat/blue.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="assets/plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="assets/plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="assets/plugins/daterangepicker/daterangepicker.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="assets/plugins/select2/select2.min.css">
    <!-- Others -->
    <link rel="stylesheet" href="css/styles.css">

    <style>
      .modalBackground {
          background: url('images/dashboard/modal-bg.png') no-repeat center center fixed; 
              -webkit-background-size: cover;
              -moz-background-size: cover;
              -o-background-size: cover;
              background-size: cover;
        }

        #main-background {
          background: url('images/dashboard/background.png') no-repeat center center fixed; 
          -webkit-background-size: cover;
          -moz-background-size: cover;
          -o-background-size: cover;
          background-size: cover;
        }
    </style>
</head>

<body class="hold-transition skin-blue sidebar-mini" >

<div class="wrapper">

<header class="main-header">
  <!-- Logo -->
  <a href="?" class="logo">
    <span class="logo-mini"><b>CRM</b></span>
    <span class="logo-lg" id="logo"><b>Soh Kim Seng</b></span>
  </a>
  
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"><span class="sr-only">Toggle navigation</span></a>

  <div class="navbar-custom-menu">
    <ul class="nav navbar-nav">

      <!-- User Account: style can be found in dropdown.less -->
      <li class="dropdown user user-menu">      
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <img src="assets/dist/img/user3-128x128.jpg" class="user-image" alt="User Image">
          <span class="hidden-xs"><?= $userFullname ?></span>
        </a>
      </li>
    
    </ul>
  </div>

  </nav>
</header>

<!-- Left side column. contains the logo and sidebar -->
<aside id="sideMenu" class="main-sidebar">

<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">

<!-- Sidebar user panel -->
<div class="user-panel" style="margin-top: 10px;">
  <div class="pull-left image">
    <img src="assets/dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
  </div>
  <div class="pull-left info">
    <p><?= $userFullname ?></p>
    <div style="margin-top: -10px; margin-left: -10px">
    <?php ActiveForm::begin(['action' => '?r=site/logout', 'method' => 'POST', 'id' => 'logout-form']); ?>
      <a href="#" onclick="document.getElementById('logout-form').submit(); return false;" class="form-btn btn btn-link btn-flat"><i class="fa fa-power-off"></i> SIGN-OUT  
    <?php ActiveForm::end(); ?>
     </div>  
    </a>
  </div>
</div>

<!-- search form -->
<!-- <form action="#" method="get" class="sidebar-form">
  <div class="input-group">
    <input type="text" name="q" class="form-control" placeholder="Search...">
      <span class="input-group-btn">
        <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
        </button>
      </span>
  </div>
</form> -->
<!-- /.search form -->
 
<!-- sidebar menu: : style can be found in sidebar.less -->
<ul id="sideMenuList" class="sidebar-menu" style="margin-top: 10px;">

<li class="<?php if( $isDashboard ) { echo 'activeMenu'; }?>" >
  <a href="?" id="homeMenu" ><i class="fa fa-home"></i> <span>Dashboard</span></a>
</li>

<li class="treeview <?php if( $isUser ) { echo 'active'; }?>" >
  <a href="#" id="userMenus" >
    <i class="fa fa-user"></i> <span>User</span>
    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
  </a>

  <ul class="treeview-menu">
    <li>
      <a href="?r=role/" id="<?php if( $isRole ) { echo 'roleMenu'; }?>" ><span class="subMenu"><i class="fa fa-angle-double-right"></i> User Role </span></a>
    </li>

    <li>
      <a href="?r=module/" id="<?php if( $isModule ) { echo 'moduleMenu'; }?>" ><span class="subMenu"><i class="fa fa-angle-double-right"></i> System Module List </span></a>
    </li>
    
    <li>
      <a href="?r=user-permission/" id="<?php if( $isUserPermission ) { echo 'userPermissionMenu'; }?>" ><span class="subMenu"><i class="fa fa-angle-double-right"></i> User Permission </span></a>
    </li>
    
    <li>
      <a href="?r=staff-group/" id="<?php if( $isStaffGroup ) { echo 'staffgroupMenu'; }?>" ><span class="subMenu"><i class="fa fa-angle-double-right"></i> Department </span></a>
    </li>

    <li>
      <a href="?r=designated-position/" id="<?php if( $isDesignatedPosition ) { echo 'designatedpositionMenu'; }?>" ><span class="subMenu"><i class="fa fa-angle-double-right"></i> Designated Position </span></a>
    </li>

    <li>
      <a href="?r=user/" id="<?php if( $isUsers ) { echo 'userMenu'; }?>" ><span class="subMenu"><i class="fa fa-angle-double-right"></i> User Account </span></a>
    </li>
  </ul>

</li>

<li class="<?php if( $isStaff ) { echo 'activeMenu'; }?>" >
  <a href="?r=staff" id="staffMenu">
    <i class="fa fa-address-card-o"></i> <span>Staff List</span>
  </a>
</li>

<li class="<?php if( $isCustomer ) { echo 'activeMenu'; }?>" >
  <a href="?r=customer" id="customerMenu">
    <i class="fa fa-users"></i> <span>Customer</span>
  </a>
</li>

<li class="<?php if( $isSupplier ) { echo 'activeMenu'; }?>" >
  <a href="?r=supplier" id="supplierMenu">
    <i class="fa fa-truck"></i> <span>Supplier</span>
  </a>
</li>

<li class="<?php if( $isStorageLocation ) { echo 'activeMenu'; }?>" >
  <a href="?r=storage-location" id="storagelocationMenu">
    <i class="fa fa-database"></i> <span>Storage Location</span>
  </a>
</li>

<li class="treeview <?php if( $isServices ) { echo 'active'; }?>" >
  <a href="#" id="serviceMenus" >
    <i class="fa fa-battery-full"></i> <span>Service</span>
    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
  </a>

  <ul class="treeview-menu">
    <li>
      <a href="?r=service-category/" id="<?php if( $isServiceCategory ) { echo 'servicecategoryMenu'; }?>" ><span class="subMenu"><i class="fa fa-angle-double-right"></i> Service Category </span></a>
    </li>

    <li>
      <a href="?r=service/" id="<?php if( $isService ) { echo 'serviceMenu'; }?>" ><span class="subMenu"><i class="fa fa-angle-double-right"></i> Service List </span></a>
    </li>
  </ul>

</li>

<li class="treeview <?php if( $isParts ) { echo 'active'; }?>" >
  <a href="#" id="partsMenus" >
    <i class="fa fa-cogs"></i> <span>Auto-Parts</span>
    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
  </a>

  <ul class="treeview-menu">
    <li>
      <a href="?r=parts-category/" id="<?php if( $isPartsCategory ) { echo 'partscategoryMenu'; }?>" ><span class="subMenu"><i class="fa fa-angle-double-right"></i> Auto-Parts Category </span></a>
    </li>

    <li>
      <a href="?r=parts/" id="<?php if( $isPart ) { echo 'partsMenu'; }?>" ><span class="subMenu"><i class="fa fa-angle-double-right"></i> Auto-Parts List </span></a>
    </li>

    <li>
      <a href="?r=parts-inventory/" id="<?php if( $isPartsInventory ) { echo 'partsinventoryMenu'; }?>" ><span class="subMenu"><i class="fa fa-angle-double-right"></i> Auto-Parts Inventory </span></a>
    </li>
  </ul>

</li>

<li class="treeview <?php if( $isProducts ) { echo 'active'; }?>" >
  <a href="#" id="productMenus" >
    <i class="fa fa-cubes"></i> <span>Products</span>
    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
  </a>

  <ul class="treeview-menu">
    <li>
      <a href="?r=product-category/" id="<?php if( $isProductCategory ) { echo 'productcategoryMenu'; }?>" ><span class="subMenu"><i class="fa fa-angle-double-right"></i> Product Category </span></a>
    </li>

    <li>
      <a href="?r=product/" id="<?php if( $isProduct ) { echo 'productMenu'; }?>" ><span class="subMenu"><i class="fa fa-angle-double-right"></i> Product List </span></a>
    </li>

    <li>
      <a href="?r=product-inventory/" id="<?php if( $isProductInventory ) { echo 'productinventoryMenu'; }?>" ><span class="subMenu"><i class="fa fa-angle-double-right"></i> Product Inventory </span></a>
    </li>
  </ul>

</li>

<li class="<?php if( $isPurchaseOrder ) { echo 'activeMenu'; }?>" >
  <a href="?r=purchase-order" id="purchaseorderMenu">
    <i class="fa fa-credit-card-alt"></i> <span>Purchase Order</span>
  </a>
</li>

<li class="<?php if( $isQuotation ) { echo 'activeMenu'; }?>" >
  <a href="?r=quotation" id="quotationMenu">
    <i class="fa fa-clipboard"></i> <span>Quotation</span>
  </a>
</li>

<li class="<?php if( $isInvoice ) { echo 'activeMenu'; }?>" >
  <a href="?r=invoice" id="invoiceMenu">
    <i class="fa fa-file-text-o"></i> <span>Invoice</span>
  </a>
</li>

<li class="<?php if( $isDeliveryOrder ) { echo 'activeMenu'; }?>" >
  <a href="?r=delivery-order" id="deliveryorderMenu">
    <i class="fa fa-ambulance"></i> <span>Delivery Order</span>
  </a>
</li>

<li class="treeview <?php if( $isUtilities   ) { echo 'active'; }?>" >
  <a href="#" id="partsMenus" >
    <i class="fa fa-globe"></i> <span>Utilities</span>
    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
  </a>

  <ul class="treeview-menu">
    <li>
      <a href="?r=race/" id="<?php if( $isRace ) { echo 'raceMenu'; }?>" ><span class="subMenu"><i class="fa fa-angle-double-right"></i> Set Race </span></a>
    </li>

    <li>
      <a href="?r=payment-type/" id="<?php if( $isPaymentType ) { echo 'paymenttypeMenu'; }?>" ><span class="subMenu"><i class="fa fa-angle-double-right"></i> Set Payment Type </span></a>
    </li>
  </ul>

</li>

<li class="treeview <?php if( $isUtilities   ) { echo 'active'; }?>" >
  <a href="#" id="partsMenus" >
    <i class="fa fa-globe"></i> <span>Reports</span>
    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
  </a>

  <ul class="treeview-menu">
    <li>
      <a href="?r=race/" id="<?php if( $isRace ) { echo 'raceMenu'; }?>" ><span class="subMenu"><i class="fa fa-angle-double-right"></i> Set Race </span></a>
    </li>

    <li>
      <a href="?r=payment-type/" id="<?php if( $isPaymentType ) { echo 'paymenttypeMenu'; }?>" ><span class="subMenu"><i class="fa fa-angle-double-right"></i> Set Payment Type </span></a>
    </li>
  </ul>

</li>

</ul>
</section>

  <!-- /.sidebar -->
</aside>

  <!-- Content Wrapper. Contains page content -->
  <div id="main-background" class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
    <div class="breadcrumbs-container">  
      <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
         ]) ?>
        <?= Alert::widget() ?>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      
      <?= $content ?> 
      <br/><br/>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; <?php echo date('Y'); ?> <a href="http://firsctcom.com">FirstCom Solutions</a>.</strong> All rights
    reserved.
  </footer>

</div>
<!-- ./wrapper -->


    <!-- Javascript -->
    <!-- jQuery 2.2.3 -->
    <script src="assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.6 -->
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="assets/plugins/morris/morris.min.js"></script>
    <!-- Sparkline -->
    <script src="assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="assets/plugins/knob/jquery.knob.js"></script>
    <!-- daterangepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
    <script src="assets/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- datepicker -->
    <script src="assets/plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Slimscroll -->
    <script src="assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="assets/plugins/fastclick/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="assets/dist/js/app.min.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <!-- <script src="assets/dist/js/pages/dashboard.js"></script> -->
    <!-- AdminLTE for demo purposes -->
    <!-- <script src="assets/dist/js/demo.js"></script> -->
    <!-- Other -->
    <script src="js/modalEvents.js"></script>
    <script src="js/quotation.js"></script>
    <script src="js/invoice.js"></script>
    <script src="js/delivery_order.js"></script>

    <!-- Table Export -->
    <script src="js/tableExport.js"></script>
    <script src="js/jquery.base64.js"></script>
    <script src="js/html2canvas.js"></script>
    <script src="js/jspdf/libs/sprintf.js"></script>
    <script src="js/jspdf/jspdf.js"></script>
    <script src="js/jspdf/libs/base64.js"></script>
    <script src="js/tableExportConfirmation.js"></script>

    <!-- Select2 -->
    <script src="assets/plugins/select2/select2.full.min.js"></script>

    <!-- Form submit -->
    <script src="js/form-submit.js"></script>

    <script>
      $(function () {
        //Initialize Select2 Elements
        $(".select2").select2({
            placeholder: "Choose here",
            allowClear: true
        });

        var date = new Date();
        var currentMonth = date.getMonth();
        var currentDate = date.getDate();
        var currentYear = date.getFullYear(); 
        
        // $('#expiry_date').daterangepicker({
        //     singleDatePicker: true,
        //     calender_style: "picker_4",
        //     format: 'DD-MM-YYYY',
        //     minDate: new Date(currentYear, currentMonth, currentDate),
        // }, function (start, end, label) {
        //     console.log(start.toISOString(), end.toISOString(), label);
        // });

        $('#datepicker').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy',
            minDate: currentDate + '-' + currentMonth + '-' + currentYear
        });

      });
    </script>

    </body>   

</html>

<?php $this->endPage() ?>
