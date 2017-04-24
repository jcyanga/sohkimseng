<?php

use yii\helpers\Html;
use yii\grid\GridView;

?>

<div class="row update-item-in-list-<?= $ctr ?> selectedItemListDesign">
	<div class="col-md-6"></div>
	
	<div class="col-md-6">
		<div style="text-align: right;">
			<span class="update-button-<?= $ctr ?> edit-button">
                <a href="javascript:updateSelectedItem(<?= $ctr ?>)" class="selectedBtns" ><i class="fa fa-edit"></i> Edit</a>
            </span>
            <span class="save-update-button-<?= $ctr ?> save-button hidden">
                <a href="javascript:saveUpdateSelectedItem(<?= $ctr ?>)" class="selectedBtns" ><i class="fa fa-save"></i> Save</a>
            </span>
            <span class="remove-update-button-<?= $ctr ?> remove-button">
                <a href="javascript:removeUpdateSelectedItem(<?= $ctr ?>)" class="selectedBtns" ><i class="fa fa-trash"></i> Remove</a>
            </span>	
		</div>
	</div>
</div>

<div class="row update-item-in-list-<?= $ctr ?> selectedItemListDesign selectedUpdateItemInLabel-<?= $ctr?> ">
	<?php if($type == '0'): ?>
		
		<div class="col-md-3 selectedPartsAndServicesFontSize" >
			<span class="selectedPartsAndServices" ><?= strtoupper($services_name) ?></span>
		</div>

	<?php else: ?>
		
		<div class="col-md-3 selectedPartsAndServicesFontSize" >
			<span class="selectedPartsAndServices" ><?= strtoupper($parts_name) ?></span>
		</div>

	<?php endif; ?>

	<div class="col-md-3 selectedPartsAndServicesFontSize" >
		<span class="selectedPartsAndServices" id="inlabel-update-quantity-<?= $ctr ?>" ><?= $quantity ?></span>
	</div>

	<div class="col-md-3 selectedPartsAndServicesFontSize" >
		<span class="selectedPartsAndServices" id="inlabel-update-unitprice-<?= $ctr ?>" ><?= $unit_price ?></span>
	</div>

	<div class="col-md-3 selectedPartsAndServicesFontSize" >
		<span class="selectedPartsAndServices" id="inlabel-update-subtotal-<?= $ctr ?>" ><?= $sub_total ?></span>
	</div>

<br/><hr/>
</div>

<div class="row update-item-in-list-<?= $ctr ?> selectedItemListDesign selectedUpdateItemInInputbox-<?= $ctr?> hidden">
	<?php if($type == '0'): ?>
		
		<div class="col-md-3">
			<input type="text" id="parts-services-update-name-in-list-<?= $ctr ?>" value="<?= strtoupper($services_name) ?>" class="inputForm inputboxTotalAlignment form-control" readonly="readonly" />

			<input type="hidden" id="parts-services-update-id-in-list-<?= $ctr ?>" value="0-<?= $services_id ?>" name="QuotationDetail[description][]" class="inputForm form-control update_selected_partsservicesName" />		
		</div>

	<?php else: ?>

		<div class="col-md-3">
			<input type="text" id="parts-services-update-name-in-list-<?= $ctr ?>" value="<?= strtoupper($parts_name) ?>" class="inputForm inputboxTotalAlignment form-control" readonly="readonly" />

			<input type="hidden" id="parts-services-update-id-in-list-<?= $ctr ?>" value="1-<?= $parts_id ?>" name="QuotationDetail[description][]" class="inputForm form-control update_selected_partsservicesName" />		
		</div>
	
	<?php endif; ?>

	<div class="col-md-3">
		<input type="text" id="parts-services-update-qty-in-list-<?= $ctr ?>" value="<?= $quantity ?>" name="QuotationDetail[quantity][]" onchange="editSelectedSubtotal(<?= $ctr ?>)" class="inputForm inputboxTotalAlignment form-control update_selected_partsservicesQty" />	
	</div>

	<div class="col-md-3">
		<input type="text" id="parts-services-update-price-in-list-<?= $ctr ?>" value="<?= $unit_price ?>" name="QuotationDetail[unit_price][]" onchange="editSelectedSubtotal(<?= $ctr ?>)" class="inputForm inputboxTotalAlignment form-control update_selected_partsservicesPrice" />	
	</div>

	<div class="col-md-3">
		<input type="text" id="parts-services-update-subtotal-in-list-<?= $ctr ?>" value="<?= $sub_total ?>" name="QuotationDetail[sub_total][]" class="inputForm inputboxTotalAlignment form-control update_selected_partsservicesSubtotal" readonly="readonly" />	
	</div>

<br/><hr/>
</div>