<div id="page-wrapper">
    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Cheque Print</h4>
                </div>
                <div class="panel-body">
                    <div class="error" style="color: red">
                        <?php echo validation_errors(); ?>
                    </div>
                    <?php if (!empty($this->session->flashdata('cheque_print_error_message'))) { ?>
                        <div class="error error-message text-align-center">
                            <?php echo $this->session->flashdata('cheque_print_error_message'); ?>
                        </div>
                    <?php }
                    ?>
                    <?php if (!empty($this->session->flashdata('cheque_print_save_success_message'))) { ?>
                        <div class="success-message text-align-center">
                            <?php echo $this->session->flashdata('cheque_print_save_success_message'); ?>
                        </div>
                    <?php }
                    ?>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <form id="cheque_print_form" name="cheque_print_form" action="<?= base_url('accounts/all_print/cheque_print/cheque_print_save') ?>" method="post">

                                <div class="col-xs-12 row">
                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="cheque_date" class="col-form-label">Date</label>
                                        <input type="date" class="form-control" id="cheque_date" name="cheque_date" value="" placeholder="">
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="pay_to" class="col-form-label">Pay To</label>
                                        <input type="text" class="form-control" id="pay_to" name="pay_to" value="" placeholder="pay To">
                                    </div>
                                </div>
                                <div class="col-xs-12 row">
                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="amount" class="col-form-label">Amount</label>
                                        <input type="text" class="form-control" id="amount" name="amount" value="" placeholder="Amount">
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="amount_in_words" class="col-form-label">Amount In Words</label>
                                        <input type="text" class="form-control" id="amount_in_words" name="amount_in_words" value="" placeholder="Amount In Words">
                                    </div>
                                </div>
                                <div class="col-xs-12 row">
                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="bank_id" class="col-form-label">Bank Name</label>
                                        <select name="bank_id" id="bank_id" class="form-control">
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($bank_list)) {
                                                foreach ($bank_list as $bank) {
                                                    ?>
                                                    <option value="<?= $bank->id ?>"><?= ucfirst($bank->bank_name) ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="details" class="col-form-label">Details</label>
                                        <textarea class="form-control" id="details" name="details" rows="3" placeholder="Details"></textarea>
                                    </div>
                                </div>

                                <div class="col-xs-12 row">
                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">

                                    </div>

                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <button type="submit" class="btn btn-default save-button cheque-print-print-button">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.col-lg-6 (nested) -->
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

<script language="javascript" type="text/javascript">
    $(document).ready(function () {
        $("#cheque_print_form").validate({
            rules: {
                cheque_date: "required",
                pay_to: "required",
                amount: "required",
                amount_in_words: "required",
                bank_id: "required",
            },
            messages: {
                cheque_date: "Please Select Date",
                pay_to: "Please Enter Pay To",
                amount: "Please Enter Amount",
                amount_in_words: "Please Enter Amount In Words",
                bank_id: "Please Select Bank",
            },
            submitHandler: function (form) {
                var result = confirm('Do you want to Continue?');
                if (result == true) {
                    form.submit();
                } else {

                }
            }
        });
    });
</script>