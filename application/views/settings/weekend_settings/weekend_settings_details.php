<div id="page-wrapper">
    <!--<div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">Bonus Incentive System List</h2>
        </div>
    </div>-->

    <?php
    $weekend_settings_list;
    ?>

    <div class="col-xs-12 row card-margin-top">

        <div class="create-new-button">
            <?php echo anchor(base_url('settings/weekend_settings/create_weekend_settings'), '<i class=" fa fa-plus" aria-hidden="true"></i> Add Weekend Day', 'class="btn btn-primary create-new-button"') ?>
        </div>

        <div class="row">
            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="">Weekend Day(s)</h4>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive table-bordered">
                            <table class="table table-striped" id="details-table">
                                <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Weekend Day</th>
                                    <th class="action-fixed-width">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $count = 1;
                                foreach ($weekend_settings_list as $weekend_settings): ?>
                                    <tr>
                                        <td><?= $count++ ?></td>
                                        <td><?= ucfirst($weekend_settings->weekend_day) ?></td>
                                        <td class="action-fixed-width">
                                            <a href="<?= base_url("settings/weekend_settings/update_weekend_settings/$weekend_settings->id") ?>"
                                               class="btn btn-primary">
                                                <i class=" fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                            <a onclick="return delete_confirm();" href="<?= base_url("settings/weekend_settings/delete/$weekend_settings->id") ?>"
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

