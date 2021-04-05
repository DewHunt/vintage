<div class="modal-content">

    <?php
    $company_information;
    $employee_leave_details_by_year;

//    echo '<pre>';
//    echo print_r($employee_leave_details_by_year);
//    echo '</pre>';
//    die();
    ?>

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Employee Leave Details Report</h4>
    </div>

    <div class="modal-body">

        <div class="form-group col-xs-12">

            <div class="col-xs-12">
                <strong>Employee: </strong> <?= ucfirst($employee->employee_name) ?>
            </div>
            <div class="col-xs-12">
                <strong>Designation: </strong> <?= ucfirst($employee->designation) ?>
            </div>

            <div class="col-xs-12">
                <strong>Year: </strong> <?= $year_session ?>
            </div>

            <div class="col-xs-12">

                <table class="table table-striped">
                    <thead class="thead-default">
                        <tr>
                            <th>SL</th>
                            <th>Leave Type</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Total Day</th>
                            <th>Reason</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $count = 1;
                        foreach ($employee_leave_details_by_year as $employee_leave_details):
                            ?>
                            <?php $start_date = date("d-m-Y", strtotime($employee_leave_details->start_date)); ?>
                            <?php $end_date = date("d-m-Y", strtotime($employee_leave_details->end_date)); ?>
                            <tr>
                                <td><?= $count++; ?></td>
                                <td><?= ucfirst($employee_leave_details->leave_type) ?></td>
                                <td><?= $start_date ?></td>
                                <td><?= $end_date ?></td>
                                <td><?= $employee_leave_details->total_day ?></td>
                                <td><?= ucfirst($employee_leave_details->comments) ?></td>
                            </tr>

                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>

        </div>

    </div>

    <div class="clearfix"></div>

    <div class="modal-footer">
        <button type="button" class="btn btn-primary print-button"><i class="fa fa-print" aria-hidden="true"></i> Print
        </button>
        <button type="button" class="btn btn-danger modal-close-button" data-dismiss="modal">Close</button>
    </div>

</div>


<!--For Print-->
<!--Display None-->

<div id="print-information" style="display: none">

    <div class="col-xs-12">
        <h4 class="left-side-view"
            style="text-align: center"><?= strtoupper($company_information->company_name_1) ?></h4>
    </div>

    <!--<div class="col-xs-12">
        <h6 class="left-side-view" style="text-align: center"><? /*= $company_information->company_address_1 */ ?></h6>
    </div>-->

    <div class="col-xs-12">
        <strong>Employee Leave Report</strong></br>
        <strong>Employee: </strong> <?= ucfirst($employee->employee_name) ?></br>
        <strong>Designation: </strong> <?= ucfirst($employee->designation) ?>
    </div>

    <div class="col-xs-12">
        <strong>Year: </strong> <?= $year_session ?>
    </div>

    <hr>

    <div class="col-xs-12">

        <table border="2px" cellspacing="0" class="table" width="100%">
            <thead class="thead-default">
                <tr>
                    <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                        SL
                    </th>
                    <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                        Leave Type
                    </th>
                    <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                        Start Date
                    </th>
                    <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                        End Date
                    </th>
                    <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                        Total Day
                    </th>
                    <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                        Reason
                    </th>
                </tr>
            </thead>
            <tbody>

                <?php
                $count = 1;
                foreach ($employee_leave_details_by_year as $employee_leave_details):
                    ?>
                    <?php $start_date = date("d-m-Y", strtotime($employee_leave_details->start_date)); ?>
                    <?php $end_date = date("d-m-Y", strtotime($employee_leave_details->end_date)); ?>
                    <tr style="border: thick">
                        <td><?= $count++; ?></td>
                        <td><?= ucfirst($employee_leave_details->leave_type) ?></td>
                        <td><?= $start_date ?></td>
                        <td><?= $end_date ?></td>
                        <td><?= $employee_leave_details->total_day ?></td>
                        <td><?= ucfirst($employee_leave_details->comments) ?></td>
                    </tr>

                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</div>


<!--For Print-->
<script language="javascript" type="text/javascript">

    $(".print-button").on("click", function () {

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


