<div class="table-responsive">

    <table class="table table-striped table-bordered table-hover table-responsive"
           id="product-table">

        <thead>
        <tr>
            <th>SL</th>
            <th>Income Head</th>
            <th>Expense Head</th>
            <th>Amount</th>
            <th>Invoice Number</th>
            <th>Mr Number</th>
            <th>Client</th>
            <th>Employee</th>
            <th>Debit</th>
            <th>Credit</th>
            <th>Action</th>
        </tr>
        </thead>

        <?php
        $voucher_info = $this->session->userdata('voucher_info');
        $this->session->userdata('voucher_debit_amount');
        $this->session->userdata('voucher_credit_amount');

        /*echo '<pre>';
        print_r($voucher_info);
        echo '</pre>';
        die();*/
        ?>

        <tbody>
        <?php $count = 1;
        if(!empty($voucher_info)) {
            foreach ($voucher_info as $voucher): ?>
                <tr>
                    <td><?= $count++ ?></td>
                    <td><?= $voucher['income_head_name'] ?></td>
                    <td><?= $voucher['expense_head_name'] ?></td>
                    <td><?= $voucher['total_amount'] ?></td>
                    <td><?= $voucher['invoice_number'] ?></td>
                    <td><?= $voucher['mr_number'] ?></td>
                    <td><?= $voucher['client_name'] ?></td>
                    <td><?= $voucher['employee_name'] ?></td>
                    <td><?= $voucher['debit_amount'] ?></td>
                    <td><?= $voucher['credit_amount'] ?></td>
                    <td>
                        <a href="<?= base_url("accounts/voucher/delete_voucher_info/" . $voucher['array_id']) ?>"
                           class="btn btn-danger"><i class="fa fa-times"
                                                     aria-hidden="true"></i></a>
                    </td>
                </tr>
                <?php
            endforeach;
        }
        ?>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>Total</td>
            <td><?= $this->session->userdata('voucher_debit_amount'); ?></td>
            <td><?= $this->session->userdata('voucher_credit_amount'); ?></td>
            <td></td>
        </tr>

        </tbody>

    </table>
</div>