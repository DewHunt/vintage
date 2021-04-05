<div id="page-wrapper">
    <style type="text/css">
        .custom-row {  padding: 0px 0px 0px 0px !important; margin: 0px 0px 0px 0px !important; }
        .custom-padding { padding: 2px !important; margin: 0px !important; }
        .col-pad { padding: 2px 7px 2px 7px !important; margin: 0px !important; }
        .custom-panel-body { padding: 5px 15px 0px 15px !important; }
        .custom-panel { margin-bottom: 2px; border-radius: 0px; }
        .custom-btn { margin-top: 4px; }

        .tableFixHead { overflow-y: auto; height: 270px; }
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

    <div class="form-block">
        <form id="addForm" name="addForm" action="<?= base_url('recipe/save') ?>" method="post" enctype="multipart/form-data">
            <div class="panel panel-default custom-panel">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4 class="">Recipe</h4></div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                            <a href="<?= base_url('recipe') ?>" class="btn btn-primary"><i class="fa fa-hand-o-left" aria-hidden="true"></i> Go Back</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row custom-row">
                <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 custom-padding">
                    <div class="panel panel-default custom-panel">
                        <div class="panel-heading" style="padding: 1px 5px;">
                            <h5 class="">Item Information</h5>
                        </div>
                        <div class="panel-body custom-panel-body">
                            <div class="row">                                
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label for="category">Category <span class="mendatory">*</span></label>
                                    <div class="form-group">
                                        <select class="form-control select2" id="productType" name="productType">
                                            <option value="">Select Category</option>
                                            <?php foreach ($productTypeList as $productType): ?>
                                                <option value="<?= $productType->id ?>"><?= $productType->product_type_name ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
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
                        </div>
                    </div>

                    <div class="panel panel-default custom-panel">
                        <div class="panel-heading" style="padding: 1px 5px;">
                            <h5 class="">Ingredients Item Information</h5>
                        </div>
                        <div class="panel-body custom-panel-body">
                            <div class="row">                                
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label for="category">Category <span class="mendatory">*</span></label>
                                    <div class="form-group">
                                        <select class="form-control select2" id="rawProductType" name="rawProductType">
                                            <option value="">Select Category</option>
                                            <?php foreach ($productTypeList as $productType): ?>
                                                <option value="<?= $productType->id ?>"><?= $productType->product_type_name ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label for="product">Product <span class="mendatory">*</span></label>
                                    <div class="form-group">
                                        <div id="raw-product-block">
                                            <select class="form-control select2" id="rawProduct" name="rawProduct">
                                                <option value="">Select Product</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div id="product">
                                        <label for="unit">Unit <span class="mendatory">*</span></label>
                                        <div class="form-group">
                                            <input class="form-control" type="text" id="unit" name="unit" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <div id="product">
                                        <label for="quantity">Quantity <span class="mendatory">*</span></label>
                                        <div class="form-group">
                                            <input class="form-control" type="number" step="0.01" min="0.01" id="quantity" name="quantity" value="1">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 text-right">
                                    <label for=""></label>
                                    <div class="form-group">
                                        <span class="btn btn-primary btn-md btn-block custom-btn" onclick="addRecipe()">Add</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 custom-padding">
                    <div class="panel panel-default custom-panel">
                        <div class="panel-heading" style="padding: 1px 5px;">
                            <h5 class="">Recipe Information</h5>
                        </div>
                        <div class="panel-body custom-panel-body">
                            <div class="table-responsive tableFixHead">
                                <table id="recipe_table">
                                    <thead>
                                        <tr>
                                            <th width="35px">SL</th>
                                            <th>Ingredients Item Name</th>
                                            <th width="110px">Unit Name</th>
                                            <th width="60px">Qty</th>
                                            <th width="10px">
                                                <i class="fa fa-trash" style="color: red;" data-toggle="tooltip" title="Remove All The Item" onclick="removeAllRecipeItem()"></i>
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?= $this->load->view('recipe/recipe_table_body','',true) ?>
                                    </tbody>

                                    <tfoot>
                                        <?= $this->load->view('recipe/recipe_table_footer','',true) ?>
                                    </tfoot>
                                </table>
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
</div>
<!-- /#page-wrapper -->

