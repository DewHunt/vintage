<div id="page-wrapper">
    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Update My Information</h4>
                </div>
                <div class="panel-body">
                    <div class="error" style="color: red">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="row">
                        <?php $this->load->view('user/user_profile_tab', $this->data); ?>
                    </div>
                    <div class="col-md-8 col-md-offset-2">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <form id="update_my_password_form" name="update_my_password_form" action="<?= base_url('user_login/update_password') ?>" method="post" enctype="multipart/form-data">

                                <?php if (!empty($this->session->flashdata('update_successful_message'))) { ?>
                                    <div class="form-group row">
                                        <div class="col-xs-12 form-group row success-message text-align-center">
                                            <?= $this->session->flashdata('update_successful_message') ?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if (!empty($this->session->flashdata('password_confirm_error_message'))) { ?>
                                    <div class="form-group row">
                                        <div class="col-xs-12 form-group row error-message text-align-center">
                                            <?= $this->session->flashdata('password_confirm_error_message') ?>
                                        </div>
                                    </div>
                                <?php } ?>

                                <input type="hidden" class="form-control" id="id" name="id" value="<?= !empty($user->id) ? intval($user->id) : 0; ?>">

                                <input type="hidden" class="form-control" id="employee_id" name="employee_id" value="<?= !empty($user->employee_id) ? intval($user->employee_id) : 0; ?>">
                                <div class="col-xs-12 row">
                                    <div class="form-group col-xs-12">
                                        <label for="password" class="col-form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" value="" placeholder="*****" required>
                                    </div>

                                    <div class="form-group col-xs-12">
                                        <label for="confirm_password" class="col-form-label">Confirm Password</label>
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" value="" placeholder="*****" required>
                                    </div>
                                </div>
                                <div class="col-xs-12 row">
                                    <div class="form-group col-xs-12">
                                        <button type="submit" class="btn btn-default save-button">Update</button>
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


<script type="text/javascript">
    $(document).ready(function () {

        $("form[name='update_my_password_form']").validate({
            rules: {
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
                form.submit();
            }
        });
    });
</script>