
<div class="table-responsive">
    <table class="table table-striped" id="details-table">
        <thead>
            <tr>
                <th width="10px">SL</th>
                <th width="140px">Date</th>
                <th>Supplier Name</th>
                <th width="110px">Payment Mode</th>
                <th width="100px">Total Amount</th>
                <th width="100px">Paid Amount</th>
                <th width="100px">Due Amount</th>
                <th width="60px">Action</th>
            </tr>
        </thead>

        <tbody>
            <?php $sl = 1; ?>
            <?php foreach ($purchasedStatementList as $purchaseStatement): ?>
                <tr>
                    <td><?= $sl++ ?></td>
                    <td><?= $purchaseStatement->date ?></td>
                    <td><?= $purchaseStatement->supplierName ?></td>
                    <td><?= $purchaseStatement->payment_mode ?></td>
                    <td align="right"><?= $purchaseStatement->total_amount ?></td>
                    <td align="right"><?= $purchaseStatement->paid_amount ?></td>
                    <td align="right"><?= $purchaseStatement->due_amount ?></td>
                    <td>
                        <span class="btn btn-primary" onclick="viewPurchasedProductInfo(<?= $purchaseStatement->id ?>)"><i class="fa fa-eye"></i>
                    </td>
                </tr>                            
            <?php endforeach ?>
        </tbody>
    </table>
</div>

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