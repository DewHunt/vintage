<?php
	$root_menu_lists = get_root_menu_list();
	$menu_permission = explode(',', $user_info->menu_permission);
	// echo "<pre>"; print_r($root_menu_lists); exit();
?>

<style type="text/css">
    .parentMenuBlock{
        border: 1px solid #d4c8c8;
        padding: 10px 0px;
        margin-bottom: 10px;
    }
</style>

<div id="page-wrapper">
	<form id="menu_form" name="menu_form" action="<?= base_url('user/update_permisssion') ?>" method="post" enctype="multipart/form-data">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-lg-6"><h4><?= $title ?></h4></div>

					<div class="col-lg-6 text-right">
						<button class="btn btn-success btn-lg">Update</button>
						<a class="btn btn-primary btn-lg" href="<?= base_url('user') ?>"><i class=" fa fa-reply-all" aria-hidden="true"></i>&nbsp;Go Back</a>
					</div>
				</div>
			</div>

			<div class="panel-body" style="margin: 0px 20px;">
				<input type="hidden" name="user_id" value="<?= $user_info->id ?>">

				<div class="row parentMenuBlock">
				    <div class="col-lg-10">
				    	<input type="checkbox" class="select_all" name="select_all"> Select All
				    </div>
				</div>

				<?php foreach ($root_menu_lists as $root_menu): ?>
					<?php 
						$checked = checke_menu_permission($root_menu->id,$menu_permission);
				        $parent_menu_lists = get_menu_list($root_menu->id);
					?>

					<div class="row parentMenuBlock">
						<div class="col-lg-12">
	                		<input class="parentMenu_<?= $root_menu->parent_menu ?> menu" type="checkbox" name="usermenu[]" value="<?= $root_menu->id ?>" <?= $checked ?>  data-id="<?= $root_menu->id ?>" <?php if ($root_menu->id == 1): ?>onclick="return false" checked<?php endif ?>>&nbsp;<span><?= $root_menu->menu_name ?></span>
	                		<div class="row" style="padding-left: 30px;">
	                			<?php foreach ($parent_menu_lists as $parent_menu): ?>
		                        	<?php
										$checked = checke_menu_permission($parent_menu->id,$menu_permission);
								        $child_menu_lists = get_menu_list($parent_menu->id);
		                        	?>

		                        	<div class="col-lg-3">
	                                	<input class="parentMenu_<?= $parent_menu->parent_menu ?> menu" type="checkbox" name="usermenu[]" value="<?= $parent_menu->id ?>" <?= $checked ?>  data-id="<?= $parent_menu->id ?>">&nbsp;<span><?= $parent_menu->menu_name ?></span>

	                                	<div class="row" style="padding-left: 30px;">
	                                		<?php foreach ($child_menu_lists as $child_menu): ?>
					                        	<?php
													$checked = checke_menu_permission($child_menu->id,$menu_permission);
											        $menu_lists = get_menu_list($child_menu->id);
					                        	?>
					                        	<div class="col-lg-12">
	                                            	<input class="parentMenu_<?= $child_menu->parent_menu ?> menu" type="checkbox" name="usermenu[]" value="<?= $child_menu->id ?>" <?= $checked ?> data-id="<?= $child_menu->id ?>">&nbsp;<span><?= $child_menu->menu_name ?></span>
	                                            	<div class="row" style="padding-left: 30px;">
	                                            		<?php foreach ($menu_lists as $menu): ?>
								                        	<?php
																$checked = checke_menu_permission($menu->id,$menu_permission);
								                        	?>
								                        	<div class="col-lg-12">
	                                            				<input class="parentMenu_<?= $menu->parent_menu ?> menu" type="checkbox" name="usermenu[]" value="<?= $menu->id ?>" <?= $checked ?> data-id="<?= $menu->id ?>">&nbsp;<span><?= $menu->menu_name ?></span>
								                        	</div>
	                                            		<?php endforeach ?>
	                                            	</div>
					                        	</div>
	                                		<?php endforeach ?>
	                                	</div>
		                        	</div>
	                			<?php endforeach ?>
	                		</div>
						</div>
					</div>
				<?php endforeach ?>
			</div>

			<div class="panel-footer">
				<div class="row">
					<div class="col-lg-12 text-right">
						<button class="btn btn-success btn-lg">Update</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('.select_all').click(function(event){
            if(this.checked)
            {
                // Iterate each checkbox
                $(':checkbox').each(function(){
                    this.checked = true;
                });
            }
            else
            {
                $(':checkbox').each(function(){
                    this.checked = false;
                });
            }
        });

        $('.menu').click(function(event){
            var menuId = $(this).data('id');
            if(this.checked)
            {
                $('.parentMenu_'+menuId).each(function()
                {
                    this.checked = true;
                });

                $('.childMenu_'+menuId).each(function(){
                    this.checked = true;
                });
            }
            else
            {
                $('.parentMenu_'+menuId).each(function()
                {
                    this.checked = false;
                });

                $('.childMenu_'+menuId).each(function(){
                    this.checked = false;
                });
            }
        });
    });
</script>
