<div id="page-wrapper">
    <div class="card-margin-top">

        <div class="create-new-button">
            <?php echo anchor(base_url('assets_info/create_new_assets_info'), '<i class=" fa fa-plus" aria-hidden="true"></i> Add New Asset', 'class="btn btn-primary create-new-button"') ?>
        </div>

        <div class="row">
            <!--<div class="col-lg-12">
                <h2 class="page-header">Assets Details</h2>
            </div>-->
        </div>

        <?php
        $assets_info_list;
        ?>

        <?php if (!empty($this->session->flashdata('delete_error_message'))) { ?>
            <div class="col-lg-12 error-message text-align-center">
                <?php echo $this->session->flashdata('delete_error_message'); ?>
            </div>
        <?php } ?>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="">Assets Details</h4>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive table-bordered">
                            <table class="table table-striped" id="details-table">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Name</th>
                                        <th>Code</th>
                                        <th>Quantity</th>
                                        <th>Assigned Quantity</th>
                                        <th>Entry Date</th>
                                        <th class="action-fixed-width">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    foreach ($assets_info_list as $assets_info):
                                        ?>
                                        <?php $entry_date = date("d-m-Y", strtotime($assets_info->entry_date)); ?>
                                        <tr>
                                            <td><?= $count++ ?></td>
                                            <td><?= ucfirst($assets_info->assets_name) ?></td>
                                            <td><?= $assets_info->assets_code ?></td>
                                            <td><?= $assets_info->assets_quantity ?></td>
                                            <td><?= !empty($assets_info->assigned_assets_quantity) ? $assets_info->assigned_assets_quantity : 0 ?></td>
                                            <td><?= $entry_date ?></td>
                                            <td class="action-fixed-width">
                                                <a href="<?= base_url("assets_info/update_assets_info/$assets_info->id") ?>"
                                                   class="btn btn-primary">
                                                    <i class=" fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                <a onclick="return delete_confirm();" href="<?= base_url("assets_info/delete/$assets_info->id") ?>"
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


