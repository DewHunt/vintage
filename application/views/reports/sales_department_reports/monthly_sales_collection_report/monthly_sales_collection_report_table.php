<div class="card card-boarder">
    <div class="width-100">
        <div class="col-xs-12 col-sm-8">
            <div class="col-xs-12">
                <label class="search-from-date">Employee: <?= !empty($employee_names) ? ($employee_names) : ''; ?></label>
            </div>
            <div class="col-xs-12">
                <label class="search-from-date">Period: <?= display_date($start_date) ?> To <?= display_date($end_date) ?> </label><br>
            </div>
        </div>
        <?php if ((strtolower($user_type) != 'marketing')) { ?>
            <?php if (!empty($print_access) > 0) { ?>
                <div class="col-xs-12 col-sm-4">
                    <button type="button" class="right-side-view btn btn-primary report-print-button monthly-sales-collection-report-table-print-button"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
                </div>
                <div class="col-xs-12">
                    <button type="button" class="right-side-view btn btn-excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                </div>
                <?php
            }
        }
        ?>
    </div>
    <div class="table-responsive table-bordered" style="width: 100%;">
        <table class="table table-striped" id="details-table">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Person</th>
                    <th class="text-right">Target</th>
                    <th class="text-right">Sale</th>
                    <th class="text-right">Collection</th>
                    <th class="text-right">% of Collection</th>
                    <th class="text-right">Deficit Sale</th>
                    <th class="text-right">Deficit Collection</th>
                    <th class="text-right">% Achievement Sale</th>
                    <th class="text-right">% of Achievement Collection</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 1;
                $sum_of_target_amount = 0;
                $sum_of_sale_amount = 0;
                $sum_of_collection_amount = 0;
                $sum_of_deficit_sale = 0;
                $sum_of_deficit_collection = 0;
                $sum_of_parcent_of_collection = 0;
                $sum_of_parcent_of_achievement_sale = 0;
                $sum_of_parcent_of_achievement_collection = 0;
                if (!empty($monthly_sales_collection_report)) {
                    foreach ($monthly_sales_collection_report as $monthly_sales_collection) {
                        $employee_id = intval($monthly_sales_collection->employee_id);
                        if (in_array($employee_id, remove_employee_ids())) {
                            continue;
                        }
                        $employee_name = !empty($monthly_sales_collection->employee_name) ? $monthly_sales_collection->employee_name : '';
                        $target_amount = !empty($monthly_sales_collection->target_amount) ? get_floating_point_number($monthly_sales_collection->target_amount) : 0;
                        $sum_of_target_amount += $target_amount;
                        $sale_amount = !empty($monthly_sales_collection->sale_amount) ? get_floating_point_number($monthly_sales_collection->sale_amount) : 0;
                        $sum_of_sale_amount += $sale_amount;
                        $collection_amount = !empty($monthly_sales_collection->collection_amount) ? get_floating_point_number($monthly_sales_collection->collection_amount) : 0;
                        $sum_of_collection_amount += $collection_amount;
                        $parcent_of_sale = ($sale_amount > 0) ? (($target_amount / $sale_amount) * 100) : 0;
                        $parcent_of_collection = ($collection_amount >= 0 && $sale_amount > 0) ? ($collection_amount / ($sale_amount) * 100) : 0;
                        $sum_of_parcent_of_collection = (($sum_of_sale_amount)) ? ($sum_of_collection_amount / ($sum_of_sale_amount) * 100) : 0;
                        $deficit_sale = ($target_amount - $sale_amount);
                        $sum_of_deficit_sale += $deficit_sale;
                        $deficit_collection = ($target_amount - $collection_amount);
                        $sum_of_deficit_collection += $deficit_collection;
                        $parcent_of_achievement_sale = ($target_amount > 0) ? ($sale_amount / ($target_amount) * 100) : 0;
                        $sum_of_parcent_of_achievement_sale = ($sum_of_target_amount > 0) ? ($sum_of_sale_amount / ($sum_of_target_amount) * 100) : 0;
                        $parcent_of_achievement_collection = ($target_amount > 0) ? ($collection_amount / ($target_amount) * 100) : 0;
                        $sum_of_parcent_of_achievement_collection = ($sum_of_target_amount > 0) ? ($sum_of_collection_amount / ($sum_of_target_amount) * 100) : 0;
                        ?>
                        <tr>
                            <td><?= $count++; ?></td>
                            <td><?= $employee_name; ?></td>
                            <td class="text-right"><?= get_floating_point_number($target_amount, TRUE); ?></td>
                            <td class="text-right"><?= get_floating_point_number($sale_amount, TRUE); ?></td>
                            <td class="text-right"><?= get_floating_point_number($collection_amount, TRUE); ?></td>
                            <td class="text-right"><?= get_floating_point_number($parcent_of_collection, TRUE); ?></td>
                            <td class="text-right"><?= get_floating_point_number($deficit_sale, TRUE); ?></td>
                            <td class="text-right"><?= get_floating_point_number($deficit_collection, TRUE); ?></td>
                            <td class="text-right"><?= get_floating_point_number($parcent_of_achievement_sale, TRUE); ?></td>
                            <td class="text-right"><?= get_floating_point_number($parcent_of_achievement_collection, TRUE); ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
                <tr>
                    <td><strong></strong></td>
                    <td><strong>Total</strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($sum_of_target_amount, TRUE); ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($sum_of_sale_amount, TRUE); ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($sum_of_collection_amount, TRUE); ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($sum_of_parcent_of_collection, TRUE); ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($sum_of_deficit_sale, TRUE); ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($sum_of_deficit_collection, TRUE); ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($sum_of_parcent_of_achievement_sale, TRUE); ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($sum_of_parcent_of_achievement_collection, TRUE); ?></strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="monthly-sales-collection-report-table-print-section" style="display: none; width: 100%" >
    <style>
        .print-table {
            width: 100%;
            border-collapse: collapse !important;
            border: 2px solid;            
        }
        .print-table th{
            text-align: center; 
            font-weight: bold; 
            background-color: black; 
            color: white; 
            font-size: 18px;
        }
        .print-table th,
        .print-table td {
            border: 1px solid #ddd !important;
        }
        .text-right{
            text-align: right;
        }
    </style>
    <?php $this->load->view('reports/company_info_as_report_header', $this->data); ?>
    <div class="col-xs-12" style="margin-left: 10px;">
        <label class="search-from-date"><strong><?= !empty($report_title) ? $report_title : ''; ?></strong></label><br>
    </div>
    <div class="col-xs-12">
        <label class="search-from-date">Employee: <?= !empty($employee_names) ? ($employee_names) : ''; ?></label>
    </div>
    <div class="col-xs-12">
        <label class="search-from-date">Period: <?= display_date($start_date) ?> To <?= display_date($end_date) ?> </label><br>
    </div>
    <br>
    <table class="table table-striped print-table" id="details-table">
        <thead>
            <tr>
                <th>SL</th>
                <th>Person</th>
                <th class="text-right">Target</th>
                <th class="text-right">Sale</th>
                <th class="text-right">Collection</th>
                <th class="text-right">% of Collection</th>
                <th class="text-right">Deficit Sale</th>
                <th class="text-right">Deficit Collection</th>
                <th class="text-right">% Achievement Sale</th>
                <th class="text-right">% of Achievement Collection</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            $sum_of_target_amount = 0;
            $sum_of_sale_amount = 0;
            $sum_of_collection_amount = 0;
            $sum_of_deficit_sale = 0;
            $sum_of_deficit_collection = 0;
            $sum_of_parcent_of_collection = 0;
            $sum_of_parcent_of_achievement_sale = 0;
            $sum_of_parcent_of_achievement_collection = 0;
            if (!empty($monthly_sales_collection_report)) {
                foreach ($monthly_sales_collection_report as $monthly_sales_collection) {
                    $employee_id = intval($monthly_sales_collection->employee_id);
                    if (in_array($employee_id, remove_employee_ids())) {
                        continue;
                    }
                    $employee_name = !empty($monthly_sales_collection->employee_name) ? $monthly_sales_collection->employee_name : '';
                    $target_amount = !empty($monthly_sales_collection->target_amount) ? get_floating_point_number($monthly_sales_collection->target_amount) : 0;
                    $sum_of_target_amount += $target_amount;
                    $sale_amount = !empty($monthly_sales_collection->sale_amount) ? get_floating_point_number($monthly_sales_collection->sale_amount) : 0;
                    $sum_of_sale_amount += $sale_amount;
                    $collection_amount = !empty($monthly_sales_collection->collection_amount) ? get_floating_point_number($monthly_sales_collection->collection_amount) : 0;
                    $sum_of_collection_amount += $collection_amount;
                    $parcent_of_sale = ($sale_amount > 0) ? (($target_amount / $sale_amount) * 100) : 0;
                    $parcent_of_collection = ($collection_amount >= 0 && $sale_amount > 0) ? ($collection_amount / ($sale_amount) * 100) : 0;
                    $sum_of_parcent_of_collection = (($sum_of_sale_amount > 0)) ? ($sum_of_collection_amount / ($sum_of_sale_amount) * 100) : 0;
                    $deficit_sale = ($target_amount - $sale_amount);
                    $sum_of_deficit_sale += $deficit_sale;
                    $deficit_collection = ($target_amount - $collection_amount);
                    $sum_of_deficit_collection += $deficit_collection;
                    $parcent_of_achievement_sale = ($target_amount > 0) ? ($sale_amount / ($target_amount) * 100) : 0;
                    $sum_of_parcent_of_achievement_sale = ($sum_of_target_amount > 0) ? ($sum_of_sale_amount / ($sum_of_target_amount) * 100) : 0;
                    $parcent_of_achievement_collection = ($target_amount > 0) ? ($collection_amount / ($target_amount) * 100) : 0;
                    $sum_of_parcent_of_achievement_collection = ($sum_of_target_amount > 0) ? ($sum_of_collection_amount / ($sum_of_target_amount) * 100) : 0;
                    ?>
                    <tr>
                        <td><?= $count++; ?></td>
                        <td><?= $employee_name; ?></td>
                        <td class="text-right"><?= get_floating_point_number($target_amount, TRUE); ?></td>
                        <td class="text-right"><?= get_floating_point_number($sale_amount, TRUE) ?></td>
                        <td class="text-right"><?= get_floating_point_number($collection_amount, TRUE) ?></td>
                        <td class="text-right"><?= get_floating_point_number($parcent_of_collection, TRUE) ?></td>
                        <td class="text-right"><?= get_floating_point_number($deficit_sale, TRUE) ?></td>
                        <td class="text-right"><?= get_floating_point_number($deficit_collection, TRUE) ?></td>
                        <td class="text-right"><?= get_floating_point_number($parcent_of_achievement_sale, TRUE) ?></td>
                        <td class="text-right"><?= get_floating_point_number($parcent_of_achievement_collection, TRUE) ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
            <tr>
                <td><strong></strong></td>
                <td><strong>Total</strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($sum_of_target_amount, TRUE); ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($sum_of_sale_amount, TRUE); ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($sum_of_collection_amount, TRUE); ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($sum_of_parcent_of_collection, TRUE); ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($sum_of_deficit_sale, TRUE); ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($sum_of_deficit_collection, TRUE); ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($sum_of_parcent_of_achievement_sale, TRUE) ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($sum_of_parcent_of_achievement_collection, TRUE) ?></strong></td>
            </tr>
        </tbody>
    </table>
</div>


<!--For Print-->
<script type="text/javascript">
    $(document).ready(function () {

        exportToExcel('print-table');

        $('#details-table').dataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [[25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]],
            "scrollY": "400px",
            "scrollX": true,
            "ordering": false,
        });


        $(".monthly-sales-collection-report-table-print-button").click(function () {
            var divContents = $('#monthly-sales-collection-report-table-print-section').html();
            var printWindow = window.open();
            printWindow.document.write(divContents);
            printWindow.document.close();
            printWindow.print();
            printWindow.close();
        });
    }
    );
</script>


