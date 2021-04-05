<div class="table-responsive">
    <?php
    $invoice_details;
    $sale_product_list;
    $sale_product_list_row;

//    echo '<pre>';
//    print_r($sale_product_list);
//    echo '</pre>';
//    die();
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
                    <td class="left-side-view"><strong>Sold
                            To:</strong> <?= $client_name_part_1 ?></td>
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

        <form id="delivery_cost_form" name="delivery_cost_form" action="<?= base_url('delivery_cost/save_delivery_cost') ?>" method="post">
            <input type="hidden" class="form-control" id="invoice_details_id" name="invoice_details_id" value="<?= !empty($invoice_details->id) ? intval($invoice_details->id) : 0; ?>">
            <table id="delivery-cost-table" class="table table-striped table-bordered table-hover table-responsive">
                <thead>
                    <tr>
                        <th style="width: 20px;">SL</th>
                        <th>Description</th>
                        <!--<th>Id</th>-->
                        <th style="width: 20%" class="text-right"><?= 'Amount ' . '(' . get_currency() . ')' ?></th>
                    </tr>
                </thead>      
                <tbody>
                    <?php
                    $count = 1;
                    if (!empty($delivery_cost_type_list)) {
                        foreach ($delivery_cost_type_list as $delivery_cost_type) {
                            $delivery_cost_type_id = intval($delivery_cost_type->id);
                            $delivery_cost_name = !empty($delivery_cost_type->delivery_cost_name) ? $delivery_cost_type->delivery_cost_name : '';
                            ?>
                            <tr>
                                <td><?= $count++; ?></td>
                                <td><?= $delivery_cost_name; ?></td>
                                <td class="text-right" style="display: none"><input type="hidden" step="any" class="form-control text-right" id="delivery_cost_type_id_<?= $delivery_cost_type_id ?>" name="delivery_cost_type_id" min="0" value="<?= $delivery_cost_type_id; ?>" placeholder=""></td>
                                <td class="text-right"><input type="number" step="any" class="amount form-control text-right" id="amount" name="amount" min="0" value="<?= get_floating_point_number(0); ?>" placeholder="Amount"></td>
                            </tr>                    
                        <?php }
                        ?>
                        <tr>
                            <td></td>                            
                            <td><strong>Total</strong></td>
                            <!--<td></td>-->
                            <td id="delivery_cost_total_amount" class="delivery_cost_total_amount text-right" style="font-weight: bold">0.00</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <div class="form-group row">
                                    <label for="delivery_cost_date" class="col-md-3 col-sm-12 col-xs-12 col-form-label">Delivery Cost Date</label>
                                    <div class="col-md-9 col-sm-12 col-xs-12">
                                        <input type="date" class="form-control col-xs-9" id="delivery_cost_date" name="delivery_cost_date" value="<?= get_current_date(); ?>" placeholder="Date">
                                    </div>
                                </div>
                            </td>
                                                            <!--<td></td>-->
                            <td>
                                <button type="submit" class="btn btn-default save-delivery-cost-button save-button" id="save-delivery-cost-button">Save</button>
                                <div class="col-xs-12 col-sm-6 loading-image" style="padding-top: 40px; float: right; display: none;"></div>
                            </td>
                        </tr>
                    <?php }
                    ?>
                </tbody>
            </table>
        </form>        
        <script type="text/javascript">

            $("table#delivery-cost-table").on("change", 'input[name^="amount"]', function (event) {
                if (!$(this).val() || $(this).val() === 0) {
                    $(this).val(0.00);
                    amountCalculation();
                }
            });
            $("table#delivery-cost-table").keyup('input[name^="amount"]', function (event) {
                amountCalculation();
            });
            amountCalculation();
            function amountCalculation() {
                var grandTotal = 0.00;
                var $tblrows = $("#delivery-cost-table tbody tr");
                var tableData = new Array();
                var rowData = {};
                var resultObj = {};
                $tblrows.each(function (index) {
                    var $tblrow = $(this);
                    var deliveryCostTypeId = parseFloat($tblrow.find("[name=delivery_cost_type_id]").val());
                    deliveryCostTypeId = isNaN(deliveryCostTypeId) ? 0.00 : deliveryCostTypeId;
                    var amount = parseFloat($tblrow.find("[name=amount]").val());
                    if (!isNaN(amount)) {
                        var amountTotal = 0.00;
                        //$tblrow.find('.amount').val(amount.toFixed(2));
                        $(".amount").each(function () {
                            var amountValue = parseFloat($(this).val());
                            amountTotal += isNaN(amountValue) ? 0.00 : amountValue;
                        });
                        grandTotal = amountTotal;
                    }
                    rowData = {'delivery_cost_type_id': deliveryCostTypeId, 'amount': amount};
                    if ((deliveryCostTypeId > 0) && (amount > 0)) {
                        tableData.push(rowData);
                    }
                });
                grandTotal = isNaN(grandTotal) ? 0.00 : grandTotal;
                resultObj = {'data': tableData, grand_total: grandTotal};
                var grandTotalResult = isNaN(resultObj['grand_total']) ? 0.00 : resultObj['grand_total'];
                $("#delivery_cost_total_amount").text(grandTotalResult.toFixed(2));
                return resultObj;
            }

            function deliveryCostFormValidation() {
                $('#delivery_cost_form').validate({
                    rules: {
                        delivery_cost_date: "required"
                    },
                    messages: {
                        delivery_cost_date: "Please Enter date"
                    },
                    errorElement: "em",
                    errorPlacement: function (error, element) {
                        // Add the `help-block` class to the error element
                        error.addClass("help-block");
                        if (element.prop("type") === "checkbox") {
                            error.insertAfter(element.parent("label"));
                        } else {
                            error.insertAfter(element);
                        }
                        if (element.attr("name") === "contact_id") {
                            error.insertAfter(".bootstrap-select.contact_id");
                        } else {
                            error.insertAfter(element);
                        }
                    },
                    highlight: function (element, errorClass, validClass) {
                        $(element).parents(".error-message").addClass("has-error").removeClass("has-success");
                    },
                    unhighlight: function (element, errorClass, validClass) {
                        $(element).parents(".error-message").addClass("has-success").removeClass("has-error");
                    },
                    invalidHandler: function (form, validator) {
                        //                    var errors = validator.numberOfInvalids();
                        //                    if (errors) {
                        //                        document.body.scrollTop = 0; // For Safari
                        ////                        document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
                        ////                        alert(validator.errorList[0].message);  //Only show first invalid rule message!!!
                        //                        validator.errorList[0].element.focus(); //Set Focus
                        //                    }
                    }
                });
                var isValid = $('#delivery_cost_form').valid();
                return isValid;
            }

            deliveryCostAction();
            function deliveryCostAction() {
                $('#save-delivery-cost-button').click(function (e) {
                    e.preventDefault();
                    var isValid = deliveryCostFormValidation();
                    if (isValid) {
                        var obj = {};
                        var invoiceDetailsId = $('input[name=invoice_details_id]').val();
                        invoiceDetailsId = isNaN(invoiceDetailsId) ? 0 : invoiceDetailsId;
                        var deliveryCostDate = $('input[name=delivery_cost_date]').val();
                        var table_data = amountCalculation();
                        var table_data_string = JSON.stringify(table_data);
                        obj = {'invoice_details_id': invoiceDetailsId, 'delivery_cost_date': deliveryCostDate, 'table_data': table_data_string};
                        if ((invoiceDetailsId > 0) && (deliveryCostDate !== '')) {
                            $.ajax({
                                type: "POST",
                                url: $('#delivery_cost_form').attr('action'),
                                data: obj,
                                success: function (data) {
                                    if (data['isDeliveryCostSave']) {
                                        alert(data['message']);
                                        window.location.href = data['redirectUrl'];
                                    } else {
                                        alert(data['message']);
                                        return false;
                                    }
                                },
                                beforeSend: function () {
                                    $("#save-delivery-cost-button").hide();
                                    $('.loading-image').show();
                                },
                                complete: function () {
                                    $("#save-delivery-cost-button").show();
                                    $('.loading-image').hide();
                                },
                                error: function (error) {
                                    console.log("error occured.");
                                }
                            });
                        } else {
                            alert('Please Check Input.');
                            return false;
                        }
                    } else {
                        return false;
                    }
                });
            }
        </script>
    <?php } ?>    
</div>


