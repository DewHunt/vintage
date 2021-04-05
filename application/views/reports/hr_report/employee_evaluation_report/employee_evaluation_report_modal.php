<div class="modal-content">
    <?php
    $company_information;
    $currency_settings;
    $employee_evaluation_by_employee_evaluation_id;
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
        <h4 class="modal-title">Employee Evaluation Details</h4>
    </div>

    <div class="modal-body">
        <div class="form-group col-xs-12">
            <center><h4><strong>Performance Appraisal Form</strong></h4></center>
            <table class="" style="width:100%">
                <tr>                    
                    <td width="60%"><strong>Company Name: </strong><?= $company_information->company_name_1 ?></td>
                    <?php $current_date = date("d-m-Y", strtotime($employee_evaluation_by_employee_evaluation_id->current_date_time)); ?>
                    <td width="40%" style="text-align:right"><strong>Date: </strong><?= $current_date ?></td>
                </tr>
            </table>
            <div class="div-margin-top"><strong>Employee Performance Review</strong></div>
            <table border="2px solid black" cellspacing="0" class="div-margin-top" style="width:100%">
                <tr>
                    <th class=""></th>
                    <th class="text-align-center">Employee Information</th>
                </tr>
                <tr>
                    <td width="30%">Employee</td>
                    <td width="70%"><?= !empty($employee_evaluation_by_employee_evaluation_id->employee_name) ? ucfirst($employee_evaluation_by_employee_evaluation_id->employee_name) : '' ?></td>
                </tr>
                <tr>
                    <td width="30%">Code</td>
                    <td width="70%"><?= !empty($employee_evaluation_by_employee_evaluation_id->employee_code) ? ucfirst($employee_evaluation_by_employee_evaluation_id->employee_code) : '' ?></td>
                </tr>
                <tr>
                    <td width="30%">Designation</td>
                    <td width="70%"><?= !empty($employee_evaluation_by_employee_evaluation_id->designation) ? ucfirst($employee_evaluation_by_employee_evaluation_id->designation) : '' ?></td>
                </tr>
                <tr>
                    <?php $start_date = date("d-m-Y", strtotime($employee_evaluation_by_employee_evaluation_id->start_date)); ?>
                    <?php $end_date = date("d-m-Y", strtotime($employee_evaluation_by_employee_evaluation_id->end_date)); ?>
                    <td width="30%">Period</td>
                    <td width="70%"><?= ($start_date) . ' To ' . ($end_date) ?></td>
                </tr>
            </table>
            <table class="div-margin-top" border="1px solid black" style="width:100%">
                <tr> 
                    <td width="100%"><center><strong>Ratings</strong></center></td>
                </tr>
            </table>
            <table class="div-margin-top" style="width:100%">
                <tr> 
                    <td width="100%"><center><strong>5 = Poor, 4 = Fair, 3 = Satisfactory, 2 = Good, 1 = Excellent</strong></center></td>
                </tr>
            </table>
            <table border="2px solid black" class="div-margin-top" style="width:100%">
                <tr>
                    <th class="">Factors</th>
                    <th class="text-align-center">Rating</th>
                    <th class="text-align-center">Comments</th>
                </tr>
                <tr>
                    <td width="30%">Job Knowledge</td>
                    <td width="20%"><?= !empty($employee_evaluation_by_employee_evaluation_id->job_knowledge_rating) ? $employee_evaluation_by_employee_evaluation_id->job_knowledge_rating : 0 ?></td>
                    <td width="50%"><?= !empty($employee_evaluation_by_employee_evaluation_id->job_knowledge_comments) ? $employee_evaluation_by_employee_evaluation_id->job_knowledge_comments : '' ?></td>
                </tr>
                <tr>
                    <td width="30%">Work Quality</td>
                    <td width="20%"><?= !empty($employee_evaluation_by_employee_evaluation_id->work_quality_rating) ? $employee_evaluation_by_employee_evaluation_id->work_quality_rating : 0 ?></td>
                    <td width="50%"><?= !empty($employee_evaluation_by_employee_evaluation_id->work_quality_comments) ? $employee_evaluation_by_employee_evaluation_id->work_quality_comments : '' ?></td>
                </tr>
                <tr>
                    <td width="30%">Attendance/Punctuality</td>
                    <td width="20%"><?= !empty($employee_evaluation_by_employee_evaluation_id->attendance_punctuality_rating) ? $employee_evaluation_by_employee_evaluation_id->attendance_punctuality_rating : 0 ?></td>
                    <td width="50%"><?= !empty($employee_evaluation_by_employee_evaluation_id->attendance_punctuality_comments) ? $employee_evaluation_by_employee_evaluation_id->attendance_punctuality_comments : '' ?></td>
                </tr>
                <tr>
                    <td width="30%">Communication/Listening Skills</td>
                    <td width="20%"><?= !empty($employee_evaluation_by_employee_evaluation_id->communication_listening_skills_rating) ? $employee_evaluation_by_employee_evaluation_id->communication_listening_skills_rating : 0 ?></td>
                    <td width="50%"><?= !empty($employee_evaluation_by_employee_evaluation_id->communication_listening_skills_comments) ? $employee_evaluation_by_employee_evaluation_id->communication_listening_skills_comments : '' ?></td>
                </tr>
                <tr>
                    <td width="30%">Dependability</td>
                    <td width="20%"><?= !empty($employee_evaluation_by_employee_evaluation_id->dependability_rating) ? $employee_evaluation_by_employee_evaluation_id->dependability_rating : 0 ?></td>
                    <td width="50%"><?= !empty($employee_evaluation_by_employee_evaluation_id->dependability_comments) ? $employee_evaluation_by_employee_evaluation_id->dependability_comments : '' ?></td>
                </tr>
                <tr>
                    <td width="30%"><strong>Overall Rating</strong></td>
                    <td width="20%"><strong><?= !empty($employee_evaluation_by_employee_evaluation_id->overall_rating) ? $employee_evaluation_by_employee_evaluation_id->overall_rating : 0 ?></strong></td>
                    <td width="50%"></td>
                </tr>
                <tr>
                    <td width="30%"><strong>Average Rating</strong></td>
                    <td width="20%"><strong><?= !empty($employee_evaluation_by_employee_evaluation_id->average_rating) ? $employee_evaluation_by_employee_evaluation_id->average_rating : 0 ?></strong></td>
                    <td width="50%"></td>
                </tr>
            </table>
            <table class="div-margin-top" border="1px solid black" style="width:100%">
                <tr> 
                    <td width="100%"><center><strong>Evaluation</strong></center></td>
                </tr>
            </table>
            <table border="2px solid black" class="div-margin-top" style="width:100%">
                <tr>
                    <td width="30%"><strong>Additional Comments</strong></td>
                    <td width="70%"><strong><?= !empty($employee_evaluation_by_employee_evaluation_id->additional_comments) ? $employee_evaluation_by_employee_evaluation_id->additional_comments : 0 ?></strong></td>
                </tr>
            </table>
            <table class="div-margin-top" border="1px solid black" style="width:100%">
                <tr> 
                    <td width="100%"><center><strong>Verification of Review</strong></center></td>
                </tr>
            </table>
            <div>
                <span>
                    By signing this form, you confirm that you have discussed this review in detail with your Supervisor. Signing this form, does not necessarily indicate that you agree with this evaluator.
                </span>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="modal-footer">
        <?php if ((strtolower($user_type) != 'marketing')) { ?>
            <?php if (!empty($print_access) > 0) { ?>
                <button type="button" class="btn btn-primary employee-evaluation-modal-print-button"><i class="fa fa-print" aria-hidden="true"></i>
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

<div id="employee-evaluation-modal-print-information" style="display: none">
    <div class="form-group col-xs-12">
        <center><h4><strong>Performance Appraisal Form</strong></h4></center>
        <table class="" style="width:100%">
            <tr>                    
                <td width="60%"><strong>Company Name: </strong><?= $company_information->company_name_1 ?></td>
                <?php $current_date = date("d-m-Y", strtotime($employee_evaluation_by_employee_evaluation_id->current_date_time)); ?>
                <td width="40%" style="text-align:right"><strong>Date: </strong><?= $current_date ?></td>
            </tr>
        </table>
        <div class="div-margin-top" style="margin-top: 3%"><strong>Employee Performance Review</strong></div>
        <table border="2px solid black" cellspacing="0" class="div-margin-top" style="width:100%">
            <tr style="border: thick">
                <th class=""></th>
                <th class="text-align-center">Employee Information</th>
            </tr>
            <tr style="border: thick">
                <td width="30%">Employee</td>
                <td width="70%"><?= !empty($employee_evaluation_by_employee_evaluation_id->employee_name) ? ucfirst($employee_evaluation_by_employee_evaluation_id->employee_name) : '' ?></td>
            </tr>
            <tr style="border: thick">
                <td width="30%">Code</td>
                <td width="70%"><?= !empty($employee_evaluation_by_employee_evaluation_id->employee_code) ? ucfirst($employee_evaluation_by_employee_evaluation_id->employee_code) : '' ?></td>
            </tr>
            <tr style="border: thick">
                <td width="30%">Designation</td>
                <td width="70%"><?= !empty($employee_evaluation_by_employee_evaluation_id->designation) ? ucfirst($employee_evaluation_by_employee_evaluation_id->designation) : '' ?></td>
            </tr>
            <tr style="border: thick">
                <?php $start_date = date("d-m-Y", strtotime($employee_evaluation_by_employee_evaluation_id->start_date)); ?>
                <?php $end_date = date("d-m-Y", strtotime($employee_evaluation_by_employee_evaluation_id->end_date)); ?>
                <td width="30%">Period</td>
                <td width="70%"><?= ($start_date) . ' To ' . ($end_date) ?></td>
            </tr>
        </table>
        <table class="div-margin-top" border="1px solid black" cellspacing="0" style="width:100%; margin-top: 3%">
            <tr> 
                <td width="100%"><center><strong>Ratings</strong></center></td>
            </tr>
        </table>
        <table class="div-margin-top" style="width:100%">
            <tr> 
                <td width="100%"><center><strong>5 = Poor, 4 = Fair, 3 = Satisfactory, 2 = Good, 1 = Excellent</strong></center></td>
            </tr>
        </table>
        <table border="2px solid black" cellspacing="0" class="div-margin-top" style="width:100%; margin-top: 3%">
            <tr style="border: thick">
                <th class="">Factors</th>
                <th class="text-align-center">Rating</th>
                <th class="text-align-center">Comments</th>
            </tr>
            <tr style="border: thick">
                <td width="30%">Job Knowledge</td>
                <td width="20%"><?= !empty($employee_evaluation_by_employee_evaluation_id->job_knowledge_rating) ? $employee_evaluation_by_employee_evaluation_id->job_knowledge_rating : 0 ?></td>
                <td width="50%"><?= !empty($employee_evaluation_by_employee_evaluation_id->job_knowledge_comments) ? $employee_evaluation_by_employee_evaluation_id->job_knowledge_comments : '' ?></td>
            </tr>
            <tr style="border: thick">
                <td width="30%">Work Quality</td>
                <td width="20%"><?= !empty($employee_evaluation_by_employee_evaluation_id->work_quality_rating) ? $employee_evaluation_by_employee_evaluation_id->work_quality_rating : 0 ?></td>
                <td width="50%"><?= !empty($employee_evaluation_by_employee_evaluation_id->work_quality_comments) ? $employee_evaluation_by_employee_evaluation_id->work_quality_comments : '' ?></td>
            </tr>
            <tr style="border: thick">
                <td width="30%">Attendance/Punctuality</td>
                <td width="20%"><?= !empty($employee_evaluation_by_employee_evaluation_id->attendance_punctuality_rating) ? $employee_evaluation_by_employee_evaluation_id->attendance_punctuality_rating : 0 ?></td>
                <td width="50%"><?= !empty($employee_evaluation_by_employee_evaluation_id->attendance_punctuality_comments) ? $employee_evaluation_by_employee_evaluation_id->attendance_punctuality_comments : '' ?></td>
            </tr>
            <tr style="border: thick">
                <td width="30%">Communication/Listening Skills</td>
                <td width="20%"><?= !empty($employee_evaluation_by_employee_evaluation_id->communication_listening_skills_rating) ? $employee_evaluation_by_employee_evaluation_id->communication_listening_skills_rating : 0 ?></td>
                <td width="50%"><?= !empty($employee_evaluation_by_employee_evaluation_id->communication_listening_skills_comments) ? $employee_evaluation_by_employee_evaluation_id->communication_listening_skills_comments : '' ?></td>
            </tr>
            <tr style="border: thick">
                <td width="30%">Dependability</td>
                <td width="20%"><?= !empty($employee_evaluation_by_employee_evaluation_id->dependability_rating) ? $employee_evaluation_by_employee_evaluation_id->dependability_rating : 0 ?></td>
                <td width="50%"><?= !empty($employee_evaluation_by_employee_evaluation_id->dependability_comments) ? $employee_evaluation_by_employee_evaluation_id->dependability_comments : '' ?></td>
            </tr>
            <tr style="border: thick">
                <td width="30%"><strong>Overall Rating</strong></td>
                <td width="20%"><strong><?= !empty($employee_evaluation_by_employee_evaluation_id->overall_rating) ? $employee_evaluation_by_employee_evaluation_id->overall_rating : 0 ?></strong></td>
                <td width="50%"></td>
            </tr>
            <tr style="border: thick">
                <td width="30%"><strong>Average Rating</strong></td>
                <td width="20%"><strong><?= !empty($employee_evaluation_by_employee_evaluation_id->average_rating) ? $employee_evaluation_by_employee_evaluation_id->average_rating : 0 ?></strong></td>
                <td width="50%"></td>
            </tr>
        </table>
        <table class="div-margin-top" border="1px solid black" cellspacing="0" style="width:100%; margin-top: 3%">
            <tr> 
                <td width="100%"><center><strong>Evaluation</strong></center></td>
            </tr>
        </table>
        <table border="2px solid black" cellspacing="0" class="div-margin-top" style="width:100%; margin-top: 3%">
            <tr style="border: thick">
                <td width="30%"><strong>Additional Comments</strong></td>
                <td width="70%"><?= !empty($employee_evaluation_by_employee_evaluation_id->additional_comments) ? $employee_evaluation_by_employee_evaluation_id->additional_comments : 0 ?></td>
            </tr>
        </table>
        <table class="div-margin-top" border="1px solid black" cellspacing="0" style="width:100%; margin-top: 3%">
            <tr> 
                <td width="100%"><center><strong>Verification of Review</strong></center></td>
            </tr>
        </table>
        <div style="margin-top: 3%">
            <span class="div-margin-top">
                By signing this form, you confirm that you have discussed this review in detail with your Supervisor. Signing this form, does not necessarily indicate that you agree with this evaluator.
            </span>
        </div>
        <table width="100%" border="0" style="margin-top: 10%">
            <tr>
                <td style="padding: 10px"></td>
                <td style="padding: 10px"></td>
                <td style="padding: 10px"></td>
            </tr>
            <tr>
                <td style="padding: 10px"></td>
                <td style="padding: 10px"></td>
                <td style="padding: 10px"></td>
            </tr>
            <tr>
                <td style="padding: 10px"></td>
                <td style="padding: 10px"></td>
                <td style="padding: 10px"></td>
            </tr>
            <tr>
                <td style="text-align: left; width: 50%">
                    <p style="">
                        <a style="border-top: inset;">Employee Signature</a>
                    </p>
                </td>
                <td style="text-align: right; width: 50%">
                    <p style="">
                        <a style="border-top: inset;">Authorize Signature</a>
                    </p>
                </td>
            </tr>
        </table>
    </div>
</div>


<!--For Print-->
<script language="javascript" type="text/javascript">

    $(".employee-evaluation-modal-print-button").on("click", function () {

        var divContents = $('#employee-evaluation-modal-print-information').html();

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


