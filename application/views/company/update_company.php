<div id="page-wrapper">
    <?php
        $company;
        $default_company_logo = base_url('assets/uploads/company_logo/no_company_logo.png');
    ?>
    <?php if (!empty($this->session->flashdata('error'))) { ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Opps!</strong> <?= $this->session->flashdata('error') ?>
        </div>
    <?php } ?>

    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6"><h4 class="">Update Company Information</h4></div>
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
                            <form id="update_company_form" name="update_company_form" action="<?= base_url('company/update') ?>" method="post" enctype="multipart/form-data">
                                <input type="hidden" class="form-control" id="id" name="id" value="<?= $company->id ?>">

                                <div class="row">
                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="company_name_1" class="col-form-label">Company Name 1</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="company_name_1" name="company_name_1" value="<?= $company->company_name_1 ?>" placeholder="Company Name 1">
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="company_name_2" class="col-form-label">Company Name 2</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="company_name_2" name="company_name_2" value="<?= $company->company_name_2 ?>" placeholder="Company Name 2">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="company_address_1" class="col-form-label">Company address 1</label>
                                        <div class="form-group">
                                            <textarea class="form-control" id="company_address_1" name="company_address_1" rows="3" placeholder="Company address 1"><?= $company->company_address_1 ?></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="company_address_2" class="col-form-label">Company address 2</label>
                                        <div class="form-group">
                                            <textarea class="form-control" id="company_address_2" name="company_address_2" rows="3" placeholder="Company address 2"><?= $company->company_address_2 ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                        <label for="mobile" class="col-form-label">Mobile</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="mobile" name="mobile" value="<?= $company->mobile ?>" placeholder="Mobile">
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                        <label for="phone" class="col-form-label">Phone</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="phone" name="phone" value="<?= $company->phone ?>" placeholder="Phone">
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                        <label for="fax" class="col-form-label">Fax</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="fax" name="fax" value="<?= $company->fax ?>" placeholder="Fax">
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="form-group col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                        <label for="email" class="col-form-label">Email</label>
                                        <div class="form-group">
                                            <input type="email" class="form-control" id="email" name="email" value="<?= $company->email ?>" placeholder="Email">
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                        <label for="website" class="col-form-label">Website</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="website" name="website" value="<?= $company->website ?>" placeholder="Website">
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                        <label for="button-background" class="col-form-label">Button Background</label>
                                        <div class="form-group">
                                            <input type="hidden" name="buttonBackground" value="">
                                            <label class="radio-inline">
                                                <input type="radio" name="buttonBackground" value="image" <?= $company->button_backgound == 'image' ? 'checked' : '' ?>>Show Image
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="buttonBackground" value="color" <?= $company->button_backgound == 'color' ? 'checked' : '' ?>>Only Color
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                        <label for="category-name" class="col-form-label">Category Name</label>
                                        <div class="form-group">
                                            <input type="hidden" name="categoryName" value="0">
                                            <label class="checkbox-inline"><input name="categoryName" type="checkbox" value="1" <?= $company->category_name == 1 ? 'checked' : '' ?>>Show</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label>Upload Company Logo</label>
                                            <input class="form-control" type="file" name="image" id="image" value="" onchange="readURL(this)">
                                            <span class="error error-message image-size-error-section"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" style="padding-top: 15px;">
                                        <img height="50px" width="50px" id="company-logo" src="<?= !empty($company->company_logo) ? base_url($company->company_logo) : $default_company_logo ?>" alt="logo">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12 col-sm-4 col-md-12 col-lg-12">
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

<script>
    $(document).ready(function () {

        $('#image').on("click", function () {
            $('.image-size-error-section').text('');
//            $('#company-logo').attr('src', '');
        });

        $('#image').on("change", function () {
            var file_size = $('#image')[0].files[0].size;
            if (file_size > (100 * 1024)) {
                var error_message = 'Maximum Image Size: 100 KB';
                $('.image-size-error-section').text(error_message);
            }
        });

        $("form[name='update_company_form']").validate({
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