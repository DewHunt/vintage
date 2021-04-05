<div class="panel panel-default">
    <div class="panel-body">
        <form id="edit_mr_number_save_form" name="edit_mr_number_save_form" action="<?= base_url('edit_mr/save_edit_mr_information') ?>" method="post">
            <input type="hidden" id="id" name="id" value="<?= $payment_information->id ?>">
            <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <label for="receipt_mr_no">Receipt(MR)No</label>
                    <div class="form-group">
                        <input type="text" class="form-control" id="receipt_mr_no" name="receipt_mr_no" value="<?= !empty($payment_information->receipt_mr_no) ? $payment_information->receipt_mr_no : '' ?>" readonly="readonly">
                    </div>
                </div>

                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <label for="invoice_number">Invoice No</label>
                    <div class="form-group">
                        <input type="text" class="form-control" id="invoice_number" name="invoice_number" value="<?= !empty($payment_information->invoice_number) ? $payment_information->invoice_number : '' ?>" readonly>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label for="client_id">Rcvd From (Customer)</label>
                    <div class="form-group">
                        <input type="text" class="form-control" id="client_id" name="client_id" value="<?= !empty($client->client_name) ? $client->client_name : '' ?>" readonly>
                    </div>
                </div>

                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <label for="receipt_date">Receipt Date</label>
                    <div class="form-group">
                        <?php $payment_date = date("Y-m-d", strtotime($payment_information->receipt_date)); ?>
                        <input type="date" class="form-control" id="receipt_date" name="receipt_date" value="<?= !empty($payment_date) ? $payment_date : '' ?>">
                    </div>
                </div>

                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <label for="amount_received">Amount Received</label>
                    <div class="form-group">
                        <input type="text" class="form-control" id="amount_received" name="amount_received" value="<?= !empty($payment_information->amount_received) ? get_floating_point_number($payment_information->amount_received) : '' ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <label for="payment_type">Mode of Payment</label>
                    <div class="form-group">
                        <input type="text" class="form-control" id="payment_type" name="payment_type" value="<?= !empty($payment_information->payment_type) ? strtoupper($payment_information->payment_type) : '' ?>" readonly>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <label for="bank_id">Bank Name</label>
                    <div class="form-group">
                        <input type="text" class="form-control" id="bank_id" name="bank_id" value="<?= !empty($bank->bank_name) ? $bank->bank_name : '' ?>" readonly>
                    </div>
                </div>

                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                <label for="cheque_number">Cheque No</label>
                    <div class="form-group">
                        <input type="text" class="form-control" id="cheque_number" name="cheque_number" value="<?= !empty($payment_information->cheque_number) ? $payment_information->cheque_number : '' ?>" readonly>
                    </div>
                </div>

                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <label for="cheque_date">Cheque Date</label>
                    <div class="form-group">
                        <?php
                            $cheque_date = empty($payment_information->cheque_date) ? '' : date("Y-m-d", strtotime($payment_information->cheque_date));
                        ?>
                        <input type="date" class="form-control" id="cheque_date" name="cheque_date" value="<?= !empty($cheque_date) ? $cheque_date : '' ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label for="remarks">Remarks/Cheque#</label>
                    <div class="form-group">
                        <textarea class="form-control" id="remarks" name="remarks" rows="2"><?= !empty($payment_information->remarks) ? $payment_information->remarks : '' ?></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="display: none;">
                    <div class="form-group">
                        <input class="form-check-input" type="checkbox"> Closed ?</label>
                    </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </div>            
        </form>
    </div>
</div>

<script>
    $(document).ready(function () {

        $("form[name='edit_mr_number_save_form']").validate({
            rules: {
                amount_received: "required",
            },
            messages: {
                amount_received: "Please Enter Amount",
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });

</script>