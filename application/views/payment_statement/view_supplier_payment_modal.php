
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
                    <th>Date : <?= $start_date ?> - <?= $end_date ?></th>
				</tr>

				<tr>
                    <th>Supplier Name : <?= $supplierInfo->name ?></th>
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
                    <th rowspan="2" width="35px">SL</th>
                    <th rowspan="2" width="140px">Date</th>
                    <th rowspan="2" width="140px">MR No.</th>
                    <th rowspan="2" width="100px">Payment Mode</th>				
                    <th colspan="3" class="text-center">Amount</th>
				</tr>
				<tr>
                    <th width="80px" class="text-right">Purchase</th>
                    <th width="80px" class="text-right">Paid</th>
                    <th width="80px" class="text-right">Balance</th>
				</tr>
			</thead>

			<?php if (!empty($supplierPaymentInfo)): ?>
				<tbody>
					<?php
						$sl = 1;
						$totalPurchaseAomunt = 0;
						$totalPaidAomunt = 0;
					?>
					<?php foreach ($supplierPaymentInfo as $supplierPayment): ?>
						<?php if ($sl == 1): ?>
							<tr>
								<td><?= $sl++ ?></td>
								<th colspan="5" class="text-right">Opening <?= $supplierPayment->status == 1 ? 'Due' : 'Advanced' ?></th>
								<td align="right"><?= $supplierPayment->previous_amount ?></td>
							</tr>							
						<?php endif ?>
						<?php
							$totalPaidAomunt = $totalPaidAomunt + $supplierPayment->paid_amount;
							$totalPurchaseAomunt = $totalPurchaseAomunt + $supplierPayment->purchase_amount;
							if ($supplierPayment->advanced_amount == 0 && $supplierPayment->due_amount == 0) {
								$closingBalance = 0;
							} else if ($supplierPayment->advanced_amount > 0) {
								$closingBalance = $supplierPayment->advanced_amount;
								$closingStatus = 2;
							}
							else {
								$closingBalance = $supplierPayment->due_amount;
								$closingStatus = 1;
							}
						?>
						<tr>
							<td><?= $sl++ ?></td>
							<td><?= $supplierPayment->date ?></td>
							<td><?= $supplierPayment->money_receipt_no ?></td>
							<td><?= $supplierPayment->payment_mode ?></td>
							<td align="right"><?= $supplierPayment->purchase_amount ?></td>
							<td align="right"><?= $supplierPayment->paid_amount ?></td>
							<td align="right"><?= $closingStatus == 2 ? '(Adv)' : '' ?> <?= $closingBalance ?></td>
						</tr>
					<?php endforeach ?>
				</tbody>

				<tfoot>
					<tr>
						<th colspan="4" class="text-right">Closing Balance</th>
						<th class="text-right"><?= $totalPurchaseAomunt ?></th>
						<th class="text-right"><?= $totalPaidAomunt ?></th>
						<th class="text-right"><?= $closingStatus == 2 ? '(Adv)' : '' ?> <?= $closingBalance ?></th>
					</tr>
				</tfoot>
			<?php else: ?>
				<tbody>
					<tr>
						<td colspan="7"><h5>Payment Info Not Found</h5></td>
					</tr>
				</tbody>
			<?php endif ?>
		</table>	
	</div>
</div>