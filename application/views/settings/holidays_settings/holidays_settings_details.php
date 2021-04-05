<div id="page-wrapper">
    <!--<div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">Bonus Incentive System List</h2>
        </div>
    </div>-->

    <?php
    $holidays_settings_list;
    /* echo '<pre>';
      print_r($holidays_settings_list);
      echo '<pre>'; */
    ?>

    <div class="col-xs-12 row card-margin-top">

        <div class="create-new-button">
            <?php echo anchor(base_url('settings/holidays_settings/create_holidays_settings'), '<i class=" fa fa-plus" aria-hidden="true"></i> Add Holiday', 'class="btn btn-primary create-new-button"') ?>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <form id="holidys-details-form" name="holidys-details-form" action="<?= base_url('settings/holidays_settings') ?>" method="post">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="">Holiday(s)</h4>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="col-xs-12">
                                <div class="form-group col-xs-12 col-sm-6">
                                    <label for="year" class="col-form-label">Year</label>
                                    <select name="year" id="year" class="form-control">
                                        <option value="" name="month">Please Select</option>
                                        <?php
                                        foreach (get_start_year_to_current_year_array() as $year) {
                                            ?>
                                            <option <?= (string) $event_show_year_session == (string) $year ? "selected='selected'" : '' ?> value="<?= $year ?>" name="year"><?= $year ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-xs-12 col-sm-6">
                                    <button type="submit" class="btn btn-default add-product-button holiday-list-show-button"
                                            id="holiday-list-show-button">Show
                                    </button>
                                </div>
                            </div>

                            <div class="table-responsive table-bordered">
                                <table class="table table-striped" id="details-table">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Date</th>
                                            <th class="action-fixed-width">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count = 1;
                                        foreach ($holidays_settings_list as $holidays_settings):
                                            ?>
                                            <?php $date = date("d-m-Y", strtotime($holidays_settings->date)); ?>
                                            <tr>
                                                <td><?= $count++ ?></td>
                                                <td><?= ucfirst($holidays_settings->title) ?></td>
                                                <td><?= ucfirst($holidays_settings->description) ?></td>
                                                <td><?= $date ?></td>
                                                <td class="action-fixed-width">
                                                    <a href="<?= base_url("settings/holidays_settings/update_holidays_settings/$holidays_settings->id") ?>"
                                                       class="btn btn-primary">
                                                        <i class=" fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                    <a onclick="return delete_confirm();"
                                                       href="<?= base_url("settings/holidays_settings/delete/$holidays_settings->id") ?>"
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
                </form>
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

        holidays_details_form();
        function holidays_details_form() {
            $("#holidys-details-form").validate({
                rules: {
                    year: "required",
                },
                messages: {
                    year: "Please Select a year",
                },
                submitHandler: function (form) {
                    form.submit();
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

    });</script>

<script>
    function delete_confirm() {
        var delete_confirmation_message = confirm("Are you sure to delete permanently?");
        if (delete_confirmation_message != true) {
            return false;
        }
    }
</script>

