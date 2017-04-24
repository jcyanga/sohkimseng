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
				<td class="pdf_headBg" > Payment-Type Name </td>
				<td class="pdf_headBg" > Description </td>
				<td class="pdf_headBg" > Interest </td>
			</tr>
		</thead>
		<tbody>
			<?php foreach($result as $row ){ ?>
			<tr>
				<td><?php echo $row['id']; ?></td>
				<td><?php echo $row['name']; ?></td>
				<td><?php echo $row['interest']; ?></td>
				<td><?php echo $row['description']; ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>