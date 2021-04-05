<div class="form-group row">
    <div class="form-group col-xs-12 col-sm-3" style="width: 20%;">
        <label class="search-from-date" for="start_date">From</label>
        <input type="date" class="form-control" id="start_date" name="start_date" value="<?= get_string_to_date_fromat_ymd($start_date); ?>" required>
    </div>            
    <div class="form-group col-xs-12 col-sm-3" style="width: 20%;">
        <label class="search-from-date" for="end_date">To</label>
        <input type="date" class="form-control" id="end_date" name="end_date" value="<?= get_string_to_date_fromat_ymd($end_date); ?>" required>
    </div>
    <div class="form-group col-xs-12 col-sm-2" style="width: 30%;">
        <label style="width: 100%;" class="" for="range">Range</label>
        <input style="width: 40%; float: left;" type="number" min="0" class="form-control" id="start_limit" name="start_limit" value="0" required>
        <label style="width: 10%; float: left; font-weight: bold; margin-left: 7px; margin-top: 5px;">To</label>
        <input style="width: 45%;" type="number" min="1" class="form-control" id="end_limit" name="end_limit" value="25" required>
    </div>
    <div class="form-group col-xs-12 col-sm-2 show-button-section pull-right" style="width: 15%;">
        <label class="" for=""></label>
        <button style="padding: 10px 30px 10px 30px; margin-top: 20px;" type="button" class="right-side-view btn btn-info canvas-print-button"><i class="fa fa-print" aria-hidden="true"></i>&nbsp;Print</button>
    </div>  
    <div class="form-group col-xs-12 col-sm-2 show-button-section pull-right" style="width: 15%;">
        <label class="" for=""></label>
        <button type="submit" class="btn btn-primary show-button" id="show-button">Show</button>
    </div>   
    <div class="col-xs-12 col-sm-2 display-none loading-image"></div>
</div>