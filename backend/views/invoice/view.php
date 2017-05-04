<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
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
/* @var $model common\models\Invoice */

$this->title = 'View Invoice';
$this->params['breadcrumbs'][] = ['label' => 'Invoices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$roleId = Yii::$app->user->identity->role_id;

$n = 0;

?>

<div class="invoice-view divContainer">

    <div class="row containerContentWrapper">
    <br/>

    <section class="content invoice">

        <!-- payment status info row -->
        <?php if( $getInvoiceInfo['do'] == 1 ): ?>
            <div class="row">    
                <div class="col-md-12 invoice-col">
                <br/>
                    <h3><b> <i class="fa fa-ioxhost"></i> DELIVERY ORDER <i class="fa fa-contao"></i>REATED </b></h3>
                </div>
            </div>
        <?php endif; ?>
        <!-- /.row -->

        <!-- branch info row -->
        <div class="row">
            <div class="col-md-12 invoice-col">
                <address class="branchRowContainer">
                    <h4><b><i class="fa fa-opencart"></i> SOH KIM SENG ENGINEERING & TRADING PTE LTD </b></h4>
                    245 JALAN AHMAD IBRAHIM SINGAPORE 629144
                    <br><b>TEL #:</b> 6897 7060
                    <br><b>FAX :</b> 6897 70599
                    <br><b>EMAIL :</b> general@skset.com
                    <br><b>WEBSITE :</b> http://www.skset.com
                    <br><b>BUSINESS REG. NO. :</b> 198305727N
                </address>
            </div>
        </div>
        <!-- /.row -->

        <!-- code and date row -->
        <div class="row">
            <div class="col-xs-12 invoice-header">
                <h3>
                <small class="pull-left quoteCodeAndDate" ><i class="fa fa-globe"></i> <?= $getInvoiceInfo['invoice_no'] ?> </small>
                <small class="pull-right quoteCodeAndDate" ><i class="fa fa-calendar-plus-o"></i> Date Issue : <?= date('m/d/Y', strtotime($getInvoiceInfo['date_issue'])) ?> </small>
                </h3>
            </div>
        </div>
        <br/>
        <!-- /.row -->

        <!-- customer info row -->
        <?php if( $getInvoiceInfo['type'] == 1 ): ?>

            <div class="row invoice-info customerRowWrapper">
                
                <div class="col-sm-12 invoice-col">
                <br/>
                    <address class="customerRowContainer" >
                        <b>Sold To :</b>
                        <br/><b><?= $getInvoiceInfo['company_name'] ?></b> 
                        <br><b>TEL :</b>  <?= $getInvoiceInfo['phone_number'] ?> / <?= $getInvoiceInfo['mobile_number'] ?>
                        <br><b>FAX :</b>  <?= $getInvoiceInfo['fax_number'] ?>
                        <br><b>ATTN :</b>  
                    </address>
                </div>
            </div>
            <br/>

            <div class="row invoice-info customerRowWrapper">
                
                <div class="col-sm-12 invoice-col">
                <br/>
                    <address class="customerRowContainer" >
                        <b>Ship To / Remark :</b>
                        <br/><b><?= $getInvoiceInfo['company_name'] ?></b> 
                        <br><b>TEL :</b>  <?= $getInvoiceInfo['phone_number'] ?> / <?= $getInvoiceInfo['mobile_number'] ?>
                        <br><b>FAX :</b>  <?= $getInvoiceInfo['fax_number'] ?>
                        <br><b>ATTN :</b>  
                    </address>
                </div>
            </div>
            <br/>
        
        <?php else: ?>

            <div class="row invoice-info customerRowWrapper">
                
                <div class="col-sm-12 invoice-col">
                <br/>
                    <address class="customerRowContainer" >
                        <b>Sold To :</b>
                        <br/><b><?= $getInvoiceInfo['customerName'] ?></b> 
                        <br><?= $getInvoiceInfo['address'] ?>
                        <br><b>TEL :</b>  <?= $getInvoiceInfo['phone_number'] ?> / <?= $getInvoiceInfo['mobile_number'] ?>
                        <br><b>FAX :</b>  <?= $getInvoiceInfo['fax_number'] ?>
                    </address>
                </div>
            </div>
            <br/>

            <div class="row invoice-info customerRowWrapper">
                
                <div class="col-sm-12 invoice-col">
                <br/>
                    <address class="customerRowContainer" >
                        <b>Ship To / Remark :</b>
                        <br/><b><?= $getInvoiceInfo['customerName'] ?></b> 
                        <br><?= $getInvoiceInfo['shipping_address'] ?>
                        <br><b>TEL :</b>  <?= $getInvoiceInfo['phone_number'] ?> / <?= $getInvoiceInfo['mobile_number'] ?>
                        <br><b>FAX :</b>  <?= $getInvoiceInfo['fax_number'] ?>
                    </address>
                </div>
            </div>
            <br/>

        <?php endif; ?>
        <!-- /.row -->
        
        <!-- Services and Parts Info row -->
        <div id="selectedServicesParts" class="row">
            <div class="col-xs-12 table">
                <table id="selecteditems" class="table table-boardered">
                    <thead>
                        <tr class="qpreviewth">
                            <th class="servicespartsContainerHeader" > Qty Shp. </th>
                            <th class="servicespartsContainerHeader" > Item Number </th>
                            <th class="servicespartsContainerHeader" > Description </th>
                            <th class="servicespartsContainerHeader" > Unit Price (SGD) </th>
                            <th class="servicespartsContainerHeader" > UOM </th>
                            <th class="servicespartsContainerHeader" > Extended Price (SGD) </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach( $getInvoicePartsInfo as $invoicepRow ): ?>
                            <tr>
                                <td class="servicespartsLists" ><?= $invoicepRow['quantity'] ?></td>
                                <td class="servicespartsLists" ><?= $invoicepRow['parts_code'] ?></td>
                                <td class="servicespartsLists" ><?= $invoicepRow['name'] ?></td>
                                <td class="servicespartsLists" ><?= number_format($invoicepRow['unit_price'],2) ?></td>
                                <td class="servicespartsLists" ><?= $invoicepRow['unit_of_measure'] ?></td>
                                <td class="servicespartsLists" ><?= number_format($invoicepRow['sub_total'],2) ?></td>
                            </tr> 
                        <?php endforeach; ?>
                        <?php foreach( $getInvoiceServicesInfo as $invoicesRow ): ?>
                            <tr>
                                <td class="servicespartsLists" ></td>
                                <td class="servicespartsLists" ></td>
                                <td class="servicespartsLists" ><?= $invoicesRow['name'] ?></td>
                                <td class="servicespartsLists" ><?= number_format($invoicesRow['unit_price'],2) ?></td>
                                <td class="servicespartsLists" ></td>
                                <td class="servicespartsLists" ><?= number_format($invoicesRow['sub_total'],2) ?></td>
                            </tr> 
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.row -->

        <!-- Remarks and Amount Due Info row -->
        <div id="paymentMethod" class="row remarksamountdueWrapper">
            <div class="col-xs-6">
            <br>
                <p class="lead remarksamountdueHeader"><i class="fa fa-comments"></i> Remarks.</p>
                <p class="text-muted well well-sm no-shadow quoPreviewRemarks remarksContent" >
                    - <?= $getInvoiceInfo['remarks'] ?>
                </p>
            
                <p class="lead remarksamountdueHeader"><i class="fa fa-comments-o"></i> Discount Remarks.</p>
                <p class="text-muted well well-sm no-shadow quoPreviewRemarks remarksContent" >
                    - <?= $getInvoiceInfo['discount_remarks'] ?>
                </p>
            </div>
        
            <div class="col-xs-6 amountdueContainer">
            <br/>
                <p class="lead remarksamountdueHeader"><i class="fa fa-calculator"></i> Amount Due.</p>
                <div class="table-responsive">
                    <table class="table amountdueTbl">
                        <tbody>
                            <tr>
                                <th style="width:40%;" class="amountdueTh" >Sub-Total :</th>
                                <td class="amountdueTd" >$ <?= number_format($getInvoiceInfo['grand_total'],2) ?> </td>
                            </tr>
                            <tr>
                                <th class="amountdueTh" >Less Pert. Discount :</th>
                                <td class="amountdueTd" >$ <?= number_format($getInvoiceInfo['discount_amount'],2) ?> </td>
                            </tr>
                            <tr>
                                <th class="amountdueTh" >GST(7.00%) :</th>
                                <td class="amountdueTd" >$ <?= number_format($getInvoiceInfo['gst'],2) ?> </td>
                            </tr>
                            <tr>
                                <th class="amountdueTh" style="font-size: 12px;" >Amount Due :</th>
                                <td class="amountdueTd" >$ <?= number_format($getInvoiceInfo['net'],2) ?> </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.row -->

        <!-- button container -->
        <hr/>
        <div class="row no-print">
            <div class="col-md-12">
                
                <?php if($roleId <= 2): ?>
                    <?php if( $getInvoiceInfo['condition'] == 0 ): ?>
                        <a class="invoiceApproveColumn" id="<?= $getInvoiceInfo['id'] ?>" ><button class="form-btn btn btn-primary btn-sm" ><i class="fa fa-check-circle"></i> Approve</button></a>
                    <?php endif; ?>

                    <?php if( $getInvoiceInfo['condition'] == 1 ): ?>
                        <a class="invoiceCloseColumn" id="<?= $getInvoiceInfo['id'] ?>" ><button class="form-btn btn btn-primary btn-sm" ><i class="fa fa-minus-circle"></i> Close</button></a>
                    <?php endif; ?>

                    <a class="invoiceCancelColumn" id="<?= $getInvoiceInfo['id'] ?>" ><button class="form-btn btn btn-danger btn-sm" ><i class="fa fa-times-circle"></i> Cancel</button></a>
                <?php endif; ?>

                <div class="pull-right">
                    <?php if($getInvoiceInfo['condition'] == 0 && $getInvoiceInfo['do'] == 0): ?>
                        <a class="_showUpdateInvoiceModal" id="<?= $getInvoiceInfo['id'] ?>" ><button class="form-btn btn btn-warning btn-sm"><i class="fa fa-edit"></i> Update Invoice</button></a>
                    <?php endif; ?>

                    <?php if( $getInvoiceInfo['condition'] == 1 && $getInvoiceInfo['do'] == 0): ?>
                        <a class="_invoiceInsertIntoDO" id="<?= $getInvoiceInfo['id'] ?>" ><button class="form-btn btn btn-info btn-sm"><i class="fa fa-pencil-square-o"></i> Generate Delivery Order</button></a>
                    <?php endif; ?>

                    <a href="?r=quotation/preview&id=<?= $getInvoiceInfo['id'] ?>"><button class="form-btn btn btn-default btn-sm " ><i class="fa fa-paw"></i> Proceed to Payment</button></a>

                    <a href="?r=quotation/preview&id=<?= $getInvoiceInfo['id'] ?>"><button class="form-btn btn btn-success btn-sm " ><i class="fa fa-print"></i> Print Invoice</button></a>

                </div>

            </div>
        </div>
        <!-- /.row -->
        
    </section>
    <br/>
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





