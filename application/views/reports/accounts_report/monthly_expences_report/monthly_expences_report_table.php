<div class="card card-boarder">

    <?php
    $user_info = $this->session->userdata('user_session');
    $user_type = $user_info['user_type'];
    $print_access = $user_info['print_access'];

    function get_monthly_expences($head_id, $month_number, $year) {
        $m_voucher_posting_details = new Voucher_posting_details_Model();
        $m_head_details = new Head_details_Model();
        $res = $m_voucher_posting_details->get_voucher_posting_details_sum_by_head_id($head_id, $month_number, $year);
        $amount = 0;
        if ($head_id == 114 && $month_number == 1) {
            $amount = $m_voucher_posting_details->get_profit_loss_appropriation_first_transaction_amount_of_year($head_id = 114, $month_number, $year, $dr_cr = 'dr');
        }
        if (!empty($res)) {
            $head_info = $m_head_details->get_head_details($head_id);
            if (!empty($head_info) && strtolower($head_info->head_type) == 'both') {
                return $res->sum_of_debit_amount - $amount;
//                if (get_floating_point_number($res->sum_of_debit_amount) > get_floating_point_number($res->sum_of_credit_amount)) {
//                    return $res->sum_of_debit_amount;
//                } else {
//                    return 0;
//                }
            } else {
                return $res->sum_of_debit_amount - $amount;
            }
        } else {
            return 0;
        }
    }

    function is_head_posting($head_id, $year, $type) { // return true or false
        $m_daywise_head_posting = new Daywise_head_posting_Model();
        $result = $m_daywise_head_posting->is_head_posting($head_id, $year, $type);
        return $result;
    }
    ?>

    <div class="col-xs-12 col-sm-8">
        <div class="col-xs-12">
            <label class="search-from-date">Period: 1st January To 31st December <?= $year ?></label><br>
        </div>
    </div>
    <?php if ((strtolower($user_type) != 'marketing')) { ?>
        <?php if (!empty($print_access) > 0) { ?>
            <div class="col-xs-12 col-sm-4">
                <button type="button" class="btn btn-primary monthly-expences-report-print-button report-print-button"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
            </div>
            <?php
        }
    }
    ?>

    <table class="table table-striped" style="width: 100%" id="details-table">

        <thead class="thead-default">
            <tr>
                <th>SL</th>
                <th>Head</th>
                <th class="text-right">Jan</th>
                <th class="text-right">Feb</th>
                <th class="text-right">Mar</th>
                <th class="text-right">Apr</th>
                <th class="text-right">May</th>
                <th class="text-right">Jun</th>
                <th class="text-right">Jul</th>
                <th class="text-right">Aug</th>
                <th class="text-right">Sep</th>
                <th class="text-right">Oct</th>
                <th class="text-right">Nov</th>
                <th class="text-right">Dec</th>
                <th class="text-right">Total</th>

            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            $january = 0;
            $february = 0;
            $march = 0;
            $april = 0;
            $may = 0;
            $june = 0;
            $july = 0;
            $august = 0;
            $september = 0;
            $october = 0;
            $november = 0;
            $december = 0;
            $january_total = 0;
            $february_total = 0;
            $march_total = 0;
            $april_total = 0;
            $may_total = 0;
            $june_total = 0;
            $july_total = 0;
            $august_total = 0;
            $september_total = 0;
            $october_total = 0;
            $november_total = 0;
            $december_total = 0;
            $monthly_expense_total = 0;
            $monthly_expense_all_total = 0;
            foreach ($expense_head_details_list as $expense_head) {
//                if($expense_head->id == 114){
//                    continue;
//                }
                ?>
                <?php
                $head_id = $expense_head->id;
                $head_name = $expense_head->head_name;
                $is_active_head = $expense_head->is_active;
                if (!empty($expense_head) && !($is_active_head)) {
                    continue;
                }
                ?>
                <?php
                $is_head_posting = is_head_posting($head_id, $year, $type = 2);
                if (TRUE) {
                    ?>
                    <?php $january = (double) get_monthly_expences($head_id, '1', $year); ?>
                    <?php $february = (double) get_monthly_expences($head_id, '2', $year); ?>
                    <?php $march = (double) get_monthly_expences($head_id, '3', $year); ?>
                    <?php $april = (double) get_monthly_expences($head_id, '4', $year); ?>
                    <?php $may = (double) get_monthly_expences($head_id, '5', $year); ?>
                    <?php $june = (double) get_monthly_expences($head_id, '6', $year); ?>
                    <?php $july = (double) get_monthly_expences($head_id, '7', $year); ?>
                    <?php $august = (double) get_monthly_expences($head_id, '8', $year); ?>
                    <?php $september = (double) get_monthly_expences($head_id, '9', $year); ?>
                    <?php $october = (double) get_monthly_expences($head_id, '10', $year); ?>
                    <?php $november = (double) get_monthly_expences($head_id, '11', $year); ?>
                    <?php $december = (double) get_monthly_expences($head_id, '12', $year); ?>

                    <?php $january_total += (double) $january; ?>
                    <?php $february_total += (double) $february; ?>
                    <?php $march_total += (double) $march; ?>
                    <?php $april_total += (double) $april; ?>
                    <?php $may_total += (double) $may; ?>
                    <?php $june_total += (double) $june; ?>
                    <?php $july_total += (double) $july; ?>
                    <?php $august_total += (double) $august; ?>
                    <?php $september_total += (double) $september; ?>
                    <?php $october_total += (double) $october; ?>
                    <?php $november_total += (double) $november; ?>
                    <?php $december_total += (double) $december; ?>
                    <?php $monthly_expense_total = (double) ($january + $february + $march + $april + $may + $june + $july + $august + $september + $october + $november + $december); ?>
                    <?php $monthly_expense_all_total += $monthly_expense_total; ?>
                    <?php if ($january > 0 || $february > 0 || $march > 0 || $april > 0 || $may > 0 || $june > 0 || $july > 0 || $august > 0 || $september > 0 || $october > 0 || $november > 0 || $december > 0) { ?>
                        <tr>
                            <td><?= $count++; ?></td>
                            <td><?= !empty($head_name) ? ucfirst($head_name) : '' ?></td>
                            <td class="text-right"><?= get_floating_point_number($january, TRUE) ?></td>
                            <td class="text-right"><?= get_floating_point_number($february, TRUE) ?></td>
                            <td class="text-right"><?= get_floating_point_number($march, TRUE) ?></td>
                            <td class="text-right"><?= get_floating_point_number($april, TRUE) ?></td>
                            <td class="text-right"><?= get_floating_point_number($may, TRUE) ?></td>
                            <td class="text-right"><?= get_floating_point_number($june, TRUE) ?></td>
                            <td class="text-right"><?= get_floating_point_number($july, TRUE) ?></td>
                            <td class="text-right"><?= get_floating_point_number($august, TRUE) ?></td>
                            <td class="text-right"><?= get_floating_point_number($september, TRUE) ?></td>
                            <td class="text-right"><?= get_floating_point_number($october, TRUE) ?></td>
                            <td class="text-right"><?= get_floating_point_number($november, TRUE) ?></td>
                            <td class="text-right"><?= get_floating_point_number($december, TRUE) ?></td>
                            <td class="text-right"><?= get_floating_point_number($monthly_expense_total, TRUE) ?></td>
                        </tr>
                    <?php }
                    ?>

                <?php } ?>
            <?php } ?>
            <tr>
                <td><strong></strong></td>
                <td><strong>Grand Total</strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($january_total, TRUE) ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($february_total, TRUE) ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($march_total, TRUE) ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($april_total, TRUE) ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($may_total, TRUE) ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($june_total, TRUE) ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($july_total, TRUE) ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($august_total, TRUE) ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($september_total, TRUE) ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($october_total, TRUE) ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($november_total, TRUE) ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($december_total, TRUE) ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($monthly_expense_all_total, TRUE) ?></strong></td>
            </tr>
        <hr>
        </tbody>
    </table>
