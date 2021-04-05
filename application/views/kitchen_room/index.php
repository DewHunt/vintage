<div id="page-wrapper">
	<style type="text/css">
	    #page-wrapper { padding-top: 5px; }
	    #page-wrapper.active { padding-top: 5px; }

		.custom-padding { padding: 2px !important; margin: 0px !important; }
		.custom-panel { margin-bottom: 2px; border-radius: 0px; }
		.custom-panel-heading { margin: 0px; padding: 3px; background-color: #545353 !important; color: #fff !important; }
		.custom-panel-body { padding: 3px; background-color: #fff !important; }
		.custom-panle-footer { padding: 3px; }
		.custom-btn-sm { padding: 1px; font-size: 12px; border-radius: 0px; }

		.tableFixHead { overflow-y: auto; height: 250px; }
		.tableFixHead thead th { position: sticky; top: 0; }
		.form-group { margin-bottom: 5px }
		table { border-collapse: collapse; width: 100%; }
		th, td { padding: 8px 16px; }
		th { background:#eee; }

		h4 { margin: 0px; }
	</style>

	<?php if ($number_of_outlet > 1): ?>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	            <h4>
                    Now You Are Selected On <span id="outletName"><?= $this->session->userdata('sessionKitchenOutletName') ?></span>
                    <input type="hidden" id="outletId" name="outlet" value="<?= $this->session->userdata('sessionKitchenOutletId') ?>">
                    <a data-toggle="modal" data-target="#outletModal">Change Outlet</a>
	            </h4>
			</div>
		</div>
	<?php endif ?>
	
    <div class="modal fade" id="outletModal" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-center">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <button type="button" class="close btnCheck" data-dismiss="modal">&times;</button> -->
                    <h4 class="modal-title">All Outlets</h4>
                </div>
                <div class="modal-body"> 
					<div class="form-horizontal">
						<div class="form-group">
							<label class="control-label col-lg-2 col-md-2 col-sm-2 col-xs-2" for="email">Outlet:</label>
							<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
				                <select class="form-control select2 outlet" name="outlet" id="outlet">
				                    <option value="">Select Outlet</option>
				                    <?php foreach ($outlet_list as $outlet): ?>
				                        <option value="<?= intval($outlet->id) ?>"><?= ucfirst($outlet->branch_name) ?></option>
				                    <?php endforeach ?>
				                </select>
							</div>
						</div>
					</div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-default btnCheck" data-dismiss="modal">Close</button> -->
                </div>
            </div>
        </div>
    </div>

    <div id="all-orders-block">
	    <?php if ($all_orders): ?>  
		    <div class="row">
		    	<?php foreach ($all_orders as $order): ?>
			        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 custom-padding">
					    <div class="panel panel-default custom-panel">
					        <div class="panel-heading custom-panel-heading">
					            <div class="row">
					                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center"><h4><?= $order->token_number ?></h4></div>
					                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center"><h4><?= $order->order_date ?></h4></div>
					            </div>
					        </div>

					        <?php $all_sale_product = $this->Sale_product_Model->getSaleProductInformationByInvoiceId($order->id); ?>

					        <div class="panel-body custom-panel-body">
					        	<div class="tableFixHead">
						        	<table class="table table-sm">
						        		<thead>
						        			<tr>
						        				<th width="10px">Qty</th>
						        				<th colspan="2">Item</th>
						        			</tr>
						        		</thead>

						        		<tbody>
						        			<?php foreach ($all_sale_product as $product): ?>
							        			<tr>
							        				<td align="right"><?= $product->quantity ?></td>
							        				<td><?= $product->productName ?></td>
							        				<td align="right">
							        					<?php if ($product->delivery_status == 2): ?>
							        						<button class="btn btn-sm btn-success custom-btn-sm">Delivered</button>
							        					<?php else: ?>
							        						<?php if ($product->delivery_status == 0): ?>
							        							<button class="btn btn-sm btn-danger custom-btn-sm" onclick="product_delivered(<?= $product->id.",".$product->delivery_status.",".$order->id ?>)">Pending</button>
							        						<?php else: ?>
							        							<button class="btn btn-sm btn-primary custom-btn-sm" onclick="product_delivered(<?= $product->id.",".$product->delivery_status.",".$order->id ?>)">Preparing</button>
							        							
							        						<?php endif ?>
							        					<?php endif ?>
							        				</td>
							        			</tr>					        				
						        			<?php endforeach ?>
						        		</tbody>
						        	</table>
					        	</div>
					        </div>

					        <div class="panel-footer custom-panle-footer">
					        	<div class="row">
					        		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><button class="btn btn-sm btn-primary btn-block" onclick="order_delivered(<?= $order->id ?>)">Delivered</button></div>
					        	</div>
					        </div>
					    </div>            	
			        </div>
		    	<?php endforeach ?>
		    </div>
    <?php else: ?>
	    <div class="row">
	        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 custom-padding">
	        	<h2>Please Wait! Right Now You Don't Have Any Order.</h2>
	        </div>
	    </div>
	    <?php endif ?>
	</div>
</div>
<!-- /#page-wrapper -->

<script type="text/javascript">
    $(document).ready(function () {
        setTimeout(function(){ location.reload(true); }, 60000)

        if ($('#outletId').val() == "") { $('#outletModal').modal('show'); }
    });

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
                url: '<?php echo base_url("kitchen_room/find_all_order_by_outlet_id/") ?>',
                data: {outletVal:outletVal,outletName:outletName,},
                success: function (data) {
                    $('#outletId').val(outletVal);
                    $('#outletName').html(outletName);
                    $('#all-orders-block').html(data.view_all_orders);
                },
                error: function () {

                }
            })
            $("#outletModal").modal('hide');
        }
    });

    function order_delivered(invoice_id) {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("kitchen_room/order_delivered/") ?>',
            data: {invoice_id:invoice_id},
            success: function (data) {
                swal({
                    title: "<small class='text-success'>Success!</small>", 
                    type: "success",
                    text: "Ordered Delivered Successfully!",
                    timer: 1000,
                    html: true,
                });
                setTimeout(function(){ location.reload(true); }, 1000)
            },
            error: function () {
            }
        })
    }

    function product_delivered(sale_product_id,delivery_status,invoice_id) {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("kitchen_room/sale_product_delivered/") ?>',
            data: {invoice_id:invoice_id,sale_product_id:sale_product_id,delivery_status:delivery_status},
            success: function (data) {
                swal({
                    title: "<small class='text-success'>Success!</small>", 
                    type: "success",
                    text: "Item Delivered Successfully!",
                    timer: 1000,
                    html: true,
                });
                setTimeout(function(){ location.reload(true); }, 1000)
            },
            error: function () {
            }
        })
    }
</script>
