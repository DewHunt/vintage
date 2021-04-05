<div class="card card-boarder">

    <?php
    $company_information;
    $employee;
    $employee_total_leave_by_year;

//    echo '<pre>';
//    print_r($employee_total_leave_by_year);
//    echo '</pre>';
//    die();
    ?>

    <div class="col-xs-12 col-sm-8">
        <div class="col-xs-12">
            <label class="search-from-date">Employee: <?= ucfirst($employee_name) ?></label>
        </div>
        <div class="col-xs-12">
            <label class="search-from-date">Year: <?= $year ?></label>
        </div>
    </div>

    <div class="col-xs-12 col-sm-4">
        <button type="button" class="btn btn-primary report-print-button employee-leave-report-print-button"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
    </div>
    <table class="table table-striped" style="width: 100%" id="details-table">
        <?php
        $all_total_leave = 0;
        $total_leave = !empty($employee_total_leave_by_year) ? reset($employee_total_leave_by_year) : '';
        $total_casual_leave = !empty($total_leave) ? (int) $total_leave->total_casual_leave : 0;
        $total_medical_leave = !empty($total_leave) ? (int) $total_leave->total_medical_leave : 0;
        $total_earn_leave = !empty($total_leave) ? (int) $total_leave->total_earn_leave : 0;
        $all_total_leave = $total_casual_leave + $total_medical_leave + $total_earn_leave;
        ?>
        <thead class="thead-default">
            <tr>
                <th>Name</th>
                <th>Paid Casual Leave <?= '(' . $total_casual_leave . ')' ?></th>
                <th>Left Casual Leave</th>
                <th>Paid Medical Leave <?= '(' . $total_medical_leave . ')' ?></th>
                <th>Left Medical Leave</th>
                <th>Paid Earn Leave <?= '(' . $total_earn_leave . ')' ?></th>
                <th>Left Earn Leave</th>
                <th>Total Paid Leave</th>
                <th>Left Total Leave</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $paid_casual_leave = 0;
            $paid_medical_leave = 0;
            $paid_earn_leave = 0;
            $casual_leave_left = 0;
            $medical_leave_left = 0;
            $earn_leave_left = 0;
            $total_paid_leave = 0;
            $total_leave_left = 0;
            if (!empty($employee_total_leave_by_year)) {
                foreach ($employee_total_leave_by_year as $employee_total_leave) {
                    ?>
                    <?php
                    $paid_casual_leave = (int) $employee_total_leave->paid_casual_leave;
                    $paid_medical_leave = (int) $employee_total_leave->paid_medical_leave;
                    $paid_earn_leave = (int) $employee_total_leave->paid_earn_leave;
                    $total_paid_leave = $paid_casual_leave + $paid_medical_leave + $paid_earn_leave;
                    ?>
                    <?php
                    $casual_leave_left = $total_casual_leave - $paid_casual_leave;
                    $medical_leave_left = $total_medical_leave - $paid_medical_leave;
                    $earn_leave_left = $total_earn_leave - $paid_earn_leave;
                    ?>
                    <?php $total_leave_left = $all_total_leave - $total_paid_leave; ?>
                    <tr>
                        <td><?= ucfirst($employee_total_leave->employee_name) ?></td>
                        <td><?= $paid_casual_leave ?></td>
                        <td><?= $casual_leave_left ?></td>
                        <td><?= $paid_medical_leave ?></td>
                        <td><?= $medical_leave_left ?></td>
                        <td><?= $paid_earn_leave ?></td>
                        <td><?= $earn_leave_left ?></td>
                        <td><?= $total_paid_leave ?></td>
                        <td><?= $total_leave_left ?></td>
                        <td>
                            <button class="btn btn-primary employee_leave_details_view_button" data-toggle="tooltip" data-placement="bottom" title="View Details" data-id="<?= $employee_total_leave->employee_id ?>" data-action="<?= base_url('reports/hr_report/employee_leave_report/employee_leave_report/employee_leave_details_report_show_in_modal/') ?>"><i class="fa fa-eye" aria-hidden="true"></i></button>
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>
    <div class="modal fade clientwise-voucher-details-information-modal">
        <div class="modal-dialog modal-lg client-voucher-show " role="document">
        </div>
    </div>

</div>


<!--For Print-->
<!--Display None-->

<div id="employee-leave-report-print-information" style="display: none; width: 100%">

    <div class="col-xs-12">
        <h4 class="left-side-view"
            style="text-align: center"><?= strtoupper($company_information->company_name_1) ?></h4>
    </div>

    <!--<div class="col-xs-12">
        <h6 class="left-side-view" style="text-align: center"><? /*= $company_information->company_address_1 */ ?></h6>
    </div>-->

    <div class="col-xs-12">
        <strong>Employee Total Leave Report</strong></br>
        <strong>Employee: </strong> <?= ucfirst($employee_name) ?></br>
        <strong>Year: </strong> <?= ucfirst($year) ?>
    </div>
    <hr>

    <div class="col-xs-12">
        <table border="2px" cellspacing="0" class="table table-striped" style="width: 100%" id="details-table">
            <?php
            $all_total_leave = 0;
            $total_leave = !empty($employee_total_leave_by_year) ? reset($employee_total_leave_by_year) : '';
            $total_casual_leave = !empty($total_leave) ? (int) $total_leave->total_casual_leave : 0;
            $total_medical_leave = !empty($total_leave) ? (int) $total_leave->total_medical_leave : 0;
            $total_earn_leave = !empty($total_leave) ? (int) $total_leave->total_earn_leave : 0;
            $all_total_leave = $total_casual_leave + $total_medical_leave + $total_earn_leave;
            ?>
            <thead class="thead-default">
                <tr style="border: thick">
                    <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Name</th>
                    <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Paid Casual Leave <?= '(' . $total_casual_leave . ')' ?></th>
                    <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Casual Leave Left</th>
                    <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Paid Medical Leave <?= '(' . $total_medical_leave . ')' ?></th>
                    <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Medical Leave Left</th>
                    <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Paid Earn Leave <?= '(' . $total_earn_leave . ')' ?></th>
                    <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Earn Leave Left</th>
                    <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Total Paid Leave</th>
                    <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Total Leave Left</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $paid_casual_leave = 0;
                $paid_medical_leave = 0;
                $paid_earn_leave = 0;
                $casual_leave_left = 0;
                $medical_leave_left = 0;
                $earn_leave_left = 0;
                $total_paid_leave = 0;
                $total_leave_left = 0;
                if (!empty($employee_total_leave_by_year)) {
                    foreach ($employee_total_leave_by_year as $employee_total_leave) {
                        ?>
                        <?php
                        $paid_casual_leave = (int) $employee_total_leave->paid_casual_leave;
                        $paid_medical_leave = (int) $employee_total_leave->paid_medical_leave;
                        $paid_earn_leave = (int) $employee_total_leave->paid_earn_leave;
                        $total_paid_leave = $paid_casual_leave + $paid_medical_leave + $paid_earn_leave;
                        ?>
                        <?php
                        $casual_leave_left = $total_casual_leave - $paid_casual_leave;
                        $medical_leave_left = $total_medical_leave - $paid_medical_leave;
                        $earn_leave_left = $total_earn_leave - $paid_earn_leave;
                        ?>
                        <?php $total_leave_left = $all_total_leave - $total_paid_leave; ?>
                        <tr style="border: thick">
                            <td><?= ucfirst($employee_total_leave->employee_name) ?></td>
                            <td><?= $paid_casual_leave ?></td>
                            <td><?= $casual_leave_left ?></td>
                            <td><?= $paid_medical_leave ?></td>
                            <td><?= $medical_leave_left ?></td>
                            <td><?= $paid_earn_leave ?></td>
                            <td><?= $earn_leave_left ?></td>
                            <td><?= $total_paid_leave ?></td>
                            <td><?= $total_leave_left ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script language="javascript" type="text/javascript">

    $('.employee_leave_details_view_button').on('click', function (event) {
        event.preventDefault();
        $.post($(this).attr('data-action'), {'id': $(this).attr('data-id')}, function (data) {
            $('.clientwise-voucher-details-information-modal .client-voucher-show').html(data);
            $('.clientwise-voucher-details-information-modal').modal('show');
        });
    });

    $('#details-table').dataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [[25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]],
        "scrollY": "400px",
        "scrollX": true,
        "ordering": false,
    });

    $(".employee-leave-report-print-button").on("click", function () {
        var divContents = $('#employee-leave-report-print-information').html();
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
