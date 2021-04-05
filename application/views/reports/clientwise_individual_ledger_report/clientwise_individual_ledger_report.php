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
                    <h4 class="">Clientwise Individual Ledger Report</h4>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12 client-individual-ledger-report-form-block">

                            <form id="client_details_ledger_report_form" name="client_details_ledger_report_form"
                                  action="<?= base_url('reports/clientwise_individual_ledger_report/clientwise_individual_ledger_report_show_in_table') ?>"
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

                                    <?php if (strtolower($user_type) === 'marketing') { ?>

                                        <div class="form-group col-xs-12 col-sm-3">
                                            <label class="form-control-label" for="client_id">Client</label>
                                            <select name="client_id" id="client_id" class="form-control">
                                                <option value="" name="client_id">Please Select</option>
                                                <?php
                                                if (!empty($all_client_by_employee_id)) {
                                                    foreach ($all_client_by_employee_id as $client) {
                                                        ?>
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
                                                }
                                                ?>
                                            </select>
                                        </div>

                                    <?php } else { ?>
                                        <div class="form-group col-xs-12 col-sm-3">
                                            <label class="form-control-label" for="client_id">Client</label>
                                            <select name="client_id" id="client_id" class="form-control">
                                                <option value="" name="client_id">Please Select</option>
                                                <?php
                                                if (!empty($client_list)) {
                                                    foreach ($client_list as $client) {
                                                        ?>
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
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    <?php } ?>

                                    <div class="form-group col-xs-12 col-sm-3" style="padding-top: 40px">
                                        <button type="submit" class="btn btn-primary stock-transfer-challan-report-button" id="show-button">Show</button>
                                    </div>
                                </div>
                            </form>

                            <div class="col-xs-12 client-individual-ledger-report-table">

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
        $('.client-individual-ledger-report-form-block form').submit(function (event) {
            event.preventDefault();
            $.post($(this).attr('action'), $(this).serialize(), function (data) {
                $(".client-individual-ledger-report-table").html(data);
            });
        });
    });
</script>