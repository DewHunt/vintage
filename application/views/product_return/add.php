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

        #page-wrapper { padding-top: 10px; }
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

    <form id="addForm" name="addForm" action="<?= base_url('product_return/save') ?>" method="post" enctype="multipart/form-data">
        <div class="panel panel-default custom-panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4 class="">Add Product Return</h4></div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                        <a href="<?= base_url('product_transfer') ?>" class="btn btn-primary"><i class="fa fa-hand-o-left" aria-hidden="true"></i> Go Back</a>
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
                                <label for="category">Category <span class="mendatory">*</span></label>
                                <div class="form-group">
                                    <select class="form-control select2" id="productType" name="productType">
                                        <option value="">Select Category</option>
                                        <?php foreach ($allProductType as $productType): ?>
                                            <option value="<?= $productType->id ?>"><?= $productType->product_type_name ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">                                
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label for="product">Product <span class="mendatory">*</span></label>
                                <div class="form-group">
                                    <div id="product-block">
                                        <select class="form-control select2" id="product" name="product">
                                            <option value="">Select Product</option>
                                        </select>
                                    </div>
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
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                                <div class="form-group">
                                    <span class="btn btn-primary btn-md custom-btn" onclick="addReturnProduct()">Add</span>
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
                            <table id="product_return_table">
                                <thead>
                                    <tr>
                                        <th width="35px">SL</th>
                                        <th>Product Name</th>
                                        <th width="60px">Qty</th>
                                        <th width="10px">
                                            <i class="fa fa-trash" style="color: red;" data-toggle="tooltip" title="Remove All The Item" onclick="removeAllTransferProduct()"></i>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody><?= $this->load->view('product_transfer/product_transfer_table_body','',true) ?></tbody>

                                <tfoot><?= $this->load->view('product_transfer/product_transfer_table_footer','',true) ?></tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default custom-panel">
                    <div class="panel-body custom-panel-body">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <label for="outlet">Outlet <span class="mendatory">*</span></label>
                                        <div class="form-group">
                                            <select class="form-control select2" id="branch" name="branch">
                                                <option value="">Select Outlet</option>
                                                <?php foreach ($allBranch as $branch): ?>
                                                    <option value="<?= $branch->id ?>"><?= $branch->branch_name ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <label for="date">Date <span class="mendatory">*</span></label>
                                        <div class="form-group">
                                            <input type="date" class="form-control" id="date" name="date" value="" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <label for="batch-no">Challan No. <span class="mendatory">*</span></label>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="challanNumber" name="challanNumber" value="" placeholder="Challan No.">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for="remarks">Remarks</label>
                                <div class="form-group">
                                    <textarea class="form-control" rows="5" id="remarks" name="remarks" placeholder="Remarks"></textarea>
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
    $(document).ready(function (){
        $(document.body).on('change', '#productType', function (){
            var productTypeId = $( "#productType" ).val();

            $.ajax({
                type: "POST",
                url: '<?php echo base_url("product_return/get_product_info_by_product_type/") ?>',
                data: {productTypeId:productTypeId},
                success: function (data) {
                    $('#product-block').html(data.output);
                    $('.select2').select2();
                },
                error: function () {

                }
            })
        });
    });

    function addReturnProduct() {
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

        $.ajax({
            type: "POST",
            url: '<?php echo base_url("product_return/add_return_product/") ?>',
            data: {productId:productId,qty:qty},
            success: function (data) {
                $('#product_return_table tbody').html(data.table_body);
                $('#product_return_table tfoot').html(data.table_footer);
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

    function removeAllTransferProduct() {
        destroySessionProductInfo();
    }

    function destroySessionProductInfo(cartRowId = "")
    {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("product_transfer/destroy_session_product_info/") ?>',
            data: {cartRowId:cartRowId},
            success: function (data) {
                location.reload();
            },
            error: function () {
            }
        })
    }
</script>