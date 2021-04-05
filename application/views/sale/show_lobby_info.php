<style type="text/css">
	.table_btn_text { width: 150px; height: 150px; line-height: 130px; }
</style>

<?php if ($table_list): ?>

	<?php foreach ($table_list as $table): ?>
		<?php if ($table->status == 1): ?>
			<span class="btn btn-danger table_btn_text booked" id="table_number" outlet-id="<?= $table->branch_id ?>" table-id="<?= $table->id ?>" onclick="showPendingOrder()"><?= $table->table_number ?> - Booked</span>			
		<?php else: ?>
			<span class="btn btn-default table_btn_text not_booked" id="table_number" table-id="<?= $table->id ?>"><?= $table->table_number ?></span>
		<?php endif ?>
	<?php endforeach ?>
<?php endif ?>