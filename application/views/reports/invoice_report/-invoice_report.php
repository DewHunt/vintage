<div id="page-wrapper">
    <?php
    $from_date = date('Y-m-d');
    $user_info = $this->session->userdata('user_session');
    $user_type = $user_info['user_type'];
    $print_access = $user_info['print_access'];
    $invoice_details_view;
//    echo '<pre>';
//    echo print_r($print_access);
//    echo '</pre>';
    ?>

    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Invoice Details Report</h4>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12 invoice-report-form-block">

                            <form id="invoice_report_form" name="invoice_report_form"
                                  action="<?= base_url('reports/invoice_report/invoice_report_show_in_table') ?>"
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
                                                <option value="0" name="client_id">All</option>
                                                <option class="import-type-color" value="import" name="client_id">Import</option>
                                                <option class="lubzone-type-color" value="lubzone" name="client_id">Lubzone</option>
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
                                                <option value="0" name="client_id">All</option>
                                                <option class="import-type-color" value="import" name="client_id">Import</option>
                                                <option class="lubzone-type-color" value="lubzone" name="client_id">Lubzone</option>
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

                                    <div class="form-group col-xs-12 col-sm-3 pull-right card-margin-top">
                                        <button type="submit" class="btn btn-primary stock-transfer-challan-report-button pull-right" id="show-button">Show</button>
                                    </div>
                                </div>
                            </form>

                            <div class="col-xs-12 invoice-report-table">

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

        $('.invoice-report-form-block form').submit(function (event) {
            event.preventDefault();
            $.post($(this).attr('action'), $(this).serialize(), function (data) {
                $(".invoice-report-table").html(data);
            });
        });

        $(".print-button").on("click", function () {

            var divContents = $('#invoice-report-print-section').html();

            var printWindow = window.open();
            printWindow.document.write(divContents);
            printWindow.document.close();
            printWindow.print();
            printWindow.close();
        });
        function printDiv(divID) {
            //Get the HTML of div
            var divElements = document.getElementById(divID).innerHTML;
            //Get the HTML of whole page
            var oldPage = document.body.innerHTML;

            //Reset the page's HTML with div's HTML only
            document.body.innerHTML =
                    "<html><head><title></title></head><body>" +
                    divElements + "</body>";

            //Print Page
            window.print();
            //Restore orignal HTML
            document.body.innerHTML = oldPage;
        }

        $('#details-table').dataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [[25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]],
            "scrollY": "400px",
            "scrollX": true,
            "ordering": false,
        });
    });
</script>
