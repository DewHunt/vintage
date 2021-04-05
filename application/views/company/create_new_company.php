<div id="page-wrapper">
    <?php
    $default_company_logo = base_url('assets/uploads/company_logo/no_company_logo.png');
    ?>

    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6"><h4 class="">Create Company Information</h4></div>
                        <div class="col-md-6 text-right">
                            <a href="<?= base_url("company/") ?>" class="btn btn-primary">
                                <i class="fa fa-reply-all" aria-hidden="true"></i> Go Back
                            </a>
                        </div>
                    </div>                    
                </div>
                <div class="panel-body">
                    <div class="error" style="color: red">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <form id="create_new_company_form" name="create_new_company_form" action="<?= base_url('company/save_company') ?>" method="post" enctype="multipart/form-data">

                                <?php if (!empty($this->session->flashdata('image_upload_error_message'))) { ?>
                                    <div class="error error-message text-align-center">
                                        <?php echo $this->session->flashdata('image_upload_error_message'); ?>
                                    </div>
                                <?php }
                                ?>
                                <div class="row">
                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="company_name_1" class="col-form-label">Company Name 1</label>
                                        <input type="text" class="form-control" id="company_name_1" name="company_name_1" value="" placeholder="Company Name 1">
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="company_name_2" class="col-form-label">Company Name 2</label>
                                        <input type="text" class="form-control" id="company_name_2" name="company_name_2" value="" placeholder="Company Name 2">
                                    </div>

                                </div>

                                <div class="row">
                                    <?php if (!empty($this->session->flashdata('name_exists_message'))) { ?>
                                        <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 error-message">
                                            <label for="" class="col-form-label"></label>
                                            <?= $this->session->flashdata('name_exists_message'); ?>
                                        </div>
                                    <?php } ?>
                                </div>

                                <div class="row">
                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="company_address_1" class="col-form-label">Company address 1</label>
                                        <textarea class="form-control" id="company_address_1" name="company_address_1" rows="3" placeholder="Company address 1"></textarea>
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="company_address_2" class="col-form-label">Company address 2</label>
                                        <textarea class="form-control" id="company_address_2" name="company_address_2" rows="3" placeholder="Company address 2"></textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                        <label for="mobile" class="col-form-label">Mobile</label>
                                        <input type="text" class="form-control" id="mobile" name="mobile" value="" placeholder="Mobile">
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                        <label for="phone" class="col-form-label">Phone</label>
                                        <input type="text" class="form-control" id="phone" name="phone" value="" placeholder="Phone">
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                        <label for="fax" class="col-form-label">Fax</label>
                                        <input type="text" class="form-control" id="fax" name="fax" value="" placeholder="Fax">
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="form-group col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                        <label for="email" class="col-form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="" placeholder="Email">
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                        <label for="website" class="col-form-label">Website</label>
                                        <input type="text" class="form-control" id="website" name="website" value="" placeholder="Website">
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                        <label for="website" class="col-form-label">Button Background</label>
                                        <div class="form-group">
                                            <input type="hidden" name="buttonBackground" value="">
                                            <label class="radio-inline">
                                                <input type="radio" name="buttonBackground" value="image">Show Image
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="buttonBackground" value="color">Only Color
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                        <label for="category-name" class="col-form-label">Category Name</label>
                                        <div class="form-group">
                                            <input type="hidden" name="categoryName" value="0">
                                            <label class="checkbox-inline"><input name="categoryName" type="checkbox" value="1">Show</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                        <span class="form-group">
                                            <label>Upload Company Logo</label>
                                            <input class="form-control" type="file" name="image" id="image" onload="readURL(this)"  >
                                            <span class="error error-message image-size-error-section"></span>
                                        </span>
                                    </div>

                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" style="padding-top: 15px;">
                                        <img width="50px" height="50px" id="company-logo" src="<?= !empty($default_company_logo) ? $default_company_logo : '' ?>" alt="logo">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-xs-12 col-sm-4 col-md-12 col-lg-12">
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
        $('#image').on("click", function () {
            $('.image-size-error-section').text('');
            $('#company-logo').attr('src', '');
        });

        $('#image').on("change", function () {
            var file_size = $('#image')[0].files[0].size;
            if (file_size > (100 * 1024)) {
                var error_message = 'Maximum Image Size: 100 KB';
                $('.image-size-error-section').text(error_message);
            }
        });

        $("form[name='create_new_company_form']").validate({
            rules: {
                company_name_1: "required",
            },
            messages: {
                company_name_1: "Please Enter Company Name 1",
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

<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#company-logo').addClass('image-preview');
                $('#company-logo').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            $('#company-logo').attr('src', '');
        }
    }
</script>
