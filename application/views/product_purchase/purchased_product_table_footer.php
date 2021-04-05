
<?php if (!empty($this->cart->contents())): ?>
	<?php
		$totalQty = 0;
		$totalAmount = 0;

		foreach ($this->cart->contents() as $productInfo) {
			$totalQty += $productInfo['qty'];
			$totalAmount += $productInfo['price'];
		}
	?>
	<tr>
	    <th colspan="3" class="text-right">Total Amount</th>
	    <th id="totalAmount" class="text-right">
	    	<input class="form-control" type="hidden" id="total_qty" name="total_qty" value="<?= $totalQty ?>">
	    	<?= $totalQty ?>
	    </th>
	    <th id="totalAmount" class="text-right">
	    	<input class="form-control" type="hidden" id="total_amount" name="total_amount" value="<?= number_format($totalAmount,2,'.','') ?>">
	    	<?= number_format($totalAmount,2,'.','') ?>
	    </th>
	    <th></th>
	</tr>
<?php endif ?>