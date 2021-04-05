<div id="page-wrapper">
    <?php if (!empty($this->session->flashdata('error'))) { ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Opps!</strong> <?= $this->session->flashdata('error') ?>
        </div>
    <?php } ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-6"><h4 class="">Create New Product</h4></div>
                <div class="col-md-6">
                    <?php echo anchor(base_url('product'), '<i class="fa fa-hand-o-left" aria-hidden="true"></i> Go Back', 'class="btn btn-primary create-new-button"') ?>
                </div>
            </div>
        </div>

        <div class="panel-body">
            <div class="error" style="color: red">
                <?php echo validation_errors(); ?>
            </div>

            <form id="create_new_product_form" name="create_new_product_form" action="<?= base_url('product/save_product') ?>" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="product-name" class="col-form-label">Product Name</label> <span class="mendatory">*</span>
                            <input type="text" class="form-control" id="product_name" name="product_name" value="" placeholder="Product Name">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="product-code" class="col-form-label">Product Code</label> <span class="mendatory">*</span>
                            <input type="text" class="form-control" id="product_code" name="product_code" value="" placeholder="Product Code">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <label></label>
                        <div class="form-group">
                            <label class="checkbox-inline">
                                <input type="hidden" value="0" name="hotKitchenStatus">
                                <input type="checkbox" value="1" id="hotKitchenStatus" name="hotKitchenStatus">Hot Kitchen
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="product_type_id" class="col-form-label">Product Type</label> <span class="mendatory">*</span>
                            <select class="form-control select2" id="product_type_id" name="product_type_id">
                                <option value="">Please Select</option>
                                <?php foreach ($product_type_list as $product_type): ?>
                                    <option value="<?= $product_type->id ?>"><?= $product_type->product_type_name ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <?php $availabilityArray = array('All' =>'All','Outlet' => 'Outlet','Factory' => 'Factory'); ?>
                        <label for="branch_code">Availability</label>
                        <div class="form-group">
                            <select class="form-control select2" id="availability" name="availability">
                                <option value="">Select Availability</option>
                                <?php foreach ($availabilityArray as $key => $value): ?>
                                    <option value="<?= $key ?>"><?= $value ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <label for="branch_code">Unit</label>
                        <div class="form-group">
                            <select class="form-control select2" id="unit" name="unit">
                                <option value="">Select Unit</option>
                                <?php foreach ($unitList as $unit): ?>
                                    <option value="<?= $unit->unit_id ?>"><?= $unit->name ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="sort_order" class="col-form-label">Sort Order</label>
                            <input type="number" min="1" class="form-control sort_order" id="sort_order" name="sort_order" value="" placeholder="Sort Order">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="purchase_price" class="col-form-label">Purchase Price</label>
                            <input type="number" min="0" class="form-control" id="purchase_price" name="purchase_price" value="" placeholder="Purchase Price" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="fixed_price" class="col-form-label">Fixed Price</label> <span class="mendatory">*</span>
                            <input type="number" min="0" class="form-control" id="fixed_price" name="fixed_price" value="" placeholder="Fixed Price" >
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="minimum_price" class="col-form-label">Minimum Price</label>
                            <input type="number" min="0" class="form-control" id="minimum_price" name="minimum_price" value="" placeholder="Minimum Price">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="maximum_price" class="col-form-label">Maximum Price</label>
                            <input type="number" min="0" class="form-control" id="maximum_price" name="maximum_price" value="" placeholder="Maximum Price">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="product-image">Image</label>
                            <input type="file" class="form-control" name="productImage">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <button style="margin-top: 20px;" type="submit" class="btn btn-default save-button">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.panel-body -->
    </div>
</div>
<!-- /#page-wrapper -->

<!-- <script>
    $(document).ready(function () {
        $("form[name='create_new_product_form']").validate({
            rules: {
                product_name: "required",
                product_code: "required",
                minimum_price: "required",
                maximum_price: "required",
                fixed_price: "required",
                purchase_price: "required",
                product_type_id: "required",
                // reorder_level: {
                //     required: true,
                //     number: true
                // }
            },
            messages: {
                product_name: "Please Enter Product Name",
                product_code: "Please Enter Product Code",
                minimum_price: "Please Enter Minimum Price",
                maximum_price: "Please Enter Maximum Price",
                fixed_price: "Please Enter Fixed Price",
                purchase_price: "Please Enter Purchase Price",
                product_type_id: "Please Select Product Type",

                // reorder_level: {
                //     required: "Please Enter Reorder Level",
                //     number: "Please Enter Valid Number"
                // }
            },
            submitHandler: function (form) {
                form.submit();
            }
        });

        // $('#minimum_price').change(function () {
        //     var stri = $('#minimum_price').val();
        //     //console.log($.isNumeric(stri)); //returns true if is number
        //     var result = $.isNumeric(stri);
        //     if(result === true){

        //     } else{
        //         alert('Please input a numeric number');
        //     }
        // });

    });
</script> -->