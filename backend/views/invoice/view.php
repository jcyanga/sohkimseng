<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use  yii\helpers\ArrayHelper;

use common\models\Supplier;
use common\models\Race;

$dataSupplier = ArrayHelper::map(Supplier::find()->all(),'id', 'name');
$dataRace = ArrayHelper::map(Race::find()->all(),'id', 'name');
/* @var $this yii\web\View */
/* @var $model common\models\Invoice */

$this->title = 'View Invoice';
$this->params['breadcrumbs'][] = ['label' => 'Invoices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$n = 0;

?>

<div class="invoice-view divContainer">

    <div class="row containerContentWrapper">
    <br/>

    <section class="content invoice">

        <!-- branch info row -->
        <div class="row">
            <div class="col-md-12 invoice-col">
            <br/>
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
        <div class="row invoice-info customerRowWrapper">
            
            <div class="col-sm-12 invoice-col">
            <br/>
                <address class="customerRowContainer" >
                    <b>Sold To</b>
                    <br/><b>EXPRESS FREIGHT MANAGEMENT PTE LTD</b> 
                    <br>20 MAXWELL ROAD, #06-12 MAXWELL HOUSE SINGAPORE 069113
                    <br><b>TEL :</b> 6662 6988 
                    <br><b>FAX :</b> 6221 3325 
                    <br><b>ATTN :</b> MS MICHELLE 
                </address>
            </div>
        </div>
        <br/>

        <div class="row invoice-info customerRowWrapper">
            
            <div class="col-sm-12 invoice-col">
            <br/>
                <address class="customerRowContainer" >
                    <b>Ship To / Remark :</b>
                    <br/><b>EXPRESS FREIGHT MANAGEMENT PTE LTD</b> 
                    <br>20 MAXWELL ROAD, #06-12 MAXWELL HOUSE SINGAPORE 069113
                    <br><b>TEL :</b> 6662 6988 
                    <br><b>FAX :</b> 6221 3325 
                    <br><b>ATTN :</b> MS MICHELLE 
                </address>
            </div>
        </div>
        <br/>
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
                        <?php foreach( $getInvoiceServicesInfo as $invoicesRow ): ?>
                            <tr>
                                <td class="servicespartsLists" ><?= $invoicesRow['quantity'] ?></td>
                                <td class="servicespartsLists" ></td>
                                <td class="servicespartsLists" ><?= $invoicesRow['name'] ?></td>
                                <td class="servicespartsLists" ><?= number_format($invoicesRow['unit_price'],2) ?></td>
                                <td class="servicespartsLists" ></td>
                                <td class="servicespartsLists" ><?= number_format($invoicesRow['sub_total'],2) ?></td>
                            </tr> 
                        <?php endforeach; ?>
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
            </div>
        
            <div class="col-xs-6 amountdueContainer">
            <br/>
                <p class="lead remarksamountdueHeader"><i class="fa fa-calculator"></i> Amount Due.</p>
                <div class="table-responsive">
                    <table class="table amountdueTbl">
                        <tbody>
                            <tr>
                                <th style="width:50%;" class="amountdueTh" >Sub Total :</th>
                                <td class="amountdueTd" > <?= number_format($getInvoiceInfo['grand_total'],2) ?> </td>
                            </tr>
                            <tr>
                                <th class="amountdueTh" >GST(7.00%) :</th>
                                <td class="amountdueTd" > <?= number_format($getInvoiceInfo['gst'],2) ?> </td>
                            </tr>
                            <tr>
                                <th class="amountdueTh" >Amount Due :</th>
                                <td class="amountdueTd" > <?= number_format($getInvoiceInfo['net'],2) ?> </td>
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
                
                <a class="_showUpdateInvoiceModal" id="<?= $getInvoiceInfo['id'] ?>" ><button class="form-btn btn btn-warning btn-sm"><i class="fa fa-edit"></i> Update Quotation</button></a>
                
                <a class="invoiceDeleteColumn" id="<?= $getInvoiceInfo['id'] ?>" ><button class="form-btn btn btn-danger btn-sm" style=""><i class="fa fa-trash"></i> Delete Quotation</button></a>

                <div class="pull-right">
            
                    <a class="invoiceApproveColumn" id="<?= $getInvoiceInfo['id'] ?>" ><button class="form-btn btn btn-primary btn-sm" ><i class="fa fa-question-circle-o"></i> Approve</button></a>

                    <a href="?r=quotation/insert-delivery-order&id=<?= $getInvoiceInfo['id'] ?>"><button class="form-btn btn btn-info btn-sm"><i class="fa fa-pencil-square-o"></i> Generate Delivery Order</button></a>

                    <a href="?r=quotation/preview&id=<?= $getInvoiceInfo['id'] ?>"><button class="form-btn btn btn-success btn-sm " ><i class="fa fa-print"></i> Print Invoice</button></a>

                </div>

            </div>
        </div>
        <!-- /.row -->
        
    </section>
    <br/>
    </div>

</div>

<!-- Update Quotation -->
<div class="modal fade modalBackground" id="modal-launcher-update-invoice" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog modalInventoryDesign" >
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close closeUpdateInvoice" >&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-edit"></i> Update Invoice </h5>
            </div>

        <div class="modal-body">
            <?php $form = ActiveForm::begin(['method' => 'post', 'id' => 'invoiceFormUpdate']); ?>
                
                <div class="row informationsContainer">
                
                <div class="headerLabelContainer" >
                    <span class="headerLabel" > <i class="fa fa-info-circle"></i> Customer Information</span>
                </div>
                <br/>

                    <div class="col-md-6">
                        <input type="hidden" name="invoice_id" id="invoice_id" />

                        <label class="labelStyle"><i class="fa fa-barcode"></i> Quotation Code</label>
                        <?= $form->field($model, 'invoice_no')->textInput(['class' => 'transactionForm form-control', 'id' => 'update_invoice_no', 'readonly' => 'readonly'])->label(false) ?>

                        <label class="labelStyle"><i class="fa fa-users"></i> Customer Name</label>
                        <?= $form->field($model, 'customer_id')->dropdownList(['0' => ' - PLEASE SELECT NAME HERE - '] + $dataCustomer, ['style' => 'width: 65%;', 'class' => 'inputForm select2', 'id' => 'update_customer', 'data-placeholder' => 'CHOOSE CUSTOMER NAME HERE'])->label(false) ?>

                        <label class="labelStyle"><i class="fa fa-user-circle-o"></i> Sales Person </label>
                        <?= $form->field($model, 'user_id')->dropdownList(['0' => ' - PLEASE SELECT NAME HERE - '] + $dataUser, ['style' => 'width: 65%;', 'class' => 'inputForm select2', 'id' => 'update_sales_person', 'data-placeholder' => 'CHOOSE SALES PERSON HERE'])->label(false) ?>
                        <br/>

                    </div>

                    <div class="col-md-6">
                        
                        <label class="labelStyle"><i class="fa fa-calendar-plus-o"></i> Date Issue</label>
                        <?= $form->field($model, 'date_issue')->textInput(['class' => 'transactionForm form-control update_date_issue', 'id' => 'datepicker', 'value' => $dateNow, 'readonly' => 'readonly'])->label(false) ?>

                        <label class="labelStyle"><i class="fa fa-comments"></i> Remarks</label>
                        <?= $form->field($model, 'remarks')->textarea(['rows' => 4, 'class' => 'transactionTxtAreaForm form-control', 'id' => 'update_remarks', 'placeholder' => 'Write your remarks here.'])->label(false) ?>    
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
                                <option value="<?= $partsRow['id']; ?>" >[<?= $partsRow['name']; ?>] <?= $partsRow['parts_name']; ?> </option>
                            <?php endforeach; ?>
                        </select>

                        <label class="labelStyle inputboxAlignment labelAlignment" ><i class="fa fa-database"></i> Quantity</label>
                        <input type="text" name="partsQty" id="update_partsQty" class="transactionForm inputboxWidth form-control" onchange="editPartsSubtotalInvoice()" placeholder="0" />

                        <label class="labelStyle inputboxAlignment labelAlignment" ><i class="fa fa-gg-circle"></i> Unit-Price</label>
                        <input type="text" name="partsPrice" id="update_partsPrice" class="transactionForm inputboxWidth form-control" onchange="editPartsSubtotalInvoice()" placeholder="$ 0.00" />

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
                                <option value="<?= $servicesRow['id']; ?>"> - <?= $servicesRow['service_name']; ?> </option>
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

                        <textarea class="transactionTxtAreaForm form-control updateFormServiceDetails hidden" id="updateFormServiceDetails" placeholder="Write service details"></textarea>

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
                        </div>
                        <br/><br/><br/>

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

            <?php ActiveForm::end(); ?>
        </div>

        <div class="modal-footer">
            <?= Html::button('<li class=\'fa fa-refresh\'></li> Clear', ['id' => 'clearPIForms', 'class' => 'formBtn btn btn-default']) ?>
            <?= Html::submitButton('<li class=\'fa fa-paper-plane-o\'></li> Save Quotation', ['id' => 'saveUpdateInvoiceForm', 'class' => 'formBtn btn btn-primary']) ?>
        </div>
        <br/>

        </div>
    </div>
</div>
