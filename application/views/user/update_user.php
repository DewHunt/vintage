<div id="page-wrapper">
    <!-- <div class="row">
         <div class="col-lg-12">
             <h2 class="page-header">Update User Information</h2>
         </div>
     </div>-->

    <?php
    $user_type_list;
    $user;
    $password_confirm_error_message = $this->session->flashdata('password_confirm_error_message');
    $user_name_error_message = $this->session->flashdata('user_name_error_message');
    $email_error_message = $this->session->flashdata('email_error_message');
    $user_type_error_message = $this->session->flashdata('user_type_error_message');
    //$update_successful_message = $this->session->flashdata('update_successful_message');
    $user_id = !empty($user->id) ? intval($user->id) : 0;
    ?>

    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6"><h4 class="">Update User Information</h4></div>
                        <div class="col-md-6">
                            <a href="<?= base_url('user/user_password_change/'.$user_id); ?>" class="btn btn-primary create-new-button">Change Password</a>
                            <?php echo anchor(base_url('user'), '<i class=" fa fa-reply-all" aria-hidden="true"></i> Go Back', 'class="btn btn-primary create-new-button"') ?>
                        </div>
                    </div>  
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                    <div class="error" style="color: red;">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <form id="update_user_form" name="update_user_form" action="<?= base_url('user/update') ?>" method="post">
                                <input type="hidden" class="form-control" id="id" name="id" value="<?= $user_id; ?>">

                                <!--<div class="form-group row">
                                    <label for="name" class="col-sm-2 col-xs-12 col-form-label">Name</label>

                                    <div class="col-sm-10 col-xs-12">
                                        <input type="text" class="form-control" id="name" name="name"
                                               value="<? /*= $user->name */ ?>" placeholder="Full Name">
                                    </div>
                                </div>-->
                                <?php if (!empty($this->session->flashdata('employee_id_exists_error_message'))) { ?>
                                    <div class="col-xs-12 form-group row error-message text-align-center">
                                        <?php echo $this->session->flashdata('employee_id_exists_error_message'); ?>
                                    </div>
                                <?php } ?>

                                <div class="form-group row">
                                    <label for="employee_id" class="col-sm-2 col-xs-12 col-form-label">Employee</label>
                                    <div class="col-sm-10 col-xs-12">
                                        <select name="employee_id" id="employee_id" class="form-control">
                                            <option value="" name="employee_id">Please Select</option>
                                            <?php foreach ($employee_list as $employee) { ?>
                                                <option <?= (!empty($employee_information->id == $employee->id)) ? 'selected="selected"' : '' ?> value="<?= $employee->id ?>" name="employee_id" id="employee_id"><?= ucfirst($employee->employee_name) ?></option>
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
                                        <input type="text" class="form-control" id="user_name" name="user_name" value="<?= $user->user_name ?>" placeholder="User Name" readonly="readonly">
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
                                        <select name="user_type" id="user_type" class="form-control">
                                            <option value="" name="user_type">Please Select</option>
                                            <?php foreach ($user_type_list as $user_type) { ?>
                                                <option <?= (!empty(strtolower($user->user_type) == strtolower($user_type->user_type))) ? 'selected="selected"' : '' ?> value="<?= $user_type->user_type ?>" name="user_type"><?= ucwords($user_type->user_type) ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="outlet" class="col-sm-2 col-xs-12 col-form-label">Outlet</label>
                                    <div class="col-sm-10 col-xs-12">
                                        <?php
                                            if ($user->outlet == 'all') {
                                                $outletArray = [];
                                            } else {
                                                $outletArray = explode(',', $user->outlet);
                                            }
                                        ?>
                                        <select name="outlet[]" id="outlet" class="form-control select2 select2-multiple" multiple>
                                            <?php foreach ($outlet_list as $outlet) { ?>
                                                <?php
                                                    if (in_array($outlet->id,$outletArray)) {
                                                        $select = 'selected';
                                                    } else {
                                                        $select = '';
                                                    }
                                                ?>
                                                <option value="<?= $outlet->id ?>" <?= $user->outlet == 'all' ? 'selected' : $select ?>><?= ucwords($outlet->branch_name) ?></option>
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
                                               value="<? /*= $user->email */ ?>" placeholder="Email Address">
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
                                               value="<? /*= $user->mobile */ ?>" placeholder="Mobile">
                                    </div>
                                </div>-->

                                <!--<div class="form-group row">
                                    <label for="address" class="col-sm-2 col-xs-12 col-form-label">Address</label>

                                    <div class="col-sm-10 col-xs-12">
                                        <input type="text" class="form-control" id="address" name="address"
                                               value="<? /*= $user->address */ ?>" placeholder="Address">
                                    </div>
                                </div>-->


                                <!-- <?php /* if (!empty($update_successful_message)) { */ ?>
                                    <div class="form-group row">
                                        <label for="" class="col-sm-2 col-xs-12 col-form-label"></label>

                                        <div class="col-sm-10 col-xs-12 error-message">
                                            <? /*= $update_successful_message */ ?>
                                        </div>
                                    </div>
                                --><?php /* } */ ?>

                                <div class="form-group row">
                                    <div class="col-sm-12 col-xs-12 user_permissions">
                                        <table border="0px solid white" width="100%" class="">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <label class="checkbox-inline">
                                                        <input type="checkbox" class="form-check-input" name="hr_access" id="hr_access" value="hr_access" <?= !empty($user->hr_access > 0) ? 'checked="checked"' : '' ?>>
                                                            Hr Access</label>
                                                    </td>

                                                    <td>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" class="form-check-input left-margin-twelve" name="sales_access" id="sales_access" value="sales_access" <?= !empty($user->sales_access > 0) ? 'checked="checked"' : '' ?>>Sales Access
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" class="form-check-input" name="product_access" id="product_access" value="product_access" <?= !empty($user->product_access > 0) ? 'checked="checked"' : '' ?>>Product Access
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" class="form-check-input left-margin-twelve" name="user_access" id="user_access" value="user_access" <?= !empty($user->user_access > 0) ? 'checked="checked"' : '' ?>>User Access
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" class="form-check-input" name="hr_report_access" id="hr_report_access" value="hr_report_access" <?= !empty($user->hr_report_access > 0) ? 'checked="checked"' : '' ?>>HR Report Access
                                                        </label>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" class="form-check-input" name="sales_report_access" id="sales_report_access" value="sales_report_access" <?= !empty($user->sales_report_access > 0) ? 'checked="checked"' : '' ?>>Sales Report Access
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" class="form-check-input" name="product_report_access" id="product_report_access" value="product_report_access" <?= !empty($user->product_report_access > 0) ? 'checked="checked"' : '' ?>>Product Report Access
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" class="form-check-input" name="client_access" id="client_access" value="client_access" <?= !empty($user->client_access > 0) ? 'checked="checked"' : '' ?>>Client Access
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" class="form-check-input left-margin-twelve" name="settings_access" id="settings_access" value="settings_access" <?= !empty($user->settings_access > 0) ? 'checked="checked"' : '' ?>>Settings Access
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" class="form-check-input" name="lock_access" id="lock_access" value="lock_access" <?= !empty($user->lock_access > 0) ? 'checked="checked"' : '' ?>>Lock Access
                                                        </label>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" class="form-check-input" name="edit_invoice_access" id="edit_invoice_access" value="edit_invoice_access" <?= !empty($user->edit_invoice_access > 0) ? 'checked="checked"' : '' ?>>Edit Invoice Access
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" class="form-check-input" name="kitchen_room_access" id="kitchen_room_access" value="kitchen_room_access"<?= !empty($user->kitchen_room_access > 0) ? 'checked="checked"' : '' ?>>Kitchen Room Access
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" class="form-check-input" name="invoice_discount_access" id="invoice_discount_access" value="invoice_discount_access"<?= !empty($user->invoice_discount_access > 0) ? 'checked="checked"' : '' ?>>Invoice Discount Access
                                                        </label>
                                                    </td>
                                                </tr>

                                                <!-- <tr>
                                                    <td>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" class="form-check-input left-margin-twelve" name="accounts_access" id="accounts_access" value="accounts_access" <?= !empty($user->accounts_access > 0) ? 'checked="checked"' : '' ?>>Accounts Access
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" class="form-check-input" name="accounts_report_access" id="accounts_report_access" value="accounts_report_access" <?= !empty($user->accounts_report_access > 0) ? 'checked="checked"' : '' ?>>Accounts Report Access
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" class="form-check-input" name="money_receipt_report_access" id="money_receipt_report_access" value="money_receipt_report_access" <?= !empty($user->money_receipt_report_access > 0) ? 'checked="checked"' : '' ?>>Money Receipt Report Access
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" class="form-check-input" name="print_access" id="print_access" value="print_access" <?= !empty($user->print_access > 0) ? 'checked="checked"' : '' ?>>Print Access
                                                        </label>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" class="form-check-input" name="edit_mr_access" id="edit_mr_access" value="edit_mr_access" <?= !empty($user->edit_mr_access > 0) ? 'checked="checked"' : '' ?>>Edit MR Access
                                                        </label>  
                                                    </td>

                                                    <td colspan="3">
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" class="form-check-input" name="order_sheet_access" id="order_sheet_access" value="order_sheet_access" <?= !empty($user->order_sheet_access > 0) ? 'checked="checked"' : '' ?>>Order Sheet Access
                                                        </label>
                                                    </td>
                                                </tr> -->
                                            </tbody>
                                        </table>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-12 col-xs-12 form-group">
                                        <button type="submit" class="btn btn-default save-button">Update</button>
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
        selectAllOption();
    });

    function selectAllOption()
    {
        var userType = $("#user_type").val();
        if (userType == 'admin'|| userType == 'hr') {
            $('#outlet').select2('destroy').find('option').prop('selected', 'selected').end().select2();
        }
        else {
            $('#outlet').select2('destroy').find('option').prop('selected', false).end().select2();
        }
    }

    $(document).ready(function () {
        // selectAllOption();

        $("form[name='update_user_form']").validate({
            rules: {
                //name: "required",
                user_name: "required",
                user_type: "required",
                //mobile: "required",
                //address: "required",
                employee_id: "required",
                /*email: {
                 required: true,
                 email: true,
                 },*/
            },
            messages: {
                // name: "Please Enter Name",
                user_name: "Please Enter User Name",
                user_type: "Please Select User Type",
                //mobile: "Please Enter Mobile Number",
                // address: "Please Enter Address",
                employee_id: "Please Select Employee",
                /*email: {
                 required: "Please Provide Email Address",
                 email: "Enter a Valid Email Address",
                 },*/
            },
            submitHandler: function (form) {
                var result = confirm('Do you want to Update this user ?');
                if (result == true) {
                    form.submit();
                } else {

                }
            }
        });
    });
</script>