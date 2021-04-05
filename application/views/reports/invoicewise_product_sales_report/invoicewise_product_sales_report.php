<div id="page-wrapper">
    <?php
    $from_date = date('Y-m-d');
    $user_info = $this->session->userdata('user_session');
    $user_id = $user_info['user_id'];
    $user_type = $user_info['user_type'];
    $employee_id = $user_info['employee_id'];
    ?>
    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Invoicewise Product Sales Report</h4>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12 invoicewise-product-sales-report-block">

                            <form id="client_accounts_individual_details_ledger_report_form" name="client_accounts_individual_details_ledger_report_form" action="<?= base_url('reports/invoicewise_product_sales_report/invoicewise_product_sales_report_show_in_table') ?>"
                                  method="post">

                                <div class="form-group row">

                                    <div class="form-group col-xs-12 col-sm-3">
                                        <label class="search-from-date" for="start_date">From</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date"
                                               value="<?= $from_date ?>">
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-3">
                                        <label class="search-from-date" for="end_date">To</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date"
                                               value="<?= $from_date ?>">
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-3">
                                        <label class="form-control-label" for="product_id">Product</label>
                                        <select class="form-control" name="product_id" id="product_id"
                                                class="form-control">
                                            <option value="0">All</option>
                                            <?php foreach ($product_list as $product) { ?>
                                                <option value="<?= $product->id ?>"><?= ucfirst($product->product_name) ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-3">
                                        <label class="form-control-label" for="client_id">Client</label>
                                        <select name="client_id" id="client_id" class="form-control">
                                            <option value="0" name="client_id">All</option>
                                            <option class="import-type-color" value="import" name="client_id">Import</option>
                                            <option class="lubzone-type-color" value="lubzone" name="client_id">Lubzone</option>
                                            <?php foreach ($client_list as $client) { ?>
                                                <?php if (strtolower($client->client_type) == 'import') { ?>
                                                    <option class="import-type-color" value="<?= $client->id ?>" name="client_id"><?= ucfirst($client->client_name) ?>
                                                    </option>
                                                <?php } else { ?>
                                                    <option class="lubzone-type-color" value="<?= $client->id ?>" name="client_id"><?= ucfirst($client->client_name) ?>
                                                    </option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-6"></div>
                                    <div class="form-group col-xs-12 col-sm-3">
                                        <label class="search-from-date" for="branch_id">Outlet</label>
                                        <select class="form-control branch_id" name="branch_id" id="branch_id">
                                            <option value="0">All</option>
                                            <?php
                                            if (!empty($branch_list)) {
                                                foreach ($branch_list as $branch) {
                                                    ?>
                                                    <option value="<?= intval($branch->id) ?>"><?= ucfirst($branch->branch_name) ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-3" style="padding-top: 40px">
                                        <button type="submit" class="btn btn-primary btn-block stock-transfer-challan-report-button pull-right" id="show-button">Show</button>
                                    </div>
                                </div>
                            </form>

                            <div class="col-xs-12 invoicewise-product-sales-report-table">

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
        $('.invoicewise-product-sales-report-block form').submit(function (event) {
            event.preventDefault();
            $.post($(this).attr('action'), $(this).serialize(), function (data) {
                $(".invoicewise-product-sales-report-table").html(data);
            });
        });
    });
</script>