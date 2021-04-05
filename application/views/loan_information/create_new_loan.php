<div id="page-wrapper">
    <?php
    $employee_list;
    $employee_loan_list;
    $loan_error_session;
    ?>

    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Create Loan</h4>
                </div>
                <div class="panel-body">
                    <div class="error" style="color: red">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <form id="create_loan_form" name="create_loan_form" action="<?= base_url('loan/save_loan') ?>" method="post">

                                <div class="col-xs-12 row">
                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="employee_id" class="col-form-label">Employee</label>
                                        <select name="employee_id" id="employee_id" class="form-control">
                                            <option value="" name="employee_id">Please Select</option>
                                            <?php foreach ($employee_list as $employee) { ?>
                                                <option value="<?= $employee->id ?>"
                                                        name="employee_id"><?= ucfirst($employee->employee_name) ?></option>
                                                    <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="loan_start_date" class="col-form-label">Loan
                                            Date</label>
                                        <input type="date" class="form-control" id="loan_start_date"
                                               name="loan_start_date"
                                               value="">
                                    </div>
                                </div>
                                <div class="col-xs-12 row">
                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="number_of_installment" class="col-form-label">Number
                                            of Installment</label>
                                        <input type="text" class="form-control" id="number_of_installment"
                                               name="number_of_installment"
                                               value="" placeholder="Number of Installment">
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="total_loan_amount" class="col-form-label">Total Loan
                                            Amount</label>
                                        <input type="text" class="form-control" id="total_loan_amount"
                                               name="total_loan_amount"
                                               value="" placeholder="Total Loan Amount">
                                    </div>
                                </div>
                                <div class="col-xs-12 row">
                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="per_installment_amount" class="col-form-label">Per
                                            Installment Amount</label>
                                        <input type="text" class="form-control"
                                               id="per_installment_amount"
                                               name="per_installment_amount"
                                               value="" placeholder="Per Installment Amount">
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="already_paid_loan_amount" class="col-form-label">Already Paid Loan Amount</label>
                                        <input type="text" class="form-control"
                                               id="already_paid_loan_amount"
                                               name="already_paid_loan_amount"
                                               value="" placeholder="Already Paid Loan Amount">
                                    </div>
                                </div>
                                <div class="col-xs-12 row">

                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="details" class="col-form-label">Details</label>
                                        <textarea class="form-control" id="details" name="details" rows="2"
                                                  placeholder="Details"></textarea>
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="current_loan_amount" class="col-form-label">Current Loan Amount</label>
                                        <input readonly="readonly" type="text" class="form-control"
                                               id="current_loan_amount"
                                               name="current_loan_amount"
                                               value="" placeholder="Current Loan Amount">
                                    </div>

                                </div>

                                <div class="col-xs-12 row">

                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 error-message">
                                        <?php
                                        if (!empty($loan_error_session)) {
                                            echo $loan_error_session;
                                        }
                                        ?>
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="" class="col-form-label"></label>
                                        <button type="submit" class="btn btn-default save-button">Save</button>
                                    </div>

                                </div>



                            </form>
                        </div>
                        <!-- /.col-lg-6 (nested) -->

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

<script>
    $(document).ready(function () {

        $("form[name='create_loan_form']").validate({
            rules: {
                employee_id: "required",
                loan_start_date: "required",
                total_loan_amount: "required",
                number_of_installment: "required",
                per_installment_amount: "required",
                details: "required",
            },
            messages: {
                employee_id: "Please Select Employee Name",
                loan_start_date: "Please Select Loan Date",
                total_loan_amount: "Please Enter Total Loan Amount",
                number_of_installment: "Please Enter Number of Installment",
                per_installment_amount: "Please Enter Per Installment Amount",
                details: "Please Enter Loan Details",
            },
            submitHandler: function (form) {
                var result = confirm('Do you want to provide this Loan ?');
                if (result) {
                    if (result == true) {
                        form.submit();
                    } else {
                    }
                }
            }
        });
        
        $('#total_loan_amount, #already_paid_loan_amount').keyup(get_current_amount);
        $('#number_of_installment, #total_loan_amount, #already_paid_loan_amount').keyup(get_amount);

        function get_amount() {
            var number_of_installment = $("#number_of_installment").val();
            var total_loan_amount = $("#total_loan_amount").val();
            var already_paid_loan_amount = $("#already_paid_loan_amount").val();
            //var current_loan_amount = $("#current_loan_amount").val();
            var current_amount = total_loan_amount - already_paid_loan_amount;
            var per_installment_amount = current_amount / number_of_installment;
            $('#per_installment_amount').val(per_installment_amount.toFixed(2));
        }

        function get_current_amount() {
            var total_loan_amount = $("#total_loan_amount").val();
            var already_paid_loan_amount = $("#already_paid_loan_amount").val();
            var per_installment_amount = total_loan_amount - already_paid_loan_amount;
            $('#current_loan_amount').val(per_installment_amount.toFixed(2));
        }

    });
</script>

