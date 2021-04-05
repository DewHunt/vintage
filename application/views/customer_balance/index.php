<div id="page-wrapper">
    <style type="text/css">
        .custom-panel-body {
            padding: 15px 15px 0px 15px;
        }
    </style>
    <?php
        $from_date = date('Y-m-d');
        $user_info = $this->session->userdata('user_session');
        // echo "<pre>"; print_r($user_info); exit();
        $user_type = $user_info['user_type'];
        $print_access = $user_info['print_access'];
    ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12"><h4 class="">Customer Balance</h4></div>
                <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12 text-right">
                    <button type="button" class="btn btn-primary print-button"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
                </div>
            </div>
        </div>

        <div class="panel-body custom-panel-body">
            <div class="table-responsive">
                <table class="table table-striped" id="details-table">
                    <thead>
                        <tr>
                            <th width="10px">SL</th>
                            <th>Name</th>
                            <th width="80px">Code</th>
                            <th width="100px">Phone</th>
                            <th width="100px">Balance</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $sl = 1; ?>
                        <?php foreach ($clientInfo as $client): ?>
                            <tr>
                                <td><?= $sl++ ?></td>
                                <td><?= $client->client_name ?></td>
                                <td><?= $client->client_code ?></td>
                                <td><?= $client->phone_number ?></td>
                                <?php
                                    if ($client->credit_balance == 0 && $client->advance_balance == 0) {
                                        $balance = 0;
                                    } elseif ($client->credit_balance > 0) {
                                        $balance = $client->credit_balance;
                                    }
                                    else {
                                        $balance = '(adv) '.$client->advance_balance;
                                    }
                                ?>
                                <td align="right"><?= $balance ?></td>
                            </tr>                            
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!--DISPLAY NONE USE FOR PRINT-->

    <div id="print-all-information" style="display: none">
        <style>
            table, td, th { border: 1px solid #ddd; }
            table { border-collapse: collapse; width: 100%; }
            th, td { padding: 5px; }
            label { font-weight: bold; }
            p { margin: 0px; }
            .print-content { margin: 30px; }
            * { box-sizing: border-box; }
            .column { float: left; padding: 10px; }
            .left { width: 60%; }
            .right { width: 40%; }
            .full { width: 100% }
            /* Clear floats after the columns */
            .row:after { content: ""; display: table; clear: both; }
            .text-center { text-align: center }
            .text-right { text-align: right }
        </style>

        <div class="print-content">
            <div class="row">
                <div class="column full text-center">
                    <font size="5px"><?= strtoupper($companyInfo->company_name_1) ?></font>
                    <p><?= $companyInfo->company_address_1 ?></p>
                </div>
            </div>

            <div class="row">
                <div class="column full" align="center">
                    Customer Balance <br>
                    <!-- <label class="search-from-date">Date : </label> <?= date() ?> -->
                </div>
            </div>

            <div class="row">
                <div class="column full">
                    <table>
                        <thead>
                            <tr>
                                <th width="10px">SL</th>
                                <th width="250px">Name</th>
                                <th width="100px">Code</th>
                                <th width="100px">Phone</th>
                                <th width="100px">Balance</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $sl = 1; ?>
                            <?php foreach ($clientInfo as $client): ?>
                                <tr>
                                    <td><?= $sl++ ?></td>
                                    <td><?= $client->client_name ?></td>
                                    <td><?= $client->client_code ?></td>
                                    <td><?= $client->phone_number ?></td>
                                    <?php
                                        if ($client->credit_balance == 0 && $client->advance_balance == 0) {
                                            $balance = 0;
                                        } elseif ($client->credit_balance > 0) {
                                            $balance = $client->credit_balance;
                                        }
                                        else {
                                            $balance = '(adv) '.$client->advance_balance;
                                        }
                                    ?>
                                    <td align="right"><?= $balance ?></td>
                                </tr>                            
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /#page-wrapper -->

<script type="text/javascript">
    $(document).ready(function () {
        $(".print-button").on("click", function () {
            var divContents = $('#print-all-information').html();

            if (divContents) {
                var printWindow = window.open();
                printWindow.document.write(divContents);
                printWindow.document.close();
                printWindow.print();
                printWindow.close();
            }
            else {
                swal("Error!", "Please Search Invoice Details Report!", "error");
            }
        });

        $('#details-table').dataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [[25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]],
            "scrollY": "400px",
            "scrollX": true,
            "ordering": false,
        });
    });
</script>
