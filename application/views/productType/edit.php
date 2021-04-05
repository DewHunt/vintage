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
            <strong>Success!</strong> <?= $this->session->flashdata('error') ?>
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

            <form id="create_new_branch_form" name="create_new_branch_form" action="<?= base_url('product_type/update') ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" class="form-control" id="categoryId" name="categoryId" value="<?= $category->id ?>">

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= $category->product_type_name ?>" placeholder="Category Name" required>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <?php
                                $foodTypeArray = array('Food' =>'Food','Non-Food' => 'Non-Food');
                            ?>
                            <label for="branch_code">Food Type</label>
                            <select class="form-control select2" id="foodType" name="foodType" required>
                                <option value="">Select Food Type</option>
                                <?php foreach ($foodTypeArray as $key => $value): ?>
                                    <?php
                                        if ($category->food_type == $key) {
                                            $select = "selected";
                                        }
                                        else {
                                            $select = "";
                                        }                                               
                                    ?>
                                    <option value="<?= $key ?>" <?= $select ?>><?= $value ?></option>
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
                                    <?php
                                        if ($category->availability == $key) {
                                            $select = "selected";
                                        }
                                        else {
                                            $select = "";
                                        }                                               
                                    ?>
                                    <option value="<?= $key ?>" <?= $select ?>><?= $value ?></option>
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
                                    <?php
                                        if ($printer->id == $category->printer_id) {
                                            $select = "selected";
                                        } else {
                                            $select = "";
                                        }
                                        
                                    ?>
                                    <option value="<?= $printer->id ?>" <?= $select ?>><?= $printer->name ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="button-color">Button Color</label>
                            <input type="text" class="form-control" id="color" name="buttonColor" value="<?= $category->button_color ?>" placeholder="Button Color" readonly>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="sort-order">Sort Order</label>
                            <input type="number" min="1" class="form-control" id="sortOrder" name="sortOrder" value="<?= $category->sort_order ?>" placeholder="Sort Order">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="product-image">Image</label>
                            <input type="file" class="form-control" name="categoryImage">
                            <input type="hidden" class="form-control" name="previousCategoryImage" value="<?= $category->image ?>">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="form-group" style="padding-top: 15px;">
                            <img width="50px" height="50px" src="<?= base_url($category->image) ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-default save-button">Update</button>
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
</script>