<?php
//echo '<pre>';
//print_r($employee_salary_details);
//echo '</pre>';
$month = (!empty($month)) ? strtoupper($month) : '';
$year = (!empty($year)) ? ($year) : '';
$current_date_time = (!empty($employee_salary_details)) ? $employee_salary_details[0]->current_date_time : get_current_date_and_time();
?>
<style>
    .salary-generate-table th{
        text-align: center;
        font-weight: bold;
        font-size: 13px;
        vertical-align: middle;
        /*background-color: gray;*/
        /*color: white;*/
    }
    .salary-generate-table .sub-thead th{
        text-align: center;
        font-weight: bold;
        font-size: 12px;
        vertical-align: middle;
        /*background-color: gray;*/
        /*color: white;*/
    }
    .salary-generate-table tbody{
        font-size: 12px;
        /*background-color: gray;*/
        /*color: white;*/
    }
    .salary-generate-table .sub-thead{
        text-align: center;
        font-weight: bold;
        font-size: 12px;
        /*background-color: aliceblue;*/
    }
    .bottom-border-hidden{
        border-bottom: hidden!important;
    }
    .right-border-hidden{
        border-right: hidden!important;
    }
    .text-bold{
        font-weight: bold;
    }
    .table-thead-design{
        background-color: gray;
        color: white;
    }
    .table-sub-thead-design{
        background-color: lightgray;
        color: black;
    }
    .table-right-border-2{
        border-right: 2px solid white !important; 
    }
    .table-left-border-2{
        border-left: 2px solid white !important;
    }
    .table-right-border-1{
        border-right: 1px solid white!important;
    }
    .table-left-border-1{
        border-left: 1px solid white !important;
    }
    .vertical-center{
        vertical-align: middle !important;
    }
    .table-header-center{
        /*        position: absolute;
                margin-top: 5%;
                margin-left: 5%;
                border: none !important;*/
    }
    /*    .table-header-center-1{
            position: absolute;
            margin-top: 10%;
            margin-left: 10%;
            border: none !important;
        }*/
    .border-top-none{
        border-top: none !important;
    }
</style>
<div class="col-xs-12 table-responsive table-bordered">
    <div class="col-xs-12 text-align-center text-bold"><h4><strong>SALARY SHEET : <?= strtoupper($month) . ' ' . $year; ?></strong></h4></div>
    <div class="col-xs-12 text-align-center"><strong>DATE: <?= display_date_format($current_date_time); ?></strong></div>
    <button style="position: relative; margin-top: -50px;" type="button" class="right-side-view btn btn-primary print-button salary-table-print-button"><i class="fa fa-print" aria-hidden="true"></i>&nbsp;Print</button>
</div>

