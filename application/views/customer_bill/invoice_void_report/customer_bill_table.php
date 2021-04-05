
<div class="table-responsive">
    <table class="table table-striped" id="details-table">
        <thead>
            <tr>
                <th width="10px">SL</th>
                <th width="200px">Name</th>
                <th width="100px">Code</th>
                <th width="100px">Phone</th>
                <th width="60px" class="text-right">Total Order</th>
                <th width="40px" class="text-right">Opening</th>
                <th width="40px" class="text-right">Sale</th>
                <th width="40px" class="text-right">Paid</th>
                <th width="40px" class="text-right">Balance</th>
                <th width="20px">Action</th>
            </tr>
        </thead>

        <tbody>
            <?php
                $sl = 1;
                $totalBalance = 0;
            ?>
            <?php foreach ($customerBillList as $customerBill): ?>
                <?php
                    $openingBalance = $this->Client_sales_details_Model->get_opening_balance_by_date_and_client_id($customerBill->clientId,$start_date);
                    if ($openingBalance) {
                        $opening_balance = $openingBalance->total_credit_balance > 0 ? $openingBalance->total_credit_balance : $openingBalance->total_advance_balance;
                    }
                    else {
                        $opening_balance = 0;
                    }
                    $balance = $opening_balance + $customerBill->saleAmount - $customerBill->paidAmount;
                    $totalBalance += $balance;
                ?>
                <tr>
                    <td><?= $sl++ ?></td>
                    <td><?= $customerBill->clientName ?></td>
                    <td><?= $customerBill->clientCode ?></td>
                    <td><?= $customerBill->clientPhoneNumber ?></td>
                    <td align="right"><?= $customerBill->totalOrder ?></td>
                    <td align="right"><?= $opening_balance < 0 ? '(adv)' : '' ?> <?= abs($opening_balance) ?></td>
                    <td align="right"><?= $customerBill->saleAmount ?></td>
                    <td align="right"><?= $customerBill->paidAmount ?></td>
                    <td align="right"><?= $balance < 0 ? '(adv)' : '' ?> <?= abs($balance) ?></td>
                    <td>
                        <span class="btn btn-primary" onclick="viewCustomeBillInfo(<?= $customerBill->clientId.",'".$start_date."','".$end_date."'" ?>)"><i class="fa fa-eye"></i>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>


<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="print-all-information" style="display: none">
    <style>
        table, td, th { border: 1px solid #ddd; }
        table { border-collapse: collapse; width: 100%; }
        th, td { padding: 5px; }
        label { font-weight: bold; }
        p { margin: 0px; }
        .print-content { margin: 30px; }
        * { box-sizing: border-box; }
        .column { float: left; padding: 10px; }
        .left { width: 60%; }
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
            <div class="column full">
                <table>
                    <thead>
                        <tr>
                            <th rowspan="2" width="10px">SL</th>
                            <th rowspan="2" width="200px">Name</th>
                            <th rowspan="2" width="100px">Code</th>
                            <th rowspan="2" width="100px">Phone</th>
                            <th colspan="5" width="120px" class="text-center">Total</th>
                        </tr>
                        <tr>
                            <th width="60px" class="text-right">Order</th>
                            <th width="80px" class="text-right">Opening</th>
                            <th width="60px" class="text-right">Sale</th>
                            <th width="60px" class="text-right">Paid</th>
                            <th width="60px" class="text-right">Balance</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            $sl = 1;
                            $totalBalance = 0;
                        ?>
                        <?php foreach ($customerBillList as $customerBill): ?>
                        <?php
                            $openingBalance = $this->Client_sales_details_Model->get_opening_balance_by_date_and_client_id($customerBill->clientId,$start_date);
                            $opening_balance = $openingBalance->total_credit_balance > 0 ? $openingBalance->total_credit_balance : $openingBalance->total_advance_balance;
                            $balance = $opening_balance + $customerBill->saleAmount - $customerBill->paidAmount;
                            $totalBalance += $balance;
                        ?>
                            <tr>
                                <td><?= $sl++ ?></td>
                                <td><?= $customerBill->clientName ?></td>
                                <td><?= $customerBill->clientCode ?></td>
                                <td><?= $customerBill->clientPhoneNumber ?></td>
                                <td align="right"><?= $customerBill->totalOrder ?></td>
                                <td align="right"><?= $opening_balance < 0 ? '(adv)' : '' ?> <?= abs($opening_balance) ?></td>
                                <td align="right"><?= $customerBill->saleAmount ?></td>
                                <td align="right"><?= $customerBill->paidAmount ?></td>
                                <td align="right"><?= $balance < 0 ? '(adv)' : '' ?> <?= abs($balance) ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#details-table').dataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [[25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]],
            "scrollY": "400px",
            "scrollX": true,
            "ordering": false,
        });
    });
</script>