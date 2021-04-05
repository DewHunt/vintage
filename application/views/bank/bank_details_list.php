<div id="page-wrapper">
    <!--<div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">Bank Details</h2>
        </div>
    </div>-->

    <?php
    $bank_list;
    ?>

    <div class="col-xs-12 row card-margin-top">

        <div class="create-new-button">
            <?php echo anchor(base_url('bank/create_new_bank'), '<i class=" fa fa-plus" aria-hidden="true"></i> Add New Bank', 'class="btn btn-primary create-new-button"') ?>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="">Bank Details</h4>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive table-bordered">
                            <table class="table table-striped" id="details-table">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Bank Name</th>
                                        <th>Branch Name</th>
                                        <th>Branch Location</th>
                                        <th class="action-fixed-width">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $count = 1;
                                    foreach ($bank_list as $bank):
                                        ?>
                                        <tr>
                                            <td><?= $count++ ?></td>
                                            <td><?= ucfirst($bank->bank_name) ?></td>
                                            <td><?= ucfirst($bank->branch_name) ?></td>
                                            <td><?= ucfirst($bank->branch_location) ?></td>
                                            <td class="action-fixed-width">
                                                <a href="<?= base_url("bank/update_bank/$bank->id") ?>"
                                                   class="btn btn-primary">
                                                    <i class=" fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                <a onclick="return delete_confirm();"
                                                   href="<?= base_url("bank/delete/$bank->id") ?>"
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


