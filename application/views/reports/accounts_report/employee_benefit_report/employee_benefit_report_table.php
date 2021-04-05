<div class="card card-boarder">

    <?php
    $company_information;
    $employee_total_benefit_by_month_year;

    /* echo '<pre>';
      print_r($employee_total_benefit_by_month_year);
      echo '</pre>';
      die(); */
    ?>
    <div class="col-xs-12 col-sm-8">
        <div class="col-xs-12">
            <label class="search-from-date">Employee: <?= ucfirst($employee_name) ?></label>
        </div>
        <div class="col-xs-12">
            <label class="search-from-date">Head: <?= ucfirst($head_name) ?></label>
        </div>
        <div class="col-xs-12">
            <?php $s_date = date("d-m-Y", strtotime($start_date)); ?>
            <?php $e_date = date("d-m-Y", strtotime($end_date)); ?>
            <label class="search-from-date">Period: <?= $s_date ?> To <?= $e_date ?> </label><br>
        </div>
    </div>

    <div class="col-xs-12 col-sm-4">
        <button type="button" class="btn btn-primary report-print-button">
            <i class="fa fa-print" aria-hidden="true"></i>Print
        </button>
    </div>

    <table class="table table-striped" style="width: 100%" id="details-table">

        <thead class="thead-default">
            <tr>
                <th>SL</th>
                <th>Date</th>
                <th>Employee</th>
                <th>Head</th>
                <th><?= 'Amount' . '(' . $currency_settings->currency_symbol . ')' ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            $total = 0;
            foreach ($employee_total_benefit_by_month_year as $employee_total_benefit) {
                ?>
                <?php $posting_date = date("d-m-Y", strtotime($employee_total_benefit->posting_date)); ?>
                <?php $total += (double) $employee_total_benefit->amount; ?>

                <tr>
                    <td><?= $count++ ?></td>
                    <td><?= $posting_date ?></td>
                    <td><?= ucfirst($employee_total_benefit->employee_name) ?></td>
                    <td><?= ucfirst($employee_total_benefit->head_name) ?></td>
                    <td><?= number_format((double) $employee_total_benefit->amount, 2) ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td><strong>Grand Total</strong></td>
                <td><strong><?= number_format((double) $total, 2); ?></strong></td>
            </tr>

        </tbody>
    </table>

    <div class="modal fade clientwise-voucher-details-information-modal">
        <div class="modal-dialog modal-lg client-voucher-show " role="document">
        </div>
    </div>
</div>


<!--For Print-->
<!--Display None-->

<div id="print-information" style="display: none">

    <div class="col-xs-12">
        <h4 style="text-align: center"><?= strtoupper($company_information->company_name_1) ?></h4>
        <!--<h6 style="text-align: center;"><? /*= $company_information->company_address_1 */ ?></h6>-->
    </div>

    <div class="col-xs-12" style="padding-bottom: 5px; margin-bottom: 5px;">
        <label class="search-from-date" style="text-align: left;"><strong>Employee Benefit Report</strong></label>
    </div>
    <div class="col-xs-12" style="padding-bottom: 5px; margin-bottom: 5px;">
        <label class="search-from-date" style="text-align: left;">Employee: <?= ucfirst($employee_name) ?></label>
    </div>
    <div class="col-xs-12" style="padding-bottom: 5px; margin-bottom: 5px;">
        <label class="search-from-date" style="text-align: left;">Head: <?= ucfirst($head_name) ?></label>
    </div>
    <div class="col-xs-12" style="padding-bottom: 5px; margin-bottom: 5px;">
        <div class="col-xs-12">
            <?php $s_date = date("d-m-Y", strtotime($start_date)); ?>
            <?php $e_date = date("d-m-Y", strtotime($end_date)); ?>
            <label class="search-from-date">Period: <?= $s_date ?> To <?= $e_date ?> </label><br>
        </div>
    </div>

    <table border="2px" cellspacing="0" class="table table-striped" style="width: 100%">

        <thead class="thead-default">
            <tr>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    SL
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Date
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Employee
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Head
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    <?= 'Amount' . '(' . $currency_settings->currency_symbol . ')' ?>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            $total = 0;
            foreach ($employee_total_benefit_by_month_year as $employee_total_benefit) {
                ?>
                <?php $posting_date = date("d-m-Y", strtotime($employee_total_benefit->posting_date)); ?>
                <?php $total += (double) $employee_total_benefit->amount; ?>

                <tr style="border: thick">
                    <td><?= $count++ ?></td>
                    <td><?= $posting_date ?></td>
                    <td><?= ucfirst($employee_total_benefit->employee_name) ?></td>
                    <td><?= ucfirst($employee_total_benefit->head_name) ?></td>
                    <td><?= number_format((double) $employee_total_benefit->amount, 2) ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td><strong>Grand Total</strong></td>
                <td><strong><?= number_format((double) $total, 2); ?></strong></td>
            </tr>
        </tbody>
    </table>
</div>


<script language="javascript" type="text/javascript">

    $('#details-table').dataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [[25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]],
        "scrollY": "400px",
        "scrollX": true,
        "ordering": false,
    });

    $('.client-voucher-details-view-button').on('click', function (event) {
        event.preventDefault();
        $.post($(this).attr('data-action'), {'id': $(this).attr('data-id')}, function (data) {
            $('.clientwise-voucher-details-information-modal .client-voucher-show').html(data)
            $('.clientwise-voucher-details-information-modal').modal('show');
        });
    });

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
</script>
