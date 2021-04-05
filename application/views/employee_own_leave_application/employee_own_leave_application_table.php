<div class="card card-boarder">
    <div class="col-xs-12 col-sm-8">
        <div class="col-xs-12">
            <label class="search-from-date">Year: <?= !empty($year) ? $year : '' ?></label><br>
            <label class="search-from-date">Employee: <?= !empty($employee->employee_name) ? ucfirst($employee->employee_name) : '' ?></label><br>
            <label class="search-from-date">Code: <?= !empty($employee->employee_code) ? ucfirst($employee->employee_code) : '' ?></label><br>
            <label class="search-from-date">Designation: <?= !empty($employee->designation) ? ucfirst($employee->designation) : '' ?></label><br>
        </div>
    </div>
    <table class="table table-striped" id="details-table">
        <thead>
            <tr>
                <th>SL</th>
                <th>Duration</th>
                <th>Total Day(s)</th>
                <th>Leave Type</th>
                <th>Application Status</th>
                <th class="action-fixed-width">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            foreach ($leave_application_list_by_employee_year_status as $leave_application):
                ?>
                <?php $start_date = date("d-m-Y", strtotime($leave_application->start_date)); ?>
                <?php $end_date = date("d-m-Y", strtotime($leave_application->end_date)); ?>                
                <tr>
                    <td><?= $count++ ?></td>
                    <td><?= ($start_date) . ' To ' . ($end_date) ?></td>
                    <td><?= ucfirst($leave_application->total_day) ?></td>
                    <td><?= ucfirst($leave_application->leave_type) ?></td>
                    <td><?= ucfirst($leave_application->application_status) ?></td>
                    <td>
                        <button class="btn btn-primary employee-own-leave-application-view-button-<?= $leave_application->id ?>" data-toggle="tooltip" data-placement="bottom" title="View Details" data-id="<?= $leave_application->id ?>" data-action="<?= base_url('employee_own_leave_application/employee_own_leave_application_show_in_modal') ?>">
                            <i class="fa fa-eye" aria-hidden="true"></i></button>

                        <script>
                            $('.employee-own-leave-application-view-button-<?= $leave_application->id ?>').on('click', function (event) {
                                event.preventDefault();
                                $.post($(this).attr('data-action'), {'id': $(this).attr('data-id')}, function (data) {
                                    $('.employee-own-leave-application-information-modal .employee-own-leave-application-show').html(data);
                                    $('.employee-own-leave-application-information-modal').modal('show');
                                });
                            });
                        </script>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="modal fade employee-own-leave-application-information-modal">
        <div class="modal-dialog modal-lg employee-own-leave-application-show " role="document">
        </div>
    </div>
</div>


<!--For Print-->
<script type="text/javascript">
    $(document).ready(function () {

        $(".employee-evaluation-print-button").on("click", function () {

            var divContents = $('#employee-evaluation-report-print-section').html();

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

        $('#details-table').dataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [[25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]],
            "scrollY": "400px",
            "scrollX": true,
            "ordering": false,
        });
    });
</script>