<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Leave Details Report</h4>
    </div>

    <div class="modal-body">
        <div class="form-group col-xs-12">
            <div class="col-xs-12">
                <?php $application_current_date_time = date('jS F Y', strtotime(($leave_application_by_leave_application_id->current_date_time))); ?>
                <?= $application_current_date_time ?>
            </div>
            <div class="col-xs-12 div-margin-top">
                <?= 'To,' ?>
            </div>
            <div class="col-xs-12">
                <?= 'HR' ?>
            </div>
            <div class="col-xs-12">
                <?= ucfirst($company_information->company_name_1) ?>
            </div>
            <div class="col-xs-12">
                <?= ucfirst($company_information->company_address_1) ?>
            </div>
            <div class="col-xs-12 card-margin-top">
                <strong>Subject: Application for <?= ucfirst($leave_application_by_leave_application_id->leave_type) ?> leave.</strong>
            </div>
            <div class="col-xs-12 card-margin-top">
                Dear Sir,
            </div>
            <div class="col-xs-12">
                <?= ucfirst($leave_application_by_leave_application_id->leave_details) ?>
            </div>
            <div class="col-xs-12 card-margin-top">
                Thanks,

            </div>
            <div class="col-xs-12 div-margin-top">
                Yours Sincerely,

            </div>
            <div class="col-xs-12">
                <?= ucwords(strtolower($leave_application_by_leave_application_id->employee_name)) ?>

            </div>
            <div class="col-xs-12">
                <?= ucfirst(strtolower($leave_application_by_leave_application_id->designation)) ?>
            </div>
            <div class="col-xs-12">
                <?= ucfirst($company_information->company_name_1) ?>
            </div>
            <div class="col-xs-12">
                <?= ucfirst($company_information->company_address_1) ?>
            </div>
        </div>

    </div>

    <div class="clearfix"></div>

    <div class="modal-footer">
        <button type="button" class="btn btn-primary employee-own-leave-application-print-button"><i class="fa fa-print" aria-hidden="true"></i> Print
        </button>
        <button type="button" class="btn btn-danger modal-close-button" data-dismiss="modal">Close</button>
    </div>
</div>


<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="employee-own-leave-application-print-information" style="display: none">
    <div class="form-group col-xs-12">
        <div class="col-xs-12" style="margin-top: 15%">
            <?php $application_current_date_time = date('jS F Y', strtotime(($leave_application_by_leave_application_id->current_date_time))); ?>
            <?= $application_current_date_time ?>
        </div>
        <div class="col-xs-12 div-margin-top" style="margin-top: 2%">
            <?= 'To,' ?>
        </div>
        <div class="col-xs-12">
            <?= 'HR' ?>
        </div>
        <div class="col-xs-12">
            <?= ucfirst($company_information->company_name_1) ?>
        </div>
        <div class="col-xs-12">
            <?= ucfirst($company_information->company_address_1) ?>
        </div>
        <div class="col-xs-12 card-margin-top" style="margin-top: 2rem">
            <strong>Subject: Application for <?= ucfirst($leave_application_by_leave_application_id->leave_type) ?> leave.</strong>
        </div>
        <div class="col-xs-12 card-margin-top" style="margin-top: 2rem">
            Dear Sir,
        </div>
        <div class="col-xs-12">
            <?= ucfirst($leave_application_by_leave_application_id->leave_details) ?>
        </div>
        <div class="col-xs-12 card-margin-top" style="margin-top: 2rem">
            Thanks,

        </div>
        <div class="col-xs-12 div-margin-top" style="margin-top: 2%">
            Yours Sincerely,

        </div>
        <div class="col-xs-12">
            <?= ucwords(strtolower($leave_application_by_leave_application_id->employee_name)) ?>

        </div>
        <div class="col-xs-12">
            <?= ucfirst(strtolower($leave_application_by_leave_application_id->designation)) ?>
        </div>
        <div class="col-xs-12">
            <?= ucfirst($company_information->company_name_1) ?>
        </div>
        <div class="col-xs-12">
            <?= ucfirst($company_information->company_address_1) ?>
        </div>
    </div>
</div>



<!--For Print-->
<script language="javascript" type="text/javascript">

    $(".employee-own-leave-application-print-button").on("click", function () {
        var divContents = $('#employee-own-leave-application-print-information').html();
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




