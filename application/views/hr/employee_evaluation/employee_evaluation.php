<div id="page-wrapper">
    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Employee Evaluation</h4>
                </div>
                <div class="panel-body">
                    <div class="error" style="color: red">
                        <?php echo validation_errors(); ?>
                    </div>
                    <?php if (!empty($this->session->flashdata('employee_evaluation_save_error_message'))) { ?>
                        <div class="error error-message text-align-center">
                            <?php echo $this->session->flashdata('employee_evaluation_save_error_message'); ?>
                        </div>
                    <?php }
                    ?>
                    <?php if (!empty($this->session->flashdata('employee_evaluation_save_success_message'))) { ?>
                        <div class="error success-message text-align-center">
                            <?php echo $this->session->flashdata('employee_evaluation_save_success_message'); ?>
                        </div>
                    <?php }
                    ?>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <form id="employee_evaluation_form" name="employee_evaluation_form" action="<?= base_url('hr/employee_evaluation/employee_evaluation_save') ?>" method="post">
                                <div class="col-xs-12 row">
                                    <table class="" width="100%">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="left-side-view col-xs-12 col-sm-6">
                                                    <label for="employee_id" class="col-sm-2 col-xs-12 col-form-label">Employee</label>
                                                    <div class="col-sm-10 col-xs-12">
                                                        <select name="employee_id" id="employee_id" class="form-control">
                                                            <option value="" name="employee_id">Please Select</option>
                                                            <?php foreach ($employee_list as $employee) { ?>
                                                                <option value="<?= $employee->id ?>" employee-code="<?= $employee->employee_code ?>" employee-designation="<?= $employee->designation ?>" employee-mobile="<?= $employee->mobile ?>" name="employee_id"><?= ucfirst($employee->employee_name) ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td class="right-side-view col-xs-12 col-sm-6">
                                                    <label for="employee_code" class="col-sm-3 col-xs-12 col-form-label">Code</label>
                                                    <div class="col-sm-9 col-xs-12">
                                                        <input type="text" class="form-control" id="employee_code" name="employee_code" value="" placeholder="Employee Code" readonly="readonly">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="left-side-view col-xs-12 col-sm-6">
                                                </td>
                                                <td class="right-side-view col-xs-12 col-sm-6">
                                                    <label for="designation" class="col-sm-3 col-xs-12 col-form-label div-margin-top">Designation</label>
                                                    <div class="col-sm-9 col-xs-12">
                                                        <input type="text" class="form-control div-margin-top" id="designation" name="designation" value="" placeholder="Designation" readonly="readonly">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="left-side-view col-xs-12 col-sm-6">
                                                    <label for="start_date" class="col-sm-2 col-xs-12 col-form-label div-margin-top">Period</label>
                                                    <div class="col-sm-5 col-xs-12">
                                                        <input type="date" class="form-control" id="start_date" name="start_date" value="" placeholder="">
                                                    </div>
                                                    <div class="col-sm-5 col-xs-12">
                                                        <input type="date" class="form-control" id="end_date" name="end_date" value="" placeholder="">
                                                    </div>
                                                </td>
                                                <td class="right-side-view col-xs-12 col-sm-6">
                                                    <label for="mobile" class="col-sm-3 col-xs-12 col-form-label div-margin-top">Mobile</label>
                                                    <div class="col-sm-9 col-xs-12">
                                                        <input type="text" class="form-control div-margin-top" id="mobile" name="mobile" value="" placeholder="mobile" readonly="readonly">
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-xs-12 div-margin-top" style="background-color: lightgray">
                                    <center><strong>Rating</strong></center>
                                </div>
                                <div class="col-xs-12 div-margin-top" style="background-color: #f6a828">
                                    <center><strong>5=Poor, 4=Fair, 3=Satisfactory, 2=Good, 1=Excellent</strong></center>
                                </div>
                                <table class="div-margin-top" style="width:100%">
                                    <tr>
                                        <th class="">Factors</th>
                                        <th class="text-align-center">Rating</th>
                                        <th class="text-align-center">Comments</th>
                                    </tr>
                                    <tr>
                                        <td width="30%">Job Knowledge</td>
                                        <td width="20%"><input type="number" class="form-control" id="job_knowledge_rating" name="job_knowledge_rating" value="" placeholder="0" min="0"></td>
                                        <td width="50%"><textarea class="form-control div-margin-left" id="job_knowledge_comments" name="job_knowledge_comments" rows="1"></textarea></td>
                                    </tr>
                                    <tr>
                                        <td width="30%">Work Quality</td>
                                        <td width="20%"><input type="number" class="form-control" id="work_quality_rating" name="work_quality_rating" value="" placeholder="0" min="0"></td>
                                        <td width="50%"><textarea class="form-control div-margin-left" id="work_quality_comments" name="work_quality_comments" rows="1"></textarea></td>
                                    </tr>
                                    <tr>
                                        <td width="30%">Attendance/Punctuality</td>
                                        <td width="20%"><input type="number" class="form-control" id="attendance_punctuality_rating" name="attendance_punctuality_rating" value="" placeholder="0" min="0"></td>
                                        <td width="50%"><textarea class="form-control div-margin-left" id="attendance_punctuality_comments" name="attendance_punctuality_comments" rows="1"></textarea></td>
                                    </tr>
                                    <tr>
                                        <td width="30%">Communication/Listening Skills</td>
                                        <td width="20%"><input type="number" class="form-control" id="communication_listening_skills_rating" name="communication_listening_skills_rating" value="" placeholder="0" min="0"></td>
                                        <td width="50%"><textarea class="form-control div-margin-left" id="communication_listening_skills_comments" name="communication_listening_skills_comments" rows="1"></textarea></td>
                                    </tr>
                                    <tr>
                                        <td width="30%">Dependability</td>
                                        <td width="20%"><input type="number" class="form-control" id="dependability_rating" name="dependability_rating" value="" placeholder="0" min="0"></td>
                                        <td width="50%"><textarea class="form-control div-margin-left" id="dependability_comments" name="dependability_comments" rows="1"></textarea></td>
                                    </tr>
                                </table>
                                <table class="div-margin-top" style="width:100%">
                                    <tr>
                                        <td width="30%">Overall Ratings</td>
                                        <td width="20%"><input type="number" class="form-control" id="overall_rating" name="overall_rating" value="" placeholder="0" min="0"></td>
                                        <td width="15%"><span class="div-margin-left">Average Ratings</span></td>
                                        <td width="35%"><input type="number" class="form-control" id="average_rating" name="average_rating" value="" placeholder="0" min="0" readonly="readonly"></td>
                                    </tr>
                                </table>
                                <table class="div-margin-top" style="width:100%">
                                    <tr>
                                        <td width="30%">Additional Comments</td>
                                        <td width="70%"><textarea class="form-control" id="additional_comments" name="additional_comments" rows="2"></textarea></td>
                                    </tr>
                                </table>
                                <table class="" style="width:100%">
                                    <tr>
                                        <td width="100%" style="float: right"><button type="submit" class="btn btn-default save-button div-margin-top">Save</button></td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->


<script>
    $(document).ready(function () {
        $("#employee_evaluation_form").validate({
            rules: {
                employee_id: "required",
                start_date: "required",
                end_date: "required",
                job_knowledge_rating: {
                    required: true,
                    min: 1,
                    max: 5,
                },
                work_quality_rating: {
                    required: true,
                    min: 1,
                    max: 5,
                },
                attendance_punctuality_rating: {
                    required: true,
                    min: 1,
                    max: 5,
                },
                communication_listening_skills_rating: {
                    required: true,
                    min: 1,
                    max: 5,
                },
                dependability_rating: {
                    required: true,
                    min: 1,
                    max: 5,
                },
                overall_rating: {
                    required: true,
                    min: 1,
                    max: 5,
                },
                average_rating: {
                    required: true,
                    min: 1,
                },
            }
            ,
            messages: {
                employee_id: "Please Select Employee Name",
                start_date: "Please Select Start Date",
                end_date: "Please Select End Date",
            }
            ,
            submitHandler: function (form) {
                form.submit();
            }
        }
        );

        $('#job_knowledge_rating').keyup(get_overall_rating);
        $('#work_quality_rating').keyup(get_overall_rating);
        $('#attendance_punctuality_rating').keyup(get_overall_rating);
        $('#communication_listening_skills_rating').keyup(get_overall_rating);
        $('#dependability_rating').keyup(get_overall_rating);

        function get_overall_rating() {
            var total_rating = 0;
            var average_rating = 0;

            var job_knowledge_rating = 0;
            job_knowledge_rating = $('#job_knowledge_rating').val();
            if (job_knowledge_rating == '' || job_knowledge_rating == null) {
                job_knowledge_rating = 0;
            } else {
                job_knowledge_rating = $('#job_knowledge_rating').val();
            }

            var work_quality_rating = 0;
            work_quality_rating = $('#work_quality_rating').val();
            if (work_quality_rating == '' || work_quality_rating == null) {
                work_quality_rating = 0;
            } else {
                work_quality_rating = $('#work_quality_rating').val();
            }

            var attendance_punctuality_rating = 0;
            attendance_punctuality_rating = $('#attendance_punctuality_rating').val();
            if (attendance_punctuality_rating == '' || attendance_punctuality_rating == null) {
                attendance_punctuality_rating = 0;
            } else {
                attendance_punctuality_rating = $('#attendance_punctuality_rating').val();
            }

            var communication_listening_skills_rating = 0;
            communication_listening_skills_rating = $('#communication_listening_skills_rating').val();
            if (communication_listening_skills_rating == '' || communication_listening_skills_rating == null) {
                communication_listening_skills_rating = 0;
            } else {
                communication_listening_skills_rating = $('#communication_listening_skills_rating').val();
            }

            var dependability_rating = 0;
            dependability_rating = $('#dependability_rating').val();
            if (dependability_rating == '' || dependability_rating == null) {
                dependability_rating = 0;
            } else {
                dependability_rating = $('#dependability_rating').val();
            }

            total_rating = parseInt(job_knowledge_rating) + parseInt(work_quality_rating) + parseInt(attendance_punctuality_rating) + parseInt(communication_listening_skills_rating) + parseInt(dependability_rating);
            average_rating = parseInt(total_rating) / 5;
            $('#average_rating').val(average_rating);
        }

        $('#employee_id').change(function () {
            var employee_code = $("option[name=employee_id]:selected").attr('employee-code');
            $('#employee_code').val(employee_code);
            var employee_designation = $("option[name=employee_id]:selected").attr('employee-designation');
            $('#designation').val(employee_designation);
            var employee_mobile = $("option[name=employee_id]:selected").attr('employee-mobile');
            $('#mobile').val(employee_mobile);
        });
    });
</script>
