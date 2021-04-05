<div id="page-wrapper">
    <?php
    $user_type_list;
    $password_confirm_error_message = $this->session->flashdata('password_confirm_error_message');
    $user_name_error_message = $this->session->flashdata('user_name_error_message');
    $email_error_message = $this->session->flashdata('email_error_message');
    $user_type_error_message = $this->session->flashdata('user_type_error_message');
    ?>
    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4 class="">Create New User</h4></div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <?php echo anchor(base_url('user'), '<i class=" fa fa-reply-all" aria-hidden="true"></i> Go Back', 'class="btn btn-primary create-new-button"') ?>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="error" style="color: red">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <form id="create_new_user_form" name="create_new_user_form" action="<?= base_url('user/save_user') ?>" method="post">

                                <?php if (!empty($this->session->flashdata('employee_id_exists_error_message'))) { ?>
                                    <div class="col-xs-12 form-group row error-message text-align-center">
                                        <?php echo $this->session->flashdata('employee_id_exists_error_message'); ?>
                                    </div>
                                <?php } ?>

                                <div class="form-group row">

                                    <!-- <label for="name" class="col-sm-2 col-xs-12 col-form-label">Name</label>
                                     <div class="col-sm-4 col-xs-12">
                                         <input type="text" class="form-control" id="name" name="name"
                                                value="" placeholder="Full Name">
                                     </div>-->

                                    <label for="employee_id" class="col-sm-2 col-xs-12 col-form-label">Employee</label>

                                    <div class="col-sm-10 col-xs-12">
                                        <select name="employee_id" id="employee_id" class="form-control">
                                            <option value="" name="employee_id">Please Select</option>
                                            <?php foreach ($employee_list as $employee) { ?>
                                                <option value="<?= $employee->id ?>" name="employee_id"><?= ucfirst($employee->employee_name) ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                </div>

                                <?php if (!empty($this->session->flashdata('employee_id_error_message'))) { ?>
                                    <div class="form-group row">
                                        <label for="" class="col-sm-2 col-xs-12 col-form-label"></label>
                                        <div class="col-sm-10 col-xs-12 error-message">
                                            <?php echo $this->session->flashdata('employee_id_error_message'); ?>
                                        </div>
                                    </div>
                                <?php } ?>

                                <div class="form-group row">
                                    <label for="user_name" class="col-sm-2 col-xs-12 col-form-label">User Name</label>
                                    <div class="col-sm-10 col-xs-12">
                                        <input type="text" class="form-control" id="user_name" name="user_name"
                                               value="" placeholder="User Name">
                                    </div>
                                </div>

                                <?php if (!empty($user_name_error_message)) { ?>
                                    <div class="form-group row">
                                        <label for="" class="col-sm-2 col-xs-12 col-form-label"></label>
                                        <div class="col-sm-10 col-xs-12 error-message">
                                            <?= $user_name_error_message ?>
                                        </div>
                                    </div>
                                <?php } ?>

                                <div class="form-group row">
                                    <label for="user_type" class="col-sm-2 col-xs-12 col-form-label">User Type</label>
                                    <div class="col-sm-10 col-xs-12">
                                        <select name="user_type" id="user_type" class="form-control select2">
                                            <option value="" name="user_type">Select User Type</option>
                                            <?php foreach ($user_type_list as $user_type) { ?>
                                                <option value="<?= $user_type->user_type ?>" name="user_type">
                                                    <?= ucwords($user_type->user_type) ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="outlet" class="col-sm-2 col-xs-12 col-form-label">Outlet</label>
                                    <div class="col-sm-10 col-xs-12">
                                        <select name="outlet[]" id="outlet" class="form-control select2 select2-multiple" multiple>
                                            <?php foreach ($outlet_list as $outlet) { ?>
                                                <option value="<?= $outlet->id ?>"><?= ucwords($outlet->branch_name) ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <?php if (!empty($user_type_error_message)) { ?>
                                    <div class="form-group row">
                                        <label for="" class="col-sm-2 col-xs-12 col-form-label"></label>
                                        <div class="col-sm-10 col-xs-12 error-message">
                                            <?= $user_type_error_message ?>
                                        </div>
                                    </div>
                                <?php } ?>

                                <!--<div class="form-group row">
                                    <label for="email" class="col-sm-2 col-xs-12 col-form-label">Email</label>

                                    <div class="col-sm-10 col-xs-12">
                                        <input type="email" class="form-control" id="email" name="email"
                                               value="" placeholder="Email Address">
                                    </div>
                                </div>

                                <?php /* if (!empty($email_error_message)) { */ ?>
                                    <div class="form-group row">
                                        <label for="" class="col-sm-2 col-xs-12 col-form-label"></label>

                                        <div class="col-sm-10 col-xs-12 error-message">
                                            <? /*= $email_error_message */ ?>
                                        </div>
                                    </div>
                                --><?php /* } */ ?>

                                <!--<div class="form-group row">
                                    <label for="mobile" class="col-sm-2 col-xs-12 col-form-label">Mobile</label>

                                    <div class="col-sm-10 col-xs-12">
                                        <input type="text" class="form-control" id="mobile" name="mobile"
                                               value="" placeholder="Mobile">
                                    </div>
                                </div>-->

                                <!--<div class="form-group row">
                                    <label for="address" class="col-sm-2 col-xs-12 col-form-label">Address</label>

                                    <div class="col-sm-10 col-xs-12">
                                        <textarea class="form-control" id="address" name="address" rows="2"
                                                  placeholder="Address"></textarea>
                                    </div>
                                </div>-->

                                <div class="form-group row">
                                    <label for="password" class="col-sm-2 col-xs-12 col-form-label">Password</label>
                                    <div class="col-sm-10 col-xs-12">
                                        <input type="password" class="form-control" id="password" name="password" value="" placeholder="*****">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="confirm_password" class="col-sm-2 col-xs-12 col-form-label">Confirm Password</label>

                                    <div class="col-sm-10 col-xs-12">
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" value="" placeholder="*****">
                                    </div>
                                </div>

                                <?php if (!empty($password_confirm_error_message)) { ?>
                                    <div class="form-group row">
                                        <label for="" class="col-sm-2 col-xs-12 col-form-label"></label>
                                        <div class="col-sm-10 col-xs-12 error-message">
                                            <?= $password_confirm_error_message ?>
                                        </div>
                                    </div>
                                <?php } ?>

                                <div class="form-group row">
                                    <div class="col-sm-12 col-xs-12 user_permissions">
                                        <table border="0px solid white" width="100%">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" class="form-check-input" name="hr_access" id="hr_access" value="hr_access">Hr Access
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" class="form-check-input left-margin-twelve" name="sales_access" id="sales_access" value="sales_access">Sales Access
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" class="form-check-input" name="product_access" id="product_access" value="product_access">Product Access
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" class="form-check-input left-margin-twelve" name="user_access" id="user_access" value="user_access">User Access
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" class="form-check-input" name="hr_report_access" id="hr_report_access" value="hr_report_access">HR Report Access
                                                        </label>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" class="form-check-input" name="sales_report_access" id="sales_report_access" value="sales_report_access">Sales Report Access
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" class="form-check-input" name="product_report_access" id="product_report_access" value="product_report_access">Product Report Access
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" class="form-check-input" name="client_access" id="client_access" value="client_access">Client Access
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" class="form-check-input left-margin-twelve" name="settings_access" id="settings_access" value="settings_access"> Settings Access
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" class="form-check-input" name="lock_access" id="lock_access" value="lock_access">Lock Access
                                                        </label>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" class="form-check-input" name="edit_invoice_access" id="edit_invoice_access" value="edit_invoice_access">Edit Invoice Access
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" class="form-check-input" name="kitchen_room_access" id="kitchen_room_access" value="kitchen_room_access">Kitchen Room Access
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" class="form-check-input" name="invoice_discount_access" id="invoice_discount_access" value="invoice_discount_access">Invoice Discount Access
                                                        </label>
                                                    </td>
                                                </tr>

                                                <!-- <tr>
                                                    <td>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" class="form-check-input left-margin-twelve" name="accounts_access" id="accounts_access" value="accounts_access">Accounts Access
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" class="form-check-input" name="accounts_report_access" id="accounts_report_access" value="accounts_report_access">Accounts Report Access
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" class="form-check-input" name="money_receipt_report_access" id="money_receipt_report_access" value="money_receipt_report_access">Money Receipt Report Access
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" class="form-check-input" name="print_access" id="print_access" value="print_access">Print Access
                                                        </label>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" class="form-check-input" name="edit_mr_access" id="edit_mr_access" value="edit_mr_access">Edit MR Access
                                                        </label>
                                                    </td>

                                                    <td colspan="3">
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" class="form-check-input" name="order_sheet_access" id="order_sheet_access" value="order_sheet_access">Order Sheet Access
                                                        </label>
                                                    </td>
                                                </tr> -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-12 col-xs-12 form-group">
                                        <button type="submit" class="btn btn-default save-button">Save</button>
                                         <a type="button" href="<?= base_url('user'); ?>" class="btn btn-danger cancel-button">Cancel</a>
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
    $('#user_type').change(function () {
        var userType = $("#user_type").val();

        if (userType == 'admin'|| userType == 'hr') {
            $('#outlet').select2('destroy').find('option').prop('selected', 'selected').end().select2();
        }
        else {
            $('#outlet').select2('destroy').find('option').prop('selected', false).end().select2();
        }
    });

    $(document).ready(function () {

        $("form[name='create_new_user_form']").validate({
            rules: {
                //name: "required",
                user_name: "required",
                user_type: "required",
                // mobile: "required",
                //address: "required",
                employee_id: "required",

                /*email: {
                 required: true,
                 email: true,
                 },*/
                password: {
                    required: true,
                    minlength: 5,
                },
                confirm_password: {
                    required: true,
                    minlength: 5,
                    equalTo: '#password',
                }
            },
            messages: {
                //name: "Please Enter Name",
                user_name: "Please Enter User Name",
                user_type: "Please Select User type",
                //mobile: "Please Enter Mobile Number",
                //address: "Please Enter Address",
                employee_id: "Please Select Employee",
                /*email: {
                 required: "Please Provide Email Address",
                 email: "Enter a Valid Email Address",
                 },*/
                password: {
                    required: "Please provide a password",
                    minlength: "Password must be at least 5 characters long",
                },
                confirm_password: {
                    required: "Please provide a confirm password",
                    minlength: "Your password must be at least 5 characters long",
                    equalTo: "Password doest not match",
                }
            },
            submitHandler: function (form) {
                var result = confirm('Do you want to Create new user ?');
                if (result == true) {
                    form.submit();
                } else {

                }
            }
        });
    });
</script>