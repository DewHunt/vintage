<div id="page-wrapper">
    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class=""><?= !empty($page_title) ? $page_title : ''; ?></h4>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="col-xs-12 sales-pfofit-report-form-block">
                        <form id="sales-pfofit-report-form" class="sales-pfofit-report-form" name="branch-stock-report" method="post" action="<?= base_url('reports/sales_statement_report/sales_pfofit_report/sales_pfofit_report_show') ?>">
                            <div class="form-group row">
                                <div class="form-group col-xs-12 col-sm-3">
                                    <label class="search-from-date" for="start_date">From</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" value="<?= get_current_date(); ?>">
                                </div>
                                <div class="form-group col-xs-12 col-sm-3">
                                    <label class="search-from-date" for="end_date">To</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" value="<?= get_current_date(); ?>">
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
                                <div class="form-group col-xs-12 col-sm-3 show-button-section pull-right">
                                    <label class="" for=""></label>
                                    <button type="submit" class="btn btn-primary show-button pull-right" id="show-button">Show</button>
                                </div>
                                <div class="col-xs-12 col-sm-3 display-none loading-image pull-right" style="padding-top: 40px;"></div>
                            </div>
                        </form>
                        <div class="sales-commission-table">

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
        $('.sales-pfofit-report-form-block form').submit(function (event) {
            event.preventDefault();
            var formClassName = 'sales-pfofit-report-form';
            var isValid = dateDurationInsideFormValidation(formClassName);
            if (isValid) {
                $.ajax({
                    type: "POST",
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    beforeSend: function () {
                        $('.loading-image').show();
                        $(".show-button-section").hide();
                    },
                    complete: function () {
                        $('.loading-image').hide();
                        $(".show-button-section").show();
                    },
                    success: function (data) {
                        $(".sales-commission-table").html(data);
                    },
                    error: function () {
                        console.log('Error Occured.');
                    }
                });
            }
        });
    });
</script>
