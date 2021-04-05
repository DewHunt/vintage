
    <?php if (count($all_orders) > 0): ?>
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

				        <?php
				        	$all_sale_product = $this->Sale_product_Model->getSaleProductInformationByInvoiceId($order->id);
				        ?>

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
						        				<td align="right"><a class="btn btn-sm btn-primary custom-btn-sm" href="#">Preparing</a></td>
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