<div id="page-wrapper">
    <?php
    $company_information;
    $currency_settings;
    $clients_details_array;
    $user_info = $this->session->userdata('user_session');
    $user_type = $user_info['user_type'];
    $print_access = $user_info['print_access'];
    /* echo '<pre>';
      echo print_r($invoice_details_view);
      echo '</pre>'; */
    ?>

    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Client(s) Ledger Report</h4>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive table-bordered">
                        <?php if ((strtolower($user_type) != 'marketing')) { ?>
                            <?php if (!empty($print_access) > 0) { ?>
                                <div class="col-xs-12">
                                    <button type="button" class="right-side-view btn btn-primary report-print-button legender-print-button"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
                                </div>
                            <?php }
                        }
                        ?>
                        <table class="table table-striped" id="details-table">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Client</th>
                                    <th>Code</th>
                                    <th><?= 'LP ' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                                    <th><?= 'IM ' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                                    <th><?= 'Total ' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 1;
                                $im_total = 0;
                                $lp_total = 0;
                                $im_lp_total = 0;
                                if (!empty($clients_details_array)) {
                                    usort($clients_details_array, function ($one, $two) {
                                        if ($one['client_name'] === $two['client_name']) {
                                            return 0;
                                        }
                                        return $one['client_name'] < $two['client_name'] ? -1 : 1;
                                    });

                                    foreach ($clients_details_array as $clients_details):
                                        ?>
                                        <?php
                                        $client_name = '';
                                        $c_name = strrev($clients_details['client_name']);
                                        if (strpos($c_name, '(') !== FALSE) {
                                            $client_name = strrev(substr($c_name, strpos($c_name, "(") + 1));
                                        } else {
                                            $client_name = strrev(substr($c_name, strpos($c_name, "(") + 0));
                                        }
                                        ?>
                                        <?php
                                        $im_total += (double)$clients_details['im_credit_balance'];
                                        $lp_total += (double)$clients_details['lp_credit_balance'];
                                        $im_lp_total += (double)$clients_details['total_credit_balance'];
                                        ?>
                                        <tr>
                                            <td><?= $count++ ?></td>
                                            <td><?= !empty($client_name) ? $client_name : '' ?></td>
                                            <td><?= $clients_details['client_code'] ?></td>
                                            <td><?= number_format((double) $clients_details['lp_credit_balance'], 2) ?></td>
                                            <td><?= number_format((double) $clients_details['im_credit_balance'], 2) ?></td>
                                            <td><?= number_format((double) $clients_details['total_credit_balance'], 2) ?></td>
                                        </tr>
                                        <?php
                                    endforeach;
                                }
                                ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td><strong>Total</strong></td>
                                    <td><strong><?= number_format((double) $lp_total, 2) ?></strong></td>
                                    <td><strong><?= number_format((double) $im_total, 2) ?></strong></td>
                                    <td><strong><?= number_format((double) $im_lp_total, 2) ?></strong></td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
    </div>

    <div class="modal fade invoice-details-information-modal">
        <div class="modal-dialog modal-lg invoice-show " role="document">
        </div>
    </div>

</div>
<!-- /#page-wrapper -->

<!--DISPLAY NONE-->
<!--FOR PRINT-->

<div id="legender-report-print-section" class="" style="width: 100%; display: none">

    <div class="col-xs-12">
        <h4 style="text-align: center"
            class="left-side-view"><?= strtoupper($company_information->company_name_1) ?></h4>
<!--        <h6 style="text-align: center" class="left-side-view"><?= $company_information->company_address_1 ?></h6>-->
    </div>

    <div><strong>Client(s) Ledger Report</strong></div>
    <hr>

    <table border="2px" cellspacing="0" class="table table-striped" id="details-table">
        <thead>
            <tr style="border: thick">
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">SL</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Client</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px"><?= 'LP ' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px"><?= 'IM ' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px"><?= 'Total ' . '(' . $currency_settings->currency_symbol . ')' ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            $im_total = 0;
            $lp_total = 0;
            $im_lp_total = 0;
            if (!empty($clients_details_array)) {
                usort($clients_details_array, function ($one, $two) {
                    if ($one['client_name'] === $two['client_name']) {
                        return 0;
                    }
                    return $one['client_name'] < $two['client_name'] ? -1 : 1;
                });

                foreach ($clients_details_array as $clients_details):
                    ?>
                    <?php
                    $client_name = '';
                    $c_name = strrev($clients_details['client_name']);
                    if (strpos($c_name, '(') !== FALSE) {
                        $client_name = strrev(substr($c_name, strpos($c_name, "(") + 1));
                    } else {
                        $client_name = strrev(substr($c_name, strpos($c_name, "(") + 0));
                    }
                    ?>
                    <?php
                    $im_total += $clients_details['im_credit_balance'];
                    $lp_total += $clients_details['lp_credit_balance'];
                    $im_lp_total += $clients_details['total_credit_balance'];
                    ?>
                    <tr style="border: thick">
                        <td><?= $count++ ?></td>
                        <td><?= !empty($client_name) ? $client_name : '' ?></td>
                        <td><?= number_format((double) $clients_details['lp_credit_balance'], 2) ?></td>
                        <td><?= number_format((double) $clients_details['im_credit_balance'], 2) ?></td>
                        <td><?= number_format((double) $clients_details['total_credit_balance'], 2) ?></td>
                    </tr>
                    <?php
                endforeach;
            }
            ?>
            <tr style="border: thick">
                <td></td>
                <td><strong>Total</strong></td>
                <td><strong><?= number_format((double) $lp_total, 2) ?></strong></td>
                <td><strong><?= number_format((double) $im_total, 2) ?></strong></td>
                <td><strong><?= number_format((double) $im_lp_total, 2) ?></strong></td>
            </tr>
        </tbody>
    </table>

</div>


<script type="text/javascript">
    $(document).ready(function () {

        $(".legender-print-button").on("click", function () {

            var divContents = $('#legender-report-print-section').html();

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

        $('#details-table').dataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [[25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]],
            "scrollY": "400px",
            "scrollX": true,
            "ordering": false,
        });

        $('.invoice-view-button').on('click', function (event) {
            event.preventDefault();
            $.post($(this).attr('data-action'), {'id': $(this).attr('data-id')}, function (data) {
                $('.invoice-details-information-modal .invoice-show').html(data);
                $('.invoice-details-information-modal').modal('show');
            });
        });
    });
</script>
