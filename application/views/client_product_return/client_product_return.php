<div id="page-wrapper">
    <?php $product_list; $branch_list; ?>
    <?php if (!empty($this->session->flashdata('branch_return_date_and_remarks_error_message'))) { ?>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="error-message text-align-center">
                    <?php echo $this->session->flashdata('branch_return_date_and_remarks_error_message'); ?>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php if (!empty($this->session->flashdata('client_product_return_save_message'))) { ?>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="success-message text-align-center">
                    <?php echo $this->session->flashdata('client_product_return_save_message'); ?>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php if (!empty($this->session->flashdata('client_product_return_table_error_message'))) { ?>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="error-message text-align-center">
                    <?php echo $this->session->flashdata('client_product_return_table_error_message'); ?>
                </div>
            </div>
        </div>
    <?php } ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><h4 class="">Void Invoice</h4></div>
            </div>
            
        </div>

        <div class="panel-body">
            <div class="error" style="color: red"><?php echo validation_errors(); ?></div>

            <form id="client_product_return_form" name="client_product_return_form" action="<?= base_url('client_product_return/client_product_return_show_in_table') ?>" method="post">

                <div class="row">
                    <div class="col-lg-10 col-md-10 col-xs-12 col-sm-12">
                        <label for="invoice_number" class="col-form-label">Invoice Number</label>
                        <div class="form">
                            <input type="text" class="form-control" id="invoice_number" name="invoice_number" value="" placeholder="Invoice Number">
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2 col-xs-12 col-sm-12">
                        <label for=""></label>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg" id="add-product-button" onclick="getBranchInfo()">Search</button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12"><div class="client_product_return_table_block"></div></div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12"><div class="client_reduce_product_return_table_block"></div></div>
            </div>

            <form id="client_product_return_save_form" name="client_product_return_save_form" action="<?= base_url('client_product_return/client_product_return_information_save') ?>" method="post">
                <input type="hidden" class="form-control" id="adjust_deduction" name="adjust_deduction" value="">

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label for="return_date" class="col-form-label">Date</label>
                                <div class="form-group">
                                    <input type="date" class="form-control" id="return_date" name="return_date" value="">
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label for="branch_id" class="col-form-label">Outlet</label>
                                <div class="form-group">
                                    <!-- <select name="branch_id" id="branch_id" class="form-control">
                                        <option value="" name="branch_id">Please Select</option>
                                        <?php foreach ($branch_list as $branch): ?>
                                            <option value="<?= $branch->id ?>" name="branch_id"><?= $branch->branch_name ?></option>
                                        <?php endforeach ?>
                                    </select> -->
                                    <input class="form-control" type="text" id="branch_name" name="branch_name" readonly>
                                    <input class="form-control" type="hidden" id="branch_id" name="branch_id">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <label for="remarks" class="col-form-label">Remarks</label>
                        <div class="form-group">
                            <textarea class="form-control" id="remarks" name="remarks" rows="5" placeholder="Remarks"></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <!-- <button type="submit" class="btn btn-default save-button">Partial Void</button> -->
                        <a class="btn btn-danger invoice-void-button">Invoice Void</a>
                        <div class="col-xs-12 text-align-center error-message"><span class="invoice_number_error_messsage"></span></div>
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
        $('#client_product_return_form').validate({
            rules: {
                //product_id: "required",
                //quantity: "required",
            },
            messages: {
                //product_id: "Please Select a Product",
                //quantity: "Please Enter Quantity",
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
                        $('.client_product_return_table_block').html(data);
                        $('.invoice-void-button').removeClass('invoice-void-button-disable');
                    },
                    error: function (error) {
                        console.log("error occured");
                    }
                });
            }
        });

        $("form[name='client_product_return_save_form']").validate({
            rules: {
                return_date: "required",
                branch_id: "required",
                remarks: "required",
            },
            messages: {
                return_date: "Please Select Date",
                branch_id: "Please Select Outlet",
                remarks: "Please Enter Remarks",
            },
            submitHandler: function (form) {
                var invoice_partial_void_confirmation_message = confirm("Are you sure to partial void this Invoice?");

                if (invoice_partial_void_confirmation_message !== true) {
                    return false;
                } else {
                    var totalReturnAmount = 0;
                    var deduction = $('#deduction').val();
                    $('#adjust_deduction').val(deduction);
//                    $.ajax({
//                        type: "POST",
//                        url: '<?php echo base_url('client_product_return/is_valid_for_return_invoice'); ?>',
//                        data: '',
//                        success: function (data) {
//                            totalReturnAmount = data['totalReturnAmount'];
//                        },
//                        error: function (error) {
//                            console.log("error occured");
//                        }
//                    });
//                     if (get_floating_point_number($invoice_amount_to_paid) < get_floating_point_number($total_return_amount)) {
//                    if(){}else{}
//
//
//
//

                    form.submit();
                }
            }
        });

        $('.invoice-void-button').on('click', function () {
            var invoice_number = $('#invoice_number_for_invoice_void').val();
            var return_date = $('#return_date').val();
            return_date = return_date.trim();
            var branch_id = $('#branch_id').val();
            branch_id = branch_id.trim();
            var remarks = $('#remarks').val();
            remarks = remarks.trim();
            var invoice_void_confirmation_message = confirm("Are you sure to void this Invoice?");
            if (invoice_void_confirmation_message !== true) {
                return false;
            } else {
                if (invoice_number === 'undefined' || return_date === '' || branch_id === '' || remarks === '') {
                    $('.invoice_number_error_messsage').html('Please Check input Fields');
                    $('.invoice_number_error_messsage').fadeIn('slow').delay(1000).fadeOut('slow'); // 1sec = 1000
                    return false;
                } else {
                    $.ajax({
                        type: "POST",
                        url: '<?php echo base_url("client_product_return/invoice_void/") ?>',
                        data: {'invoice_number': invoice_number, 'return_date': return_date, 'branch_id': branch_id, 'remarks': remarks},
                        success: function (data) {
                            window.location.href = '<?php echo base_url("client_product_return") ?>';
                        },
                        error: function () {

                        }
                    });
                }
            }
        });
    });

    function getBranchInfo() {
        var invoice_number = $('#invoice_number').val();
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("client_product_return/get_branch_info/") ?>',
            data: {invoice_number:invoice_number},
            success: function (data) {
                var branch_info = data.branch_info;
                $('#branch_name').val(branch_info.branch_name);
                $('#branch_id').val(branch_info.id);
            },
            error: function () {
            }
        })
    }

</script>



