<form id="sale_form" action="<?= base_url('sale_product/save_sale_details') ?>" method="post">
    <div class="row">
        <div class="form-group col-xs-12 col-sm-4 col-md-3 col-lg-3">
            <label for="gate_pass_remarks" class="col-form-label">Gate Pass Remarks</label>
            <input type="text" class="form-control" id="gate_pass_remarks"
                   name="gate_pass_remarks"
                   placeholder="Gate Pass Remarks">
        </div>

        <!--                                    <div class="form-group col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                                <label for="pack_size" class="col-form-label">Pack Size</label>
                                                <input type="text" class="form-control" id="pack_size" name="pack_size"
                                                       placeholder="Pack Size">
                                            </div>-->

        <div class="form-group col-xs-12 col-sm-4 col-md-3 col-lg-3">
            <label for="vat" class="col-form-label">Vat</label>
            <input type="text" class="form-control" id="vat" name="vat" placeholder="vat" value="<?= set_value('vat') ?>">
        </div>

        <div class="form-group col-xs-12 col-sm-4 col-md-3 col-lg-3">
            <label for="client_id" class="col-form-label">Client</label>
            <select name="client_id" id="client_id" class="form-control">
                <option value="" name="client_id" label="Please Select">
                    <?php foreach ($client_list as $client) { ?>
                        <?php if (strtolower($client->client_type) == 'import') { ?>
                        <option class="import-type-color"
                                value="<?= $client->id ?>"
                                name="client_id"><?= $client->client_name ?>
                        </option>
                    <?php } else { ?>
                        <option class="lubzone-type-color"
                                value="<?= $client->id ?>"
                                name="client_id"><?= $client->client_name ?>
                        </option>
                        <?php
                    }
                }
                ?>
            </select>
        </div>

        <div class="form-group col-xs-12 col-sm-4 col-md-3 col-lg-3">
            <label for="invoice_number" class="col-form-label">Invoice Number</label>
            <input readonly="readonly" type="text" class="form-control" id="invoice_number"
                   name="invoice_number" value="<?= $invoice_number; ?>"
                   placeholder="Invoice Number">
        </div>

    </div>

    <div class="row">
        <div class="form-group col-xs-12 col-sm-4 col-md-3 col-lg-3">
            <label for="vat_registration_id" class="col-form-label">Vat Registration
                Id</label>
            <input type="text" class="form-control" id="vat_registration_id"
                   name="vat_registration_id" placeholder="Vat Registration Id">
        </div>

        <div class="form-group col-xs-12 col-sm-4 col-md-3 col-lg-3">
            <label for="date_of_issue" class="col-form-label">Date Of Issue</label>
            <input type="date" class="form-control" id="date_of_issue" name="date_of_issue"
                   value="<?= date("Y-m-d") ?>" placeholder="Date Of issue">
        </div>

        <div class="form-group col-xs-12 col-sm-4 col-md-3 col-lg-3">
            <label for="delivery_charge" class="col-form-label">Delivery Charge</label>
            <input type="text" class="form-control" id="delivery_charge"
                   name="delivery_charge"
                   placeholder="Delivery Charge">
        </div>

        <div class="form-group col-xs-12 col-sm-4 col-md-3 col-lg-3">
            <label for="others_charge" class="col-form-label">Others Charge</label>
            <input type="text" class="form-control" id="others_charge" name="others_charge"
                   placeholder="Others Charge">
        </div>

    </div>

    <div class="row">
        <div class="form-group col-xs-12 col-sm-4 col-md-3 col-lg-3">
            <label for="deduction" class="col-form-label">Deduction</label>
            <input type="text" class="form-control" id="deduction" name="deduction"
                   placeholder="Deduction">
        </div>

        <div class="form-group col-xs-12 col-sm-4 col-md-3 col-lg-3">
            <label for="deduction_type" class="col-form-label">Deduction Type</label>
            <select name="deduction_type" id="deduction_type" class="form-control">
                <option value="discount" name="deduction_type"
                        label="<?= ucfirst('discount') ?>">
                <option value="commission" name="deduction_type"
                        label="<?= ucfirst('commission') ?>">
            </select>
        </div>

        <div class="form-group col-xs-12 col-sm-4 col-md-3 col-lg-3">
            <label for="mode_of_payment" class="col-form-label">Mode Of Sale</label>
            <select name="mode_of_payment" id="mode_of_payment" class="form-control">
                <option value="" name="mode_of_payment">Please Select</option>
                <option value="cash" name="mode_of_payment">Cash</option>
                <option value="credit" name="mode_of_payment">Credit</option>
                <option value="card" name="mode_of_payment">Card</option>
                <option value="cheque" name="mode_of_payment">Cheque</option>
                <option value="tt" name="mode_of_payment">TT</option>
                <option value="draft" name="mode_of_payment">Draft/Pay order</option>
                <option value="mobile_banking" name="mode_of_payment">Mobile Banking
                </option>
            </select>
        </div>

        <div class="form-group col-xs-12 col-sm-4 col-md-3 col-lg-3">
            <label for="source" class="col-form-label">Source</label>
            <input type="text" class="form-control" id="source" name="source"
                   placeholder="Source">
        </div>

    </div>

    <div class="row">
        <!--<div class="form-group col-xs-12 col-sm-4 col-md-3 col-lg-3">
            <label for="delivery_certificate" class="col-form-label">Delivery
                Certificate</label>
            <input type="text" class="form-control" id="delivery_certificate"
                   name="delivery_certificate" placeholder="Delivery Certificate">
        </div>-->

        <div class="form-group col-xs-12 col-sm-4 col-md-3 col-lg-3">
            <label for="challan_number" class="col-form-label">Challan Number</label>
            <input readonly="readonly" type="text" class="form-control" id="challan_numer"
                   name="challan_number"
                   value="<?= $challan_number; ?>" placeholder="Challan Number">
        </div>

        <div class="form-group col-xs-12 col-sm-4 col-md-3 col-lg-3">
            <label for="branch_id" class="col-form-label">Outlet</label>
            <select name="branch_id" id="branch_id" class="form-control">
                <option value="" name="branch_id" label="Please Select">
                    <?php foreach ($branch_list as $branch) { ?>
                    <option value="<?= $branch->id ?>" name="branch_id"
                            label="<?= $branch->branch_name ?>">
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group col-xs-12 col-sm-4 col-md-3 col-lg-3">
            <label for="order_number" class="col-form-label">Order No</label>
            <input type="text" class="form-control" id="order_number" name="order_number"
                   placeholder="Order No">
        </div>

        <div class="form-group col-xs-12 col-sm-4 col-md-3 col-lg-3">
            <label for="order_date" class="col-form-label">Order Date</label>
            <input type="date" class="form-control" id="order_date" name="order_date" value="<?= date("Y-m-d") ?>">
        </div>

    </div>

    <div class="row">
        <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <label for="challan_number" class="col-form-label">Delivery Address</label>
            <textarea class="form-control" id="delivery_address" name="delivery_address" rows="2" placeholder="Delivery Address"></textarea>
        </div>

        <!--        <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
        
                </div>
        
                <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
        
                </div>-->

        <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <input type="hidden" id="grand_total" name="grand_total" value="">
            <label id="grand_total_amount" class="right-side-view">Total: <?= get_floating_point_number($product_total_price_session, TRUE) ?></label>
        </div>

    </div>

    <!--    <div class="col-xs-12 row form-group">
            $this->session->userdata('product_total_price')
            <input type="hidden" id="grand_total" name="grand_total" value="">
            <label id="grand_total_amount" class="right-side-view">Total: <?= get_floating_point_number($product_total_price_session, TRUE) ?></label>
        </div>-->

    <div class="row form-group">
        <button type="submit" name="confirm_sale_product_button" class="btn btn-default save-button confirm-button sale_confirm_button">Confirm</button>
    </div>
</form>

<script>
    $('#vat').keyup(get_grand_total_amount);
    $('#delivery_charge').keyup(get_grand_total_amount);
    $('#others_charge').keyup(get_grand_total_amount);
    $('#deduction').keyup(get_grand_total_amount);

    function get_grand_total_amount() {
        //total
        var total = 0;
        total = $('#total_session').val();
        if (total == '') {
            total = 0;
        } else {
            total = $('#total_session').val();
        }
        //vat
        var vat = 0;
        vat = $("#vat").val();
        if (vat == '') {
            vat = 0;
        } else {
            vat = $("#vat").val();
        }
        //delivery_charge
        var delivery_charge = 0;
        delivery_charge = $("#delivery_charge").val();
        if (delivery_charge == '') {
            delivery_charge = 0;
        } else {
            delivery_charge = $("#delivery_charge").val();
        }
        // var others_charge
        var others_charge = 0;
        others_charge = $("#others_charge").val();
        if (others_charge == '') {
            others_charge = 0;
        } else {
            others_charge = $("#others_charge").val();
        }
        //deduction
        var deduction = 0;
        var deduction = $("#deduction").val();
        if (deduction == '') {
            deduction = 0;
        } else {
            deduction = $("#deduction").val();
        }
        var grand_total = parseFloat(total) + parseFloat(vat) + parseFloat(delivery_charge) + parseFloat(others_charge) - parseFloat(deduction);
        $('#grand_total_amount').text('Total: ' + grand_total.toFixed(2));
    }
</script>