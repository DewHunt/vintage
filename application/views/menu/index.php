<div id="page-wrapper">
	<?php if ($this->session->flashdata('message')): ?>
		<div class="alert alert-success alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Success!</strong> <?= $this->session->flashdata('message') ?>
		</div>
	<?php endif ?>

	<?php if ($this->session->flashdata('error')): ?>
		<div class="alert alert-danger alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Success!</strong> <?= $this->session->flashdata('error') ?>
		</div>
	<?php endif ?>

	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="row">
				<div class="col-lg-6"><h4><?= $title ?></h4></div>

				<div class="col-lg-6 text-right">
					<a class="btn btn-primary btn-lg" href="<?= base_url('menu/add') ?>">Add Menu</a>
				</div>
			</div>
		</div>

		<div class="panel-body">
            <div class="table-responsive table-bordered">
                <table class="table table-striped" id="details-table">
                    <thead>
			            <tr>
			                <th width="20px">SL</th>
			                <th>Name</th>
			                <th>Parent</th>
			                <th>Link</th>
			                <th>Icon</th>
			                <th width="20px">Order</th>
			                <th width="20px">Status</th>
			                <th width="50px">Action</th>
			            </tr>
                    </thead>
                    <tbody>
			        	<?php $sl = 1; ?>
			        	<?php foreach ($menu_lists as $menu): ?>
			        		<tr class="row_<?= $menu->id ?>">
			        			<td><?= $sl++ ?></td>
			        			<td><?= $menu->menu_name ?></td>
			        			<td><?= $menu->parentName ?></td>
			                    <td><?= $menu->menu_link ?></td>
			                    <td><?= $menu->menu_icon ?></td>
			                    <td><?= $menu->order_by ?></td>
			        			<td>
			        			</td>
			        			<td class="text-center">
			        				<a class="btn btn-success btn-sm" href="<?= base_url('menu/edit/'.$menu->id) ?>"><i class=" fa fa-pencil-square-o" aria-hidden="true"></i></a>
			        			</td>
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
        $('#details-table').dataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [[25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]],
            "scrollY": "400px",
            "scrollX": true,
            "ordering": false,
        });
    });
</script>
