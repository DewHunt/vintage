
<div class="table-responsive">
    <table class="table table-striped" id="details-table">
        <thead>
            <tr>
                <th width="10px">SL</th>
                <th width="170px">Date</th>
                <th width="200px">Name</th>
                <th width="100px">Code</th>
                <th width="100px">Phone</th>
                <th width="125px">Payment Type</th>
                <th width="120px">Amount</th>
            </tr>
        </thead>

        <tbody>
            <?php $sl = 1; $totalAmount = 0; ?>
            <?php foreach ($customerPaymentList as $customerPayment): ?>
                <?php $totalAmount += $customerPayment->amount_received; ?>
                <tr>
                    <td><?= $sl++ ?></td>
                    <td><?= $customerPayment->receipt_date ?></td>
                    <td><?= $customerPayment->clientName ?></td>
                    <td><?= $customerPayment->clientCode ?></td>
                    <td><?= $customerPayment->clientPhoneNumber ?></td>
                    <td><?= $customerPayment->payment_type ?></td>
                    <td align="right"><?= $customerPayment->amount_received ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>

        <tfoot>
            <tr>
                <th colspan="6" align="right">Total</th>
                <th align="right"><?= $totalAmount ?></th>
            </tr>
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
                Customer Payment <br>
                <label class="search-from-date">Date : </label> <?= $start_date ?> To <?= $end_date ?>
            </div>
        </div>

        <div class="row">
            <div class="column full">
                <table>
                    <thead>
                        <tr>
                            <th width="10px">SL</th>
                            <th width="150px">Date</th>
                            <th width="200px">Name</th>
                            <th width="100px">Code</th>
                            <th width="100px">Phone</th>
                            <th width="140px">Payment Type</th>
                            <th width="100px">Amount</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $sl = 1; $totalAmount = 0; ?>
                        <?php foreach ($customerPaymentList as $customerPayment): ?>
                            <?php $totalAmount += $customerPayment->amount_received; ?>
                            <tr>
                                <td><?= $sl++ ?></td>
                                <td><?= $customerPayment->receipt_date ?></td>
                                <td><?= $customerPayment->clientName ?></td>
                                <td><?= $customerPayment->clientCode ?></td>
                                <td><?= $customerPayment->clientPhoneNumber ?></td>
                                <td><?= $customerPayment->payment_type ?></td>
                                <td align="right"><?= $customerPayment->amount_received ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>

                    <tfoot>
                        <tr>
                            <th colspan="6" align="right">Total</th>
                            <th align="right"><?= $totalAmount ?></th>
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