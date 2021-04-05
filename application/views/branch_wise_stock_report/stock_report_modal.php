
<div class="row">
    <div class="col-lg-12 text-center">
        <font size="5px"><?= strtoupper($companyInfo->company_name_1) ?></font>
        <p><?= $companyInfo->company_address_1 ?></p>       
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <table style="width: 100%; border: 0px;">
            <thead>
                <tr>
                    <th>Date : <?= $transferReportInfo->product_receive_date ?></th>
                    <th class="text-right">Challan No. : <?= $transferReportInfo->challan_number ?></th>
                </tr>

                <tr>
                    <th colspan="2">Branch Name : <?= $transferReportInfo->branchName ?></th>
                </tr>
            </thead>
        </table>    
    </div>
</div>

<div style="padding: 10px;"></div>

<div class="row">
    <div class="col-lg-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th width="35px">SL</th>
                    <th>Product Name</th>
                    <th width="60px" class="text-right">Qty</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($transferReportProductList)): ?>
                    <?php $sl = 1; ?>
                    <?php foreach ($transferReportProductList as $transferProduct): ?>
                        <tr>
                            <td><?= $sl++ ?></td>
                            <td><?= $transferProduct->productName ?></td>
                            <td align="right"><?= $transferProduct->quantity ?></td>
                        </tr>
                    <?php endforeach ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5"><h5>Product Not Found</h5></td>
                    </tr>
                <?php endif ?>
            </tbody>

            <?php if (!empty($transferReportProductList)): ?>
                <tfoot>
                    <tr>
                        <th colspan="2" class="text-right">Total</th>
                        <th class="text-right"><?= $transferReportInfo->total_qty ?></th>
                    </tr>
                </tfoot>
            <?php endif ?>
        </table>
    </div>
</div>


<!--DISPLAY NONE-->
<!--USE FOR PRINT-->


<div id="print-information" style="display: none;">
    <style>
        table, td, th { border: 1px solid #ddd; }
        table { border-collapse: collapse; width: 100%; }
        th, td { padding: 5px; }
        label { font-weight: bold; }
        p { margin: 0px; }
        .print-content { margin: 30px; }
        * { box-sizing: border-box; }
        .column { float: left; padding: 10px; }
        .left { width: 30%; }
        .right { width: 70%; }
        .full { width: 100% }
        /* Clear floats after the columns */
        .row:after { content: ""; display: table; clear: both; }
        .text-center { text-align: center }
        .text-right { text-align: right }
    </style>

    <div class="print-content">
        <div class="row">
            <div class="column full text-center">
                <h4><?= strtoupper($companyInfo->company_name_1) ?></h4>
            </div>
        </div>

        <div class="row">
            <div class="column left">
                <label>Challan :</label> <?= $transferReportInfo->challan_number ?>
            </div>
            <div class="column right text-right">
                <label>Date Of Issue :</label> <?= $transferReportInfo->product_receive_date ?>
            </div>
        </div>

        <div class="row">
            <div class="column full">
                <label>Branch :</label> <?= $transferReportInfo->branchName ?>
            </div>
        </div>

        <div class="row">
            <div class="column full">
                <table>
                    <thead>
                        <tr>
                            <th width="35px">SL</th>
                            <th>Product Name</th>
                            <th width="60px" class="text-right">Qty</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($transferReportProductList)): ?>
                            <?php $sl = 1; ?>
                            <?php foreach ($transferReportProductList as $transferProduct): ?>
                                <tr>
                                    <td><?= $sl++ ?></td>
                                    <td><?= $transferProduct->productName ?></td>
                                    <td align="right"><?= $transferProduct->quantity ?></td>
                                </tr>
                            <?php endforeach ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5"><h5>Product Not Found</h5></td>
                            </tr>
                        <?php endif ?>
                    </tbody>

                    <?php if (!empty($transferReportProductList)): ?>
                        <tfoot>
                            <tr>
                                <th colspan="2" class="text-right">Total</th>
                                <th class="text-right"><?= $transferReportInfo->total_qty ?></th>
                            </tr>
                        </tfoot>
                    <?php endif ?>
                </table>
            </div>
        </div>
    </div>
</div>

