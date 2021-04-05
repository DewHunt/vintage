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
            		<a href="<?= base_url('table/add') ?>" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Add New Table</a>
            	</div>
            </div>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">
                    <label>Outlet</label>
                    <div class="form-group">
                        <select class="form-control branch_id select2" id="branchId" name="branchId">
                            <option value="">Select Outlet</option>
                            <?php foreach ($branch_list as $branch): ?>
                                <option value="<?= $branch->id ?>"><?= $branch->branch_name ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="table_list"></div>
        </div>
    </div>
</div>
<!-- /#page-wrapper -->

<!--Jquery Data Table-->
<script type="text/javascript">
    $(document).on('change','.branch_id',function(e) {
        var branchId = $(this).val();
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("table/get_table_info_by_branch_id/") ?>',
            data: {branchId:branchId},
            success: function (data) {
                $('.table_list').html(data.output);
            },
            error: function () {
            }
        });
    });
</script>