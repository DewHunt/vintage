<div id="page-wrapper">
    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Leave Application</h4>
                </div>
                <div class="panel-body">
                    <div class="error" style="color: red">
                        <?php echo validation_errors(); ?>
                    </div>
                    <?php if (!empty($this->session->flashdata('leave_application_save_success_message'))) { ?>
                        <div class="error success-message text-align-center">
                            <?php echo $this->session->flashdata('leave_application_save_success_message'); ?>
                        </div>
                    <?php }
                    ?>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <form id="leave_application_form" name="leave_application_form" action="<?= base_url('hr/employee_leave/leave_application_save') ?>" method="post">
                                <div class="col-xs-12 row" style="padding-bottom: 2%">
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
                                                    <label for="start_date" class="col-sm-2 col-xs-12 col-form-label div-margin-top">Period</label>
                                                    <div class="col-sm-5 col-xs-12">
                                                        <input type="date" class="form-control" id="start_date" name="start_date" value="" placeholder="">
                                                    </div>
                                                    <div class="col-sm-5 col-xs-12">
                                                        <input type="date" class="form-control" id="end_date" name="end_date" value="" placeholder="">
                                                    </div>
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
                                                    <label for="leave_type" class="col-sm-2 col-xs-12 col-form-label div-margin-top">Type</label>
                                                    <div class="col-sm-4 col-xs-12">
                                                        <select name="leave_type" id="leave_type" class="form-control">
                                                            <option value="" name="leave_type">Please Select</option>
                                                            <option value="casual" name="leave_type">Casual Leave</option>
                                                            <option value="medical" name="leave_type">Medical Leave</option>
                                                            <option value="earn" name="leave_type">Earn Leave</option>
                                                        </select>
                                                    </div>
                                                    <label for="total_day" class="col-sm-3 col-xs-12 col-form-label div-margin-top">Total Day</label>
                                                    <div class="col-sm-3 col-xs-12">
                                                        <input type="number" class="form-control" id="total_day" name="total_day" value="" placeholder="" min="1">
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
                                    <div>
                                        <div class="clearfix"></div>
                                        <div class="text-align-center"><strong><u>When On Leave</u></strong></div>
                                        <table class="" width="100%">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="right-side-view col-xs-12 col-sm-6">
                                                        <label for="contact_no" class="col-sm-2 col-xs-12 col-form-label">Contact</label>
                                                        <div class="col-sm-10 col-xs-12">
                                                            <input type="text" class="form-control" id="contact_no" name="contact_no" value="" placeholder="Contact">
                                                        </div>
                                                    </td>
                                                    <td class="left-side-view col-xs-12 col-sm-6">
                                                        <label for="address" class="col-sm-2 col-xs-12 col-form-label div-margin-top">Address</label>
                                                        <div class="col-sm-10 col-xs-12">
                                                            <textarea class="form-control" id="address" name="address" rows="2" placeholder="Address"></textarea>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                                <label for="leave_details" class="col-sm-2 col-xs-12 col-form-label">Details</label>
                                <div class="form-group row">
                                    <div class="col-xs-12">
                                        <textarea class="form-control" id="leave_details" name="leave_details" rows="3" placeholder="Details"></textarea>
                                    </div>
                                </div>
                                <table class="" style="width:100%">
                                    <tr>
                                        <td width="100%" style="float: right"><button type="submit" class="btn btn-default save-button">Save</button></td>
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

        CKEDITOR.replace('leave_details');

        $("#leave_application_form").validate({
            rules: {
                employee_id: "required",
                start_date: "required",
                end_date: "required",
                leave_type: "required",
                total_day: "required",
                leave_details: "required",
                address: "required",
                contact_no: "required",
            }
            ,
            messages: {
                employee_id: "Please Select Employee",
                start_date: "Please Select start date",
                end_date: "Please Select end date",
                leave_type: "Please Select leave type",
                total_day: "Please enter total day",
                leave_details: "Please Enter Details",
                address: "Please Enter Address",
                contact_no: "Please Enter Contact no",
            }
            ,
            submitHandler: function (form) {
                form.submit();
            }
        });

        $('#employee_id').change(function () {
            var employee_code = $("option[name=employee_id]:selected").attr('employee-code');
            $('#employee_code').val(employee_code);
            var employee_designation = $("option[name=employee_id]:selected").attr('employee-designation');
            $('#designation').val(employee_designation);
            var employee_mobile = $("option[name=employee_id]:selected").attr('employee-mobile');
            $('#mobile').val(employee_mobile);
        });

        //total day calculate from two date
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


    });
</script>
