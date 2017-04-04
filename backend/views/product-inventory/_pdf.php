<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

?>

<div>
	<table class="pdfTable" >
		<thead>
			<tr>
				<td class="pdf_number" > # </td>
				<td class="pdf_headBg" > Supplier Name </td>
				<td class="pdf_headBg" > Product Name </td>
				<td class="pdf_headBg" > Quantity </td>
				<td class="pdf_headBg" > Price </td>
			</tr>
		</thead>
		<tbody>
			<?php foreach($result as $row ){ ?>
			<tr>
				<td><?php echo $row['id']; ?></td>
				<td><?php echo $row['name']; ?></td>
				<td><?php echo $row['product_name']; ?></td>
				<td><?php echo $row['quantity']; ?></td>
				<td><?php echo $row['price']; ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>