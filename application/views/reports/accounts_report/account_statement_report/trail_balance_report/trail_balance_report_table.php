<div class="card card-boarder">
    <?php
    $user_info = $this->session->userdata('user_session');
    $user_type = $user_info['user_type'];
    $print_access = $user_info['print_access'];
    $table_title = ($is_custom == 0) ? 'As at ' . display_date_format_for_account_statment($end_date) : 'From ' . display_date_format_for_account_statment($start_date) . ' To ' . display_date_format_for_account_statment($end_date);
    ?>

    <div class="col-xs-12 col-sm-8">
        <div class="col-xs-12">
            <!--<label class="search-from-date">As at 31st December-<?= $year ?></label><br>-->
            <label class="search-from-date"><?= $table_title; ?></label><br>
        </div>
    </div>
    <?php if ((strtolower($user_type) != 'marketing')) { ?>
        <?php if (!empty($print_access) > 0) { ?>
            <div class="col-xs-12 col-sm-4">
                <button type="button" class="btn btn-primary trail-balance-report-print-button report-print-button"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
            </div>
            <?php
        }
    }
    ?>

    <div class="clearfix"></div>
    <div class="form-group table-responsive" style="margin-top: 5%">
        <table class="table table-bordered table-striped" style="width: 100%" id="details-table">
            <thead>
                <tr>
                    <th>Particular(DR.)</th>
                    <th class="text-align-right">Amount</th>
                    <th>Particular(CR.)</th>
                    <th class="text-align-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                $total_dr = 0;
                $total_cr = 0;
                if (!empty($dr) || !empty($cr)) {
                    $maximum_length = max(count($dr), count($cr));
                    ?>
                    <?php
                    while ((int) $i < (int) $maximum_length) {
                        $total_dr += !empty($dr[$i]) ? (double) (abs($dr[$i]['balance'])) : 0;
                        $total_cr += !empty($cr[$i]) ? (double) (abs($cr[$i]['balance'])) : 0;
                        ?>
                        <tr style="line-height: 30px;border-bottom: 0;">
                            <td><?= !empty($cr[$i]) ? ucfirst($cr[$i]['head_name']) : '' ?></td>
                            <td class="text-align-right"><?= !empty($cr[$i]) ? get_floating_point_number(abs($cr[$i]['balance'])) : '' ?></td>
                            <td><?= !empty($dr[$i]) ? ucfirst($dr[$i]['head_name']) : '' ?></td>
                            <td class="text-align-right"><?= !empty($dr[$i]) ? get_floating_point_number(abs($dr[$i]['balance'])) : '' ?></td>
                        </tr>
                        <?php
                        $i++;
                    }
                    ?>
                <?php } ?>
                <tr>
                    <td></td>
                    <td class="text-align-right"><strong><?= !empty($total_cr) ? get_floating_point_number($total_cr) : 0 ?></strong></td>
                    <td></td>
                    <td class="text-align-right"><strong><?= !empty($total_dr) ? get_floating_point_number($total_dr) : 0 ?></strong></td>
                </tr>
            </tbody>              
        </table>
    </div>
</div>

<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="trail-balance-report-print-information" style="display: none">
    <div class="col-xs-12" style="text-align: center; font-size: 22px; font-weight: bolder">
        <label class=""><?= strtoupper($company_information->company_name_1) ?></label>
    </div>
    <div class="col-xs-12" style="text-align: center">
        <label class=""><?= $company_information->company_address_1 ?></label><br>
    </div>
    <div class="col-xs-12" style="text-align: center; font-size: 16px; font-weight: bolder">
        <label class=""><?= strtoupper('Trail Balance') ?></label>
    </div>
    <div class="col-xs-12" style="text-align: center">
        <!--<label class=""><?= 'As at 31st December-' . $year ?></label><br>-->
        <label class=""><?= $table_title; ?></label><br>
    </div>

    <div class="col-xs-12">
        <table class="table table-bordered table-striped" border="2px solid black" cellspacing="0" style="width: 100%" id="details-table">
            <thead>
                <tr style="border: thick">
                    <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Particular(DR.)</th>
                    <th class="text-align-right" style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px; text-align: right">Amount</th>
                    <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Particular(CR.)</th>
                    <th class="text-align-right" style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px; text-align: right">Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                $total_dr = 0;
                $total_cr = 0;
                if (!empty($dr) || !empty($cr)) {
                    $maximum_length = max(count($dr), count($cr));
                    ?>
                    <?php
                    while ((int) $i < (int) $maximum_length) {
                        $total_dr += !empty($dr[$i]) ? (double) (abs($dr[$i]['balance'])) : 0;
                        $total_cr += !empty($cr[$i]) ? (double) (abs($cr[$i]['balance'])) : 0;
                        ?>
                        <tr style="line-height: 30px; border: thick">
                            <td><?= !empty($cr[$i]) ? ucfirst($cr[$i]['head_name']) : '' ?></td>
                            <td class="text-align-right" style="text-align: right"><?= !empty($cr[$i]) ? get_floating_point_number(abs($cr[$i]['balance'])) : '' ?></td>
                            <td><?= !empty($dr[$i]) ? ucfirst($dr[$i]['head_name']) : '' ?></td>
                            <td class="text-align-right" style="text-align: right"><?= !empty($dr[$i]) ? get_floating_point_number(abs($dr[$i]['balance'])) : '' ?></td>
                        </tr>
                        <?php
                        $i++;
                    }
                    ?>
                <?php } ?>
                <tr style="line-height: 30px; border: thick">
                    <td></td>
                    <td class="text-align-right" style="text-align: right"><strong><?= !empty($total_cr) ? get_floating_point_number($total_cr) : 0 ?></strong></td>
                    <td></td>
                    <td class="text-align-right" style="text-align: right"><strong><?= !empty($total_dr) ? get_floating_point_number($total_dr) : 0 ?></strong></td>
                </tr>
            </tbody>                     
        </table>
    </div>
</div>


<!--For Print-->
<script language="javascript" type="text/javascript">

    $(".trail-balance-report-print-button").on("click", function () {

        var divContents = $('#trail-balance-report-print-information').html();
        var printWindow = window.open();
        printWindow.document.write(divContents);
        printWindow.document.close();
        printWindow.print();
        printWindow.close();
    });

</script>
