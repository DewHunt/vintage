<div id="page-wrapper">
    <!--<div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">ClientWise Sale Report</h2>
        </div>
    </div>-->

    <?php
    $from_date = date('Y-m-d');
    $current_year = date('Y');

    /* echo '<pre>';
      echo print_r($periodic_report_list);
      echo '</pre>'; */
    ?>

    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Employee Yearly Benefit Report</h4>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                    <div class="col-xs-12 employee-yearly-benefit-report-form-block">
                        <form class="" name="branch-stock-report" method="post"
                              action="<?= base_url('reports/accounts_report/employee_yearly_benefit_report/employee_yearly_benefit_report_show') ?>">

                            <div class="form-group col-xs-12 col-sm-4">
                                <label for="year" class="col-form-label">Year</label>
                                <select name="year" id="year" class="form-control">
                                    <option value="" name="month">Please Select</option>
                                    <?php
                                    $start_Year = '2016';
                                    $current_year = date('Y');
                                    $diff = ($current_year - $start_Year);
                                    $last_year = ($start_Year + $diff);
                                    if ($start_Year == $current_year) {
                                        ?>
                                        <option value="<?= $current_year ?>" name="year"><?= $current_year ?></option>
                                        <?php
                                    } else {
                                        for ($i = $start_Year; $i <= $last_year; $i++) {
                                            ?>
                                            <option <?= (string) $current_year == (string) $i ? "selected='selected'" : '' ?> value="<?= $i ?>" name="year"><?= $i ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group col-xs-12 col-sm-4">
                                <label for="employee_id" class="col-form-label">Employee</label>
                                <label class="employee_id" for="employee_id"></label>
                                <select class="form-control" name="employee_id" id="employee_id"
                                        class="form-control">
                                    <option value="0">All</option>
                                    <?php foreach ($employee_list as $employee) { ?>
                                        <option name="employee_id" id="employee_id"
                                                value="<?= $employee->id ?>"><?= $employee->employee_name ?></option>
                                            <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-xs-12 col-sm-4 show-button-padding-top">
                                <button type="submit" class="btn btn-primary" id="show-button">Show</button>
                            </div>

                        </form>

                        <div class="col-xs-12 employee_yearly_benefit_report_table">

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
        $('.employee-yearly-benefit-report-form-block form').submit(function (event) {
            event.preventDefault();
            $.post($(this).attr('action'), $(this).serialize(), function (data) {
                $(".employee_yearly_benefit_report_table").html(data);
            });
        });
    });
</script>










