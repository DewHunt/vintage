<div class="card card-boarder">

    <?php
    $company_information;
    $employee_information;
    $pf_funds_report_by_employee_id;
    ?>

    <div>
        <div class="col-xs-12 col-sm-8">
            <div class="col-xs-12">
                <label class="search-from-date">Name: <?= ucfirst($employee_name) ?></label>
            </div>
            <div class="col-xs-12">
                <label class="search-from-date">Designation: <?= ucfirst($designation) ?></label>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-4">
        <button type="button" class="btn btn-primary report-print-button"><i class=" fa fa-print"
                                                                             aria-hidden="true"></i> Print
        </button>
    </div>

    <div style="width: 100%;">
        <table class="table table-striped" style="width: 100%" id="details-table">

            <thead class="thead-default">
            <tr>
                <th>SL</th>
                <th>Employee Name</th>
                <th><?= 'Per Month ' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                <th><?= 'Total Deposit Amount ' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                <th>Starting Date</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $count = 1;
            $total = 0;
            foreach ($pf_funds_report_by_employee_id as $employee_pf_funds_report): ?>
                <?php $starting_date = date("d-m-Y", strtotime($employee_pf_funds_report->starting_date)); ?>
                <?php $total += $employee_pf_funds_report->total_deposit_amount ?>
                <tr>
                    <td><?= $count++ ?></td>
                    <td><?= $employee_pf_funds_report->employee_name ?></td>
                    <td><?= $employee_pf_funds_report->pf_contribution_per_month ?></td>
                    <td><?= number_format((double)$employee_pf_funds_report->total_deposit_amount, 2) ?></td>
                    <td><?= $starting_date ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td></td>
                <td></td>
                <td><strong>Grand Total</strong></td>
                <td><strong><?= number_format((double)$total, 2) ?></strong></td>
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
        <h4 style="text-align: center"
            class="left-side-view"><?= strtoupper($company_information->company_name_1) ?></h4>
        <h6 style="text-align: center" class="left-side-view"><?= $company_information->company_address_1 ?></h6>
    </div>

    <div class="card card-boarder" style="margin-top: 10px;">

        <div class="col-xs-12" style="margin-left: 10px;">
            <label class="search-from-date"><strong>Employee Total PF Funds Report</strong></label><br>
        </div>
        <div class="col-xs-12" style="margin-left: 10px;">
            <label class="search-from-date">Name: <?= $employee_name ?></label><br>
        </div>
        <div class="col-xs-12" style="margin-left: 10px;">
            <label class="search-from-date">Designation: <?= $designation ?></label><br>
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
                        <?= 'Per Month ' . '(' . $currency_settings->currency_symbol . ')' ?>
                    </th>
                    <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                        <?= 'Total Deposit Amount ' . '(' . $currency_settings->currency_symbol . ')' ?>
                    </th>
                    <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                        Starting Date
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php
                $count = 1;
                $total = 0;
                foreach ($pf_funds_report_by_employee_id as $employee_pf_funds_report): ?>
                    <?php $starting_date = date("d-m-Y", strtotime($employee_pf_funds_report->starting_date)); ?>
                    <?php $total += $employee_pf_funds_report->total_deposit_amount ?>
                    <tr style="border: thick">
                        <td style="text-align: center"><?= $count++ ?></td>
                        <td style="text-align: center"><?= $employee_pf_funds_report->employee_name ?></td>
                        <td style="text-align: center"><?= $employee_pf_funds_report->pf_contribution_per_month ?></td>
                        <td style="text-align: center"><?= number_format((double)$employee_pf_funds_report->total_deposit_amount, 2) ?></td>
                        <td style="text-align: center"><?= $starting_date ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr style="border: thick">
                    <td></td>
                    <td></td>
                    <td><strong>Grand Total</strong></td>
                    <td style="text-align: center"><strong><?= number_format((double)$total, 2) ?></strong></td>
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











