<div id="page-wrapper">
    <?php if (!empty($this->session->flashdata('payment_success_message'))): ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Success!</strong> <?= $this->session->flashdata('payment_success_message') ?>
        </div>
    <?php endif ?>

    <?php if (!empty($this->session->flashdata('valid_numeric_number_check_error_message'))): ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Opps!</strong> <?= $this->session->flashdata('valid_numeric_number_check_error_message') ?>
        </div>
    <?php endif ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <!-- <h4 class="">Cash/Cheque Receipt entry against Credit Sales</h4> -->
            <h4 class="">Money Receipt</h4>
        </div>

        <div class="panel-body">
            <form id="payment_form" name="payment_form" action="<?= base_url('payment/save_payment') ?>" method="post">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <label for="receipt-mr-no">Money Receipt No</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="receipt_mr_no" name="receipt_mr_no" value="<?= $receipt_mr_no ?>" readonly="readonly">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <label for="receipt-date">Receipt Date</label>
                        <div class="form-group">
                            <input type="date" class="form-control" id="receipt_date" name="receipt_date" value="<?= date("Y-m-d") ?>">
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <label for="customer">Recieved From Customer</label>
                        <div class="form-group">
                            <select name="client_id" id="client_id" class="form-control select2">
                                <option value="">Please Select</option>
                                <?php foreach ($client_list as $client): ?>
                                    <option value="<?= $client->id ?>"><?= $client->client_name ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                        <label for="client_code">Customer Code</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="client_code" name="client_code" value="" readonly="readonly">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <label for="outlet">Outlet</label>
                        <div class="form-group">
                            <select class="form-control branch_id select2" name="branch_id" id="branch_id">
                                <option value="">Please Select A Outlet</option>
                                <?php foreach ($branch_list as $branch): ?>
                                    <option value="<?= $branch->id ?>"><?= ucfirst($branch->branch_name) ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <label for="amount-received">Amount Received</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="amount_received" name="amount_received" value="">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <label for="payment-type">Mode of Payment</label>
                        <div class="form-group">
                            <?php
                                $paymentTypeArray = array(
                                    'Cash' => 'cash',
                                    'Card' => 'card',
                                    'Cheque' => 'cheque',
                                    'Mobile Banking' => 'mobile_banking'
                                );
                            ?>
                            <select name="payment_type" id="payment_type" class="form-control select2">
                                <option value="" name="payment_type">Please Select</option>
                                <?php foreach ($paymentTypeArray as $key => $value): ?>
                                    <option value="<?= $key ?>"><?= $value ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label for="bank-name">Bank Name</label>
                                <div class="form-group">
                                    <select id="bank_id" name="bank_id" class="form-control select2">
                                        <?php $currentBankName = ""; ?>
                                        <option value="">Please Select A Bank</option>
                                        <?php foreach ($bank_list as $bank): ?>
                                            <?php if ($currentBankName != $bank->bank_name): ?>
                                                <?php $currentBankName = $bank->bank_name; ?>
                                                <option value="<?= $bank->id ?>"><?= $bank->bank_name ?></option>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for="cheque-number">Cheque No</label>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="cheque_number" name="cheque_number" value="">
                                </div>
                            </div>
                            
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for="cheque-date">Cheque Date</label>
                                <div class="form-group">
                                    <input type="date" class="form-control" id="cheque_date" name="cheque_date" value="<?= date("Y-m-d") ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <label for="remarks">Remarks</label>
                        <div class="form-group">
                            <textarea class="form-control" id="remarks" name="remarks" rows="5"></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">                    
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                        <button type="submit" class="btn btn-success">Save</button>
                        <button type="reset" class="btn btn-danger">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
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
            var clientId = $("#client_id").val();
            if (clientId == "") {
                $('#client_code').val("");
            }
            else {
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url("payment/getclientInfoById/") ?>',
                    data: {clientId:clientId},
                    success: function (data) {
                        var clientInfo = data.clientInfo;
                        $('#client_code').val(clientInfo.client_code);
                    },
                    error: function () {}
                })
            }
        });
    });
</script>