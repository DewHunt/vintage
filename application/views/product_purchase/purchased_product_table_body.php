<?php $sl = 1; ?>

<?php if (!empty($this->cart->contents())): ?>
	<?php foreach ($this->cart->contents() as $productInfo): ?>
	    <tr class="productRow" id="productRow_<?= $productInfo['id'] ?>">
	    	<td><?= $sl++ ?></td>
		    <td>
			    <input class="form-control rowId" type="hidden" id="rowId_<?= $productInfo['id'] ?>" name="rowId[]" value="<?= $productInfo['rowid'] ?>">
			    <input class="form-control productId" type="hidden" id="productId_<?= $productInfo['id'] ?>" name="productId[]" value="<?= $productInfo['id'] ?>">
			    <?= $productInfo['name'] ?>
			</td>

		    <td align="right">
	    		<input class="form-control" type="hidden" min="1" id="rate_<?= $productInfo['id'] ?>" name="rate[]" value="<?= $productInfo['rate'] ?>" oninput="getTotalPrice(<?= $productInfo['id'] ?>)">
		    	<?= $productInfo['rate'] ?>
		    </td>

		    <td align="right">
	    		<input class="form-control" type="hidden" min="1" id="qty_<?= $productInfo['id'] ?>" name="qty[]" value="<?= $productInfo['qty'] ?>" oninput="getTotalPrice(<?= $productInfo['id'] ?>)">
		    	<?= $productInfo['qty'] ?>
		    </td>

		    <td align="right">
	    		<input class="form-control qty" type="hidden" min="1" id="amount_<?= $productInfo['id'] ?>" name="amount[]" value="<?= $productInfo['price'] ?>" oninput="getTotalPrice(<?= $productInfo['id'] ?>)">
		    	<?= $productInfo['price'] ?>		    	
		    </td>
		    <td><i class="fa fa-trash" style="color: red;" onclick="remove(<?= $productInfo['id'] ?>)"></i></td>
	    </tr>	
	<?php endforeach ?>
    <!-- <script>window.getTotal(<?= $productInfo['id'] ?>)</script>     -->
<?php endif ?>