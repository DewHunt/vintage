<style type="text/css">
	.btn-pad { padding: 3px; }	
</style>

<div class="row">
	<div class="col-lg-12 text-center">
        <font size="5px"><?= strtoupper($companyInfo->company_name_1) ?></font>
        <p><?= $companyInfo->company_address_1 ?></p>		
	</div>
</div>

<?php
	if ($type == "FactoryToBranch") {
		$date = $receiveChallanInfo->product_receive_date;
		$branchName = $receiveChallanInfo->branchName;
	}
	elseif ($type == "BranchToBranch") {
		$date = $receiveChallanInfo->transfer_date;
		$branchName = $receiveChallanInfo->fromBranchName." To ".$receiveChallanInfo->toBranchName;
	}
	else {
		$date = $receiveChallanInfo->product_return_date;
		$branchName = $receiveChallanInfo->branchName;
	}
?>

<div class="row">
	<div class="col-lg-12">
		<table style="width: 100%; border: 0px;">
			<thead>
				<tr>
                    <th>Date : <?= $date ?></th>
                    <th class="text-right">Challan No. : <?= $receiveChallanInfo->challan_number ?></th>
				</tr>

				<tr>
                    <th colspan="2">Branch Name : <?= $branchName ?></th>
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
                    <th width="120px">Action/Status</th>
				</tr>
			</thead>

			<tbody>
				<?php if (!empty($receiveProductList)): ?>
					<?php $sl = 1; ?>
					<?php foreach ($receiveProductList as $receiveProduct): ?>
						<tr>
							<td><?= $sl++ ?></td>
							<td><?= $receiveProduct->productName ?></td>
							<td align="right"><?= $receiveProduct->quantity ?></td>
							<td align="center" id="productReceiveStatus_<?= $receiveProduct->id ?>">
								<?php if ($receiveProduct->status > 0): ?>
									<?php
										$msg = "Received";
										if ($type == "BranchToFactory") {
											$msg = "Approved";
										}
									?>
									<?= $receiveProduct->status == 1 ? $msg : 'Rejected' ?>
								<?php else: ?>
									<?php if ($type == "BranchToFactory"): ?>
										<!-- <span class="btn btn-success btn-sm btn-pad" onclick="approveProduct(<?= $receiveProduct->id ?>,'<?= $type ?>')">Approve</span>										 -->
										<span class="btn btn-success btn-sm btn-pad" onclick="receiveProduct(<?= $receiveProduct->id ?>,'<?= $type ?>')">Approve</span>										
									<?php else: ?>
										<span class="btn btn-success btn-sm btn-pad" onclick="receiveProduct(<?= $receiveProduct->id ?>,'<?= $type ?>')">Receive</span>
									<?php endif ?>
                                    <span class="btn btn-danger btn-sm btn-pad" onclick="rejectProduct(<?= $receiveProduct->id ?>,'<?= $type ?>')">Reject</span>
								<?php endif ?>
							</td>
						</tr>
					<?php endforeach ?>
				<?php else: ?>
					<tr>
						<td colspan="6"><h5>Product Not Found</h5></td>
					</tr>
				<?php endif ?>
			</tbody>

			<?php if (!empty($receiveProductList)): ?>
				<tfoot>
					<tr>
						<th colspan="2" class="text-right">Total</th>
						<th class="text-right"><?= $receiveChallanInfo->total_qty ?></th>
						<th></th>
					</tr>
				</tfoot>
			<?php endif ?>
		</table>	
	</div>
</div>