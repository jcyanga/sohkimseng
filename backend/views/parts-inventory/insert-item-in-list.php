<?php

use yii\helpers\Html;
use yii\grid\GridView;

?>

<div class="row item-in-list-<?= $ctr ?> selectedItemListDesign selectedItems">

	<div class="col-md-3">
		<input type="text" id="supplier-in-list-<?= $ctr ?>" value="<?= strtoupper($supplier) ?>" class="inputForm form-control" readonly="readonly" />

		<input type="hidden" id="supplier-in-list-<?= $ctr ?>" value="<?= $supplier_id ?>" name="PartsInventory[supplier_id][]" class="inputForm form-control suppliers" />		
	</div>

	<div class="col-md-3">
		<input type="text" id="parts-in-list-<?= $ctr ?>" value="<?= strtoupper($parts) ?>" class="inputForm form-control" readonly="readonly" />		

		<input type="hidden" id="parts-in-list-<?= $ctr ?>" value="<?= $parts_id ?>" name="PartsInventory[parts_id][]" class="inputForm form-control parts" />	
	</div>

	<div class="col-md-3">
		<input type="text" id="quantity-in-list-<?= $ctr ?>" value="<?= $quantity ?>" name="PartsInventory[quantity][]" class="inputForm form-control quantities" readonly="readonly" />	
	</div>

	<div class="col-md-3">
		<input type="text" id="price-in-list-<?= $ctr ?>" value="<?= $price ?>" name="PartsInventory[price][]" class="inputForm form-control prices" readonly="readonly" />	
	</div>

</div>

<div class="row item-in-list-<?= $ctr ?> selectedItemListDesign selectedItems">

	<div class="col-md-6"></div>
	
	<div class="col-md-6">
		<div style="text-align: right;">
			<span class="edit-button<?= $ctr ?> edit-button">
                <a href="javascript:editItem(<?= $ctr ?>)" class="selectedBtns" ><i class="fa fa-edit"></i> Edit</a>
            </span>
            <span class="save-button<?= $ctr ?> save-button hidden">
                <a href="javascript:saveItem(<?= $ctr ?>)" class="selectedBtns" ><i class="fa fa-save"></i> Save</a>
            </span>
            <span class="remove-button<?= $ctr ?> remove-button">
                <a href="javascript:removeItem(<?= $ctr ?>)" class="selectedBtns" ><i class="fa fa-trash"></i> Remove</a>
            </span>	
		</div>
	</div>

</div>
<br/>