<div id="page-wrapper">
    <div class="col-xs-12 row card-margin-top">
        <div class="create-new-button">
            <?php echo anchor(base_url('employee/create_new_target'), ' <i class=" fa fa-plus" aria-hidden="true"></i> Add New Target', 'class="btn btn-primary create-new-button"') ?>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <h4 class=""><?= !empty($page_title) ? $page_title : ""; ?></h4>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive table-bordered">
                            <div class="col-xs-12">
<!--                                <button type="button" class="right-side-view btn btn-primary print-button"><i class="fa fa-print" aria-hidden="true"></i>Print
                                </button>-->
                            </div>
                            <table class="table table-striped" id="details-table">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Name</th>
                                        <th>Code</th>
                                        <th class="">Start Date</th>
                                        <th class="text-right">Target</th>
                                        <th class="action-fixed-width">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    $total_target_amount = 0;
                                    if (!empty($employee_target_list)) {
                                        foreach ($employee_target_list as $employee) {
                                            $start_date = !empty($employee->target_start_date) ? $employee->target_start_date : '';
                                            $target_amount = get_floating_point_number($employee->target_amount);
                                            $total_target_amount += $target_amount;
                                            ?>
                                            <tr>
                                                <td><?= $count++; ?></td>
                                                <td><?= ucfirst($employee->employee_name) ?></td>
                                                <td><?= $employee->employee_code ?></td>
                                                <td class=""><?= get_string_to_date_fromat($start_date); ?></td>
                                                <td class="text-right"><?= get_floating_point_number($target_amount, TRUE) ?></td>
                                                <td class="action-fixed-width">
                                                    <a href="<?= base_url("employee/update_employee_target/$employee->id") ?>" class="btn btn-primary">
                                                        <i class=" fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                        <?php }
                                        ?>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td><strong></strong></td>
                                            <td><strong>Total</strong></td>
                                            <td class="text-right"><strong><?= get_floating_point_number($total_target_amount, TRUE) ?></strong></td>
                                            <td class=""></td>
                                        </tr>
                                    <?php }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-6 -->
        </div>
        <!-- /.row -->

    </div>


</div>
<!-- /#page-wrapper -->


<!--Display None-->
<!--For Print-->

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

