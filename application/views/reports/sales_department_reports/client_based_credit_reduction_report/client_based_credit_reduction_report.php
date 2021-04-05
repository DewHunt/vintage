<div id="page-wrapper">
    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class=""><?= !empty($page_title) ? $page_title : ''; ?></h4>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="col-xs-12 client-based-credit-reduction-report-form-block">
                        <form id="client-based-credit-reduction-report-form" class="client-based-credit-reduction-report-form" name="client-based-credit-reduction-report" method="post" action="<?= base_url('reports/sales_department_reports/client_based_credit_reduction_report/client_based_credit_reduction_report_show_in_table') ?>">
                            <div class="form-group row">
                                <div class="form-group col-xs-12 col-sm-12 col-md-6 start-month-picker">
                                    <label class="search-from-date" for="start_month_year">From</label>
                                    <input type="text" class="form-control monthpicker" id="start_month_year" name="start_month_year" value="" readonly>
                                </div>
                                <div class="form-group col-xs-12 col-sm-12 col-md-6  end-month-picker">
                                    <label class="search-from-date" for="end_month_year">To</label>
                                    <input type="text" class="form-control monthpicker" id="end_month_year" name="end_month_year" value="" readonly>
                                </div>
                                 <?php if ((strtolower($user_type) === 'marketing')) { ?>
                                        <div class="form-group col-xs-12 col-sm-12 col-md-10">
                                            <label class="form-control-label" for="client_id">Client</label>
                                            <select name="client_id[]" id="client_id" class="form-control select2" multiple="multiple">
                                                <option value="-1" name="client_id">Please Select</option>
                                                <?php foreach ($all_client_by_employee_id as $client) { ?>
                                                    <?php if (strtolower($client->client_type) == 'import') { ?>
                                                        <option class="import-type-color" value="<?= $client->id ?>" name="client_id"><?= $client->client_name ?>
                                                        </option>
                                                    <?php } else { ?>
                                                        <option class="lubzone-type-color" value="<?= $client->id ?>" name="client_id"><?= $client->client_name ?>
                                                        </option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    <?php } else { ?>
                                        <div class="form-group col-xs-12 col-sm-12 col-md-10">
                                            <label class="form-control-label" for="client_id">Client</label>
                                            <select name="client_id[]" id="client_id" class="form-control select2" multiple="multiple">
                                                <?php foreach ($client_list as $client) { ?>
                                                    <?php if (strtolower($client->client_type) == 'import') { ?>
                                                        <option class="import-type-color" value="<?= $client->id ?>" name="client_id"><?= $client->client_name ?>
                                                        </option>
                                                    <?php } else { ?>
                                                        <option class="lubzone-type-color" value="<?= $client->id ?>" name="client_id"><?= $client->client_name ?>
                                                        </option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    <?php } ?>
                                <div class="form-group col-xs-12 col-sm-12 col-md-2 show-button-section">
                                    <label class="" for=""></label>
                                    <button type="submit" class="btn btn-primary show-button" id="show-button">Show</button>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-2 display-none loading-image" style="padding-top: 40px;"></div>
                            </div>
                        </form>
                        <div class="client-based-credit-reduction-report-table">

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

        $(function () {
            $('#start_month_year').monthpicker({
                className: '.start-month-picker',
                years: [<?= (implode(',', array_reverse(get_start_year_to_current_year_array()))) ?>],
                topOffset: 6,
                onMonthSelect: function (m, y) {
//                    console.log('Month: ' + m + ', year: ' + y);
                    $('#start_month_year').val('' + GetMonthName(m) + '- ' + y);
                }
            });
            $('#end_month_year').monthpicker({
                className: '.end-month-picker',
                years: [<?= (implode(',', array_reverse(get_start_year_to_current_year_array()))) ?>],
                topOffset: 6,
                onMonthSelect: function (m, y) {
//                    console.log('Month: ' + m + ', year: ' + y);
                    $('#end_month_year').val('' + GetMonthName(m) + '- ' + y);
                }
            });
        });

        $(".select2").select2({
            placeholder: "Please Select",
        });

        $('.client-based-credit-reduction-report-form-block form').submit(function (event) {
            event.preventDefault();
            var formClassName = 'client-based-credit-reduction-report-form';
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
                        $(".client-based-credit-reduction-report-table").html(data);
                    },
                    error: function () {
                        console.log('Error Occured.');
                    }
                });
            }
        });

    });
</script>
