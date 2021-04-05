<div id="page-wrapper">
    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Yearend Closing Statement Generate</h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12 update_closing_balance_form_block">
                            <form id="yearend_closing_statement_generate_form" name="yearend_closing_statement_generate_form" action="<?= base_url('accounts/yearend_closing_statement_generate/statement_generate') ?>" method="post">
                                <?php if (!empty($this->session->flashdata('yearend_closing_statement_generate_message'))) { ?>
                                    <div class="form-group row col-xs-12 success-message text-align-center">
                                        <?= $this->session->flashdata('yearend_closing_statement_generate_message'); ?>
                                    </div>

                                <?php } ?>
                                <div class="form-group row">
                                    <center><button type="submit" class="btn btn-default add-product-button">Generate</button></center>
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

        $("#yearend_closing_statement_generate_form").validate({
            rules: {
            },
            messages: {
            },
            submitHandler: function (form) {
                var result = confirm('Are You Sure ?');
                if (result == true) {
                    form.submit();
                } else {

                }

            }
        });
    });
</script>




