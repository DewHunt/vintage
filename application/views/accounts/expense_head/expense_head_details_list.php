<div id="page-wrapper">
    <div class="card-margin-top">

        <div class="create-new-button">
            <?php echo anchor(base_url('accounts/expense_head/create_new_expense_head'), '<i class=" fa fa-plus" aria-hidden="true"></i> Add New Expense Head', 'class="btn btn-primary create-new-button"') ?>
        </div>

        <div class="row">
            <!--<div class="col-lg-12">
                <h2 class="page-header">Expense Head Details</h2>
            </div>-->
        </div>

        <?php
        $expense_head_list;
        ?>

        <div class="row">
            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="">Expense Head Details</h4>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive table-bordered">
                            <table class="table table-striped" id="details-table">
                                <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Expense Head</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $count = 1;
                                foreach ($expense_head_list as $expense_head): ?>
                                    <tr>
                                        <td><?= $count++ ?></td>
                                        <td><?= $expense_head->head_name ?></td>
                                        <td>
                                            <a href="<?= base_url("accounts/expense_head/update_expense_head/$expense_head->id") ?>"
                                               class="btn btn-primary">
                                                <i class=" fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                            <!--<a onclick="return delete_confirm();" href="<? /*= base_url("accounts/expense_head/delete/$expense_head->id") */ ?>"
                                           class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></a>-->
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
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-6 -->
        </div>

    </div>

    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

<!--Jquery Data Table-->
<script type="text/javascript">
    $(document).ready(function () {
        $('#details-table').dataTable({
            //"aoColumnDefs": [{ "bSortable": false, "aTargets": [ -1, -2, -3,-4 ,-5, -6, ,-7, -8 ] }],
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

