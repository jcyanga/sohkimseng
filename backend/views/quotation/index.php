<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use  yii\helpers\ArrayHelper;

use common\models\Supplier;
use common\models\Race;

$dataSupplier = ArrayHelper::map(Supplier::find()->all(),'id', 'name');
$dataRace = ArrayHelper::map(Race::find()->all(),'id', 'name');

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchQuotation */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quotation List';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="quotation-index divContainer">

<div class="row containerHeadWrapper">
    
    <div class="col-md-12 col-sm-12 col-xs-12">
        
        <div>
            <h4 class="divHeaderLabel"><i class="fa fa-clipboard"></i> <?= Html::encode($this->title) ?></h4>
        </div>
        <hr/>

    <?php  echo $this->render('_search', [
                            'model' => $searchModel]); 
                        ?>    
    </div>

</div>
<br/>

<div class="row containerContentWrapper">
<?php
$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
        'quotation_code',
        'date_issue',
        [
            'attribute' => 'customer_id',
            'value' => 'customer.fullname',
            'label' => 'Customer Name'
        ],
        [
            'attribute' => 'user_id',
            'value' => 'user.fullname',
            'label' => 'Sales Person'
        ],
    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{preview}{update}{delete}',
        'buttons' => [
            'preview' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-eye-open"></span> ', $url, ['class' => '_showViewQuoteModal', 'id' => $model->id, 'title' => Yii::t('app', 'Preview'),
                ]);
            },
            'update' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-pencil"></span> ', $url, ['class' => '_showUpdateQuoteModal', 'id' => $model->id, 'title' => Yii::t('app', 'Update'),
                ]);
            },
            'delete' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-trash"></span> ', $url, ['class' => 'quotationDeleteColumn', 'id' => $model->id, 'title' => Yii::t('app', 'Delete'),
                ]);
            },
        ],
        'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'preview') {
                $url ='?r=quotation/view&id='.$model->id;
                return $url;
            }   
            if ($action === 'update') {
                $url ='#';
                return $url;
            }
            if ($action === 'delete') {
                $url ='#';
                return $url;
            }
        }
    ],
]
?>

<div class="col-md-12 col-sm-12 col-xs-12 btnsContainer">
<div class="row">

    <div class="col-md-2 pull-right">  
        <?= Html::button('<li class=\'fa fa-user-plus\'></li> New Quotation -', ['class' => '_showCreateQuotationModal formBtn btn btn-block btn-success btn-sm']) ?>
    </div>

    <div class="col-md-2 pull-right">  
        <?= Html::button('<li class=\'fa fa-users\'></li> New Customer -',['class' => '_showCreateCustomerByQuoteModal formBtn btn btn-block btn-info btn-sm']) ?>
    </div>

</div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 table-responsive contentWrapper">
    <?=
        GridView::widget([
            'id' => 'tableID',
            'class' => 'table table-hover',
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
            'showFooter'=>true,
        ]); 
    ?>
</div>
<br/>

<div class="col-md-12 col-sm-12 col-xs-12">
<div class="row">

<div class="col-md-4 pull-right">

    <div class="row">    
        <div class="col-md-6">
            <?= Html::button('<li class=\'fa fa-download\'></li> Export to Excel',['class' => 'formBtn btn btn-block btn-warning btn-xs', 'onclick' => "excelExportQuotation()"]) ?>
        </div>
        <div class="col-md-6">
            <a href="?r=quotation/export-pdf"onclick="return pdfExport()" class="formBtn btn btn-block btn-danger btn-xs">
                <i class="fa fa-download"></i> Export to PDF
            </a>
        </div>
    </div>

</div>
</div>
<br/><br/>

</div>

</div>

