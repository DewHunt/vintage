<div id="page-wrapper">
    <!--<div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">Total Loan Report</h2>
        </div>
    </div>-->

    <?php
    $employee_list;
    $from_date = date('Y-m-d');

    /* echo '<pre>';
      echo print_r($periodic_report_list);
      echo '</pre>'; */
    ?>

    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Employee Total Loan Report</h4>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                    <div class="col-xs-12 employee_total_loan_report-form-block">
                        <form class="" name="employee_total_loan_report_form" method="post"
                              action="<?= base_url('reports/employee_total_loan_report/employee_wise_total_loan_report_show') ?>">
                            <div class="form-group row">
                                <div class="form-group col-xs-12 col-sm-4">
                                    <label class="search-from-date" for="start_date">From</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date"
                                           value="<?= $from_date ?>">
                                </div>
                                <div class="form-group col-xs-12 col-sm-4">
                                    <label class="search-from-date" for="end_date">To</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date"
                                           value="<?= $from_date ?>">
                                </div>
                                <div class="form-group col-xs-12 col-sm-4">
                                    <label class="branch_id" for="employee_id">Employee</label>
                                    <select class="form-control" name="employee_id" id="employee_id" class="form-control">
                                        <option value="0">All</option>
                                        <?php foreach ($employee_list as $employee) { ?>
                                            <option value="<?= $employee->id ?>"><?= $employee->employee_name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group row">
                                    <button style="margin-right: 30px" type="submit" class="btn btn-primary save-button" id="show-button">Show</button>
                                </div>
                            </div>
                        </form>
                        <div class="col-md-12 col-xs-12 employee_total_loan_report_table">

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
        $('.employee_total_loan_report-form-block form').submit(function (event) {
            event.preventDefault();
            $.post($(this).attr('action'), $(this).serialize(), function (data) {
                $(".employee_total_loan_report_table").html(data);
            });
        });
    });
</script>











