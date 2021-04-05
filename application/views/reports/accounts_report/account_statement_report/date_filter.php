<input type="hidden" id="start_date" name="start_date" value="<?= get_first_date_of_current_year(); ?>">
<input type="hidden" id="end_date" name="end_date" value="<?= get_last_date_of_current_year(); ?>">
<input type="hidden" id="is_custom" name="is_custom" value="0">
<label for="year" class="col-form-label">Year</label>
<select name="year" id="year" class="form-control">
    <option value="" name="year">Please Select</option>
    <?php
    $current_year = get_current_year();
    foreach (get_start_year_to_current_year_array() as $year) {
        $start_date = date($year . '-01-01');
        $end_date = date($year . '-12-31');
        ?>
        <option start_date="<?= $start_date; ?>" end_date="<?= $end_date; ?>" <?= (string) $year == (string) $current_year ? "selected='selected'" : '' ?> value="<?= $year; ?>" name="year" is_custom="0"><?= $year; ?></option>
        <?php
    }
    ?>
    <option value="<?= $current_year; ?>" start_date="<?= get_first_date_of_current_year(); ?>" end_date="<?= get_last_date_of_selected_month(date('Y-03-01')); ?>" is_custom="1"><?= get_month_name_by_month_number(1, TRUE); ?>-<?= get_month_name_by_month_number(3, TRUE); ?>(<?= get_current_year(); ?>)</option>
    <option value="<?= $current_year; ?>" start_date="<?= get_first_date_of_current_year(); ?>" end_date="<?= get_last_date_of_selected_month(date('Y-06-01')); ?>" is_custom="1"><?= get_month_name_by_month_number(1, TRUE); ?>-<?= get_month_name_by_month_number(6, TRUE); ?>(<?= get_current_year(); ?>)</option>
    <option value="<?= $current_year; ?>" start_date="<?= get_first_date_of_current_year(); ?>" end_date="<?= get_last_date_of_selected_month(date('Y-09-01')); ?>" is_custom="1"><?= get_month_name_by_month_number(1, TRUE); ?>-<?= get_month_name_by_month_number(9, TRUE); ?>(<?= get_current_year(); ?>)</option>
</select>

<script type="text/javascript">
    $(document).ready(function () {
        $('#year').change(function (e) {
            e.preventDefault();
            var startDate = $(this).find('option:selected').attr("start_date");
            var endDate = $(this).find('option:selected').attr("end_date");
            var isCustom = $(this).find('option:selected').attr("is_custom");
            $('#start_date').val(startDate);
            $('#end_date').val(endDate);
            $('#is_custom').val(isCustom);
        });
    });
</script>