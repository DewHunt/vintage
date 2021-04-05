<div class="card card-boarder">
    <?php
    $user_info = $this->session->userdata('user_session');
    $user_type = $user_info['user_type'];
    $print_access = $user_info['print_access'];
    $table_title = ($is_custom == 0) ? 'For the year ended ' . display_date_format_for_account_statment($end_date) : 'From ' . display_date_format_for_account_statment($start_date) . ' To ' . display_date_format_for_account_statment($end_date);

//    echo '<pre>';
//    print_r($account_statement_report);
//    echo '</pre>';
    ?>

    <div class="col-xs-12 col-sm-8">
        <div class="col-xs-12">
            <!--<label class="search-from-date">For the year ended 31th Dec-<?= $year ?></label><br>-->
            <label class="search-from-date"><?= $table_title; ?></label><br>
        </div>
    </div>
    <?php if ((strtolower($user_type) != 'marketing')) { ?>
        <?php if (!empty($print_access) > 0) { ?>
            <div class="col-xs-12 col-sm-4">
                <button type="button" class="btn btn-primary account-statement-report-print-button report-print-button"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
            </div>
            <?php
        }
    }
    ?>

    <div class="clearfix"></div>
    <div class="form-group table-responsive">
        <table class="table table-bordered table-striped" style="width: 100%" id="details-table">
            <?php
            $i = 0;
            $dr = !empty($account_statement_report[0]['dr']) ? $account_statement_report[0]['dr'] : '';
            $cr = !empty($account_statement_report[0]['cr']) ? $account_statement_report[0]['cr'] : '';
            $total_dr = !empty($account_statement_report[0]['total_dr']) ? $account_statement_report[0]['total_dr'] : 0;
            $total_cr = !empty($account_statement_report[0]['total_cr']) ? $account_statement_report[0]['total_cr'] : 0;
            $difference = !empty($account_statement_report[0]['difference']) ? $account_statement_report[0]['difference'] : 0;
            $profit = $account_statement_report['profit'];
            $loss = $account_statement_report['loss'];
            $previous_account_statement_profit = $account_statement_report[0]['previous_profit'];
            $previous_account_statement_loss = $account_statement_report[0]['previous_loss'];
            $previous_profit_heading = $account_statement_report[0]['previous_profit_heading'];
            $previous_loss_heading = $account_statement_report[0]['previous_loss_heading'];
            $profit_heading = $account_statement_report[0]['profit_heading'];
            $loss_heading = $account_statement_report[0]['loss_heading'];
            $grand_total_dr = $account_statement_report['grand_total_dr'];
            $grand_total_cr = $account_statement_report['grand_total_cr'];
            $table_heading_1 = $account_statement_report['table_heading_1'];
            $table_heading_2 = $account_statement_report['table_heading_2'];
            $table_heading_3 = $account_statement_report['table_heading_3'];
            $table_heading_4 = $account_statement_report['table_heading_4'];
            ?>
            <thead>
                <tr>
                    <th><?= $table_heading_1 ?></th>
                    <th class="text-align-right"><?= $table_heading_2 ?></th>
                    <th><?= $table_heading_3 ?></th>
                    <th class="text-align-right"><?= $table_heading_4 ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if ((double) $previous_account_statement_loss != (double) 0) { ?>
                    <tr>
                        <td class="text-align-left"><?= $previous_loss_heading ?></td>
                        <td class="text-align-right"><?= !empty($previous_account_statement_loss) ? get_floating_point_number($previous_account_statement_loss) : get_floating_point_number(0) ?></td>
                        <td class="text-align-right"></td>
                        <td class="text-align-right"></td>
                    </tr>
                <?php } ?>
                <?php if ((double) $previous_account_statement_profit != (double) 0) { ?>

                    <tr>
                        <td class="text-align-right"></td>
                        <td class="text-align-right"></td>
                        <td class="text-align-left"><?= $previous_profit_heading ?></td>
                        <td class="text-align-right"><?= !empty($previous_account_statement_profit) ? get_floating_point_number($previous_account_statement_profit) : get_floating_point_number(0) ?></td>
                    </tr>
                <?php } ?>
                <?php
                if (!empty($dr) || !empty($cr)) {
                    $maximum_length = max(count($dr), count($cr));
                    ?>
                    <?php
                    while ((int) $i < (int) $maximum_length) {
                        ?>
                        <tr style="line-height: 30px;border-bottom: 0;">
                            <td><?= !empty($dr[$i]) ? ucfirst($dr[$i]['head_name']) : '' ?></td>
                            <td class="text-align-right"><?= !empty($dr[$i]) ? get_floating_point_number(abs($dr[$i]['balance'])) : '' ?></td>
                            <td><?= !empty($cr[$i]) ? ucfirst($cr[$i]['head_name']) : '' ?></td>
                            <td class="text-align-right"><?= !empty($cr[$i]) ? get_floating_point_number(abs($cr[$i]['balance'])) : '' ?></td>
                        </tr>
                        <?php
                        $i++;
                    }
                    ?>
                <?php } ?>

                <tr>
                    <td class="text-align-right"></td>
                    <td class="text-align-right">
                        <?= !empty($total_dr) ? get_floating_point_number($total_dr) : get_floating_point_number(0) ?>
                    </td>
                    <td class="text-align-right"></td>
                    <td class="text-align-right">
                        <?= !empty($total_cr) ? get_floating_point_number($total_cr) : get_floating_point_number(0) ?>
                    </td>
                </tr>  
                <?php if ((double) $loss != (double) 0) { ?>
                    <tr>
                        <td class="text-align-right"><? ?></td>
                        <td class="text-align-right"><? ?></td>
                        <td><?= $loss_heading ?></td>
                        <td class="text-align-right"><?= get_floating_point_number(abs($loss)) ?></td>
                    </tr>
                <?php } ?>
                <?php if ((double) $profit != (double) 0) { ?>
                    <tr>
                        <td><?= $profit_heading ?></td>
                        <td class="text-align-right"><?= get_floating_point_number(abs($profit)) ?></td>
                        <td class="text-align-right"><? ?></td>
                        <td class="text-align-right"><? ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td class="text-align-right"></td>
                    <td class="text-align-right">
                        <strong>
                            <?= get_floating_point_number((double) $grand_total_dr) ?>
                        </strong>
                    </td>
                    <td class="text-align-right"></td>
                    <td class="text-align-right">
                        <strong>
                            <?= get_floating_point_number((double) $grand_total_cr) ?>
                        </strong>
                    </td>
                </tr>

            </tbody>              
        </table>
    </div>
</div>

<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="account-statement-report-print-information" style="display: none">
    <div class="col-xs-12" style="text-align: center; font-size: 22px; font-weight: bolder">
        <label class=""><?= strtoupper($company_information->company_name_1) ?></label>
    </div>
    <div class="col-xs-12" style="text-align: center">
        <label class=""><?= $company_information->company_address_1 ?></label><br>
    </div>
    <div class="col-xs-12" style="text-align: center; font-size: 16px; font-weight: bolder">
        <label class=""><?= strtoupper($print_report_heading) ?></label>
    </div>
    <div class="col-xs-12" style="text-align: center">
        <!--<label class=""><?= 'For the year ended 31th Dec-' . $year ?></label><br>-->
        <label class=""><?= $table_title; ?></label><br>
    </div>

    <div class="col-xs-12">
        <table class="table table-bordered table-striped" border="2px solid black" cellspacing="0" style="width: 100%" id="details-table">
            <?php
            $i = 0;
            $dr = $account_statement_report[0]['dr'];
            $cr = $account_statement_report[0]['cr'];
            $total_dr = $account_statement_report[0]['total_dr'];
            $total_cr = $account_statement_report[0]['total_cr'];
            $difference = $account_statement_report[0]['difference'];
            $profit = $account_statement_report['profit'];
            $loss = $account_statement_report['loss'];
            $previous_account_statement_profit = $account_statement_report[0]['previous_profit'];
            $previous_account_statement_loss = $account_statement_report[0]['previous_loss'];
            $previous_profit_heading = $account_statement_report[0]['previous_profit_heading'];
            $previous_loss_heading = $account_statement_report[0]['previous_loss_heading'];
            $profit_heading = $account_statement_report[0]['profit_heading'];
            $loss_heading = $account_statement_report[0]['loss_heading'];
            $grand_total_dr = $account_statement_report['grand_total_dr'];
            $grand_total_cr = $account_statement_report['grand_total_cr'];
            $table_heading_1 = $account_statement_report['table_heading_1'];
            $table_heading_2 = $account_statement_report['table_heading_2'];
            $table_heading_3 = $account_statement_report['table_heading_3'];
            $table_heading_4 = $account_statement_report['table_heading_4'];
            ?>
            <thead>
                <tr style="border: thick">
                    <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px"><?= $table_heading_1 ?></th>
                    <th class="text-align-right" style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px; text-align: right"><?= $table_heading_2 ?></th>
                    <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px"><?= $table_heading_3 ?></th>
                    <th class="text-align-right" style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px; text-align: right"><?= $table_heading_4 ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if ((double) $previous_account_statement_loss != (double) 0) { ?>
                    <tr style="line-height: 30px; border: thick;">
                        <td class="text-align-left"><?= $previous_loss_heading ?></td>
                        <td class="text-align-right" style="text-align: right"><?= !empty($previous_account_statement_loss) ? get_floating_point_number($previous_account_statement_loss) : get_floating_point_number(0) ?></td>
                        <td class="text-align-right"></td>
                        <td class="text-align-right"></td>
                    </tr>
                <?php } ?>
                <?php if ((double) $previous_account_statement_profit != (double) 0) { ?>
                    <tr style="line-height: 30px; border: thick;">
                        <td class="text-align-right"></td>
                        <td class="text-align-right"></td>
                        <td class="text-align-left"><?= $previous_profit_heading ?></td>
                        <td class="text-align-right" style="text-align: right"><?= !empty($previous_account_statement_profit) ? get_floating_point_number($previous_account_statement_profit) : get_floating_point_number(0) ?></td>
                    </tr><?php } ?>

                <?php
                if (!empty($dr) || !empty($cr)) {
                    $maximum_length = max(count($dr), count($cr));
                    ?>
                    <?php
                    while ((int) $i < (int) $maximum_length) {
                        ?>
                        <tr style="line-height: 30px; border: thick;">
                            <td><?= !empty($dr[$i]) ? ucfirst($dr[$i]['head_name']) : '' ?></td>
                            <td class="text-align-right" style="text-align: right"><?= !empty($dr[$i]) ? get_floating_point_number(abs($dr[$i]['balance'])) : '' ?></td>
                            <td><?= !empty($cr[$i]) ? ucfirst($cr[$i]['head_name']) : '' ?></td>
                            <td class="text-align-right" style="text-align: right"><?= !empty($cr[$i]) ? get_floating_point_number(abs($cr[$i]['balance'])) : '' ?></td>
                        </tr>
                        <?php
                        $i++;
                    }
                    ?>
                <?php } ?>
                <tr style="line-height: 30px; border: thick">
                    <td></td>
                    <td class="text-align-right" style="text-align: right"><?= !empty($total_dr) ? get_floating_point_number($total_dr) : 0 ?></td>
                    <td></td>
                    <td class="text-align-right" style="text-align: right"><?= !empty($total_cr) ? get_floating_point_number($total_cr) : 0 ?></td>
                </tr>
                <?php if ((double) $loss != (double) 0) { ?>    
                    <tr style="line-height: 30px; border: thick">
                        <td class="text-align-right" style="text-align: right"><? ?></td>
                        <td class="text-align-right" style="text-align: right"><? ?></td>
                        <td><?= $loss_heading ?></td>
                        <td class="text-align-right" style="text-align: right"><?= get_floating_point_number(abs($loss)) ?></td>
                    </tr>
                <?php } ?>
                <?php if ((double) $profit != (double) 0) { ?>
                    <tr style="line-height: 30px; border: thick">
                        <td><?= $profit_heading ?></td>
                        <td class="text-align-right" style="text-align: right"><?= get_floating_point_number(abs($profit)) ?></td>
                        <td class="text-align-right" style="text-align: right"><? ?></td>
                        <td class="text-align-right" style="text-align: right"><? ?></td>
                    </tr>
                <?php } ?>

                <tr style="line-height: 30px; border: thick">
                    <td class="text-align-right" style="text-align: right"></td>
                    <td class="text-align-right" style="text-align: right"><strong><?= get_floating_point_number((double) $grand_total_dr) ?></strong></td>
                    <td class="text-align-right" style="text-align: right"></td>
                    <td class="text-align-right" style="text-align: right"><strong><?= get_floating_point_number((double) $grand_total_cr) ?></strong></td>
                </tr>
            </tbody>              
        </table>
    </div>
</div>


<!--For Print-->
<script language="javascript" type="text/javascript">

    $(".account-statement-report-print-button").on("click", function () {
        var divContents = $('#account-statement-report-print-information').html();
        var printWindow = window.open();
        printWindow.document.write(divContents);
        printWindow.document.close();
        printWindow.print();
        printWindow.close();
    });

</script>
