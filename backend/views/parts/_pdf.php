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
				<td class="pdf_headBg" > Auto-Parts Category Name </td>
				<td class="pdf_headBg" > Auto-Parts Code </td>
				<td class="pdf_headBg" > Auto-Parts Name </td>
				<td class="pdf_headBg" > Description </td>
				<td class="pdf_headBg" > Unit of Measure </td>
			</tr>
		</thead>
		<tbody>
			<?php foreach($result as $row ){ ?>
			<tr>
				<td><?php echo $row['id']; ?></td>
				<td><?php echo $row['name']; ?></td>
				<td><?php echo $row['parts_code']; ?></td>
				<td><?php echo $row['parts_name']; ?></td>
				<td><?php echo $row['description']; ?></td>
				<td><?php echo $row['unit_of_measure']; ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>