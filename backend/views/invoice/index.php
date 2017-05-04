<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use  yii\helpers\ArrayHelper;

use common\models\Supplier;
use common\models\Race;
use common\models\PaymentType;

$dataCustomer = ArrayHelper::map($dataCustomerList,'id', 'customerInfo');
$dataSupplier = ArrayHelper::map(Supplier::find()->where(['status' => 1])->all(),'id', 'name');
$dataRace = ArrayHelper::map(Race::find()->where(['status' => 1])->all(),'id', 'name');
$dataPaymentType = ArrayHelper::map(PaymentType::find()->where(['status' => 1])->all(),'id', 'name');
$salesPerson = Yii::$app->user->identity->id;

$dataCustomerType = array('0' => '- CHOOSE CUSTOMER TYPE HERE -', '1' => '- For Company', '2' => '- For Individual');

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchInvoice */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Invoice List';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="quotation-index divContainer">

<div class="row containerHeadWrapper">
    
    <div class="col-md-12 col-sm-12 col-xs-12">
        
        <div>
            <h4 class="divHeaderLabel"><i class="fa fa-file-text-o"></i> <?= Html::encode($this->title) ?></h4>
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
    [
        'class' => 'yii\grid\SerialColumn',
        'options' => ['style' => 'color: #444']
    ],
        [
            'label' => 'INVOICE #',
            'value' => 'invoice_no',
            'options' => ['style' => 'color: #444']
        ],
        [
            'label' => 'DATE ISSUE',
            'value' => 'date_issue',
            'options' => ['style' => 'color: #444']
        ],
        [
            'attribute' => 'customer_id',
            'value' => 'customer.fullname',
            'header' => 'CUSTOMER NAME',
            'options' => ['style' => 'color: #444']
        ],
        [
            'header' => 'DELIVERY ORDER STATUS',
            'options' => ['style' => 'color: #444'],
            'value' => function($model)
            {   
                if($model->do == 1){
                    return 'Delivery order Created';

                }else{
                    return 'Not yet';

                }
            },
        ],
        [
            'header' => 'STATUS',
            'options' => ['style' => 'color: #444'],
            'value' => function($model)
            {   
                switch($model->condition){
                    case 1:
                        return 'Approved Invoice';
                    break;

                    case 2:
                        return 'Cancelled Invoice';
                    break;

                    case 3:
                        return 'Closed Invoice';
                    break;

                    default:
                        return 'Pending Invoice';
                }
            },
        ],

    [
        'class' => 'yii\grid\ActionColumn',
        'header' => 'ACTION',
        'options' => ['style' => 'color: #444'],
        'template' => '{preview}{update}{delete}{payment-history}',
        'buttons' => [
            'preview' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-eye-open"></span> ', $url, ['class' => '_showViewServiceModal', 'id' => $model->id, 'title' => Yii::t('app', 'Preview'),
                ]);
            },
            'update' => function ($url, $model) {
                if($model->condition == 0 && $model->do == 0){
                    return Html::a(' <span class="glyphicon glyphicon-pencil"></span> ', $url, ['class' => '_showUpdateInvoiceModal', 'id' => $model->id, 'title' => Yii::t('app', 'Update'),
                    ]);

                }else{
                    return false;

                }
            },
            'delete' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-trash"></span> ', $url, ['class' => 'invoiceDeleteColumn', 'id' => $model->id, 'title' => Yii::t('app', 'Delete'),
                ]);
            },
            'payment-history' => function ($url, $model) {
                return Html::a(' <span class="fa fa-history"></span> ', $url, ['class' => 'invoicePaymentHistoryColumn', 'id' => $model->id, 'title' => Yii::t('app', 'Payment History'),
                ]);
            },
        ],
        'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'preview') {
                $url ='?r=invoice/view&id='.$model->id;
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
            if ($action === 'payment-history') {
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
        <?= Html::button('<li class=\'fa fa-user-plus\'></li> New Invoice -', ['class' => '_showCreateInvoiceModal formBtn btn btn-block btn-success btn-sm']) ?>
    </div>

    <div class="col-md-2 pull-right">  
        <?= Html::button('<li class=\'fa fa-user\'></li> New Customer -',['class' => '_showCreateCustomerByInvoiceModal formBtn btn btn-block btn-info btn-sm']) ?>
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
            'showFooter'=> false,
        ]); 
    ?>
<br/>
</div>

<!-- <div class="col-md-12 col-sm-12 col-xs-12">
<div class="row">

