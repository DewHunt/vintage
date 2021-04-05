<div class="modal-content">

    <?php
    $company_information;
    /*echo '<pre>';
    echo print_r($res);
    echo '</pre>';
    die();*/
    ?>

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Invoice Details</h4>
    </div>

    <div class="modal-body">

        <div class="form-group col-xs-12">

            <div class="col-xs-12">
                <h4 class="left-side-view" style="text-align: center"><?= strtoupper($company_information->company_name_1) ?></h4>
            </div>

            <div class="col-xs-12">
                <h6 class="left-side-view"
                    style="text-align: center"><?= $company_information->company_address_1 ?></h6>
            </div>

            <div class="col-xs-12">
                <h6 class="left-side-view" style="text-align: left"><strong>Dealerwise Sales Report</strong></h6>
            </div>
            <div class="col-xs-12">
                <label class="col-form-label right-side-view">Employee
                    Code: <?= $employee->employee_code ?> </label>
            </div>
            <div class="col-xs-12">
                <label class="col-form-label right-side-view">Dealer Code: <?= $dealer->dealer_code ?></label>
            </div>

            <div class="col-xs-12">
                <label
                    class="col-form-label right-side-view">Invoice: <?= $invoice_details_by_invoice_id->invoice_number ?></label>
            </div>

            <div class="col-xs-12">
                <label class="col-form-label right-side-view">Challan
                    Number:<?= $invoice_details_by_invoice_id->challan_number ?></label>
            </div>

            <div class="col-xs-12">
                <label
                    class="col-form-label right-side-view">Branch:<?= $invoice_details_by_invoice_id->branch_name ?></label>
            </div>

            <div class="col-xs-12">
                <label class="col-form-label left-side-view">Invoice Details</label>
            </div>
            <div class="col-xs-12">
                <label class="col-form-label left-side-view">Sold
                    To: <?= $invoice_details_by_invoice_id->client_name ?></label>
            </div>

            <div class="col-xs-12">
                <label class="col-form-label right-side-view">Vat Registration
                    No:<?= $invoice_details_by_invoice_id->vat_registration_id ?></label>
            </div>
            <div class="col-xs-12">
                <?php
                $date_of_issue = date("d-m-Y", strtotime($invoice_details_by_invoice_id->date_of_issue));
                ?>
                <label class="col-form-label right-side-view">Date Of Issue:<?= $date_of_issue ?></label>
            </div>

            <div class="col-xs-12">
                <label class="col-form-label left-side-view">Product Information</label>
            </div>

            <div class="col-xs-12">

                <table class="table">
                    <thead class="thead-default">
                    <tr>
                        <th>SL</th>
                        <th>Product</th>
                        <th>Pack Size</th>
                        <th>Quantity</th>
                        <th>Price/Pack</th>
                        <th>Sales Price<br>(Exclude Vat)</th>
                        <th>Vat</th>
                        <th>Sales Price<br>(Include Vat)</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php $count = 1;
                    foreach ($sale_product_list as $sale_product): ?>
                        <?php
                        $product = $this->Product_Model->get_product($sale_product->product_id);
                        ?>
                        <tr>
                            <td><?= $count++; ?></td>
                            <td><?= $product->product_name ?></td>
                            <td><?= $sale_product->pack_size ?></td>
                            <td><?= $sale_product->quantity ?></td>
                            <td><?= number_format((double)$sale_product->unit_price, 2) ?></td>
                            <td><?= number_format((double)$sale_product->sales_price_excluding_vat, 2) ?></td>
                            <td><?= number_format((double)$sale_product->vat, 2) ?></td>
                            <td><?= number_format((double)$sale_product->sales_price_including_vat, 2) ?></td>
                        </tr>

                    <?php endforeach; ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <?php
                        $delivery_charge = $invoice_details_by_invoice_id->delivery_charge;
                        $others_charge = $invoice_details_by_invoice_id->others_charge;
                        $deduction = $invoice_details_by_invoice_id->deduction;
                        $vat = 0;
                        $total = $delivery_charge + $others_charge + $vat - $deduction;
                        ?>
                        <td>Total</td>
                        <td> <?= number_format((double)$total, 2) ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Delivery Charge</td>
                        <td><?= number_format((double)$invoice_details_by_invoice_id->delivery_charge, 2) ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Others Charge</td>
                        <td><?= number_format((double)$invoice_details_by_invoice_id->others_charge, 2) ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Deduction</td>
                        <td><?= number_format((double)$invoice_details_by_invoice_id->deduction, 2) ?></td>
                    </tr>

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Gross Payable</td>
                        <td><?= number_format((double)$invoice_details_by_invoice_id->gross_payable, 2) ?></td>
                    </tr>

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Advance Adjusted</td>
                        <td><?= number_format((double)$invoice_details_by_invoice_id->advance_adjusted, 2) ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Amount Paid</td>
                        <td><?= number_format((double)$invoice_details_by_invoice_id->amount_to_paid, 2) ?></td>
                    </tr>

                    </tbody>
                </table>

            </div>

            <div class="col-xs-12">
                <label class="col-form-label left-side-view">Payment Information
                    <hr>
                </label>
            </div>

            <div class="col-xs-12">
                <label class="col-form-label left-side-view">Mode Of
                    Payment: <?= $invoice_details_by_invoice_id->mode_of_payment ?></label>
            </div>

            <div class="col-xs-12">
                <label class="col-form-label left-side-view">Amount In
                    word: <?= convert_number_to_words($invoice_details_by_invoice_id->amount_to_paid) . ' Taka'; ?> </label>
            </div>

        </div>

    </div>

    <div class="clearfix"></div>

    <div class="modal-footer">
        <button type="button" class="btn btn-primary print-button"><i class="fa fa-print" aria-hidden="true"></i> Print
        </button>
        <button type="button" class="btn btn-secondary modal-close-button" data-dismiss="modal">Close</button>
    </div>

