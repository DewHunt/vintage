<div id="page-wrapper">
    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Profit and Loss Account Report</h4>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12 profit-and-loss-account-report-block">
                            <form id="profit_and_loss_account_report_form" name="profit_and_loss_account_report_form" action="<?= base_url('reports/accounts_report/account_statement_report/statement_report_show_in_table') ?>" method="post">
                                <input type="hidden" id="financial_statement_accounts_id" name="financial_statement_accounts_id" value="2">
                                <div class="form-group row">
                                    <div class="form-group col-xs-12 col-sm-6">
                                        <?php $this->load->view('reports/accounts_report/account_statement_report/date_filter', $this->data); ?>
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-6 show-button-section" style="padding-top: 40px">
                                        <button type="submit" class="btn btn-primary stock-transfer-challan-report-button" id="show-button">Show</button>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 display-none loading-image" style="padding-top: 40px;"></div>
                                </div>
                            </form>

                            <div class="col-xs-12 profit-and-loss-account-report-table">

                            </div>
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
    </div>
</div>
<!-- /#page-wrapper -->

<script type="text/javascript">
    $(document).ready(function () {
        $('.profit-and-loss-account-report-block form').submit(function (event) {
            event.preventDefault();
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function (data) {
                    $(".profit-and-loss-account-report-table").html(data);
                },
                beforeSend: function () {
                    $('.loading-image').show();
                    $(".show-button-section").hide();
                },
                complete: function () {
                    $('.loading-image').hide();
                    $(".show-button-section").show();
                },
                error: function () {

                }
            });
        });
    });
</script>