<!-- Create Customer -->
<div class="modal fade" id="modal-launcher-create-customerbyquote" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-user-plus"></i> New Customer</h5>
            </div>

        <div class="modal-body">
            <?php $form = ActiveForm::begin(['method' => 'post', 'id' => 'customerFormCreate']); ?>
    
                <label class="labelStyle">Fullname</label>
                <?= $form->field($customerModel, 'fullname')->textInput(['class' => 'inputForm form-control', 'id' => 'fullname', 'placeholder' => 'Enter Fullname here.'])->label(false) ?>

                <label class="labelStyle">Address</label>
                <?= $form->field($customerModel, 'address')->textarea(['rows' => '3', 'cols' => '2', 'class' => 'inputForm form-control', 'id' => 'address', 'placeholder' => 'Enter Address here.'])->label(false) ?>

                <label class="labelStyle">Race</label>
                <?= $form->field($customerModel, 'race_id')->dropdownList(['0' => ' - CHOOSE RACE HERE - '] + $dataRace,['style' => 'width: 100%;', 'class' => 'inputForm select2', 'id' => 'race', 'data-placeholder' => 'PLEASE CHOOSE RACE HERE'])->label(false) ?>

                <label class="labelStyle">Email</label>
                <?= $form->field($customerModel, 'email')->textInput(['class' => 'inputForm form-control', 'id' => 'email', 'placeholder' => 'Enter Email here.'])->label(false) ?>

                <label class="labelStyle">Phone Number</label>
                <?= $form->field($customerModel, 'phone_number')->textInput(['class' => 'inputForm form-control', 'id' => 'phoneNumber', 'placeholder' => 'Enter Phone number here.'])->label(false) ?>

                <label class="labelStyle">Mobile Number</label>
                <?= $form->field($customerModel, 'mobile_number')->textInput(['class' => 'inputForm form-control', 'id' => 'mobileNumber', 'placeholder' => 'Enter Mobile number here.'])->label(false) ?>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="modal-footer">
            <?= Html::button('<li class=\'fa fa-refresh\'></li> Clear', ['id' => 'clearCustomerForms', 'class' => 'formBtn btn btn-default']) ?>
            <?= Html::submitButton('<li class=\'fa fa-paper-plane-o\'></li> Submit Customer Information', ['id' => 'submitCustomerFormCreateByQuote', 'class' => 'formBtn btn btn-primary']) ?>
        </div>

        </div>
    </div>
</div>

