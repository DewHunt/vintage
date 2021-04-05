<div id="page-wrapper">
    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class=""><?= !empty($page_title) ? $page_title : ''; ?></h4>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="col-xs-12 sales-details-statement-form-block">
                        <form id="sales-details-statement-form" class="sales-details-statement-form" name="branch-stock-report" method="post" action="<?= base_url('reports/sales_statement_report/sales_details_statement/sales_details_statement_report_show') ?>">
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
                                        <?php if (strtolower($user_type) != 'marketing') { ?>
                                            <option value="0" name="client_id">All</option>
                                            <option class="import-type-color" value="import" name="client_id">Import</option>
                                            <option class="lubzone-type-color" value="lubzone" name="client_id">Lubzone</option>
                                        <?php } else { ?>
                                            <option value="" name="client_id">Please Select</option>
                                        <?php }
                                        ?>                                       
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
                                <div class="form-group col-xs-12 col-sm-3 show-button-section">
                                    <label class="" for=""></label>
                                    <button type="submit" class="btn btn-primary show-button" id="show-button">Show</button>
                                </div>
                                <div class="col-xs-12 col-sm-3 display-none loading-image" style="padding-top: 40px;"></div>
                            </div>

                        </form>

                        <div class="sales-details-statement-table">

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
        $('.sales-details-statement-form-block form').submit(function (event) {
            event.preventDefault();
            var formClassName = 'sales-details-statement-form';
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
                        $(".sales-details-statement-table").html(data);
                    },
                    error: function () {
                        console.log('Error Occured.');
                    }
                });
            }
        });
    });
</script>
