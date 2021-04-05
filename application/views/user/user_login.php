<div class="container center-block">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title text-center"><i class="fa fa-sign-in fa-fw"></i>Sign In</h3>
                </div>
                <div class="panel-body">
                    <form id="user_login_form" name="user_login_form" method="post" action="<?= base_url('user_login/login_action') ?>">
                        <fieldset>
                            <div class="form-group">
                                <input type="text" class="form-control" id="user_name_or_email" name="user_name_or_email" placeholder="User Name Or Email Address" value="" autofocus>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="">
                            </div>
                            <!--$login_error_message-->
                            <?php if (!empty($this->session->flashdata('login_error_message'))) { ?>
                                <div class="form-group error-message">
                                    <?php echo $this->session->flashdata('login_error_message'); ?>
                                </div>
                            <?php } ?>
                            <button type="submit" class="btn btn-lg btn-success btn-block">Login</button>
                            <address>
                                <a href="http://giantssoft.com/" target="_blank"><h6 class="address-design">Developed By Giantssoft Solution</h6></a>
                            </address>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#user_login_form").validate({
            rules: {
                user_name_or_email: "required",
                password: "required",
            },
            messages: {
                user_name_or_email: "This field is required.",
                password: "This field is required.",
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });
</script>