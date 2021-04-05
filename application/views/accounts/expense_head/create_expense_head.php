<div id="page-wrapper">
    <!--<div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">Create New Expense Head</h2>
        </div>
    </div>-->

    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Create New Expense Head</h4>
                </div>
                <div class="panel-body">
                    <div class="error" style="color: red">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <form id="create_expense_head_form" name="create_expense_head_form"
                                  action="<?= base_url('accounts/expense_head/save_expense_head') ?>" method="post">

                                <div class="form-group row">
                                    <label for="expense_head_name" class="col-sm-2 col-xs-12 col-form-label">Expense
                                        Head</label>
                                    <div class="col-sm-10 col-xs-12">
                                        <input type="text" class="form-control" id="expense_head_name"
                                               name="expense_head_name"
                                               value="" placeholder="Expense Head">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="opening_balance" class="col-sm-2 col-xs-12 col-form-label">Opening
                                        Balance</label>

                                    <div class="col-sm-6 col-xs-12">
                                        <input type="text" class="form-control" id="opening_balance"
                                               name="opening_balance"
                                               value="" placeholder="Opening Balance">
                                    </div>

                                    <div class="col-sm-4 col-xs-12 balance-type">
                                        <input type="radio" class="form-check-input" name="balance_type"
                                               id="balance_type" value="debit"> Debit

                                        <input type="radio" class="form-check-input left-margin-ten" name="balance_type"
                                               id="balance_type" value="credit"> Credit
                                    </div>

                                </div>

                                <div class="form-group row">
                                    <label for="both" class="col-sm-2 col-xs-12 col-form-label">
                                    </label>

                                    <div class="col-sm-10 col-xs-12">
                                        <input type="checkbox" class="form-check-input" id="debit_credit_both"
                                               name="debit_credit_both"> Both
                                    </div>
                                </div>


                                <?php if(!empty($this->session->flashdata('expense_head_name_duplicate_error_message'))){ ?>
                                    <div class="form-group row">
                                        <label for="" class="col-sm-2 col-xs-12 col-form-label"></label>
                                        <div class="col-sm-10 col-xs-12 error-message">
                                            <?= $this->session->flashdata('expense_head_name_duplicate_error_message') ?>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if(!empty($this->session->flashdata('balance_type_error_message'))){ ?>
                                    <div class="form-group row">
                                        <label for="" class="col-sm-2 col-xs-12 col-form-label"></label>
                                        <div class="col-sm-10 col-xs-12 error-message">
                                            <?= $this->session->flashdata('balance_type_error_message'); ?>
                                        </div>
                                    </div>
                                <?php } ?>

                                <button type="submit" class="btn btn-default save-button">Save</button>

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
        $("form[name='create_expense_head_form']").validate({
            // Specify validation rules
            rules: {
                expense_head_name: "required",
                opening_balance: "required",
            },
            messages: {
                expense_head_name: "Please Enter Expense Head",
                opening_balance: "Please Enter Opening Balance",
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });
</script>