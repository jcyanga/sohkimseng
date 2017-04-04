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
				<td class="pdf_headBg" > Fullname </td>
				<td class="pdf_headBg" > Address </td>
				<td class="pdf_headBg" > Phone Number </td>
				<td class="pdf_headBg" > Mobile Number </td>
			</tr>
		</thead>
		<tbody>
			<?php foreach($result as $row ){ ?>
			<tr>
				<td><?php echo $row['id']; ?></td>
				<td><?php echo $row['fullname']; ?></td>
				<td><?php echo $row['address']; ?></td>
				<td><?php echo $row['phone_number']; ?></td>
				<td><?php echo $row['mobile_number']; ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>