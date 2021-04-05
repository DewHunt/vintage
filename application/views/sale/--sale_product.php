<div id="page-wrapper">
    <!--<div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">Sale Product</h2>
        </div>
    </div>-->

    <?php
    // var_dump($product_table_array);
    ?>

    <?php if (!empty($this->session->flashdata('sale_product_save_successful_message'))) { ?>
        <div class="col-xs-12 success-message text-align-center">
            <?php echo $this->session->flashdata('sale_product_save_successful_message'); ?>
        </div>
    <?php }
    ?>

    <?php if (!empty($this->session->flashdata('information_save_error_message'))) { ?>
        <div class="col-xs-12 error-message text-align-center">
            <?php echo $this->session->flashdata('information_save_error_message'); ?>
        </div>
    <?php }
    ?>

    <?php if (!empty($this->session->flashdata('stock_insufficient_message'))) { ?>
        <div class="col-xs-12 error-message text-align-center">
            <?php
            $stock_insufficient_message = $this->session->flashdata('stock_insufficient_message');
            foreach ($stock_insufficient_message as $res) {
                echo $res;
            }
            ?>
        </div>
    <?php }
    ?>

    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Invoice</h4>
                </div>
                <div class="panel-body">
                    <div class="row">

                        <div class="col-lg-12 col-sm-12 col-xs-12">

                            <div class="product-show-part">

                                <form id="sale_product_form" name="sale_product_form"
                                      action="<?= base_url('sale_product/get_data_in_table') ?>" method="post">


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
                                                        id="add-product-button">Add
                                                </button>
                                                <div class="error-message">
                                                    <?php
                                                    if (!empty($this->session->flashdata('product_table_error_message'))) {
                                                        echo $this->session->flashdata('product_table_error_message', '');
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <div class="col-xs-12 product-table-block">
                                    <?php $this->load->view('sale/product_table', $this->data); ?>
                                </div>
                            </div>

                            <div class="text-align-center error-message product-save-error-show-section">

                            </div>

                            <div class="col-xs-12 sale_details_information_block">
                                <?php $this->load->view('sale/sale_details_information_section', $this->data); ?>
                            </div>

                        </div>
                    </div>

                    <div style="float: right">
                        <form class="" id="clear_session" name="clear_session" method="post"
                              action="<?= base_url('sale_product/clear_sale_product_table_session') ?>">
                            <button type="submit" class="btn btn-default  add-product-button cancel-button-color"
                                    id="add-product-button">Clear
                            </button>
                        </form>
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
        
        sale_invoice_form(); // validation
        
        delete_single_product_from_table();
        
        function sale_invoice_form() {
            $('#sale_product_form').validate({
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
                            $('.product-table-block').html(data['product_table_data']);
                            var total_amount_data = data['total_amount_data'];
                            var total_extra_amount = get_total_extra_amount();
                            var grand_total_amount = 0;
                            grand_total_amount = parseFloat(total_amount_data) + parseFloat(total_extra_amount);
                            $('#grand_total_amount').html('Total: ' + grand_total_amount.toFixed(2));
//                            $('.sale_details_information_block').html(data['sale_details_information_data']);
                            delete_single_product_from_table();
                        },
                        error: function (error) {
                            console.log("error occured");
                        }
                    });
                }
            });
        }

        function get_total_extra_amount() {
            //vat
            var vat = 0;
            vat = $("#vat").val();
            if (vat == '') {
                vat = 0;
            } else {
                vat = $("#vat").val();
            }
            //delivery_charge
            var delivery_charge = 0;
            delivery_charge = $("#delivery_charge").val();
            if (delivery_charge == '') {
                delivery_charge = 0;
            } else {
                delivery_charge = $("#delivery_charge").val();
            }
            // var others_charge
            var others_charge = 0;
            others_charge = $("#others_charge").val();
            if (others_charge == '') {
                others_charge = 0;
            } else {
                others_charge = $("#others_charge").val();
            }
            //deduction
            var deduction = 0;
            deduction = $("#deduction").val();
            if (deduction == '') {
                deduction = 0;
            } else {
                deduction = $("#deduction").val();
            }
            var amount_total = 0;
            amount_total = parseFloat(vat) + parseFloat(delivery_charge) + parseFloat(others_charge) - parseFloat(deduction);
            return amount_total;
        }

        sale_form();
        
        function sale_form() {
            $("#sale_form").validate({
                rules: {
                    branch_id: "required",
                    client_id: "required",
                    mode_of_payment: "required",
                },
                messages: {
                    branch_id: "Please Select a Outlet",
                    client_id: "Please Select a Client",
                    mode_of_payment: "Please Select Payment Mode",
                },
                submitHandler: function (form) {
                    var branch_id = $("option[name=branch_id]:selected").attr('value');
                    if (branch_id == '' || branch_id <= 0) {
                        $('.product-save-error-show-section').hide();
                    } else {
                        $('.product-save-error-show-section').show();
                    }
                    $.ajax({
                        type: "POST",
                        url: '<?php echo base_url("sale_product/check_insufficient_stock/") ?>',
                        data: {'branch_id': branch_id},
                        success: function (data) {
                            if (data['arr'] == false) {
                                $('.product-save-error-show-section').html('');
                                form.submit();
                            } else {
                                $('.product-save-error-show-section').html(data['arr']);
                                return false;
                            }

                        },
                        error: function () {

                        }
                    });

                }
            });
        }

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

        function delete_single_product_from_table() {
            $('.delete-invoice-product-button').click(function () {
                var array_id = $(this).attr('data-id');
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url("sale_product/delete_product_info/") ?>',
                    data: {'array_id': array_id},
                    success: function (data) {
                        $('.product-table-block').html(data['product_table_data']);
                        var total_amount_data = data['total_amount_data'];
                        var total_extra_amount = get_total_extra_amount();
                        var grand_total_amount = 0;
                        grand_total_amount = parseFloat(total_amount_data) + parseFloat(total_extra_amount);
                        $('#grand_total_amount').html('Total: ' + grand_total_amount.toFixed(2));
//                            $('.sale_details_information_block').html(data['sale_details_information_data']);
                        delete_single_product_from_table();
                        get_check_insufficient_stock();
                    },
                    error: function () {

                    }
                });
            });
        }

        $('#branch_id').change(get_check_insufficient_stock);

        function get_check_insufficient_stock() {
            var branch_id = $("option[name=branch_id]:selected").attr('value');
            if (branch_id == '' || branch_id <= 0) {
                $('.product-save-error-show-section').hide();
            } else {
                $('.product-save-error-show-section').show();
            }
            $.ajax({
                type: "POST",
                url: '<?php echo base_url("sale_product/check_insufficient_stock/") ?>',
                data: {'branch_id': branch_id},
                success: function (data) {
                    if (data['arr'] == false) {
                        $('.product-save-error-show-section').html('');
                    } else {
                        $('.product-save-error-show-section').html(data['arr']);
                    }
                },
                error: function () {

                }
            });
        }

    });

</script>


