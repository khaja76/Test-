<h3 class="header smaller lighter">
    Add Location
    <span class="pull-right">
        <button type="submit" form="frm" class="btn btn-xs btn-success"><i class="fa fa-floppy-o"></i> Save</button>
        <a href="#" onclick="goBack();" class="btn btn-xs btn-warning"><i class="fa fa-arrow-left"></i> Back</a>
    </span>
</h3>
<?php echo getMessage(); ?>
<span class="pull-right text-danger">
    * Fields are mandatory 
</span>
<form class="form-horizontal" id="frm" method="POST" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="pk_id" value="<?php echo !empty($location['pk_id']) ? $location['pk_id'] : ""; ?>">

    <div class="col-md-12">
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label col-sm-5" for="country"><sup class="text-danger">*</sup> Country Name :</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control input-sm"  id="country" name="country" placeholder="Enter Country Name" value="<?php echo !empty($location['country']) ? $location['country'] : ""; ?>">
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label col-sm-5" for="location_name"><sup class="text-danger">*</sup> Location Name :</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control input-sm" id="location_name" name="location_name" placeholder="Enter Location Name" value="<?php echo !empty($location['location_name']) ? $location['location_name'] : ""; ?>">
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label col-sm-5" for="location_code"><sup class="text-danger">*</sup> Location Code :</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control input-sm" id="location_code" name="location_code" placeholder="Enter Location Code" value="<?php echo !empty($location['location_code']) ? $location['location_code'] : ""; ?>">
                </div>
            </div>
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
                location_name: {required: true},
                location_code: {required: true}
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