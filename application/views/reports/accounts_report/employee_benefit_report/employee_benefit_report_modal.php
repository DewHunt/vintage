<div class="modal-content">

    <?php
    $company_information;
    $employee_benefit_details_by_month_year;
    $employee;

    /*echo '<pre>';
    echo print_r($employee_benefit_details_by_month_year);
    echo '</pre>';*/
    //die();

    ?>

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Employee Benefit Details</h4>
    </div>

    <div class="modal-body">

        <div class="form-group col-xs-12">

            <div class="col-xs-12">
                <h4 class="left-side-view"><?= strtoupper($company_information->company_name_1) ?></h4>
            </div>

            <!--<div class="col-xs-12">
                <h6 class="left-side-view"><? /*= $company_information->company_address_1 */ ?></h6>
            </div>-->

            <div class="col-xs-12">
                <h6 class="left-side-view">Employee Name: <?= ucfirst($employee->employee_name) ?></h6>
            </div>

            <div class="col-xs-12">
                <h6 class="left-side-view">Month:<?= ucfirst($month) ?></h6>
            </div>
            <div class="col-xs-12">
                <h6 class="left-side-view">Year:<?= ($year) ?></h6>
            </div>

            <div class="col-xs-12">

                <table class="table" id="details-table">
                    <thead class="thead-default">
                    <tr>
                        <th>SL</th>
                        <th>Date</th>
                        <th>head</th>
                        <th>Amount</th>
                        <th>Voucher No</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php $count = 1;
                    foreach ($employee_benefit_details_by_month_year as $employee_benefit_details) { ?>
                        <?php $posting_date = date("d-m-Y", strtotime($employee_benefit_details->posting_date)); ?>

                        <tr>
                            <td><?= $count++; ?></td>
                            <td><?= $posting_date ?></td>
                            <td><?= ucfirst($employee_benefit_details->head_name) ?></td>
                            <td><?= number_format((double)$employee_benefit_details->amount, 2) ?></td>
                            <td><?= $employee_benefit_details->voucher_number ?></td>
                        </tr>

                    <?php } ?>
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


<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="print-information" style="display: none">


    <div class="col-xs-12">
        <h4 style="text-align: center"><?= strtoupper($company_information->company_name_1) ?></h4>
        <!--<h6 style="text-align: center;"><? /*= $company_information->company_address_1 */ ?></h6>-->
    </div>

    <div class="col-xs-12">
        <label class="col-form-label" style="float: left"><strong>Employee Benefit Report</strong></label><br>
    </div>

    <div class="col-xs-12">
        <label class="col-form-label" style="float: left">Employee
            Name: <?= ucfirst($employee->employee_name) ?> </label><br>
    </div>
    <br>

    <div class="col-xs-12">
        <label class="col-form-label" style="float: left">Month: <?= ucfirst($month) ?> </label><br>
    </div>
    <br>

    <div class="col-xs-12">
        <label class="col-form-label" style="float: left">Year: <?= $year ?> </label><br>
    </div>
    <br>

    <div class="col-xs-12" style="margin-top: 10px;padding-left: 0px;">

        <table border="2px" cellspacing="0" class="table" width="100%">
            <thead class="thead-default">
            <tr>
                <th style="border-bottom: 1px solid #ddd;">SL</th>
                <th style="border-bottom: 1px solid #ddd;">Date</th>
                <th style="border-bottom: 1px solid #ddd;">Head</th>
                <th style="border-bottom: 1px solid #ddd;">Amount</th>
                <th style="border-bottom: 1px solid #ddd;">Voucher No</th>
            </tr>
            </thead>
            <tbody>

            <?php $count = 1;
            foreach ($employee_benefit_details_by_month_year as $employee_benefit_details) { ?>
                <?php $posting_date = date("d-m-Y", strtotime($employee_benefit_details->posting_date)); ?>
                <tr style="border: thick">
                    <td style="text-align: center"><?= $count++ ?></td>
                    <td style="text-align: center"><?= $posting_date ?></td>
                    <td style="text-align: center"><?= ucfirst($employee_benefit_details->head_name) ?></td>
                    <td style="text-align: center"><?= number_format((double)$employee_benefit_details->amount, 2) ?></td>
                    <td style="text-align: center"><?= $employee_benefit_details->voucher_number ?></td>
                </tr>
            <?php } ?>

            </tbody>
        </table>
    </div>
</div>


</div>


<!--For Print-->
<script language="javascript" type="text/javascript">

    $('#details-table').dataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [[25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]],
        "scrollY": "400px",
        "scrollX": true,
        "ordering": false,
    });

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


