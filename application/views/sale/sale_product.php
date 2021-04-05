<div style="padding-top: 0px"></div>

<style type="text/css">
    #page-wrapper {
        padding-top: 5px;
    }

    #page-wrapper.active {
        padding-top: 5px;
    }

    .custom-btn-lg {
        padding: 5px !important;
        font-size: 12px !important;
        height: 40px !important;
        border-radius: 0px !important;
        text-align: center;
        display: inline-flex;
        align-items: flex-end;
    }

    .btn-guest-bill, .btn-clear {
        margin-top: -10px;
        margin-bottom: -10px;
    }

    .cat-col { padding: 0px 2px; margin: 0px; }
    .cat-row { 
        padding: 0px 0px 0px 0px !important;
        margin: 0px 0px 0px 0px !important;
    }

    .button-text {
        width: 100%;
        /*opacity: 0.5;*/
        background: rgba(192,192,192,0.5);
    }
</style>

<div id="page-wrapper">
    <?php if (!empty($this->session->flashdata('message'))) { ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Success!</strong> <?php echo $this->session->flashdata('message'); ?>
        </div>
    <?php } ?>

    <?php if (!empty($this->session->flashdata('information_save_error_message'))) { ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Oops!</strong> <?php echo $this->session->flashdata('information_save_error_message'); ?>
        </div>
    <?php } ?>

    <?php if (!empty($this->session->flashdata('stock_insufficient_message'))) { ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Oops!</strong>
            <?php
                $stock_insufficient_message = $this->session->flashdata('stock_insufficient_message');
                foreach ($stock_insufficient_message as $res) {
                    echo $res;
                }
            ?>
        </div>
    <?php } ?>

    <?php
        $userInfo = $this->session->userdata['user_session'];
        $userType = $userInfo['user_type'];
        $button_backgound = $company_info->button_backgound;
        $category_name_status = $company_info->category_name;
        // echo "<pre>"; print_r($userInfo); exit();
    ?>

    <form id="sale_product_form" name="sale_product_form">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 custom-padding">
                <div class="panel panel-default custom-panel" style="background-color: #def5da; border-color: #def5da;">
                    <div class="panel-body custom-panel-body" style="padding: 2px 15px;">
                        <div class="row">
                            <?php if (empty($singleOutlect)): ?>
                                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                    <h4>
                                        Now You Are Selected On <span id="outletName"><?= $this->session->userdata('sessionOutletName') ?></span>
                                        <input type="hidden" id="outletId" name="outlet" value="<?= $this->session->userdata('sessionOutletId') ?>">
                                        <a data-toggle="modal" data-target="#myModal">Change Outlet</a>
                                    </h4>
                                </div>
                            <?php else: ?>
                                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                    <h4>Now You Are Selected On <?= $singleOutlect->branch_name ?></h4>
                                    <input type="hidden" id="outletId" name="outlet" value="<?= $singleOutlect->id ?>">
                                </div>
                            <?php endif ?>
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <?php
                                    if ($this->session->userdata('invoiceId')) {
                                        $invoiceId = $this->session->userdata('invoiceId');
                                    } else {
                                        $invoiceId = "";
                                    }

                                    if ($this->session->userdata('invoiceNumber')) {
                                        $invoiceNumber = $this->session->userdata('invoiceNumber');
                                    } else {
                                        $invoiceNumber = "";
                                    }

                                    if ($this->session->userdata('tokenNumber')) {
                                        $tokenNumber = $this->session->userdata('tokenNumber');
                                    } else {
                                        $tokenNumber = "";
                                    }

                                    if ($this->session->userdata('tokenNumberForShow')) {
                                        $tokenNumberForShow = $this->session->userdata('tokenNumberForShow');
                                    } else {
                                        $tokenNumberForShow = "";
                                    } 

                                    if ($this->session->userdata('tableId')) {
                                        $tableId = $this->session->userdata('tableId');
                                    } else {
                                        $tableId = "";
                                    }

                                    if ($this->session->userdata('tableNumber')) {
                                        $tableNumber = $this->session->userdata('tableNumber');
                                    } else {
                                        $tableNumber = "";
                                    }                                    
                                ?>
                                <h4>
                                    <?= $business_type == 0 ? 'Table Number' : 'Token Number' ?> : <span id="tokenNumberForShow"><?= $business_type == 0 ? $tableNumber : $tokenNumberForShow ?></span>
                                </h4>
                                <!-- <h4>Table Number : <span id="tableNumber"><?= $tableNumber ?></span></h4> -->
                                <input type="hidden" name="tokenNumber" id="tokenNumber" value="<?= $tokenNumber ?>" readonly>
                                <input type="hidden" name="tableId" id="tableId" value="<?= $tableId ?>" readonly>
                                <input type="hidden" name="invoiceId" id="invoiceId" value="<?= $invoiceId ?>" readonly>
                                <input type="hidden" name="invoiceNumber" id="invoiceNumber" value="<?= $invoiceNumber ?>" readonly>
                                <input type="hidden" name="saleType" id="saleType" value="<?= $saleType ?>" readonly>
                                <input type="hidden" id="userType" name="userType" value="<?= $userType ?>">
                                <input type="hidden" id="pendingOrderStatus" name="pendingOrderStatus" value="<?= $this->session->userdata('pendingOrderStatus') ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 custom-padding">
                <!-- Modal -->
                <?php if (!empty($allOutlet)): ?>
                    <div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
                        <div class="modal-dialog modal-dialog-center">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <!-- <button type="button" class="close btnCheck" data-dismiss="modal">&times;</button> -->
                                    <h4 class="modal-title">All Outlets</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <select id="outlet" class="form-control select2">
                                            <option value="">Select Outlet</option>
                                            <?php foreach ($allOutlet as $outlet) { ?>
                                                <option value="<?= $outlet->id ?>"><?= ucfirst($outlet->branch_name) ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <!-- <button type="button" class="btn btn-default btnCheck" data-dismiss="modal">Close</button> -->
                                </div>
                            </div>
                        </div>
                    </div>                          
                <?php endif ?>

                <div class="panel panel-default custom-panel" style="background-color: #e0e9ec; border-color: #e0e9ec;">
                    <div class="panel-body custom-panel-body">
                        <div id="productType">
                            <div class="row cat-row">
                                <?php foreach ($product_type_list as $product_type) { ?>
                                    <?php
                                        $product_type_name = '';
                                        if ($category_name_status == 1) {
                                            $product_type_name = $product_type->product_type_name;
                                        }
                                        

                                        $all_word = explode(' ',trim($product_type->product_type_name));
                                        $category_name = "";

                                        for ($i = 1; $i <= count($all_word); $i++) { 
                                            if ($i < count($all_word)) {
                                                $letter_or_word = trim($all_word[$i-1])[0].".";
                                            }
                                            else {
                                                $letter_or_word = " ".$all_word[$i-1];
                                            }
                                            $category_name .= $letter_or_word;
                                        }

                                        preg_match_all('/(?<=\s|^)[a-z]/i', $product_type->product_type_name, $matches);
                                        $first_letter_of_first_word = $matches[0];
                                        $first_letter_of_all_word = implode('',$matches[0]);

                                        // echo "<pre>"; print_r(count($all_word));
                                        // echo "<pre>"; print_r($first_letter_of_all_word);
                                        // echo "<pre>"; print_r(trim($all_word[0])[0]);
                                        // echo "<pre>"; print_r($category_name); exit();
                                    ?>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 cat-col">
                                        <?php if ($button_backgound == 'image' && !empty($product_type->image)): ?>
                                            <span class="btn btn-primary custom-btn-lg btn-block product-type-mr" style="white-space: normal; background: url(<?= $product_type->image ?>) no-repeat; background-size: 100px 40px;" onclick="showProductByProductType(<?= $product_type->id ?>)">
                                                <b class="button-text"><?= $product_type_name ?></b>
                                            </span>
                                        <?php else: ?>
                                            <span class="btn btn-primary custom-btn-lg btn-block product-type-mr" style="white-space: normal; background-color: <?= $product_type->button_color ?>;" onclick="showProductByProductType(<?= $product_type->id ?>)">
                                                <b><?= $product_type->product_type_name ?></b>
                                            </span>
                                        <?php endif ?>
                                        <!-- <span class="btn btn-primary custom-btn-lg btn-block product-type-mr" style="white-space: normal; background-color: <?= $product_type->button_color ?>;" onclick="showProductByProductType(<?= $product_type->id ?>)"><b><?= $category_name ?></b></span> -->
                                    </div>
                                <?php } ?>
                            </div>
                            <!-- <span class="btn btn-danger btn-sm product-type-mr" onclick="clearProductSection()"><b>Clear</b></span> -->
                        </div>
                    </div>
                </div>

                <div class="panel panel-default custom-panel" style="background-color: #ebe1f5; border-color: #ebe1f5;">
                    <div class="panel-body custom-panel-body">
                        <div id="products">
                            <p>To Show Products Click On Category Name</p>
                        </div>                                    
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 custom-padding">
                <div class="panel panel-default custom-panel" style="background-color: #efe1e1; border-color: #efe1e1">
                    <div class="panel-body custom-panel-body">
                        <div class="row">
                            <div class="col-lg-10 col-md-9 col-sm-9 col-xs-8">
                                <div class="form-group">
                                    <select id="allProduct" class="form-control select2">
                                        <option value="">Please Select Product</option>
                                        <?php foreach ($product_list as $product) { ?>
                                            <option value="<?= $product->id ?>"><?= ucfirst($product->product_name) ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-3 col-xs-4">
                                <div class="form-group" style="margin-left: 0px;">
                                    <span class="btn btn-primary btn-md btn-block" onclick="addProduct()">Add</span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-9 col-md-9 col-sm-6 col-xs-8">
                                <div class="form-group">
                                    <select id="allPendingOrder" class="form-control select2">
                                        <option value="">Please Select Pending Order</option>
                                        <?php foreach ($pendingOrderList as $pendingOrder) { ?>
                                            <?php
                                                $pendingDate = date('ymd',strtotime($pendingOrder->order_date));
                                                $token = str_replace("-".$pendingDate, "", $pendingOrder->token_number);
                                            ?>
                                            <option value="<?= $pendingOrder->id ?>"><?= $business_type == 0 ? $pendingOrder->tableNumber : $token ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-4">
                                <div class="form-group" style="margin-left: 0px;">
                                    <span class="btn btn-primary btn-md <?= $business_type == 0 ? '' : 'btn-block' ?>" onclick="showPendingOrder()">Show</span>
                                    <?php if ($business_type == 0): ?>
                                        <span class="btn btn-primary btn-md" onclick="showLobby()">Lobby</span>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="lobbyModal" role="dialog" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog modal-dialog-center modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close btnCheck" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">All Table</h4>
                            </div>
                            <div class="modal-body">
                                <div id="lobby_info"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default btnCheck" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="newOrderModal" role="dialog" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog modal-dialog-center">
                        <div class="modal-content">
                            <!-- <div class="modal-header">
                                <button type="button" class="close btnCheck" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">All Table</h4>
                            </div> -->
                            <div class="modal-body text-center">
                                <h3>Are You Want To Submit New Order</h3>
                                <input type="hidden" id="newOrderTableId" value="">
                                <span class="btn btn-success btn-lg new_order" button-value="yes">Yes</span>
                                <span class="btn btn-danger btn-lg new_order" button-value="no">No</span>
                                <button type="button" class="btn btn-warning btn-lg btnCheck" data-dismiss="modal">Cancel</button>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default btnCheck" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default custom-panel" style="background-color: #bfbfbf; border-color: #bfbfbf;">
                    <div class="panel-body custom-panel-body">
                        <div class="table-responsive">
                            <table id="product-details" class="table table-bordered table-sm">
                                <thead>
                                    <!-- <th width="50px">Code</th> -->
                                    <th>Name</th>
                                    <th width="80px">Price</th>
                                    <th width="80px">QTY</th>
                                    <th width="80px">Disc %</th>
                                    <th width="90px">Total</th>
                                    <th width="20px"><i class="fa fa-trash" style="color: red;" id="remove" data-toggle="tooltip" title="Remove All The Item" onclick="removeAllItem()"></i></th>
                                </thead>

                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 custom-padding">
                <div class="panel panel-default custom-panel" style="background-color: #fde2cf; border-color: #fde2cf">
                    <div class="panel-body custom-panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div id="customerDiv">
                                        <select id="allCustomer" name="customerId" class="form-control select2">
                                            <option value="">Please Select Customer</option>
                                            <option value="add new customer">Add New Customer</option>
                                            <?php foreach ($client_list as $client) { ?>
                                                <?php
                                                    $select = '';
                                                    if (!empty($this->session->userdata('clientId'))) {
                                                        $clientId = $this->session->userdata('clientId');
                                                        if ($client->id == $clientId) {
                                                            $select = 'selected';
                                                        } else {
                                                            $select = '';
                                                        }                                                                    
                                                    }
                                                ?>
                                                <option value="<?= $client->id ?>" <?= $select ?>><?= ucfirst($client->client_name) ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <div id="customer-info"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <?php
                                $clearButtonCol = "col-lg-12 col-md-12 col-sm-12 col-xs-12";
                                $clearButtonStyle = "";
                            ?>
                            <?php if ($saleType != 'factory_sale'): ?>
                                <?php
                                    $clearButtonCol = "col-lg-6 col-md-6 col-sm-6 col-xs-12";
                                    $clearButtonStyle = "padding-left: 2px;";
                                ?>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="padding-right: 2px;">
                                    <div class="form-group">
                                        <span class="btn btn-primary btn-lg btn-block btn-guest-bill" onclick="guestBill()">Guest Bill</span>
                                    </div>                                
                                </div>                               
                            <?php endif ?>

                            <div class="<?= $clearButtonCol ?>" style="<?= $clearButtonStyle ?>">
                                <div class="form-group">
                                    <span class="btn btn-danger btn-lg btn-block btn-clear" id="clear" onclick="clearAllItem()">Clear</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default custom-panel" style="background-color: #f3f3d5; border-color: #f3f3d5">
                    <div class="panel-body custom-panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <table width="100%">
                                        <tr style="display: none;">
                                            <th>Item</th>
                                            <td align="right">
                                                <input class="form-control" type="number" min="0" id="totalItem" name="totalItem" style="text-align: right" value="0" readonly>
                                            </td>
                                        </tr>
                                        <tr style="display: none;">
                                            <th style="padding-top: 5px">Quantity</th>
                                            <td style="padding-top: 5px" align="right">
                                                <input class="form-control" type="number" min="0" id="totalQty" name="totalQty" style="text-align: right" value="0" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="padding-top: 5px">Sub Total</th>
                                            <td style="padding-top: 5px" align="right">
                                                <input class="form-control" type="number" min="0" id="subTotal" name="subTotal" style="text-align: right" value="0" readonly>
                                            </td>
                                            <td rowspan="3">
                                                <textarea class="form-control" rows="5" cols="30" rows="5" id="order_notes" name="order_notes" placeholder="Order Notes Here..."></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="padding-top: 5px">VAT</th>
                                            <td style="padding-top: 5px" align="right">
                                                <input class="form-control" type="number" min="0" id="totalVat" name="totalVat" style="text-align: right" value="0" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="padding: 5px 5px 0px 0px">
                                                <!-- <div>Discount</div> -->
                                                <div>
                                                    <?php
                                                        $discountArray = array('fixed' => 'Discount','prcentage' => 'Dis (%)','request' => 'Request');
                                                    ?>
                                                    <select name="discountOption" id="discountOption" class="form-control select2" onchange="getOverallCalculation()" <?= $userInfo['invoice_discount_access'] == 0 ? 'disabled' : '' ?>>
                                                        <option value="">Select Option</option>
                                                        <?php foreach ($discountArray as $key => $value): ?>
                                                            <?php
                                                                $select = '';
                                                                if (!empty($this->session->userdata('discountOption'))) {
                                                                    $sessionDiscoutnOption = $this->session->userdata('discountOption');
                                                                    if ($key == $sessionDiscoutnOption) {
                                                                        $select = 'selected';
                                                                    } else {
                                                                        $select = '';
                                                                    }                                                                    
                                                                }
                                                            ?>
                                                            <option value="<?= $key ?>" <?= $select ?>><?= ucfirst($value) ?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                            </th>
                                            <td style="padding-top: 5px" align="right">
                                                <?php $sessionDiscountValue = $this->session->userdata('overallDiscount'); ?>
                                                <input class="form-control" type="number" min="0" step="0.01" id="overallDiscount" name="overallDiscount" oninput="getOverallCalculation()" style="text-align: right" value="<?= empty($sessionDiscountValue) ? 0 : $sessionDiscountValue ?>" <?= $userInfo['invoice_discount_access'] == 0 ? 'disabled' : '' ?>>
                                                <input class="form-control" type="hidden" min="0" id="discountValue" name="discountValue" oninput="getOverallCalculation()" style="text-align: right" value="0">
                                            </td>
                                        </tr>
                                    </table>

                                    <div style="border-bottom: 1px solid black; margin: 10px 0px"></div>

                                    <table width="100%">
                                        <tr>
                                            <th width="50%">Total Payable</th>
                                            <td align="right">
                                                <input class="form-control" type="number" min="0" id="totalPayable" name="totalPayable" style="text-align: right" value="0" readonly>
                                            </td>
                                        </tr>
                                    </table>

                                    <div style="border-bottom: 1px solid black; margin: 10px 0px"></div>

                                    <table width="100%">
                                        <tr>
                                            <th width="50%">Payment Type</th>
                                            <td>
                                                <?php
                                                    $paymentTypeArray = array('Cash' => 'Cash','Card' => 'Card','Split' => 'Split');
                                                    if ($saleType == "factory_sale") {
                                                        $paymentTypeArray['Due'] = 'Due';
                                                    }
                                                ?>
                                                <select name="paymentType" id="paymentType" class="form-control select2">
                                                    <option value="">Select</option>
                                                    <?php foreach ($paymentTypeArray as $key => $value): ?>
                                                        <option value="<?= $key ?>"><?= ucfirst($value) ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>

                                    <div id="cashDiv">
                                        <table width="100%">
                                            <tbody>
                                                <tr>
                                                    <td width="50%" style="padding: 5px 2px 0px 0px;">
                                                        <input class="form-control" type="number" min="0" step="0.01" id="paidAmount" name="paidAmount" oninput="getOverallCalculation()" style="text-align: right" placeholder="Paid">
                                                    </td>
                                                    <td width="50%" style="padding: 5px 0px 0px 2px;">
                                                        <input class="form-control" type="number" min="0" step="0.01" id="changeAmount" name="changeAmount" oninput="getOverallCalculation()" style="text-align: right" placeholder="Change">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div id="dueDiv">
                                        <table width="100%">
                                            <tbody>
                                                <tr>
                                                    <td width="50%" style="padding: 5px 2px 0px 0px;">
                                                        <input class="form-control" type="number" min="0" step="0.01" id="cashAmount" name="cashAmount" oninput="getOverallCalculation()" style="text-align: right" placeholder="Cash">
                                                    </td>
                                                    <td width="50%" style="padding: 5px 0px 0px 2px;">
                                                        <input class="form-control" type="number" min="0" step="0.01" id="dueAmount" name="dueAmount" oninput="getOverallCalculation()" style="text-align: right" placeholder="Due">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div id="splitDiv">
                                        <table width="100%">
                                            <tbody>
                                                <tr>
                                                    <td width="50%" style="padding: 5px 2px 0px 0px;">
                                                        <input class="form-control" type="number" min="0" step="0.01" id="cashPayment" name="cashPayment" oninput="getOverallCalculation()" style="text-align: right" placeholder="Cash">
                                                    </td>
                                                    <td width="50%" style="padding: 5px 0px 0px 2px;">
                                                        <input class="form-control" type="number" min="0" step="0.01" id="cardPayment" name="cardPayment" oninput="getOverallCalculation()" style="text-align: right" placeholder="Card">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div style="border-bottom: 1px solid black; margin: 10px 0px"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <?php
                                $completeButtonCol = "col-lg-12 col-md-12 col-sm-12 col-xs-12";
                                $completeButtonStyle = "";
                            ?>
                            <?php if ($saleType != 'factory_sale'): ?>
                                <?php
                                    $completeButtonCol = "col-lg-6 col-md-6 col-sm-6 col-xs-12";
                                    $completeButtonStyle = "padding-left: 2px;";
                                ?>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="padding-right: 2px;">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block saveButton" id="submitButton" name="saveButton" value="Submit">Submit</button>
                                    </div>
                                </div>                                
                            <?php endif ?>

                            <div class="<?= $completeButtonCol ?>" style="<?= $completeButtonStyle ?>">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success btn-lg btn-block saveButton" id="completeButton" name="saveButton" value="Complete">Complete</button>
                                    <input type="hidden" id="buttonValue" name="buttonValue">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div id="customer-info"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="modal fade" id="addNewCustomerModal" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-center modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close btnCheck" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add new Customer</h4>
                </div>
                <form id="customer_form" name="customer_form">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="client_name">Client Name</label>
                                    <input type="text" class="form-control" id="client_name" name="client_name" value="" placeholder="Client Name">
                                    <?php
                                        if ($saleType == 'factory_sale') {
                                            $customerFor = 'Factory';
                                        } else {
                                            $customerFor = 'Outlet';
                                        }                                        
                                    ?>
                                    <input type="hidden" class="form-control" id="customerFor" name="customerFor" value="<?= $customerFor ?>">
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="client_code">Client Code</label>
                                    <input type="text" class="form-control" id="client_code" name="client_code" value="" placeholder="Client Code">
                                    <input type="hidden" class="form-control" id="saveFrom" name="saveFrom" value="outside">
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="" placeholder="Email">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="cell_number">Cell Number</label>
                                    <input type="text" class="form-control" id="cell_number" name="cell_number" value="" placeholder="Cell Number">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="phone_number">Phone Number</label>
                                    <input type="text" class="form-control" id="phone_number" name="phone_number" value="" placeholder="Phone Number">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea class="form-control" rows="2" id="address" name="address" placeholder="Address"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="client_area">Client Area</label>
                                    <textarea class="form-control" rows="2" id="client_area" name="client_area" placeholder="Client Area"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-default btnCheck" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="discountRequestModal" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-center modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close btnCheck" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Request For Discount</h4>
                </div>
                <form id="request_discount_form" name="request_discount_form">
                    <div class="modal-body">
                        <div class="row" id="msgDiv" style="display: block;">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                <div class="form-group">
                                    <h4 style="color: green;" id="msgTag"></h4>
                                    <h4 style="color: red;" id="errorMsgTag"></h4>
                                    <div id="loader"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="formContenet">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="client_name">Branch Name</label>
                                    <input type="text" class="form-control" id="requestBranchName" name="requestBranchName" value="" placeholder="Branch Name" readonly>
                                    <input type="hidden" class="form-control" id="requestBranchId" name="requestBranchId" value="">
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="token-number">Token Number</label>
                                    <input type="text" class="form-control" id="requestTokenNumberForShow" name="requestTokenNumberForShow" value="" placeholder="Token Number" readonly>
                                    <input type="hidden" class="form-control" id="requestTokenNumber" name="requestTokenNumber" value="">
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="discount">Dicount (%)</label>
                                    <input type="number" min="10" class="form-control" id="requestDiscount" name="requestDiscount" value="" placeholder="Discount (%)">
                                </div>
                            </div>
                        </div>

                        <div class="row" id="formContenet">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="client_name">Reason</label>
                                    <textarea class="form-control" id="requestReason" name="requestReason"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="requestDiscountSave" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-default btnCheck" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- <div class="loader"></div> -->
    <!-- <div class="svg-test"> -->

    <div class="printableArea" style="padding: 15px;"></div>
</div>
<!-- /#page-wrapper -->
  
<script>
    $(document).ready(function () {
        $('#splitDiv').hide();
        $('#dueDiv').hide();

        if ($('#outletId').val() == "") { $('#myModal').modal('show'); }
        var customerId = $('#allCustomer').val();

        if (customerId) { showCustomerInfo(customerId) }        
        
        $("#outlet").val($("#outlet option:first").val());
        showSessionProductInfo();
    });

    $('#submitButton, #completeButton').click(function(){
        var buttonValue = $(this).val();
        $('#buttonValue').val(buttonValue);
    });

    $('#sale_product_form').submit(function(event){
        event.preventDefault();
        var totalPayable = $('#totalPayable').val();
        var outlet = $('#outlet').val();
        var paymentType = $('#paymentType').val();
        var discountOption = $('#discountOption').val();
        var overallDiscount = $('#overallDiscount').val();
        var buttonValue = $('#buttonValue').val();
        var tokenNumberForShow = $('#tokenNumberForShow').val();
        var pendingOrderId = $("#allPendingOrder").val();
        var saleType = $("#saleType").val();
        var customerId = $("#allCustomer").val();

        if (overallDiscount > 0) {
            if (discountOption == "") {
                error = "Select Discount Option";
                swal({
                    title: "<small class='text-danger'>Error!</small>", 
                    type: "error",
                    text: error,
                    // timer: 2000,
                    html: true,
                });
                return false;
            }
        }

        if (buttonValue == 'Complete') {
            if (saleType == "factory_sale" && customerId == "") {
                error = "Select A Customer";
                swal({
                    title: "<small class='text-danger'>Error!</small>", 
                    type: "error",
                    text: error,
                    // timer: 2000,
                    html: true,
                });
                return false;
            }

            if (paymentType == "") {
                error = "Select Payment Type";
                swal({
                    title: "<small class='text-danger'>Error!</small>", 
                    type: "error",
                    text: error,
                    // timer: 2000,
                    html: true,
                });
                return false;
            }

            if (paymentType == "Cash") {
                var paidAmount = $('#paidAmount').val();
                if (paidAmount == "") {
                    error = "Enter Paid Amount";
                    swal({
                        title: "<small class='text-danger'>Error!</small>", 
                        type: "error",
                        text: error,
                        // timer: 2000,
                        html: true,
                    });
                    return false;
                }
            }

            if (paymentType == "Split") {
                var cashPayment = $('#cashPayment').val();
                if (cashPayment == "") {
                    error = "Enter Cash Payment";
                    swal({
                        title: "<small class='text-danger'>Error!</small>", 
                        type: "error",
                        text: error,
                        // timer: 2000,
                        html: true,
                    });
                    return false;
                }
            }

            if (paymentType == "Due") {
                var cashAmount = $('#cashAmount').val();
                if (cashAmount == "") {
                    error = "Enter Cash Amount";
                    swal({
                        title: "<small class='text-danger'>Error!</small>", 
                        type: "error",
                        text: error,
                        // timer: 2000,
                        html: true,
                    });
                    return false;
                }
            }
        }

        if (totalPayable == 0) {
            error = "Add Product For Sale";
            swal({
                title: "<small class='text-danger'>Error!</small>", 
                type: "error",
                text: error,
                // timer: 2000,
                html: true,
            });
        }
        else {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url("sale_product/save/") ?>',
                data: $("#sale_product_form").serialize(),
                async: false,
                dataType: 'json',
                success: function (data) {
                    if (data.status == false) {
                        swal("Error!",data.output, "error");
                    }
                    else {
                        if (buttonValue == 'Complete') {
                            var mode = 'iframe'; //popup
                            var close = mode == "popup";
                            var options = {
                                popTitle: tokenNumberForShow,
                                mode: mode,
                                popClose: close
                                // popClose: false
                            };
                            $(".printableArea").html(data.output);
                            $("div.printableArea").printArea(options);
                            $("#invoiceId").val("");
                            $("#invoiceNumber").val("");
                            if (pendingOrderId) {
                                $("#allPendingOrder option[value="+pendingOrderId+"]").remove();
                                $("#allPendingOrder").val("");
                                $("#allPendingOrder").select2().trigger('change');
                            }
                        }
                        $('.productRow').remove();
                        getOverallCalculation();
                        $(".printableArea").html("");
                        $("#customer-info").html("");
                        $("#allProduct").val("").trigger('change');
                        $("#allCustomer").val("").trigger('change');
                        $("#discountOption").val("").trigger('change');
                        $("#overallDiscount").val(0);
                        $("#discountValue").val(0);
                        $("#paymentType").val("").trigger('change');
                        $("#paidAmount").val(0);
                        $("#changeAmount").val(0);
                        $("#cashPayment").val(0);
                        $("#cardPayment").val(0);
                        $("#order_notes").val("");
                        getTokenNumber();
                        if (buttonValue == 'Submit') {
                            swal({
                                title: "<small class='text-success'>Success!</small>", 
                                type: "success",
                                text: data.output,
                                // timer: 2000,
                                html: true,
                            });
                        }
                        destroySessionProductInfo();
                    }
                },
                error: function () {
                }
            });
        }
    });

    function guestBill() {
        var totalPayable = $('#totalPayable').val();
        var discountValue = $('#discountValue').val();
        var orderNote = $('#order_notes').val();

        if (totalPayable == 0) {
            error = "Add Product And Submit Order For Guest Bill";
            swal({
                title: "<small class='text-danger'>Error!</small>", 
                type: "error",
                text: error,
                // timer: 2000,
                html: true,
            });
        }
        else {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url("sale_product/get_guest_bill/") ?>',
                data: {discountValue:discountValue,orderNote:orderNote},
                success: function (data) {
                    if (data.output == "") {
                        error = "Please Submit This Order For Guest Bill";
                        swal({
                            title: "<small class='text-danger'>Error!</small>", 
                            type: "error",
                            text: error,
                            // timer: 2000,
                            html: true,
                        });
                    }
                    else {
                        var mode = 'iframe'; //popup
                        var close = mode == "popup";
                        var options = {
                            mode: mode,
                            popClose: close
                        };

                        $(".printableArea").html(data.output);
                        $("div.printableArea").printArea(options);
                        $(".printableArea").html("");

                        showSessionProductInfo();
                    }
                },
                error: function () {
                }
            })
        }
    }

    function getTokenNumber() {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("sale_product/getTokenNumber/") ?>',
            data: {},
            success: function (data) {
                var sessionOutletBusinessType = "<?= $this->session->userdata('sessionOutletBusinessType'); ?>";
                var showNumber = data.tokenNumberForShow;
                if (sessionOutletBusinessType == 0) {
                    showNumber = "<?= $this->session->userdata('tableNumber'); ?>"
                }
                $('#tokenNumber').val(data.tokenNumber);
                $('#tokenNumberForShow').html(showNumber);
            },
            error: function () {
            }
        })
    }

    function showSessionProductInfo()
    {
        $.ajax({
            type: "GET",
            url: '<?php echo base_url("sale_product/showProductInfo/") ?>',
            // data: {productTypeId:productTypeId},
            success: function (data) {
                $('#product-details tbody').html(data.output);
                $('#order_notes').html(data.sessionOrderNote);

                if (data.totalGuestBill > 0 && data.userType != 'admin') {
                    $('#remove').css('display','none');
                    $("#clear").prop("onclick", null).off("click");
                }
            },
            error: function () {

            }
        })
    }

    function showProductByProductType(productTypeId)
    {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("sale_product/get_product_by_product_type/") ?>',
            data: {productTypeId:productTypeId},
            success: function (data) {
                var output = '';
                var product_list = data.output;
                var products = data.products;
                output += '<div class="row cat-row">';
                for (product of products)
                {
                    var all_word = product.product_name.split(' ');
                    var category_name = ""; 

                    for (var i = 1; i <= all_word.length; i++) {
                        if (i < all_word.length) {
                            var letter_or_word = all_word[i-1].charAt(0)+".";
                        }
                        else {
                            var letter_or_word = " "+all_word[i-1];
                        }
                        category_name += letter_or_word;
                    }
                    // alert(category_name);
                    output += '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 cat-col">';
                    output += '<span class="btn btn-primary custom-btn-lg btn-block product-mr" style="white-space: normal; background-color: '+product.buttonColor+';" onclick="getProductInfoById('+product.id+')"><b>'+product.product_name+'</b></span>';
                    // output += '<span class="btn btn-primary custom-btn-lg btn-block product-mr" style="white-space: normal; background-color: '+product.buttonColor+';" onclick="getProductInfoById('+product.id+')"><b>'+category_name+'</b></span>';
                    output += "</div>";
                }
                output += "</div>";
                $('#products').html(product_list);
            },
            error: function () {

            }
        });
    }

    function getProductInfoById(productId)
    {
        if (productId == $('#productId_'+productId).val())
        {
            var selectedProductQty = parseInt($('#qty_'+productId).val());
            selectedProductQty = selectedProductQty + 1;
            $('#qty_'+productId).val(selectedProductQty);
            getTotalPrice(productId);
        }
        else
        {
            if (productId != "")
            {
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url("sale_product/get_product_info_by_id/") ?>',
                    data: {productId:productId},
                    success: function (data) {
                        $('#product-details tbody').html(data);
                    },
                    error: function () {

                    }
                });
            }
        }
    }

    function showPendingOrder()
    {
        var pendingOrderId = $('#allPendingOrder').val();
        var tableId = $('.booked').attr('table-id');

        if (pendingOrderId == "" && typeof tableId === 'undefined')
        {
            error = "Select Pending Order";
            swal({
                title: "<small class='text-danger'>Error!</small>", 
                type: "error",
                text: error,
                // timer: 2000,
                html: true,
            });
        }
        else {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url("sale_product/get_order_info/") ?>',
                data: {pendingOrderId:pendingOrderId,tableId:tableId},
                success: function (data) {
                    // destroySessionProductInfo();
                    var invoiceDetailsInfo = data.invoiceDetailsInfo;

                    if (invoiceDetailsInfo.client_id != 0) {
                        showCustomerInfo(invoiceDetailsInfo.client_id)
                    }
                    else {
                        $('#customer-info').html('Customer Information Not Found');
                    }

                    $('#invoiceId').val(data.invoiceId);
                    $('#invoiceNumber').val(data.invoiceNumber);
                    $('#tokenNumber').val(data.tokenNumber);
                    // $('#tokenNumberForShow').html(data.tokenNumberForShow);
                    $('#product-details tbody').html(data.productInfoTable);
                    $('#discountOption').val(data.discountOption);
                    $('#discountOption').select2().trigger('change');
                    $('#overallDiscount').val(data.overallDiscount);
                    $('#order_notes').val(data.orderNote);
                    $('#tableId').val(data.tableId);
                    $('#tokenNumberForShow').html(data.showNumberInfo);
                    $('#pendingOrderStatus').val(data.pendingOrderStatus);
                    getOverallCalculation();
                    $('#lobbyModal').modal('hide');
                    
                },
                error: function () {

                }
            });
        }
    }

    function showLobby()
    {
        var outletId = $('#outletId').val();
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("sale_product/get_table_info/") ?>',
            data: {outletId:outletId},
            success: function (data) {
                $('#lobby_info').html(data.output);
                $('#lobbyModal').modal('show');
            },
            error: function () {

            }
        });
    }

    $(document).on('click','.new_order',function(e) {
        var newOrderButtonValue = $(this).attr('button-value');
        if (newOrderButtonValue == 'yes') {
            var tableId = $('#newOrderTableId').val();
            set_table_info(tableId);            
            $('#newOrderModal').modal('hide');
        } else {            
            $('#newOrderModal').modal('hide');
        }
    });

    $(document).on('click','.not_booked',function(e) {
        e.preventDefault();
        var tableId = $(this).attr("table-id");
        var pendingOrderStatus = $('#pendingOrderStatus').val();

        if (pendingOrderStatus == 'yes') {
            $('#lobbyModal').modal('hide');
            $('#newOrderTableId').val(tableId);
            $('#newOrderModal').modal('show');
        } else {
            set_table_info(tableId);
        }
    });

    function set_table_info(tableId) {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("sale_product/set_table_info/") ?>',
            data: {tableId:tableId},
            success: function (data) {
                $('#tableId').val(data.tableId);
                $('#tokenNumberForShow').html(data.tableNumber);
                $('#lobbyModal').modal('hide');
                $('#pendingOrderStatus').val(data.pendingOrderStatusInput);
                if (data.pendingOrderStatus == 'yes') {
                    $('#buttonValue').val('Pending Order');
                    $('.productRow').remove();
                    getOverallCalculation();
                    $(".printableArea").html("");
                    $("#customer-info").html("");
                    $("#allProduct").val("").trigger('change');
                    $("#allCustomer").val("").trigger('change');
                    $("#discountOption").val("").trigger('change');
                    $("#overallDiscount").val(0);
                    $("#discountValue").val(0);
                    $("#paymentType").val("").trigger('change');
                    $("#allPendingOrder").val("").trigger('change');
                    $("#paidAmount").val(0);
                    $("#changeAmount").val(0);
                    $("#cashPayment").val(0);
                    $("#cardPayment").val(0);
                    $("#order_notes").val("");
                    getTokenNumber();
                    destroySessionProductInfo();
                }
            },
            error: function () {
            }
        });
    }

    $('#outlet').change(function () {
        var outletVal = $( "#outlet" ).val();
        var outletName = $( "#outlet option:selected" ).text();
        if (outletVal == "") {
            error = "You Have To Select A Outlet";
            swal({
                title: "<small class='text-danger'>Error!</small>", 
                type: "error",
                text: error,
                // timer: 2000,
                html: true,
            });
        } else {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url("sale_product/setOutletIdInSession/") ?>',
                data: {outletVal:outletVal,outletName:outletName,},
                success: function (data) {
                    // $('#outletId').val(outletVal);
                    // $('#outletName').html(outletName);
                    // $('#tokenNumber').val(data.tokenNumber);
                    // $('#tokenNumberForShow').html(data.tokenNumberForShow);
                    destroySessionProductInfo();
                },
                error: function () {
                }
            })
            $("#myModal").modal('hide');
        }
    });

    $('#allProduct').change(function () {
        var productId = $("#allProduct").val();
        getProductInfoById(productId);
    });

    $('#allCustomer').change(function () {
        var customerId = $("#allCustomer").val();

        $('#customer-info').html("");

        if (customerId != "" && customerId !== null)
        {
            if (customerId == "add new customer") {
                $('#addNewCustomerModal').modal('show');
            }
            else {
                showCustomerInfo(customerId);
            }
        }
    });

    $('#addNewCustomerModal').on('hidden.bs.modal', function () {
        // location.reload();
    })

    $('#discountOption').change(function () {
        var discountOption = $("#discountOption").val();

        if (discountOption != "" && discountOption == "request")
        {
            var branchId = $('#outletId').val();
            var branchName = $('#outletName').html();
            var tokenNumberForShow = $('#tokenNumberForShow').html();
            var tokenNumber = $('#tokenNumber').val();

            $.ajax({
                type: "POST",
                url: '<?php echo base_url("sale_product/is_exits_discount_info/") ?>',
                data: {branchId:branchId,tokenNumber:tokenNumber},
                success: function (data) {
                    var isExists = data.isExists;
                    if (isExists) {
                        $('#msgDiv').css('display','all');
                        $('#msgTag').html('');
                        $('#errorMsgTag').html('You Already Send Request For This Order. Please Wait A Minute.');
                        $('#loader').addClass('loader');
                        $('#requestDiscountSave').prop('disabled',true);
                        var intervalId = setInterval(function(){ get_discount_info(isExists.id,intervalId) },5000);
                    }
                    $('#requestBranchId').val(branchId);
                    $('#requestBranchName').val(branchName);
                    $('#requestTokenNumberForShow').val(tokenNumberForShow);
                    $('#requestTokenNumber').val(tokenNumber);

                    $('#discountRequestModal').modal('show');
                },
                error: function () {

                }
            });
        }

    });

    $('#customer_form').submit(function(event){
        event.preventDefault();
        $.ajax({
            url: '<?php echo base_url("client/save_client/") ?>',
            data: $("#customer_form").serialize(),
            type: "POST",
            async: false,
            dataType: 'json',
            success: function (data) {
                if (data.errorMessage) {
                    swal('Oops Sorry!',data.errorMessage,'error');
                }
                else{
                    getCustomerDropdown(data.lastInsertedCustomerId);
                    $("#allCustomer").val(data.lastInsertedCustomerId).trigger('change');
                    showCustomerInfo(data.lastInsertedCustomerId);
                    $('#addNewCustomerModal').modal('hide');
                }
            },
            error: function () {
            }
        });
    });

    function getCustomerDropdown(lastInsertedCustomerId) {
        var saleType = $('#saleType').val();
        var customerType = 'Factory';

        if (saleType == 'outlet_sale') { customerType = 'Outlet'}

        $.ajax({
            type: "POST",
            url: '<?php echo base_url("client/get_all_customer_for_invoice/") ?>',
            data: {lastInsertedCustomerId:lastInsertedCustomerId,customerType:customerType},
            success: function (data) {
                $('#customerDiv').html('');
                $('#customerDiv').html(data.customerDropdownList);
                $('.select2').select2();
            },
            error: function () {
            }
        });
    }

    $('#request_discount_form').submit(function(event){
        event.preventDefault();
        $.ajax({
            url: '<?php echo base_url("Request_for_discount/save/") ?>',
            data: $("#request_discount_form").serialize(),
            type: "POST",
            async: false,
            dataType: 'json',
            success: function (data) {
                if (data.msg != "") {
                    $('#msgDiv').css('display','all');
                    $('#requestDiscountSave').prop('disabled',true);
                    // $('#formContenet').css('display','none');
                    $('#errorMsgTag').html('');
                    $('#msgTag').html(data.msg);
                    $('#loader').addClass('loader');
                }

                if (data.errorMsg != "") {
                    $('#msgDiv').css('display','all');
                    $('#msgTag').html('');
                    $('#errorMsgTag').html(data.errorMsg);
                    $('#loader').addClass('loader');
                }

                var intervalId = setInterval(function(){ get_discount_info(data.discount_id,intervalId) },5000);
            },
            error: function () {
            }
        });
    });

    function get_discount_info(discount_id,intervalId) {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("sale_product/get_discount_info_by_token_key/") ?>',
            data: {discount_id:discount_id},
            success: function (data) {
                var discountInfo = data.discountInfo;

                if (discountInfo.status == 1) {
                    $("#discountOption").val('prcentage').trigger('change');
                    $('#overallDiscount').val(discountInfo.approved_discount);
                    getOverallCalculation();
                    $('#msgTag').html('Congratulation! Your Request Approved.');
                    $('#errorMsgTag').html('');
                    $('.loader').hide();
                    setTimeout(function(){ $('#discountRequestModal').modal('hide'); }, 3000);
                    clearInterval(intervalId);
                }

                if (discountInfo.status == 2) {
                    $('#msgTag').html('');
                    $('#errorMsgTag').html('Sorry! Your Request Not Approved.');
                    $('#requestDiscountSave').prop('disabled',false);
                    $('.loader').hide();
                    clearInterval(intervalId);
                }
            },
            error: function () {

            }
        });
    }

    function showCustomerInfo(customerId) {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("sale_product/get_client_info_by_id/") ?>',
            data: {customerId:customerId},
            success: function (data) {
                $('#customer-info').html(data.output);
            },
            error: function () {

            }
        });
    }

    $('#paymentType').change(function () {
        var paymentType = $("#paymentType").val();

        if (paymentType == 'Split')
        {
            $('#splitDiv').show();
            $('#cashDiv').hide();
            $('#dueDiv').hide();
        }
        else if (paymentType == 'Card') {
            $('#splitDiv').hide();
            $('#cashDiv').hide();
            $('#dueDiv').hide();
        }
        else if (paymentType == 'Due') {
            $('#dueDiv').show();
            $('#cashDiv').hide();
            $('#splitDiv').hide();
        }
        else {
            $('#cashDiv').show();
            $('#splitDiv').hide();
            $('#dueDiv').hide();
        }
    });

    function _getTotalPrice(productId)
    {
        totalPriceCalculation(productId,false);
    }

    function getTotalPrice(productId)
    {
        totalPriceCalculation(productId,true);
    }

    function totalPriceCalculation(productId,update)
    {
        var cartRowId = $('#rowId_'+productId).val();
        var price = parseFloat($('#price_'+productId).val());
        var vatRate = parseFloat($('#vatRate_'+productId).val());
        var qty = parseFloat($('#qty_'+productId).val());
        var minQty = parseFloat($('#qty_'+productId).attr('min'));
        var discount = parseFloat($('#discount_'+productId).val());
        var minDiscount = parseFloat($('#discount_'+productId).attr('min'));
        var itemNote = $('#itemNote_'+productId).val();
        $maxDiscount = 10;

        if ($('#userType').val() == 'admin') {
            $minQty = 1;
            $minDiscount = 0;
            $maxDiscount = 100;
        }

        if (qty <= minQty) {
            $('#qty_'+productId).val(minQty);
            qty = minQty;
        }

        if (discount < minDiscount) {
            $('#discount_'+productId).val(minDiscount);
            discount = minDiscount;
        }
        else {
            if (discount > $maxDiscount) {
                $('#discount_'+productId).val($maxDiscount);
                discount = $maxDiscount;             
            }
        }

        if (update == true)
        {
            updateSessionProductInfo(cartRowId,qty,discount,discountAmount,itemNote);            
        }

        var price = price * qty;
        var discountAmount = (price * discount)/100;

        var totalPrice = price - discountAmount;
        var productTotalVat = (price * vatRate)/100;

        $('#total_'+productId).val(totalPrice.toFixed(2));
        $('#discountAmount_'+productId).val(discountAmount.toFixed(2));
        $('#productTotalVat_'+productId).val(productTotalVat.toFixed(2));

        getOverallCalculation();
    }

    function getOverallCalculation()
    {
        var totalItem = 0;
        var totalQty = 0;
        var subTotal = 0;
        var totalVat = 0;
        var total = 0;
        var dueAmount = 0;

        $('.item').each(function(){
            totalItem = totalItem + parseFloat($(this).val());
        });

        $('.qty').each(function(){
            totalQty = totalQty + parseFloat($(this).val());
        });

        $('.total').each(function(){
            subTotal = subTotal + parseFloat($(this).val());
        });

        $('.productTotalVat').each(function(){
            totalVat = totalVat + parseFloat($(this).val());
        });


        if (overallDiscount < 0) {
            $('#overallDiscount').val(1);
            overallDiscount = 1;
        }
        else {
            if (overallDiscount > 100) {
                $('#overallDiscount').val(100);
                overallDiscount = 100;              
            }
        }

        var discountOption = $('#discountOption').val();

        if (discountOption == '') {
            var discountValue = 0;
        }
        else {
            var overallDiscount = parseFloat($('#overallDiscount').val());
            
            if (overallDiscount < 0) {
                $('#overallDiscount').val(1);
                overallDiscount = 1;
            }

            if (discountOption == 'fixed')
            {
                var discountValue = overallDiscount;
                if ($('#userType').val() != 'admin') {
                    var calculatedDiscount = (subTotal * 10)/100;

                    if (overallDiscount > calculatedDiscount) {
                        discountValue = calculatedDiscount;
                        $('#overallDiscount').val(calculatedDiscount)
                    }
                }
            }
            else
            {
                if ($('#userType').val() != 'admin' && overallDiscount > 10) {
                    overallDiscount = 10;
                    $('#overallDiscount').val(10)
                }
                var discountValue = (subTotal * overallDiscount)/100;
            }
        }

        total = Math.round(subTotal - discountValue + totalVat);

        // Split option Start
        var cardPayment = parseFloat($('#cardPayment').val());
        var cashPayment = parseFloat($('#cashPayment').val());

        if (cashPayment > total || cashPayment < 0)
        {
            $('#cashPayment').val(total);
            $('#cardPayment').val(0);
        }
        else
        {
            var restAmount = total - cashPayment;
            $('#cardPayment').val(restAmount);
        }
        // Split Option End

        // Cash Option Start
        var paidAmount = parseFloat($('#paidAmount').val());
        var changeAmount = parseFloat($('#changeAmount').val());

        if (paidAmount < 0)
        {
            $('#paidAmount').val(total);
            $('#changeAmount').val(0);
        }
        else
        {
            if (paidAmount > total)
            {
                var change = paidAmount - total;
                $('#changeAmount').val(change.toFixed(2));
            }
            else {
                $('#changeAmount').val(0);
            }
        }
        // Cash Option End

        // Due Option Start
        var cashAmount = parseFloat($('#cashAmount').val());
        var dueAmount = parseFloat($('#dueAmount').val());

        if (cashAmount < 0)
        {
            $('#cashAmount').val(total);
            $('#dueAmount').val(0);
        }
        else
        {
            if (cashAmount > total)
            {
                $('#cashAmount').val(total);
                $('#dueAmount').val(0);
            }
            else {
                var due = total- cashAmount;
                $('#dueAmount').val(due.toFixed(2));
            }
        }
        // Due Option End

        $('#totalItem').val(totalItem.toFixed(2));
        $('#totalQty').val(totalQty.toFixed(2));
        $('#subTotal').val(subTotal.toFixed(2));
        $('#totalVat').val(totalVat.toFixed(2));
        $('#totalPayable').val(total.toFixed(2));
        $('#discountValue').val(discountValue.toFixed(2));
    }

    function addProduct()
    {
        var productId = $("#allProduct").val();
        getProductInfoById(productId)       
    }

    function removeAllItem()
    {
        destroySessionProductInfo()
        // location.reload();
        // setTimeout(function(){ location.reload(true); }, 1000);
        // $('.productRow').remove();
        // $('#discountOption').val('');
        // $('#discountOption').select2().trigger('change');
        // $('#overallDiscount').val(0);
        // getOverallCalculation();
    }

    function remove(productId)
    {
        var cartRowId = $("#rowId_"+productId).val();
        removeSessionProductInfo(cartRowId);
        $('#productRow_'+productId).remove();
        getOverallCalculation();
    }

    function clearAllItem()
    {
        destroySessionProductInfo()
    }

    function updateSessionProductInfo(cartRowId,qty,discount,discountAmount,itemNote)
    {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("sale_product/updateSessionProductInfo/") ?>',
            data: {cartRowId:cartRowId,qty:qty,discount:discount,discountAmount:discountAmount,itemNote:itemNote},
            success: function (data) {
                // alert(data.message);
            },
            error: function () {
            }
        })
    }

    function removeSessionProductInfo(cartRowId)
    {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("sale_product/removeSessionProductInfo/") ?>',
            data: {cartRowId:cartRowId},
            success: function (data) {
            },
            error: function () {
            }
        })
    }

    function destroySessionProductInfo()
    {
        var buttonValue = $('#buttonValue').val();
        var tableId = $('#tableId').val();
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("sale_product/destroySessionProductInfo/") ?>',
            data: {tableId:tableId},
            success: function (data) {
                if (buttonValue == 'Submit' || buttonValue == "") {
                    location.reload();
                }
                $('#buttonValue').val("");
            },
            error: function () {
            }
        })
    }
</script>