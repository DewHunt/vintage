<div id="page-wrapper">
    <?php if (!empty($this->session->flashdata('successMessage'))) { ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Success!</strong> <?= $this->session->flashdata('successMessage') ?>
        </div>
    <?php } ?>

    <?php if (!empty($this->session->flashdata('errorMessage'))) { ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Opps!</strong> <?= $this->session->flashdata('errorMessage') ?>
        </div>
    <?php } ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-6"><h4 class="">Create Outlet</h4></div>
                <div class="col-md-6 text-right">
                    <a href="<?= base_url('branch') ?>" class="btn btn-primary"><i class="fa fa-hand-o-left" aria-hidden="true"></i> Go Back</a>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="error" style="color: red">
                <?php echo validation_errors(); ?>
            </div>

            <form id="create_new_branch_form" name="create_new_branch_form" action="<?= base_url('branch/save_branch') ?>" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <label for="branch_name">Outlet Name</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="branch_name" name="branch_name" value="" placeholder="Outlet Name">
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <label for="branch_code">Outlet Code</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="branch_code" name="branch_code" value="" placeholder="Outlet Code">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <label for="mobile">Contact Number</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="mobile" name="mobile" value="" placeholder="mobile Number">
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <label for="vat-ragistration">VAT Registration Number</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="vatReg" name="vatReg" value="" placeholder="Phone Number">
                        </div>
                    </div>
                    
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <label for="logo">Logo</label>
                        <div class="form-group">
                            <input type="file" class="form-control" id="logo" name="logo" value="" placeholder="Upload Less Than 1MB Image">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <label for="address">Address</label>
                        <div class="form-group">
                            <textarea class="form-control" rows="2" id="address" name="address" placeholder="Address"></textarea>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <label for="footer-text">Footer Text</label>
                        <div class="form-group">
                            <textarea class="form-control" rows="2" id="footerText" name="footerText" placeholder="Footer Text"></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <label class="checkbox-inline">
                            <input type="checkbox" value="yes" id="hotKitchen">Hot Kitchen
                            <input type="hidden" value="0" id="hotKitchenStatus" name="hotKitchenStatus">
                        </label>
                        <div class="form-group" id="branch-block" style="display: none;">
                            <select class="form-control select2" id="branch" name="branch[]" multiple>
                                <?php foreach ($assignedBranchList as $branch): ?>
                                    <option value="<?= $branch->id ?>"><?= $branch->branch_name ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <label class="checkbox-inline">
                            <input type="hidden" value="0" id="isFactory" name="isFactory">
                            <input type="checkbox" value="1" id="isFactory" name="isFactory">Is Factory
                        </label>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <label>Business Type</label>
                        <div class="form-group">
                            <label class="radio-inline"><input type="radio" name="businessType" value="0" checked>Table Number</label>
                            <label class="radio-inline"><input type="radio" name="businessType" value="1">Token Number</label>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#hotKitchen').click(function(event) {
            if(this.checked) {
                $('#branch-block').css('display','block');
                $('#hotKitchenStatus').val(1);
            }
            else {
                $('#hotKitchenStatus').val(0);
                $('#branch-block').css('display','none');
            }
        });

        // $("form[name='create_new_branch_form']").validate({
        //     rules: {
        //         branch_name: "required"
        //     },
        //     messages: {
        //         branch_name: "Please Enter Outlet Name"
        //     },
        //     submitHandler: function (form) {
        //         form.submit();
        //     }
        // });
    });

    $('#create_new_branch_form').submit(function(event){
        if ($('#branch_name').val() == "") {
            swal('Error!','Please Enter Branch Name','error');
            return false;
        }

        if ($('#mobile').val() == "") {
            swal('Error!','Please Enter Contact Number','error');
            return false;
        }

        if($("#hotKitchen").prop('checked') == true) {
            if ($('#branch').val() == "") {
                swal('Error!','Please Select A Hot kitchen','error');
                return false;
            }
        }
    });
</script>