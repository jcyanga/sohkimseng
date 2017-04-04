<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use  yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Quotation */

$this->title = 'Create Quotation for Customer';
$this->params['breadcrumbs'][] = ['label' => 'Quotations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$n = 0;

?>

<div class="quotation-view divContainer">

<div class="row containerContentWrapper">

    <div class="col-md-12 col-sm-12 col-xs-12">       
        <div>
            <h4 class="divHeaderLabel"><i class="fa fa-clipboard"></i> <?= Html::encode($this->title) ?></h4>
        </div>
        <hr/>
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12">
        <h4 class="divHeaderLabel pull-right">
            <i class="fa fa-users"></i> CUSTOMER NAME | <i class="fa fa-user-circle"></i> <?= strtoupper($customerInfo->fullname) ?> -
        </h4>
    </div>

<?php $form = ActiveForm::begin(['method' => 'post', 'id' => 'quoteFormCreate']); ?>
    
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="row informationsContainer">
            
            <div class="headerLabelContainer" >
                <span class="headerLabel" > <i class="fa fa-info-circle"></i> Customer Information</span>
            </div>
            <br/>

                <div class="col-md-6">
                    <input type="hidden" name="customer" id="customer" value="<?= $customerInfo->id ?>" />

                    <label class="labelStyle"><i class="fa fa-barcode"></i> Quotation Code</label>
                    <?= $form->field($model, 'quotation_code')->textInput(['class' => 'transactionForm form-control', 'id' => 'quotation_code', 'value' => $quotationCode, 'readonly' => 'readonly'])->label(false) ?>

                    <label class="labelStyle"><i class="fa fa-user-circle-o"></i> Sales Person </label>
                    <?= $form->field($model, 'user_id')->dropdownList(['0' => ' - PLEASE SELECT NAME HERE - '] + $dataUser, ['style' => 'width: 65%;', 'class' => 'inputForm select2', 'id' => 'sales_person', 'data-placeholder' => 'CHOOSE SALES PERSON HERE'])->label(false) ?>
                    
                    <label class="labelStyle"><i class="fa fa-comments"></i> Remarks</label>
                    <?= $form->field($model, 'remarks')->textarea(['rows' => 4, 'class' => 'transactionTxtAreaForm form-control', 'id' => 'remarks', 'placeholder' => 'Write your remarks here.'])->label(false) ?>    
                    <br/>

                </div>

                <div class="col-md-6">
                    
                    <label class="labelStyle"><i class="fa fa-calendar-plus-o"></i> Date Issue</label>
                    <?= $form->field($model, 'date_issue')->textInput(['class' => 'transactionForm form-control date_issue', 'id' => 'datepicker', 'value' => $dateNow, 'readonly' => 'readonly'])->label(false) ?>

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
                    </div>
                    <br/><br/><br/>

                </div>

                 <div class="col-md-8 modalInventoryDesignLside">
                 <br/>

                    <div class="insert-item-in-list selectedItemContainer" id="insert-item-in-list">
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
                        <?= $form->field($model, 'grand_total')->textInput(['class' => 'inputForm inputboxTotalAlignment form-control', 'id' => 'grandTotal', 'placeholder' => '$ 0.00', 'readonly' => 'readonly'])->label(false) ?>

                        <span class="labelStyle"><center><b><i class="fa fa-percent"></i> GST </b></center></span>
                        <?= $form->field($model, 'gst')->textInput(['class' => 'inputForm inputboxTotalAlignment form-control', 'id' => 'gst', 'onchange' => 'getNetTotal()', 'value' => '0', 'placeholder' => '0.00'])->label(false) ?>
                        <input type="hidden" id="gst_amount" class="gst_amount" />

                        <span class="labelStyle"><center><b><i class="fa fa-globe"></i> Nett Total </b></center></span>
                        <?= $form->field($model, 'net')->textInput(['class' => 'inputForm inputboxTotalAlignment form-control', 'id' => 'netTotal', 'placeholder' => '$ 0.00', 'readonly' => 'readonly'])->label(false) ?>
                    </div>
                </div>
        </div>
        <br/>
    </div>

<?php ActiveForm::end(); ?>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="pull-right">
        <?= Html::button('<li class=\'fa fa-refresh\'></li> Clear', ['id' => 'clearPIForms', 'class' => 'formBtn btn btn-default']) ?>
        <?= Html::submitButton('<li class=\'fa fa-paper-plane-o\'></li> Submit Quotation', ['id' => 'submitQuotationFormFromCustomer', 'class' => 'formBtn btn btn-primary']) ?>
    </div>
    <br/><br/>
</div>

</div>

</div>


