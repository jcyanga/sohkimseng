<?php

use yii\helpers\Html;
use yii\grid\GridView;

?>

<div class="row item-in-list-<?= $ctr ?> selectedItemListDesign selectedItems">

	<div class="col-md-3">
		<input type="text" id="supplier-in-list-<?= $ctr ?>" value="<?= strtoupper($supplier) ?>" class="inputForm form-control" readonly="readonly" />

		<input type="hidden" id="supplier-in-list-<?= $ctr ?>" value="<?= $supplier_id ?>" name="ProductInventory[supplier_id][]" class="inputForm form-control suppliers" />		
	</div>

	<div class="col-md-3">
		<input type="text" id="product-in-list-<?= $ctr ?>" value="<?= strtoupper($product) ?>" class="inputForm form-control" readonly="readonly" />		

		<input type="hidden" id="product-in-list-<?= $ctr ?>" value="<?= $product_id ?>" name="ProductInventory[product_id][]" class="inputForm form-control products" />	
	</div>

	<div class="col-md-3">
		<input type="text" id="quantity-in-list-<?= $ctr ?>" value="<?= $quantity ?>" name="ProductInventory[quantity][]" class="inputForm form-control quantities" readonly="readonly" />	
	</div>

	<div class="col-md-3">
		<input type="text" id="price-in-list-<?= $ctr ?>" value="<?= $price ?>" name="ProductInventory[price][]" class="inputForm form-control prices" readonly="readonly" />	
	</div>

</div>

<div class="row item-in-list-<?= $ctr ?> selectedItemListDesign selectedItems">

	<div class="col-md-6"></div>
	
	<div class="col-md-6">
		<div style="text-align: right;">
			<span class="_editButton<?= $ctr ?> edit-button">
                <a href="javascript:editSelectedItem(<?= $ctr ?>)" class="selectedBtns" ><i class="fa fa-edit"></i> Edit</a>
            </span>
            <span class="_saveButton<?= $ctr ?> save-button hidden">
                <a href="javascript:saveSelectedItem(<?= $ctr ?>)" class="selectedBtns" ><i class="fa fa-save"></i> Save</a>
            </span>
            <span class="_removeButton<?= $ctr ?> remove-button">
                <a href="javascript:removeSelectedItem(<?= $ctr ?>)" class="selectedBtns" ><i class="fa fa-trash"></i> Remove</a>
            </span>	
		</div>
	</div>

</div>
<br/>