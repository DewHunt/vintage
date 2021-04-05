<div id="page-wrapper">
    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class=""><?= !empty($page_title) ? $page_title : ''; ?></h4>
                </div>
                <div class="panel-body">
                    <div class="error" style="color: red">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">

                            <form id="client_sales_commission_form" name="client_sales_commission_form" action="<?= base_url('client_sales_commission/update') ?>" method="post">
                                <input type="hidden" class="form-control" id="id" name="id" value="<?= !empty($client_sales_commission) ? intval($client_sales_commission->id) : 0 ?>" placeholder="">
                                <input type="hidden" class="form-control" id="invoice_details_id" name="invoice_details_id" value="<?= !empty($client_sales_commission) ? intval($client_sales_commission->invoice_details_id) : 0 ?>">
                                <?php if ((!empty($this->session->flashdata('client_sales_commission_success_message')))) { ?>
                                    <div class="form-group row success success-message">
                                        <?php echo $this->session->set_flashdata('client_sales_commission_success_message'); ?>
                                    </div>
                                <?php }
                                ?>
                                <?php if ((!empty($this->session->flashdata('client_sales_commission_error_message')))) { ?>
                                    <div class="form-group row error error-message">
                                        <?php echo $this->session->set_flashdata('client_sales_commission_error_message'); ?>
                                    </div>
                                <?php }
                                ?>
                                <div class="form-group row">
                                    <div class="form-group col-xs-12 col-sm-4">
                                        <label for="invoice_number" class="col-form-label">Invoice Number</label>
                                        <input type="text" class="form-control" id="invoice_number" name="invoice_number" value="<?= !empty($invoice_details->invoice_number) ? ($invoice_details->invoice_number) : '' ?>" placeholder="Invoice Number" readonly="readonly">
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-4">
                                        <label for="commission_record_number" class="col-form-label">Commission Record Number</label>
                                        <input type="text" class="form-control" id="commission_record_number" name="commission_record_number" value="<?= !empty($client_sales_commission->commission_record_number) ? ($client_sales_commission->commission_record_number) : '' ?>" placeholder="Commission Record Number">
                                    </div>                                    
                                    <div class="form-group col-xs-12 col-sm-4">
                                        <label for="commission_amount" class="col-form-label">Commission Amount</label>
                                        <input type="number" step="any" min="1" class="form-control" id="commission_amount" name="commission_amount" value="<?= !empty($client_sales_commission->commission_amount) ? get_floating_point_number($client_sales_commission->commission_amount) : '' ?>" placeholder="Commission Amount">
                                    </div>                                    
                                </div>
                                <div class="form-group row">
                                    <div class="form-group col-xs-12 col-sm-4">
                                        <label for="claim_date" class="col-form-label">Claim Date</label>
                                        <?php
                                        $claim_date = !empty($client_sales_commission->claim_date) ? date("Y-m-d", strtotime($client_sales_commission->claim_date)) : '';
                                        if (empty($claim_date) || $claim_date == '0000-00-00 00:00:00') {
                                            $claim_date = get_current_date();
                                        }
                                        ?>
                                        <input type="date" class="form-control" id="claim_date" name="claim_date" value="<?= $claim_date; ?>" placeholder="Date">
                                    </div>                                    
                                    <div class="form-group col-xs-12 col-sm-4">
                                        <label for="commission_bank_name" class="col-form-label">Commission Bank Name</label>
                                        <input type="text" class="form-control" id="commission_bank_name" name="commission_bank_name" value="<?= !empty($client_sales_commission->commission_bank_name) ? ($client_sales_commission->commission_bank_name) : ''; ?>" placeholder="Commission Bank Name">
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-4">
                                        <label for="commission_bank_account" class="col-form-label">Commission Bank Account</label>
                                        <input type="text" class="form-control" id="commission_bank_account" name="commission_bank_account" value="<?= !empty($client_sales_commission->commission_bank_account) ? ($client_sales_commission->commission_bank_account) : ''; ?>" placeholder="Commission Bank Account">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="form-group col-xs-12 col-sm-4">
                                        <label for="commission_bkash_number" class="col-form-label">Commission Bkash Number</label>
                                        <input type="text" class="form-control" id="commission_bkash_number" name="commission_bkash_number" value="<?= !empty($client_sales_commission->commission_bkash_number) ? ($client_sales_commission->commission_bkash_number) : ''; ?>" placeholder="Commission Bkash Number">
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-4">
                                        <label for="" class="col-form-label"></label>
                                        <button type="submit" class="btn btn-default save-button update-client-sales-commission-button" id="update-client-sales-commission-button" style="float: left; margin-top: 20px;">Update</button>
                                        <a style="margin-top: 20px; float: left; margin-left: 10px;" class="btn btn-danger delete-client-sales-commission-button invoice-void-button float-left" id="delete-client-sales-commission-button" data-id="<?= !empty($client_sales_commission->id) ? intval($client_sales_commission->id) : 0; ?>" href="<?= base_url('client_sales_commission/delete'); ?>">Delete</a>
                                        <div class="col-xs-12 col-sm-6 loading-image" style="padding-top: 40px; float: right; display: none;"></div>
                                    </div>
                                    <div id="details_information_div" class="form-group col-xs-12 col-sm-4">

                                    </div>
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

        var invoiceNumber = $('#invoice_number').val();
        $.ajax({
            type: "POST",
            url: '<?php echo base_url('client_sales_commission/get_invoice_details_for_update'); ?>',
            data: {'invoice_number': invoiceNumber},
            success: function (data) {
                var content = '';
                var invoiceData = '';
                if (data['isInvoice']) {
                    invoiceData = data['invoiceData'];
                    if (invoiceData !== '') {
                        var content = '<div class="panel panel-info"><div class="panel-heading">Invoice Information</div><div class="panel-body"><table class="table table-striped" style="border: 1px solid #ddd;"><tbody>'
                        content += '<tr><td class="text-right" style="width: 150px;">' + '' + 'Client Name: ' + '</td><td class="">' + '' + invoiceData['client_name'] + '</td></tr>';
                        content += '<tr><td class="text-right" style="">' + '' + 'Employee Code: ' + '</td><td class="">' + '' + invoiceData['employee_code'] + '</td></tr>';
                        content += '<tr><td class="text-right" style="">' + '' + 'Dealer Code: ' + '</td><td class="">' + '' + invoiceData['dealer_code'] + '</td></tr>';
                        content += '<tr><td class="text-right" style="">' + '' + 'Amount: ' + '</td><td class="">' + '' + invoiceData['amount_to_paid'] + '</td></tr>';
                        content += '</tbody></table></div></div>';
                    }
                    $('#client_sales_commission_form #details_information_div').html(content);
                    $('#client_sales_commission_form #invoice_details_id').val(invoiceData['id']);
                } else {
                    $('#client_sales_commission_form #details_information_div').html(data['message']);
                    $('#client_sales_commission_form #invoice_details_id').val(0);
                    return false;
                }
            },
            error: function (error) {
                console.log("error occured.");
            }
        });

        $('#client_sales_commission_form').validate({
            rules: {
                invoice_number: "required",
                commission_amount: {
                    required: true,
                    number: true,
                    min: 1
                },
                claim_date: "required"
            },
            messages: {
                invoice_number: "Please input invoice number",
                commission_amount: {
                    required: "Please input amount",
                    number: "Please input valid amount"
                },
                claim_date: "Please input date"
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
                form.submit();
            }
        });

        $('#delete-client-sales-commission-button').click(function (e) {
            e.preventDefault();
            var deleteConfirmationMessage = confirm("Are you sure?");
            if (deleteConfirmationMessage !== true) {
                return false;
            } else {
                var id = $(this).data('id');
                id = isNaN(id) ? 0 : id;
                $.ajax({
                    type: "POST",
                    url: $(this).attr('href'),
                    data: {'id': id},
                    success: function (data) {
                        if (data['isDeleteClientSalesCommission']) {
                            alert(data['message']);
                            window.location.href = data['redirectUrl'];
                        } else {
                            alert(data['message']);
                            return false;
                        }
                    },
                    beforeSend: function () {
                        $("#update-client-sales-commission-button").hide();
                        $("#delete-client-sales-commission-button").hide();
                        $('.loading-image').show();
                    },
                    complete: function () {
                        $("#update-client-sales-commission-button").show();
                        $("#delete-client-sales-commission-button").show();
                        $('.loading-image').hide();
                    },
                    error: function (error) {
                        console.log("error occured.");
                    }
                });
            }
        });
    });

</script>