<div class="col-md-4 pull-right">

    <div class="row">    
        <div class="col-md-6">
            <?= Html::button('<li class=\'fa fa-download\'></li> Export to Excel',['class' => 'formBtn btn btn-block btn-warning btn-xs', 'onclick' => "excelExportInvoice()"]) ?>
        </div>
        <div class="col-md-6">
            <a href="?r=invoice/export-pdf"onclick="return pdfExport()" class="formBtn btn btn-block btn-danger btn-xs">
                <i class="fa fa-download"></i> Export to PDF
            </a>
        </div>
    </div>

</div>
</div>
<br/><br/>

</div> -->

</div>

<!-- Create Customer -->
<div class="modal fade modalBackground" id="modal-launcher-create-customerbyinvoice" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close closeNewInvoiceCustomer" >&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-user-plus"></i> New Customer</h5>
            </div>

        <div class="modal-body">
            <?php $form = ActiveForm::begin(['method' => 'post', 'id' => 'customerFormCreate']); ?>
    
                <div class="row">
                    <div class="col-md-6 col-xs-6 col-sm-6">
                        <label class="labelStyle">Customer Type</label>
                        <?= $form->field($customerModel, 'type')->dropdownList($dataCustomerType, ['style' => 'width: 100%;', 'class' => 'inputForm select2', 'id' => 'customerType', 'data-placeholder' => 'PLEASE CHOOSE CUSTOMER TYPE HERE'])->label(false) ?>
                    </div>
                </div>
                <hr/>

                <div id="forCompany">
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <label class="labelStyle">Customer Code</label>
                            <input type="text" name="customer_code" class="inputForm form-control readonlyForm" value = "<?= $customerCode ?>" id="companyCustomerCode" readonly = "readonly" />
                        </div>
                    </div>
                    <br/>

                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <label class="labelStyle">Company Name</label>
                            <?= $form->field($customerModel, 'company_name')->textInput(['class' => 'inputForm form-control', 'id' => 'companyName', 'placeholder' => 'Enter Company name here.'])->label(false) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <label class="labelStyle">Location</label>
                            <input type="text" name="company_location" class="inputForm form-control" placeholder="Enter Company location here." id="companyLocation" />
                        </div>
                    </div>
                    <br/>

                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <label class="labelStyle">Contact Person</label>
                            <input type="text" name="contact_person" class="inputForm form-control" placeholder="Enter Contact person here." id="companyContactPerson" />
                        </div>
                    </div>
                    <br/>

                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <label class="labelStyle">Billing Address</label>
                            <textarea name="company_address" rows="5" class="inputForm form-control" placeholder="Enter Billing address here." id="companyAddress" ></textarea>
                        </div>
                        <div style="margin-top: 10px;" class="col-md-3 col-xs-3 col-sm-3 pull-right">
                            <button type="button" class="formBtn btn btn-block btn-flat btn-info btn-xs" id="btnInvoiceAddInformation" ><i class="fa fa-plus-circle"></i> Add Information - </button>
                        </div>
                    </div>
                    <hr/>

                    <input type="hidden" id="ctr" value="0" />
                    <div class="company-contactperson-address" id="company-contactperson-address" ></div>

                    <div class="row">
                        <div class="col-md-6 col-xs-6 col-sm-6">
                            <label class="labelStyle">Uen No.</label>
                            <input type="text" name="uen_no" class="inputForm form-control" placeholder="Enter UEN number here." id="companyUenNo" />
                            <br/>

                            <label class="labelStyle">E-mail Address</label>
                            <input type="text" name="company_email" class="inputForm form-control" placeholder="Enter Email address here." id="companyEmail"  />
                            <br/>

                            <label class="labelStyle">Phone Number</label>
                            <input type="text" name="company_hanphone" class="inputForm form-control" placeholder="Enter Phone number here." id="companyPhoneNumber" />
                        </div>
        
                        <div class="col-md-6 col-xs-6 col-sm-6">
                            <label class="labelStyle">Office Number</label>
                            <input type="text" name="company_officeno" class="inputForm form-control" placeholder="Enter Office number here." id="companyOfficeNumber" />
                            <br/>

                            <label class="labelStyle">Fax Number</label>
                            <input type="text" name="company_faxno" class="inputForm form-control" placeholder="Enter Fax number here." id="companyFaxNumber" />
                        </div>
                    </div>
                    <br/>

                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <label class="labelStyle">Remarks</label>
                            <textarea name="company_remarks" rows="5" class="inputForm form-control" placeholder="Enter Company remarks here." id="companyRemarks" ></textarea>
                        </div>
                    </div>
                </div>

                <div id="forIndividual">
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <label class="labelStyle">Customer Code</label>
                            <input type="text" name="individual_customer_code" class="inputForm form-control readonlyForm" value = "<?= $customerCode ?>" id="individualCustomerCode" readonly = "readonly" />
                        </div>
                    </div>
                    <br/>
                    
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <label class="labelStyle">Fullname</label>
                            <?= $form->field($customerModel, 'fullname')->textInput(['class' => 'inputForm form-control', 'id' => 'fullname', 'placeholder' => 'Enter Fullname here.'])->label(false) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <label class="labelStyle">Billing Address</label>
                            <textarea name="individual_address" rows="5" class="inputForm form-control" placeholder="Enter Billing address here." id="customerAddress" ></textarea>
                        </div>
                    </div>
                    <br/>

                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <label class="labelStyle">Shipping Address</label>
                            <textarea name="shipping_address" rows="5" class="inputForm form-control" placeholder="Enter Shipping address here." id="customerShippingAddress" ></textarea>
                        </div>
                    </div>
                    <br/>

                    <div class="row">
                        <div class="col-md-6 col-xs-6 col-sm-6">
                            <label class="labelStyle">Race</label>
                            <?= $form->field($customerModel, 'race_id')->dropdownList(['0' => ' - CHOOSE RACE HERE - '] + $dataRace,['style' => 'width: 100%;', 'class' => 'inputForm select2', 'id' => 'customerRace', 'data-placeholder' => 'PLEASE CHOOSE RACE HERE'])->label(false) ?>

                            <label class="labelStyle" style="margin-top: 12px;">Nric</label>
                            <input type="text" name="nric" class="inputForm form-control" placeholder="Write NRIC here." id="customerNric" />
                            <br/>

                            <label class="labelStyle">Personal E-mail Address</label>
                            <input type="text" name="person_email" class="inputForm form-control" placeholder="Write Email address here." id="customerEmail"  />
                        </div>

                        <div class="col-md-6 col-xs-6 col-sm-6">
                            <label class="labelStyle">Personal Contact Number</label>
                            <input type="text" name="person_hanphone" class="inputForm form-control" placeholder="Write Phone number here." id="customerPhoneNumber" />
                            <br/>

                            <label class="labelStyle">Office Number</label>
                            <input type="text" name="person_officeno" class="inputForm form-control" placeholder="Write Office number here." id="customerOficeNumber" />
                            <br/>

                            <label class="labelStyle">Fax Number</label>
                            <input type="text" name="person_faxno" class="inputForm form-control" placeholder="Write Fax number here." id="customerFaxNumber" />
                        </div>
                    </div>    
                    <br/>

                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <label class="labelStyle">Remarks</label>
                            <textarea name="individual_remarks" rows="5" class="inputForm form-control" placeholder="Enter Customer remarks here." id="customerRemarks" ></textarea>
                        </div>
                    </div>    
                </div>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="modal-footer">
            <?= Html::button('<li class=\'fa fa-refresh\'></li> Clear', ['id' => 'clearCustomerForms', 'class' => 'formBtn btn btn-default']) ?>
            <?= Html::submitButton('<li class=\'fa fa-paper-plane-o\'></li> Submit Record', ['id' => 'submitCustomerFormCreateByInvoice', 'class' => 'formBtn btn btn-primary']) ?>
        </div>

        </div>
    </div>
