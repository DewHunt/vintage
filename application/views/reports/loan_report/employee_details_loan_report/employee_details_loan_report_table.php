<div class="card card-boarder">

    <?php
    $company_information;
    $employee_information;
    $employee_loan_details_report_by_employee_id_and_date;
    ?>

    <div>
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
    </div>

    <div class="col-xs-12 col-sm-4">
        <button type="button" class="btn btn-primary report-print-button"><i class="fa fa-print" aria-hidden="true"></i>
            Print
        </button>
    </div>

    <div style="width: 100%;">
        <table class="table table-striped" style="width: 100%" id="details-table">

            <thead class="thead-default">
                <tr>
                    <th>SL</th>
                    <th>Name</th>
                    <th>Month</th>
                    <th>Year</th>
                    <th>Per Installment</th>
                    <th>Total Loan</th>
                    <!--<th>Prev. Loan Pay</th>-->
                    <th>Total Loan Pay</th>
                    <th>Due Loan</th>
                    <th>Payment Date</th>
                    <th>user</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 1;
                $total_per_installment = 0;
                $total_loan = 0;
                $total_previous_loan_payment = 0;
                $total_loan_payment = 0;
                $total_due_loan_amount = 0;
                foreach ($employee_loan_details_report_by_employee_id_and_date as $employee_loan_details_report):
                    ?>
                    <?php $loan_payment_date = date("d-m-Y", strtotime($employee_loan_details_report->loan_payment_date)); ?>
                    <?php $total_per_installment += (double) $employee_loan_details_report->per_installment ?>
                    <?php $total_loan += (double) $employee_loan_details_report->total_loan_amount ?>
                    <?php $total_previous_loan_payment += (double) $employee_loan_details_report->previous_loan_payment ?>
                    <?php $total_loan_payment += (double) $employee_loan_details_report->total_loan_payment ?>
                    <?php $total_due_loan_amount += (double) $employee_loan_details_report->due_loan_amount ?>
                    <tr>
                        <td><?= $count++ ?></td>
                        <td><?= ucfirst($employee_loan_details_report->employee_name) ?></td>
                        <td><?= ucfirst($employee_loan_details_report->month) ?></td>
                        <td><?= $employee_loan_details_report->year ?></td>
                        <td><?= number_format((double) $employee_loan_details_report->per_installment, 2) ?></td>
                        <td><?= number_format((double) $employee_loan_details_report->total_loan_amount, 2) ?></td>
                        <!--<td><?= number_format((double) $employee_loan_details_report->previous_loan_payment, 2) ?></td>-->
                        <td><?= number_format((double) $employee_loan_details_report->total_loan_payment, 2) ?></td>
                        <td><?= number_format((double) $employee_loan_details_report->due_loan_amount, 2) ?></td>
                        <td><?= $loan_payment_date ?></td>
                        <td><?= ucfirst($employee_loan_details_report->user_name) ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td><strong></strong></td>
                    <td><strong></strong></td>
                    <td><strong></strong></td>
                    <td><strong>Grand Total</strong></td>
                    <td><strong><?= number_format((double) $total_per_installment, 2) ?></strong></td>
                    <td><strong><?= number_format((double) $total_loan, 2) ?></strong></td>
                    <!--<td><strong><?= number_format((double) $total_previous_loan_payment, 2) ?></strong></td>-->
                    <td><strong><?= number_format((double) $total_loan_payment, 2) ?></strong></td>
                    <td><strong><?= number_format((double) $total_due_loan_amount, 2) ?></strong></td>
                    <td><strong></strong></td>
                    <td><strong></strong></td>
                </tr>
            </tbody>
        </table>
    </div>

</div>


<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="print-information" style="display: none">

    <div class="col-xs-12">
        <h4 class="" style="text-align: center"><?= strtoupper($company_information->company_name_1) ?></h4>
        <h6 class="" style="text-align: center"><?= $company_information->company_address_1 ?></h6>
    </div>

    <div class="card card-boarder" style="margin-top: 10px;">

        <div class="col-xs-12" style="margin-left: 10px;">
            <label class="search-from-date"><strong>Employee Loan Details Report</strong></label><br>
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
            <table border="2px" cellspacing="0" class="table table-striped" style="width: 100%; margin-top: 10px;"
                   id="order-list-table">

                <thead class="thead-default">
                    <tr>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                            SL
                        </th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                            Name
                        </th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                            Month
                        </th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                            Year
                        </th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                            Per Installment
                        </th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                            Total Loan
                        </th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                            Prev. Loan Pay
                        </th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                            Total Loan Pay
                        </th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                            Due Loan
                        </th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                            Payment Date
                        </th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                            User
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    $total_per_installment = 0;
                    $total_loan = 0;
                    $total_previous_loan_payment = 0;
                    $total_loan_payment = 0;
                    $total_due_loan_amount = 0;
                    foreach ($employee_loan_details_report_by_employee_id_and_date as $employee_loan_details_report):
                        ?>
                        <?php $loan_payment_date = date("d-m-Y", strtotime($employee_loan_details_report->loan_payment_date)); ?>
                        <?php $total_per_installment += (double) $employee_loan_details_report->per_installment ?>
                        <?php $total_loan += (double) $employee_loan_details_report->total_loan_amount ?>
                        <?php $total_previous_loan_payment += (double) $employee_loan_details_report->previous_loan_payment ?>
                        <?php $total_loan_payment += (double) $employee_loan_details_report->total_loan_payment ?>
                        <?php $total_due_loan_amount += (double) $employee_loan_details_report->due_loan_amount ?>
                        <tr style="border: thick">
                            <td style="text-align: center"><?= $count++ ?></td>
                            <td style="text-align: center"><?= ucfirst($employee_loan_details_report->employee_name) ?></td>
                            <td style="text-align: center"><?= ucfirst($employee_loan_details_report->month) ?></td>
                            <td style="text-align: center"><?= $employee_loan_details_report->year ?></td>
                            <td style="text-align: center"><?= number_format((double) $employee_loan_details_report->per_installment, 2) ?></td>
                            <td style="text-align: center"><?= number_format((double) $employee_loan_details_report->total_loan_amount, 2) ?></td>
                            <td style="text-align: center"><?= number_format((double) $employee_loan_details_report->previous_loan_payment, 2) ?></td>
                            <td style="text-align: center"><?= number_format((double) $employee_loan_details_report->total_loan_payment, 2) ?></td>
                            <td style="text-align: center"><?= number_format((double) $employee_loan_details_report->due_loan_amount, 2) ?></td>
                            <td style="text-align: center"><?= $loan_payment_date ?></td>
                            <td style="text-align: center"><?= ucfirst($employee_loan_details_report->user_name) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr style="border: thick">
                        <td><strong></strong></td>
                        <td><strong></strong></td>
                        <td><strong></strong></td>
                        <td><strong>Grand Total</strong></td>
                        <td><strong><?= number_format((double) $total_per_installment, 2) ?></strong></td>
                        <td><strong><?= number_format((double) $total_loan, 2) ?></strong></td>
                        <td><strong><?= number_format((double) $total_previous_loan_payment, 2) ?></strong></td>
                        <td><strong><?= number_format((double) $total_loan_payment, 2) ?></strong></td>
                        <td><strong><?= number_format((double) $total_due_loan_amount, 2) ?></strong></td>
                        <td><strong></strong></td>
                        <td><strong></strong></td>
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











