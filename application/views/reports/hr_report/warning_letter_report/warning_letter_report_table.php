<div class="card card-boarder">

    <?php
    $user_info = $this->session->userdata('user_session');
    $user_type = $user_info['user_type'];
    $print_access = $user_info['print_access'];
    ?>
    <div class="col-xs-12 col-sm-8">
        <div class="col-xs-12">
            <label class="search-from-date">Employee: <?= $employee_name ?></label>
        </div>
    </div>
    <?php if ((strtolower($user_type) != 'marketing')) { ?>
        <?php if (!empty($print_access) > 0) { ?>
            <div class="col-xs-12 col-sm-4">
                <button type="button" class="right-side-view btn btn-primary report-print-button warning-letter-print-button"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
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
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            foreach ($warning_letter_by_employee as $warning_letter):
                ?>
                <?php $warning_date = date("d-m-Y", strtotime($warning_letter->warning_date)); ?>
                <?php $current_date = date("d-m-Y", strtotime($warning_letter->current_date_time)); ?>
                <tr>
                    <td><?= $count++ ?></td>
                    <td><?= ucfirst($warning_letter->employee_name) ?></td>
                    <td><?= $warning_letter->employee_code ?></td>
                    <td><?= ucfirst($warning_letter->designation) ?></td>
                    <td><?= $warning_date ?></td>
                    <td>
                        <button class="btn btn-primary warning-letter-view-button-<?= $warning_letter->id ?>" data-toggle="tooltip" data-placement="bottom" title="View Details" data-id="<?= $warning_letter->id ?>" data-action="<?= base_url('reports/hr_report/warning_letter_report/warning_letter_report_show_in_modal') ?>">
                            <i class="fa fa-eye" aria-hidden="true"></i></button>

                        <script>
                            $('.warning-letter-view-button-<?= $warning_letter->id ?>').on('click', function (event) {
                                event.preventDefault();
                                $.post($(this).attr('data-action'), {'id': $(this).attr('data-id')}, function (data) {
                                    $('.warning-letter-details-information-modal .warning-letter-show').html(data);
                                    $('.warning-letter-details-information-modal').modal('show');
                                });
                            });
                        </script>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="modal fade warning-letter-details-information-modal">
        <div class="modal-dialog modal-lg warning-letter-show" role="document">
        </div>
    </div>
</div>


<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="warning-letter-report-print-section" style="display: none; width: 100%" >

    <div class="col-xs-12">
        <h4 class="left-side-view" style="text-align: center"><?= strtoupper($company_information->company_name_1) ?></h4>
        <!--<h6 class="left-side-view" style="text-align: center"><?= $company_information->company_address_1 ?></h6>-->
    </div>

    <div class="col-xs-12">
        <label class="search-from-date"><strong>Warning Letter Report</strong></label><br>
    </div>
    <div class="col-xs-12">
        <label class="search-from-date">Employee: <?= $employee_name ?></label><br>
    </div>
    <hr>

    <table border="2px" cellspacing="0" class="table table-striped" id="details-table" style="width: 100%">
        <thead>
            <tr>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">SL</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Employee name</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Code</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Designation</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            foreach ($warning_letter_by_employee as $warning_letter):
                ?>
                <?php $warning_date = date("d-m-Y", strtotime($warning_letter->warning_date)); ?>
                <?php $current_date = date("d-m-Y", strtotime($warning_letter->current_date_time)); ?>
                <tr style="border: thick">
                    <td><?= $count++ ?></td>
                    <td><?= ucfirst($warning_letter->employee_name) ?></td>
                    <td><?= $warning_letter->employee_code ?></td>
                    <td><?= ucfirst($warning_letter->designation) ?></td>
                    <td><?= $warning_date ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>



<!--For Print-->
<script type="text/javascript">
    $(document).ready(function () {

        $(".warning-letter-print-button").on("click", function () {

            var divContents = $('#warning-letter-report-print-section').html();

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