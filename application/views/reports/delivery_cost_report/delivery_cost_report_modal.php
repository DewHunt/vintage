<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Delivery Cost Details Report</h4>
    </div>
    <div class="modal-body">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <?php
                $invoice_details;
                $sale_product_list;
                $sale_product_list_row;
                ?>

                <?php if (!empty($invoice_details)) { ?>
                    <table class="" width="100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="left-side-view">Invoice Details</td>
                                <td class="right-side-view">
                                    <strong>Invoice: <?= $invoice_details->invoice_number ?></strong></td>
                            </tr>
                            <tr>
                                <?php
                                $client_name_part_1 = '';
                                $client_name_part_2 = '';
                                $client = $this->Client_Model->get_client(intval($invoice_details->client_id));
                                if (strpos(($client->client_name), '(') !== false) {
                                    $client_name = explode("(", ($client->client_name));
                                    $client_name_part_1 = $client_name[0];
                                    $client_name_part_2 = $client_name[1];
                                } else {
                                    $client_name_part_1 = $client->client_name;
                                }
                                ?>
                                <td class="left-side-view"><strong>Sold To:</strong> <?= $client_name_part_1 ?></td>
                                <td class="right-side-view">Challan Number:<?= $invoice_details->challan_number ?></td>
                            </tr>
                            <tr>
                                <td class="left-side-view">Order No:<?= !empty($invoice_details->order_number) ? $invoice_details->order_number : '' ?></td>
                                <?php $branch = $this->Branch_Model->get_Branch($invoice_details->branch_id); ?>
                                <td class="right-side-view">Outlet:<?= $branch->branch_name ?></td>
                            </tr>
                            <tr>
                                <?php
                                $order_date = date("d-m-Y", strtotime($invoice_details->order_date));
                                $order_date = ((is_valid_date($order_date))) ? $order_date : '';
                                ?>
                                <td class="left-side-view">Order Date:<?= $order_date; ?></td>
                                </td>
                                <?php
                                $date_of_issue = date("d-m-Y", strtotime($invoice_details->date_of_issue));
                                $date_of_issue = ((is_valid_date($date_of_issue))) ? $date_of_issue : '';
                                ?>
                                <td class="right-side-view">Date Of Issue:<?= $date_of_issue ?></td>
                            </tr>
                            <tr>
                                <td class="left-side-view"></td>
                                <td class="right-side-view"></td>
                            </tr>
                            <tr>
                                <td class="left-side-view"></td>
                                <td class="right-side-view"></td>
                            </tr>
                        </tbody>
                    </table>

                    <form id="delivery_cost_form" name="delivery_cost_form" action="<?= base_url('delivery_cost/update') ?>" method="post">
                        <input type="hidden" class="form-control" id="delivery_cost_id" name="delivery_cost_id" value="<?= !empty($delivery_cost->id) ? intval($delivery_cost->id) : 0; ?>">
                        <input type="hidden" class="form-control" id="invoice_details_id" name="invoice_details_id" value="<?= !empty($invoice_details->id) ? intval($invoice_details->id) : 0; ?>">
                        <table id="delivery-cost-table" class="table table-striped table-bordered table-hover table-responsive">
                            <thead>
                                <tr>
                                    <th style="width: 20px;">SL</th>
                                    <th>Description</th>
                                    <!--<th>Id</th>-->
                                    <th style="width: 25%" class="text-right"><?= 'Amount ' . '(' . get_currency() . ')' ?></th>
                                </tr>
                            </thead>      
                            <tbody>
                                <?php
                                $m_delivery_cost_details = new Delivery_cost_details_Model();
                                $count = 1;
                                $amount = 0;
                                $delivery_cost_details_id = 0;
                                $arr = array();
                                if (!empty($delivery_cost_type_list)) {
                                    foreach ($delivery_cost_type_list as $delivery_cost_type) {
                                        $delivery_cost_type_id = intval($delivery_cost_type->id);
                                        $delivery_cost_name = !empty($delivery_cost_type->delivery_cost_name) ? $delivery_cost_type->delivery_cost_name : '';
                                        $arr = $m_delivery_cost_details->get_delivery_cost_details_id_and_amount($delivery_cost_details_by_delivery_cost_id, $delivery_cost_type_id);
                                        $amount = !empty($arr) ? (array_key_exists('amount', $arr) ? (!empty($arr['amount']) ? $arr['amount'] : '') : '') : '';
                                        $delivery_cost_details_id = !empty($arr) ? (array_key_exists('delivery_cost_details_id', $arr) ? (!empty($arr['delivery_cost_details_id']) ? $arr['delivery_cost_details_id'] : '') : '') : '';
                                        ?>
                                        <tr>
                                            <td><?= $count++; ?></td>
                                            <td><?= $delivery_cost_name; ?></td>
                                            <td class="text-right"><?= get_floating_point_number($amount); ?></td>
                                        </tr>                    
                                        <?php
                                    }
                                    ?>
                                    <tr>
                                        <td></td>                            
                                        <td><strong>Grand Total</strong></td>
                                        <td id="delivery_cost_total_amount" class="delivery_cost_total_amount text-right" style="font-weight: bold"><?= !empty($delivery_cost->total_amount) ? get_floating_point_number($delivery_cost->total_amount) : get_floating_point_number(0); ?></td>
                                    </tr>
                                <?php }
                                ?>
                            </tbody>
                        </table>
                    </form> 
                <?php } ?>    
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="modal-footer">
        <button type="button" class="btn btn-primary print-button delivery-cost-details-print-information-button"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
        <button style="float: right; margin-left: 1%" type="button" class="btn btn-danger modal-close-button" data-dismiss="modal">Close</button>
    </div>
