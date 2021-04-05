
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
                    <th>Date : <?= $stockTransferChallanInfo->transfer_date ?></th>
                    <th class="text-right">Challan No. : <?= $stockTransferChallanInfo->challan_number ?></th>
				</tr>

				<tr>
                    <th>From : <?= $stockTransferChallanInfo->fromBranchName ?></th>
                    <th class="text-right">To : <?= $stockTransferChallanInfo->toBranchName ?></th>
				</tr>
			</thead>
		</table>	
	</div>
</div>

<div style="padding: 10px;"></div>

<div class="row">
	<div class="col-lg-12">
		<table class="table table-bordered">
			<thead>
				<tr>
                    <th width="35px">SL</th>
                    <th>Product Name</th>
                    <th width="60px" class="text-right">Qty</th>
				</tr>
			</thead>

			<tbody>
				<?php if (!empty($stockTransferProductList)): ?>
					<?php $sl = 1; ?>
					<?php foreach ($stockTransferProductList as $stockTransferProduct): ?>
						<tr>
							<td><?= $sl++ ?></td>
							<td><?= $stockTransferProduct->productName ?></td>
							<td align="right"><?= $stockTransferProduct->quantity ?></td>
						</tr>
					<?php endforeach ?>
				<?php else: ?>
					<tr>
						<td colspan="5"><h5>Product Not Found</h5></td>
					</tr>
				<?php endif ?>
			</tbody>

			<?php if (!empty($stockTransferProductList)): ?>
				<tfoot>
					<tr>
						<th colspan="2" class="text-right">Total</th>
						<th class="text-right"><?= $stockTransferChallanInfo->total_qty ?></th>
					</tr>
				</tfoot>
			<?php endif ?>
		</table>	
	</div>
</div>