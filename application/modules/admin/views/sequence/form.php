<h3 class="header smaller lighter">
    Welcome to Number Sequence Settings Page
</h3>
<?php echo getMessage(); ?>
<span class="pull-right text-danger">
    * Fields are mandatory 
</span>
<form class="form-horizontal" id="frm" method="POST" autocomplete="off">   
<input type="hidden" name="pk_id" value="<?php echo !empty($sequence['pk_id']) ? $sequence['pk_id'] : ""; ?>">
    <div class="col-md-6 col-md-offset-3">        
        <div class="form-group">
            <label class="control-label col-sm-4"><sup class="text-danger">*</sup>  Name :</label>
            <div class="col-sm-8">
                <?php $types = ['TAX_INVOICE','OUTWARD','INWARD','PROFORMA','QUOTATION','INWARD_CHALLAN','OUTWARD_CHALLAN']; ?>
                <select class="form-control required" name="action_type" required>
                    <option value="">Select Name</option>
                    <?php foreach ($types as $key => $type) { ?>
                        <option value='<?php echo $type; ?>' <?php echo !empty($sequence) && ($sequence['action_type']==$type) ? "selected='selected'" : ""; ?>><?php echo $type; ?></option>
                    <?php } ?>                                   
                </select>
            </div>
        </div>    
        <div class="form-group">
            <label class="control-label col-sm-4"><sup class="text-danger">*</sup> Number :</label>
            <div class="col-sm-8">
                <input type="text" class="form-control input-sm required" onkeypress="return isNumber(event)" name="number" placeholder="Enter Number" value="<?php echo !empty($sequence['number']) ? $sequence['number'] : ""; ?>">
            </div>
        </div>  
        <div class="col-md-offset-4">
        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-submit"></i> Save</button>
        </div>
    </div>
</form>
<script type="text/javascript">
    //jQuery(function ($) {
    $(document).ready(function(){
        $('#frm').validate({
            errorElement: 'div',
            errorClass: 'help-block',
            focusInvalid: false,
            ignore: "",
            rules: {
                action_type: {required: true},
                number: {required: true}
            },
            highlight: function (e) {
                $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
            },
            success: function (e) {
                $(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
                $(e).remove();
            },
            invalidHandler: function (form) {
            }
        });
    })
</script>