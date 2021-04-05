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
            <strong>Success!</strong> <?= $this->session->flashdata('errorMessage') ?>
        </div>
    <?php } ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><h4 class="">Supplier</h4></div>
              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                <a href="<?= base_url('supplier/payment') ?>" class="btn btn-primary">
                    <i class=" fa fa-plus" aria-hidden="true"></i> Add New Payment
                </a>
                <a href="<?= base_url('supplier/add') ?>" class="btn btn-primary">
                    <i class=" fa fa-plus" aria-hidden="true"></i> Add New Supplier
                </a>
              </div>
            </div>
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped" id="details-table">
                    <thead>
                        <tr>
                            <th width="20px">SL</th>
                            <th>Name</th>
                            <th width="200px">Contact Person</th>
                            <th width="120px">Contact Number</th>
                            <th width="120px">Email</th>
                            <th>Address</th>
                            <th>Advanced</th>
                            <th>Paid</th>
                            <th>Due</th>
                            <th width="60px">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $sl = 1; ?>
                        <?php foreach ($supplierLists as $supplier): ?>
                            <tr>
                                <td><?= $sl++ ?></td>
                                <td><?= $supplier->name ?></td>
                                <td><?= $supplier->contact_person_name ?></td>
                                <td><?= $supplier->contact_person_contact_number ?></td>
                                <td><?= $supplier->email ?></td>
                                <td><?= $supplier->address ?></td>
                                <td><?= $supplier->advanced_amount ?></td>
                                <td><?= $supplier->paid_amount ?></td>
                                <td><?= $supplier->due_amount ?></td>
                                <td>
                                    <a href="<?= base_url("supplier/edit/$supplier->id") ?>" class="btn btn-primary">
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
                    
    //ajax status change code
    function statusChange(supplier_id) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "post",
            url: "<?= base_url('supplier/status') ?>",
            data: {supplier_id:supplier_id},
            success: function(response) {
                swal({
                    title: "<small class='text-success'>Success!</small>", 
                    type: "success",
                    text: "Status Successfully Updated!",
                    timer: 1000,
                    html: true,
                });
            },
            error: function(response) {
                error = "Failed.";
                swal({
                    title: "<small class='text-danger'>Error!</small>", 
                    type: "error",
                    text: error,
                    timer: 2000,
                    html: true,
                });
            }
        });
    }

    function delete_confirm() {
        var delete_confirmation_message = confirm("Are you sure to delete permanently?");
        if (delete_confirmation_message != true) {
            return false;
        }
    }
</script>
