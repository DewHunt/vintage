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
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4 class="">Add New Supplier</h4></div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                    <a href="<?= base_url('supplier') ?>" class="btn btn-primary"><i class=" fa fa-reply-all" aria-hidden="true"></i> Go Back</a>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <form id="add_form" name="add_form" action="<?= base_url('supplier/save') ?>" method="post" enctype="multipart/form-data">

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="supplier-name">Company/Supplier Name <span class="mendatory">*</span></label>
                            <input type="text" class="form-control" id="supplierName" name="supplierName" value="" placeholder="Company/Supplier Name" required>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="vat-id">VAT ID</label>
                            <input type="text" class="form-control" id="vatId" name="vatId" value="" placeholder="VAT ID">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="supplier-contact-number">Supplier Contact Number <span class="mendatory">*</span></label>
                            <input type="text" class="form-control" id="supplierConatactNumber" name="supplierConatactNumber" value="" placeholder="Supplier Contact Number" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="contact-person-name">Contact Person Name <span class="mendatory">*</span></label>
                            <input type="text" class="form-control" id="contactPersonName" name="contactPersonName" value="" placeholder="Contact Person Name" required>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="contact-person-contact-number">Contact Person Contact Number <span class="mendatory">*</span></label>
                            <input type="text" class="form-control" id="contactPersonConatactNumber" name="contactPersonConatactNumber" value="" placeholder="Contact Person Contact Number" required>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" id="email" name="email" value="" placeholder="Email">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="address">Address <span class="mendatory">*</span></label>
                            <textarea class="form-control" rows="2" id="address" name="address" placeholder="Address" required></textarea>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="remarks">Remarks</label>
                            <textarea class="form-control" rows="2" id="remarks" name="remarks" placeholder="Remarks"></textarea>
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
            <!-- /.row (nested) -->
        </div>
        <!-- /.panel-body -->
    </div>
</div>
<!-- /#page-wrapper -->

<script>
</script>