<script type="text/javascript">
    $(document).ready(function (){
        $('.form-block form').submit(function (event) {
            event.preventDefault();
            var productId = $('#product').val();

            if (productId == "") {
                swal("Error!", "Please Select A Product From Raw Item Information Section!", "error");
                return false;
            }

            $.post($(this).attr('action'), $(this).serialize(), function (data) {
                swal("Great!", "Recipe Saved Successfully!", "success");
                $('#product').val("").trigger('change');
            });
        });

        $(document.body).on('change', '#productType', function (){
            var productTypeId = $( "#productType" ).val();
            var section = 'item';

            $.ajax({
                type: "POST",
                url: '<?php echo base_url("recipe/get_product_info_by_product_type/") ?>',
                data: {productTypeId:productTypeId,section:section},
                success: function (data) {
                    $('#product-block').html(data.output);
                    $('.select2').select2();
                },
                error: function () {

                }
            })
        });

        $(document.body).on('change', '#rawProductType', function (){
            var productId = $( "#product" ).val();
            var productTypeId = $( "#rawProductType" ).val();
            var section = 'raw';

            if (productId == "") {
                swal("Error!", "Please Select A Product From Item Information Section!", "error");
                $("#rawProductType").val("");
                return false;
            }

            $.ajax({
                type: "POST",
                url: '<?php echo base_url("recipe/get_product_info_by_product_type/") ?>',
                data: {productTypeId:productTypeId,section:section},
                success: function (data) {
                    $('#raw-product-block').html(data.output);
                    $('.select2').select2();
                },
                error: function () {

                }
            })
        });

        $(document.body).on('change', '#product', function (){
            var productId = $('#product').val();

            $.ajax({
                type: "POST",
                url: '<?php echo base_url("recipe/get_recipe_info_by_parent_product_id/") ?>',
                data: {productId:productId},
                success: function (data) {
                    $('#recipe_table tbody').html(data.table_body);
                    $('#recipe_table tfoot').html(data.table_footer);
                },
                error: function () {

                }
            })
        });

        $(document.body).on('change', "#rawProduct", function () {
            var productId = $( "#rawProduct" ).val();

            $.ajax({
                type: "POST",
                url: '<?php echo base_url("recipe/get_product_info/") ?>',
                data: {productId:productId},
                success: function (data) {
                    $('#unit').val(data.unit);
                },
                error: function () {

                }
            })
        });
    });

    function addRecipe() {
        var productId = $( "#product" ).val();
        var rawProductTypeId = $( "#rawProductType" ).val();
        var rawProductId = $( "#rawProduct" ).val();
        var unit = $('#unit').val();
        var qty = $('#quantity').val();

        if (productId == "") {
            swal("Error!", "Please Select A Product From Raw Item Information Section!", "error");
            return false;
        }
        else {
            if (productId == rawProductId) {
                swal("Error!", "You Can't Select Same Product. Please Select Another Product!", "error");
                return false;
            }
        }

        if (qty == "") {
            swal("Error!","Please Enter Quantity!", "error");
            return false;
        }
        else {
            if (parseFloat(qty) == 0) {
                swal("Error!","Quantity Can Not Be Zero!", "error");
                return false;   
            }         
        }

        $.ajax({
            type: "POST",
            url: '<?php echo base_url("recipe/add_recipe/") ?>',
            data: {rawProductTypeId:rawProductTypeId,rawProductId:rawProductId,unit:unit,qty:qty},
            success: function (data) {
                $('#recipe_table tbody').html(data.table_body);
                $('#recipe_table tfoot').html(data.table_footer);
            },
            error: function () {

            }
        });
    }

    function remove(productId)
    {
        var cartRowId = $("#rowId_"+productId).val();
        destroySessionItemInfo(cartRowId);
    }

    function removeAllRecipeItem() {
        destroySessionItemInfo();
    }

    function destroySessionItemInfo(cartRowId = "")
    {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("recipe/destroy_session_item_info/") ?>',
            data: {cartRowId:cartRowId},
            success: function (data) {
                $('#recipe_table tbody').html(data.table_body);
                $('#recipe_table tfoot').html(data.table_footer);
            },
            error: function () {
            }
        })
    }
</script>