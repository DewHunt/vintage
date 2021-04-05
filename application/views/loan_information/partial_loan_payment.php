<div id="page-wrapper">
    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Partial Loan Payment</h4>
                </div>
                <div class="panel-body">
                    <div class="error" style="color: red">
                        <?php echo validation_errors(); ?>
                    </div>
                    <?php if (!empty($this->session->flashdata('partial_loan_payment_save_success_message'))) { ?>
                        <div class="col-xs-12 success-message text-align-center">
                            <?php echo $this->session->flashdata('partial_loan_payment_save_success_message'); ?>
                        </div>
                    <?php } ?>
                    <?php if (!empty($this->session->flashdata('partial_loan_payment_save_error_message'))) { ?>
                        <div class="col-xs-12 error-message text-align-center">
                            <?php echo $this->session->flashdata('partial_loan_payment_save_error_message'); ?>
                        </div>
                    <?php } ?>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <form id="partial_loan_payment_form" name="partial_loan_payment_form" action="<?= base_url('loan/partial_loan_payment_save') ?>" method="post">

                                <div class="col-xs-12 row">
                                    <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <label for="employee_id" class="col-form-label">Employee</label>
                                        <select name="employee_id" id="employee_id" class="form-control">
                                            <option value="" name="employee_id" employee-name="" employee-code="" employee-designation="" loan-start-date="" total-loan-amount="" total-installment-amount="" due-amount="">Please Select</option>
                                            <?php foreach ($employee_loan_list as $employee) { ?>
                                                <option value="<?= $employee->employee_id ?>" name="employee_id" employee-name="<?= ucfirst($employee->employee_name) ?>" employee-code="<?= !empty($employee->employee_code) ? $employee->employee_code : '' ?>" employee-designation="<?= !empty($employee->designation) ? ucfirst($employee->designation) : '' ?>" loan-start-date="<?= date("d-m-Y", strtotime($employee->loan_start_date)) ?>" total-loan-amount="<?= get_floating_point_number($employee->total_loan_amount) ?>" total-installment-amount="<?= get_floating_point_number($employee->total_installment_amount) ?>" due-amount="<?= get_floating_point_number(((double) $employee->total_loan_amount) - ((double) $employee->total_installment_amount)) ?>"><?= ucfirst($employee->employee_name) ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <label id="employee_name" class="">Employee Name: </label>
                                </div>
                                <div class="col-xs-12">
                                    <label id="employee_code" class="">Employee Code: </label>
                                </div>
                                <div class="col-xs-12">
                                    <label id="designation" class="">Designation: </label>
                                </div>
                                <div class="col-xs-12">
                                    <label id="loan_start_date" class="">Loan Start Date(dd-mm-yyyy): </label>
                                </div>
                                <div class="col-xs-12">
                                    <label id="total_loan_amount" class="">Total Loan Amount: </label>
                                </div>
                                <div class="col-xs-12">
                                    <label id="total_installment_amount" class="">Total Paid Amount: </label>
                                </div>
                                <div class="col-xs-12">
                                    <label id="due_amount" class="">Due Amount: </label>
                                </div>
                                <div class="col-xs-12 row">
                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="current_payment" class="col-form-label">Current Payment</label>
                                        <input type="text" class="form-control" id="current_payment" name="current_payment" value="" placeholder="Current Payment">
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="current_due_amount" class="col-form-label">Current Due Amount</label>
                                        <input readonly="readonly" type="text" class="form-control" id="current_due_amount" name="current_due_amount" value="" placeholder="Current Due Amount">
                                    </div>
                                </div>
                                <div class="col-xs-12 row">

                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="partial_loan_payment_date" class="col-form-label">Payment Date</label>
                                        <input type="date" class="form-control" id="partial_loan_payment_date" name="partial_loan_payment_date" value="<?= get_current_date() ?>">
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 div-margin-top">
                                        <label for="" class="col-form-label"></label>
                                        <button type="submit" class="btn btn-default save-button div-margin-top partial_loan_payment_save_button">Save</button>
                                    </div>

                                </div>
                                <div class="col-xs-12 text-align-center error-message">
                                    <span class="current_due_amount_error_messsage"></span>
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

<script>
    $(document).ready(function () {

        partial_loan_payment_form_validation();

        $('#employee_id').change(get_employee_loan_info);

        $('#current_payment').keyup(get_current_due_amount);

        function partial_loan_payment_form_validation() {
            $("#partial_loan_payment_form").validate({
                rules: {
                    employee_id: "required",
                    current_payment: "required",
                    current_due_amount: "required",
                    partial_loan_payment_date: "required",
                },
                messages: {
                    employee_id: "Please Select Employee",
                    current_payment: "Please Enter Payment Amount",
                    current_due_amount: "Please Enter Due Amount",
                    partial_loan_payment_date: "Please Enter Date",
                },
                submitHandler: function (form) {
                    var result = confirm('Do you want to continue this Partial Loan Payment?');
                    if (result) {
                        if (result === true) {
                            form.submit();
                        } else {
                        }
                    }
                }
            });
        }

        function get_employee_loan_info() {
            var employee_name = $("option[name=employee_id]:selected").attr('employee-name');
            $('#employee_name').text('Employee Name: ' + employee_name);
            var employee_code = $("option[name=employee_id]:selected").attr('employee-code');
            $('#employee_code').text('Employee Code: ' + employee_code);
            var designation = $("option[name=employee_id]:selected").attr('employee-designation');
            $('#designation').text('Designation: ' + designation);
            var loan_start_date = $("option[name=employee_id]:selected").attr('loan-start-date');
            $('#loan_start_date').text('Loan Start Date(dd-mm-yyyy): ' + loan_start_date);
            var total_loan_amount = $("option[name=employee_id]:selected").attr('total-loan-amount');
            $('#total_loan_amount').text('Total Loan Amount: ' + total_loan_amount);
            var total_installment_amount = $("option[name=employee_id]:selected").attr('total-installment-amount');
            $('#total_installment_amount').text('Total Installment Amount: ' + total_installment_amount);
            var due_amount = $("option[name=employee_id]:selected").attr('due-amount');
            $('#due_amount').text('Due Amount: ' + due_amount);

            $('#current_payment').val('');
            $('#current_due_amount').val('');
            is_save_button_enable(false);
        }

        function get_current_due_amount() {
            var due_amount = $("option[name=employee_id]:selected").attr('due-amount');
            if (due_amount === '') {
                due_amount = 0;
            }
            var current_payment = $(this).val();
            var current_due_amount = (due_amount - current_payment);
            $('#current_due_amount').val(current_due_amount.toFixed(2));
            if (current_due_amount < 0) {
                $('.current_due_amount_error_messsage').html('Please Enter Corrent Amount');
                $('.current_due_amount_error_messsage').fadeIn('slow').delay(1000).fadeOut('slow'); // 1sec = 1000
                is_save_button_enable(true);
            } else {
                is_save_button_enable(false);
            }
        }

        function is_save_button_enable(flag = false) {
            $('.partial_loan_payment_save_button').attr('disabled', flag);
        }

    });
</script>

