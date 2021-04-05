<div id="page-wrapper">
    <?php if (!empty($this->session->flashdata('success_message'))) { ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Success!</strong> <?= $this->session->flashdata('success_message') ?>
        </div>
    <?php } ?>

    <?php if (!empty($this->session->flashdata('error_message'))) { ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Opps!</strong> <?= $this->session->flashdata('error_message') ?>
        </div>
    <?php } ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
            	<div class="col-md-6"><h4 class=""><?= $title ?></h4></div>
            	<div class="col-md-6 text-right">
            		<a href="<?= base_url('table') ?>" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Table Lists</a>
            	</div>
            </div>
        </div>

        <div class="panel-body">
        	<form id="table_form" name="table_form" action="<?= base_url('table/save') ?>" method="post" enctype="multipart/form-data">
	        	<div class="row">
	        		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
	        			<div class="form-group">
	        				<label>Outlet</label>
	        				<select class="form-control select2" id="outletId" name="outletId">
	        					<option value="">Select Outlet</option>
	        					<?php foreach ($outlet_lists as $outlet): ?>
	        						<option value="<?= $outlet->id ?>"><?= $outlet->branch_name ?></option>
	        					<?php endforeach ?>
	        				</select>
	        			</div>
	        		</div>

	        		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
	        			<div class="form-group">
	        				<label>Table Number</label>
	        				<input class="form-control" type="text" id="tablenNumber" name="tablenNumber">
	        			</div>
	        		</div>

	        		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
	        			<div class="form-group">
	        				<label>Table Capacity</label>
	        				<input class="form-control" type="number" min="1" id="tableCapacity" name="tableCapacity">
	        			</div>
	        		</div>
	        	</div>

	        	<div class="row">
	        		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
	        			<button class="btn btn-primary btn-md">Save</button>
	        		</div>
	        	</div>
        	</form>
        </div>
    </div>
</div>
<!-- /#page-wrapper -->