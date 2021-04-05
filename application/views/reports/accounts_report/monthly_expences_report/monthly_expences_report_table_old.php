<div class="card card-boarder">

    <?php
    $user_info = $this->session->userdata('user_session');
    $user_type = $user_info['user_type'];
    $print_access = $user_info['print_access'];

    function get_monthly_expences($head_id, $month_number, $year) {
        $m_daywise_head_posting = new Daywise_head_posting_Model();
        $m_head_details = new Head_details_Model();
        $res = $m_daywise_head_posting->get_last_daywise_head_posting_by_head($head_id, $month_number, $year);
        if (!empty($res)) {
            $head_info = $m_head_details->get_head_details($head_id);
            if (!empty($head_info) && strtolower($head_info->head_type) == 'both') {
                if ((double) $res->closing_balance > 0) {
                    return $res->closing_balance;
                } else {
                    return 0;
                }
            } else {
                return $res->closing_balance;
            }
        } else {
            return 0;
        }
    }

    function get_single_head_monthly_expences_total($head_id, $year) {
        $result = 0;
        $amount = 0;
        $m_daywise_head_posting = new Daywise_head_posting_Model();
        $m_head_details = new Head_details_Model();
        for ($month_number = 1; $month_number <= 12; $month_number++) {
            $res = $m_daywise_head_posting->get_last_daywise_head_posting_by_head($head_id, $month_number, $year);
            if (!empty($res)) {
                $head_info = $m_head_details->get_head_details($head_id);
                if (!empty($head_info) && strtolower($head_info->head_type) == 'both') {
                    if ((double) $res->closing_balance > 0) {
                        $amount = $res->closing_balance;
                    } else {
                        $amount = 0;
                    }
                } else {
                    $amount = $res->closing_balance;
                }
            } else {
                $amount = 0;
            }
            $result += (double) $amount;
        }
        return $result;
    }

    function get_single_head_current_expence_balance($head_id, $year) {
        $result = 0;
        $amount = 0;
        $m_daywise_head_posting = new Daywise_head_posting_Model();
        $m_head_details = new Head_details_Model();
        $res = $m_daywise_head_posting->get_current_balance_from_daywise_head_posting_by_head($head_id, $year);
        if (!empty($res)) {
            $head_info = $m_head_details->get_head_details($head_id);
            if (!empty($head_info) && strtolower($head_info->head_type) == 'both') {
                if ((double) $res->closing_balance > 0) {
                    $amount = $res->closing_balance;
                } else {
                    $amount = 0;
                }
            } else {
                $amount = $res->closing_balance;
            }
        } else {
            $amount = 0;
        }
        $result = (double) $amount;
        return !empty($result) ? $result : 0;
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
                <th>Jan</th>
                <th>Feb</th>
                <th>Mar</th>
                <th>Apr</th>
                <th>May</th>
                <th>Jun</th>
                <th>Jul</th>
                <th>Aug</th>
                <th>Sep</th>
                <th>Oct</th>
                <th>Nov</th>
                <th>Dec</th>
                <th>Total</th>

            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
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
            $all_total = 0;
            foreach ($expense_head_details_list as $expense_head) {
                ?>
                <?php
                $head_id = $expense_head->id;
                $head_name = $expense_head->head_name;
                ?>
                <?php
                $is_head_posting = is_head_posting($head_id, $year, $type = 2);
                if ($is_head_posting) {
                    ?>
                    <?php $january_total += (double) get_monthly_expences($head_id, '1', $year); ?>
                    <?php $february_total += (double) get_monthly_expences($head_id, '2', $year); ?>
                    <?php $march_total += (double) get_monthly_expences($head_id, '3', $year); ?>
                    <?php $april_total += (double) get_monthly_expences($head_id, '4', $year); ?>
                    <?php $may_total += (double) get_monthly_expences($head_id, '5', $year); ?>
                    <?php $june_total += (double) get_monthly_expences($head_id, '6', $year); ?>
                    <?php $july_total += (double) get_monthly_expences($head_id, '7', $year); ?>
                    <?php $august_total += (double) get_monthly_expences($head_id, '8', $year); ?>
                    <?php $september_total += (double) get_monthly_expences($head_id, '9', $year); ?>
                    <?php $october_total += (double) get_monthly_expences($head_id, '10', $year); ?>
                    <?php $november_total += (double) get_monthly_expences($head_id, '11', $year); ?>
                    <?php $december_total += (double) get_monthly_expences($head_id, '12', $year); ?>
                    <?php // $all_total += (double) get_single_head_monthly_expences_total($head_id, $year); ?>
                    <?php $all_total += (double) get_single_head_current_expence_balance($head_id, $year); ?>
                    <tr>
                        <td><?= $count++; ?></td>
                        <td><?= !empty($head_name) ? ucfirst($head_name) : '' ?></td>
                        <td><?= get_floating_point_number(get_monthly_expences($head_id, '1', $year), TRUE) ?></td>
                        <td><?= get_floating_point_number(get_monthly_expences($head_id, '2', $year), TRUE) ?></td>
                        <td><?= get_floating_point_number(get_monthly_expences($head_id, '3', $year), TRUE) ?></td>
                        <td><?= get_floating_point_number(get_monthly_expences($head_id, '4', $year), TRUE) ?></td>
                        <td><?= get_floating_point_number(get_monthly_expences($head_id, '5', $year), TRUE) ?></td>
                        <td><?= get_floating_point_number(get_monthly_expences($head_id, '6', $year), TRUE) ?></td>
                        <td><?= get_floating_point_number(get_monthly_expences($head_id, '7', $year), TRUE) ?></td>
                        <td><?= get_floating_point_number(get_monthly_expences($head_id, '8', $year), TRUE) ?></td>
                        <td><?= get_floating_point_number(get_monthly_expences($head_id, '9', $year), TRUE) ?></td>
                        <td><?= get_floating_point_number(get_monthly_expences($head_id, '10', $year), TRUE) ?></td>
                        <td><?= get_floating_point_number(get_monthly_expences($head_id, '11', $year), TRUE) ?></td>
                        <td><?= get_floating_point_number(get_monthly_expences($head_id, '12', $year), TRUE) ?></td>
                        <!--<td><?= get_floating_point_number(get_single_head_monthly_expences_total($head_id, $year), TRUE) ?></td>-->
                        <td><?= get_floating_point_number(get_single_head_current_expence_balance($head_id, $year), TRUE) ?></td>
                    </tr>
                <?php } ?>
            <?php } ?>
            <tr>
                <td><strong></strong></td>
                <td><strong>Grand Total</strong></td>
                <td><strong><?= get_floating_point_number($january_total, TRUE) ?></strong></td>
                <td><strong><?= get_floating_point_number($february_total, TRUE) ?></strong></td>
                <td><strong><?= get_floating_point_number($march_total, TRUE) ?></strong></td>
                <td><strong><?= get_floating_point_number($april_total, TRUE) ?></strong></td>
                <td><strong><?= get_floating_point_number($may_total, TRUE) ?></strong></td>
                <td><strong><?= get_floating_point_number($june_total, TRUE) ?></strong></td>
                <td><strong><?= get_floating_point_number($july_total, TRUE) ?></strong></td>
                <td><strong><?= get_floating_point_number($august_total, TRUE) ?></strong></td>
                <td><strong><?= get_floating_point_number($september_total, TRUE) ?></strong></td>
                <td><strong><?= get_floating_point_number($october_total, TRUE) ?></strong></td>
                <td><strong><?= get_floating_point_number($november_total, TRUE) ?></strong></td>
                <td><strong><?= get_floating_point_number($december_total, TRUE) ?></strong></td>
                <td><strong><?= get_floating_point_number($all_total, TRUE) ?></strong></td>
            </tr>
        <hr>
        </tbody>
    </table>
</div>

<!--For Print-->
<!--Display None-->

<div id="monthly-expences-report-print-information" style="display: none">

    <div class="col-xs-12">
        <h4 style="text-align: center"><?= strtoupper($company_information->company_name_1) ?></h4>
        <!--<h6 style="text-align: center;"><? /*= $company_information->company_address_1 */ ?></h6>-->
    </div>

    <div class="col-xs-12" style=" margin-bottom: 10px">
        <label class="search-from-date"><strong>Monthly Expences Report(Payment Side)(Dr) Report</strong></label>
    </div>

    <div class="col-xs-12" style=" margin-bottom: 10px">
        <label class="search-from-date">Period: 1st January To 31st December <?= $year ?></label>
    </div>


    <table border="2px" cellspacing="0" class="table table-striped" style="width: 100%" id="details-table">

        <thead class="thead-default">
            <tr>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    SL
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Head
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Jan
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Feb
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Mar
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Apr
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    May
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Jun
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Jul
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Aug
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Sep
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Oct
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Nov
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Dec
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Total
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
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
            $all_total = 0;
            foreach ($expense_head_details_list as $expense_head) {
                ?>
                <?php
                $head_id = $expense_head->id;
                $head_name = $expense_head->head_name;
                ?>
                <?php
                $is_head_posting = is_head_posting($head_id, $year, $type = 2);
                if ($is_head_posting) {
                    ?>
                    <?php $january_total += (double) get_monthly_expences($head_id, '1', $year); ?>
                    <?php $february_total += (double) get_monthly_expences($head_id, '2', $year); ?>
                    <?php $march_total += (double) get_monthly_expences($head_id, '3', $year); ?>
                    <?php $april_total += (double) get_monthly_expences($head_id, '4', $year); ?>
                    <?php $may_total += (double) get_monthly_expences($head_id, '5', $year); ?>
                    <?php $june_total += (double) get_monthly_expences($head_id, '6', $year); ?>
                    <?php $july_total += (double) get_monthly_expences($head_id, '7', $year); ?>
                    <?php $august_total += (double) get_monthly_expences($head_id, '8', $year); ?>
                    <?php $september_total += (double) get_monthly_expences($head_id, '9', $year); ?>
                    <?php $october_total += (double) get_monthly_expences($head_id, '10', $year); ?>
                    <?php $november_total += (double) get_monthly_expences($head_id, '11', $year); ?>
                    <?php $december_total += (double) get_monthly_expences($head_id, '12', $year); ?>
                    <?php // $all_total += (double) get_single_head_monthly_expences_total($head_id, $year); ?>
                    <?php $all_total += (double) get_single_head_current_expence_balance($head_id, $year); ?>
                    <tr style="border: thick">
                        <td><?= $count++; ?></td>
                        <td><?= !empty($head_name) ? ucfirst($head_name) : '' ?></td>
                        <td><?= get_floating_point_number(get_monthly_expences($head_id, '1', $year), TRUE) ?></td>
                        <td><?= get_floating_point_number(get_monthly_expences($head_id, '2', $year), TRUE) ?></td>
                        <td><?= get_floating_point_number(get_monthly_expences($head_id, '3', $year), TRUE) ?></td>
                        <td><?= get_floating_point_number(get_monthly_expences($head_id, '4', $year), TRUE) ?></td>
                        <td><?= get_floating_point_number(get_monthly_expences($head_id, '5', $year), TRUE) ?></td>
                        <td><?= get_floating_point_number(get_monthly_expences($head_id, '6', $year), TRUE) ?></td>
                        <td><?= get_floating_point_number(get_monthly_expences($head_id, '7', $year), TRUE) ?></td>
                        <td><?= get_floating_point_number(get_monthly_expences($head_id, '8', $year), TRUE) ?></td>
                        <td><?= get_floating_point_number(get_monthly_expences($head_id, '9', $year), TRUE) ?></td>
                        <td><?= get_floating_point_number(get_monthly_expences($head_id, '10', $year), TRUE) ?></td>
                        <td><?= get_floating_point_number(get_monthly_expences($head_id, '11', $year), TRUE) ?></td>
                        <td><?= get_floating_point_number(get_monthly_expences($head_id, '12', $year), TRUE) ?></td>
                        <!--<td><?= get_floating_point_number(get_single_head_monthly_expences_total($head_id, $year), TRUE) ?></td>-->
                        <td><?= get_floating_point_number(get_single_head_current_expence_balance($head_id, $year), TRUE) ?></td>
                    </tr>
                <?php } ?>
            <?php } ?>
            <tr style="border: thick">
                <td><strong></strong></td>
                <td><strong>Grand Total</strong></td>
                <td><strong><?= get_floating_point_number($january_total, TRUE) ?></strong></td>
                <td><strong><?= get_floating_point_number($february_total, TRUE) ?></strong></td>
                <td><strong><?= get_floating_point_number($march_total, TRUE) ?></strong></td>
                <td><strong><?= get_floating_point_number($april_total, TRUE) ?></strong></td>
                <td><strong><?= get_floating_point_number($may_total, TRUE) ?></strong></td>
                <td><strong><?= get_floating_point_number($june_total, TRUE) ?></strong></td>
                <td><strong><?= get_floating_point_number($july_total, TRUE) ?></strong></td>
                <td><strong><?= get_floating_point_number($august_total, TRUE) ?></strong></td>
                <td><strong><?= get_floating_point_number($september_total, TRUE) ?></strong></td>
                <td><strong><?= get_floating_point_number($october_total, TRUE) ?></strong></td>
                <td><strong><?= get_floating_point_number($november_total, TRUE) ?></strong></td>
                <td><strong><?= get_floating_point_number($december_total, TRUE) ?></strong></td>
                <td><strong><?= get_floating_point_number($all_total, TRUE) ?></strong></td>
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
