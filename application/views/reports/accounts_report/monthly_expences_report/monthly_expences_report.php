<div id="page-wrapper">
    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Monthly Expenses Report(Payment Side)(Dr)</h4>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12 monthly-expences-report-block">

                            <form id="monthly_expences_report_form" name="monthly_expences_report_form" action="<?= base_url('reports/accounts_report/monthly_expences_report/monthly_expences_report_show_in_table') ?>" method="post">

                                <div class="form-group row">
                                    <div class="form-group col-xs-12 col-sm-6">
                                        <label for="year" class="col-form-label">Year</label>
                                        <select name="year" id="year" class="form-control">
                                            <option value="" name="month">Please Select</option>
                                            <?php
                                            $current_year = get_current_year();
                                            foreach (get_start_year_to_current_year_array() as $year) {
                                                ?>
                                                <option <?= (string) $year == (string) $year ? "selected='selected'" : '' ?> value="<?= $year ?>" name="year"><?= $year ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-6 show-button-section" style="padding-top: 40px">
                                        <button type="submit" class="btn btn-primary stock-transfer-challan-report-button monthly-expences-show-button" id="show-button">Show</button>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 display-none loading-image" style="padding-top: 40px;"></div>
                                </div>
                            </form>
                            <div class="col-xs-12 monthly-expences-report-table">

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
        $('.monthly-expences-report-block form').submit(function (event) {
            event.preventDefault();
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function (data) {
                    $(".monthly-expences-report-table").html(data);
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