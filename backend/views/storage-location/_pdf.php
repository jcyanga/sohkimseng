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
				<td class="pdf_headBg" > Rack </td>
				<td class="pdf_headBg" > Bay </td>
				<td class="pdf_headBg" > Level </td>
				<td class="pdf_headBg" > Position </td>
			</tr>
		</thead>
		<tbody>
			<?php foreach($result as $row ){ ?>
			<tr>
				<td><?php echo $row['id']; ?></td>
				<td><?php echo $row['rack']; ?></td>
				<td><?php echo $row['bay']; ?></td>
				<td><?php echo $row['level']; ?></td>
				<td><?php echo $row['position']; ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>