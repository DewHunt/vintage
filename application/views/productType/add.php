<div id="page-wrapper">
    <?php if (!empty($this->session->flashdata('successMessage'))) { ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Success!</strong> <?= $this->session->flashdata('successMessage') ?>
        </div>
    <?php } ?>

    <?php if (!empty($this->session->flashdata('error'))) { ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Opps!</strong> <?= $this->session->flashdata('error') ?>
        </div>
    <?php } ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-6"><h4 class="">Create Category</h4></div>
                <div class="col-md-6">
                    <!-- <div class="create-new-button"> -->
                    <?php echo anchor(base_url('product_type'), '<i class="fa fa-hand-o-left" aria-hidden="true"></i> Go Back', 'class="btn btn-primary create-new-button"') ?>
                    <!-- </div> -->
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="error" style="color: red">
                <?php echo validation_errors(); ?>
            </div>

            <form id="create_new_branch_form" name="create_new_branch_form" action="<?= base_url('product_type/save') ?>" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <label for="name">Name</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="name" name="name" value="" placeholder="Category Name" required>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <?php $foodTypeArray = array('Food' =>'Food','Non-Food' => 'Non-Food'); ?>
                        <label for="branch_code">Food Type</label>
                        <div class="form-group">
                            <select class="form-control select2" id="foodType" name="foodType" required>
                                <option value="">Select Food Type</option>
                                <?php foreach ($foodTypeArray as $key => $value): ?>
                                    <option value="<?= $key ?>"><?= $value ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <?php $availabilityArray = array('All' =>'All','Outlet' => 'Outlet','Factory' => 'Factory'); ?>
                        <label for="branch_code">Availability</label>
                        <div class="form-group">
                            <select class="form-control select2" id="availability" name="availability" required>
                                <option value="">Select Food Type</option>
                                <?php foreach ($availabilityArray as $key => $value): ?>
                                    <option value="<?= $key ?>"><?= $value ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <label for="assign-printer">Assign Printer</label>
                        <div class="form-group">
                            <select class="form-control select2" id="printerId" name="printerId">
                                <option value="">Select Printer</option>
                                <?php foreach ($allPrinters as $printer): ?>
                                    <option value="<?= $printer->id ?>"><?= $printer->name ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <label for="button-color">Button Color</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="color" name="buttonColor" value="" placeholder="Button Color" readonly>
                        </div>
                    </div>                    
                    
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <label for="sort-order">Sort Order</label>
                        <div class="form-group">
                            <input type="number" min="1" class="form-control" id="sortOrder" name="sortOrder" value="" placeholder="Sort Order">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="product-image">Image</label>
                            <input type="file" class="form-control" name="categoryImage">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-default save-button">Save</button>
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