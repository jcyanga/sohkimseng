<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use  yii\helpers\ArrayHelper;

use common\models\Supplier;
use common\models\Race;
use common\models\PaymentType;

$dataSupplier = ArrayHelper::map(Supplier::find()->where(['status' => 1])->all(),'id', 'name');
$dataRace = ArrayHelper::map(Race::find()->where(['status' => 1])->all(),'id', 'name');
$dataPaymentType = ArrayHelper::map(PaymentType::find()->where(['status' => 1])->all(),'id', 'name');
$salesPerson = Yii::$app->user->identity->id;

/* @var $this yii\web\View */
/* @var $model common\models\DeliveryOrder */

$this->title = 'Create Delivery Order for Customer';
$this->params['breadcrumbs'][] = ['label' => 'Delivery Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$n = 0;

?>

<div class="delivery-order-create divContainer">

<div class="row containerContentWrapper">

    <div class="col-md-12 col-sm-12 col-xs-12">       
        <div>
            <h4 class="divHeaderLabel"><i class="fa fa-clipboard"></i> <?= Html::encode($this->title) ?></h4>
        </div>
        <hr/>
    </div>

    <!-- <div class="col-md-12 col-sm-12 col-xs-12">
        <h4 class="divHeaderLabel pull-right">
            <i class="fa fa-users"></i> CUSTOMER NAME | <i class="fa fa-user-circle"></i> <?= strtoupper($customerInfo->fullname) ?> -
        </h4>
    </div> -->

<?php $form = ActiveForm::begin(['method' => 'post', 'id' => 'deliveryorderFormCreate']); ?>
    
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="row informationsContainer">
                
                <div class="headerLabelContainer" >
                    <span class="headerLabel" > <i class="fa fa-info-circle"></i> Customer Information</span>
                </div>
                <br/>

                    <div class="col-md-6">
                        <input type="hidden" id="customer" class="customer" value="<?= $customerInfo->id ?>" />

                        <label class="labelStyle"><i class="fa fa-barcode"></i> Delivery Order Code </label>
                        <?= $form->field($model, 'delivery_order_code')->textInput(['class' => 'transactionForm form-control', 'id' => 'delivery_order_code', 'value' => $deliveryorderCode, 'readonly' => 'readonly'])->label(false) ?>

                        <label class="labelStyle"><i class="fa fa-user-circle-o"></i> Sales Person </label>
                        <?= $form->field($model, 'user_id')->dropdownList(['0' => ' - PLEASE SELECT NAME HERE - '] + $dataUser, ['style' => 'width: 65%;', 'class' => 'inputForm select2', 'value' => $salesPerson, 'id' => 'sales_person', 'data-placeholder' => 'CHOOSE SALES PERSON HERE'])->label(false) ?>
                        
                        <label class="labelStyle"><i class="fa fa-money"></i> Payment Type </label>
                        <?= $form->field($model, 'payment_type_id')->dropdownList(['0' => ' - PLEASE SELECT PAYMENT TYPE HERE - '] + $dataPaymentType, ['style' => 'width: 65%;', 'class' => 'inputForm select2', 'id' => 'paymentType', 'data-placeholder' => 'CHOOSE PAYMENT TYPE HERE'])->label(false) ?>

                        <label class="labelStyle"><i class="fa fa-comments"></i> Remarks</label>
                        <?= $form->field($model, 'remarks')->textarea(['rows' => 5, 'class' => 'transactionTxtAreaForm form-control', 'id' => 'remarks', 'placeholder' => 'Write your remarks here.'])->label(false) ?> 
                        <br/>

                    </div>

                    <div class="col-md-6">
                        
                        <label class="labelStyle"><i class="fa fa-calendar-plus-o"></i> Date Issue</label>
                        <?= $form->field($model, 'date_issue')->textInput(['class' => 'transactionForm form-control date_issue', 'id' => 'datepicker', 'value' => $dateNow, 'readonly' => 'readonly'])->label(false) ?> 
                        <br/>

                        <?php if( $customerInfo->type == 1 ): ?>
                            <h5 class="divHeaderLabel">
                                <i class="fa fa-users"></i> CUSTOMER NAME | <i class="fa fa-user-circle"></i> <?= strtoupper($customerInfo->company_name) ?> -
                            </h5>
                        <?php else: ?>
                            <h5 class="divHeaderLabel">
                                <i class="fa fa-users"></i> CUSTOMER NAME | <i class="fa fa-user-circle"></i> <?= strtoupper($customerInfo->fullname) ?> -
                            </h5>
                        <?php endif; ?>

                        <div id="deliver-order-customer-information" class="deliver-order-customer-information" >
                            
                            <?php if( $customerInfo->type == 1 ): ?>

                                <table class="table table-hover table-striped viewTableContent">
                                    <tr>
                                        <td><b>UEN NO.</b></td>
                                        <td><?= strtoupper($customerInfo->uen_no) ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>EMAIL</b></td>
                                        <td><?= $customerInfo->email ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>PHONE NUMBER</b></td>
                                        <td><?= $customerInfo->phone_number ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>MOBILE NUMBER</b></td>
                                        <td><?= $customerInfo->mobile_number ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>FAX NUMBER</b></td>
                                        <td><?= $customerInfo->fax_number ?></td>
                                    </tr>
                                </table>
                        
                            <?php else: ?>

                                <table class="table table-hover table-striped viewTableContent">
                                    <tr>
                                        <td><b>NRIC NO.</b></td>
                                        <td><?= strtoupper($customerInfo->nric) ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>ADDRESS</b></td>
                                        <td><?= strtoupper($customerInfo->address) ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>SHIPPING ADDRESS</b></td>
                                        <td><?= strtoupper($customerInfo->shipping_address) ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>EMAIL</b></td>
                                        <td><?= $customerInfo->email ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>PHONE NUMBER</b></td>
                                        <td><?= $customerInfo->phone_number ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>MOBILE NUMBER</b></td>
                                        <td><?= $customerInfo->mobile_number ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>FAX NUMBER</b></td>
                                        <td><?= $customerInfo->fax_number ?></td>
                                    </tr>
                                </table>

                        <?php endif; ?>

                        </div>
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
                        <select name="parts" class="inputForm select2" id="parts" style="width: 95%;" onchange="getPartsPriceAndQtyDeliveryOrder()" data-placeholder="CHOOSE AUTO-PARTS HERE" >
                                <option value="0"> - PLEASE SELECT AUTO-PARTS HERE - </option>
                            <?php foreach($partsResult as $partsRow): ?>
                                <option value="<?= $partsRow['id']; ?>" > <?= $partsRow['parts_name']; ?> </option>
                            <?php endforeach; ?>
                        </select>

                        <label class="labelStyle inputboxAlignment labelAlignment" ><i class="fa fa-database"></i> Quantity</label>
                        <input type="text" name="partsQty" id="partsQty" class="transactionForm inputboxWidth form-control" onchange="updatePartsSubtotalDeliveryOrder()" placeholder="0" />
                        <input type="hidden" id="currentQtyValue" class="currentQtyValue" />
                        <label class="labelStyle inputboxAlignment labelAlignment" id="currentQtyStyle" >*Current Stock : </label> <span class="currentQtyContent" id="currentQty" >0</span>
                        <br/>

                        <label class="labelStyle inputboxAlignment labelAlignment" ><i class="fa fa-gg-circle"></i> Unit-Price</label>
                        <input type="text" name="partsPrice" id="partsPrice" class="transactionForm inputboxWidth form-control" placeholder="$ 0.00" readonly/>

                        <label class="labelStyle inputboxAlignment labelAlignment" ><i class="fa fa-dollar"></i> Sub-Total</label>
                        <input type="text" name="partsSubtotal" id="partsSubtotal" class="transactionForm inputboxWidth form-control" placeholder="$ 0.00" readonly/>

                        <div class="btnAlignment pull-right" > 
                            <button type="button" class=" formBtn btn btn-success btn-sm btn-flat add_autoparts_deliveryorder" >
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
                        <select name="services" class="inputForm selectboxWidth select2" id="services" style="width: 95%;" onchange="getServicesPriceAndQtyDeliveryOrder()" data-placeholder="CHOOSE SERVICES HERE" >
                                <option value="0"> - PLEASE SELECT SERVICES HERE - </option>
                            <?php foreach($servicesResult as $servicesRow): ?>
                                <option value="<?= $servicesRow['id']; ?>">[ <?= $servicesRow['name']; ?> ] <?= $servicesRow['service_name']; ?> </option>
                            <?php endforeach; ?>
                        </select>

                        <span class="pull-right btn btn-link" id="editServiceDetailsBtn" style="font-size: 11px;">
                            <a href="javascript:updateServiceDetailsDeliveryOrder()" class="selectedBtns" >
                                <b><i class="fa fa-pencil"></i> Update Service Details</b>
                            </a>
                        </span>

                        <span class="pull-right btn btn-link hidden" id="saveServiceDetailsBtn" style="font-size: 11px;">
                            <a href="javascript:saveServiceDetailsDeliveryOrder()" class="selectedBtns" >
                                <b><i class="fa fa-save"></i> Save Service Details</b>
                            </a>
                        </span>
                        <br/><br/>

                        <input type="hidden" id="serviceCategory" class="serviceCategory" />
                        <textarea class="transactionTxtAreaForm form-control editFormServiceDetails hidden" rows="5" id="editFormServiceDetails" placeholder="Write service details"></textarea>

                        <label class="labelStyle inputboxAlignment labelAlignment" ><i class="fa fa-database"></i> Quantity</label>
                        <input type="text" name="servicesQty" id="servicesQty" class="transactionForm inputboxWidth form-control" onchange="updateServicesSubtotalDeliveryOrder()" placeholder="0" />

                        <label class="labelStyle inputboxAlignment labelAlignment" ><i class="fa fa-gg-circle"></i> Unit-Price</label>
                        <input type="text" name="servicesPrice" id="servicesPrice" class="transactionForm inputboxWidth form-control" onchange="updateServicesSubtotalDeliveryOrder()" placeholder="$ 0.00" />

                        <label class="labelStyle inputboxAlignment labelAlignment" ><i class="fa fa-dollar"></i> Sub-Total</label>
                        <input type="text" name="servicesSubtotal" id="servicesSubtotal" class="transactionForm inputboxWidth form-control" placeholder="$ 0.00" readonly/>
                        
                        <div class="btnAlignment pull-right" > 
                            <button type="button" class=" formBtn btn btn-danger btn-sm btn-flat add_services_deliveryorder" >
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
        <br/>
    </div>

<?php ActiveForm::end(); ?>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="pull-right">
        <?= Html::button('<li class=\'fa fa-refresh\'></li> Clear', ['id' => 'clearPIForms', 'class' => 'formBtn btn btn-default']) ?>
        <?= Html::submitButton('<li class=\'fa fa-paper-plane-o\'></li> Submit Delivery Order', ['id' => 'submitDeliveryOrderFormFromCustomer', 'class' => 'formBtn btn btn-primary']) ?>
    </div>
    <br/><br/><br/>
</div>

</div>

</div>


