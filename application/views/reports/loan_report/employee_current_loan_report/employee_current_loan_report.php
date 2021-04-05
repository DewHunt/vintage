<div id="page-wrapper">
    <?php
    $employee_list;
    //$employee_wise_report_view_by_date;
    $from_date = date('Y-m-d');

    /* echo '<pre>';
      echo print_r($periodic_report_list);
      echo '</pre>'; */
    ?>

    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Employee Current Loan Report</h4>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                    <div class="col-xs-12 employee_current_loan_report_form_block">
                        <form class="" name="order-report" method="post"
                              action="<?= base_url('reports/employee_total_loan_report/employee_current_total_loan_report_show') ?>">
                            <div class="form-group row">
                                <div class="col-xs-6">
                                    <select class="form-control" name="employee_id" id="employee_id"
                                            class="form-control">
                                        <option value="0">All</option>
                                        <?php foreach ($employee_list as $employee) { ?>
                                            <option name="employee_id" value="<?= $employee->id ?>"><?= $employee->employee_name ?></option>
                                                <?php } ?>
                                    </select>
                                </div>
                                
                                <div class="col-xs-6">
                                    <button type="submit" class="btn btn-primary" id="show-button">Show</button>
                                </div>
                            </div>

                        </form>
                        <div class="col-md-12 col-xs-12 employee_current_loan_report_table">

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
        $('.employee_current_loan_report_form_block form').submit(function (event) {
            event.preventDefault();
            $.post($(this).attr('action'), $(this).serialize(), function (data) {
                $(".employee_current_loan_report_table").html(data);
            });
        });
    });
</script>








