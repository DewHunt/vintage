
<div class="row">
	<div class="col-lg-12 text-center">
        <font size="5px"><?= strtoupper($companyInfo->company_name_1) ?></font>
        <p><?= $companyInfo->company_address_1 ?></p>		
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<table style="width: 100%; border: 0px;">
			<thead>
				<tr>
                    <th>Date : <?= $purchasedProductInfo->date ?></th>
                    <th class="text-right">Payment Mode : <?= $purchasedProductInfo->payment_mode ?></th>
				</tr>

				<tr>
                    <th colspan="2">Supplier Name : <?= $purchasedProductInfo->supplierName ?></th>
				</tr>
			</thead>
		</table>	
	</div>
</div>

<div style="padding-bottom: 10px;"></div>

<div class="row">
	<div class="col-lg-12">
		<table class="table table-bordered">
			<thead>
				<tr>
                    <th width="35px">SL</th>
                    <th>Product Name</th>
                    <th width="60px" class="text-right">Rate</th>
                    <th width="60px" class="text-right">Qty</th>
                    <th width="80px" class="text-right">Amount</th>
				</tr>
			</thead>

			<tbody>
				<?php if (!empty($purchasedProductList)): ?>
					<?php $sl = 1; ?>
					<?php foreach ($purchasedProductList as $purchasedProduct): ?>
						<tr>
							<td><?= $sl++ ?></td>
							<td><?= $purchasedProduct->productName ?></td>
							<td align="right"><?= $purchasedProduct->rate ?></td>
							<td align="right"><?= $purchasedProduct->qty ?></td>
							<td align="right"><?= $purchasedProduct->amount ?></td>
						</tr>
					<?php endforeach ?>
				<?php else: ?>
					<tr>
						<td colspan="5"><h5>Product Not Found</h5></td>
					</tr>
				<?php endif ?>
			</tbody>

			<?php if (!empty($purchasedProductList)): ?>
				<tfoot>
					<tr>
						<th colspan="4" class="text-right">Total Amount</th>
						<th class="text-right"><?= $purchasedProductInfo->total_amount ?></th>
					</tr>

					<tr>
						<th colspan="4" class="text-right">Paid Amount</th>
						<th class="text-right"><?= $purchasedProductInfo->paid_amount ?></th>
					</tr>

					<tr>
						<th colspan="4" class="text-right">Due Amount</th>
						<th class="text-right"><?= $purchasedProductInfo->due_amount ?></th>
					</tr>
				</tfoot>
			<?php endif ?>
		</table>	
	</div>
</div>