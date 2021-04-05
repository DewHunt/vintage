<div id="page-wrapper">
    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class=""><?= !empty($page_title) ? $page_title : ''; ?></h4>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12 delivery-cost-report-form-block">
                            <form id="delivery-cost-report-form" name="delivery-cost-report-form" action="<?= base_url('reports/delivery_cost_report/delivery_cost_report_show_in_table') ?>" method="post">
                                <div class="form-group row">
                                    <div class="form-group col-xs-12 col-sm-3">
                                        <label class="search-from-date" for="start_date">From</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date"
                                               value="<?= get_current_date(); ?>">
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-3">
                                        <label class="search-from-date" for="end_date">To</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date"
                                               value="<?= get_current_date(); ?>">
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-3">
                                        <label class="form-control-label" for="client_id">Client</label>
                                        <select name="client_id" id="client_id" class="form-control">
                                            <?= (strtolower($user_type) === 'marketing') ? '<option value="" name="client_id">Please Select</option>' : '<option value="0" name="client_id">All</option>' ?> 
                                            <!--<option class="import-type-color" value="import" name="client_id">Import</option>-->
                                            <!--<option class="lubzone-type-color" value="lubzone" name="client_id">Lubzone</option>-->
                                            <?php
                                            if (!empty($client_list)) {
                                                foreach ($client_list as $client) {
                                                    ?>
                                                    <?php if (strtolower($client->client_type) == 'import') { ?>
                                                        <option class="import-type-color" value="<?= $client->id ?>" name="client_id"><?= $client->client_name ?></option>
                                                    <?php } else { ?>
                                                        <option class="lubzone-type-color" value="<?= $client->id ?>" name="client_id"><?= $client->client_name ?></option>
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <?php if (strtolower($user_type) === 'marketing') { ?>
                                        <div class="form-group col-xs-12 col-sm-3">
                                            <label class="" for="employee_id">Employee</label>
                                            <select class="form-control" name="employee_id" id="employee_id" class="form-control">
                                                <option value="<?= $employee_info->id ?>"><?= $employee_info->employee_name ?></option>
                                            </select>
                                        </div>

                                    <?php } else { ?>

                                        <div class="form-group col-xs-12 col-sm-3">
                                            <label class="" for="employee_id">Employee</label>
                                            <select class="form-control" name="employee_id" id="employee_id" class="form-control">
                                                <option value="0">All</option>
                                                <?php foreach ($employee_list as $employee) { ?>
                                                    <option value="<?= $employee->id ?>"><?= $employee->employee_name ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                    <?php } ?>
                                    <div class="form-group col-xs-12 col-sm-3 pull-right" style="padding-top: 20px">
                                        <button type="submit" class="btn btn-primary stock-transfer-challan-report-button pull-right" id="show-button">Show</button>
                                    </div>
                                </div>
                            </form>

                            <div class="col-xs-12 delivery-cost-report-table">

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

        $('.delivery-cost-report-form-block form').submit(function (event) {
            event.preventDefault();
            $.post($(this).attr('action'), $(this).serialize(), function (data) {
                $(".delivery-cost-report-table").html(data);
            });
        });

        $(".print-button").on("click", function () {

            var divContents = $('#print-information').html();

            var printWindow = window.open();
            printWindow.document.write(divContents);
            printWindow.document.close();
            printWindow.print();
            printWindow.close();
        });

        //Jquery Data Table
        $('#details-table').dataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [[25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]],
            "scrollY": "400px",
            "scrollX": true,
            "ordering": false,
        });
    });
</script>
