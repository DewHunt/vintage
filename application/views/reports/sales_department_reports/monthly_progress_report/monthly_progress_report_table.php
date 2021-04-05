<style type="text/css">
    table .table-title td:not(:first-child){
        border: 1px solid black !important;
    }
    table .table-description td:not(:first-child){
        border: 1px solid black !important;
    }
    table .table-title td:first-child {
        border-right: 1px solid black !important;
        max-width: 10px;
    }
    table .table-description td:first-child {
        border-right: 1px solid black !important;
        max-width: 100px;
    }
    table .table-empty-row td:not(:first-child){
        border-bottom: 1px solid black !important;
    }
</style>
<div class="card card-boarder">
    <div class="width-100">
        <div class="col-xs-12 col-sm-8">
            <div class="col-xs-12">
                <!--<label class="search-from-date">Employee: <?= !empty($employee_names) ? ($employee_names) : ''; ?></label>-->
            </div>
            <div class="col-xs-12">
                <label class="search-from-date">Period: <?= ($start_month_year) ?> To <?= ($end_month_year) ?> </label><br>
            </div>
        </div>
        <?php if ((strtolower($user_type) != 'marketing')) { ?>
            <?php if (!empty($print_access) > 0) { ?>
                <div class="col-xs-12 col-sm-4">
                    <button type="button" class="right-side-view btn btn-primary report-print-button monthly-progress-report-table-print-button"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
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

        <table class="table table-bordered">
<!--            <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>-->
            <tbody>
                <?php
                if (!empty($monthly_progress_report)) {
                    $count_employee = 0;
                    $total_sum_of_target_amount = 0;
                    $total_sum_of_sale_amount = 0;
                    $total_sum_of_collection_amount = 0;
                    $total_sum_of_average_sale_amount = 0;
                    $total_sum_of_average_collection_amount = 0;
                    $total_sum_of_accumulated_target_amount = 0;
                    $total_sum_of_accumulated_sale_amount = 0;
                    $total_sum_of_accumulated_collection_amount = 0;
                    foreach ($monthly_progress_report as $monthly_progress) {
                        $employee_info = $monthly_progress['employee'];
                        if (in_array(intval($employee_info->id), remove_employee_ids())) {
                            continue;
                        }
                        if (!empty($employee_info)) {
                            $count_employee++;
                        }
                        $report_array = $monthly_progress['report_array'];
                        ?>
                        <tr class="table-title">
                            <td></td>
                            <td></td>
                            <td class="text-right">Target</td>
                            <td class="text-right">Sale</td>
                            <td class="text-right">Collection</td>
                            <td class="text-right"><?= $month_duration_count; ?> Month(s) Average Sale</td>
                            <td class="text-right"><?= $month_duration_count; ?> Month(s) Average Collection</td>
                            <td class="text-right">Accumulated Target</td>
                            <td class="text-right">Accumulated Sale</td>
                            <td class="text-right">Accumulated Collection</td>
                        </tr>
                        <?php
                        if (!empty($report_array)) {
                            $is_show_employee_name = FALSE;
                            $count_report_array = $report_array;
                            $count = 1;
                            $sum_of_target_amount = 0;
                            $sum_of_sale_amount = 0;
                            $sum_of_collection_amount = 0;
                            $sum_of_average_sale_amount = 0;
                            $sum_of_average_collection_amount = 0;
                            $sum_of_accumulated_target_amount = 0;
                            $sum_of_accumulated_sale_amount = 0;
                            $sum_of_accumulated_collection_amount = 0;
                            foreach ($report_array as $rep) {
                                $employee_id = intval($rep['employee_id']);
                                if ($count == 1) {
                                    $is_show_employee_name = TRUE;
                                } else {
                                    $is_show_employee_name = FALSE;
                                }
                                $month_name = !empty($rep['month_name']) ? $rep['month_name'] : '';
                                $year = !empty($rep['year']) ? $rep['year'] : '';
                                $month_year = (!empty($month_name) ? $month_name : '') . (!empty($year) ? '-' . $year : '');
                                $employee_name = !empty($rep['employee_name']) ? $rep['employee_name'] : '';
                                $target_amount = !empty($rep['target_amount']) ? get_floating_point_number($rep['target_amount']) : 0;
                                $sum_of_target_amount += $target_amount;
                                $sale_amount = !empty($rep['sale_amount']) ? get_floating_point_number($rep['sale_amount']) : 0;
                                $sum_of_sale_amount += $sale_amount;
                                $collection_amount = !empty($rep['collection_amount']) ? get_floating_point_number($rep['collection_amount']) : 0;
                                $sum_of_collection_amount += $collection_amount;
                                $average_sale_amount = !empty($rep['average_sale_amount']) ? get_floating_point_number($rep['average_sale_amount']) : 0;
                                $average_collection_amount = !empty($rep['average_collection_amount']) ? get_floating_point_number($rep['average_collection_amount']) : 0;
                                $accumulated_target_amount = !empty($rep['accumulated_target_amount']) ? get_floating_point_number($rep['accumulated_target_amount']) : 0;
                                $sum_of_accumulated_target_amount = $accumulated_target_amount;
//                                $total_sum_of_accumulated_target_amount += $sum_of_accumulated_target_amount;
                                $accumulated_sale_amount = !empty($rep['accumulated_sale_amount']) ? get_floating_point_number($rep['accumulated_sale_amount']) : 0;
                                $sum_of_accumulated_sale_amount = $accumulated_sale_amount;
                                $accumulated_collection_amount = !empty($rep['accumulated_collection_amount']) ? get_floating_point_number($rep['accumulated_collection_amount']) : 0;
                                $sum_of_accumulated_collection_amount = $accumulated_collection_amount;
                                ?>
                                <tr class="table-description">
                                    <td><?= ($is_show_employee_name) ? $employee_name : ''; ?></td>
                                    <td><?= $month_year; ?></td>
                                    <td class="text-right"><?= get_floating_point_number($target_amount, TRUE); ?></td>
                                    <td class="text-right"><?= get_floating_point_number($sale_amount, TRUE) ?></td>
                                    <td class="text-right"><?= get_floating_point_number($collection_amount, TRUE) ?></td>
                                    <td class="text-right"><?= get_floating_point_number($average_sale_amount, TRUE) ?></td>
                                    <td class="text-right"><?= get_floating_point_number($average_collection_amount, TRUE) ?></td>
                                    <td class="text-right"><?= get_floating_point_number($accumulated_target_amount, TRUE) ?></td>
                                    <td class="text-right"><?= get_floating_point_number($accumulated_sale_amount, TRUE) ?></td>
                                    <td class="text-right"><?= get_floating_point_number($accumulated_collection_amount, TRUE) ?></td>
                                </tr>
                                <?php
                                $count++;
                            }
                            $total_sum_of_target_amount += $sum_of_target_amount;
                            $total_sum_of_sale_amount += $sum_of_sale_amount;
                            $sum_of_average_sale_amount = ($sum_of_sale_amount > 0) ? ($sum_of_sale_amount / $month_duration_count) : 0;
//                            $sum_of_average_sale_amount = ($total_sum_of_sale_amount > 0) ? ($total_sum_of_sale_amount / $month_duration_count) : 0;
                            $total_sum_of_average_sale_amount += $sum_of_sale_amount;
//                            $total_sum_of_average_sale_amount += $sum_of_average_sale_amount;
                            $total_sum_of_collection_amount += $sum_of_collection_amount;
                            $sum_of_average_collection_amount = ($sum_of_collection_amount > 0) ? ($sum_of_collection_amount / $month_duration_count) : 0;
//                            $sum_of_average_collection_amount = ($total_sum_of_collection_amount > 0) ? ($total_sum_of_collection_amount / $month_duration_count) : 0;
                            $total_sum_of_average_collection_amount += $sum_of_collection_amount;
//                            $total_sum_of_average_collection_amount += $sum_of_average_collection_amount;
                            $total_sum_of_accumulated_target_amount += $sum_of_accumulated_target_amount;
                            $total_sum_of_accumulated_sale_amount += $sum_of_accumulated_sale_amount;
                            $total_sum_of_accumulated_collection_amount += $sum_of_accumulated_collection_amount;
                            ?>
                            <tr class="table-description">
                                <td><strong><?= ''; ?></strong></td>
                                <td><strong>Total</strong></td>
                                <td class="text-right"><strong><?= get_floating_point_number($sum_of_target_amount, TRUE); ?></strong></td>
                                <td class="text-right"><strong><?= get_floating_point_number($sum_of_sale_amount, TRUE); ?></strong></td>
                                <td class="text-right"><strong><?= get_floating_point_number($sum_of_collection_amount, TRUE); ?></strong></td>
                                <td class="text-right"><strong><?= get_floating_point_number($sum_of_average_sale_amount, TRUE); ?></strong></td>
                                <td class="text-right"><strong><?= get_floating_point_number($sum_of_average_collection_amount, TRUE); ?></strong></td>
                                <td class="text-right"><strong><?= get_floating_point_number($sum_of_accumulated_target_amount, TRUE); ?></strong></td>
                                <td class="text-right"><strong><?= get_floating_point_number($sum_of_accumulated_sale_amount, TRUE); ?></strong></td>
                                <td class="text-right"><strong><?= get_floating_point_number($sum_of_accumulated_collection_amount, TRUE); ?></strong></td>
                            </tr>
                            <tr class="">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr class="table-empty-row">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        <?php }
                        ?>
                    <?php }
                    ?>
                    <tr class="table-description">
                        <td><strong></strong></td>
                        <td><strong>Grand Total</strong></td>
                        <td class="text-right"><strong><?= get_floating_point_number($total_sum_of_target_amount, TRUE); ?></strong></td>
                        <td class="text-right"><strong><?= get_floating_point_number($total_sum_of_sale_amount, TRUE); ?></strong></td>
                        <td class="text-right"><strong><?= get_floating_point_number($total_sum_of_collection_amount, TRUE); ?></strong></td>
                        <td class="text-right"><strong><?= ($total_sum_of_average_sale_amount > 0) ? get_floating_point_number(($total_sum_of_average_sale_amount / $month_duration_count), TRUE) : get_floating_point_number(0); ?></strong></td>
                        <td class="text-right"><strong><?= ($total_sum_of_average_collection_amount > 0) ? get_floating_point_number(($total_sum_of_average_collection_amount / $month_duration_count), TRUE) : get_floating_point_number(0); ?></strong></td>
                        <td class="text-right"><strong><?= get_floating_point_number($total_sum_of_accumulated_target_amount, TRUE); ?></strong></td>
                        <td class="text-right"><strong><?= get_floating_point_number($total_sum_of_accumulated_sale_amount, TRUE); ?></strong></td>
                        <td class="text-right"><strong><?= get_floating_point_number($total_sum_of_accumulated_collection_amount, TRUE); ?></strong></td>
                    </tr>
                <?php }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="monthly-progress-report-table-print-section" style="display: none; width: 100%" >
    <style>
        .print-table {
            width: 100%;
            border-collapse: collapse !important;
            /*border: 2px solid;*/            
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
        .print-table .table-title td:not(:first-child){
            border: 1px solid black !important;
        }
        .print-table .table-description td:not(:first-child){
            border: 1px solid black !important;
        }
        .print-table .table-title td:first-child {
            border-right: 1px solid black !important;
            /*max-width: 10px;*/
        }
        .print-table .table-description td:first-child {
            border-right: 1px solid black !important;
            /*max-width: 10px;*/
        }
        .print-table .table-empty-row td:not(:first-child){
            border-bottom: 1px solid black !important;
        }
    </style>
    <?php $this->load->view('reports/company_info_as_report_header', $this->data); ?>
    <div class="col-xs-12" style="margin-left: 10px;">
        <label class="search-from-date"><strong><?= !empty($report_title) ? $report_title : ''; ?></strong></label><br>
    </div>
    <div class="col-xs-12">
        <!--<label class="search-from-date">Employee: <?= !empty($employee_names) ? ($employee_names) : ''; ?></label>-->
    </div>
    <div class="col-xs-12">
        <label class="search-from-date">Period: <?= ($start_month_year) ?> To <?= ($end_month_year) ?> </label><br>
    </div>
    <br>
    <table class="table table-bordered print-table">
<!--            <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>-->
        <tbody>
            <?php
            if (!empty($monthly_progress_report)) {
                $count_employee = 0;
                $total_sum_of_target_amount = 0;
                $total_sum_of_sale_amount = 0;
                $total_sum_of_collection_amount = 0;
                $total_sum_of_average_sale_amount = 0;
                $total_sum_of_average_collection_amount = 0;
                $total_sum_of_accumulated_target_amount = 0;
                $total_sum_of_accumulated_sale_amount = 0;
                $total_sum_of_accumulated_collection_amount = 0;
                foreach ($monthly_progress_report as $monthly_progress) {
                    $employee_info = $monthly_progress['employee'];
                    if (in_array(intval($employee_info->id), remove_employee_ids())) {
                        continue;
                    }
                    if (!empty($employee_info)) {
                        $count_employee++;
                    }
                    $report_array = $monthly_progress['report_array'];
                    ?>
                    <tr class="table-title">
                        <td></td>
                        <td></td>
                        <td class="text-right">Target</td>
                        <td class="text-right">Sale</td>
                        <td class="text-right">Collection</td>
                        <td class="text-right"><?= $month_duration_count; ?> Month(s) Average Sale</td>
                        <td class="text-right"><?= $month_duration_count; ?> Month(s) Average Collection</td>
                        <td class="text-right">Accumulated Target</td>
                        <td class="text-right">Accumulated Sale</td>
                        <td class="text-right">Accumulated Collection</td>
                    </tr>
                    <?php
                    if (!empty($report_array)) {
                        $is_show_employee_name = FALSE;
                        $count_report_array = $report_array;
                        $count = 1;
                        $sum_of_target_amount = 0;
                        $sum_of_sale_amount = 0;
                        $sum_of_collection_amount = 0;
                        $sum_of_average_sale_amount = 0;
                        $sum_of_average_collection_amount = 0;
                        $sum_of_accumulated_target_amount = 0;
                        $sum_of_accumulated_sale_amount = 0;
                        $sum_of_accumulated_collection_amount = 0;
                        foreach ($report_array as $rep) {
                            $employee_id = intval($rep['employee_id']);
                            if ($count == 1) {
                                $is_show_employee_name = TRUE;
                            } else {
                                $is_show_employee_name = FALSE;
                            }
                            $month_name = !empty($rep['month_name']) ? $rep['month_name'] : '';
                            $year = !empty($rep['year']) ? $rep['year'] : '';
                            $month_year = (!empty($month_name) ? $month_name : '') . (!empty($year) ? '-' . $year : '');
                            $employee_name = !empty($rep['employee_name']) ? $rep['employee_name'] : '';
                            $target_amount = !empty($rep['target_amount']) ? get_floating_point_number($rep['target_amount']) : 0;
                            $sum_of_target_amount += $target_amount;
                            $sale_amount = !empty($rep['sale_amount']) ? get_floating_point_number($rep['sale_amount']) : 0;
                            $sum_of_sale_amount += $sale_amount;
                            $collection_amount = !empty($rep['collection_amount']) ? get_floating_point_number($rep['collection_amount']) : 0;
                            $sum_of_collection_amount += $collection_amount;
                            $average_sale_amount = !empty($rep['average_sale_amount']) ? get_floating_point_number($rep['average_sale_amount']) : 0;
                            $average_collection_amount = !empty($rep['average_collection_amount']) ? get_floating_point_number($rep['average_collection_amount']) : 0;
                            $accumulated_target_amount = !empty($rep['accumulated_target_amount']) ? get_floating_point_number($rep['accumulated_target_amount']) : 0;
                            $sum_of_accumulated_target_amount = $accumulated_target_amount;
//                                $total_sum_of_accumulated_target_amount += $sum_of_accumulated_target_amount;
                            $accumulated_sale_amount = !empty($rep['accumulated_sale_amount']) ? get_floating_point_number($rep['accumulated_sale_amount']) : 0;
                            $sum_of_accumulated_sale_amount = $accumulated_sale_amount;
                            $accumulated_collection_amount = !empty($rep['accumulated_collection_amount']) ? get_floating_point_number($rep['accumulated_collection_amount']) : 0;
                            $sum_of_accumulated_collection_amount = $accumulated_collection_amount;
                            ?>
                            <tr class="table-description">
                                <td><?= ($is_show_employee_name) ? $employee_name : ''; ?></td>
                                <td><?= $month_year; ?></td>
                                <td class="text-right"><?= get_floating_point_number($target_amount, TRUE); ?></td>
                                <td class="text-right"><?= get_floating_point_number($sale_amount, TRUE) ?></td>
                                <td class="text-right"><?= get_floating_point_number($collection_amount, TRUE) ?></td>
                                <td class="text-right"><?= get_floating_point_number($average_sale_amount, TRUE) ?></td>
                                <td class="text-right"><?= get_floating_point_number($average_collection_amount, TRUE) ?></td>
                                <td class="text-right"><?= get_floating_point_number($accumulated_target_amount, TRUE) ?></td>
                                <td class="text-right"><?= get_floating_point_number($accumulated_sale_amount, TRUE) ?></td>
                                <td class="text-right"><?= get_floating_point_number($accumulated_collection_amount, TRUE) ?></td>
                            </tr>
                            <?php
                            $count++;
                        }
                        $total_sum_of_target_amount += $sum_of_target_amount;
                        $total_sum_of_sale_amount += $sum_of_sale_amount;
                        $sum_of_average_sale_amount = ($sum_of_sale_amount > 0) ? ($sum_of_sale_amount / $month_duration_count) : 0;
//                            $sum_of_average_sale_amount = ($total_sum_of_sale_amount > 0) ? ($total_sum_of_sale_amount / $month_duration_count) : 0;
                        $total_sum_of_average_sale_amount += $sum_of_sale_amount;
//                            $total_sum_of_average_sale_amount += $sum_of_average_sale_amount;
                        $total_sum_of_collection_amount += $sum_of_collection_amount;
                        $sum_of_average_collection_amount = ($sum_of_collection_amount > 0) ? ($sum_of_collection_amount / $month_duration_count) : 0;
//                            $sum_of_average_collection_amount = ($total_sum_of_collection_amount > 0) ? ($total_sum_of_collection_amount / $month_duration_count) : 0;
                        $total_sum_of_average_collection_amount += $sum_of_collection_amount;
//                            $total_sum_of_average_collection_amount += $sum_of_average_collection_amount;
                        $total_sum_of_accumulated_target_amount += $sum_of_accumulated_target_amount;
                        $total_sum_of_accumulated_sale_amount += $sum_of_accumulated_sale_amount;
                        $total_sum_of_accumulated_collection_amount += $sum_of_accumulated_collection_amount;
                        ?>
                        <tr class="table-description">
                            <td><strong><?= ''; ?></strong></td>
                            <td><strong>Total</strong></td>
                            <td class="text-right"><strong><?= get_floating_point_number($sum_of_target_amount, TRUE); ?></strong></td>
                            <td class="text-right"><strong><?= get_floating_point_number($sum_of_sale_amount, TRUE); ?></strong></td>
                            <td class="text-right"><strong><?= get_floating_point_number($sum_of_collection_amount, TRUE); ?></strong></td>
                            <td class="text-right"><strong><?= get_floating_point_number($sum_of_average_sale_amount, TRUE); ?></strong></td>
                            <td class="text-right"><strong><?= get_floating_point_number($sum_of_average_collection_amount, TRUE); ?></strong></td>
                            <td class="text-right"><strong><?= get_floating_point_number($sum_of_accumulated_target_amount, TRUE); ?></strong></td>
                            <td class="text-right"><strong><?= get_floating_point_number($sum_of_accumulated_sale_amount, TRUE); ?></strong></td>
                            <td class="text-right"><strong><?= get_floating_point_number($sum_of_accumulated_collection_amount, TRUE); ?></strong></td>
                        </tr>
                        <tr class="">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr class="table-empty-row">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php }
                    ?>
                <?php }
                ?>
                <tr class="table-description">
                    <td><strong></strong></td>
                    <td><strong>Grand Total</strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($total_sum_of_target_amount, TRUE); ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($total_sum_of_sale_amount, TRUE); ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($total_sum_of_collection_amount, TRUE); ?></strong></td>
                    <td class="text-right"><strong><?= ($total_sum_of_average_sale_amount > 0) ? get_floating_point_number(($total_sum_of_average_sale_amount / $month_duration_count), TRUE) : get_floating_point_number(0); ?></strong></td>
                    <td class="text-right"><strong><?= ($total_sum_of_average_collection_amount > 0) ? get_floating_point_number(($total_sum_of_average_collection_amount / $month_duration_count), TRUE) : get_floating_point_number(0); ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($total_sum_of_accumulated_target_amount, TRUE); ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($total_sum_of_accumulated_sale_amount, TRUE); ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($total_sum_of_accumulated_collection_amount, TRUE); ?></strong></td>
                </tr>
            <?php }
            ?>
        </tbody>
    </table>
</div>

<!--For Print-->
<script type="text/javascript">
    $(document).ready(function () {
        
        exportToExcel('print-table');

        $(".monthly-progress-report-table-print-button").click(function () {
            var divContents = $('#monthly-progress-report-table-print-section').html();
            var printWindow = window.open();
            printWindow.document.write(divContents);
            printWindow.document.close();
            printWindow.print();
            printWindow.close();
        });
        
    });
</script>

