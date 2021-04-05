<div class="modal-content">
    <?php
    $company_information;
    $currency_settings;
    $warning_letter_by_warning_letter_id;
    $user_info = $this->session->userdata('user_session');
    $user_type = $user_info['user_type'];
    $print_access = $user_info['print_access'];

//    echo '<pre>';
//    echo print_r($employee_evaluation_by_employee_evaluation_id);
//    echo '</pre>';
//    die();
    ?>

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Warning Letter Details</h4>
    </div>

    <div class="modal-body">
        <div class="form-group col-xs-12">
            <div><center><strong><h3><?= strtoupper($company_information->company_name_1) ?></h3></strong></center></div>
        </div>
        <div class="clearfix"></div>
        <div class="panel-default">
            <div class="panel-heading">
                <div class="panel-body">
                    <div class="form-group col-xs-12">
                        <div><center><strong><u>LETTER OF WARNING</u></strong></center></div>
                    </div>
                    <table class="" style="width:100%">
                        <tr>    
                            <?php $warning_date = date("d-F-Y", strtotime($warning_letter_by_warning_letter_id->warning_date)); ?>                
                            <?php $generate_date = date("d-F-Y", strtotime($warning_letter_by_warning_letter_id->current_date_time)); ?>                
                            <td width="60%"><strong>Date: </strong><?= $generate_date ?></td>

                            <td width="40%" style="text-align:right"><strong>Warning Date: </strong><?= $warning_date ?></td>
                        </tr>
                    </table>
                    <div class="card-margin-top">
                        <strong>Subject : Warning Letter - <?= ucwords($warning_letter_by_warning_letter_id->warning_type) ?>.</strong>
                    </div>
                    <div class="card-margin-top">
                        Dear <?= ucwords(strtolower($warning_letter_by_warning_letter_id->employee_name)) ?>,
                    </div>
                    <div class="div-margin-top">
                        <?= ucfirst(($warning_letter_by_warning_letter_id->warning_details)) ?>
                    </div>
                    <div class="card-margin-top">
                        Sincerely -
                    </div>
                    <div class="div-margin-top">
                        Head of HRD
                        <br>
                        <?= strtoupper($company_information->company_name_1) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="modal-footer">
        <?php if ((strtolower($user_type) != 'marketing')) { ?>
            <?php if (!empty($print_access) > 0) { ?>
                <button type="button" class="btn btn-primary warning-letter-modal-print-button"><i class="fa fa-print" aria-hidden="true"></i>
                    Print
                </button>
                <?php
            }
        }
        ?>
        <button type="button" class="btn btn-danger modal-close-button" data-dismiss="modal">Close</button>
    </div>
</div>

<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="warning-letter-modal-print-information" style="display: none">
    <div class="form-group col-xs-12">
        <div class="form-group col-xs-12">
            <div><center><strong><h3><?= strtoupper($company_information->company_name_1) ?></h3></strong></center></div>
        </div>
        <div class="clearfix"></div>
        <div class="panel-default">
            <div class="panel-heading">
                <div class="panel-body">
                    <div class="form-group col-xs-12" style="margin-top: 4rem;">
                        <div><center><strong><u>LETTER OF WARNING</u></strong></center></div>
                    </div>
                    <table class="" style="width:100%; margin-top: 2rem;">
                        <tr>    
                            <?php $warning_date = date("d-F-Y", strtotime($warning_letter_by_warning_letter_id->warning_date)); ?>                
                            <?php $generate_date = date("d-F-Y", strtotime($warning_letter_by_warning_letter_id->current_date_time)); ?>                
                            <td width="60%"><strong>Date: </strong><?= $generate_date ?></td>

                            <td width="40%" style="text-align:right"><strong>Warning Date: </strong><?= $warning_date ?></td>
                        </tr>
                    </table>
                    <div class="card-margin-top" style="margin-top: 2rem;">
                        <strong>Subject : Warning Letter - <?= ucwords($warning_letter_by_warning_letter_id->warning_type) ?>.</strong>
                    </div>
                    <div class="card-margin-top" style="margin-top: 4rem">
                        Dear <?= ucwords(strtolower($warning_letter_by_warning_letter_id->employee_name)) ?>,
                    </div>
                    <div class="div-margin-top">
                        <?= ucfirst(($warning_letter_by_warning_letter_id->warning_details)) ?>
                    </div>
                    <div class="card-margin-top" style="margin-top: 4rem;">
                        Sincerely -
                    </div>
                    <div class="div-margin-top" style="margin-top: 2rem;">
                        Head of HRD
                        <br>
                        <?= strtoupper($company_information->company_name_1) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--For Print-->
<script language="javascript" type="text/javascript">

    $(".warning-letter-modal-print-button").on("click", function () {

        var divContents = $('#warning-letter-modal-print-information').html();

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


