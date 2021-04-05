
<div class="table-responsive">
    <table class="table table-striped" id="details-table">
        <thead>
            <tr>
                <th width="10px">SL</th>
                <th width="170px">Date</th>
                <th width="200px">Name</th>
                <th width="100px">Narration</th>
                <th width="100px">Phone</th>
                <td width="120px">Sale Amount</td>
                <td width="120px">Paid Amount</td>
                <td width="120px">Balance Amount</td>
            </tr>
        </thead>

        <tbody>
            <?php if ($customerLedgerList): ?>
                <?php $sl = 1; ?>
                <?php foreach ($customerLedgerList as $customerLedger): ?>
                    <?php if ($sl == 1): ?>
                        <tr>
                            <td><?= $sl++ ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-right">Opening Balance</td>
                            <td></td>
                            <td class="text-right"><?= $customerLedger->opening_balance < 0 ? '(adv)' : '' ?> <?= abs($customerLedger->opening_balance) ?></td>
                        </tr>
                    <?php endif ?>
                    <tr>
                        <td><?= $sl++ ?></td>
                        <td><?= $customerLedger->transaction_date ?></td>
                        <td><?= $customerLedger->clientName ?></td>
                        <td><?= $customerLedger->narration ?></td>
                        <td><?= $customerLedger->clientPhoneNumber ?></td>
                        <td align="right"><?= $customerLedger->credit_amount ?></td>
                        <td align="right"><?= $customerLedger->debit_amount ?></td>
                        <td align="right"><?= $customerLedger->closing_balance < 0 ? '(adv)' : '' ?> <?= abs($customerLedger->closing_balance) ?></td>
                    </tr>
                <?php endforeach ?>                
            <?php endif ?>
        </tbody>

        <tfoot>
            <?php if ($customerLedgerList): ?>
                <tr>
                    <th colspan="7" class="text-right">Closing Balance</th>
                    <th class="text-right"><?= $customerLedger->closing_balance < 0 ? '(Adv)' : '' ?> <?= abs($customerLedger->closing_balance) ?></th>
                </tr>                
            <?php endif ?>
        </tfoot>
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
                Customer Ledger <br>
                <label class="search-from-date">Date : </label> <?= $start_date ?> To <?= $end_date ?>
            </div>
        </div>

        <div class="row">
            <div class="column full">
                <table>
                    <thead>
                        <tr>
                            <th rowspan="2" width="10px">SL</th>
                            <th rowspan="2" width="150px">Date</th>
                            <th rowspan="2" width="200px">Name</th>
                            <th rowspan="2" width="100px">Narration</th>
                            <th rowspan="2" width="100px">Phone</th>
                            <td colspan="3" class="text-center">Amount</td>
                        </tr>

                        <tr>
                            <th width="100px" class="text-right">Sale</th>
                            <th width="100px" class="text-right">Paid</th>
                            <th width="120px" class="text-right">Balance</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $sl = 1; ?>
                        <?php foreach ($customerLedgerList as $customerLedger): ?>
                            <?php if ($sl == 1): ?>
                                <tr>
                                    <td><?= $sl++ ?></td>
                                    <th colspan="6" class="text-center">Opening Balance</th>
                                    <td class="text-right"><?= $customerLedger->opening_balance < 0 ? '(adv)' : '' ?> <?= abs($customerLedger->opening_balance) ?></td>
                                </tr>
                            <?php endif ?>
                            <tr>
                                <td><?= $sl++ ?></td>
                                <td><?= $customerLedger->transaction_date ?></td>
                                <td><?= $customerLedger->clientName ?></td>
                                <td><?= $customerLedger->narration ?></td>
                                <td><?= $customerLedger->clientPhoneNumber ?></td>
                                <td align="right"><?= $customerLedger->credit_amount ?></td>
                                <td align="right"><?= $customerLedger->debit_amount ?></td>
                                <td align="right"><?= $customerLedger->closing_balance < 0 ? '(adv)' : '' ?> <?= $customerLedger->closing_balance ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>

                    <tfoot>
                        <tr>
                            <th colspan="7" class="text-center">Closing Balance</th>
                            <th class="text-right"><?= $customerLedger->closing_balance < 0 ? '(Adv)' : '' ?> <?= abs($customerLedger->closing_balance) ?></th>
                        </tr>
                    </tfoot>
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