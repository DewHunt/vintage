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
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <form id="update_my_profile_form" name="update_my_profile_form" action="<?= base_url('user_login/update') ?>" method="post" enctype="multipart/form-data">
                                <?php if (!empty($this->session->flashdata('update_successful_message'))) { ?>
                                    <div class="form-group row">
                                        <div class="col-xs-12 form-group row success-message text-align-center">
                                            <?= $this->session->flashdata('update_successful_message') ?>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if (!empty($this->session->flashdata('name_error_message'))) { ?>
                                    <div class="form-group row">
                                        <div class="col-xs-12 form-group row error-message text-align-center">
                                            <?= $this->session->flashdata('name_error_message') ?>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if (!empty($this->session->flashdata('user_name_error_message'))) { ?>
                                    <div class="form-group row">
                                        <div class="col-xs-12 form-group row error-message text-align-center">
                                            <?= $this->session->flashdata('user_name_error_message') ?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if (!empty($this->session->flashdata('user_type_error_message'))) { ?>
                                    <div class="form-group row">
                                        <div class="col-xs-12 form-group row error-message text-align-center">
                                            <?= $this->session->flashdata('user_type_error_message') ?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if (!empty($this->session->flashdata('email_error_message'))) { ?>
                                    <div class="form-group row">
                                        <div class="col-xs-12 form-group row error-message text-align-center">
                                            <?= $this->session->flashdata('email_error_message') ?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if (!empty($this->session->flashdata('mobile_error_message'))) { ?>
                                    <div class="form-group row">
                                        <div class="col-xs-12 form-group row error-message text-align-center">
                                            <?= $this->session->flashdata('mobile_error_message') ?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if (!empty($this->session->flashdata('address_error_message'))) { ?>
                                    <div class="form-group row">
                                        <div class="col-xs-12 form-group row error-message text-align-center">
                                            <?= $this->session->flashdata('address_error_message') ?>
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
                                <?php if (!empty($this->session->flashdata('image_upload_error_message'))) { ?>
                                    <div class="form-group row">
                                        <div class="col-xs-12 form-group row error-message text-align-center">
                                            <?= $this->session->flashdata('image_upload_error_message') ?>
                                        </div>
                                    </div>
                                <?php } ?>

                                <input type="hidden" class="form-control" id="id" name="id" value="<?= $user->id ?>">

                                <input type="hidden" class="form-control" id="employee_id" name="employee_id" value="<?= $user->employee_id ?>">
                                <div class="col-xs-12 row">
                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="name" class="col-form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" value="<?= ucfirst($user->name) ?>" placeholder="Name" readonly="readonly">
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="user_name" class="col-form-label">User Name</label>
                                        <input type="text" class="form-control" id="user_name" name="user_name" value="<?= $user->user_name ?>" placeholder="User Name" readonly="readonly">
                                    </div>
                                </div>
                                <div class="col-xs-12 row">
                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="user_type" class="col-form-label">User Type</label>
                                        <input type="text" class="form-control" id="user_type" name="user_type" value="<?= ucfirst($user->user_type) ?>" placeholder="User Type" readonly="readonly">
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="email" class="col-form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?= $user->email ?>" placeholder="Email Address">
                                    </div>
                                </div>
                                <div class="col-xs-12 row">
                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="mobile" class="col-form-label">Mobile</label>
                                        <input type="text" class="form-control" id="mobile" name="mobile" value="<?= $user->mobile ?>" placeholder="Mobile">
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="address" class="col-form-label">Address</label>
<!--                                        <input type="text" class="form-control" id="address" name="address" value="<?= $user->address ?>" placeholder="Address">-->
                                        <textarea class="form-control" id="address" name="address" rows="2" placeholder="Address"><?= $user->address ?></textarea>
                                    </div>
                                </div>
                                <div class="col-xs-12 row">
                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="card" style=" height: 300px; width: 300px; padding-top: 5px">
                                                <img style="margin-left: 10%" height="100px" width="150px" id="employee-image" src="<?= !empty($employee_information->employee_image) ? base_url($employee_information->employee_image) : get_default_employee_image() ?>" alt="image">
                                                <br><span class="error error-message image-size-error-section"></span>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <span class="">
                                                <i class="fa fa-upload"></i>
                                                <span>Upload Employee Image</span>
                                                <input style="width: 80%" class="btn btn-success" type="file" name="image" id="image" onchange="readURL(this)"  >
                                            </span>
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
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

        $('#image').on("click", function () {
            $('.image-size-error-section').text('');
            $('#employee-image').attr('src', '');
        });

        $('#image').on("change", function () {
            var file_size = $('#image')[0].files[0].size;
            if (file_size > (100 * 1024)) {
                var error_message = 'Maximum Image Size: 100 KB';
                $('.image-size-error-section').text(error_message);
            }
        });

        $("form[name='update_my_profile_form']").validate({
            rules: {
                name: "required",
                user_name: "required",
                user_type: "required",
                mobile: "required",
                address: "required",

                email: {
                    required: true,
                    email: true,
                },
            },
            messages: {
                name: "Please Enter Name",
                user_name: "Please Enter User Name",
                user_type: "Please Select User Type",
                mobile: "Please Enter Mobile Number",
                address: "Please Enter Address",
                email: {
                    required: "Please Provide Email Address",
                    email: "Enter A Valid Email Address",
                },
            },
            submitHandler: function (form) {
                var file_size = $('#image')[0].files[0].size;
                if (file_size > (100 * 1024)) {
                    var error_message = 'Maximum Image Size: 100 KB';
                    $('.image-size-error-section').text(error_message);
                    return false;
                } else {
                    form.submit();
                }
            }
        });
    });
</script>

<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#employee-image').addClass('image-preview');
                $('#employee-image').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            $('#employee-image').attr('src', '');
        }
    }
</script>