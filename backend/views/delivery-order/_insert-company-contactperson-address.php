<?php

use yii\helpers\Html;
use yii\grid\GridView;

?>

<div class="row inserted-contactperson-address-in-list-<?= $ctr ?> insertedContactpersonAddressListDesign">
	<div class="col-md-6">
		<label class="ContactpersonAddressHeader">
			<i class="fa fa-address-card-o"></i> COMPANY INFORMATION 
		</label>
	</div>
	
	<div class="col-md-6">
		<div style="text-align: right;">
			<span class="edit-contactperson-address-button-<?= $ctr ?> edit-button">
                <a href="javascript:editDOSelectedContactPersonAddress(<?= $ctr ?>)" class="selectedBtns" ><i class="fa fa-edit"></i> Edit</a>
            </span>
            &nbsp;
            <span class="remove-button">
                <a href="javascript:removeDOSelectedContactPersonAddress(<?= $ctr ?>)" class="selectedBtns" ><i class="fa fa-trash"></i> Remove</a>
            </span>	
		</div>
	</div>
</div>

<div class="row inserted-contactperson-address-in-list-<?= $ctr ?> insertedContactpersonAddressListDesign ">
	
	<div class="col-md-12 ContactpersonAddressFontSize" >
		<span class="insertedContactpersonAddress" id="inlabel-contactperson-<?= $ctr ?>" >
			<b>Contact Person :</b> <?= $contact_person ?>
		</span>
	</div>
	<br/>

	<div class="col-md-12 ContactpersonAddressFontSize" >
		<span class="insertedContactpersonAddress" id="inlabel-address-<?= $ctr ?>" >
			<b>Billing Address :</b> <?= $address ?>
		</span>
	</div>

<br/><hr/>
</div>

<div class="row inserted-contactperson-address-in-list-<?= $ctr ?> insertedContactpersonAddressListDesign hidden">
	<div class="col-md-4">
		<input type="text" id="customer-contactperson-in-list-<?= $ctr ?>" value="<?= $contact_person ?>" name="CustomerContactpersonAddress[contact_person][]" class="inputForm form-control selectedContactPerson" />	
	</div>

	<div class="col-md-8">
		<input type="text" id="customer-address-in-list-<?= $ctr ?>" value="<?= $address ?>" name="CustomerContactpersonAddress[address][]" class="inputForm form-control selectedAddress" />	
	</div>	
</div>