<div class="card card-boarder">
    <?php
    $company_information;
    $currency_settings;
    $return_product_info_by_date_and_branch;
    $user_info = $this->session->userdata('user_session');
    $user_type = $user_info['user_type'];
    $print_access = $user_info['print_access'];
//    echo '<pre>';
//    print_r($return_product_info_by_date_and_branch);
//    echo '</pre>';
//    die();
    ?>

    <div class="col-xs-12 col-sm-8">
        <div class="col-xs-12">
            <label class="search-from-date">Outlet: <?= ucfirst($branch_name) ?></label>
        </div>
        <div class="col-xs-12">
            <?php $start_date = date("d-m-Y", strtotime($start_date)); ?>
            <?php $end_date = date("d-m-Y", strtotime($end_date)); ?>
            <label class="search-from-date">Period: <?= $start_date ?> To <?= $end_date ?> </label><br>
        </div>
    </div>
    <?php if ((strtolower($user_type) != 'marketing')) { ?>
        <?php if (!empty($print_access) > 0) { ?>
            <div class="col-xs-12 col-sm-4">
                <button type="button" class="btn btn-primary return-product-info-report-print-button report-print-button"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
            </div>
            <?php
        }
    }
    ?>

    <table class="table table-striped" style="width: 100%" id="details-table">

        <thead class="thead-default">
            <tr>
                <th>SL</th>
                <th>Date</th>
                <th>Outlet</th>
                <th>Total Quantity</th>
                <th><?= 'Total Price' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                <th>Reason</th>
                <th>User</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $count = 1;
            $total = 0;
            foreach ($return_product_info_by_date_and_branch as $return_product_info) {
                ?>
                <?php $return_date = date("d-m-Y", strtotime($return_product_info->return_date)); ?>
                <?php $total += (double) $return_product_info->total_purchase_price; ?>
                <tr>
                    <td><?= $count++ ?></td>
                    <td><?= $return_date ?></td>
                    <td><?= $return_product_info->branch_name ?></td>
                    <td><?= $return_product_info->total_quantity ?></td>
                    <td><?= number_format((double) $return_product_info->total_purchase_price, 2) ?></td>
                    <td><?= ucfirst($return_product_info->reason) ?></td>
                    <td><?= ucfirst($return_product_info->user_name) ?></td>
                    <td>
                        <button class="btn btn-primary return-product-details-view-button-<?= $return_product_info->id ?>"
                                data-toggle="tooltip" data-placement="bottom"
                                title="View Details"
                                data-id="<?= $return_product_info->id ?>"
                                data-action="<?= base_url('reports/return_product_report/return_product_report_details_show_in_modal') ?>">
                            <i class="fa fa-eye" aria-hidden="true"></i></button>
                        <script>
                            $('.return-product-details-view-button-<?= $return_product_info->id ?>').on('click', function (event) {
                                event.preventDefault();
                                $.post($(this).attr('data-action'), {'id': $(this).attr('data-id')}, function (data) {
                                    $('.return_product_report_modal .return_product_report_modal_show').html(data)
                                    $('.return_product_report_modal').modal('show');
                                });
                            });
                        </script>
                    </td>
                </tr>

            <?php }
            ?>

            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td><strong>Grand Total</strong></td>
                <td><strong><?= number_format((double) $total, 2) ?></strong></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>

    </table>

    <div class="modal fade return_product_report_modal">
        <div class="modal-dialog modal-lg return_product_report_modal_show" role="document">
        </div>
    </div>
</div>


<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="return-product-info-report-print-section" style="width: 100%; display: none;">

    <div class="col-xs-12">
        <h4 style="text-align: center"
            class="left-side-view"><?= strtoupper($company_information->company_name_1) ?></h4>
<!--        <h6 style="text-align: center" class="left-side-view"><?= $company_information->company_address_1 ?></h6>-->
    </div>

    <div><strong>Product (Return) Report</strong></div>

    <div class="col-xs-12">
        <label class="search-from-date">Outlet: <?= ucfirst($branch_name) ?></label>
    </div>
    <div class="col-xs-12">
        <?php $start_date = date("d-m-Y", strtotime($start_date)); ?>
        <?php $end_date = date("d-m-Y", strtotime($end_date)); ?>
        <label class="search-from-date">Period: <?= $start_date ?> To <?= $end_date ?> </label><br>
    </div>

    <hr>

    <table style="width: 100%" border="2px" cellspacing="0" class="table table-striped" id="details-table">

        <thead class="thead-default">
            <tr>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">SL</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Date</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Outlet</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Total Quantity</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px"><?= 'Total Price' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">Reason</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">User</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $count = 1;
            $total = 0;
            foreach ($return_product_info_by_date_and_branch as $return_product_info) {
                ?>
                <?php $return_date = date("d-m-Y", strtotime($return_product_info->return_date)); ?>
                <?php $total += (double) $return_product_info->total_purchase_price; ?>
                <tr style="border: thick">
                    <td><?= $count++ ?></td>
                    <td><?= $return_date ?></td>
                    <td><?= $return_product_info->branch_name ?></td>
                    <td><?= $return_product_info->total_quantity ?></td>
                    <td><?= number_format((double) $return_product_info->total_purchase_price, 2) ?></td>
                    <td><?= ucfirst($return_product_info->reason) ?></td>
                    <td><?= ucfirst($return_product_info->user_name) ?></td>
                </tr>

            <?php }
            ?>
            <tr style="border: thick">
                <td></td>
                <td></td>
                <td></td>
                <td><strong>Grand Total</strong></td>
                <td><strong><?= number_format((double) $total, 2) ?></strong></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>

    </table>

</div>

<!--For Print-->
<script language="javascript" type="text/javascript">

//    $('.client-invoice-view-button').on('click', function (event) {
//        event.preventDefault();
//        $.post($(this).attr('data-action'), {'id': $(this).attr('data-id')}, function (data) {
//            $('.client-invoice-details-information-modal .client-invoice-show').html(data)
//            $('.client-invoice-details-information-modal').modal('show');
//        });
//    });

    $(".return-product-info-report-print-button").on("click", function () {

        var divContents = $('#return-product-info-report-print-section').html();

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