<div class="table-responsive table-bordered">
    <div class="width-100">        
        <table class="table table-bordered salary-generate-table">
            <thead>
                <tr class="table-thead-design">
                    <th rowspan="2" class="bottom-border-hidden vertical-center table-header-center">NAME</th>
                    <th rowspan="2" class="bottom-border-hidden vertical-center table-left-border-2 table-header-center-1" style="width: 100px;">DATE OF JOINING</th>
                    <th colspan="2" class="table-right-border-2 table-left-border-2 vertical-center">DESIGNATION</th>
                    <th colspan="7" class="vertical-center">NEW/REVISED SALARY</th>
                    <?= (empty($is_preview) && (!$is_preview)) ? '<th rowspan="2" class="bottom-border-hidden vertical-center">Action</th>' : ''; ?>                    
                </tr>
                <tr class="sub-thead">
                    <th class="table-sub-thead-design table-left-border-2 table-right-border-1 vertical-center">STAFF ID#</th>
                    <th class="table-sub-thead-design table-right-border-2 vertical-center">PRESENT</th>
                    <th class="table-sub-thead-design table-right-border-1 vertical-center">GROSS</th>
                    <th class="table-sub-thead-design table-right-border-1 vertical-center">NET</th>
                    <th class="table-sub-thead-design table-right-border-1 vertical-center">BASIC</th>
                    <th class="table-sub-thead-design table-right-border-1 vertical-center">BONUS</th>
                    <th class="table-sub-thead-design table-right-border-1 vertical-center">PF</th>
                    <th class="table-sub-thead-design table-right-border-1 vertical-center">LOAN</th>
                    <th class="table-sub-thead-design vertical-center">TAKE HOME SALARY</th>
                </tr>
            </thead>
            <tbody>

                <?php
                if (!empty($employee_salary_details)) {
                    $count = 1;
                    $gross_salary_total = 0;
                    $net_salary_total = 0;
                    $basic_salary_total = 0;
                    $bonus_total = 0;
                    $pf_contribution_company_part_total = 0;
                    $loan_installment_total = 0;
                    $take_home_salary_total = 0;
                    foreach ($employee_salary_details as $salary_details) {
                        if (intval($salary_details->employee_id) == 6) { // admin employee id = 6
                            continue;
                        }
                        $id = !empty($salary_details->id) ? intval($salary_details->id) : 0;
                        $joining_date = ((!empty($salary_details->joining_date)) && ($salary_details->joining_date != "0000-00-00 00:00:00")) ? date("d-m-Y", strtotime($salary_details->joining_date)) : '';
                        $gross_salary = !empty($salary_details->gross_salary) ? get_floating_point_number($salary_details->gross_salary) : 0;
                        $net_salary = !empty($salary_details->net_salary) ? get_floating_point_number($salary_details->net_salary) : 0;
                        $basic_salary = !empty($salary_details->basic_salary) ? get_floating_point_number($salary_details->basic_salary) : 0;
                        $bonus = !empty($salary_details->bonus) ? get_floating_point_number($salary_details->bonus) : '0.00';
                        $pf_contribution_company = !empty($salary_details->pf_contribution_company_part) ? get_floating_point_number($salary_details->pf_contribution_company_part) : 0;
                        $loan_installment = !empty($salary_details->loan_installment) ? get_floating_point_number($salary_details->loan_installment) : 0;
                        $take_home_salary = !empty($salary_details->take_home_salary) ? get_floating_point_number($salary_details->take_home_salary) : 0;
                        if (($take_home_salary) <= 100) {  // do not show take home salary below 100 
                            continue;
                        }
                        $gross_salary_total += $gross_salary;
                        $net_salary_total += $net_salary;
                        $basic_salary_total += $basic_salary;
                        $bonus_total += $bonus;
                        $pf_contribution_company_part_total += $pf_contribution_company;
                        $loan_installment_total += $loan_installment;
                        $take_home_salary_total += $take_home_salary;
                        ?>
                        <tr>
                            <td><?= !empty($salary_details->employee_name) ? ucfirst($salary_details->employee_name) : ''; ?></td>
                            <td><?= $joining_date; ?></td>
                            <td><?= !empty($salary_details->employee_code) ? ($salary_details->employee_code) : ''; ?></td>
                            <td><?= !empty($salary_details->designation) ? ucfirst($salary_details->designation) : ''; ?></td>
                            <td class="text-right"><?= get_floating_point_number($gross_salary, TRUE); ?></td>
                            <td class="text-right"><?= get_floating_point_number($net_salary, TRUE); ?></td>
                            <td class="text-right"><?= get_floating_point_number($basic_salary, TRUE); ?></td>
                            <td class="text-right"><?= get_floating_point_number($bonus, TRUE); ?></td>
                            <td class="text-right"><?= get_floating_point_number($pf_contribution_company, TRUE); ?></td>
                            <td class="text-right"><?= get_floating_point_number($loan_installment, TRUE); ?></td>
                            <td class="text-right"><?= get_floating_point_number($take_home_salary, TRUE); ?></td>
                            <?php if ($id > 0) { ?>
                                <td class="<?= (empty($is_preview) && (!$is_preview)) ? '' : 'display-none'; ?> ">
                                    <a href="<?= base_url("employee_salary_generate/employee_salary_details/$id") ?>" class="btn btn-primary"> <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                </td>
                            <?php }
                            ?>

                        </tr>
                    <?php }
                    ?>
                    <tr>
                        <td class="text-right" colspan="4" style="border: none!important;"></td>
                        <td class="text-right"><strong><?= get_floating_point_number($gross_salary_total, TRUE); ?></strong></td>
                        <td class="text-right"><strong><?= get_floating_point_number($net_salary_total, TRUE); ?></strong></td>
                        <td class="text-right"><strong><?= get_floating_point_number($basic_salary_total, TRUE); ?></strong></td>
                        <td class="text-right"><strong><?= get_floating_point_number($bonus_total, TRUE); ?></strong></td>
                        <td class="text-right"><strong><?= get_floating_point_number($pf_contribution_company_part_total, TRUE); ?></strong></td>
                        <td class="text-right"><strong><?= get_floating_point_number($loan_installment_total, TRUE); ?></strong></td>
                        <td class="text-right"><strong><?= get_floating_point_number($take_home_salary_total, TRUE); ?></strong></td>
                        <?= (empty($is_preview) && (!$is_preview)) ? '<td class="text-right right-border-hidden"></td>' : ''; ?>                         
                    </tr>
                <?php }
                ?>  
            </tbody>
        </table>
    </div>
