<?php echo getMessage() ?>
<h3 class="header smaller lighter">
    Import Components
    <span class="pull-right">
        <a href="<?php echo base_url() ?>admin/components/sample-csv/" class="btn btn-xs btn-info" download="download" title="Sample CSV File"><i class="fa fa-file-excel-o"></i> Sample CSV File</a>
        <a href="#" class="btn btn-xs btn-warning" onclick="goBack();" title="Back"><i class="fa fa-arrow-left"></i> Back</a>
    </span>
</h3>
<form name="frm" id="frm" class="form-horizontal" method="post" enctype="multipart/form-data">
    <input type="hidden" name="import" id="import" value="true"/>
    <div class="form-group">
        <label for="import_csv" class="col-md-3 control-label">Components CSV</label>
        <div class="col-md-3">
            <input type="file" class="input-file-2" name="import_csv" id="import_csv" class="required"/>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-offset-3 col-md-2">
            <button type="submit" class="btn btn-xs btn-info"> Save <i class="fa fa-save"></i></button>
        </div>
    </div>
</form>
