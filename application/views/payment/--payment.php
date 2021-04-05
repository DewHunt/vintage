<div id="page-wrapper">
    <?php if ((!empty($this->session->flashdata('payment_success_message')))) { ?>
        <div class="col-xs-12 success-message text-align-center">
            <?php echo $this->session->flashdata('payment_success_message'); ?>
        </div>
    <?php }
    ?>
    <?php if ((!empty($this->session->flashdata('valid_numeric_number_check_error_message')))) { ?>
        <div class="col-xs-12 error-message text-align-center">
            <?php echo $this->session->flashdata('valid_numeric_number_check_error_message'); ?>
        </div>
    <?php }
    ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="">Cash/Cheque Receipt entry against Credit Sales</h4>
        </div>
        
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <form id="payment_form" name="payment_form" action="<?= base_url('payment/save_payment') ?>" method="post">
                        <div class="form-group row">
                            <label for="receipt_mr_no" class="col-sm-2 col-xs-12 col-form-label">Receipt(MR)No</label>
                            <div class="col-sm-4 col-xs-12">
                                <input type="text" class="form-control" id="receipt_mr_no" name="receipt_mr_no" value="<?= $receipt_mr_no ?>" readonly="readonly">
                            </div>

                            <label for="receipt_date" class="col-sm-2 col-xs-12 col-form-label">Receipt Date</label>
                            <div class="col-sm-4 col-xs-12">
                                <input type="date" class="form-control" id="receipt_date" name="receipt_date" value="<?= date("Y-m-d") ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="client_id" class="col-sm-2 col-xs-12 col-form-label">Rcvd From(Party)</label>
                            <div class="col-sm-4 col-xs-12">
                                <select name="client_id" id="client_id" class="form-control">
                                    <option value="" name="client_id">Please Select</option>
                                    <?php foreach ($client_list as $client) { ?>
                                        <?php if (strtolower($client->client_type) == 'import') { ?>
                                            <option class="import-type-color" value="<?= $client->id ?>" client-code="<?= $client->client_code ?>" name="client_id"><?= $client->client_name ?>
                                            </option>
                                        <?php } else { ?>
                                            <option class="lubzone-type-color" value="<?= $client->id ?>" client-code="<?= $client->client_code ?>" name="client_id"><?= $client->client_name ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <label for="client_code" class="col-sm-2 col-xs-12 col-form-label">Party
                                Code</label>
                            <div class="col-sm-4 col-xs-12">
                                <input type="text" class="form-control" id="client_code" name="client_code" value="" readonly="readonly">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="amount_received" class="col-sm-2 col-xs-12 col-form-label">Amount Received</label>
                            <div class="col-sm-4 col-xs-12">
                                <input type="text" class="form-control" id="amount_received" name="amount_received" value="">
                            </div>

                            <label for="branch_id" class="col-sm-2 col-xs-12 col-form-label">Outlet</label>
                            <div class="col-sm-4 col-xs-12">
                                <select class="form-control branch_id" name="branch_id" id="branch_id">
                                    <option value="">Please Select</option>
                                    <?php
                                    if (!empty($branch_list)) {
                                        foreach ($branch_list as $branch) {
                                            ?>
                                            <option value="<?= intval($branch->id) ?>"><?= ucfirst($branch->branch_name) ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="payment_type" class="col-sm-2 col-xs-12 col-form-label">Mode of Payment</label>
                            <div class="col-sm-4 col-xs-12">
                                <select name="payment_type" id="payment_type" class="form-control">
                                    <option value="" name="payment_type">Please Select</option>
                                    <option value="cash" name="payment_type">Cash</option>
                                    <!--<option value="credit" name="payment_type">Credit</option>-->
                                    <option value="card" name="payment_type">Card</option>
                                    <option value="cheque" name="payment_type">Cheque</option>
                                    <option value="tt" name="payment_type">TT</option>
                                    <option value="draft" name="payment_type">Draft/Pay order</option>
                                    <option value="mobile_banking" name="payment_type">Mobile Banking</option>
                                </select>
                            </div>

                            <label for="branch_mr_no" class="col-sm-2 col-xs-12 col-form-label">Outlet(MR)No</label>
                            <div class="col-sm-4 col-xs-12">
                                <input type="text" class="form-control" id="branch_mr_no" name="branch_mr_no" value="">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cheque_number" class="col-sm-2 col-xs-12 col-form-label">Cheque No</label>

                            <div class="col-sm-4 col-xs-12">
                                <input type="text" class="form-control" id="cheque_number" name="cheque_number" value=""><!--readonly="readonly"-->
                            </div>

                            <label for="cheque_date" class="col-sm-2 col-xs-12 col-form-label">Cheque Date</label>

                            <div class="col-sm-4 col-xs-12">
                                <input type="date" class="form-control" id="cheque_date" name="cheque_date" value="<?= date("Y-m-d") ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="bank_id" class="col-sm-2 col-xs-12 col-form-label">Bank Name</label>
                            <div class="col-sm-10 col-xs-12">
                                <select id="branch_name" name="branch_name" class="form-control">
                                    <option value="" name="branch_name" label="Please Select">
                                        <?php foreach ($all_distinct_bank_name as $bank) { ?>
                                        <option value="<?= $bank->bank_name ?>" name="branch_name"><?= $bank->bank_name ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="bank_id" class="col-sm-2 col-xs-12 col-form-label">Branch</label>
                            <div class="col-sm-10 col-xs-12">
                                <select id="bank_id" name="bank_id" class="form-control">
                                    <option id="bank_id" name="bank_id" value="">Please Select</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="purpose" class="col-sm-2 col-xs-12 col-form-label">Purpose</label>
                            <div class="col-sm-10 col-xs-12">
                                <input type="text" class="form-control" id="purpose" name="purpose" value="">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="invoice_number" class="col-sm-2 col-xs-12 col-form-label">Invoice No</label>

                            <div class="col-sm-10 col-xs-12">
                                <input type="text" class="form-control" id="invoice_number"
                                       name="invoice_number" value="">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="remarks"
                                   class="col-sm-2 col-xs-12 col-form-label">Remarks/Cheque#</label>

                            <div class="col-sm-10 col-xs-12">
                                <textarea class="form-control" id="remarks" name="remarks" rows="2"></textarea>
                            </div>
                        </div>

                        <button style="margin-left: 1%" type="submit" class="btn btn-default save-button">Save</button>
                        <button type="reset"
                                class="btn btn-danger cancel-button save-button cancel-button-color">Cancel
                        </button>
                    </form>
                </div>
                <!-- /.col-lg-6 (nested) -->
            </div>
            <!-- /.row (nested) -->
        </div>
        <!-- /.panel-body -->
    </div>
</div>
<!-- /#page-wrapper -->


<script>
    $(document).ready(function () {

        $("form[name='payment_form']").validate({
            rules: {
                client_id: "required",
                amount_received: {
                    required: true,
                    number: true
                },
                payment_type: "required",
                branch_id: "required"
            },
            messages: {
                client_id: "Please Select Client",
                amount_received: {
                    required: "Please Enter Amount",
                    number: "Please Enter Valid Amount"
                },
                payment_type: "Please Select Payment Type",
                branch_id: "Please Select Outlet"
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
        // change client_code according to Client
        $('#client_id').change(function () {
            var client_code = $("option[name=client_id]:selected").attr('client-code');
            $('#client_code').val(client_code);
        });
        // change branch_name according to Branch
//        $('#bank_id').change(function () {
//            var branch_name = $("option[name=bank_id]:selected").attr('branch-name');
//            $('#branch_name').val(branch_name);
//        });

        $('#branch_name').change(function (event) {
            var bank_name = $('#branch_name option:selected').val();
            $.ajax({
                type: "POST",
                url: '<?php echo base_url("payment/get_all_branches_of_selected_bank/") ?>',
                data: {'bank_name': bank_name},
                success: function (data) {
                    //alert(data);
                    $("#bank_id").html(data);
                },
                error: function (error) {
                    console.log("error occured");
                }
            });
            event.preventDefault();
        });
        /* $('#payment_type').change(function () {
         var payment_type = $("option[name=payment_type]:selected").val();
         if ($("option[name=payment_type]:selected").val() != ""){
         $('#cheque_number').attr('readonly', false);
         $("option[name=bank_id]:selected").attr('readonly', false);
         }else {
         $('#cheque_number').attr('readonly', true);
         }
         });*/

    });

</script>