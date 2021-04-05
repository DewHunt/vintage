<div class="card card-boarder">

    <?php
    $user_info = $this->session->userdata('user_session');
    $user_type = $user_info['user_type'];
    $print_access = $user_info['print_access'];
    ?>
    <div class="col-xs-12 col-sm-8">
        <div class="col-xs-12">
            <label class="search-from-date">Year: <?= $year ?></label><br>
            <label class="search-from-date">Employee: <?= $employee_name ?></label>
        </div>
    </div>
    <?php if ((strtolower($user_type) != 'marketing')) { ?>
        <?php if (!empty($print_access) > 0) { ?>
            <div class="col-xs-12 col-sm-4">
                <button type="button" class="right-side-view btn btn-primary report-print-button employee-evaluation-print-button"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
            </div>
            <?php
        }
    }
    ?>

    <table class="table table-striped" id="details-table">
        <thead>
            <tr>
                <th>SL</th>
                <th>Employee name</th>
                <th>Code</th>
                <th>Designation</th>
                <th>Duration</th>
                <th>Overall Rating</th>
                <th>Generate Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            foreach ($employee_evaluation_by_employee_and_year as $employee_evaluation):
                ?>
                <?php $start_date = date("d-m-Y", strtotime($employee_evaluation->start_date)); ?>
                <?php $end_date = date("d-m-Y", strtotime($employee_evaluation->end_date)); ?>
                <?php $generate_date = date("d-m-Y", strtotime($employee_evaluation->current_date_time)); ?>
                <?php
                $overall_rating = '';
                if ((int) $employee_evaluation->overall_rating == 1) {
                    $overall_rating = 'Excellent';
                } elseif ((int) $employee_evaluation->overall_rating == 2) {
                    $overall_rating = 'Good';
                } elseif ((int) $employee_evaluation->overall_rating == 3) {
                    $overall_rating = 'Satisfactory';
                } elseif ((int) $employee_evaluation->overall_rating == 4) {
                    $overall_rating = 'Fair';
                } else {
                    $overall_rating = 'Poor';
                }
                ?>
                <tr>
                    <td><?= $count++ ?></td>
                    <td><?= ucfirst($employee_evaluation->employee_name) ?></td>
                    <td><?= $employee_evaluation->employee_code ?></td>
                    <td><?= ucfirst($employee_evaluation->designation) ?></td>
                    <td><?= ($start_date) . ' To ' . ($end_date) ?></td>
                    <td><?= $overall_rating ?></td>
                    <td><?= $generate_date ?></td>
                        <td>
                        <button class="btn btn-primary employee-evaluation-view-button-<?= $employee_evaluation->id ?>"
                                data-toggle="tooltip" data-placement="bottom"
                                title="View Details"
                                data-id="<?= $employee_evaluation->id ?>"
                                data-action="<?= base_url('reports/hr_report/employee_evaluation_report/employee_evaluation_report_show_in_modal') ?>">
                            <i class="fa fa-eye" aria-hidden="true"></i></button>

                        <script>
                            $('.employee-evaluation-view-button-<?= $employee_evaluation->id ?>').on('click', function (event) {
                                event.preventDefault();
                                $.post($(this).attr('data-action'), {'id': $(this).attr('data-id')}, function (data) {
                                    $('.employee-evaluation-details-information-modal .employee-evaluation-show').html(data);
                                    $('.employee-evaluation-details-information-modal').modal('show');
                                });
                            });
                        </script>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="modal fade employee-evaluation-details-information-modal">
        <div class="modal-dialog modal-lg employee-evaluation-show " role="document">
        </div>
    </div>
</div>


<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="employee-evaluation-report-print-section" style="display: none; width: 100%" >

    <div class="col-xs-12">
        <h4 class="left-side-view" style="text-align: center"><?= strtoupper($company_information->company_name_1) ?></h4>
        <!--<h6 class="left-side-view" style="text-align: center"><?= $company_information->company_address_1 ?></h6>-->
    </div>

    <div class="col-xs-12">
        <label class="search-from-date"><strong>Employee Evaluation Report</strong></label><br>
    </div>
    <div class="col-xs-12">
        <label class="search-from-date">Year: <?= $year ?></label><br>
    </div>
    <div class="col-xs-12">
        <label class="search-from-date">Employee: <?= $employee_name ?></label><br>
    </div>
    <hr>

    <table border="2px" cellspacing="0" class="table table-striped" id="details-table">
        <thead>
            <tr>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">SL</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Employee name</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Code</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Designation</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Duration</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Overall Rating</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Generate Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            foreach ($employee_evaluation_by_employee_and_year as $employee_evaluation):
                ?>
                <?php $start_date = date("d-m-Y", strtotime($employee_evaluation->start_date)); ?>
                <?php $end_date = date("d-m-Y", strtotime($employee_evaluation->end_date)); ?>
                <?php $generate_date = date("d-m-Y", strtotime($employee_evaluation->current_date_time)); ?>
                <?php
                $overall_rating = '';
                if ((int) $employee_evaluation->overall_rating == 1) {
                    $overall_rating = 'Excellent';
                } elseif ((int) $employee_evaluation->overall_rating == 2) {
                    $overall_rating = 'Good';
                } elseif ((int) $employee_evaluation->overall_rating == 3) {
                    $overall_rating = 'Satisfactory';
                } elseif ((int) $employee_evaluation->overall_rating == 4) {
                    $overall_rating = 'Fair';
                } else {
                    $overall_rating = 'Poor';
                }
                ?>
                <tr style="border: thick">
                    <td><?= $count++ ?></td>
                    <td><?= ucfirst($employee_evaluation->employee_name) ?></td>
                    <td><?= $employee_evaluation->employee_code ?></td>
                    <td><?= ucfirst($employee_evaluation->designation) ?></td>
                    <td><?= ($start_date) . ' To ' . ($end_date) ?></td>
                    <td><?= $overall_rating ?></td>
                    <td><?= $generate_date ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

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

//        $('.invoice-view-button').on('click', function (event) {
//            event.preventDefault();
//            $.post($(this).attr('data-action'), {'id': $(this).attr('data-id')}, function (data) {
//                $('.invoice-details-information-modal .invoice-show').html(data);
//                $('.invoice-details-information-modal').modal('show');
//            });
//        });
    });
</script>