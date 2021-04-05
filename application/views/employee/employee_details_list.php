<div id="page-wrapper">

    <?php
        $employee_list;
    ?>

    <div class="row card-margin-top">
        <div class="clearfix"></div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <h4 class="">Employee Details</h4>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 float-right text-right">
                        <a type="button" href="<?= base_url('employee/create_new_employee'); ?>" class="btn btn-primary">
                            <i class=" fa fa-plus" aria-hidden="true"></i> Add New Employee
                        </a>
                        <!-- <a type="button" href="<?= base_url('employee/employee_target'); ?>" class="btn btn-primary">
                            <i class=" fa fa-plus" aria-hidden="true"></i> Target
                        </a> -->
                        <button type="button" class="btn btn-primary print-button">
                            <i class="fa fa-print" aria-hidden="true"></i> Print
                        </button>
                    </div>
                </div>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive table-bordered">
                    <div class="col-xs-12">
                    </div>
                    <table class="table table-striped" id="details-table">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Designation</th>
                                <th>Mobile</th>
                                <th>Blood Group</th>
                                <th>Loan</th>
                                <th class="action-fixed-width">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($employee_list as $employee):
                                ?>
                                <?php
                                $loan_status = '';
                                if (($employee->is_loan) == 1) {
                                    $loan_status = 'yes';
                                } else {
                                    $loan_status = 'no';
                                }
                                ?>
                                <tr>
                                    <td><?= $count++; ?></td>
                                    <td><?= ucfirst($employee->employee_name) ?></td>
                                    <td><?= $employee->employee_code ?></td>
                                    <td><?= ucfirst($employee->designation) ?></td>
                                    <td><?= $employee->mobile ?></td>
                                    <td><?= strtoupper($employee->blood_group) ?></td>
                                    <td><?= ucfirst($loan_status) ?></td>
                                    <td class="action-fixed-width">
                                        <a href="<?= base_url("employee/update_employee/$employee->id") ?>"
                                           class="btn btn-primary">
                                            <i class=" fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                        <a onclick="return delete_confirm();"
                                           href="<?= base_url("employee/delete/$employee->id") ?>"
                                           class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.panel-body -->
        </div>
    </div>


</div>
<!-- /#page-wrapper -->


<!--Display None-->
<!--For Print-->
<div id="print-information" style="width: 100%; display: none">

    <div style="width: 100%">
        <h2 style="text-align: center; font-size: 20px;">EMPLOYEE LIST<hr></h2>
    </div>

    <table border="2px" cellspacing="0" class="table table-striped" id="details-table">
        <thead>
            <tr>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    SL
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Employee Name
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Code
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Designation
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Mobile
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Blood Group
                </th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                    Loan Status
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            foreach ($employee_list as $employee):
                ?>
                <?php
                $loan_status = '';
                if (($employee->is_loan) == 1) {
                    $loan_status = 'yes';
                } else {
                    $loan_status = 'no';
                }
                ?>

                <tr style="border: thick">
                    <td><?= $count++; ?></td>
                    <td><?= ucfirst($employee->employee_name) ?></td>
                    <td><?= $employee->employee_code ?></td>
                    <td><?= ucfirst($employee->designation) ?></td>
                    <td><?= $employee->mobile ?></td>
                    <td><?= strtoupper($employee->blood_group) ?></td>
                    <td><?= ucfirst($loan_status) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<!--Jquery Data Table-->
<script type="text/javascript">

    $(".print-button").on("click", function () {

        var divContents = $('#print-information').html();

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

    $(document).ready(function () {
        $('#details-table').dataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [[25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]],
            "scrollY": "400px",
            "scrollX": true,
            "ordering": false,
        });
    });
</script>

<script>
    function delete_confirm() {
        var delete_confirmation_message = confirm("Are you sure to delete permanently?");
        if (delete_confirmation_message != true) {
            return false;
        }
    }
</script>

