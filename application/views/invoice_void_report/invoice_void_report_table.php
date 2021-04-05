
<div class="table-responsive">
    <table class="table table-striped" id="details-table">
        <thead>
            <tr>
                <th width="10px">SL</th>
                <th width="50px">Date</th>
                <th width="40px">Invoice Number</th>
                <th width="220px"><?= $branch_head ?> Name</th>
                <th width="220px">Client Name</th>
                <th width="50px" class="text-right">Total Amount</th>
                <th width="20px">Action</th>
            </tr>
        </thead>

        <tbody>
            <?php
                $sl = 1;
                $totalBalance = 0;
            ?>
            <?php foreach ($invoiceVoidList as $invoiceVoid): ?>
                <tr>
                    <td><?= $sl++ ?></td>
                    <td><?= $invoiceVoid->return_date ?></td>
                    <td><?= $invoiceVoid->invoice_number ?></td>
                    <td><?= $invoiceVoid->branchName ?></td>
                    <td><?= $invoiceVoid->clientName ?></td>
                    <td align="right"><?= $invoiceVoid->total_amount ?></td>
                    <td>
                        <span class="btn btn-primary" onclick="viewInvoiceVoidInfo(<?= $invoiceVoid->id.",'".$start_date."','".$end_date."'" ?>)"><i class="fa fa-eye"></i>
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
                            <th width="10px">SL</th>
                            <th width="50px">Date</th>
                            <th width="50px">Invoice No.</th>
                            <th width="150px"><?= $branch_head ?></th>
                            <th width="150px">Client</th>
                            <th width="60px" class="text-right">Total</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            $sl = 1;
                            $totalBalance = 0;
                        ?>
                        <?php foreach ($invoiceVoidList as $invoiceVoid): ?>
                            <tr>
                                <td><?= $sl++ ?></td>
                                <td><?= $invoiceVoid->return_date ?></td>
                                <td><?= $invoiceVoid->invoice_number ?></td>
                                <td><?= $invoiceVoid->branchName ?></td>
                                <td><?= $invoiceVoid->clientName ?></td>
                                <td align="right"><?= $invoiceVoid->total_amount ?></td>
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