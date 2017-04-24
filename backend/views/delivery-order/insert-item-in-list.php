<?php

use yii\helpers\Html;
use yii\grid\GridView;

?>

<div class="row inserted-item-in-list-<?= $ctr ?> selectedItemListDesign">
	<div class="col-md-6"></div>
	
	<div class="col-md-6">
		<div style="text-align: right;">
			<span class="edit-button-<?= $ctr ?> edit-button">
                <a href="javascript:editSelectedDeliveryOrderItem(<?= $ctr ?>)" class="selectedBtns" ><i class="fa fa-edit"></i> Edit</a>
            </span>
            <span class="save-button-<?= $ctr ?> save-button hidden">
                <a href="javascript:saveSelectedDeliveryOrderItem(<?= $ctr ?>)" class="selectedBtns" ><i class="fa fa-save"></i> Save</a>
            </span>
            <span class="remove-button-<?= $ctr ?> remove-button">
                <a href="javascript:removeSelectedDeliveryOrderItem(<?= $ctr ?>)" class="selectedBtns" ><i class="fa fa-trash"></i> Remove</a>
            </span>	
		</div>
	</div>
</div>

<div class="row inserted-item-in-list-<?= $ctr ?> selectedItemListDesign selectedItemInLabel-<?= $ctr?> ">
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
		<span class="selectedPartsAndServices" id="inlabel-quantity-<?= $ctr ?>" ><?= $quantity ?></span>
	</div>

	<div class="col-md-3 selectedPartsAndServicesFontSize" >
		<span class="selectedPartsAndServices" id="inlabel-unitprice-<?= $ctr ?>" ><?= $unit_price ?></span>
	</div>

	<div class="col-md-3 selectedPartsAndServicesFontSize" >
		<span class="selectedPartsAndServices" id="inlabel-subtotal-<?= $ctr ?>" ><?= $sub_total ?></span>
	</div>

<br/><hr/>
</div>

<div class="row inserted-item-in-list-<?= $ctr ?> selectedItemListDesign selectedItemInInputbox-<?= $ctr?> hidden">
	<?php if($type == '0'): ?>
		
		<div class="col-md-3">
			<input type="text" id="parts-services-name-in-list-<?= $ctr ?>" value="<?= strtoupper($services_name) ?>" class="inputForm inputboxTotalAlignment form-control" readonly="readonly" />

			<input type="hidden" id="parts-services-id-in-list-<?= $ctr ?>" value="0-<?= $services_id ?>" name="DeliveryOrderDetail[description][]" class="inputForm form-control partsservicesName" />		
		</div>

	<?php else: ?>

		<div class="col-md-3">
			<input type="text" id="parts-services-name-in-list-<?= $ctr ?>" value="<?= strtoupper($parts_name) ?>" class="inputForm inputboxTotalAlignment form-control" readonly="readonly" />

			<input type="hidden" id="parts-services-id-in-list-<?= $ctr ?>" value="1-<?= $parts_id ?>" name="DeliveryOrderDetail[description][]" class="inputForm form-control partsservicesName" />		
		</div>
	
	<?php endif; ?>

	<div class="col-md-3">
		<input type="text" id="parts-services-qty-in-list-<?= $ctr ?>" value="<?= $quantity ?>" name="DeliveryOrderDetail[quantity][]" onchange="updateSelectedSubtotalDeliveryOrder(<?= $ctr ?>)" class="inputForm inputboxTotalAlignment form-control partsservicesQty" />	
	</div>

	<div class="col-md-3">
		<input type="text" id="parts-services-price-in-list-<?= $ctr ?>" value="<?= $unit_price ?>" name="DeliveryOrderDetail[unit_price][]" onchange="updateSelectedSubtotalDeliveryOrder(<?= $ctr ?>)" class="inputForm inputboxTotalAlignment form-control partsservicesPrice" />	
	</div>

	<div class="col-md-3">
		<input type="text" id="parts-services-subtotal-in-list-<?= $ctr ?>" value="<?= $sub_total ?>" name="sub_total[]" class="inputForm inputboxTotalAlignment form-control partsservicesSubtotal" readonly="readonly" />	
	</div>

<br/><hr/>
</div>