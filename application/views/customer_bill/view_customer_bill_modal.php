
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
                    <th colspan="3">Date : <?= $start_date ?> - <?= $end_date ?></th>
				</tr>

				<tr>
                    <th>Name : <?= $clientInfo->client_name ?></th>
                    <th width="150px">Code : <?= $clientInfo->client_code ?></th>
                    <th width="220px">Phone Number : <?= $clientInfo->phone_number ?></th>
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
                    <th width="100px">Date</th>
                    <th width="140px">Narration</th>
                    <th width="30px" class="text-right">Sale</th>
                    <th width="30px" class="text-right">Paid</th>
                    <th width="30px" class="text-right">Balance</th>
				</tr>
			</thead>

			<?php if (!empty($customerBillInfo)): ?>
				<tbody>
					<?php
						$sl = 1;
						$totalPaidAmount = 0;
						$totalSale = 0;
					?>
					<?php foreach ($customerBillInfo as $customerBill): ?>
						<?php if ($sl == 1): ?>						
							<tr>
								<td><?= $sl ?></td>
								<th colspan="3" class="text-right">Opening Balance</th>
								<td class="text-right">
									<?= $customerBill->opening_balance < 0 ? '(abv)' : '' ?> <?= abs($customerBill->opening_balance) ?>									
								</td>
								<td></td>
							</tr>
						<?php endif ?>
						<tr>
							<td><?= $sl++ ?></td>
							<td><?= $customerBill->transaction_date ?></td>
							<td><?= $customerBill->narration ?></td>
							<td align="right"><?= $customerBill->credit_amount ?></td>
							<td align="right"><?= $customerBill->debit_amount ?></td>
							<td align="right"><?= $customerBill->closing_balance < 0 ? '(adv)' : '' ?> <?= abs($customerBill->closing_balance) ?></td>
						</tr>
					<?php endforeach ?>
				</tbody>
			<?php endif ?>

			<?php if (!empty($customerBillInfo)): ?>
				<tbody>
					<tr>
						<th colspan="4" class="text-right">Closing Balance</th>
						<th class="text-right">
							<?= $customerBill->closing_balance < 0 ? '(adv)' : '' ?> <?= abs($customerBill->closing_balance) ?>
						</th>
						<th></th>
					</tr>
				</tbody>
			<?php endif ?>
		</table>
	</div>
</div>

<!--DISPLAY NONE, USE FOR PRINT-->

<div id="print-view-information" style="display: none">
    <style>
        table, td, th { border: 1px solid #ddd; }
        table { border-collapse: collapse; width: 100%; }
        th, td { padding: 5px; }
        label { font-weight: bold; }
        p { margin: 0px; }
        .print-content { margin: 30px; }
        * { box-sizing: border-box; }
        .column { float: left; padding: 10px; }

        .left { width: 40%; }
        .middle { width: 20%; }
        .right { width: 40%; }

        .full { width: 100% }
        /* Clear floats after the columns */
        .row:after { content: ""; display: table; clear: both; }
        .text-center { text-align: center }
        .text-right { text-align: right }
    </style>

    <div class="print-content">
        <div class="row">
            <div class="column full text-center">
                <font size="5px"><?= strtoupper($companyInfo->company_name_1) ?></font>
                <p><?= $companyInfo->company_address_1 ?></p>
            </div>
        </div>

        <div class="row">
            <div class="column full" align="center">
                Customer Bill <br>
                <label class="search-from-date">Date : </label> <?= $start_date ?> To <?= $end_date ?>
            </div>
        </div>

        <div class="row">
            <div class="column left">
                <label class="search-from-date">Name : </label><?= $clientInfo->client_name ?>
            </div>

            <div class="column middle">
                <label class="search-from-date">Code : </label> <?= $clientInfo->client_code ?>
            </div>

            <div class="column right">
                <label class="search-from-date">Phone Number : </label> <?= $clientInfo->phone_number ?>
            </div>
        </div>

        <div class="row">
            <div class="column full">
				<table>
					<thead>
						<tr>
		                    <th width="35px">SL</th>
		                    <th>Date</th>
		                    <th>Narration</th>
		                    <th width="80px" class="text-right">Sale</th>
		                    <th width="80px" class="text-right">Paid</th>
		                    <th width="100px" class="text-right">Balance</th>
						</tr>
					</thead>

					<?php if (!empty($customerBillInfo)): ?>
						<tbody>
							<?php
								$sl = 1;
								$totalPaidAmount = 0;
								$totalSale = 0;
							?>
							<?php foreach ($customerBillInfo as $customerBill): ?>
								<?php if ($sl == 1): ?>						
									<tr>
										<td><?= $sl ?></td>
										<th colspan="3" class="text-right">Opening Balance</th>
										<td class="text-right">
											<?= $customerBill->opening_balance < 0 ? '(abv)' : '' ?> <?= abs($customerBill->opening_balance) ?>
										</td>
										<td></td>
									</tr>
								<?php endif ?>
								<tr>
									<td><?= $sl++ ?></td>
									<td><?= $customerBill->transaction_date ?></td>
									<td><?= $customerBill->narration ?></td>
									<td align="right"><?= $customerBill->credit_amount ?></td>
									<td align="right"><?= $customerBill->debit_amount ?></td>
									<td align="right"><?= $customerBill->closing_balance < 0 ? '(adv)' : '' ?> <?= abs($customerBill->closing_balance) ?></td>
								</tr>
							<?php endforeach ?>
						</tbody>
					<?php endif ?>

					<?php if (!empty($customerBillInfo)): ?>
						<tbody>
							<tr>
								<th colspan="4" class="text-right">Closing Balance</th>
								<th class="text-right">
									<?= $customerBill->closing_balance < 0 ? '(adv)' : '' ?> <?= abs($customerBill->closing_balance) ?>
								</th>
								<th></th>
							</tr>
						</tbody>
					<?php endif ?>
				</table>
            </div>
        </div>
    </div>
</div>