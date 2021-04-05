<div id="page-wrapper">
    <?php
    $loan_list;
    $employee_loan_list;
    ?>

    <div class="col-xs-12 row card-margin-top">
        <div class="create-new-button">
            <?php echo anchor(base_url('loan/create_new_loan'), '<i class=" fa fa-plus" aria-hidden="true"></i> Add New Loan', 'class="btn btn-primary create-new-button"') ?>
        </div>
        <div class="row">
            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="">Loan Details</h4>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive table-bordered">
                            <table class="table table-striped" id="details-table">
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                        <th>Loan Date</th>
                                        <th>Total Loan Amount</th>
                                        <th>Number of Installment</th>
                                        <th>Per Installment</th>
                                        <th>Total Paid Amount</th>
                                        <th>Due Amount</th>
                                        <!--<th>Action</th>-->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($employee_loan_list as $loan): ?>
                                        <?php $loan_start_date = date("d-m-Y", strtotime($loan->loan_start_date)); ?>
                                        <?php $due_amount = ($loan->total_loan_amount) - ($loan->total_installment_amount); ?>
                                        <tr>
                                            <td><?= ucfirst($loan->employee_name) ?></td>
                                            <td><?= $loan_start_date ?></td>
                                            <td><?= number_format((double) $loan->total_loan_amount, 2) ?></td>
                                            <td><?= $loan->number_of_installment ?></td>
                                            <td><?= number_format((double) $loan->per_installment_amount, 2) ?></td>
                                            <td><?= number_format((double) $loan->total_installment_amount, 2) ?></td>
                                            <td><?= number_format((double) $due_amount, 2) ?></td>

                                                <!-- <td>-->
                                                <!--<a href="<? /*= base_url("loan/update_loan/$loan->id") */ ?>"
                                                   class="btn btn-primary">
                                                    <i class=" fa fa-pencil-square-o" aria-hidden="true"></i></a>-->
                                                <!-- <a href="<? /*= base_url("loan/delete/$loan->id") */ ?>"
                                                   class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></a>-->
                                            <!--</td>-->
                                        </tr>
                                    <?php endforeach; ?>
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

<!--Jquery Data Table-->
<script type="text/javascript">
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

