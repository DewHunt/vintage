<div id="" style="">
    <div style="text-align: center; font-size: 20px;"><strong>Invoice</strong></div>
    <table class="" width="98%">
        <thead>
            <tr>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="left-side-view" style="text-align: left; width: 50%;"></td>
                <td class="right-side-view" style="text-align: right; width: 50%;">EC: <?= !empty($employee->employee_code) ? $employee->employee_code : '' ?></td>
            </tr>
            <tr>
                <td class="left-side-view" style="text-align: left; width: 50%;">Invoice Details</td>
                <td class="right-side-view" style="text-align: right; width: 50%;">DC: <?= !empty($dealer->dealer_code) ? $dealer->dealer_code : '' ?></td>
            </tr>
            <tr>
                <td class="left-side-view" style="text-align: left; width: 50%;"></td>
                <td class="right-side-view" style="text-align: right; width: 50%;"><strong>Invoice: <?= $invoice_details_by_invoice_id->invoice_number ?></strong></td>
            </tr>
            <tr>
                <?php
                $client_name_part_1 = '';
                $client_name_part_2 = '';
                if (strpos(($invoice_details_by_invoice_id->client_name), '(') !== false) {
                    $client_name = explode("(", ($invoice_details_by_invoice_id->client_name));
                    $client_name_part_1 = $client_name[0];
                    $client_name_part_2 = $client_name[1];
                } else {
                    $client_name_part_1 = $invoice_details_by_invoice_id->client_name;
                }
                ?>
                <td class="left-side-view" style="text-align: left; width: 50%;"><strong>Sold To:</strong> <?= $client_name_part_1 ?></td>
                <td class="right-side-view" style="text-align: right; width: 50%;">Challan Number:<?= $invoice_details_by_invoice_id->challan_number ?></td>
            </tr>
            <tr>                
                <td class="left-side-view" style="text-align: left; width: 50%;"><strong>Address:</strong> <?= !empty($invoice_details_by_invoice_id->address) ? $invoice_details_by_invoice_id->address : '' ?></td>
                <td class="right-side-view" style="text-align: right; width: 50%;">Outlet:<?= $invoice_details_by_invoice_id->branch_name ?></td>
            </tr>
            <tr>
                <td class="left-side-view" style="text-align: left; width: 50%;"><strong>Delivery Address:</strong> <?= !empty($invoice_details_by_invoice_id->delivery_address) ? nl2br($invoice_details_by_invoice_id->delivery_address) : '' ?></td>
                <?php
                $date_of_issue = date("d-m-Y", strtotime($invoice_details_by_invoice_id->date_of_issue));
                ?>
                <td class="right-side-view" style="text-align: right; width: 50%;">Date Of Issue:<?= $date_of_issue ?></td>
            </tr>
            <tr>
                <td class="left-side-view" style="text-align: left; width: 50%;">
                    <strong>Contact:
                        <?php
                        $contact_number = '';
                        $client_cell_number = !empty($invoice_details_by_invoice_id->cell_number) ? $invoice_details_by_invoice_id->cell_number : '';
                        $client_phone_number = !empty($invoice_details_by_invoice_id->phone_number) ? $invoice_details_by_invoice_id->phone_number : '';
                        if ((empty($client_cell_number)) && (!empty($client_phone_number))) {
                            $contact_number = $client_phone_number;
                        } else {
                            $contact_number = $client_cell_number;
                        }
                        ?>
                    </strong> <?= !empty($contact_number) ? $contact_number : '' ?>
                </td>
                <td class="right-side-view" style="text-align: right; width: 50%;">Order No:<?= !empty($invoice_details_by_invoice_id->order_number) ? $invoice_details_by_invoice_id->order_number : '' ?></td>
            </tr>
            <tr>
                <td class="left-side-view" style="text-align: left; width: 50%;"></td>
                <?php
                $order_date = '';
                $order_date = date("d-m-Y", strtotime($invoice_details_by_invoice_id->order_date));
                $order_date = (is_valid_date($order_date)) ? $order_date : '';
                ?>
                <td class="right-side-view" style="text-align: right; width: 50%;">Order Date:<?= !empty($order_date) ? $order_date : '' ?></td>
            </tr>
        </tbody>
    </table>
</div>
