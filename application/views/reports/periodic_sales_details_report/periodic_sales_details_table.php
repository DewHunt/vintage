<?php
    $periodic_report_view_by_date;

    $total = 0;
    foreach ($periodic_report_view_by_date as $periodic_report) {
        $total += (double) $periodic_report->total_amount;
    }
?>

<table class="table table-striped" style="width: 100%" id="details-table">
    <thead class="thead-default">
        <tr>
            <th>SL</th>
            <th>Invoice No</th>
            <th>Outlet</th>
            <th>Date</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Rate</th>
            <th>Amount</th>
        </tr>
    </thead>

    <tbody>
        <?php $count = 1; ?>
        <?php foreach ($periodic_report_view_by_date as $periodic_report): ?>
            <?php
                $date_of_issue = date("d-m-Y", strtotime($periodic_report->date_of_issue));

            ?>
            <tr>
                <td><?= $count++ ?></td>
                <td><?= $periodic_report->invoice_number ?></td>
                <td><?= $periodic_report->branch_name ?></td>
                <td><?= $date_of_issue ?></td>
                <td><?= ucfirst($periodic_report->product_name) ?></td>
                <td align="right"><?= $periodic_report->quantity ?></td>
                <td align="right"><?= get_floating_point_number($periodic_report->unit_price, TRUE); ?></td>
                <td align="right"><?= get_floating_point_number($periodic_report->total_amount, TRUE); ?></td>
            </tr>            
        <?php endforeach ?>
    </tbody>

    <tfoot>
        <tr>
            <td colspan="7" align="right"><strong>Total Sales</strong></td>
            <td align="right"><strong><?= get_floating_point_number($total, TRUE); ?></strong></td>
        </tr>
    </tfoot>
</table>


<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="print-information" style="display: none">
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
                <font size="5px"><?= strtoupper($company_information->company_name_1) ?></font>
                <p><?= $company_information->company_address_1 ?></p>
            </div>
        </div>

        <div class="row">
            <div class="column left"><label>Outlet: <?= !empty($branch_name) ? $branch_name : ''; ?> </label></div>
            <div class="column right">
                <label>Period: <?= get_string_to_date_fromat_ymd($start_date) ?> To <?= get_string_to_date_fromat_ymd($end_date) ?> </label>
            </div>
        </div>

        <div class="row">
            <div class="column full">
                <table>
                    <caption><strong>Product Report</strong></caption>
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Invoice No</th>
                            <th>Outlet</th>
                            <th>Date</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Rate</th>
                            <th>Amount</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $count = 1; ?>
                        <?php foreach ($periodic_report_view_by_date as $periodic_report): ?>
                            <?php $date_of_issue = date("d-m-Y", strtotime($periodic_report->date_of_issue)); ?>
                            <tr>
                                <td><?= $count++ ?></td>
                                <td><?= $periodic_report->invoice_number ?></td>
                                <td><?= $periodic_report->branch_name ?></td>
                                <td><?= $date_of_issue ?></td>
                                <td><?= ucfirst($periodic_report->product_name) ?></td>
                                <td align="right"><?= $periodic_report->quantity ?></td>
                                <td align="right"><?= get_floating_point_number($periodic_report->unit_price, TRUE); ?></td>
                                <td align="right"><?= get_floating_point_number($periodic_report->total_amount, TRUE); ?></td>
                            </tr>            
                        <?php endforeach ?>
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="7" align="right"><strong>Total Sales</strong></td>
                            <td align="right"><strong><?= get_floating_point_number($total, TRUE); ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<!--For Print-->
<script language="javascript" type="text/javascript">

    $('#details-table').dataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [[25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]],
        "scrollY": "400px",
        "scrollX": true,
        "ordering": false,
    });
</script>





