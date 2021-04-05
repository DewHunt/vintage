<div id="page-wrapper">
    <!--<div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">ClientWise Sale Report</h2>
        </div>
    </div>-->

    <?php
    $client_list;
    $from_date = date('Y-m-d');

    /* echo '<pre>';
      echo print_r($periodic_report_list);
      echo '</pre>'; */
    ?>

    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">ClientWise Accounts Report</h4>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                    <div class="col-xs-12 client-wise-sales-report-form-block">
                        <form class="" name="branch-stock-report" method="post"
                              action="<?= base_url('reports/accounts_report/clientwise_accounts_report/clientwise_accounts_report_show') ?>">
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
                                    <label class="client_id" for="client_id">Client</label>
                                    <select name="client_id" id="client_id" class="form-control">
                                        <option value="0" name="client_id">All</option>
                                        <?php foreach ($client_list as $client) { ?>
                                            <?php if (strtolower($client->client_type) == 'import') { ?>
                                                <option class="import-type-color"
                                                        value="<?= $client->id ?>"
                                                        name="client_id"><?= $client->client_name ?>
                                                </option>
                                            <?php } else { ?>
                                                <option class="lubzone-type-color"
                                                        value="<?= $client->id ?>"
                                                        name="client_id"><?= $client->client_name ?>
                                                </option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-xs-12 col-sm-3 show-button-padding-top">
                                    <label class="" for=""></label>
                                    <button type="submit" class="btn btn-primary" id="show-button">Show</button>
                                </div>
                            </div>

                        </form>

                        <div class="col-xs-12 client-wise-sales-report-table">

                        </div>
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
        $('.client-wise-sales-report-form-block form').submit(function (event) {
            event.preventDefault();
            $.post($(this).attr('action'), $(this).serialize(), function (data) {
                $(".client-wise-sales-report-table").html(data);
            });
        });
    });
</script>