</div>


<!--DISPLAY NONE-->
<!--USE FOR PRINT-->

<div id="delivery-cost-details-print-information" class="col-xs-12 color-print" style="display: none; width: 100%;">
    <style>
        .delivery-cost-details-report-print-table{
            width: 100%;
        }
        .delivery-cost-details-report-print-table thead th{
            text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px;
        }
        .text-right{
            text-align: right !important;
        }
        .border-thick{
            border: thick;
        }
        .width-100{
            width: 100%;
        }
        .left-side-view{
            text-align: left;
        }
        .right-side-view{
            text-align: right;
        }
    </style>
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="col-xs-12">
            <h4 class="left-side-view" style="text-align: center"><?= strtoupper(get_company_name()) ?></h4>
            <h6 class="left-side-view" style="text-align: center"><?= get_company_address(); ?></h6>
        </div>

        <div class="col-xs-12" style="margin-left: 10px;">
            <label class="search-from-date"><strong>Delivery Cost Report</strong></label><br>
        </div>
        <div class="table-responsive">
            <?php
            $invoice_details;
            $sale_product_list;
            $sale_product_list_row;
            ?>

            <?php if (!empty($invoice_details)) { ?>
                <table class="width-100" width="100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="left-side-view">Invoice Details</td>
                            <td class="right-side-view">
                                <strong>Invoice: <?= $invoice_details->invoice_number ?></strong></td>
                        </tr>
                        <tr>
                            <?php
                            $client_name_part_1 = '';
                            $client_name_part_2 = '';
                            $client = $this->Client_Model->get_client(intval($invoice_details->client_id));
                            if (strpos(($client->client_name), '(') !== false) {
                                $client_name = explode("(", ($client->client_name));
                                $client_name_part_1 = $client_name[0];
                                $client_name_part_2 = $client_name[1];
                            } else {
                                $client_name_part_1 = $client->client_name;
                            }
                            ?>
                            <td class="left-side-view"><strong>Sold To:</strong> <?= $client_name_part_1 ?></td>
                            <td class="right-side-view">Challan Number:<?= $invoice_details->challan_number ?></td>
                        </tr>
                        <tr>
                            <td class="left-side-view">Order No:<?= !empty($invoice_details->order_number) ? $invoice_details->order_number : '' ?></td>
                            <?php $branch = $this->Branch_Model->get_Branch($invoice_details->branch_id); ?>
                            <td class="right-side-view">Outlet:<?= $branch->branch_name ?></td>
                        </tr>
                        <tr>
                            <?php
                            $order_date = date("d-m-Y", strtotime($invoice_details->order_date));
                            $order_date = ((is_valid_date($order_date))) ? $order_date : '';
                            ?>
                            <td class="left-side-view">Order Date:<?= $order_date; ?></td>
                            </td>
                            <?php
                            $date_of_issue = date("d-m-Y", strtotime($invoice_details->date_of_issue));
                            $date_of_issue = ((is_valid_date($date_of_issue))) ? $date_of_issue : '';
                            ?>
                            <td class="right-side-view">Date Of Issue:<?= $date_of_issue ?></td>
                        </tr>
                        <tr>
                            <td class="left-side-view"></td>
                            <td class="right-side-view"></td>
                        </tr>
                        <tr>
                            <td class="left-side-view"></td>
                            <td class="right-side-view"></td>
                        </tr>
                    </tbody>
                </table>
                <table border="2px" cellspacing="0" id="delivery-cost-details-report-print-table" class="table table-striped table-bordered table-hover table-responsive delivery-cost-details-report-print-table">
                    <thead>
                        <tr>
                            <th style="width: 20px;">SL</th>
                            <th>Description</th>
                            <!--<th>Id</th>-->
                            <th style="width: 25%" class="text-right"><?= 'Amount ' . '(' . get_currency() . ')' ?></th>
                        </tr>
                    </thead>      
                    <tbody>
                        <?php
                        $m_delivery_cost_details = new Delivery_cost_details_Model();
                        $count = 1;
                        $amount = 0;
                        $delivery_cost_details_id = 0;
                        $arr = array();
                        if (!empty($delivery_cost_type_list)) {
                            foreach ($delivery_cost_type_list as $delivery_cost_type) {
                                $delivery_cost_type_id = intval($delivery_cost_type->id);
                                $delivery_cost_name = !empty($delivery_cost_type->delivery_cost_name) ? $delivery_cost_type->delivery_cost_name : '';
                                $arr = $m_delivery_cost_details->get_delivery_cost_details_id_and_amount($delivery_cost_details_by_delivery_cost_id, $delivery_cost_type_id);
                                $amount = !empty($arr) ? (array_key_exists('amount', $arr) ? (!empty($arr['amount']) ? $arr['amount'] : '') : '') : '';
                                $delivery_cost_details_id = !empty($arr) ? (array_key_exists('delivery_cost_details_id', $arr) ? (!empty($arr['delivery_cost_details_id']) ? $arr['delivery_cost_details_id'] : '') : '') : '';
                                ?>
                        <tr class="border-thick">
                                    <td><?= $count++; ?></td>
                                    <td><?= $delivery_cost_name; ?></td>
                                    <td class="text-right"><?= get_floating_point_number($amount); ?></td>
                                </tr>                    
                                <?php
                            }
                            ?>
                                <tr class="border-thick">
                                <td></td>                            
                                <td><strong>Grand Total</strong></td>
                                <td id="delivery_cost_total_amount" class="delivery_cost_total_amount text-right" style="font-weight: bold"><?= !empty($delivery_cost->total_amount) ? get_floating_point_number($delivery_cost->total_amount) : get_floating_point_number(0); ?></td>
                            </tr>
                        <?php }
                        ?>
                    </tbody>
                </table>
            <?php } ?>    
        </div>
    </div>
</div>


<!--For Print-->
<script language="javascript" type="text/javascript">

    $(".delivery-cost-details-print-information-button").click(function () {
        var divContents = $('#delivery-cost-details-print-information').html();
        var printWindow = window.open();
        printWindow.document.write(divContents);
        printWindow.document.close();
        printWindow.print();
        printWindow.close();
    });

    $('.modal-close-button').click(function () {
        $('.modal').modal('hide');
    });
</script>


