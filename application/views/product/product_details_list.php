<div id="page-wrapper">
    <?php
        $user_info = $this->session->userdata('user_session');
        $user_type = $user_info['user_type'];
        $settings_access = $user_info['settings_access'];
        $product_access = $user_info['product_access'];
        $client_access = $user_info['client_access'];
    ?>

    <?php if (!empty($this->session->flashdata('message'))) { ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Opps!</strong> <?= $this->session->flashdata('message') ?>
        </div>
    <?php } ?>

    <?php if (!empty($this->session->flashdata('error'))) { ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Opps!</strong> <?= $this->session->flashdata('error') ?>
        </div>
    <?php } ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-3"><h4 class="">Product Details</h4></div>

                <div class="col-md-1" style="border: 0px solid black; text-align: right; padding-right: 3px;"><h4>Search : </h4></div>

                <div class="col-md-4" style="border: 0px solid black; padding-left: 2px;">
                    <select class="form-control select2" id="productTypeId" name="product_type_id">
                        <option value="">Select Category</option>
                        <?php foreach ($product_type_list as $product_type): ?>
                            <option value="<?= $product_type->id ?>"><?= $product_type->product_type_name ?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="col-md-4 text-right">
                    <a href="<?= base_url('product/create_new_product') ?>" class="btn btn-primary">
                        <i class=" fa fa-plus" aria-hidden="true"></i> Add New Product
                    </a>
                    <button type="button" class="btn btn-primary print-button"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
                </div>
            </div>                
        </div>

        <!-- /.panel-heading -->
        <div class="panel-body">
            <div class="table-responsive table-bordered">
                <div class="col-xs-12">
                </div>
                <table class="table table-striped productTable" id="details-table">
                    <thead>
                        <tr>
                            <th width="20px">SL</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th width="70px">Unit</th>
                            <th width="90px">Hot Kitchen</th>
                            <th width="90px">Purc. Price</th>
                            <th width="85px">Fixed Price</th>
                            <th class="action-fixed-width">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sl = 1; ?>

                        <?php foreach ($product_list as $product): ?>                                
                            <tr>
                                <td><?= $sl++ ?></td>
                                <td><?= $product->product_code ?></td>
                                <td>
                                    <?= $product->product_name ?>
                                    <?php if ($product->image): ?>
                                        <img width="40px" height="40px" src="<?= $product->image ?>">
                                    <?php endif ?>
                                </td>
                                <td><?= $product->productTypeName ?></td>
                                <td><?= $product->unitName ?></td>
                                <td><?= $product->hot_kitchen_status == 1 ? 'Yes' : 'No' ?></td>
                                <td align="right"><?= $product->purchase_price ?></td>
                                <td align="right"><?= $product->fixed_price ?></td>
                                <td class="action-fixed-width">
                                    <a href="<?= base_url("product/update_product/$product->id") ?>" class="btn btn-primary">
                                        <i class=" fa fa-pencil-square-o" aria-hidden="true"></i>
                                    </a>
                                    <a href="<?= base_url("product/delete/$product->id") ?>" class="btn btn-danger" onclick="return delete_confirm();">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                   </a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.panel-body -->
    </div>
</div>
<!-- /#page-wrapper -->


<!--Display None-->
<!--For Print-->
<div id="print-information" style="width: 100%; display: none;">
    <style>
        table, td, th { border: 1px solid #ddd; }
        table { border-collapse: collapse; width: 100%; }
        th, td { padding: 5px; }
        label { font-weight: bold; }
        p { margin: 0px; }
        .print-content { margin: 30px; }
        * { box-sizing: border-box; }
        .column { float: left; padding: 10px; }
        .left { width: 60%; }
        .right { width: 40%; }
        .full { width: 100% }
        /* Clear floats after the columns */
        .row:after { content: ""; display: table; clear: both; }
        .text-center { text-align: center }
        .text-right { text-align: right }
    </style>

    <div class="print-content">
        <div class="row">
            <div class="column full text-center">
                <font size="5px"><?= strtoupper($company_information->company_name_1) ?></font>
                <p><?= $company_information->company_address_1 ?></p>
            </div>
        </div>

        <div class="row">
            <div class="column full">
                <table>
                    <caption class="text-center"><strong>Product Lists</strong></caption>
                    <thead>
                        <tr>
                            <th width="20px" rowspan="2">SL</th>
                            <th width="100px" rowspan="2">Code</th>
                            <th rowspan="2">Name</th>
                            <th rowspan="2">Category</th>
                            <th rowspan="2" width="70px">Availability</th>
                            <th rowspan="2" width="90px">Hot Kitchen</th>
                            <th colspan="4" class="text-center">Price</th>
                        </tr>
                        <tr>
                            <th width="60px" class="text-center">Purchase</th>
                            <th width="60px" class="text-center">MIN</th>
                            <th width="60px" class="text-center">MAX</th>
                            <th width="60px" class="text-center">Fixed</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sl = 1; ?>

                        <?php foreach ($product_list as $product): ?>
                            
                            <tr>
                                <td><?= $sl++ ?></td>
                                <td><?= $product->product_code ?></td>
                                <td><?= $product->product_name ?></td>
                                <td><?= $product->productTypeName ?></td>
                                <td><?= $product->availability ?></td>
                                <td><?= $product->hot_kitchen_status == 1 ? 'Yes' : 'No' ?></td>
                                <td align="right"><?= $product->purchase_price ?></td>
                                <td align="right"><?= $product->minimum_price ?></td>
                                <td align="right"><?= $product->maximum_price ?></td>
                                <td align="right"><?= $product->fixed_price ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<!--Jquery Data Table-->
<script type="text/javascript">
    $(document).ready(function () {
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

        $('#details-table').dataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [[25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]],
            "scrollY": "400px",
            "scrollX": true,
            "ordering": false,
        });
    });
</script>

<script>
    $('#productTypeId').change(function () {
        var productTypeId = $("#productTypeId").val();
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("product/searchProduct/") ?>',
            data: {productTypeId:productTypeId},
            success: function (data) {
                $('.productTable tbody').html("");

                $('.productTable tbody').html(data);
            },
            error: function () {

            }
        });
    });
    
    function delete_confirm() {
        var delete_confirmation_message = confirm("Are you sure to delete permanently?");
        if (delete_confirmation_message != true) {
            return false;
        }
    }
</script>
