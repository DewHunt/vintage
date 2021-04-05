<div class="card card-boarder">

    <?php
    $user_info = $this->session->userdata('user_session');
    $user_type = $user_info['user_type'];
    $print_access = $user_info['print_access'];
    ?>

    <div class="col-xs-12 col-sm-8">
        <div class="col-xs-12">
            <label class="search-from-date">Period: <?= $start_date ?> To <?= $end_date ?> </label><br>
        </div>
    </div>
    <?php if ((strtolower($user_type) != 'marketing')) { ?>
        <?php if (!empty($print_access) > 0) { ?>
            <div class="col-xs-12 col-sm-4">
                <button type="button" class="right-side-view btn btn-primary report-print-button gate-pass-print-button"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
            </div>
            <?php
        }
    }
    ?>

    <div class="table-responsive table-bordered">
        <table class="table table-striped" id="details-table">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Invoice</th>
                    <th>Client</th>
                    <th>Dealer</th>
                    <th>Employee</th>
                    <th>Date</th>
                    <th>Source</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 1;
                foreach ($invoice_details as $invoice):
                    ?>
                    <?php $date_of_issue = date("d-m-Y", strtotime($invoice->date_of_issue)); ?>
                    <tr>
                        <td><?= $count++ ?></td>
                        <td><?= ucfirst($invoice->invoice_number) ?></td>
                        <td><?= ucfirst($invoice->client_name) ?></td>
                        <td><?= ucfirst($invoice->dealer_name) ?></td>
                        <td><?= ucfirst($invoice->employee_name) ?></td>
                        <td><?= $date_of_issue ?></td>
                        <td><?= $invoice->source ?></td>

                        <td>
                            <button class="btn btn-primary gate-pass-view-button-<?= $invoice->id ?>"
                                    data-toggle="tooltip" data-placement="bottom"
                                    title="View Details"
                                    data-id="<?= $invoice->id ?>"
                                    data-action="<?= base_url('reports/gate_pass_report/gate_pass_modal_view') ?>">
                                <i class="fa fa-eye" aria-hidden="true"></i></button>
                            <script>
                                $('.gate-pass-view-button-<?= $invoice->id ?>').on('click', function (event) {
                                    event.preventDefault();
                                    $.post($(this).attr('data-action'), {'id': $(this).attr('data-id')}, function (data) {
                                        $('.gate-pass-details-information-modal .invoice-show').html(data);
                                        $('.gate-pass-details-information-modal').modal('show');
                                    });
                                });
                            </script>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>

    <div class="modal fade gate-pass-details-information-modal">
        <div class="modal-dialog modal-lg invoice-show " role="document">
        </div>
    </div>
</div>


<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="gete-pass-report-print-section" style="display: none; width: 100%" >

    <div class="col-xs-12">
        <h4 class="left-side-view" style="text-align: center"><?= strtoupper($company_information->company_name_1) ?></h4>
        <h6 class="left-side-view" style="text-align: center"><?= $company_information->company_address_1 ?></h6>
    </div>

    <div class="col-xs-12" style="margin-left: 10px;">
        <label class="search-from-date"><strong>Gate Pass Report</strong></label><br>
    </div>
    <div class="col-xs-12">
        <label class="search-from-date">Period: <?= $start_date ?> To <?= $end_date ?> </label><br>
    </div>
    <hr>

    <table border="2px" cellspacing="0" class="table table-striped" id="details-table">
        <thead>
            <tr>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">SL</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Invoice</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Client</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Dealer</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Employee</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Date</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Source</th>   
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            foreach ($invoice_details as $invoice):
                ?>
                <?php $date_of_issue = date("d-m-Y", strtotime($invoice->date_of_issue)); ?>
                <tr>
                    <td><?= $count++ ?></td>
                    <td><?= ucfirst($invoice->invoice_number) ?></td>
                    <td><?= ucfirst($invoice->client_name) ?></td>
                    <td><?= ucfirst($invoice->dealer_name) ?></td>
                    <td><?= ucfirst($invoice->employee_name) ?></td>
                    <td><?= $date_of_issue ?></td>
                    <td><?= $invoice->source ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>



<!--For Print-->
<script type="text/javascript">
    $(document).ready(function () {

        $(".gate-pass-print-button").on("click", function () {

            var divContents = $('#gete-pass-report-print-section').html();

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