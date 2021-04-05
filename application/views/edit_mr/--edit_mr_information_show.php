<div class="panel panel-default">
    <div class="panel-body">
        <form id="edit_mr_number_save_form" name="edit_mr_number_save_form" action="<?= base_url('edit_mr/save_edit_mr_information') ?>" method="post">
            <input type="hidden" id="id" name="id" value="<?= $payment_information->id ?>">
            <div class="row"></div>
            <div class="form-group row">
                <label for="receipt_mr_no" class="col-sm-2 col-xs-12 col-form-label">Receipt(MR)No</label>
                <div class="col-sm-4 col-xs-12">
                    <input type="text" class="form-control" id="receipt_mr_no" name="receipt_mr_no" value="<?= !empty($payment_information->receipt_mr_no) ? $payment_information->receipt_mr_no : '' ?>" readonly="readonly">
                </div>

                <label for="receipt_date" class="col-sm-2 col-xs-12 col-form-label">Receipt Date</label>
                <div class="col-sm-4 col-xs-12">
                    <?php $payment_date = date("Y-m-d", strtotime($payment_information->receipt_date)); ?>
                    <input type="date" class="form-control" id="receipt_date" name="receipt_date" value="<?= !empty($payment_date) ? $payment_date : '' ?>">
                </div>
            </div>

            <div class="form-group row">
                <label for="client_id" class="col-sm-2 col-xs-12 col-form-label">Rcvd From(Party)</label>
                <div class="col-sm-10 col-xs-12">
                    <input type="text" class="form-control" id="client_id" name="client_id" value="<?= !empty($client->client_name) ? $client->client_name : '' ?>">
                </div>
            </div>

            <div class="form-group row">
                <label for="amount_received" class="col-sm-2 col-xs-12 col-form-label">Amount Received</label>
                <div class="col-sm-4 col-xs-12">
                    <input type="text" class="form-control" id="amount_received" name="amount_received" value="<?= !empty($payment_information->amount_received) ? get_floating_point_number($payment_information->amount_received) : '' ?>">
                </div>
                <label for="client_code" class="col-sm-2 col-xs-12 col-form-label">Party
                    Code</label>
                <div class="col-sm-4 col-xs-12">
                    <input type="text" class="form-control" id="client_code" name="client_code" value="<?= !empty($client->client_code) ? $client->client_code : '' ?>" readonly="readonly">
                </div>
            </div>

            <div class="form-group row">
                <label for="payment_type" class="col-sm-2 col-xs-12 col-form-label">Mode of Payment</label>
                <div class="col-sm-4 col-xs-12">
                    <input type="text" class="form-control" id="payment_type" name="payment_type" value="<?= !empty($payment_information->payment_type) ? strtoupper($payment_information->payment_type) : '' ?>">
                </div>

                <label for="" class="col-sm-2 col-xs-12 col-form-label"></label>
                <div class="col-sm-4 col-xs-12">
                    <label hidden class="form-check-label">
                        <input class="form-check-input" type="checkbox"> Closed ?</label>
                </div>
            </div>

            <div class="form-group row">
                <label for="cheque_number" class="col-sm-2 col-xs-12 col-form-label">Cheque
                    no</label>

                <div class="col-sm-4 col-xs-12">
                    <input type="text" class="form-control" id="cheque_number" name="cheque_number" value="<?= !empty($payment_information->cheque_number) ? $payment_information->cheque_number : '' ?>"><!--readonly="readonly"-->
                </div>

                <label for="cheque_date" class="col-sm-2 col-xs-12 col-form-label">Cheque Date</label>

                <div class="col-sm-4 col-xs-12">
                    <?php $cheque_date = date("Y-m-d", strtotime($payment_information->cheque_date)); ?>
                    <input type="date" class="form-control" id="cheque_date" name="cheque_date" value="<?= !empty($cheque_date) ? $cheque_date : '' ?>">
                </div>
            </div>

            <div class="form-group row">
                <label for="bank_id" class="col-sm-2 col-xs-12 col-form-label">Bank Name</label>
                <div class="col-sm-10 col-xs-12">
                    <input type="text" class="form-control" id="bank_id" name="bank_id" value="<?= !empty($bank->bank_name) ? $bank->bank_name : '' ?>">
                </div>
            </div>

            <div class="form-group row">
                <label for="bank_id" class="col-sm-2 col-xs-12 col-form-label">Branch</label>
                <div class="col-sm-10 col-xs-12">
                    <input type="text" class="form-control" id="bank_id" name="bank_id" value="<?= !empty($payment_information->branch_name) ? $payment_information->branch_name : '' ?>">
                </div>
            </div>

            <div class="form-group row">
                <label for="purpose" class="col-sm-2 col-xs-12 col-form-label">Purpose</label>
                <div class="col-sm-10 col-xs-12">
                    <input type="text" class="form-control" id="purpose" name="purpose" value="<?= !empty($payment_information->purpose) ? $payment_information->purpose : '' ?>">
                </div>
            </div>

            <div class="form-group row">
                <label for="invoice_number" class="col-sm-2 col-xs-12 col-form-label">Invoice No</label>

                <div class="col-sm-10 col-xs-12">
                    <input type="text" class="form-control" id="invoice_number" name="invoice_number" value="<?= !empty($payment_information->invoice_number) ? $payment_information->invoice_number : '' ?>">
                </div>
            </div>

            <div class="form-group row">
                <label for="remarks"
                       class="col-sm-2 col-xs-12 col-form-label">Remarks/Cheque#</label>

                <div class="col-sm-10 col-xs-12">
                    <textarea class="form-control" id="remarks" name="remarks" rows="2"><?= !empty($payment_information->remarks) ? $payment_information->remarks : '' ?></textarea>
                </div>
            </div>

            <button style="margin-left: 1%" type="submit" class="btn btn-default save-button">Save</button>
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