</div>

<!-- Create Invoice -->
<div class="modal fade modalBackground" id="modal-launcher-create-invoice" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog modalInventoryDesign" >
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close closeInvoice" >&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-edit"></i> Create Invoice Form </h5>
            </div>

        <div class="modal-body">
            <?php $form = ActiveForm::begin(['method' => 'post', 'id' => 'invoiceFormCreate']); ?>
                
                <div class="row informationsContainer">
                
                <div class="headerLabelContainer" >
                    <span class="headerLabel" > <i class="fa fa-info-circle"></i> Customer Information</span>
                </div>
                <br/>

                    <div class="col-md-6">
                        
                        <label class="labelStyle"><i class="fa fa-barcode"></i> Invoice No.</label>
                        <?= $form->field($model, 'invoice_no')->textInput(['class' => 'transactionForm form-control', 'id' => 'invoice_no', 'value' => $invoiceNo, 'readonly' => 'readonly'])->label(false) ?>

                        <label class="labelStyle"><i class="fa fa-user-circle-o"></i> Sales Person </label>
                        <?= $form->field($model, 'user_id')->dropdownList(['0' => ' - PLEASE SELECT NAME HERE - '] + $dataUser, ['style' => 'width: 65%;', 'class' => 'inputForm select2', 'id' => 'sales_person', 'data-placeholder' => 'CHOOSE SALES PERSON HERE'])->label(false) ?>
                        
                        <label class="labelStyle"><i class="fa fa-money"></i> Payment Type </label>
                        <?= $form->field($model, 'payment_type_id')->dropdownList(['0' => ' - PLEASE SELECT PAYMENT TYPE HERE - '] + $dataPaymentType, ['style' => 'width: 65%;', 'class' => 'inputForm select2', 'id' => 'paymentType', 'data-placeholder' => 'CHOOSE PAYMENT TYPE HERE'])->label(false) ?>

                        <label class="labelStyle"><i class="fa fa-comments"></i> Remarks</label>
                        <?= $form->field($model, 'remarks')->textarea(['rows' => 5, 'class' => 'transactionTxtAreaForm form-control', 'id' => 'remarks', 'placeholder' => 'Write your remarks here.'])->label(false) ?> 
                        <br/>

                    </div>

                    <div class="col-md-6">
                        
                        <label class="labelStyle"><i class="fa fa-calendar-plus-o"></i> Date Issue</label>
                        <?= $form->field($model, 'date_issue')->textInput(['class' => 'transactionForm form-control date_issue', 'id' => 'datepicker', 'value' => $dateNow, 'readonly' => 'readonly'])->label(false) ?>
                        
                        <label class="labelStyle"><i class="fa fa-users"></i> Customer Name</label>
                        <?= $form->field($model, 'customer_id')->dropdownList(['0' => ' - PLEASE SELECT NAME HERE - '] + $dataCustomer, ['style' => 'width: 65%;', 'class' => 'inputForm select2', 'id' => 'invoiceCustomerName', 'data-placeholder' => 'CHOOSE CUSTOMER NAME HERE' ])->label(false) ?>   
                        
                        <div id="invoice-customer-information" class="invoice-customer-information" ></div>
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
                        <select name="parts" class="inputForm select2" id="parts" style="width: 95%;" onchange="getPartsPriceAndQtyInvoice()" data-placeholder="CHOOSE AUTO-PARTS HERE" >
                                <option value="0"> - PLEASE SELECT AUTO-PARTS HERE - </option>
                            <?php foreach($partsResult as $partsRow): ?>
                                <option value="<?= $partsRow['id']; ?>" > <?= $partsRow['parts_name']; ?> </option>
                            <?php endforeach; ?>
                        </select>

                        <label class="labelStyle inputboxAlignment labelAlignment" ><i class="fa fa-database"></i> Quantity</label>
                        <input type="text" name="partsQty" id="partsQty" class="transactionForm inputboxWidth form-control" onchange="updatePartsSubtotalInvoice()" placeholder="0" />
                        <input type="hidden" id="currentQtyValue" class="currentQtyValue" />
                        <label class="labelStyle inputboxAlignment labelAlignment" id="currentQtyStyle" >*Current Stock : </label> <span class="currentQtyContent" id="currentQty" >0</span>
                        <br/>

                        <label class="labelStyle inputboxAlignment labelAlignment" ><i class="fa fa-gg-circle"></i> Unit-Price</label>
                        <input type="text" name="partsPrice" id="partsPrice" class="transactionForm inputboxWidth form-control" placeholder="$ 0.00" readonly/>

                        <label class="labelStyle inputboxAlignment labelAlignment" ><i class="fa fa-dollar"></i> Sub-Total</label>
                        <input type="text" name="partsSubtotal" id="partsSubtotal" class="transactionForm inputboxWidth form-control" placeholder="$ 0.00" readonly/>

                        <div class="btnAlignment pull-right" > 
                            <button type="button" class=" formBtn btn btn-success btn-sm btn-flat add_autoparts_invoice" >
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
                        <select name="services" class="inputForm selectboxWidth select2" id="services" style="width: 95%;" onchange="getServicesPriceAndQtyInvoice()" data-placeholder="CHOOSE SERVICES HERE" >
                                <option value="0"> - PLEASE SELECT SERVICES HERE - </option>
                            <?php foreach($servicesResult as $servicesRow): ?>
                                <option value="<?= $servicesRow['id']; ?>">[ <?= $servicesRow['name']; ?> ] <?= $servicesRow['service_name']; ?> </option>
                            <?php endforeach; ?>
                        </select>

                        <span class="pull-right btn btn-link" id="editServiceDetailsBtn" style="font-size: 11px;">
                            <a href="javascript:updateServiceDetailsInvoice()" class="selectedBtns" >
                                <b><i class="fa fa-pencil"></i> Update Service Details</b>
                            </a>
                        </span>

                        <span class="pull-right btn btn-link hidden" id="saveServiceDetailsBtn" style="font-size: 11px;">
                            <a href="javascript:saveServiceDetailsInvoice()" class="selectedBtns" >
                                <b><i class="fa fa-save"></i> Save Service Details</b>
                            </a>
                        </span>
                        <br/><br/>

                        <input type="hidden" id="serviceCategory" class="serviceCategory" />
                        <textarea class="transactionTxtAreaForm form-control editFormServiceDetails hidden" rows="5" id="editFormServiceDetails" placeholder="Write service details"></textarea>

                        <label class="labelStyle inputboxAlignment labelAlignment" ><i class="fa fa-database"></i> Quantity</label>
                        <input type="text" name="servicesQty" id="servicesQty" class="transactionForm inputboxWidth form-control" onchange="updateServicesSubtotalInvoice()" placeholder="0" />

                        <label class="labelStyle inputboxAlignment labelAlignment" ><i class="fa fa-gg-circle"></i> Unit-Price</label>
                        <input type="text" name="servicesPrice" id="servicesPrice" class="transactionForm inputboxWidth form-control" onchange="updateServicesSubtotalInvoice()" placeholder="$ 0.00" />

                        <label class="labelStyle inputboxAlignment labelAlignment" ><i class="fa fa-dollar"></i> Sub-Total</label>
                        <input type="text" name="servicesSubtotal" id="servicesSubtotal" class="transactionForm inputboxWidth form-control" placeholder="$ 0.00" readonly/>
                        
                        <div class="btnAlignment pull-right" > 
                            <button type="button" class=" formBtn btn btn-danger btn-sm btn-flat add_services_invoice" >
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
                            <span class="labelStyle"><center><b><i class="fa fa-dedent"></i> Sub-Total </b></center></span>
                            <?= $form->field($model, 'grand_total')->textInput(['class' => 'inputForm inputboxTotalAlignment form-control', 'id' => 'grandTotal', 'placeholder' => '$ 0.00', 'readonly' => 'readonly'])->label(false) ?>

                            <span class="labelStyle"><center><b><i class="fa fa-percent"></i> GST </b></center></span>
                            <?= $form->field($model, 'gst')->textInput(['class' => 'inputForm inputboxTotalAlignment form-control', 'id' => 'gst', 'onchange' => 'getQuoteNetTotal()', 'placeholder' => '0.00'])->label(false) ?>
                            <input type="hidden" id="gst_amount" class="gst_amount" />

                            <span class="labelStyle"><center><b><i class="fa fa-globe"></i> Nett Total </b></center></span>
                            <?= $form->field($model, 'net')->textInput(['class' => 'inputForm inputboxTotalAlignment form-control', 'id' => 'netTotal', 'placeholder' => '$ 0.00', 'readonly' => 'readonly'])->label(false) ?>
                        </div>
                    </div>

                </div>
                <br/>

                <div class="row informationsContainer">
                
                <div class="headerLabelContainer" >
                    <span class="headerLabel" > <i class="fa fa-battery-1"></i> Discount Information</span>
                </div>
                <br/>

                <div class="col-md-4 col-xs-4 col-sm-4">
                    <label class="labelStyle"><i class="fa fa-minus-circle"></i> Discount Amount</label>
                    <?= $form->field($model, 'discount_amount')->textInput(['class' => 'inputForm form-control', 'id' => 'discountAmount', 'placeholder' => 'Write Discount amount here.', 'readonly' => 'readonly' ])->label(false) ?>
                </div>

                <div class="col-md-8 col-xs-8 col-sm-8">
                    <span class="labelStyle"><i class="fa fa-commenting"></i> Discount Remarks</span>
                    <?= $form->field($model, 'discount_remarks')->textArea(['class' => 'transactionDiscountTxtAreaForm form-control', 'id' => 'discountRemarks', 'placeholder' => 'Write Discount remarks here.', 'readonly' => 'readonly', 'rows' => 5 ])->label(false) ?>
                </div>
                <br/>

                <div class="col-md-12 col-xs-12 col-sm-12">
                    <div style="margin-top: -1px;">
                        <button type="button" class="btnDiscount formBtn btn btn-info pull-right" id="btnDiscount" ><i class="fa fa-battery-4"></i> Add Discount - </button>
                        <button type="button" class="submitDiscount formBtn btn btn-primary pull-right hidden" id="submitDiscount"><i class="fa fa-save"></i> Save Discount - </button>
                        <button type="button" class="clearDiscount formBtn btn btn-danger pull-right hidden" id="clearDiscount"><i class="fa fa-refresh"></i> Cancel - </button>
                    </div>
                </div>
                <br/>

                <div class="col-md-12 col-xs-12 col-sm-12"><br/></div>

                </div>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="modal-footer">
            <?= Html::button('<li class=\'fa fa-refresh\'></li> Clear', ['id' => 'clearPIForms', 'class' => 'formBtn btn btn-default']) ?>
            <?= Html::submitButton('<li class=\'fa fa-paper-plane-o\'></li> Submit Invoice', ['id' => 'submitInvoiceForm', 'class' => 'formBtn btn btn-primary']) ?>
        </div>
        <br/>

        </div>
    </div>
