<div class="card card-boarder">
    <?php
    $user_info = $this->session->userdata('user_session');
    $user_type = $user_info['user_type'];
    $print_access = $user_info['print_access'];

//    echo '<pre>';
//    print_r($trading_account_statement);
//    echo '</pre>';
    ?>

    <div class="col-xs-12 col-sm-8">
        <div class="col-xs-12">
            <label class="search-from-date">For the year ended 31th Dec-<?= $year ?></label><br>
        </div>
    </div>
    <?php if ((strtolower($user_type) != 'marketing')) { ?>
        <?php if (!empty($print_access) > 0) { ?>
            <div class="col-xs-12 col-sm-4">
                <button type="button" class="btn btn-primary trading-account-report-print-button report-print-button"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
            </div>
            <?php
        }
    }
    ?>

    <div class="clearfix"></div>
    <div class="form-group table-responsive card-margin-top">
        <table class="table table-bordered table-striped" style="width: 100%" id="details-table">
            <thead>
                <tr>
                    <th>Particular</th>
                    <th class="text-align-right">Amount</th>
                    <th>Particular</th>
                    <th class="text-align-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                $dr = $trading_account_statement[0]['dr'];
                $cr = $trading_account_statement[0]['cr'];
                $total_dr = $trading_account_statement[0]['total_dr'];
                $total_cr = $trading_account_statement[0]['total_cr'];
                $difference = $trading_account_statement[0]['difference'];
                $profit = $trading_account_statement['profit'];
                $loss = $trading_account_statement['loss'];
                $grand_total_dr = $trading_account_statement['grand_total_dr'];
                $grand_total_cr = $trading_account_statement['grand_total_cr'];
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
                    <td></td>
                    <td class="text-align-right"><?= !empty($total_dr) ? get_floating_point_number($total_dr) : 0 ?></td>
                    <td></td>
                    <td class="text-align-right"><?= !empty($total_cr) ? get_floating_point_number($total_cr) : 0 ?></td>
                </tr>   
                <?php if ((double) $loss != (double) 0) { ?>
                    <tr>
                        <td class="text-align-right"><? ?></td>
                        <td class="text-align-right"><? ?></td>
                        <td>Gross Loss (Transfer to profit & loss account)</td>
                        <td class="text-align-right"><?= get_floating_point_number(abs($loss)) ?></td>
                    </tr>
                <?php } ?>
                <?php if ((double) $profit != (double) 0) { ?>
                    <tr> 
                        <td>Gross Profit (Transfer to profit & loss account)</td>
                        <td class="text-align-right"><?= get_floating_point_number(abs($profit)) ?></td>
                        <td class="text-align-right"><? ?></td>
                        <td class="text-align-right"><? ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td class="text-align-right"></td>
                    <td class="text-align-right"><strong><?= get_floating_point_number($grand_total_dr) ?></strong></td>
                    <td class="text-align-right"></td>
                    <td class="text-align-right"><strong><?= get_floating_point_number($grand_total_cr) ?></strong></td>
                </tr>

            </tbody>              
        </table>
    </div>
</div>

<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="trading-account-report-print-information" style="display: none">
    <div class="col-xs-12" style="text-align: center; font-size: 22px; font-weight: bolder">
        <label class=""><?= strtoupper($company_information->company_name_1) ?></label>
    </div>
    <div class="col-xs-12" style="text-align: center">
        <label class=""><?= $company_information->company_address_1 ?></label><br>
    </div>
    <div class="col-xs-12" style="text-align: center; font-size: 16px; font-weight: bolder">
        <label class=""><?= strtoupper('Trading Account') ?></label>
    </div>
    <div class="col-xs-12" style="text-align: center">
        <label class=""><?= 'For the year ended 31th Dec-' . $year ?></label><br>
    </div>

    <div class="col-xs-12">
        <table class="table table-bordered table-striped" border="2px solid black" cellspacing="0" style="width: 100%" id="details-table">
            <thead>
                <tr style="border: thick">
                    <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Particular</th>
                    <th class="text-align-right" style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px; text-align: right">Amount</th>
                    <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Particular</th>
                    <th class="text-align-right" style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px; text-align: right">Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                $dr = $trading_account_statement[0]['dr'];
                $cr = $trading_account_statement[0]['cr'];
                $total_dr = $trading_account_statement[0]['total_dr'];
                $total_cr = $trading_account_statement[0]['total_cr'];
                $difference = $trading_account_statement[0]['difference'];
                $profit = $trading_account_statement['profit'];
                $loss = $trading_account_statement['loss'];
                $grand_total_dr = $trading_account_statement['grand_total_dr'];
                $grand_total_cr = $trading_account_statement['grand_total_cr'];
                if (!empty($dr) || !empty($cr)) {
                    $maximum_length = max(count($dr), count($cr));
                    ?>
                    <?php
                    while ((int) $i < (int) $maximum_length) {
                        ?>
                        <tr>
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
                        <td>Gross Loss (Transfer to profit & loss account)</td>
                        <td class="text-align-right" style="text-align: right"><?= get_floating_point_number(abs($loss)) ?></td>
                    </tr>
                <?php } ?>
                <?php if ((double) $profit != (double) 0) { ?>
                    <tr style="line-height: 30px; border: thick">
                        <td>Gross Profit (Transfer to profit & loss account)</td>
                        <td class="text-align-right" style="text-align: right"><?= get_floating_point_number(abs($profit)) ?></td>
                        <td class="text-align-right" style="text-align: right"><? ?></td>
                        <td class="text-align-right" style="text-align: right"><? ?></td>
                    </tr>
                <?php }
                ?>        
                <tr style="line-height: 30px; border: thick">
                    <td class="text-align-right" style="text-align: right"></td>
                    <td class="text-align-right" style="text-align: right"><strong><?= get_floating_point_number($grand_total_dr) ?></strong></td>
                    <td class="text-align-right" style="text-align: right"></td>
                    <td class="text-align-right" style="text-align: right"><strong><?= get_floating_point_number($grand_total_cr) ?></strong></td>
                </tr>
            </tbody>              
        </table>
    </div>
</div>


<!--For Print-->
<script language="javascript" type="text/javascript">

    $(".trading-account-report-print-button").on("click", function () {

        var divContents = $('#trading-account-report-print-information').html();
        var printWindow = window.open();
        printWindow.document.write(divContents);
        printWindow.document.close();
        printWindow.print();
        printWindow.close();
    });
    function printDiv(divID) {
        //Get the HTML of div
        var divElements = document.getElementById(divID).innerHTML;
        //Get the HTML of whole page
        var oldPage = document.body.innerHTML;
        //Reset the page's HTML with div's HTML only
        document.body.innerHTML =
                "<html><head><title></title></head><body>" +
                divElements + "</body>";
        //Print Page
        window.print();
        //Restore orignal HTML
        document.body.innerHTML = oldPage;
    }

//    $('#details-table').dataTable({
//        "pagingType": "full_numbers",
//        "lengthMenu": [[25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]],
//        "scrollY": "400px",
//        "scrollX": true,
//        "ordering": false,
//    });

</script>
