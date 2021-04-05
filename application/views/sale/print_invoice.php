<div id="page-wrapper">
    <!--<div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">Sale Product</h2>
        </div>
    </div>-->

    <div style="padding-top: 10px"></div>

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

    <div class="row">
        <div class="col-lg-12">
    		<div class="panel panel-default custom-panel-margin">
                <div class="panel-heading">
                    <button id="print" class="btn btn-info btn-lg" type="button"> <span><i class="fa fa-print">
                    	</i> Print</span>
                    </button>

                    <a class="btn btn-success btn-lg" href="<?= base_url('Sale_product') ?>">Go Back</a>
                </div>

    			<div class="panel-body printableArea">
    				<style type="text/css">
			            hr.dashed {
			                border-top: 1px dashed black;
			                margin: 10px 0px;
			                width: 50%;
			            }

			            table {
			            	background-color: transparent;
			            }

			            caption {
			            	padding-top: 8px;
			            	padding-bottom: 8px;
			            	color: #777;
			            	text-align: left;
			            }

			            th {
			            	text-align: left;
			            }

						.tab {
							width: 50%;
							max-width: 50%;
							margin-bottom: 20px;
						}

						.tab > thead > tr > th,
						.tab > tbody > tr > th,
						.tab > tfoot > tr > th,
						.tab > thead > tr > td,
						.tab > tbody > tr > td,
						.tab > tfoot > tr > td {
							padding: 8px;
							line-height: 1.42857143;
							vertical-align: top;
							border-top: 1px solid #ddd;
						}

						.tab > thead > tr > th {
							vertical-align: bottom;
							border-bottom: 2px solid #ddd;
						}
						.tab > caption + thead > tr:first-child > th,
						.tab > colgroup + thead > tr:first-child > th,
						.tab > thead:first-child > tr:first-child > th,
						.tab > caption + thead > tr:first-child > td,
						.tab > colgroup + thead > tr:first-child > td,
						.tab > thead:first-child > tr:first-child > td {
							border-top: 0;
						}
						.tab > tbody + tbody {
							border-top: 2px solid #ddd;
						}
						.tab .tab {
							background-color: #fff;
						}
						.tab-condensed > thead > tr > th,
						.tab-condensed > tbody > tr > th,
						.tab-condensed > tfoot > tr > th,
						.tab-condensed > thead > tr > td,
						.tab-condensed > tbody > tr > td,
						.tab-condensed > tfoot > tr > td {
							padding: 5px;
						}
						.tab-bordered {
							border: 1px solid #ddd;
						}
						.tab-bordered > thead > tr > th,
						.tab-bordered > tbody > tr > th,
						.tab-bordered > tfoot > tr > th,
						.tab-bordered > thead > tr > td,
						.tab-bordered > tbody > tr > td,
						.tab-bordered > tfoot > tr > td {
							border: 1px solid #ddd;
						}
						.tab-bordered > thead > tr > th,
						.tab-bordered > thead > tr > td {
							border-bottom-width: 2px;
						}
						.tab-striped > tbody > tr:nth-of-type(odd) {
							background-color: #f9f9f9;
						}
						.tab-hover > tbody > tr:hover {
							background-color: #f5f5f5;
						}

						table col[class*="col-"] {
							position: static;
							display: table-column;
							float: none;
						}
						table td[class*="col-"],
						table th[class*="col-"] {
							position: static;
							display: table-cell;
							float: none;
						}

						.tab > thead > tr > td.active,
						.tab > tbody > tr > td.active,
						.tab > tfoot > tr > td.active,
						.tab > thead > tr > th.active,
						.tab > tbody > tr > th.active,
						.tab > tfoot > tr > th.active,
						.tab > thead > tr.active > td,
						.tab > tbody > tr.active > td,
						.tab > tfoot > tr.active > td,
						.tab > thead > tr.active > th,
						.tab > tbody > tr.active > th,
						.tab > tfoot > tr.active > th {
							background-color: #f5f5f5;
						}
						.tab-hover > tbody > tr > td.active:hover,
						.tab-hover > tbody > tr > th.active:hover,
						.tab-hover > tbody > tr.active:hover > td,
						.tab-hover > tbody > tr:hover > .active,
						.tab-hover > tbody > tr.active:hover > th {
							background-color: #e8e8e8;
						}
						.tab > thead > tr > td.success,
						.tab > tbody > tr > td.success,
						.tab > tfoot > tr > td.success,
						.tab > thead > tr > th.success,
						.tab > tbody > tr > th.success,
						.tab > tfoot > tr > th.success,
						.tab > thead > tr.success > td,
						.tab > tbody > tr.success > td,
						.tab > tfoot > tr.success > td,
						.tab > thead > tr.success > th,
						.tab > tbody > tr.success > th,
						.tab > tfoot > tr.success > th {
							background-color: #dff0d8;
						}
						.tab-hover > tbody > tr > td.success:hover,
						.tab-hover > tbody > tr > th.success:hover,
						.tab-hover > tbody > tr.success:hover > td,
						.tab-hover > tbody > tr:hover > .success,
						.tab-hover > tbody > tr.success:hover > th {
							background-color: #d0e9c6;
						}
						.tab > thead > tr > td.info,
						.tab > tbody > tr > td.info,
						.tab > tfoot > tr > td.info,
						.tab > thead > tr > th.info,
						.tab > tbody > tr > th.info,
						.tab > tfoot > tr > th.info,
						.tab > thead > tr.info > td,
						.tab > tbody > tr.info > td,
						.tab > tfoot > tr.info > td,
						.tab > thead > tr.info > th,
						.tab > tbody > tr.info > th,
						.tab > tfoot > tr.info > th {
							background-color: #d9edf7;
						}
						.tab-hover > tbody > tr > td.info:hover,
						.tab-hover > tbody > tr > th.info:hover,
						.tab-hover > tbody > tr.info:hover > td,
						.tab-hover > tbody > tr:hover > .info,
						.tab-hover > tbody > tr.info:hover > th {
							background-color: #c4e3f3;
						}
						.tab > thead > tr > td.warning,
						.tab > tbody > tr > td.warning,
						.tab > tfoot > tr > td.warning,
						.tab > thead > tr > th.warning,
						.tab > tbody > tr > th.warning,
						.tab > tfoot > tr > th.warning,
						.tab > thead > tr.warning > td,
						.tab > tbody > tr.warning > td,
						.tab > tfoot > tr.warning > td,
						.tab > thead > tr.warning > th,
						.tab > tbody > tr.warning > th,
						.tab > tfoot > tr.warning > th {
							background-color: #fcf8e3;
						}
						.tab-hover > tbody > tr > td.warning:hover,
						.tab-hover > tbody > tr > th.warning:hover,
						.tab-hover > tbody > tr.warning:hover > td,
						.tab-hover > tbody > tr:hover > .warning,
						.tab-hover > tbody > tr.warning:hover > th {
							background-color: #faf2cc;
						}
						.tab > thead > tr > td.danger,
						.tab > tbody > tr > td.danger,
						.tab > tfoot > tr > td.danger,
						.tab > thead > tr > th.danger,
						.tab > tbody > tr > th.danger,
						.tab > tfoot > tr > th.danger,
						.tab > thead > tr.danger > td,
						.tab > tbody > tr.danger > td,
						.tab > tfoot > tr.danger > td,
						.tab > thead > tr.danger > th,
						.tab > tbody > tr.danger > th,
						.tab > tfoot > tr.danger > th {
							background-color: #f2dede;
						}
						.tab-hover > tbody > tr > td.danger:hover,
						.tab-hover > tbody > tr > th.danger:hover,
						.tab-hover > tbody > tr.danger:hover > td,
						.tab-hover > tbody > tr:hover > .danger,
						.tab-hover > tbody > tr.danger:hover > th {
							background-color: #ebcccc;
						}
						.tab-responsive {
							min-height: .01%;
							overflow-x: auto;
						}

			            .tab>tfoot>tr>td {
			                border-bottom: hidden;
			                padding-top: 0px;
			                padding-bottom: 0px;
			            }

			            .tab>tfoot>tr>th {
			                padding-top: 0px;
			                padding-bottom: 0px;
			            }

			            .tab>tbody>tr>td, .tab>tbody>tr>th, .tab>thead>tr>th {
			                padding-top: 2px;
			                padding-bottom: 2px;
			            }
    				</style>

    				<table width="50%">
    					<tbody>
    						<tr>
    							<td class="text-center">
    								<h2>Company Name</h2>
    								<b>House - 60. Road - 10, Lane - 06, Block - A,<br>Section - 02, Mirpur, Dhaka 1216</b>
    							</td>
    						</tr>
    					</tbody>
    				</table>

	                <hr class="dashed">

	                <table width="50%">
	                	<tbody>
	                		<tr>
	                			<td width="25%">Order Time</td>
	                			<td width="5%">:</td>
	                			<td><?= $invoiceDetails->order_date ?></td>
	                		</tr>
	                		<tr>
	                			<td width="25%">Print Time</td>
	                			<td width="5%">:</td>
	                			<td><?= date("Y-m-d H:i:s") ?></td>
	                		</tr>
	                	</tbody>
	                </table>

	                <hr class="dashed">

                    <table class="tab tab-bordered">
                    	<caption class="text-center"><b>Order Information</b></caption>
                    	<thead>
                    		<tr>
                    			<th>Item Name</th>
                    			<th width="10%" class="text-right">Rate</th>
                    			<th width="10%" class="text-right">Qty</th>
                    			<th width="10%" class="text-right">Price</th>
                    		</tr>
                    	</thead>

                        <tbody>
                        	<?php foreach ($saleProducts as $product): ?>
	                        	<tr>
	                        		<td><?= $product->productName ?></td>
	                        		<td align="right"><?= $product->unit_price ?></td>
	                        		<td align="right"><?= $product->quantity ?></td>
	                        		<td align="right"><?= $product->sales_price_excluding_vat ?></td>
	                        	</tr>                        		
                        	<?php endforeach ?>
                        </tbody>

                        <tfoot>
                        	<tr>
                        		<td colspan="3" align="right">Order Total</td>
                        		<td align="right"><?= $invoiceDetails->gross_payable ?></td>
                        	</tr>
                        	<tr>
                        		<td colspan="3" align="right">Vat Toal</td>
                        		<td align="right"><?= $invoiceDetails->total_vat ?></td>
                        	</tr>
                        	<tr>
                        		<td colspan="3" align="right">Discount</td>
                        		<td align="right"><?= $invoiceDetails->deduction ?></td>
                        	</tr>
                        	<tr>
                        		<th colspan="3" class="text-right">Total Amount</th>
                        		<th class="text-right"><?= $invoiceDetails->amount_to_paid ?></th>
                        	</tr>
                        </tfoot>
                    </table>
    			</div>
    		</div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->