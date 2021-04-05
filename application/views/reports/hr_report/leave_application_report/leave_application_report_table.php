<div id="page-wrapper">
    <div class="col-xs-12 row card-margin-top">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="">Leave Application Report</h4>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive table-bordered">
                            <table class="table table-striped" id="details-table">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Employee</th>
                                        <th>Employee code</th>
                                        <th>Leave type</th>
                                        <th>Duration</th>
                                        <th>Total day(s)</th>
                                        <th class="action-fixed-width">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    foreach ($is_show_leave_application_false_list as $is_show_leave_application_false) {
                                        ?>
                                        <?= $start_date = date('d-m-Y', strtotime($is_show_leave_application_false->start_date)) ?>
                                        <?= $end_date = date('d-m-Y', strtotime($is_show_leave_application_false->end_date)) ?>
                                        <tr>
                                            <td><?= $count++ ?></td>
                                            <td><?= ucfirst($is_show_leave_application_false->employee_name) ?></td>
                                            <td><?= $is_show_leave_application_false->employee_code ?></td>
                                            <td><?= ucfirst($is_show_leave_application_false->leave_type) ?></td>
                                            <td><?= ($start_date) . ' To ' . ($end_date) ?></td>
                                            <td><?= $is_show_leave_application_false->total_day ?></td>
                                            <td>
                                                <button class="btn btn-primary leave-application-view-button-<?= $is_show_leave_application_false->id ?>" data-toggle="tooltip" data-placement="bottom" title="View Details" data-id="<?= $is_show_leave_application_false->id ?>" data-action="<?= base_url('reports/hr_report/employee_leave_report/employee_leave_report/leave_application_report_show_in_modal') ?>"><i class="fa fa-eye" aria-hidden="true"></i></button>

                                                <script>
                                                    $('.leave-application-view-button-<?= $is_show_leave_application_false->id ?>').on('click', function (event) {
                                                        event.preventDefault();
                                                        $.post($(this).attr('data-action'), {'id': $(this).attr('data-id')}, function (data) {
                                                            $('.leave-application-details-information-modal .leave-application-show').html(data);
                                                            $('.leave-application-details-information-modal').modal('show');
                                                        });
                                                    });
                                                </script>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <div class="modal fade leave-application-details-information-modal">
                                <div class="modal-dialog modal-lg leave-application-show" role="document">

                                </div>
                            </div>
                            <div class="col-lg-12 reason-modal-block">
                                <input type="hidden" id="leave_application_id" name="leave_application_id" value="<?= !empty($is_show_leave_application_false->id) ? $is_show_leave_application_false->id : 0 ?>">
                                <?php $this->load->view('reports/hr_report/leave_application_report/leave_application_report_reject_reason', $this->data); ?>
                            </div>
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

        $('.reject-modal-close-button').click(function () {
            $('#reject-reason-modal').modal('hide');
        });

        $('.modal-close-button').click(function () {
            $('.leave-application-details-information-modal .leave-application-show').modal('hide');
        });

        $('#reject_reason').keyup(function () {
            $('#reject_reason').css("border-color", "#337ab7");
        });

        $('.reject-modal-ok-button').click(function () {
            var leave_application_id = $('#leave_application_id').val();
            var reject_reason = $('#reject_reason').val().trim();
            if (reject_reason.length <= 0) {
//                alert("Please Enter Reason");
                $('#reject_reason').css("border-color", "red");
            } else {
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url("reports/hr_report/employee_leave_report/employee_leave_report/reject_reason_update_in_leave_application/"); ?>',
                    data: {'leave_application_id': leave_application_id, 'reject_reason': reject_reason},
                    success: function (data) {
                        if (data == '1') { // 1 = true
                            $('#reject-reason-modal').modal('hide');
                        }
                    },
                    error: function () {

                    }
                });
            }
        });

    });
</script>


