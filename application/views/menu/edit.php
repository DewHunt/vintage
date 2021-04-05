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
			<strong>Sorry!</strong> <?= $this->session->flashdata('error') ?>
		</div>
	<?php endif ?>

	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="row">
				<div class="col-lg-6"><h4><?= $title ?></h4></div>

				<div class="col-lg-6 text-right">
					<a class="btn btn-primary btn-lg" href="<?= base_url('menu') ?>">Menu List</a>
				</div>
			</div>
		</div>

		<div class="panel-body">
            <form id="menu_form" name="menu_form" action="<?= base_url('menu/update') ?>" method="post" enctype="multipart/form-data">
            	<input class="form-control" type="hidden" name="menuId" value="<?= $menuInfo->id ?>">
				<div class="row">
					<div class="col-lg-6 col-md-6">
						<label for="parent">Parent</label>
						<div class="form-group">
							<select class="form-control select2" id="parentMenuId" name="parentMenu">
								<option value="">Select Parent</option>
								<?php foreach ($menu_lists as $menu): ?>
				                	<?php
				                		if ($menu->id == $menuInfo->parent_menu) {
				                			$select = 'selected';
				                		} else {
				                			$select = '';
				                		}						                        		
				                	?>
									<option value="<?= $menu->id ?>" <?= $select ?>><?= $menu->menu_name ?></option>
								<?php endforeach ?>
							</select>
						</div>
					</div>

					<div class="col-lg-6 col-md-6">
						<label for="menu-name">Menu Name</label>
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Menu name" name="menuName" value="<?= $menuInfo->menu_name ?>" required>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-6 col-md-6">
						<label for="menu-link">Menu Link</label>
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Menu link" name="menuLink" value="<?= $menuInfo->menu_link ?>">
						</div>
					</div>

					<div class="col-lg-3 col-md-3">
						<label for="menu-icon">Menu Icon</label>
						<div class="form-group">
							<input type="text" class="form-control" placeholder="fa fa-icon" name="menuIcon" value="<?= $menuInfo->menu_icon ?>">
						</div>
					</div>

					<div class="col-lg-3 col-md-3">
						<label for="order-by">Order By</label>
						<div class="form-group">
							<input type="number" class="form-control" placeholder="Order By" id="orderBy" name="orderBy" value="<?= $menuInfo->order_by ?>" required>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-12 col-md-12 text-right">
						<button class="btn btn-success btn-lg">Update</button>
			        	<a class="btn btn-danger btn-lg" href="<?= base_url('menu/delete/'.$menuInfo->id) ?>">Delete</a>
					</div>
				</div>
            </form>
		</div>
	</div>
</div>

<script type="text/javascript">
    $(document).on('change','#parentMenuId',function(){
        var parentMenuId = $('#parentMenuId').val();

        $.ajax({
            type: "POST",
            url: "<?= base_url('menu/max_order') ?>",
            data:{parentMenuId:parentMenuId},
            success: function(response) {
                var orderBy = response.orderBy;

                $('#orderBy').val(orderBy);
            },
        });
    });
</script>