</div>

<!--Display None-->
<!--For Print-->
<div id="salary-table-print-information" style="width: 100%; display: none;">

    <style>
        .table {
            border-collapse: collapse !important;
        }
        .table td,
        .table th {
            /*            background-color: #fff !important;*/
        }
        .table-bordered th,
        .table-bordered td {
            border: 1px solid #ddd !important;
        }

        .salary-generate-table-for-print{
            border-collapse: collapse;
            /*border: 1px solid black;*/
        }
        .salary-generate-table-for-print th{
            text-align: center;
            font-weight: bold;
            font-size: 13px;
            /*background-color: gray;*/
            color: white;
        }
        .salary-generate-table-for-print .sub-thead th{
            text-align: center;
            font-weight: bold;
            font-size: 12px;
            /*background-color: gray;*/
            color: white;
        }
        .salary-generate-table-for-print tbody{
            font-size: 12px;
        }
        .salary-generate-table-for-print .sub-thead{
            text-align: center;
            font-weight: bold;
            /*background-color: aliceblue;*/
        }
        .bottom-border-hidden{
            border-bottom: hidden!important;
        }
        .right-border-hidden{
            border-right: hidden!important;
        }
        .text-bold{
            font-weight: bold;
        }
        .border-thick{
            border: thick;
        }
        .text-right{
            text-align: right;
        }
        .table-thead-design{
            background-color: gray;
            color: white;
        }
        .table-sub-thead-design{
            background-color: lightgray;
            color: black !important;
        }
        .table-right-border-2{
            border-right: 2px solid white !important; 
        }
        .table-left-border-2{
            border-left: 2px solid white !important;
        }
        .table-right-border-1{
            border-right: 1px solid white!important;
        }
        .table-left-border-1{
            border-left: 1px solid white !important;
        }
        .vertical-center{
            vertical-align: middle !important;
        }
        .table-header-center{
            /*        position: absolute;
                    margin-top: 5%;
                    margin-left: 5%;
                    border: none !important;*/
        }
        /*    .table-header-center-1{
                position: absolute;
                margin-top: 10%;
                margin-left: 10%;
                border: none !important;
            }*/
        .border-top-none{
            border-top: none !important;
        }
    </style>

    <div style="width: 100%">
        <div style="text-align: center; font-size: 20px; font-weight: bold;">SALARY SHEET : <?= strtoupper($month) . ' ' . $year; ?></div>
        <div style="text-align: center; font-size: 14px;">DATE: <?= display_date_format($current_date_time); ?></div>
        <br>
    </div>

    <table cellspacing="0" class="table table-bordered salary-generate-table-for-print">
        <thead>
            <tr class="table-thead-design">
                <th rowspan="2" class="bottom-border-hidden vertical-center table-header-center">NAME</th>
                <th rowspan="2" class="bottom-border-hidden vertical-center table-left-border-2 table-header-center-1" style="width: 100px;">DATE OF JOINING</th>
                <th colspan="2" class="table-right-border-2 table-left-border-2 vertical-center">DESIGNATION</th>
                <th colspan="7" class="vertical-center">NEW/REVISED SALARY</th>                
            </tr>
            <tr class="sub-thead">
                <th class="table-sub-thead-design table-left-border-2 table-right-border-1 vertical-center">STAFF ID#</th>
                <th class="table-sub-thead-design table-right-border-2 vertical-center">PRESENT</th>
                <th class="table-sub-thead-design table-right-border-1 vertical-center">GROSS</th>
                <th class="table-sub-thead-design table-right-border-1 vertical-center">NET</th>
                <th class="table-sub-thead-design table-right-border-1 vertical-center">BASIC</th>
                <th class="table-sub-thead-design table-right-border-1 vertical-center">BONUS</th>
                <th class="table-sub-thead-design table-right-border-1 vertical-center">PF</th>
                <th class="table-sub-thead-design table-right-border-1 vertical-center">LOAN</th>
                <th class="table-sub-thead-design vertical-center">TAKE HOME SALARY</th>
            </tr>
        </thead>
        <tbody>

            <?php
            if (!empty($employee_salary_details)) {
                $count = 1;
                $gross_salary_total = 0;
                $net_salary_total = 0;
                $basic_salary_total = 0;
                $bonus_total = 0;
                $pf_contribution_company_part_total = 0;
                $loan_installment_total = 0;
                $take_home_salary_total = 0;
                foreach ($employee_salary_details as $salary_details) {
                    if (intval($salary_details->employee_id) == 6) { // admin employee id = 6
                        continue;
                    }
                    $id = !empty($salary_details->id) ? intval($salary_details->id) : 0;
                    $joining_date = ((!empty($salary_details->joining_date)) && ($salary_details->joining_date != "0000-00-00 00:00:00")) ? date("d-m-Y", strtotime($salary_details->joining_date)) : '';
                    $gross_salary = !empty($salary_details->gross_salary) ? get_floating_point_number($salary_details->gross_salary) : 0;
                    $net_salary = !empty($salary_details->net_salary) ? get_floating_point_number($salary_details->net_salary) : 0;
                    $basic_salary = !empty($salary_details->basic_salary) ? get_floating_point_number($salary_details->basic_salary) : 0;
                    $bonus = !empty($salary_details->bonus) ? get_floating_point_number($salary_details->bonus) : '0.00';
                    $pf_contribution_company = !empty($salary_details->pf_contribution_company_part) ? get_floating_point_number($salary_details->pf_contribution_company_part) : 0;
                    $loan_installment = !empty($salary_details->loan_installment) ? get_floating_point_number($salary_details->loan_installment) : 0;
                    $take_home_salary = !empty($salary_details->take_home_salary) ? get_floating_point_number($salary_details->take_home_salary) : 0;
                    if (($take_home_salary) <= 100) { // do not show take home salary below 100 
                        continue;
                    }
                    $gross_salary_total += $gross_salary;
                    $net_salary_total += $net_salary;
                    $basic_salary_total += $basic_salary;
                    $bonus_total += $bonus;
                    $pf_contribution_company_part_total += $pf_contribution_company;
                    $loan_installment_total += $loan_installment;
                    $take_home_salary_total += $take_home_salary;
                    ?>
                    <tr class="border-thick">
                        <td><?= !empty($salary_details->employee_name) ? ucfirst($salary_details->employee_name) : ''; ?></td>
                        <td><?= $joining_date; ?></td>
                        <td><?= !empty($salary_details->employee_code) ? ($salary_details->employee_code) : ''; ?></td>
                        <td><?= !empty($salary_details->designation) ? ucfirst($salary_details->designation) : ''; ?></td>
                        <td class="text-right"><?= get_floating_point_number($gross_salary, TRUE); ?></td>
                        <td class="text-right"><?= get_floating_point_number($net_salary, TRUE); ?></td>
                        <td class="text-right"><?= get_floating_point_number($basic_salary, TRUE); ?></td>
                        <td class="text-right"><?= get_floating_point_number($bonus, TRUE); ?></td>
                        <td class="text-right"><?= get_floating_point_number($pf_contribution_company, TRUE); ?></td>
                        <td class="text-right"><?= get_floating_point_number($loan_installment, TRUE); ?></td>
                        <td class="text-right"><?= get_floating_point_number($take_home_salary, TRUE); ?></td>
                    </tr>
                <?php }
                ?>
                <tr class="border-thick">                   
                    <td class="text-right" colspan="4" style="border: none!important;"></td>
                    <td class="text-right"><strong><?= get_floating_point_number($gross_salary_total, TRUE); ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($net_salary_total, TRUE); ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($basic_salary_total, TRUE); ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($bonus_total, TRUE); ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($pf_contribution_company_part_total, TRUE); ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($loan_installment_total, TRUE); ?></strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($take_home_salary_total, TRUE); ?></strong></td>                         
                </tr>
            <?php }
            ?>  
        </tbody>
    </table>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $(".salary-table-print-button").on("click", function () {
            var divContents = $('#salary-table-print-information').html();
            var printWindow = window.open();
            printWindow.document.write(divContents);
            printWindow.document.close();
            printWindow.print();
            printWindow.close();
        });
    });
</script>