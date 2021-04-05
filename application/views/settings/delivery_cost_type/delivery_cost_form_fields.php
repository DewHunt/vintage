<div class="form-group row">
    <label for="delivery_cost_name" class="col-sm-2 col-xs-12 col-form-label">Delivery Cost Name</label>
    <div class="col-sm-10 col-xs-12">
        <input type="text" class="form-control" id="delivery_cost_name" name="delivery_cost_name" value="<?= !empty($delivery_cost_type->delivery_cost_name) ? $delivery_cost_type->delivery_cost_name : ''; ?>" placeholder="Delivery Cost Name">
    </div>
    <?php if (!empty($this->session->flashdata('delivery_cost_name_error_message'))) { ?>
        <div class="form-group row">
            <label for="" class="col-sm-2 col-xs-12 col-form-label"></label>
            <div class="col-sm-10 col-xs-12 error-message">
                <?= $this->session->flashdata('delivery_cost_name_error_message') ?>
            </div>
        </div>
    <?php } ?>
</div>

<?php if (!empty($this->session->flashdata('delivery_cost_type_duplicate_error_message'))) { ?>
    <div class="form-group row">
        <label for="" class="col-sm-2 col-xs-12 col-form-label"></label>
        <div class="col-sm-10 col-xs-12 error-message">
            <?= $this->session->flashdata('delivery_cost_type_duplicate_error_message') ?>
        </div>
    </div>
<?php } ?>
<button type="submit" class="btn btn-default save-button"><?= !empty($button_text) ? $button_text : 'Save' ?></button>