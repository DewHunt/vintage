<div id="page-wrapper">
    <?php
        $product_list;
        $branch_list;
    ?>

    <?php if (!empty($this->session->flashdata('return_product_table_save_message'))) { ?>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="success-message text-align-center">
                    <?php echo $this->session->flashdata('return_product_table_save_message') ?>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php if (!empty($this->session->flashdata('transfer_branch_error_message'))) { ?>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="error-message text-align-center">
                    <?php echo $this->session->flashdata('transfer_branch_error_message') ?>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php if (!empty($this->session->flashdata('stock_insufficient_message'))) { ?>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="col-xs-12 error-message text-align-center">
                    <?php echo $this->session->flashdata('stock_insufficient_message') ?>
                </div>
            </div>
        </div>
    <?php } ?>

    <div class="panel panel-default">
        <div class="panel-heading">            
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><h4 class=""><h4 class="">Product (Return)</h4></h4></div>
            </div>
        </div>
        <div class="panel-body">
            <div class="error" style="color: red"><?php echo validation_errors(); ?></div>

            <form id="return_product_form" name="return_product_form" action="<?= base_url('return_product/add_return_product_details_in_table') ?>" method="post">
                <div class="row">
                    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                        <label for="product_id">Product</label>
                        <div class="form-group">
                            <select name="product_id" id="product_id" class="form-control">
                                <option value="" name="product_id">Please Select</option>
                                <?php foreach ($product_list as $product) { ?>
                                    <option value="<?= $product->id ?>" product-price="<?= $product->fixed_price ?>" minimum-price="<?= $product->minimum_price ?>" maximum-price="<?= $product->maximum_price ?>" name="product_id">
                                        <?= ucfirst($product->product_name) ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                        <label for="quantity">Quantity</label>
                        <div class="form-group">
                            <input type="number" class="form-control" id="quantity" name="quantity" min="1" value="1" placeholder="">
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                        <label for=""></label>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg" id="add-product-button">Add</button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                        <?php if (!empty($this->session->flashdata('damage_or_defect_product_table_error_message'))) { ?>
                            <div class="col-xs-12 text-align-center error-message">
                                <?php echo $this->session->flashdata('damage_or_defect_product_table_error_message'); ?>
                            </div>
                        <?php } ?>
                    </div>                    
                </div>
            </form>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="return_product_table_block">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="product-table">
                                <thead>
                                    <tr>
                                        <th width="20px">SL</th>
                                        <th>Product Name</th>
                                        <th width="150px">Quantity</th>
                                        <th width="20px">Action</th>
                                    </tr>
                                </thead>

                                <?php $return_product_table_array = $this->session->userdata('return_product_table_array'); ?>

                                <tbody>
                                    <?php $count = 1; ?>
                                    <?php if (!empty($return_product_table_array)): ?>
                                        <?php foreach ($return_product_table_array as $return_product): ?>
                                            <?php
                                                $product_name_part_1 = '';
                                                $product_name_part_2 = '';
                                                if (strpos(($return_product['product_name']), '#') !== FALSE) {
                                                    $product_name = explode("#", ($return_product['product_name']));
                                                    $product_name_part_1 = $product_name[0];
                                                    $product_name_part_2 = $product_name[1];
                                                } else {
                                                    $product_name_part_1 = $return_product['product_name'];
                                                }
                                            ?>
                                            <tr>
                                                <td><?= $count++ ?></td>
                                                <td><?= $product_name_part_1 ?></td>
                                                <td><?= $return_product['quantity'] ?></td>
                                                <td>
                                                    <a href="<?= base_url("return_product/delete_return_product_details_from_table/" . $return_product['array_id']) ?>"
                                                       class="btn btn-danger">
                                                        <i class="fa fa-times" aria-hidden="true"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

            <form id="return_product_save_form" name="return_product_save_form" action="<?= base_url('return_product/return_product_information_save') ?>" method="post">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <label for="from_branch_id">From Outlet</label>
                        <div class="form-group">
                            <select name="from_branch_id" id="from_branch_id" class="form-control">
                                <option value="" name="from_branch_id">Please Select From Outlet</option>
                                <?php foreach ($branch_list as $branch): ?>
                                    <option value="<?= $branch->id ?>" name="from_branch_id"><?= $branch->branch_name ?></option>                                
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <label for="to_branch_id">To Outlet</label>
                        <div class="form-group">
                            <select name="to_branch_id" id="to_branch_id" class="form-control">
                                <option value="" name="to_branch_id" label="Please Select To Outlet">
                                <?php if (!empty($branch_list)): ?>
                                    <?php foreach ($branch_list as $branch): ?>
                                        <option value="<?= $branch->id ?>" name="to_branch_id"><?= $branch->branch_name ?></option>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <label for="return_date">Date</label>
                        <div class="form-group">
                            <input type="date" class="form-control" id="return_date" name="return_date" value="">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label for="reason">Reason</label>
                        <div class="form-group">
                            <textarea class="form-control" id="reason" name="reason" rows="2" placeholder="Reason"></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                        <button type="submit" class="btn btn-primary">Save</button>
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

        $('#return_product_form').validate({
            rules: {
                product_id: "required",
                quantity: "required",
            },
            messages: {
                product_id: "Please Select a Product",
                quantity: "Please Enter Quantity",
            },
            errorElement: "em",
            errorPlacement: function (error, element) {
                // Add the `help-block` class to the error element
                error.addClass("help-block");
                if (element.prop("type") === "checkbox") {
                    error.insertAfter(element.parent("label"));
                } else {
                    error.insertAfter(element);
                }
            },
            highlight: function (element, errorClass, validClass) {
                $(element).parents(".error-message").addClass("has-error").removeClass("has-success");
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).parents(".error-message").addClass("has-success").removeClass("has-error");
            },
            submitHandler: function (form) {
                $.ajax({
                    type: "POST",
                    url: $(form).attr('action'),
                    data: $(form).serialize(),
                    success: function (data) {
                        $('.return_product_table_block').html(data);
                    },
                    error: function (error) {
                        console.log("error occured");
                    }
                });
            }
        });

        $("form[name='return_product_save_form']").validate({
            rules: {
                from_branch_id: "required",
                to_branch_id: "required",
                return_date: "required",
                reason: "required",
            },
            messages: {
                from_branch_id: "Please Select From Outlet",
                to_branch_id: "Please Select To Outlet",
                return_date: "Please Select Date",
                reason: "Please Enter Reason",
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });

</script>
