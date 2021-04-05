
<?php if (!empty($this->cart->contents())): ?>
	<?php
		$totalQty = 0;
		$totalAmount = 0;
		$totalItem = 0;

		foreach ($this->cart->contents() as $productInfo) {
			$totalQty += $productInfo['qty'];
			$totalAmount += $productInfo['price'];
			$totalItem++;
		}
	?>
	<tr>
	    <th colspan="3" class="text-right">Total Qty</th>
	    <th id="totalAmount" class="text-right">
	    	<input class="form-control" type="hidden" id="total_item" name="total_item" value="<?= $totalItem ?>">
	    	<input class="form-control" type="hidden" id="total_qty" name="total_qty" value="<?= $totalQty ?>">
	    	<?= $totalQty ?>
	    </th>
	    <th></th>
	</tr>
<?php endif ?>