</div>


<!--DISPLAY NONE-->
<!--USE FOR PRINT-->


<div id="print-information" style="display: none">


    <div class="col-xs-12">
        <h4><?= strtoupper($company_information->company_name_1) ?></h4>
        <h6><?= $company_information->company_address_1 ?></h6>
    </div>


    <div class="col-xs-12">
        <label class="col-form-label left-side-view" style="float: left"><strong>Dealerwise Sales
                Report</strong></label><br>
        <label class="col-form-label right-side-view" style="float: right">Employee
            Code: <?= $employee->employee_code ?> </label><br>
    </div>
    <div class="col-xs-12">
        <label class="col-form-label right-side-view" style="float: right">Dealer
            Code: <?= $dealer->dealer_code ?></label><br>
    </div>

    <div class="col-xs-12">
        <label class="col-form-label right-side-view"
               style="float: right">Invoice: <?= $invoice_details_by_invoice_id->id ?></label><br>
    </div>
    <br>

    <div class="col-xs-12">
        <label class="col-form-label right-side-view" style="float: right">Challan
            Number:<?= $invoice_details_by_invoice_id->challan_number ?></label><br>
    </div>
    <div class="col-xs-12">
        <label class="col-form-label right-side-view"
               style="float: right">Branch:<?= $invoice_details_by_invoice_id->branch_name ?></label><br>
    </div>

    <div class="col-xs-12">
        <br> <label class="col-form-label left-side-view" style="float: left">Invoice Details</label><br>
        <label class="col-form-label left-side-view" style="float: left">Sold
            To: <?= $invoice_details_by_invoice_id->client_name ?></label><br>
    </div>

    <div class="col-xs-12">
        <label class="col-form-label right-side-view" style="float: right">Vat Registration
            No:<?= $invoice_details_by_invoice_id->vat_registration_id ?></label><br>
    </div>

    <div class="col-xs-12">
        <?php
        $date_of_issue = date("d-m-Y", strtotime($invoice_details_by_invoice_id->date_of_issue));
        ?>
        <label class="col-form-label right-side-view" style="float: right">Date Of
            Issue:<?= $date_of_issue ?></label><br>
    </div>

    <div class="col-xs-12">
        <br> <label class="col-form-label left-side-view" style="float: left"><strong>Product
                Information</strong></label><br>
    </div>


    <div class="col-xs-12" style="margin-top: 10px;padding-left: 0px;">

        <table class="table" style="border: 1px solid white; width: 100%">
            <thead class="thead-default">
            <tr>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">SL</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">Product</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">Pack Size</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">Quantity</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">Price/Pack</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">Sales Price<br>(Exclude Vat)</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">Vat</th>
                <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 20px">Sales Price<br>(Include Vat)</th>
            </tr>
            </thead>
            <tbody>

            <?php $count = 1;
            foreach ($sale_product_list as $sale_product): ?>
                <?php
                $product = $this->Product_Model->get_product($sale_product->product_id);
                ?>
                <tr>
                    <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $count++ ?></td>
                    <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $product->product_name ?></td>
                    <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $sale_product->pack_size ?></td>
                    <td style="border-bottom: 1px solid #ddd; text-align: center"><?= $sale_product->quantity ?></td>
                    <td style="border-bottom: 1px solid #ddd; text-align: center"><?= number_format((double)$sale_product->unit_price, 2) ?></td>
                    <td style="border-bottom: 1px solid #ddd; text-align: center"><?= number_format((double)$sale_product->sales_price_excluding_vat, 2) ?></td>
                    <td style="border-bottom: 1px solid #ddd; text-align: center"><?= number_format((double)$sale_product->vat, 2) ?></td>
                    <td style="border-bottom: 1px solid #ddd; text-align: center"><?= number_format((double)$sale_product->sales_price_including_vat, 2) ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td style="padding-bottom: 20px"></td>
                <td style="padding-bottom: 20px"></td>
                <td style="padding-bottom: 20px"></td>
                <td style="padding-bottom: 20px"></td>
                <td style="padding-bottom: 20px"></td>
                <td style="padding-bottom: 20px"></td>
                <td style="padding-bottom: 20px"></td>
                <td style="padding-bottom: 20px"></td>
            </tr>
            <hr>
            <tr>
                <td style="border: 1px solid white; text-align: center"></td>
                <td style="border: 1px solid white; text-align: center"></td>
                <td style="border: 1px solid white; text-align: center"></td>
                <td style="border: 1px solid white; text-align: center"></td>
                <td style="border: 1px solid white; text-align: center"></td>
                <td style="border: 1px solid white; text-align: center"></td>
                <?php
                $delivery_charge = $invoice_details_by_invoice_id->delivery_charge;
                $others_charge = $invoice_details_by_invoice_id->others_charge;
                $deduction = $invoice_details_by_invoice_id->deduction;
                $vat = 0;
                $total = $delivery_charge + $others_charge + $vat - $deduction;
                ?>

                <td style="margin-top: 50px;border-bottom: 1px solid #ddd; text-align: right">Total</td>
                <td style="border-bottom: 1px solid #ddd; text-align: center"> <?= number_format((double)$total, 2) ?></td>
            </tr>
            <tr>
                <td style="border: 1px solid white; text-align: center"></td>
                <td style="border: 1px solid white; text-align: center"></td>
                <td style="border: 1px solid white; text-align: center"></td>
                <td style="border: 1px solid white; text-align: center"></td>
                <td style="border: 1px solid white; text-align: center"></td>
                <td style="border: 1px solid white; text-align: center"></td>
                <td style="border-bottom: 1px solid #ddd; text-align: right">Delivery Charge</td>
                <td style="border-bottom: 1px solid #ddd; text-align: center"><?= number_format((double)$invoice_details_by_invoice_id->delivery_charge, 2) ?></td>
            </tr>
            <tr>
                <td style="border: 1px solid white; text-align: center"></td>
                <td style="border: 1px solid white; text-align: center"></td>
                <td style="border: 1px solid white; text-align: center"></td>
                <td style="border: 1px solid white; text-align: center"></td>
                <td style="border: 1px solid white; text-align: center"></td>
                <td style="border: 1px solid white; text-align: center"></td>
                <td style="border-bottom: 1px solid #ddd; text-align: right">Others Charge</td>
                <td style="border-bottom: 1px solid #ddd; text-align: center"><?= number_format((double)$invoice_details_by_invoice_id->others_charge, 2) ?></td>
            </tr>
            <tr>
                <td style="border: 1px solid white; text-align: center"></td>
                <td style="border: 1px solid white; text-align: center"></td>
                <td style="border: 1px solid white; text-align: center"></td>
                <td style="border: 1px solid white; text-align: center"></td>
                <td style="border: 1px solid white; text-align: center"></td>
                <td style="border: 1px solid white; text-align: center"></td>
                <td style="border-bottom: 1px solid #ddd; text-align: right">Deduction</td>
                <td style="border-bottom: 1px solid #ddd; text-align: center"><?= number_format((double)$invoice_details_by_invoice_id->deduction, 2) ?></td>
            </tr>

            <tr>
                <td style="border: 1px solid white; text-align: center"></td>
                <td style="border: 1px solid white; text-align: center"></td>
                <td style="border: 1px solid white; text-align: center"></td>
                <td style="border: 1px solid white; text-align: center"></td>
                <td style="border: 1px solid white; text-align: center"></td>
                <td style="border: 1px solid white; text-align: center"></td>
                <td style="border-bottom: 1px solid #ddd; text-align: right">Gross Payable</td>
                <td style="border-bottom: 1px solid #ddd; text-align: center"><?= number_format((double)$invoice_details_by_invoice_id->gross_payable, 2) ?></td>
            </tr>

            <tr>
                <td style="border: 1px solid white; text-align: center"></td>
                <td style="border: 1px solid white; text-align: center"></td>
                <td style="border: 1px solid white; text-align: center"></td>
                <td style="border: 1px solid white; text-align: center"></td>
                <td style="border: 1px solid white; text-align: center"></td>
                <td style="border: 1px solid white; text-align: center"></td>
                <td style="border-bottom: 1px solid #ddd; text-align: right">Advance Adjusted</td>
                <td style="border-bottom: 1px solid #ddd; text-align: center"><?= number_format((double)$invoice_details_by_invoice_id->advance_adjusted, 2) ?></td>
            </tr>
            <tr>
                <td style="border: 1px solid white; text-align: center"></td>
                <td style="border: 1px solid white; text-align: center"></td>
                <td style="border: 1px solid white; text-align: center"></td>
                <td style="border: 1px solid white; text-align: center"></td>
                <td style="border: 1px solid white; text-align: center"></td>
                <td style="border: 1px solid white; text-align: center"></td>
                <td style="border-bottom: 1px solid #ddd; text-align: right">Amount Paid</td>
                <td style="border-bottom: 1px solid #ddd; text-align: center"><?= number_format((double)$invoice_details_by_invoice_id->amount_to_paid, 2) ?></td>
            </tr>

            </tbody>
        </table>

    </div>
    <hr>

    <div class="col-xs-12">
        <label class="col-form-label left-side-view" style="margin-top: 25px;"><strong>Payment Information</strong>
        </label>
    </div>

    <div class="col-xs-12" style="margin-top: 10px">
        <label class="col-form-label left-side-view" style=" margin-top: 60px">Mode Of
            Payment: <?= $invoice_details_by_invoice_id->mode_of_payment ?></label>
    </div>

    <div class="col-xs-12" style="margin-top: 5px">
        <label class="col-form-label left-side-view">Amount In word
            : <?= convert_number_to_words($invoice_details_by_invoice_id->amount_to_paid) . ' Taka'; ?></label>
    </div>

</div>

</div>


<!--For Print-->
<script language="javascript" type="text/javascript">

    $(".print-button").on("click", function () {

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
    $('.modal-close-button').click(function () {
        $('.modal').modal('hide');
    });
</script>


