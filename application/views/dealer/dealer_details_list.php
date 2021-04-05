<div id="page-wrapper">
    <!--<div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">Dealer Details</h2>
        </div>
    </div>-->

    <?php
    $dealer_list;
    ?>

    <div class="col-xs-12 row card-margin-top">

        <div class="create-new-button">
            <?php echo anchor(base_url('dealer/create_new_dealer'), '<i class=" fa fa-plus" aria-hidden="true"></i> Add New Dealer', 'class="btn btn-primary create-new-button"') ?>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="">Dealer Details</h4>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive table-bordered">
                            <table class="table table-striped" id="details-table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Code</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th class="action-fixed-width">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($dealer_list as $dealer): ?>
                                        <tr>
                                            <td><?= ucfirst($dealer->dealer_name) ?></td>
                                            <td><?= $dealer->dealer_code ?></td>
                                            <td><?= $dealer->email ?></td>
                                            <td><?= $dealer->cell_number ?></td>
                                            <td><?= $dealer->phone_number ?></td>
                                            <td><?= $dealer->address ?></td>
                                            <td class="action-fixed-width">
                                                <a href="<?= base_url("dealer/update_dealer/$dealer->id") ?>"
                                                   class="btn btn-primary">
                                                    <i class=" fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                <a onclick="return delete_confirm();" href="<?= base_url("dealer/delete/$dealer->id") ?>"
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