</div>

<!-- Update Invoice -->
<div class="modal fade modalBackground" id="modal-launcher-update-invoice" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog modalInventoryDesign" >
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close closeUpdateInvoice" >&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-edit"></i> Edit Invoice Form </h5>
            </div>

       <div class="modal-body">
            <?php $form = ActiveForm::begin(['method' => 'post', 'id' => 'invoiceFormUpdate']); ?>
                
                <div class="row informationsContainer">
                
                <div class="headerLabelContainer" >
                    <span class="headerLabel" > <i class="fa fa-info-circle"></i> Customer Information</span>
                </div>
                <br/>

                    <div class="col-md-6">
                        <input type="hidden" id="invoice_id" class="invoice_id" />

                        <label class="labelStyle"><i class="fa fa-barcode"></i> Invoice No.</label>
                        <?= $form->field($model, 'invoice_no')->textInput(['class' => 'transactionForm form-control', 'id' => 'update_invoice_no', 'readonly' => 'readonly'])->label(false) ?>

                        <label class="labelStyle"><i class="fa fa-user-circle-o"></i> Sales Person </label>
                        <?= $form->field($model, 'user_id')->dropdownList(['0' => ' - PLEASE SELECT NAME HERE - '] + $dataUser, ['style' => 'width: 65%;', 'class' => 'inputForm select2', 'value' => $salesPerson, 'id' => 'update_sales_person', 'data-placeholder' => 'CHOOSE SALES PERSON HERE'])->label(false) ?>
                        
                        <label class="labelStyle"><i class="fa fa-money"></i> Payment Type </label>
                        <?= $form->field($model, 'payment_type_id')->dropdownList(['0' => ' - PLEASE SELECT PAYMENT TYPE HERE - '] + $dataPaymentType, ['style' => 'width: 65%;', 'class' => 'inputForm select2', 'id' => 'update_paymentType', 'data-placeholder' => 'CHOOSE PAYMENT TYPE HERE'])->label(false) ?>

                        <label class="labelStyle"><i class="fa fa-comments"></i> Remarks</label>
                        <?= $form->field($model, 'remarks')->textarea(['rows' => 5, 'class' => 'transactionTxtAreaForm form-control', 'id' => 'update_remarks', 'placeholder' => 'Write your remarks here.'])->label(false) ?> 
                        <br/>

                    </div>

                    <div class="col-md-6">
                        
                        <label class="labelStyle"><i class="fa fa-calendar-plus-o"></i> Date Issue</label>
                        <?= $form->field($model, 'date_issue')->textInput(['class' => 'transactionForm form-control update_date_issue', 'id' => 'datepicker', 'value' => $dateNow, 'readonly' => 'readonly'])->label(false) ?>
                        
                        <label class="labelStyle"><i class="fa fa-users"></i> Customer Name</label>
                        <?= $form->field($model, 'customer_id')->dropdownList(['0' => ' - PLEASE SELECT NAME HERE - '] + $dataCustomer, ['style' => 'width: 65%;', 'class' => 'inputForm select2', 'id' => 'update_customer', 'data-placeholder' => 'CHOOSE CUSTOMER NAME HERE' ])->label(false) ?>   
                        
                        <div id="update-invoice-customer-information" class="update-invoice-customer-information" ></div>
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
                        <select name="parts" class="inputForm select2" id="update_parts" style="width: 95%;" onchange="getUpdatePartsPriceAndQtyInvoice()" data-placeholder="CHOOSE AUTO-PARTS HERE" >
                                <option value="0"> - PLEASE SELECT AUTO-PARTS HERE - </option>
                            <?php foreach($partsResult as $partsRow): ?>
                                <option value="<?= $partsRow['id']; ?>" > <?= $partsRow['parts_name']; ?> </option>
                            <?php endforeach; ?>
                        </select>

                        <label class="labelStyle inputboxAlignment labelAlignment" ><i class="fa fa-database"></i> Quantity</label>
                        <input type="text" name="partsQty" id="update_partsQty" class="transactionForm inputboxWidth form-control" onchange="editPartsSubtotalInvoice()" placeholder="0" />
                        <input type="hidden" id="currentUpdateQtyValue" class="currentUpdateQtyValue" />
                        <label class="labelStyle inputboxAlignment labelAlignment" id="currentQtyStyle" >*Current Stock : </label> <span class="currentQtyContent" id="currentUpdateQty" >0</span>
                        <br/>

                        <label class="labelStyle inputboxAlignment labelAlignment" ><i class="fa fa-gg-circle"></i> Unit-Price</label>
                        <input type="text" name="partsPrice" id="update_partsPrice" class="transactionForm inputboxWidth form-control" onchange="editPartsSubtotalInvoice()" placeholder="$ 0.00" readonly/>

                        <label class="labelStyle inputboxAlignment labelAlignment" ><i class="fa fa-dollar"></i> Sub-Total</label>
                        <input type="text" name="partsSubtotal" id="update_partsSubtotal" class="transactionForm inputboxWidth form-control" placeholder="$ 0.00" readonly/>

                        <div class="btnAlignment pull-right" > 
                            <button type="button" class=" formBtn btn btn-success btn-sm btn-flat autoparts_update_invoice" >
                                <i class="fa fa-cart-plus"></i> <b> - Insert Item in List - </b> 
                            </button>
                        </div>

                        <input type="hidden" id="n" class="n" value="0" />

                        <div class="headerLabelContainer servicesContainerAlignment" >
                            <span class="headerLabel" > <i class="fa fa-tachometer"></i> Services Information</span>
                        </div>
                        <br/>
                        
                        <label class="labelStyle labelAlignment"><i class="fa fa-wheelchair-alt"></i> Services</label>
                        <br/>
                        <select name="services" class="inputForm selectboxWidth select2" id="update_services" style="width: 95%;" onchange="getUpdateServicesPriceAndQtyInvoice()" data-placeholder="CHOOSE SERVICES HERE" >
                                 <option value="0"> - PLEASE SELECT SERVICES HERE - </option>
                            <?php foreach($servicesResult as $servicesRow): ?>
                                <option value="<?= $servicesRow['id']; ?>">[ <?= $servicesRow['name']; ?> ] <?= $servicesRow['service_name']; ?> </option>
                            <?php endforeach; ?>
                        </select>

                        <span class="pull-right btn btn-link" id="updateServiceDetailsBtn" style="font-size: 11px;">
                            <a href="javascript:editServiceDetailsInvoice()" class="selectedBtns" >
                                <b><i class="fa fa-pencil"></i> Update Service Details</b>
                            </a>
                        </span>

                        <span class="pull-right btn btn-link hidden" id="saveUpdateServiceDetailsBtn" style="font-size: 11px;">
                            <a href="javascript:saveUpdateServiceDetailsInvoice()" class="selectedBtns" >
                                <b><i class="fa fa-save"></i> Save Service Details</b>
                            </a>
                        </span>
                        <br/><br/>

                        <input type="hidden" id="serviceCategoryUpdate" class="serviceCategoryUpdate" />
                        <textarea class="transactionTxtAreaForm form-control updateFormServiceDetails hidden" rows="5" id="updateFormServiceDetails" placeholder="Write service details"></textarea>

                        <label class="labelStyle inputboxAlignment labelAlignment" ><i class="fa fa-database"></i> Quantity</label>
                        <input type="text" name="servicesQty" id="update_servicesQty" class="transactionForm inputboxWidth form-control" onchange="editServicesSubtotalInvoice()" placeholder="0" />

                        <label class="labelStyle inputboxAlignment labelAlignment" ><i class="fa fa-gg-circle"></i> Unit-Price</label>
                        <input type="text" name="servicesPrice" id="update_servicesPrice" class="transactionForm inputboxWidth form-control" onchange="editServicesSubtotalInvoice()" placeholder="$ 0.00" />

                        <label class="labelStyle inputboxAlignment labelAlignment" ><i class="fa fa-dollar"></i> Sub-Total</label>
                        <input type="text" name="servicesSubtotal" id="update_servicesSubtotal" class="transactionForm inputboxWidth form-control" placeholder="$ 0.00" readonly/>
                        
                        <div class="btnAlignment pull-right" > 
                            <button type="button" class=" formBtn btn btn-danger btn-sm btn-flat services_update_invoice" >
                                <i class="fa fa-cart-plus"></i> <b> - Insert Item in List - </b> 
                            </button>
                            <br/><br/>
                        </div>
                

                    </div>

                     <div class="col-md-8 modalInventoryDesignLside">
                     <br/>

                        <div class="update-item-in-list-invoice selectedItemContainer" id="update-item-in-list-invoice">
                            <div class="selectedItemContent">
                               <span class="selectedItemLabel" >
                                    <i class="fa fa-opencart"></i> Selected Auto-Parts & Services
                                </span>
                            </div>  
                            <hr/>
                        </div>
                        <br/>

                        <div class="pull-right" style="width: 25%;">
                            <span class="labelStyle"><center><b><i class="fa fa-dedent"></i> Gross Total </b></center></span>
                            <?= $form->field($model, 'grand_total')->textInput(['class' => 'inputForm inputboxTotalAlignment form-control', 'id' => 'update_grandTotal', 'placeholder' => '$ 0.00', 'readonly' => 'readonly'])->label(false) ?>

                            <span class="labelStyle"><center><b><i class="fa fa-percent"></i> GST </b></center></span>
                            <?= $form->field($model, 'gst')->textInput(['class' => 'inputForm inputboxTotalAlignment form-control', 'id' => 'update_gst', 'onchange' => 'getUpdateNetTotal()', 'value' => '0', 'placeholder' => '0.00'])->label(false) ?>
                            <input type="hidden" id="update_gst_amount" class="update_gst_amount" />

                            <span class="labelStyle"><center><b><i class="fa fa-globe"></i> Nett Total </b></center></span>
                            <?= $form->field($model, 'net')->textInput(['class' => 'inputForm inputboxTotalAlignment form-control', 'id' => 'update_netTotal', 'placeholder' => '$ 0.00', 'readonly' => 'readonly'])->label(false) ?>
                        </div>
                    </div>

                </div>
                <br/>

                <div class="row informationsContainer">
                
                <div class="headerLabelContainer" >
                    <span class="headerLabel" > <i class="fa fa-battery-1"></i> Discount Information</span>
                </div>
                <br/>

                <div class="col-md-4 col-xs-4 col-sm-4">
                    <label class="labelStyle"><i class="fa fa-minus-circle"></i> Discount Amount</label>
                    <?= $form->field($model, 'discount_amount')->textInput(['class' => 'inputForm form-control', 'id' => 'update_discountAmount', 'placeholder' => 'Write Discount amount here.', 'readonly' => 'readonly' ])->label(false) ?>
                </div>

                <div class="col-md-8 col-xs-8 col-sm-8">
                    <span class="labelStyle"><i class="fa fa-commenting"></i> Discount Remarks</span>
                    <?= $form->field($model, 'discount_remarks')->textArea(['class' => 'transactionDiscountTxtAreaForm form-control', 'id' => 'update_discountRemarks', 'placeholder' => 'Write Discount remarks here.', 'readonly' => 'readonly', 'rows' => 5 ])->label(false) ?>
                </div>
                <br/>

                <div class="col-md-12 col-xs-12 col-sm-12">
                    <div style="margin-top: -1px;">
                        <button type="button" class="btnUpdateDiscount formBtn btn btn-info pull-right" id="btnUpdateDiscount" ><i class="fa fa-battery-4"></i> Add Discount - </button>
                        <button type="button" class="submitUpdateDiscount formBtn btn btn-primary pull-right hidden" id="submitUpdateDiscount"><i class="fa fa-save"></i> Save Discount - </button>
                        <button type="button" class="clearUpdateDiscount formBtn btn btn-danger pull-right hidden" id="clearUpdateDiscount"><i class="fa fa-refresh"></i> Cancel - </button>
                    </div>
                </div>
                <br/>

                <div class="col-md-12 col-xs-12 col-sm-12"><br/></div>

                </div>
                
            <?php ActiveForm::end(); ?>
        </div>

        <div class="modal-footer">
            <?= Html::button('<li class=\'fa fa-refresh\'></li> Clear', ['id' => 'clearPIForms', 'class' => 'formBtn btn btn-default']) ?>
            <?= Html::submitButton('<li class=\'fa fa-paper-plane-o\'></li> Save Invoice', ['id' => 'saveUpdateInvoiceForm', 'class' => 'formBtn btn btn-primary']) ?>
        </div>
        <br/>

        </div>
    </div>
</div>


</div>
