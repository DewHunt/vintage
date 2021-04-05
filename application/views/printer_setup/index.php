<div id="page-wrapper">
    <?php if (!empty($this->session->flashdata('successMessage'))) { ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Success!</strong> <?= $this->session->flashdata('successMessage') ?>
        </div>
    <?php } ?>

    <?php if (!empty($this->session->flashdata('errorMessage'))) { ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Opps!</strong> <?= $this->session->flashdata('errorMessage') ?>
        </div>
    <?php } ?>
    
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
              <div class="col-md-6"><h4 class="">Outlet Details</h4></div>
              <div class="col-md-6 text-right">
                  <a class="btn btn-primary btn-lg" href="<?= base_url('printer_setup/add') ?>">
                  	<i class="fa fa-plus" aria-hidden="true"></i> Add New Printer
                  </a>
              </div>
            </div>
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <div class="table-responsive table-bordered">
                <table class="table table-striped" id="details-table">
                    <thead>
                        <tr>
                            <th width="20px">SL</th>
                            <th width="200px">Name</th>
                            <th>Address</th>
                            <th class="action-fixed-width">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php $sl = 1; ?>
                    	<?php foreach ($printer_list as $printer): ?>
                            <tr>
                                <td><?= $sl++ ?></td>
                                <td><?= $printer->name ?></td>
                                <td><?= $printer->address ?></td>
                                <td class="action-fixed-width">
                                    <a href="<?= base_url("printer_setup/edit/$printer->id") ?>" class="btn btn-primary">
                                    	<i class=" fa fa-pencil-square-o" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>                                		
                    	<?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.panel-body -->
    </div>
</div>
<!-- /#page-wrapper -->


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