<!-- Create Quotation -->
<div class="modal fade modalBackground" id="modal-launcher-create-quotation" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog modalInventoryDesign" >
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close closeQuotation" >&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-edit"></i> Create Quotation Form </h5>
            </div>

        <div class="modal-body">
            <?php $form = ActiveForm::begin(['method' => 'post', 'id' => 'quoteFormCreate']); ?>
                
                <div class="row informationsContainer">
                
                <div class="headerLabelContainer" >
                    <span class="headerLabel" > <i class="fa fa-info-circle"></i> Customer Information</span>
                </div>
                <br/>

                    <div class="col-md-6">
                        
                        <label class="labelStyle"><i class="fa fa-barcode"></i> Quotation Code</label>
                        <?= $form->field($model, 'quotation_code')->textInput(['class' => 'transactionForm form-control', 'id' => 'quotation_code', 'value' => $quotationCode, 'readonly' => 'readonly'])->label(false) ?>

                        <label class="labelStyle"><i class="fa fa-users"></i> Customer Name</label>
                        <?= $form->field($model, 'customer_id')->dropdownList(['0' => ' - PLEASE SELECT NAME HERE - '] + $dataCustomer, ['style' => 'width: 65%;', 'class' => 'inputForm select2', 'id' => 'customer', 'data-placeholder' => 'CHOOSE CUSTOMER NAME HERE'])->label(false) ?>

                        <label class="labelStyle"><i class="fa fa-user-circle-o"></i> Sales Person </label>
                        <?= $form->field($model, 'user_id')->dropdownList(['0' => ' - PLEASE SELECT NAME HERE - '] + $dataUser, ['style' => 'width: 65%;', 'class' => 'inputForm select2', 'id' => 'sales_person', 'data-placeholder' => 'CHOOSE SALES PERSON HERE'])->label(false) ?>
                        <br/>

                    </div>

                    <div class="col-md-6">
                        
                        <label class="labelStyle"><i class="fa fa-calendar-plus-o"></i> Date Issue</label>
                        <?= $form->field($model, 'date_issue')->textInput(['class' => 'transactionForm form-control date_issue', 'id' => 'datepicker', 'value' => $dateNow, 'readonly' => 'readonly'])->label(false) ?>

                        <label class="labelStyle"><i class="fa fa-comments"></i> Remarks</label>
                        <?= $form->field($model, 'remarks')->textarea(['rows' => 4, 'class' => 'transactionTxtAreaForm form-control', 'id' => 'remarks', 'placeholder' => 'Write your remarks here.'])->label(false) ?>    
                        <br/>

                    </div>

                </div>
                <br/><br/>

                 
                <div class="row informationsContainer">
                
                <div class="headerLabelContainer" >
                    <span class="headerLabel" > <i class="fa fa-subway"></i> Auto-Parts and Service Information</span>
                </div>
                    
                    <div class="col-md-4 modalInventoryDesignRside">
                    <br/>

                        <div class="headerLabelContainer" >
                            <span class="headerLabel" > <i class="fa fa-chain"></i> Auto-Parts Information</span>
                        </div>
                        <br/>

                        <label class="labelStyle labelAlignment"><i class="fa fa-wrench"></i> Auto-Parts</label>
                        <br/>
                        <select name="parts" class="inputForm select2" id="parts" style="width: 95%;" onchange="getPartsPriceAndQty()" data-placeholder="CHOOSE AUTO-PARTS HERE" >
                                <option value="0"> - PLEASE SELECT AUTO-PARTS HERE - </option>
                            <?php foreach($partsResult as $partsRow): ?>
                                <option value="<?= $partsRow['id']; ?>" >[<?= $partsRow['name']; ?>] <?= $partsRow['parts_name']; ?> </option>
                            <?php endforeach; ?>
                        </select>

                        <label class="labelStyle inputboxAlignment labelAlignment" ><i class="fa fa-database"></i> Quantity</label>
                        <input type="text" name="partsQty" id="partsQty" class="transactionForm inputboxWidth form-control" onchange="updatePartsSubtotal()" placeholder="0" />

                        <label class="labelStyle inputboxAlignment labelAlignment" ><i class="fa fa-gg-circle"></i> Unit-Price</label>
                        <input type="text" name="partsPrice" id="partsPrice" class="transactionForm inputboxWidth form-control" onchange="updatePartsSubtotal()" placeholder="$ 0.00" />

                        <label class="labelStyle inputboxAlignment labelAlignment" ><i class="fa fa-dollar"></i> Sub-Total</label>
                        <input type="text" name="partsSubtotal" id="partsSubtotal" class="transactionForm inputboxWidth form-control" placeholder="$ 0.00" readonly/>

                        <div class="btnAlignment pull-right" > 
                            <button type="button" class=" formBtn btn btn-success btn-sm btn-flat add_autoparts" >
                                <i class="fa fa-cart-plus"></i> <b> - Insert Item in List - </b> 
                            </button>
                        </div>

                        <input type="hidden" id="ctr" class="ctr" value="0" />

                        <div class="headerLabelContainer servicesContainerAlignment" >
                            <span class="headerLabel" > <i class="fa fa-tachometer"></i> Services Information</span>
                        </div>
                        <br/>
                        
                        <label class="labelStyle labelAlignment"><i class="fa fa-wheelchair-alt"></i> Services</label>
                        <br/>
                        <select name="services" class="inputForm selectboxWidth select2" id="services" style="width: 95%;" onchange="getServicesPriceAndQty()" data-placeholder="CHOOSE SERVICES HERE" >
                                <option value="0"> - PLEASE SELECT SERVICES HERE - </option>
                            <?php foreach($servicesResult as $servicesRow): ?>
                                <option value="<?= $servicesRow['id']; ?>"> - <?= $servicesRow['service_name']; ?> </option>
                            <?php endforeach; ?>
                        </select>

                        <span class="pull-right btn btn-link" id="editServiceDetailsBtn" style="font-size: 11px;">
                            <a href="javascript:updateServiceDetails()" class="selectedBtns" >
                                <b><i class="fa fa-pencil"></i> Update Service Details</b>
                            </a>
                        </span>

                        <span class="pull-right btn btn-link hidden" id="saveServiceDetailsBtn" style="font-size: 11px;">
                            <a href="javascript:saveServiceDetails()" class="selectedBtns" >
                                <b><i class="fa fa-save"></i> Save Service Details</b>
                            </a>
                        </span>
                        <br/><br/>

                        <textarea class="transactionTxtAreaForm form-control editFormServiceDetails hidden" id="editFormServiceDetails" placeholder="Write service details"></textarea>

                        <label class="labelStyle inputboxAlignment labelAlignment" ><i class="fa fa-database"></i> Quantity</label>
                        <input type="text" name="servicesQty" id="servicesQty" class="transactionForm inputboxWidth form-control" onchange="updateServicesSubtotal()" placeholder="0" />

                        <label class="labelStyle inputboxAlignment labelAlignment" ><i class="fa fa-gg-circle"></i> Unit-Price</label>
                        <input type="text" name="servicesPrice" id="servicesPrice" class="transactionForm inputboxWidth form-control" onchange="updateServicesSubtotal()" placeholder="$ 0.00" />

                        <label class="labelStyle inputboxAlignment labelAlignment" ><i class="fa fa-dollar"></i> Sub-Total</label>
                        <input type="text" name="servicesSubtotal" id="servicesSubtotal" class="transactionForm inputboxWidth form-control" placeholder="$ 0.00" readonly/>
                        
                        <div class="btnAlignment pull-right" > 
                            <button type="button" class=" formBtn btn btn-danger btn-sm btn-flat add_services" >
                                <i class="fa fa-cart-plus"></i> <b> - Insert Item in List - </b> 
                            </button>
                        <br/><br/>    
                        </div>
                

                    </div>

                     <div class="col-md-8 modalInventoryDesignLside">
                     <br/>

                        <div class="insert-item-in-list selectedItemContainer" id="insert-item-in-list">
                            <div class="selectedItemContent">
                               <span class="selectedItemLabel" >
                                    <span class="fa fa-opencart"></span> Selected Auto-Parts & Services
                                </span>
                            </div>  
                            <hr/>
                        </div>
                        <br/>

                        <div class="pull-right" style="width: 25%;">
                            <span class="labelStyle"><center><b><i class="fa fa-dedent"></i> Gross Total </b></center></span>
                            <?= $form->field($model, 'grand_total')->textInput(['class' => 'inputForm inputboxTotalAlignment form-control', 'id' => 'grandTotal', 'placeholder' => '$ 0.00', 'readonly' => 'readonly'])->label(false) ?>

                            <span class="labelStyle"><center><b><i class="fa fa-percent"></i> GST </b></center></span>
                            <?= $form->field($model, 'gst')->textInput(['class' => 'inputForm inputboxTotalAlignment form-control', 'id' => 'gst', 'onchange' => 'getNetTotal()', 'value' => '0', 'placeholder' => '0.00'])->label(false) ?>
                            <input type="hidden" id="gst_amount" class="gst_amount" />

                            <span class="labelStyle"><center><b><i class="fa fa-globe"></i> Nett Total </b></center></span>
                            <?= $form->field($model, 'net')->textInput(['class' => 'inputForm inputboxTotalAlignment form-control', 'id' => 'netTotal', 'placeholder' => '$ 0.00', 'readonly' => 'readonly'])->label(false) ?>
                        </div>
                    </div>


                </div>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="modal-footer">
            <?= Html::button('<li class=\'fa fa-refresh\'></li> Clear', ['id' => 'clearPIForms', 'class' => 'formBtn btn btn-default']) ?>
            <?= Html::submitButton('<li class=\'fa fa-paper-plane-o\'></li> Submit Quotation', ['id' => 'submitQuotationForm', 'class' => 'formBtn btn btn-primary']) ?>
        </div>
        <br/>

        </div>
    </div>
</div>

</div>