<div class="card card-boarder">

    <?php
    $company_information;
    $employee_information;
    $total_loan_report_by_employee_id_and_date;
    ?>

    <div>
        <div class="col-xs-12 col-sm-8">
            <div class="col-xs-12">
                <label class="search-from-date">Name: <?= ucfirst($employee_name) ?></label>
            </div>
            <div class="col-xs-12">
                <label class="search-from-date">Designation: <?= ucfirst($designation) ?></label>
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
                    <th>Employee Name</th>
                    <th>Loan Start Date</th>
                    <th>Total Loan Amount</th>
                    <th>number of Installment</th>
                    <th>Per Installment Amount</th>
                    <th>Total Paid Amount</th>
                    <th>Due Amount</th>
                    <th>User</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 1;
                $total_loan = 0;
                $total_per_installment = 0;
                $total_installment = 0;
                $total_due_amount = 0;
                foreach ($total_loan_report_by_employee_id_and_date as $total_loan_report):
                    ?>
                    <?php $loan_start_date = date("d-m-Y", strtotime($total_loan_report->loan_start_date)); ?>
                    <?php $total_loan += $total_loan_report->total_loan_amount ?>
                    <?php $total_per_installment += $total_loan_report->per_installment_amount ?>
                    <?php $total_installment += $total_loan_report->total_installment_amount ?>
                    <?php $due_amount = 0; 
                    $due_amount = ($total_loan_report->total_loan_amount) - ($total_loan_report->total_installment_amount) ?>
                    <?php $total_due_amount += $due_amount ?>
                    <tr>
                        <td><?= $count++ ?></td>
                        <td><?= ucfirst($total_loan_report->employee_name) ?></td>
                        <td><?= $loan_start_date ?></td>
                        <td><?= number_format((double) $total_loan_report->total_loan_amount, 2) ?></td>
                        <td><?= $total_loan_report->number_of_installment ?></td>
                        <td><?= number_format((double) $total_loan_report->per_installment_amount, 2) ?></td>
                        <td><?= number_format((double) $total_loan_report->total_installment_amount, 2) ?></td>
                        <td><?= number_format((double) $due_amount, 2) ?></td>
                        <td><?= ucfirst($total_loan_report->user_name) ?></td>
                    </tr>
<?php endforeach; ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td><strong>Grand Total</strong></td>
                    <td><strong><?= number_format((double) $total_loan, 2) ?></strong></td>
                    <td></td>
                    <td><strong><?= number_format((double) $total_per_installment, 2) ?></strong></td>
                    <td><strong><?= number_format((double) $total_installment, 2) ?></strong></td>
                    <td><strong><?= number_format((double) $total_due_amount, 2) ?></strong></td>
                    <td></td>
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
            <label class="search-from-date"><strong>Employee Total Loan Report</strong></label><br>
        </div>
        <div class="col-xs-12" style="margin-left: 10px;">
            <label class="search-from-date">Name: <?= ucfirst($employee_name) ?></label><br>
        </div>
        <div class="col-xs-12" style="margin-left: 10px;">
            <label class="search-from-date">Designation: <?= ucfirst($designation) ?></label><br>
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
                            Employee Name
                        </th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                            Loan Start Date
                        </th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                            Total Loan Amount
                        </th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                            Number of Installment
                        </th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                            Per Installment Amount
                        </th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                            Total Paid Amount
                        </th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                            Due Amount
                        </th>
                        <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                            User
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    $total_loan = 0;
                    $total_per_installment = 0;
                    $total_installment = 0;
                    $total_due_amount = 0;
                    foreach ($total_loan_report_by_employee_id_and_date as $total_loan_report):
                        ?>
    <?php $loan_start_date = date("d-m-Y", strtotime($total_loan_report->loan_start_date)); ?>
                    <?php $due_amount = 0; 
                    $due_amount = ($total_loan_report->total_loan_amount) - ($total_loan_report->total_installment_amount) ?>
                    <?php $total_due_amount += $due_amount ?>

                        <tr style="border: thick">
                            <td style="text-align: center"><?= $count++ ?></td>
                            <td style="text-align: center"><?= ucfirst($total_loan_report->employee_name) ?></td>
                            <td style="text-align: center"><?= $loan_start_date ?></td>
                            <td style="text-align: center"><?= number_format((double) $total_loan_report->total_loan_amount, 2) ?></td>
                            <td style="text-align: center"><?= $total_loan_report->number_of_installment ?></td>
                            <td style="text-align: center"><?= number_format((double) $total_loan_report->per_installment_amount, 2) ?></td>
                            <td style="text-align: center"><?= number_format((double) $total_loan_report->total_installment_amount, 2) ?></td>
                            <td style="text-align: center"><?= number_format((double) $due_amount, 2) ?></td>
                            <td style="text-align: center"><?= ucfirst($total_loan_report->user_name) ?></td>
                        </tr>
<?php endforeach; ?>
                    <tr style="border: thick">
                        <td></td>
                        <td></td>
                        <td><strong>Grand Total</strong></td>
                        <td><strong><?= number_format((double) $total_loan, 2) ?></strong></td>
                        <td></td>
                        <td><strong><?= number_format((double) $total_per_installment, 2) ?></strong></td>
                        <td><strong><?= number_format((double) $total_installment, 2) ?></strong></td>
                        <td><strong><?= number_format((double) $total_due_amount, 2) ?></strong></td>
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











