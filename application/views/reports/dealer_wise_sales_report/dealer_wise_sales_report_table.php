<div class="card card-boarder">

    <?php
    $company_information;
    $dealer_invoice_details_list;

    /* echo '<pre>';
     echo print_r($employee_name);
     echo '</pre>';*/
    ?>

    <div class="col-xs-12 col-sm-8">
        <div class="col-xs-12">
            <label class="search-from-date">Dealer: <?= $dealer_name ?></label>
        </div>
        <div class="col-xs-12">
            <label class="search-from-date">Period: <?= $start_date ?> To <?= $end_date ?> </label><br>
        </div>
    </div>
    <!--<div class="col-xs-12 col-sm-4">
        <button type="button" class="btn btn-primary report-print-button"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
    </div>
-->
    <table class="table table-striped" style="width: 100%" id="details-table">

        <thead class="thead-default">
        <tr>
            <th>SL</th>
            <th>Date</th>
            <th>Invoice</th>
            <th>Client</th>
            <th>Dealer</th>
            <th>Employee</th>
            <th>Branch</th>
            <th>Total</th>
            <th>User</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php $count = 1;
        foreach ($dealer_invoice_details_list as $dealer_invoice): ?>
            <?php $date_of_issue = date("d-m-Y", strtotime($dealer_invoice->date_of_issue)); ?>
            <tr>
                <td><?= $count++ ?></td>
                <td><?= $date_of_issue ?></td>
                <td><?= $dealer_invoice->invoice_number ?></td>
                <td><?= $dealer_invoice->client_name ?></td>
                <td><?= $dealer_invoice->dealer_name ?></td>
                <td><?= $dealer_invoice->employee_name ?></td>
                <td><?= $dealer_invoice->branch_name ?></td>
                <td><?= number_format((double)$dealer_invoice->product_total, 2) ?></td>
                <td><?= $dealer_invoice->user_name ?></td>
                <td>
                    <button class="btn btn-primary dealer-invoice-view-button"
                            data-toggle="tooltip" data-placement="bottom"
                            title="View Details"
                            data-id="<?= $dealer_invoice->id ?>"
                            data-action="<?= base_url('reports/dealer_wise_sales_report/dealer_invoice_report_view') ?>">
                        <i class="fa fa-eye" aria-hidden="true"></i></button>
                </td>
            </tr>

        <?php endforeach; ?>
        <hr>
        </tbody>
    </table>
    <div class="modal fade dealer-invoice-details-information-modal">
        <div class="modal-dialog modal-lg dealer-invoice-show " role="document">
        </div>
    </div>
</div>


<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<!--<div id="print-information" style="display: none">

    <div class="col-xs-12">
        <h4 class="left-side-view"><?/*= strtoupper($company_information->company_name_1) */?></h4>
        <h6 class="left-side-view"><?/*= $company_information->company_address_1 */?></h6>
    </div>

    <div class="card card-boarder" style="margin-top: 10px;">

        <div class="col-xs-12" style="margin-left: 10px;">
            <label class="search-from-date">Client: <?/*= $client_name */?></label><br>
        </div>
        <div class="col-xs-12" style="margin-left: 10px;">
            <label class="search-from-date">Period: <?/*= $start_date */?> To <?/*= $end_date */?> </label><br>
        </div>

        <div class="col-xs-12" style="margin-top: 10px; padding-left: 0px;">
            <table class="table table-striped" style="width: 100%; border: 2px solid #D1C9C7; margin-top: 10px;"
                   id="branch-stock-list-table">

                <thead class="thead-default">
                <tr>
                    <th style="border-bottom: 1px solid #ddd;">SL</th>
                    <th style="border-bottom: 1px solid #ddd;">Date</th>
                    <th style="border-bottom: 1px solid #ddd;">Invoice</th>
                    <th style="border-bottom: 1px solid #ddd;">Client</th>
                    <th style="border-bottom: 1px solid #ddd;">Dealer</th>
                    <th style="border-bottom: 1px solid #ddd;">Employee</th>
                    <th style="border-bottom: 1px solid #ddd;">Branch</th>
                    <th style="border-bottom: 1px solid #ddd;">Total</th>
                    <th style="border-bottom: 1px solid #ddd;">User</th>
                </tr>
                </thead>
                <tbody>
                <?php /*$count = 1;
                foreach ($dealer_invoice_details_list as $dealer_invoice): */?>
                    <?php /*$date_of_issue = date("d-m-Y", strtotime($dealer_invoice->date_of_issue)); */?>
                    <tr>
                        <td style="border-bottom: 1px solid #ddd; text-align: center"><?/*= $count++ */?></td>
                        <td style="border-bottom: 1px solid #ddd; text-align: center"><?/*= $date_of_issue */?></td>
                        <td style="border-bottom: 1px solid #ddd; text-align: center"><?/*= $dealer_invoice->invoice_number */?></td>
                        <td style="border-bottom: 1px solid #ddd; text-align: center"><?/*= $dealer_invoice->client_name */?></td>
                        <td style="border-bottom: 1px solid #ddd; text-align: center"><?/*= $dealer_invoice->dealer_name */?></td>
                        <td style="border-bottom: 1px solid #ddd; text-align: center"><?/*= $dealer_invoice->employee_name */?></td>
                        <td style="border-bottom: 1px solid #ddd; text-align: center"><?/*= $dealer_invoice->branch_name */?></td>
                        <td style="border-bottom: 1px solid #ddd; text-align: center"><?/*= $dealer_invoice->product_total */?></td>
                        <td style="border-bottom: 1px solid #ddd; text-align: center"><?/*= $dealer_invoice->user_name */?></td>
                    </tr>
                <?php /*endforeach; */?>

                <hr>
                </tbody>
            </table>
        </div>

    </div>

</div>-->

<!--For Print-->
<script language="javascript" type="text/javascript">

    $('.dealer-invoice-view-button').on('click', function (event) {
        event.preventDefault();
        $.post($(this).attr('data-action'), {'id': $(this).attr('data-id')}, function (data) {
            $('.dealer-invoice-details-information-modal .dealer-invoice-show').html(data)
            $('.dealer-invoice-details-information-modal').modal('show');
        });
    });

    $(".report-print-button").on("click", function () {

        var divContents = $('#print-information').html();

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
</script>
