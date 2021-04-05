
<div class="table-responsive">
    <table class="table table-striped" id="details-table">
        <thead>
            <tr>
                <th width="10px">SL</th>
                <th width="170px">Date</th>
                <th width="200px">User</th>
                <th>Supplier Name</th>
                <!-- <th width="140px">Previous Amount</th> -->
                <th width="140px">Total Paid Amount</th>
                <th width="60px">Action</th>
            </tr>
        </thead>

        <tbody>
            <?php $sl = 1; ?>
            <?php foreach ($paymentStatementList as $paymentStatement): ?>
                <tr>
                    <td><?= $sl++ ?></td>
                    <td><?= $start_date." - ".$end_date ?></td>
                    <td><?= $paymentStatement->userName ?></td>
                    <td><?= $paymentStatement->supplierName ?></td>
                    <!-- <td align="right"><?= $paymentStatement->previousAmount ?></td> -->
                    <td align="right"><?= $paymentStatement->totalPaidAmount ?></td>
                    <td>
                        <span class="btn btn-primary" onclick="viewPaymentInfo(<?= $paymentStatement->supplier_id.",'".$start_date."','".$end_date."'" ?>)"><i class="fa fa-eye"></i>
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
                Payment Statement <br>
                <label class="search-from-date">Date : </label> <?= $start_date ?> To <?= $end_date ?>
            </div>
        </div>

        <div class="row">
            <div class="column full">
                <table class="table table-striped" id="details-table">
                    <thead>
                        <tr>
                            <th width="10px">SL</th>
                            <th width="180px">Date</th>
                            <th width="150px">User</th>
                            <th width="200px">Supplier Name</th>
                            <th width="90px">Total Paid</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $sl = 1; ?>
                        <?php foreach ($paymentStatementList as $paymentStatement): ?>
                            <tr>
                                <td><?= $sl++ ?></td>
                                <td><?= $start_date." - ".$end_date ?></td>
                                <td><?= $paymentStatement->userName ?></td>
                                <td><?= $paymentStatement->supplierName ?></td>
                                <td align="right"><?= $paymentStatement->totalPaidAmount ?></td>
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