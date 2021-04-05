<?php
	$button_backgound = $company_info->button_backgound;
	$category_name = $company_info->category_name;
?>
<div class="row cat-row">
	<?php foreach ($products as $product): ?>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 cat-col">
			<?php if ($button_backgound == 'image' && !empty($product->image)): ?>
				<span class="btn btn-primary custom-btn-lg btn-block product-mr" style="white-space: normal; background: url(<?= $product->image ?>) no-repeat; background-size: 100px 40px;" onclick="getProductInfoById(<?= $product->id ?>)">
					<b class="button-text"><?= $product->product_name ?></b>
				</span>				
			<?php else: ?>
				<span class="btn btn-primary custom-btn-lg btn-block product-mr" style="white-space: normal; background-color: <?= $product->buttonColor ?>" onclick="getProductInfoById(<?= $product->id ?>)">
					<b><?= $product->product_name ?></b>
				</span>
			<?php endif ?>
		</div>
	<?php endforeach ?>
</div>