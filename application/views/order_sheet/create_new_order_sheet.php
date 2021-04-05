<div id="page-wrapper">
    <!--<div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">Sale Product</h2>
        </div>
    </div>-->

    <?php
    // var_dump($product_table_array);
    ?>

    <div class="col-xs-12 success-message text-align-center">
        <?php
        echo $this->session->flashdata('sale_product_save_successful_message');
        ?>
    </div>

    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Order Sheet</h4>
                </div>
                <div class="panel-body">
                    <div class="row">

                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <?php if (!empty($this->session->flashdata('order_sheet_save_message'))) { ?>
                                <div class="success-message text-align-center">
                                    <?php echo $this->session->flashdata('order_sheet_save_message'); ?>
                                </div>
                            <?php }
                            ?>

                            <div class="product-show-part">

                                <form id="order_sheet_table_form" name="order_sheet_table_form"
                                      action="<?= base_url('order_sheet/add_product_in_order_sheet_table') ?>" method="post">

                                    <div class="error" style="color: red">
                                        <?php echo validation_errors(); ?>
                                    </div>

                                    <div class="form-group col-xs-12">

                                        <div class="form-group row">

                                            <div class="form-group col-xs-12 col-sm-6">
                                                <label for="product_id" class="col-form-label">Product</label>
                                                <select name="product_id" id="product_id" class="form-control">
                                                    <option value="" name="product_id">Please Select</option>
                                                    <?php foreach ($product_list as $product) { ?>
                                                        <option value="<?= $product->id ?>"
                                                                product-price="<?= $product->fixed_price ?>"
                                                                minimum-price="<?= $product->minimum_price ?>"
                                                                maximum-price="<?= $product->maximum_price ?>"
                                                                name="product_id"><?= ucfirst($product->product_name) ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="form-group col-xs-12 col-sm-6">
                                                <label for="quantity" class="col-form-label">Quantity</label>
                                                <input type="number" class="form-control" id="quantity" name="quantity"
                                                       min="1" value="1" placeholder="">
                                            </div>

                                        </div>

                                        <div class="form-group row">

                                            <div class="form-group col-xs-12 col-sm-6">
                                                <label for="unit_price" class="">Unit Price</label>
                                                <!--<label id="unit-price-label" class="error"></label>-->
                                                <input type="text" class="form-control" id="unit_price"
                                                       name="unit_price"
                                                       value="" placeholder="">
                                            </div>

                                            <div class="form-group col-xs-12 col-sm-6">
                                                <button type="submit" class="btn btn-default add-product-button"
                                                        id="add-product-button">Add</button>
                                                <div class="error-message">
                                                    <?php
                                                    if (!empty($this->session->flashdata('order_sheet_table_error_message'))) {
                                                        echo $this->session->flashdata('order_sheet_table_error_message', '');
                                                    }
                                                    ?>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </form>

                                <div class="col-xs-12 order-sheet-table-block">
                                    <?php if (!empty($this->session->userdata('order_sheet_table_array'))) { ?>
                                        <table class="table table-striped table-bordered table-hover"
                                               id="product-table">
                                            <input type="hidden"
                                                   value="<?= $this->session->userdata('order_sheet_total_price') ?>"
                                                   id="total_session_1" name="total_session_1">

                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Unit Price</th>
                                                    <th>Quantity</th>
                                                    <th>Price</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <?php
                                            $order_sheet_table_array_info = $this->session->userdata('order_sheet_table_array');
                                            $order_sheet_total_price_session = $this->session->userdata('order_sheet_total_price');
                                            ?>

                                            <tbody>
                                                <?php foreach ($order_sheet_table_array_info as $product): ?>
                                                    <tr>
                                                        <td><?= $product['product_name'] ?></td>
                                                        <td><?= $product['fixed_price'] ?></td>
                                                        <td><?= $product['quantity'] ?></td>
                                                        <td><?= $product['total_amount'] ?></td>
                                                        <td>
                                                            <a href="<?= base_url("order_sheet/delete_product_in_order_sheet_table/" . $product['array_id']) ?>"
                                                               class="btn btn-danger"><i class="fa fa-times"
                                                                                      aria-hidden="true"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td><strong>Total</strong></td>
                                                    <td id="total_session"><?= $order_sheet_total_price_session ?></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>

                                        </table>
                                        <button class="pull-right btn btn-danger order-sheet-table-clear-button">Clear</button>
                                    <?php } ?>
                                </div>
                            </div>

                            <form id="order-sheet-information-form" action="<?= base_url('order_sheet/order_sheet_information_save') ?>"
                                  method="post">

                                <div class="row">

                                    <div class="form-group col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                        <label for="online_order_sheet_number" class="col-form-label">Online Order Sheet No</label>
                                        <input type="text" class="form-control" id="online_order_sheet_number" name="online_order_sheet_number" placeholder="Online Order Sheet Number" value="<?= $online_order_sheet_number ?>" readonly="readonly">
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                        <label for="issue_date" class="col-form-label">Issue Date</label>
                                        <input type="date" class="form-control" id="issue_date" name="issue_date"
                                               value="<?= $current_date ?>">
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                        <label for="issue_time" class="col-form-label">Order Issue Received Time</label>
                                        <input type="time" class="form-control" id="issue_time" name="issue_time" value="<?= $current_time ?>">
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                        <label for="client_id" class="col-form-label">Client</label>
                                        <select name="client_id" id="client_id" class="form-control">
                                            <option value="" name="client_id" label="Please Select">
                                                <?php foreach ($client_list as $client) { ?>
                                                    <?php if (strtolower($client->client_type) == 'import') { ?>
                                                    <option class="import-type-color"
                                                            value="<?= $client->id ?>"
                                                            name="client_id"><?= $client->client_name ?>
                                                    </option>
                                                <?php } else { ?>
                                                    <option class="lubzone-type-color"
                                                            value="<?= $client->id ?>"
                                                            name="client_id"><?= $client->client_name ?>
                                                    </option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                        <label for="work_order_number" class="col-form-label">Work Order No</label>
                                        <input type="text" class="form-control" id="work_order_number"
                                               name="work_order_number" value=""
                                               placeholder="Work Order Number">
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                        <label for="work_order_date" class="col-form-label">Work Order Date</label>
                                        <input type="date" class="form-control" id="work_order_date"
                                               name="work_order_date" value="<?= $current_date ?>">
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                        <label for="delivery_date" class="col-form-label">Delivery Date</label>
                                        <input type="date" class="form-control" id="delivery_date" name="delivery_date" value="<?= $current_date ?>">
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                        <label for="freight_charge" class="col-form-label">Freight Charge</label>
                                        <input type="text" class="form-control" id="freight_charge" name="freight_charge"  placeholder="Freight Charge">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                        <label for="discount" class="col-form-label">Discount</label>
                                        <input type="text" class="form-control" id="discount" name="discount" placeholder="Discount" value="">
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                        <label for="bonus" class="col-form-label">Bonus</label>
                                        <input type="text" class="form-control" id="bonus" name="bonus" placeholder="Bonus" value="">
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                        <label for="delivery_address" class="col-form-label">Delivery Address</label>
                                        <textarea class="form-control" id="delivery_address" name="delivery_address" rows="2"></textarea>
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                        <label for="remarks" class="col-form-label">Remarks</label>
                                        <textarea class="form-control" id="remarks" name="remarks" rows="2"></textarea>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <button type="submit" class="btn btn-default save-button confirm-button">Confirm
                                    </button>
                                </div>

                            </form>

                        </div>
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

        $('#order_sheet_table_form').validate({
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
                        $('.order-sheet-table-block').show();
                        $('.order-sheet-table-block').html(data);
                    },
                    error: function (error) {
                        console.log("error occured");
                    }
                });
            }
        });

        // change product price according to product
        $('#product_id').change(function () {
            var price = $("option[name=product_id]:selected").attr('product-price');
            $('#unit_price').val(price);
        });

        //set min max value
        $('#product_id').change(function () {
            var minimum_price = $("option[name=product_id]:selected").attr('minimum-price');
            var maximum_price = $("option[name=product_id]:selected").attr('maximum-price');
            $("#unit_price").attr({
                "max": maximum_price,
                "min": minimum_price
            });
        });

        $('#unit_price').change(function () {
            if ($("#unit_price").val() <= 0) {
                var price = $("option[name=product_id]:selected").attr('product-price');
                $('#unit_price').val(price);
            } else {
                var price = $("option[name=product_id]:selected").attr('product-price');
            }
        });

    });

    $('.order-sheet-table-clear-button').click(function () {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("order_sheet/get_order_sheet_table_array_clear/") ?>',
            data: {},
            success: function (data) {
                $('.error-message').hide();
                $('.order-sheet-table-block').hide();
            },
            error: function () {

            }
        });
    });

    $("#order-sheet-information-form").validate({
        // Specify validation rules
        rules: {
            client_id: "required",
        },
        messages: {
            client_id: "Please Enter Client Name",
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

</script>

