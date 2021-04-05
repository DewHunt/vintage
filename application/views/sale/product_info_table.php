<?php
	$userInfo = $this->session->userdata['user_session'];
	$userType = $userInfo['user_type'];
?>

<?php foreach ($this->cart->contents() as $productInfo): ?>
	<?php
		$minQty = "";
		$minDiscount = "";
		if ($productInfo['bill_type'] == 'Guest Bill' && $userType != 'admin') {
			$minQty = $productInfo['guest_qty'];
			$minDiscount = $productInfo['guest_discount'];
		}
	?>
    <tr class="productRow" id="productRow_<?= $productInfo['id'] ?>">
	    <td>
		    <input class="form-control rowId" type="hidden" id="rowId_<?= $productInfo['id'] ?>" name="rowId[]" value="<?= $productInfo['rowid'] ?>">
		    <input class="form-control productId" type="hidden" id="productId_<?= $productInfo['id'] ?>" name="productId[]" value="<?= $productInfo['id'] ?>">
		    <input class="form-control item" type="hidden" id="item_<?= $productInfo['id'] ?>" name="item[]" value="1">
		    <input class="form-control vatRate" type="hidden" id="vatRate_<?= $productInfo['id'] ?>" name="vatRate[]" value="<?= $productInfo['vat_rate'] ?>">
		    <input class="form-control billType" type="hidden" id="billType_<?= $productInfo['id'] ?>" name="billType[]" value="<?= $productInfo['bill_type'] ?>">

		    <?= $productInfo['name'] ?>
    		<textarea class="form-control" style="height: 25px; line-height: 13px;" rows="1" id="itemNote_<?= $productInfo['id'] ?>" name="itemNote[]" placeholder="Item Notes Here..." onchange="getTotalPrice(<?= $productInfo['id'] ?>)"><?= $productInfo['itemNote'] ?></textarea>
		</td>

	    <td>
	    	<input class="form-control" type="number" min="1" id="price_<?= $productInfo['id'] ?>" name="price[]" value="<?= $productInfo['price'] ?>" oninput="getTotalPrice(<?= $productInfo['id'] ?>)" readonly>
	    </td>

	    <td>
	    	<input class="form-control qty" type="number" min="<?= $minQty == "" ? 1 : $minQty ?>" id="qty_<?= $productInfo['id'] ?>" name="qty[]" value="<?= $productInfo['qty'] ?>" oninput="getTotalPrice(<?= $productInfo['id'] ?>)">
	    </td>

	    <td>
		    <input class="form-control" type="number" min="<?= $minDiscount == "" ? 0 : $minDiscount ?>" max="100" id="discount_<?= $productInfo['id'] ?>" name="discount[]" value="<?= $productInfo['discount'] ?>" oninput="getTotalPrice(<?= $productInfo['id'] ?>)">
		    <input class="form-control" type="hidden" id="discountAmount_<?= $productInfo['id'] ?>" name="discountAmount[]" value="<?= $productInfo['discountAmount'] ?>" readonly>
	    </td>

	    <td>
		    <input class="form-control total" type="number" min="0" id="total_<?= $productInfo['id'] ?>" name="total[]" value="0"; readonly>
		    <input class="form-control productTotalVat" type="hidden" min="0" id="productTotalVat_<?= $productInfo['id'] ?>" name="productTotalVat[]" value="0"; readonly>
	    </td>

	    <td>
	    	<?php if ($productInfo['bill_type'] != 'Guest Bill' || $userType == 'admin'): ?>
	    		<i class="fa fa-trash" style="color: red;" onclick="remove(<?= $productInfo['id'] ?>)"></i>
	    	<?php endif ?>
	    </td>
    </tr>
    <script>window._getTotalPrice(<?= $productInfo['id'] ?>)</script>
	
<?php endforeach ?>