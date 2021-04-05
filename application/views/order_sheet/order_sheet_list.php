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
<!--            <div class="col-xs-12 col-sm-4">
                <button type="button" class="right-side-view btn btn-primary report-print-button print-button"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
            </div>-->
            <?php
        }
    }
    ?>

    <table class="table table-striped" id="details-table">
        <thead>
            <tr>
                <th>SL</th>
                <th>Issue Date</th>
                <th>Client</th>
                <th>Online Order Sheet No</th>
                <th><?= 'Total Amount ' . '(' . $currency_settings->currency_symbol . ')' ?></th>
                <th>User</th>
                <th class="action-fixed-width">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            foreach ($order_sheet_list as $order_sheet):
                ?>
                <?php $issue_date = date("d-m-Y", strtotime($order_sheet->issue_date)); ?>
                <tr>
                    <td><?= $count++ ?></td>
                    <td><?= $issue_date ?></td>
                    <td><?= ucfirst($order_sheet->client_name) ?></td>
                    <td><?= ucfirst($order_sheet->online_order_number) ?></td>
                    <td><?= number_format($order_sheet->total, 2) ?></td>
                    <td><?= ucfirst($order_sheet->user_name) ?></td>
                    <td>
                        <button class="btn btn-primary order-sheet-view-button-<?= $order_sheet->id ?>"
                                data-toggle="tooltip" data-placement="bottom"
                                title="View Details"
                                data-id="<?= $order_sheet->id ?>"
                                data-action="<?= base_url('order_sheet/order_sheet_details_show_in_modal') ?>">
                            <i class="fa fa-eye" aria-hidden="true"></i></button>

                        <script>
                            $('.order-sheet-view-button-<?= $order_sheet->id ?>').on('click', function (event) {
                                event.preventDefault();
                                $.post($(this).attr('data-action'), {'id': $(this).attr('data-id')}, function (data) {
                                    $('.order-sheet-details-information-modal .order-sheet-show').html(data);
                                    $('.order-sheet-details-information-modal').modal('show');
                                });
                            });
                        </script>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="modal fade order-sheet-details-information-modal">
        <div class="modal-dialog modal-lg order-sheet-show " role="document">

        </div>
    </div>
</div>




<!--For Print-->
<script type="text/javascript">
    $(document).ready(function () {

        $(".print-button").on("click", function () {

            var divContents = $('#invoice-report-print-section').html();

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




