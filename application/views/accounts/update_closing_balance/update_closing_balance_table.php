<div class="form-group div-margin-top">
    <div class="panel panel-default">
        <table class="table table-striped table-bordered table-hover" id="product-table">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Head</th>
                    <th>Debit/Credit</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $update_closing_balance_session = $this->session->userdata('update_closing_balance_session');
                if (!empty($update_closing_balance_session)) {
                    $count = 1;
                    foreach ($update_closing_balance_session as $update_closing_balance) {
                        ?>
                        <tr>
                            <td width="5%"><?= $count++; ?></td>
                            <td width="45%"><?= $update_closing_balance['head_name'] ?></td>
                            <td width="45%"><?= $update_closing_balance['amount'] ?></td>
                            <td width="5%"><?= $update_closing_balance['balance_type'] ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>


