<div id="page-wrapper">
    <style type="text/css">
        .custom-row {  padding: 0px 0px 0px 0px !important; margin: 0px 0px 0px 0px !important; }
        .custom-padding { padding: 2px !important; margin: 0px !important; }
        .col-pad { padding: 2px 7px 2px 7px !important; margin: 0px !important; }
        .custom-panel-body { padding: 5px 15px 0px 15px !important; }
        .custom-panel { margin-bottom: 2px; border-radius: 0px; }
        .custom-btn { margin-top: 4px; }

        .tableFixHead { overflow-y: auto; height: 275px; }
        .tableFixHead thead th { position: sticky; top: 0; }
        .tableFixHead tfoot th { position: sticky; bottom: 0; }
        table { border-collapse: collapse; width: 100%; }
        th, td { padding: 8px 16px; }
        th { background:#eee; }

        /* Borders (if you need them) */
        .tableFixHead,.tableFixHead td { box-shadow: inset 1px 1px #eee; }
        .tableFixHead th { box-shadow: inset 1px 1px #bbb, 1px 1px #bbb; }

        #page-wrapper { padding-top: 5px; }
    </style>

    <?php if (!empty($this->session->flashdata('successMessage'))) { ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Success!</strong> <?= $this->session->flashdata('successMessage') ?>
        </div>
    <?php } ?>

    <?php if (!empty($this->session->flashdata('errorMessage'))) { ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Opps!</strong> <?= $this->session->flashdata('errorMessage') ?>
        </div>
    <?php } ?>

    <form id="addForm" name="addForm" action="<?= base_url('product_purchase/save') ?>" method="post" enctype="multipart/form-data">
        <div class="panel panel-default custom-panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4 class="">Add Product Purchase</h4></div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                        <a href="<?= base_url('product_purchase') ?>" class="btn btn-primary"><i class="fa fa-hand-o-left" aria-hidden="true"></i> Go Back</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row custom-row">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 custom-padding">
                <div class="panel panel-default custom-panel">
                    <div class="panel-body custom-panel-body">
                        <div class="row">                                
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label for="product">Product <span class="mendatory">*</span></label>
                                <div class="form-group">
                                    <select class="form-control select2" id="product" name="product">
                                        <option value="">Select Product</option>
                                        <?php foreach ($allProduct as $product): ?>
                                            <option value="<?= $product->id ?>"><?= $product->product_name ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">                            
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label for="quantity">Quantity <span class="mendatory">*</span></label>
                                <div class="form-group">
                                    <input type="number" min="1" class="form-control" id="quantity" name="quantity" value="1" placeholder="Quantity">
                                </div>
                            </div>
                        </div>

                        <div class="row">                             
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label for="amount">Amount <span class="mendatory">*</span></label>
                                <div class="form-group">
                                    <input type="number" min="0" class="form-control" id="amount" name="amount" value="1" placeholder="Amount">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                                <div class="form-group">
                                    <span class="btn btn-primary btn-md custom-btn" onclick="addPurchasedProduct()">Add</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 custom-padding">
                <div class="panel panel-default custom-panel">
                    <div class="panel-body custom-panel-body">
                        <div class="table-responsive tableFixHead">
                            <table id="purchased_product_table">
                                <thead>
                                    <tr>
                                        <th width="35px">SL</th>
                                        <th>Product Name</th>
                                        <th width="80px">Rate</th>
                                        <th width="60px">Qty</th>
                                        <th width="80px">Amount</th>
                                        <th width="10px">
                                            <i class="fa fa-trash" style="color: red;" data-toggle="tooltip" title="Remove All The Item" onclick="removeAllPurchasedProduct()"></i>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?= $this->load->view('product_purchase/purchased_product_table_body','',true) ?>
                                </tbody>

                                <tfoot>
                                    <?= $this->load->view('product_purchase/purchased_product_table_footer','',true) ?>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row custom-row">
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 custom-padding">
                        <div class="panel panel-default custom-panel">
                            <div class="panel-body custom-panel-body">
                                <div class="row">                                
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <label for="supplier">Supplier <span class="mendatory">*</span></label>
                                        <div class="form-group">
                                            <select class="form-control select2" id="supplier" name="supplier" required>
                                                <option value="">Select Product</option>
                                                <?php foreach ($supplierLists as $supplier): ?>
                                                    <option value="<?= $supplier->id ?>"><?= $supplier->name ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div style="display: none;" id="showAmount">
                                            <label id="labelName"></label>
                                            <div class="form-group">
                                                <input type="hidden" class="form-control" id="amountName" name="amountName" value="" readonly>
                                                <input type="number" class="form-control" id="displayAmount" name="displayAmount" value="" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 custom-padding">
                        <div class="panel panel-default custom-panel">
                            <div class="panel-body custom-panel-body">
                                <div class="error" style="color: red">
                                    <?php echo validation_errors(); ?>
                                </div>

                                <div class="row">                                
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        <label for="date">Date <span class="mendatory">*</span></label>
                                        <div class="form-group">
                                            <input type="date" class="form-control" id="date" name="date" value="" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        <label for="date">Payment Mode <span class="mendatory">*</span></label>
                                        <div class="form-group">
                                            <?php $paymentModeArray = array('Cash' => 'Cash', 'Card' => 'Card', 'Cheque' => 'Cheque', 'Mobile Banking' => 'Mobile Banking'); ?>
                                            <select class="form-control select2" id="paymentMode" name="paymentMode" required>
                                                <option value="">Select Payment Mode</option>
                                                <?php foreach ($paymentModeArray as $key => $value): ?>
                                                    <option value="<?= $key ?>"><?= $value ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        <label for="paid-amount">Paid Amount <span class="mendatory">*</span></label>
                                        <div class="form-group">
                                            <input type="number" min="0" class="form-control" id="paidAmount" name="paidAmount" value="0" required>
                                        </div>
                                    </div>
                                </div>
                                    
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        <label for="bill-no">Bill No.</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="moneyReceiptNumber" name="moneyReceiptNumber" value="" placeholder="Bill No.">
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        <label for="bill-image">Bill Image</label>
                                        <div class="form-group">
                                            <input type="file" class="form-control" id="moneyReceiptImage" name="moneyReceiptImage" value="0">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        <label for="remarks">Remarks</label>
                                        <div class="form-group">
                                            <textarea class="form-control" rows="1" id="remarks" name="remarks" placeholder="Remarks"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="panel panel-default custom-panel">
            <div class="panel-footer">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                        <button type="submit" class="btn btn-primary btn-md">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- /#page-wrapper -->

<script type="text/javascript">
    function addPurchasedProduct() {
        var productId = $('#product').val();
        var qty = $('#quantity').val();
        var amount = $('#amount').val();

        if (productId == "") {
            swal("Error!", "Please Select A Product!", "error");
            return false;
        }

        if (qty == "") {
            swal("Error!","Please Enter Quantity!", "error");
            return false;
        }
        else {
            if (parseInt(qty) == 0) {
                swal("Error!","Quantity Can Not Be Zero!", "error");
                return false;   
            }         
        }

        if (amount == "") {
            swal("Error!", "Please Enter Amount", "error");
            return false;
        }
        else {
            if (parseInt(amount) == 0) {
                swal("Error!","Amount Can Not Be Zero!", "error");
                return false;   
            }         
        }

        $.ajax({
            type: "POST",
            url: '<?php echo base_url("product_purchase/add_purchased_product/") ?>',
            data: {productId:productId,qty:qty,amount:amount},
            success: function (data) {
                $('#purchased_product_table tbody').html(data.table_body);
                $('#purchased_product_table tfoot').html(data.table_footer);
            },
            error: function () {

            }
        });
    }

    function remove(productId)
    {
        var cartRowId = $("#rowId_"+productId).val();
        destroySessionProductInfo(cartRowId);
    }

    function removeAllPurchasedProduct() {
        destroySessionProductInfo();
    }

    function destroySessionProductInfo(cartRowId = "")
    {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("product_purchase/destroy_session_product_info/") ?>',
            data: {cartRowId:cartRowId},
            success: function (data) {
                location.reload();
            },
            error: function () {
            }
        })
    }

    $('#supplier').change(function () {
        var supplierId = $( "#supplier" ).val();
        if (supplierId == "") {
            $('#showAmount').css('display','none');
            $('#labelName').html('');
            $('#amountName').val('');
            $('#displayAmount').val('');
            // swal("Error!", "Please Select A Supplier!", "error");
        } else {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url("supplier/get_supplier_info/") ?>',
                data: {supplierId:supplierId},
                success: function (data) {
                    $('#showAmount').css('display','contents');
                    $('#labelName').html(data.amountName);
                    $('#amountName').val(data.amountName);
                    $('#displayAmount').val(data.amount);
                },
                error: function () {

                }
            })
        }
    });

    // $('#addForm').submit(function(event){
    //     event.preventDefault();
    //     var paidAmount = $('#paidAmount').val();

    //     if (paidAmount == "") {
    //         swal("Error!","Please Enter Paid Amount!", "error");
    //         return false;
    //     }
    //     else {
    //         if (parseInt(paidAmount) == 0) {
    //             swal("Error!","Paid Amount Can Not Be Zero!", "error");
    //             return false;   
    //         }         
    //     }

    //     return true;
    // });
</script>