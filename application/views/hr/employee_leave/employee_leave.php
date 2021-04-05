<div id="page-wrapper">
    <!-- <div class="row">
         <div class="col-lg-12">
             <h2 class="page-header">Add Company Information</h2>
         </div>
     </div>-->

    <?php
    $employee_list;
    $from_date = date('Y-m-d');
    ?>
    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Employee Leave Information</h4>
                </div>
                <div class="panel-body">
                    <div class="error" style="color: red">
                        <?php echo validation_errors(); ?>
                    </div>

                    <?php if ((!empty($this->session->flashdata('employee_leave_details_save_message')))) { ?>
                        <div class="col-xs-12 success-message text-align-center">
                            <?php echo $this->session->flashdata('employee_leave_details_save_message'); ?>
                        </div>
                    <?php } ?>

                    <?php if ((!empty($this->session->flashdata('total_day_leave_error_message')))) { ?>
                        <div class="col-xs-12 error-message text-align-center">
                            <?php echo $this->session->flashdata('total_day_leave_error_message'); ?>
                        </div>
                    <?php } ?>

                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <form id="employee_leave_save_form" name="employee_leave_save_form"
                                  action="<?= base_url('hr/employee_leave/employee_leave_save') ?>" method="post">

                                <div class="col-xs-12 row">

                                    <div class="form-group col-xs-12 col-sm-6">
                                        <label for="employee_id" class="col-form-label">Employee</label>
                                        <select name="employee_id" id="employee_id"
                                                class="form-control">
                                            <option value="" name="employee_id">Please Select</option>
                                                <?php foreach ($employee_list as $employee){ ?>
                                            <option value="<?= $employee->id ?>"
                                                    name="employee_id"><?= ucfirst($employee->employee_name) ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-xs-12 col-sm-6">
                                        <label for="leave_type" class="col-form-label">Leave Type</label>
                                        <select name="leave_type" id="leave_type" class="form-control">
                                            <option value="" name="leave_type">Please Select</option>
                                            <option value="casual" name="leave_type">Casual Leave</option>
                                            <option value="medical" name="leave_type">Medical Leave</option>
                                            <option value="earn" name="leave_type">Earn Leave</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xs-12 row">

                                    <div class="form-group col-xs-12 col-sm-6">
                                        <label for="start_date" class="col-form-label">Start Date</label>
                                        <input type="date" class="form-control" id="start_date"
                                               name="start_date" value="<?= $from_date ?>">
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-6">
                                        <label for="end_date" class="col-form-label">End Date</label>
                                        <input type="date" class="form-control" id="end_date"
                                               name="end_date" value="<?= $from_date ?>">
                                    </div>

                                </div>

                                <div class="form-group col-xs-12 row">

                                    <div class="form-group col-xs-12 col-sm-6">
                                        <label for="total_day" class="col-form-label">Total Day(s)</label>
                                        <input type="number" min="1" class="form-control" id="total_day"
                                               name="total_day" value="1">
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-6">
                                        <label for="comments" class="col-form-label">Comments</label>
                                        <textarea class="form-control" id="comments" name="comments"
                                                  rows="3" placeholder="Comments"></textarea>
                                    </div>

                                </div>

                                <div class="form-group col-xs-12 row">
                                    <div class="form-group col-xs-12">
                                        <button type="submit" class="btn btn-default save-button">Save</button>
                                    </div>
                                </div>

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

        $("form[name='employee_leave_save_form']").validate({
            rules: {
                employee_id: "required",
                leave_type: "required",
                start_date: "required",
                end_date: "required",
                total_day: "required",
                comments: "required",
            },
            messages: {
                employee_id: "Please Select Employee Name",
                leave_type: "Please Select Leave Type",
                start_date: "Please Select Start Date",
                end_date: "Please Select End Date",
                total_day: "Please Enter Total Day",
                comments: "Please Enter Comments",
            },
            submitHandler: function (form) {
                form.submit();
            }
        });

        //total day calculate from two date
        $('#end_date').change(function () {
            var start_date = $("#start_date").val();
            var end_date = $("#end_date").val();
            var from = moment(start_date, 'YYYY-MM-DD'); // format in which you have the date
            var to = moment(end_date, 'YYYY-MM-DD');     // format in which you have the date
            /* using diff */
            var difference = to.diff(from, 'days');
            var duration = difference + 1;
            /* show the result */
            $('#total_day').val(duration);
        });

        $('#start_date').change(function () {
            var start_date = $("#start_date").val();
            var end_date = $("#end_date").val();
            var from = moment(start_date, 'YYYY-MM-DD'); // format in which you have the date
            var to = moment(end_date, 'YYYY-MM-DD');     // format in which you have the date
            /* using diff */
            var difference = to.diff(from, 'days');
            var duration = difference + 1;
            /* show the result */
            $('#total_day').val(duration);
        });

    });

</script>
