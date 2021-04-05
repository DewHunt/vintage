<div class="card card-boarder">

    <?php
    $user_info = $this->session->userdata('user_session');
    $user_type = $user_info['user_type'];
    $print_access = $user_info['print_access'];
    ?>

    <div class="col-xs-12 col-sm-8">
        <div class="col-xs-12">
            <label class="search-from-date">Delivery Cost Name: <?= !empty($delivery_cost_name) ? $delivery_cost_name : ''; ?> </label><br>
        </div>
        <div class="col-xs-12">
            <label class="search-from-date">Period: <?= $start_date ?> To <?= $end_date ?> </label><br>
        </div>
    </div>
    <?php if ((strtolower($user_type) != 'marketing')) { ?>
        <?php if (!empty($print_access) > 0) { ?>
            <div class="col-xs-12 col-sm-4">
                <button type="button" class="right-side-view btn btn-primary report-print-button delivery-itemwise-cost-report-print-button"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
            </div>
            <?php
        }
    }
    ?>
    <div class="table-responsive table-bordered" style="width: 100%;">

        <table class="table table-striped" id="details-table">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Date</th>
                    <th>Invoice</th>
                    <th>Delivery Cost Name</th>
                    <th class="text-right"><?= 'Amount ' . '(' . get_currency() . ')' ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 1;
                $grand_total_amount = 0;
                if (!empty($delivery_itemwise_cost_report)) {
                    foreach ($delivery_itemwise_cost_report as $delivery_itemwise_cost) {
                        $cost_date = date("d-m-Y", strtotime($delivery_itemwise_cost->delivery_cost_date));
                        $cost_date = (is_valid_date($cost_date)) ? $cost_date : '';
                        $total_amount = !empty($delivery_itemwise_cost->amount) ? get_floating_point_number($delivery_itemwise_cost->amount) : 0;
                        $grand_total_amount += $total_amount;
                        ?>
                        <tr>
                            <td><?= $count++; ?></td>
                            <td><?= $cost_date; ?></td>
                            <td><?= (!empty($delivery_itemwise_cost->invoice_number)) ? $delivery_itemwise_cost->invoice_number : ''; ?></td>
                            <td><?= (!empty($delivery_itemwise_cost->delivery_cost_name)) ? $delivery_itemwise_cost->delivery_cost_name : ''; ?></td>
                            <td class="text-right"><?= get_floating_point_number($total_amount, TRUE); ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><strong>Grand Total</strong></td>
                    <td class="text-right"><strong><?= get_floating_point_number($grand_total_amount, TRUE); ?></strong></td>
                </tr>
            </tbody>
        </table>

    </div>

    <div class="modal fade delivery-cost-details-information-modal">
        <div class="modal-dialog modal-lg delivery-cost-details-show" role="document">
        </div>
    </div>
</div>


<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="delivery-itemwise-cost-report-print-section" style="display: none; width: 100%">

    <style>
        .delivery-cost-report-print-table{
            width: 100%;
        }
        .delivery-cost-report-print-table thead th{
            text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px;
        }
        .text-right{
            text-align: right !important;
        }
        .border-thick{
            border: thick;
        }
    </style>

    <div class="col-xs-12">
        <h4 class="left-side-view" style="text-align: center"><?= strtoupper(get_company_name()) ?></h4>
        <h6 class="left-side-view" style="text-align: center"><?= get_company_address(); ?></h6>
    </div>

    <div class="col-xs-12" style="margin-left: 10px;">
        <label class="search-from-date"><strong>Delivery Item Wise Cost Report</strong></label><br>
    </div>
    <div class="col-xs-12">
        <label class="search-from-date">Delivery Cost Name: <?= !empty($delivery_cost_name) ? $delivery_cost_name : ''; ?> </label><br>
    </div>
    <div class="col-xs-12">
        <label class="search-from-date">Period: <?= $start_date ?> To <?= $end_date ?> </label><br>
    </div>
    <hr>

    <table border="2px" cellspacing="0" class="table table-striped delivery-cost-report-print-table" id="details-table">
        <thead>
            <tr>
                <th>SL</th>
                <th>Date</th>
                <th>Invoice</th>
                <th>Delivery Cost Name</th>
                <th class="text-right"><?= 'Amount ' . '(' . get_currency() . ')' ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            $grand_total_amount = 0;
            if (!empty($delivery_itemwise_cost_report)) {
                foreach ($delivery_itemwise_cost_report as $delivery_itemwise_cost) {
                    $cost_date = date("d-m-Y", strtotime($delivery_itemwise_cost->delivery_cost_date));
                    $cost_date = (is_valid_date($cost_date)) ? $cost_date : '';
                    $total_amount = !empty($delivery_itemwise_cost->amount) ? get_floating_point_number($delivery_itemwise_cost->amount) : 0;
                    $total_amount = !empty($delivery_itemwise_cost->amount) ? get_floating_point_number($delivery_itemwise_cost->amount) : 0; // for all it shows sum of amount
                    $grand_total_amount += $total_amount;
                    ?>
                    <tr class="border-thick">
                        <td><?= $count++; ?></td>
                        <td><?= $cost_date; ?></td>
                        <td><?= (!empty($delivery_itemwise_cost->invoice_number)) ? $delivery_itemwise_cost->invoice_number : ''; ?></td>
                        <td><?= (!empty($delivery_itemwise_cost->delivery_cost_name)) ? $delivery_itemwise_cost->delivery_cost_name : ''; ?></td>
                        <td class="text-right"><?= get_floating_point_number($total_amount, TRUE); ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
            <tr class="border-thick">
                <td></td>
                <td></td>
                <td></td>
                <td><strong>Grand Total</strong></td>
                <td class="text-right"><strong><?= get_floating_point_number($grand_total_amount, TRUE); ?></strong></td>
            </tr>
        </tbody>
    </table>

</div>

<!--For Print-->
<script type="text/javascript">
    $(document).ready(function () {
        $(".delivery-itemwise-cost-report-print-button").click(function () {
            var divContents = $('#delivery-itemwise-cost-report-print-section').html();
            var printWindow = window.open();
            printWindow.document.write(divContents);
            printWindow.document.close();
            printWindow.print();
            printWindow.close();
        });

        $('#details-table').dataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [[25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]],
            "scrollY": "400px",
            "scrollX": true,
            "ordering": false,
        });

    });
</script>