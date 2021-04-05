<div class="card card-boarder">

    <?php
    $company_information;
    $employee_wise_report_view_by_date;
    $start_date;
    $end_date;
    $employee_information;
    $user_info = $this->session->userdata('user_session');
    $user_type = $user_info['user_type'];
    $print_access = $user_info['print_access'];
    $total = 0;
    foreach ($employee_wise_report_view_by_date as $employee_report) {
        $total += $employee_report->product_total;
    }
    /* echo '<pre>';
      echo print_r($employee_name);
      echo '</pre>'; */
    ?>


    <div class="col-xs-12 col-sm-8">
        <div class="col-xs-12">
            <label class="search-from-date">Name: <?= $employee_name ?></label>
        </div>
        <div class="col-xs-12">
            <label class="search-from-date">Designation: <?= $designation ?></label>
        </div>
        <div class="col-xs-12">
            <label class="search-from-date">Period: <?= $start_date ?> To <?= $end_date ?> </label><br>
        </div>
    </div>
    <?php if ((strtolower($user_type) != 'marketing')) { ?>
        <?php if (!empty($print_access) > 0) { ?>
            <div class="col-xs-12 col-sm-4">
                <button type="button" class="btn btn-primary report-print-button"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
            </div>
            <?php
        }
    }
    ?>

    <table class="table table-striped" style="width: 100%" id="details-table">

        <thead class="thead-default">
            <tr>
                <th>SL</th>
                <th>Date</th>
                <th>Party Name</th>
                <th>Invoice No</th>
                <th>Amount</th>
                <th>Area</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            foreach ($employee_wise_report_view_by_date as $employee_report):
                ?>
                <?php $date_of_issue = date("d-m-Y", strtotime($employee_report->date_of_issue)); ?>

                <tr>
                    <td><?= $count++ ?></td>
                    <td><?= $date_of_issue ?></td>
                    <td class="text-left"><?= $employee_report->client_name ?></td>
                    <td><?= $employee_report->invoice_number ?></td>
                    <td><?= number_format((double) $employee_report->amount_to_paid, 2) ?></td>
                    <td><?= $employee_report->client_area ?></td>
                </tr>
            <?php endforeach; ?>

            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td><strong>Grand Total</strong></td>
                <td><strong><?= number_format((double) $total, 2) ?></strong></td>
                <td></td>
            </tr>
        <hr>
        </tbody>
    </table>
</div>


<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="print-information" style="display: none">

    <div class="col-xs-12">
        <h4 class="left-side-view" style="text-align: center"><?= strtoupper($company_information->company_name_1) ?></h4>
        <!--<h6 class="left-side-view"><?/*= $company_information->company_address_1 */?></h6>-->
    </div>

    <div class="card card-boarder" style="margin-top: 10px;">

        <div class="col-xs-12" style="margin-left: 10px;">
            <label class="search-from-date"><strong>Empployeewise Sales Report</strong></label><br>
        </div>
        <div class="col-xs-12" style="margin-left: 10px;">
            <label class="search-from-date">Name: <?= $employee_name ?></label><br>
        </div>
        <div class="col-xs-12" style="margin-left: 10px;">
            <label class="search-from-date">Designation: <?= $designation ?></label><br>
        </div>
        <div class="col-xs-12" style="margin-left: 10px;">
            <label class="search-from-date">Period: <?= $start_date ?> To <?= $end_date ?> </label><br>
        </div>

        <div class="col-xs-12" style="margin-top: 10px; padding-left: 0px;">
            <table class="table" width="100%" border="2px" cellspacing="">

                <thead class="thead-default">
                    <tr style="border: thick">
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">SL</th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">Date</th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">Party Name</th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">Invoice No</th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">Amount</th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">Area</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    foreach ($employee_wise_report_view_by_date as $employee_report):
                        ?>
                        <?php $date_of_issue = date("d-m-Y", strtotime($employee_report->date_of_issue)); ?>

                        <tr style="border: thick">
                            <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $count++ ?></td>
                            <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $date_of_issue ?></td>
                            <td style="border-bottom: 1px solid #ddd; text-align: left"><?= $employee_report->client_name ?></td>
                            <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $employee_report->invoice_number ?></td>
                            <td style="border-bottom: 1px solid #ddd; text-align: right"><?= number_format((double) $employee_report->amount_to_paid, 2) ?></td>
                            <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $employee_report->client_area ?></td>
                        </tr>
                    <?php endforeach; ?>

                    <tr style="border: thick">
                        <td></td>
                        <td></td>
                        <td style="padding-top:20px;padding-bottom: 20px"></td>
                        <td><strong>Grand Total</strong></td>
                        <td><strong><?= number_format((double) $total, 2) ?></strong></td>
                        <td></td>
                    </tr>
                <hr>
                </tbody>
            </table>
        </div>

    </div>

</div>


<!--For Print-->
<script language="javascript" type="text/javascript">

    $(".report-print-button").on("click", function () {

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

    $('#details-table').dataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [[25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]],
        "scrollY": "400px",
        "scrollX": true,
        "ordering": false,
    });

</script>











