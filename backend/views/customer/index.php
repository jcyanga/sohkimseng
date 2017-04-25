<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use common\models\Race;
/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchCustomer */
/* @var $dataProvider yii\data\ActiveDataProvider */

$dataRace = ArrayHelper::map(Race::find()->where(['status' => 1])->all(),'id', 'name');
$dataCustomerType = array('0' => '- CHOOSE CUSTOMER TYPE HERE -', '1' => '- For Company', '2' => '- For Individual');

$this->title = 'Customer Maintenance';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="customer-index divContainer">

<div class="row containerHeadWrapper">
    
    <div class="col-md-12 col-sm-12 col-xs-12">
        
        <div>
            <h4 class="divHeaderLabel"><i class="fa fa-users"></i> <?= Html::encode($this->title) ?></h4>
        </div>
        <hr/>

    <?php  echo $this->render('_search', [
                            'model' => $searchModel ]); 
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
            'label' => 'CUSTOMER CODE',
            'value' => 'customer_code',
            'options' => ['style' => 'color: #444']
        ],
        [
            'header' => 'Customer Name',
            'options' => ['style' => 'color: #444'],
            'value' => function($model)
            {   
                if($model->type == 1)
                {
                    return $model->company_name;
                }
                else
                {   
                    return $model->fullname;
                }
            },
        ],
        [
            'label' => 'LOCATION',
            'value' => 'location',
            'options' => ['style' => 'color: #444']
        ],
        [
            'label' => 'PHONE NUMBER',
            'value' => 'phone_number',
            'options' => ['style' => 'color: #444']
        ],
    [
        'class' => 'yii\grid\ActionColumn',
        'header' => 'Action',
        'options' => ['style' => 'color: #444'],
        'template' => '{preview}{update}{delete}',
        'buttons' => [
            'preview' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-eye-open"></span> ', $url, ['class' => '_showViewCustomerModal', 'id' => $model->id, 'title' => Yii::t('app', 'Preview'),
                ]);
            },
            'update' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-pencil"></span> ', $url, ['class' => '_showUpdateCustomerModal', 'id' => $model->id, 'title' => Yii::t('app', 'Update'),
                ]);
            },
            'delete' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-trash"></span> ', $url, ['class' => 'customerDeleteColumn', 'id' => $model->id, 'title' => Yii::t('app', 'Delete'),
                ]);
            },
        ],
        'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'preview') {
                $url ='#';
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
        <?= Html::button('<li class=\'fa fa-user-plus\'></li> New Customer -',['class' => '_showCreateCustomerModal formBtn btn btn-block btn-success btn-sm']) ?>
    </div>

</div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 table table-striped table-responsive contentWrapper">
    <?=
        GridView::widget([
            'id' => 'tableID',
            'class' => 'table table-hover',
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
            'showFooter'=> false,
        ]); 
    ?>
</div>
<br/>

<div class="col-md-12 col-sm-12 col-xs-12">
<div class="row">

<div class="col-md-4 pull-right">

    <div class="row">    
        <div class="col-md-6">
            <?= Html::button('<li class=\'fa fa-download\'></li> Export to Excel -',['class' => 'formBtn btn btn-block btn-warning btn-xs', 'onclick' => "excelExportCustomer()"]) ?>
        </div>
        <div class="col-md-6">
            <a href="?r=customer/export-pdf"onclick="return pdfExport()" class="formBtn btn btn-block btn-danger btn-xs">
                <i class="fa fa-download"></i> Export to PDF -
            </a>
        </div>
    </div>

</div>
</div>
<br/><br/>

</div>

</div>

<!-- Create -->
<div class="modal fade modalBackground" id="modal-launcher-create-customer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close closeNewCustomer" >&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-laptop"></i> New Customer</h5>
            </div>

        <div class="modal-body">
            <?php $form = ActiveForm::begin(['method' => 'post', 'id' => 'customerFormCreate']); ?>
                
                <div class="row">
                    <div class="col-md-6 col-xs-6 col-sm-6">
                        <label class="labelStyle">Customer Type</label>
                        <?= $form->field($model, 'type')->dropdownList($dataCustomerType, ['style' => 'width: 100%;', 'class' => 'inputForm select2', 'id' => 'customerType', 'data-placeholder' => 'PLEASE CHOOSE CUSTOMER TYPE HERE'])->label(false) ?>
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
                            <?= $form->field($model, 'company_name')->textInput(['class' => 'inputForm form-control', 'id' => 'companyName', 'placeholder' => 'Enter Company name here.'])->label(false) ?>
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
                            <button type="button" class="formBtn btn btn-block btn-flat btn-info btn-xs" id="btnAddInformation" ><i class="fa fa-plus-circle"></i> Add Information - </button>
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
                            <?= $form->field($model, 'fullname')->textInput(['class' => 'inputForm form-control', 'id' => 'fullname', 'placeholder' => 'Enter Fullname here.'])->label(false) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <label class="labelStyle">Location</label>
                            <input type="text" name="individual_location" class="inputForm form-control" placeholder="Enter Customer location here." id="individualLocation" />
                        </div>
                    </div>
                    <br/>

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
                            <?= $form->field($model, 'race_id')->dropdownList(['0' => ' - CHOOSE RACE HERE - '] + $dataRace,['style' => 'width: 100%;', 'class' => 'inputForm select2', 'id' => 'customerRace', 'data-placeholder' => 'PLEASE CHOOSE RACE HERE'])->label(false) ?>

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
            <?= Html::submitButton('<li class=\'fa fa-paper-plane-o\'></li> Submit Record', ['id' => 'submitCustomerFormCreate', 'class' => 'formBtn btn btn-primary']) ?>
        </div>

        </div>
    </div>
