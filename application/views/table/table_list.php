<div class="table-responsive table-bordered">
    <table class="table table-striped" id="details-table">
        <thead>
            <tr>
                <th width="20px">SL</th>
                <th width="200px">Table Number</th>
                <th width="80px">Capacity</th>
                <th width="80px">Status</th>
                <th width="50px">Action</th>
            </tr>
        </thead>

        <tbody>
            <?php $sl = 1 ?>
            <?php foreach ($table_list as $table): ?>                            
                <tr>
                    <td><?= $sl++ ?></td>
                    <td><?= $table->table_number ?></td>
                    <td><?= $table->table_capacity ?></td>
                    <td><?= $table->status == 0 ? 'Vacant' : 'Booked' ?></td>
                    <td>
                        <a href="<?= base_url("table/edit/$table->id") ?>" class="btn btn-primary btn-sm">
                            <i class=" fa fa-pencil-square-o" aria-hidden="true"></i>
                        </a>

                        <a onclick="return delete_confirm();" href="<?= base_url("table/delete/$table->id") ?>" class="btn btn-danger btn-sm">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
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