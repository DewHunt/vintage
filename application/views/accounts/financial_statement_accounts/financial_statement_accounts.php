<div id="page-wrapper">
    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Financial Statement Accounts</h4>
                </div>
                <div class="panel-body">
                    <div class="error" style="color: red">
                        <?php echo validation_errors(); ?>
                    </div>
                    <?php if (!empty($this->session->flashdata('financial_statement_accounts_save_success_message'))) { ?>
                        <div class="form-group col-xs-12 success-message text-align-center">
                            <?= $this->session->flashdata('financial_statement_accounts_save_success_message') ?>
                        </div>
                    <?php } ?>
                    <?php if (!empty($this->session->flashdata('financial_statement_accounts_save_error_message'))) { ?>
                        <div class="form-group col-xs-12 error-message text-align-center">
                            <?= $this->session->flashdata('financial_statement_accounts_save_error_message') ?>
                        </div>
                    <?php } ?>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12 financial-statement-accounts-block">
                            <form id="financial_statement_accounts_show_form" name="financial_statement_accounts_show_form" action="<?= base_url('accounts/financial_statement_accounts/financial_statement_accounts_name_show') ?>" method="post">
                                <div class="form-group row">
                                    <label for="financial_statement_accounts_id" class="col-sm-2 col-xs-12 col-form-label">Name</label>

                                    <div class="col-sm-10 col-xs-12">
                                        <select name="financial_statement_accounts_id" id="financial_statement_accounts_id" class="form-control">
                                            <option value="" name="financial_statement_accounts_id"><?= strtoupper('Please Select') ?></option>
                                            <?php foreach ($financial_statement_accounts_list as $financial_statement_accounts) { ?>
                                                <option value="<?= $financial_statement_accounts->id ?>" name="financial_statement_accounts_id"><?= strtoupper($financial_statement_accounts->account_name) ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-default save-button">Show</button>
                            </form>
                            <div class="col-xs-12 financial-statement-accounts-name-section">

                            </div>
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

<script type="text/javascript">
    $(document).ready(function () {
        $('.financial-statement-accounts-block form').submit(function (event) {
            event.preventDefault();
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function (data) {
                    $(".financial-statement-accounts-name-section").html(data);
                },
                error: function () {

                }
            });
        });
    });
</script>