</div>

<!--For Print-->
<!--Display None-->

<div id="monthly-expences-report-print-information" style="display: none">
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

    <div class="col-xs-12">
        <h4 style="text-align: center"><?= strtoupper($company_information->company_name_1) ?></h4>
        <!--<h6 style="text-align: center;"><? /*= $company_information->company_address_1 */ ?></h6>-->
    </div>

    <div class="col-xs-12" style=" margin-bottom: 10px">
        <label class="search-from-date"><strong>Monthly Expenses Report(Payment Side)(Dr) Report</strong></label>
    </div>

    <div class="col-xs-12" style=" margin-bottom: 10px">
        <label class="search-from-date">Period: 1st January To 31st December <?= $year ?></label>
    </div>
    <table class="table table-striped print-table" style="width: 100%" id="details-table">

        <thead class="thead-default">
            <tr>
                <th>SL</th>
                <th>Head</th>
                <th class="text-right">Jan</th>
                <th class="text-right">Feb</th>
                <th class="text-right">Mar</th>
                <th class="text-right">Apr</th>
                <th class="text-right">May</th>
                <th class="text-right">Jun</th>
                <th class="text-right">Jul</th>
                <th class="text-right">Aug</th>
                <th class="text-right">Sep</th>
                <th class="text-right">Oct</th>
                <th class="text-right">Nov</th>
                <th class="text-right">Dec</th>
                <th class="text-right">Total</th>

            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            $january = 0;
            $february = 0;
            $march = 0;
            $april = 0;
            $may = 0;
            $june = 0;
            $july = 0;
            $august = 0;
            $september = 0;
            $october = 0;
            $november = 0;
            $december = 0;
            $january_total = 0;
            $february_total = 0;
            $march_total = 0;
            $april_total = 0;
            $may_total = 0;
            $june_total = 0;
            $july_total = 0;
            $august_total = 0;
            $september_total = 0;
            $october_total = 0;
            $november_total = 0;
            $december_total = 0;
            $monthly_expense_total = 0;
            $monthly_expense_all_total = 0;
            foreach ($expense_head_details_list as $expense_head) {
//                if($expense_head->id == 114){
//                    continue;
//                }
                ?>
                <?php
                $head_id = $expense_head->id;
                $head_name = $expense_head->head_name;
                $is_active_head = $expense_head->is_active;
                if (!empty($expense_head) && !($is_active_head)) {
                    continue;
                }
                ?>
                <?php
                $is_head_posting = is_head_posting($head_id, $year, $type = 2);
                if (TRUE) {
                    ?>
                    <?php $january = (double) get_monthly_expences($head_id, '1', $year); ?>
                    <?php $february = (double) get_monthly_expences($head_id, '2', $year); ?>
                    <?php $march = (double) get_monthly_expences($head_id, '3', $year); ?>
                    <?php $april = (double) get_monthly_expences($head_id, '4', $year); ?>
                    <?php $may = (double) get_monthly_expences($head_id, '5', $year); ?>
                    <?php $june = (double) get_monthly_expences($head_id, '6', $year); ?>
                    <?php $july = (double) get_monthly_expences($head_id, '7', $year); ?>
                    <?php $august = (double) get_monthly_expences($head_id, '8', $year); ?>
                    <?php $september = (double) get_monthly_expences($head_id, '9', $year); ?>
                    <?php $october = (double) get_monthly_expences($head_id, '10', $year); ?>
                    <?php $november = (double) get_monthly_expences($head_id, '11', $year); ?>
                    <?php $december = (double) get_monthly_expences($head_id, '12', $year); ?>

                    <?php $january_total += (double) $january; ?>
                    <?php $february_total += (double) $february; ?>
                    <?php $march_total += (double) $march; ?>
                    <?php $april_total += (double) $april; ?>
                    <?php $may_total += (double) $may; ?>
                    <?php $june_total += (double) $june; ?>
                    <?php $july_total += (double) $july; ?>
                    <?php $august_total += (double) $august; ?>
                    <?php $september_total += (double) $september; ?>
                    <?php $october_total += (double) $october; ?>
                    <?php $november_total += (double) $november; ?>
                    <?php $december_total += (double) $december; ?>
                    <?php $monthly_expense_total = (double) ($january + $february + $march + $april + $may + $june + $july + $august + $september + $october + $november + $december); ?>
                    <?php $monthly_expense_all_total += $monthly_expense_total; ?>
                    <?php if ($january > 0 || $february > 0 || $march > 0 || $april > 0 || $may > 0 || $june > 0 || $july > 0 || $august > 0 || $september > 0 || $october > 0 || $november > 0 || $december > 0) { ?>
                        <tr>
                            <td><?= $count++; ?></td>
                            <td><?= !empty($head_name) ? ucfirst($head_name) : '' ?></td>
                            <td class="text-right"><?= get_floating_point_number($january, TRUE) ?></td>
                            <td class="text-right"><?= get_floating_point_number($february, TRUE) ?></td>
                            <td class="text-right"><?= get_floating_point_number($march, TRUE) ?></td>
                            <td class="text-right"><?= get_floating_point_number($april, TRUE) ?></td>
                            <td class="text-right"><?= get_floating_point_number($may, TRUE) ?></td>
                            <td class="text-right"><?= get_floating_point_number($june, TRUE) ?></td>
                            <td class="text-right"><?= get_floating_point_number($july, TRUE) ?></td>
                            <td class="text-right"><?= get_floating_point_number($august, TRUE) ?></td>
                            <td class="text-right"><?= get_floating_point_number($september, TRUE) ?></td>
                            <td class="text-right"><?= get_floating_point_number($october, TRUE) ?></td>
                            <td class="text-right"><?= get_floating_point_number($november, TRUE) ?></td>
                            <td class="text-right"><?= get_floating_point_number($december, TRUE) ?></td>
                            <td class="text-right"><?= get_floating_point_number($monthly_expense_total, TRUE) ?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
            <tr>
                <td><strong></strong></td>
                <td><strong>Grand Total</strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($january_total, TRUE) ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($february_total, TRUE) ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($march_total, TRUE) ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($april_total, TRUE) ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($may_total, TRUE) ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($june_total, TRUE) ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($july_total, TRUE) ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($august_total, TRUE) ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($september_total, TRUE) ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($october_total, TRUE) ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($november_total, TRUE) ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($december_total, TRUE) ?></strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($monthly_expense_all_total, TRUE) ?></strong></td>
            </tr>
        <hr>
        </tbody>
    </table>
</div>



<!--For Print-->
<script language="javascript" type="text/javascript">

    $(".monthly-expences-report-print-button").on("click", function () {

        var divContents = $('#monthly-expences-report-print-information').html();
        var printWindow = window.open();
        printWindow.document.write(divContents);
        printWindow.document.close();
        printWindow.print();
        printWindow.close();
    });

    $('#details-table').dataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [[25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]],
        "scrollY": "400px",
        "scrollX": true,
        "ordering": false,
    });


</script>
