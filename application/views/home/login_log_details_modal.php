<div class="modal-content">
    <?php
    $company_information;
    ?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Login Log Details</h4>
    </div>

    <div class="modal-body">

        <div class="form-group col-xs-12 table-responsive">

            <table class="table table-striped" id="details-table">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Time</th>
                        <th>Login Information</th>
                        <th>IP Address</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    foreach ($login_log_details_with_limit as $login_log_details):
                        ?>
                        <?php $login_time = date('jS M Y h:i A', strtotime(($login_log_details->login_time))); ?>
                        <tr>
                            <td><?= $count++; ?></td>
                            <?php if (($login_log_details->user_id) > 0) { ?>
                                <td class="success-notification-text"><?= $login_time ?></td>
                                <td class="success-notification-text">Success Login
                                    Attempt[<?= $login_log_details->user_name_or_email ?>]
                                </td>
                            <?php } else { ?>
                                <td class="error-notification-text"><?= $login_time ?></td>
                                <td class="error-notification-text">Failed Login
                                    Attempt[<?= $login_log_details->user_name_or_email ?>]
                                </td>
                            <?php } ?>
                            <td><?= !empty($login_log_details->ip_address) ? $login_log_details->ip_address : '' ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>

    </div>

    <div class="clearfix"></div>

    <div class="modal-footer">
        <button type="button" class="btn btn-primary modal-print-button"><i class="fa fa-print" aria-hidden="true"></i>
            Print
        </button>
        <button type="button" class="btn btn-danger modal-close-button" data-dismiss="modal">Close</button>
    </div>

</div>

<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="print-information" style="display: none">

    <div class="col-xs-12">
        <p style="text-align: center; font-weight: bold; font-size: 16px"><?= strtoupper($company_information->company_name_1) ?></p>
        <p style="text-align: center; font-weight: bold; font-size: 12px"><?= $company_information->company_address_1 ?></p>
    </div>

    <table border="2px" cellspacing="0" class="table table-striped" id="details-table" width="100%">
        <thead>
            <tr>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">SL</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">Time</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">Login Information</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">IP Address</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            foreach ($login_log_details_with_limit as $login_log_details):
                ?>
                <?php $login_time = date('jS M Y h:i A', strtotime(($login_log_details->login_time))); ?>
                <tr style="border: thick">
                    <td><?= $count++; ?></td>
                    <?php if (($login_log_details->user_id) > 0) { ?>
                        <td><?= $login_time ?></td>
                        <td>Success Login
                            Attempt[<?= $login_log_details->user_name_or_email ?>]
                        </td>
                    <?php } else { ?>
                        <td><?= $login_time ?></td>
                        <td>Failed Login
                            Attempt[<?= $login_log_details->user_name_or_email ?>]
                        </td>
                    <?php } ?>
                    <td><?= !empty($login_log_details->ip_address) ? $login_log_details->ip_address : '' ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<!--For Print-->
<script language="javascript" type="text/javascript">

    $(".modal-print-button").on("click", function () {

        var divContents = $('#print-information').html();

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
    $('.modal-close-button').click(function () {
        $('.modal').modal('hide');
    });
</script>



