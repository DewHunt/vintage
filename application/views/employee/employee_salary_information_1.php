<!--Salary deatails show in a table-->
<div id="page-wrapper">
    <?php
    $employee_list;
    $employee_salary_details;

//    $model_salary = new Salary_details_Model();
//    $is_salary_generate_or_not = FALSE;
//    $res = $model_salary->get_salary_details_by_month_year($month, $year);
//    if (!empty($res)) {
//        $is_salary_generate_or_not = TRUE;
//    } else {
//        $is_salary_generate_or_not = FALSE;
//    }
    ?>

    <div class="col-xs-12 error-message text-align-center">
        <?php
        echo $this->session->flashdata('selected_month_year_error_message');
        ?>
    </div>

    <div class="col-xs-12 success-message text-align-center">
        <?php
        echo $this->session->flashdata('salary_generate_success_message');
        ?>
    </div>

    <div class="row card-margin-top">
        <form id="employee_salary_generate_form" name="employee_salary_generate_form" action="<?= base_url('employee_salary_generate/salary_generate') ?>" method="post">

            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="">Employee Salary Generate</h4>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="form-group col-xs-12 col-sm-4">
                            <label for="month" class="col-form-label">Month</label>
                            <select name="month" id="month" class="form-control">
                                <option value="" name="month">Please Select</option>
                                <?php foreach (get_months_name_array() as $month) { ?>
                                    <?php
                                    if (!empty($this->session->flashdata('month_name_flashdata'))) {
                                        $curr_month_name = $this->session->flashdata('month_name_flashdata');
                                    } else {
                                        $curr_month_name = get_current_month_name();
                                    }
                                    ?>
                                    <option <?= strtolower($curr_month_name) == strtolower($month) ? "selected='selectd'" : '' ?> value="<?= strtolower($month) ?>" name="month"><?= $month ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group col-xs-12 col-sm-4">
                            <label for="year" class="col-form-label">Year</label>
                            <select name="year" id="year" class="form-control">
                                <option value="" name="month">Please Select</option>
                                <?php
                                if (!empty($this->session->flashdata('year_flashdata'))) {
                                    $current_year = $this->session->flashdata('year_flashdata');
                                } else {
                                    $current_year = get_current_year();
                                }
                                ?>
                                <?php
                                foreach (get_start_year_to_current_year_array() as $year) {
                                    ?>
                                    <option <?= (string) $current_year == (string) $year ? "selected='selected'" : '' ?> value="<?= $year ?>" name="year"><?= $year ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group col-xs-12 col-sm-4">
                            <button type="submit" class="btn btn-default add-product-button salary-generate-confirm-button"
                                    id="salary-generate-button">Salary Generate
                            </button>
                        </div>

                        <!--<div class="form-group col-xs-12 error-message">
                        <?php /* if (!empty($this->session->flashdata('salary_generate_error'))) {
                          echo $this->session->flashdata('salary_generate_error');
                          } */ ?>
                        </div>-->
                        <div class="col-xs-12 table-responsive table-bordered">
                            <div class="col-xs-12">
                                <button type="button" class="right-side-view btn btn-primary print-button salary-table-print-button"><i
                                        class="fa fa-print" aria-hidden="true"></i>
                                    Print
                                </button>
                            </div>
                        </div>

                        <div class="table-responsive table-bordered">
                            <table class="table table-striped" id="details-table">
                                <thead>
                                    <tr>
                                        <th>Employee Name</th>
                                        <th>Employee Code</th>
                                        <th>Mobile</th>
                                        <th>Month</th>
                                        <th>Gross Salary</th>
                                        <th>Net Salary</th>
                                        <th>Take Home Salary</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total_gross_salary = 0;
                                    $total_net_salary = 0;
                                    $total_take_home_salary = 0;
                                    foreach ($employee_salary_details as $salary_details):
                                        ?>
                                        <?php $total_gross_salary += (double) $salary_details->gross_salary ?>
                                        <?php $total_net_salary += (double) $salary_details->net_salary ?>
                                        <?php $total_take_home_salary += (double) $salary_details->take_home_salary ?>
                                        <tr>
                                            <td><?= ucfirst($salary_details->employee_name) ?></td>
                                            <td><?= $salary_details->employee_code ?></td>
                                            <td><?= $salary_details->mobile ?></td>
                                            <td><?= ucfirst($salary_details->month) ?></td>
                                            <td><?= number_format((double) $salary_details->gross_salary, 2) ?></td>
                                            <td><?= number_format((double) $salary_details->net_salary, 2) ?></td>
                                            <td><?= number_format((double) $salary_details->take_home_salary, 2) ?></td>
                                            <td>
                                                <a href="<?= base_url("employee_salary_generate/employee_salary_details/$salary_details->id") ?>"
                                                   class="btn btn-primary"> <i class=" fa fa-eye" aria-hidden="true"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><strong>Grand Total</strong></td>
                                        <td><strong><?= number_format($total_gross_salary, 2) ?></strong></td>
                                        <td><strong><?= number_format($total_net_salary, 2) ?></strong></td>
                                        <td><strong><?= number_format($total_take_home_salary, 2) ?></strong></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
        </form>
        <!-- /.col-lg-6 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->


<!--Display None-->
<!--For Print-->
<div id="salary-table-print-information" style="width: 100%; display: none">

    <div style="width: 100%">
        <h2 style="text-align: center; font-size: 20px;">SALARY LIST<hr></h2>
    </div>

    <table border="2px" cellspacing="0" class="table table-striped" id="details-table">
        <thead>
            <tr>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Employee Name</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Employee Code</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Mobile</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Month</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Gross Salary</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Net Salary</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Take Home Salary</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total_gross_salary = 0;
            $total_net_salary = 0;
            $total_take_home_salary = 0;
            foreach ($employee_salary_details as $salary_details):
                ?>
                <?php $total_gross_salary += (double) $salary_details->gross_salary ?>
                <?php $total_net_salary += (double) $salary_details->net_salary ?>
                <?php $total_take_home_salary += (double) $salary_details->take_home_salary ?>
                <tr style="border: thick">
                    <td><?= ucfirst($salary_details->employee_name) ?></td>
                    <td><?= $salary_details->employee_code ?></td>
                    <td><?= $salary_details->mobile ?></td>
                    <td><?= ucfirst($salary_details->month) . '-' . $salary_details->year ?></td>
                    <td><?= number_format((double) $salary_details->gross_salary, 2) ?></td>
                    <td><?= number_format((double) $salary_details->net_salary, 2) ?></td>
                    <td><?= number_format((double) $salary_details->take_home_salary, 2) ?></td>
                </tr>
            <?php endforeach; ?>
            <tr style="border: thick">
                <td></td>
                <td></td>
                <td></td>
                <td><strong>Grand Total</strong></td>
                <td><strong><?= number_format($total_gross_salary, 2) ?></strong></td>
                <td><strong><?= number_format($total_net_salary, 2) ?></strong></td>
                <td><strong><?= number_format($total_take_home_salary, 2) ?></strong></td>
            </tr>
        </tbody>
    </table>

</div>

<!--Jquery Data Table-->
<script type="text/javascript">
    $(document).ready(function () {

        employee_salary_generate_form();
        function employee_salary_generate_form() {
            $("#employee_salary_generate_form").validate({
                rules: {
                    month: "required",
                    year: "required",
                },
                messages: {
                    month: "Please Select a Month",
                    year: "Please Select a year",
                },
                submitHandler: function (form) {
                    var month = $("option[name=month]:selected").attr('value');
                    var year = $("option[name=year]:selected").attr('value');
                    $.ajax({
                        type: "POST",
                        url: '<?php echo base_url("employee_salary_generate/is_salary_generate_or_not/") ?>',
                        data: {'month': month, 'year': year},
                        success: function (data) {
                            if (data != true) {
                                var salary_generate_confirm_message = confirm("Are you sure to generate salary?");
                                if (salary_generate_confirm_message != true) {
                                    return false;
                                } else {
                                    form.submit();
                                }
                            } else {
                                form.submit();
                            }

                        },
                        error: function () {

                        }
                    });

                }
            });
        }

        $('#details-table').dataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [[25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]],
            "scrollY": "400px",
            "scrollX": true,
            "ordering": false,
        });

        $(".salary-table-print-button").on("click", function () {

            var divContents = $('#salary-table-print-information').html();

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
    });
</script>