</div>

<!-- Update -->
<div class="modal fade modalBackground" id="modal-launcher-update-customer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close closeUpdateCustomer" >&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-edit"></i> Update Customer</h5>
            </div>

        <div class="modal-body">
            <?php $form = ActiveForm::begin(['method' => 'post', 'id' => 'customerFormUpdate']); ?>
                <input type="hidden" name="id" id="id" />

                <div class="row">
                    <div class="col-md-6 col-xs-6 col-sm-6">
                        <label class="labelStyle">Customer Type</label>
                        <?= $form->field($model, 'type')->dropdownList($dataCustomerType, ['style' => 'width: 100%;', 'class' => 'inputForm select2', 'id' => 'updateCustomerType', 'data-placeholder' => 'PLEASE CHOOSE CUSTOMER TYPE HERE'])->label(false) ?>
                    </div>
                </div>
                <hr/>

                <div id="forUpdateCompany">
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <label class="labelStyle">Customer Code</label>
                            <input type="text" name="customer_code" class="inputForm form-control readonlyForm" id="updateCompanyCustomerCode" readonly = "readonly" />
                        </div>
                    </div>
                    <br/>

                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <label class="labelStyle">Company Name</label>
                            <?= $form->field($model, 'company_name')->textInput(['class' => 'inputForm form-control', 'id' => 'updateCompanyName', 'placeholder' => 'Enter Company name here.'])->label(false) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <label class="labelStyle">Location</label>
                            <input type="text" name="company_location" class="inputForm form-control" placeholder="Enter Customer location here." id="updateCompanyLocation" />
                        </div>
                    </div>
                    <br/>

                    <label class="labelStyle">Contact Person</label>
                    <input type="text" name="contact_person" class="inputForm form-control" placeholder="Enter Contact person here." id="updateCompanyContactPerson" />
                    <br/>

                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <label class="labelStyle">Company Address</label>
                            <textarea name="company_address" rows="5" class="inputForm form-control" placeholder="Enter Company address here." id="updateCompanyAddress" ></textarea>
                        </div>
                        <div style="margin-top: 10px;" class="col-md-3 col-xs-3 col-sm-3 pull-right">
                            <button type="button" class="formBtn btn btn-block btn-flat btn-info btn-xs" id="btnAddInformationInEdit" ><i class="fa fa-plus-circle"></i> Add Information - </button>
                        </div>
                    </div>
                    <hr/>

                    <input type="hidden" id="n" value="<?= $getLastCompanyInfoId ?>" />
                    <div class="update-company-contactperson-address" id="update-company-contactperson-address" ></div>

                    <div class="row">
                        <div class="col-md-6 col-xs-6 col-sm-6">
                            <label class="labelStyle">Uen No.</label>
                            <input type="text" name="uen_no" class="inputForm form-control" placeholder="Enter UEN number here." id="updateCompanyUenNo" />
                            <br/>

                            <label class="labelStyle">E-mail Address</label>
                            <input type="text" name="company_email" class="inputForm form-control" placeholder="Enter Email address here." id="updateCompanyEmail"  />
                            <br/>

                            <label class="labelStyle">Phone Number</label>
                            <input type="text" name="company_hanphone" class="inputForm form-control" placeholder="Enter Phone number here." id="updateCompanyPhoneNumber" />
                        </div>
        
                        <div class="col-md-6 col-xs-6 col-sm-6">
                            <label class="labelStyle">Office Number</label>
                            <input type="text" name="company_officeno" class="inputForm form-control" placeholder="Enter Office number here." id="updateCompanyOfficeNumber" />
                            <br/>

                            <label class="labelStyle">Fax Number</label>
                            <input type="text" name="company_faxno" class="inputForm form-control" placeholder="Enter Fax number here." id="updateCompanyFaxNumber" />
                        </div>
                    </div>
                    <br/>

                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <label class="labelStyle">Remarks</label>
                            <textarea name="company_remarks" rows="5" class="inputForm form-control" placeholder="Enter Company remarks here." id="updateCompanyRemarks" ></textarea>
                        </div>
                    </div>
                </div>

                <div id="forUpdateIndividual">
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <label class="labelStyle">Customer Code</label>
                            <input type="text" name="update_individual_customer_code" class="inputForm form-control readonlyForm" id="updateIndividualCustomerCode" readonly = "readonly" />
                        </div>
                    </div>
                    <br/>

                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <label class="labelStyle">Fullname</label>
                            <?= $form->field($model, 'fullname')->textInput(['class' => 'inputForm form-control', 'id' => 'updateFullname', 'placeholder' => 'Enter Fullname here.'])->label(false) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <label class="labelStyle">Location</label>
                            <input type="text" name="update_individual_location" class="inputForm form-control" placeholder="Enter Customer location here." id="updateIndividualLocation" />
                        </div>
                    </div>
                    <br/>

                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <label class="labelStyle">Billing Address</label>
                            <textarea name="individual_address" rows="5" class="inputForm form-control" placeholder="Enter Billing address here." id="updateCustomerAddress" ></textarea>
                        </div>
                    </div>
                    <br/>

                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <label class="labelStyle">Shipping Address</label>
                            <textarea name="shipping_address" rows="5" class="inputForm form-control" placeholder="Enter Shipping address here." id="updateCustomerShippingAddress" ></textarea>
                        </div>
                    </div>
                    <br/>

                    <div class="row">
                        <div class="col-md-6 col-xs-6 col-sm-6">
                            <label class="labelStyle">Race</label>
                            <?= $form->field($model, 'race_id')->dropdownList(['0' => ' - CHOOSE RACE HERE - '] + $dataRace,['style' => 'width: 100%;', 'class' => 'inputForm select2', 'id' => 'updateCustomerRace', 'data-placeholder' => 'PLEASE CHOOSE RACE HERE'])->label(false) ?>

                            <label class="labelStyle" style="margin-top: 12px;">Nric</label>
                            <input type="text" name="nric" class="inputForm form-control" placeholder="Write NRIC here." id="updateCustomerNric" />
                            <br/>

                            <label class="labelStyle">Personal E-mail Address</label>
                            <input type="text" name="person_email" class="inputForm form-control" placeholder="Write Email address here." id="updateCustomerEmail"  />
                        </div>

                        <div class="col-md-6 col-xs-6 col-sm-6">
                            <label class="labelStyle">Personal Contact Number</label>
                            <input type="text" name="person_hanphone" class="inputForm form-control" placeholder="Write Phone number here." id="updateCustomerPhoneNumber" />
                            <br/>

                            <label class="labelStyle">Office Number</label>
                            <input type="text" name="person_officeno" class="inputForm form-control" placeholder="Write Office number here." id="updateCustomerOficeNumber" />
                            <br/>

                            <label class="labelStyle">Fax Number</label>
                            <input type="text" name="person_faxno" class="inputForm form-control" placeholder="Write Fax number here." id="updateCustomerFaxNumber" />
                        </div>
                    </div>   
                    <br/>

                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <label class="labelStyle">Remarks</label>
                            <textarea name="update_individual_remarks" rows="5" class="inputForm form-control" placeholder="Enter Customer remarks here." id="updateCustomerRemarks" ></textarea>
                        </div>
                    </div>       
                </div>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="modal-footer">
            <?= Html::button('<li class=\'fa fa-refresh\'></li> Clear', ['id' => 'clearCustomerForms', 'class' => 'formBtn btn btn-default']) ?>
            <?= Html::submitButton('<li class=\'fa fa-paper-plane-o\'></li> Save Record', ['id' => 'submitCustomerFormUpdate', 'class' => 'formBtn btn btn-primary']) ?>
        </div>

        </div>
    </div>
</div>

<!-- View -->
<div class="modal fade modalBackground" id="modal-launcher-view-customer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close closeViewCustomer" >&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-desktop"></i> View Customer Information</h5>
            </div>

            <div class="modal-body" id="viewCustomer">
                <!-- Information Content -->
            </div>

            <div class="modal-body" id="viewCustomerCompanyInformation">
                <!-- Information Content -->
            </div>

            <div class="modal-footer">
            <?= Html::button('<li class=\'fa fa-minus-square\'></li> Close', ['id' => 'closeCustomerForms', 'class' => 'formBtn btn btn-default']) ?>
            </div>

        </div>
    </div>
</div>

<!-- Export to Excel -->
<a id="divLink" style="display: none;"></a>

</div>