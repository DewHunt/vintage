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
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4 class="">Update Outlet</h4></div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                    <a href="<?= base_url('branch') ?>" class="btn btn-primary"><i class="fa fa-hand-o-left" aria-hidden="true"></i> Go Back</a>
                </div>
            </div>
            
        </div>
        <div class="panel-body">
            <form id="create_new_branch_form" name="create_new_branch_form" action="<?= base_url('branch/update') ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" class="form-control" id="id" name="id" value="<?= $branch->id ?>">

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <?php if (!empty($this->session->flashdata('name_exists_message'))) { ?>
                            <div class="form-group row">
                                <label for="" class="col-sm-2 col-xs-12 col-form-label"></label>

                                <div class="col-sm-10 col-xs-12 error-message">
                                    <?= $this->session->flashdata('name_exists_message'); ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="branch_name">Outlet Name</label>
                            <input type="text" class="form-control" id="branch_name" name="branch_name" value="<?= $branch->branch_name ?>" placeholder="Outlet Name">
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="branch_code">Outlet Code</label>
                            <input type="text" class="form-control" id="branch_code" name="branch_code" value="<?= $branch->branch_code ?>" placeholder="Outlet Code">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="mobile">Mobile</label>
                            <input type="text" class="form-control" id="mobile" name="mobile" value="<?= $branch->mobile ?>" placeholder="mobile Number">
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="vat-ragistration">VAT Registration Number</label>
                            <input type="text" class="form-control" id="vatReg" name="vatReg" value="<?= $branch->vat_reg ?>" placeholder="Phone Number">
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="logo">Logo</label>
                            <input type="file" class="form-control" id="logo" name="logo" value="" placeholder="Upload Less Than 100kb Image">
                        </div>
                    </div>
                    
                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 text-center">
                        <img width="100px" height="100px" src="<?= base_url($branch->logo) ?>" style=" border: 1px solid #ccc;">
                        <input type="hidden" class="form-control" id="previousLogo" name="previousLogo" value="<?= $branch->logo ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" rows="2" id="address" name="address" placeholder="Address"><?= $branch->address ?></textarea>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="footer-text">Footer Text</label>
                            <textarea class="form-control" rows="2" id="footerText" name="footerText" placeholder="Footer Text"><?= $branch->footer_text ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <?php if (empty($isHotKitchen)): ?>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label class="checkbox-inline">
                                <input type="checkbox" value="yes" id="hotKitchen" <?= $branch->hot_kitchen_status == 1 ? 'checked' : ''; ?>>Hot Kitchen
                                <input type="hidden" value=" <?= $branch->hot_kitchen_status == 1 ? '1' : 0; ?>" id="hotKitchenStatus" name="hotKitchenStatus">
                            </label>
                            <div class="form-group" id="branch-block" style="display: <?= $branch->hot_kitchen_status == 1 ? 'block' : 'none'; ?>;">
                                <select class="form-control select2" id="branch" name="branch[]" multiple>
                                    <?php $branch_array = explode(',', $branch->assigned_branches); ?>
                                    <?php foreach ($assignedBranchList as $assignedBranch): ?>
                                        <?php
                                            if (in_array($assignedBranch->id,$branch_array)) {
                                                $select = "selected";
                                            } else {
                                                $select = "";
                                            }                                        
                                        ?>
                                        <option value="<?= $assignedBranch->id ?>" <?= $select ?>><?= $assignedBranch->branch_name ?></option>
                                    <?php endforeach ?>
                                </select>  
                            </div>
                        </div>
                    <?php endif ?>

                    <div class="<?= empty($isHotKitchen) ? 'col-lg-4 col-md-4' : 'col-lg-6 col-md-6' ?> col-sm-12 col-xs-12">
                        <label class="checkbox-inline">
                            <input type="hidden" value="0" id="isFactory" name="isFactory">
                            <input type="checkbox" value="1" id="isFactory" name="isFactory" <?= $branch->factory_status == 1 ? 'checked' : '' ?>>Is Factory
                        </label>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <label>Business Type</label>
                        <div class="form-group">
                            <label class="radio-inline"><input type="radio" name="businessType" value="0" <?= $branch->business_type == 0 ? 'checked' : '' ?>>Table Number</label>
                            <label class="radio-inline"><input type="radio" name="businessType" value="1" <?= $branch->business_type == 1 ? 'checked' : '' ?>>Token Number</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                        <div class="form-group">
                            <?php if (get_menu_permission('outlet_access')): ?>
                                <a onclick="return delete_confirm();" href="<?= base_url("branch/delete/$branch->id") ?>" class="btn btn-danger">Delete</a>
                            <?php endif ?>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.panel-body -->
    </div>
</div>
<!-- /#page-wrapper -->

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

        $("form[name='create_new_branch_form']").validate({
            rules: {
                branch_name: "required"
            },
            messages: {
                branch_name: "Please Enter Outlet Name"
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });

    function delete_confirm() {
        var delete_confirmation_message = confirm("Are you sure to delete permanently?");
        if (delete_confirmation_message != true) {
            return false;
        }
    }
</script>


