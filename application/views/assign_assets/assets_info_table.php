<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover"
           id="assets-info-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Quantity</th>
                <th>Action</th>
            </tr>
        </thead>

        <?php
        $assign_assets = $this->session->userdata('assign_assets');

        /* echo '<pre>';
          echo print_r($message);
          echo '</pre>'; */
        ?>


        <?php if ((!empty($assets_already_added_into_table_message))) { ?>
            <div class="error-message text-align-center">
                <?php echo $assets_already_added_into_table_message; ?>
            </div>
        <?php }
        ?>

        <?php if ((!empty($available_quantity_exceed))) { ?>
            <div class="error-message text-align-center">
                <?php echo $available_quantity_exceed; ?>
            </div>
        <?php } ?>


        <tbody>
            <?php
            if (!empty($assign_assets)) {
                foreach ($assign_assets as $asset):
                    ?>
                    <tr>
                        <td><?= $asset['assets_name'] ?></td>
                        <td><?= $asset['quantity'] ?></td>
                        <td>
                            <a data-id="<?= $asset['array_id'] ?>" class="btn btn-danger delete-assign-asset-button"><i class="fa fa-times" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php } ?>

        </tbody>

    </table>
</div>