<div id="page-wrapper">
    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Warning Letter</h4>
                </div>
                <div class="panel-body">
                    <div class="error" style="color: red">
                        <?php echo validation_errors(); ?>
                    </div>
                    <?php if (!empty($this->session->flashdata('warning_letter_save_success_message'))) { ?>
                        <div class="error success-message text-align-center">
                            <?php echo $this->session->flashdata('warning_letter_save_success_message'); ?>
                        </div>
                    <?php }
                    ?>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <form id="warning_letter_form" name="warning_letter_form" action="<?= base_url('hr/warning_letter/warning_letter_save') ?>" method="post">
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
                                                    <label for="warning_date" class="col-sm-2 col-xs-12 col-form-label div-margin-top">Date</label>
                                                    <div class="col-sm-10 col-xs-12">
                                                        <input type="date" class="form-control div-margin-top" id="warning_date" name="warning_date" value="" placeholder="">
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
                                                    <label for="warning_type_id" class="col-sm-2 col-xs-12 col-form-label div-margin-top">Type</label>
                                                    <div class="col-sm-10 col-xs-12">
                                                        <select name="warning_type_id" id="warning_type_id" class="form-control">
                                                            <option value="" name="warning_type_id">Please Select</option>
                                                            <?php foreach ($warning_type_list as $warning_type) { ?>
                                                                <option value="<?= $warning_type->id ?>" name="warning_type"><?= ucfirst($warning_type->warning_type) ?></option>
                                                            <?php } ?>
                                                        </select>
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

                                <label for="warning_details" class="col-sm-2 col-xs-12 col-form-label">Details</label>
                                <div class="form-group row">
                                    <div class="col-xs-12">
                                        <textarea class="form-control" id="warning_details" name="warning_details" rows="3" placeholder="Details"></textarea>
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

        CKEDITOR.replace('warning_details');

        $("#warning_letter_form").validate({
            rules: {
                employee_id: "required",
                warning_date: "required",
                warning_type_id: "required",
                warning_details: "required",
            }
            ,
            messages: {
                employee_id: "Please Select Employee Name",
                warning_date: "Please Select warning Date",
                warning_type_id: "Please Select warning type",
                warning_details: "Please Enter Details",
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
    });
</script>
