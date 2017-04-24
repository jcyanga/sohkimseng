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
				<td class="pdf_headBg" > Type </td>
				<td class="pdf_headBg" > Parts Name </td>
				<td class="pdf_headBg" > Old Quantity </td>
				<td class="pdf_headBg" > New Quantity </td>
			</tr>
		</thead>
		<tbody>
			<?php foreach($result as $row ){ ?>
			<tr>
				<td><?php echo $row['id']; ?></td>
				<td>
					<?php if($row['type'] == 1): ?>
						<b>Stock-In</b>

					<?php elseif($row['type'] == 2): ?>
						<b>Stock-Out</b>

					<?php else: ?>
						<b>Stock-Adjustment</b>

					<?php endif; ?>
				</td>
				<td><?php echo $row['parts_name']; ?></td>
				<td><?php echo $row['old_quantity']; ?></td>
				<td><?php echo $row['new_quantity']; ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>