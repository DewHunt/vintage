<style type="text/css">
	hr.dashed {border-top: 1px dashed black;font-weight: bold;margin: 5px 0px;width: 100%;}
	table {background-color: transparent;}
	caption {padding-top: 0px;padding-bottom: 3px;color: #777;text-align: center;}
	th {text-align: left;}
	.tab {width: 100%;max-width: 100%;margin-bottom: 5px;font-size:12px;}
	.tab > thead > tr > th,.tab > tbody > tr > th,.tab > tfoot > tr > th,
	.tab > thead > tr > td,.tab > tbody > tr > td,
	.tab > tfoot > tr > td {padding: 2px;line-height: 1.42857143;vertical-align: top;border-bottom: 0px dashed black;}
	.tab > thead > tr > th {vertical-align: bottom;border-bottom: 0px dashed black;}                        
	.tab > caption + thead > tr:first-child > th,.tab > colgroup + thead > tr:first-child > th,
	.tab > thead:first-child > tr:first-child > th,.tab > caption + thead > tr:first-child > td,
	.tab > colgroup + thead > tr:first-child > td,.tab > thead:first-child > tr:first-child > td {border-top: 0;}
	.tab > tbody + tbody {border-top: 0px dashed black;}
	.tab .tab {background-color: #fff;}
	.tab-condensed > thead > tr > th,.tab-condensed > tbody > tr > th,
	.tab-condensed > tfoot > tr > th,.tab-condensed > thead > tr > td,
	.tab-condensed > tbody > tr > td,.tab-condensed > tfoot > tr > td {padding: 5px;}
	.tab-bordered {border: 1px solid black;}
	.tab-bordered > thead > tr > th,.tab-bordered > tbody > tr > th,
	.tab-bordered > tfoot > tr > th,.tab-bordered > thead > tr > td,
	.tab-bordered > tbody > tr > td,.tab-bordered > tfoot > tr > td {border: 1px solid black;}
	.tab-bordered > thead > tr > th,.tab-bordered > thead > tr > td {border-bottom-width: 2px;}
	.tab-striped > tbody > tr:nth-of-type(odd) {background-color: #f9f9f9;}
	.tab-hover > tbody > tr:hover {background-color: #f5f5f5;}
	table col[class*="col-"] {position: static;display: table-column;float: none;}
	table td[class*="col-"],table th[class*="col-"] {position: static;display: table-cell;float: none;}
	.tab > thead > tr > td.active,.tab > tbody > tr > td.active,.tab > tfoot > tr > td.active,
	.tab > thead > tr > th.active,.tab > tbody > tr > th.active,.tab > tfoot > tr > th.active,
	.tab > thead > tr.active > td,.tab > tbody > tr.active > td,.tab > tfoot > tr.active > td,
	.tab > thead > tr.active > th,.tab > tbody > tr.active > th,.tab > tfoot > tr.active > th {background-color: #f5f5f5;}
	.tab-hover > tbody > tr > td.active:hover,.tab-hover > tbody > tr > th.active:hover,
	.tab-hover > tbody > tr.active:hover > td,.tab-hover > tbody > tr:hover > .active,
	.tab-hover > tbody > tr.active:hover > th {background-color: #e8e8e8;}
	.tab > thead > tr > td.success,.tab > tbody > tr > td.success,
	.tab > tfoot > tr > td.success,.tab > thead > tr > th.success,
	.tab > tbody > tr > th.success,.tab > tfoot > tr > th.success,
	.tab > thead > tr.success > td,.tab > tbody > tr.success > td,
	.tab > tfoot > tr.success > td,.tab > thead > tr.success > th,
	.tab > tbody > tr.success > th,.tab > tfoot > tr.success > th {background-color: #dff0d8;}
	.tab-hover > tbody > tr > td.success:hover,.tab-hover > tbody > tr > th.success:hover,
	.tab-hover > tbody > tr.success:hover > td,.tab-hover > tbody > tr:hover > .success,
	.tab-hover > tbody > tr.success:hover > th {background-color: #d0e9c6;}
	.tab > thead > tr > td.info,.tab > tbody > tr > td.info,
	.tab > tfoot > tr > td.info,.tab > thead > tr > th.info,
	.tab > tbody > tr > th.info,.tab > tfoot > tr > th.info,
	.tab > thead > tr.info > td,.tab > tbody > tr.info > td,
	.tab > tfoot > tr.info > td,.tab > thead > tr.info > th,
	.tab > tbody > tr.info > th,.tab > tfoot > tr.info > th {background-color: #d9edf7;}
	.tab-hover > tbody > tr > td.info:hover,.tab-hover > tbody > tr > th.info:hover,
	.tab-hover > tbody > tr.info:hover > td,.tab-hover > tbody > tr:hover > .info,
	.tab-hover > tbody > tr.info:hover > th {background-color: #c4e3f3;}
	.tab > thead > tr > td.warning,.tab > tbody > tr > td.warning,
	.tab > tfoot > tr > td.warning,.tab > thead > tr > th.warning,
	.tab > tbody > tr > th.warning,.tab > tfoot > tr > th.warning,
	.tab > thead > tr.warning > td,.tab > tbody > tr.warning > td,
	.tab > tfoot > tr.warning > td,.tab > thead > tr.warning > th,
	.tab > tbody > tr.warning > th,.tab > tfoot > tr.warning > th {background-color: #fcf8e3;}
	.tab-hover > tbody > tr > td.warning:hover,.tab-hover > tbody > tr > th.warning:hover,
	.tab-hover > tbody > tr.warning:hover > td,.tab-hover > tbody > tr:hover > .warning,
	.tab-hover > tbody > tr.warning:hover > th {background-color: #faf2cc;}
	.tab > thead > tr > td.danger,.tab > tbody > tr > td.danger,
	.tab > tfoot > tr > td.danger,.tab > thead > tr > th.danger,
	.tab > tbody > tr > th.danger,.tab > tfoot > tr > th.danger,
	.tab > thead > tr.danger > td,.tab > tbody > tr.danger > td,
	.tab > tfoot > tr.danger > td,.tab > thead > tr.danger > th,
	.tab > tbody > tr.danger > th,.tab > tfoot > tr.danger > th {background-color: #f2dede;}
	.tab-hover > tbody > tr > td.danger:hover,.tab-hover > tbody > tr > th.danger:hover,
	.tab-hover > tbody > tr.danger:hover > td,.tab-hover > tbody > tr:hover > .danger,
	.tab-hover > tbody > tr.danger:hover > th {background-color: #ebcccc;}
	.tab-responsive {min-height: .01%;overflow-x: auto;}
	.tab>tfoot>tr>td {border-bottom: hidden;}
	.tab>tfoot>tr>th {border-bottom: 1px dashed black;}
	.div-separator {border: 1px dashed black;}
	.separator {border-bottom: 1px dashed black;}
</style>

<table class="tab">
	<tbody>
		<tr><td class="text-center"><img width="100px" height="100px" src="<?= base_url($outletInfo->logo) ?>"></td></tr>
		<tr><td class="text-center"><b><?= $outletInfo->address ?></b></td></tr>
	</tbody>
</table>

<div class="div-separator"></div>

<table class="tab">
	<tbody>
		<tr>
			<td width="35%">
				<b>Token : <?= $tokenNumberForShow ?></b><br>
				Order Time : <?= $orderAndPrintTime ?><br>
				Print Time : <?= $orderAndPrintTime ?><br>
				BIN : <?= empty($outletInfo->vat_reg) ? 'Applied' : $outletInfo->vat_reg?><br>
			</td>
		</tr>
	</tbody>
</table>

<div class="div-separator"></div>

<table class="tab">
	<caption class="separator"><b>Order Information</b></caption>
	<tbody>
		<tr class="separator">
			<td>Item Name</td>
			<td class="text-right">Rate</td>
			<td class="text-right">Qty</td>
			<td class="text-right">Disc</td>
			<td class="text-right">Price</td>
		</tr>
		<?php
			$order_total = 0;
			$total_vat = 0;
		?>
		<?php foreach ($cartContents as $content): ?>
			<?php
				$discount_amount = (($content['price'] * $content['qty']) * $content['discount']) / 100;
				$vat_amount = (($content['price'] * $content['qty']) * $content['vat_rate']) / 100;
				$item_total = $content['subtotal'] - $discount_amount;
				$order_total = $order_total + $item_total;
				$total_vat = $total_vat + $vat_amount;
			?>
		    <tr>
			    <td><?= $content['name'] ?></td>
			    <td align="right"><?= $content['price'] ?></td>
			    <td align="right"><?= $content['qty'] ?></td>
			    <td align="right"><?= $discount_amount ?></td>
			    <td align="right"><?= $item_total ?></td>
		    </tr> 
		    <tr class="separator"><td colspan="5"><?= $content['itemNote'] ?></td></tr>
		<?php endforeach ?>
	</tbody>

	<tfoot>
		<tr>
			<td >*Vat Included</td>
			<td colspan="3" align="right">Order Total : </td>
			<td align="right"><?= number_format($order_total,2,'.','') ?></td>
		</tr>
		<?php if ($total_vat): ?>
		    <tr>
			    <td colspan="4" align="right">Vat Total : </td>
			    <td align="right"><?= number_format($total_vat,2,'.','') ?></td>
		    </tr>
		<?php endif ?>
		<tr>
			<td colspan="4" align="right">Discount : </td>
			<td align="right"><?= number_format($discountValue,2,'.','') ?></td>
		</tr>
		<tr>
			<th colspan="4" class="text-right">Total Amount :</th>
			<th class="text-right"><?= number_format(round($order_total - $discountValue + $total_vat),2,'.','') ?></th>
		</tr>
		<?php if (!empty($sessionOrderNote)): ?>
			<tr>
				<td colspan="5">
					<div style="text-align: center; font-weight: bold;">--- Order Comments ---</div>
					<?= $sessionOrderNote ?>
				</td>
			</tr>			
		<?php endif ?>
	</tfoot>
</table>

<div class="div-separator"></div>

<table class="tab">
	<tbody>
		<tr><td align="center"><?= $outletInfo->footer_text ?></td></tr>
	</tbody>
</table>

<div class="div-separator"></div>

<table class="tab">
	<tbody>
		<tr><td align="center">Developed By : http://giantssoft.com</td></tr>
	</tbody>
</table>