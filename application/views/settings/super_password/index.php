<div id="page-wrapper">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="">Super Password</h4>
        </div>
        <div class="panel-body">
            <div class="error" style="color: red">
                <?php echo validation_errors(); ?>
            </div>

            <form id="super-password-form" name="super-password-form" action="<?= base_url('settings/super_password/save_super_password') ?>" method="post">
                <input type="hidden" class="form-control" id="id" name="id" value="<?= !empty($company_information) ? intval($company_information->id) : 0; ?>">
                <div class="row">
                    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                        <label for="password">Password</label>
                        <div class="form-group">
                            <input type="password" class="form-control" id="password" name="password" value="" placeholder="*****" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                        <label for="confirm_password">Confirm Password</label>
                        <div class="form-group">
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" value="" placeholder="*****" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                        <label for=""></label>
                        <div class="form-group">
                            <button type="submit" class="btn btn-default save-button"><?= $button_text; ?></button>
                        </div>
                    </div>
                </div>
            </form>
            <!-- /.row (nested) -->
        </div>
        <!-- /.panel-body -->
    </div>
</div>
<!-- /#page-wrapper -->


<script>
    $(document).ready(function () {

        superPasswordAction();
        function superPasswordAction() {
            var thisForm = $("form[name='super-password-form']");
            thisForm.validate({
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
                    var result = confirm('Do you want to Update ?');
                    if (result === true) {
                        $.ajax({
                            type: "POST",
                            url: thisForm.attr('action'),
                            data: thisForm.serialize(),
                            beforeSend: function () { },
                            complete: function () { },
                            success: function (data) {
                                if (data['isUpdate']) {
                                    alert(data['message']);
                                    window.location.href = data['redirectUrl'];
                                } else {
                                    alert(data['message']);
                                    return false;
                                }
                            },
                            error: function () {
                                console.log('Error Occured.');
                            }
                        });
                    } else {

                    }
                }
            });
        }
    });
</script>