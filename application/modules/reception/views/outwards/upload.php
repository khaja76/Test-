<h3 class="header smaller lighter">
    Outwards -Upload Images
    <span class="pull-right">
        <a href='#' onclick="goBack();" class='btn btn-warning btn-xs'><i class='fa fa-times'></i> Cancel</a>
    </span>
</h3>
<div class="space-6"></div>
<div class="space-1"></div>
<div class="col-md-12 col-sm-12">
    <form class="form-inline" method="POST" id="frm" enctype="multipart/form-data">
        <input type="hidden" name="job_id" value="<?php echo $inward['job_id'] ?>"/>
        <input type="hidden" name="pk_id" value="<?php echo $inward['pk_id'] ?>"/>
        <input type="hidden" name="job_no" value="<?php echo $inward['inward_no'] ?>"/>
        <input type="hidden" name="customer_id" value="<?php echo $inward['customer_pk_id'] ?>"/>
        <div class="col-md-4">
            <label class="col-md-5"> Upload Images</label>
            <div class="col-md-7">
                <input type="file" name="photo[]" class="input-file-2 inward_imgs  "  multiple="multiple" accept=".png, .jpg,.jpeg, .gif">
            </div>
        </div>
        <div class="col-md-7">
            <label class="col-md-2"> Remarks</label>
            <div class="col-md-10">
                <textarea class="form-control" name="remarks" rows="2" cols="65">Repaired</textarea>
            </div>
        </div>
        <div class="col-md-1">
            <div class="form-group">
                <button type="submit" name="save" class="btn btn-xs btn-success btn-upload _saveOut"><i class="fa fa-files-o"></i> Submit</button>
            </div>
        </div>
    </form>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="job-gallery text-center"></div>
</div>
<div class="space-6"></div>
<div class="clearfix"></div>
<?php
if (!empty($_GET)) {
    if (!empty($inward)) {
        include_once currentModuleView('admin') . 'common_pages/product_info.php'; ?>
    <?php } else {
        echo "<h5 class='text-danger text-center'>Sorry, No Inward Found with searching Data</h5>";
    }
}
?>
<script>
    $(function () {
        $('#frm').validate({
            errorElement: 'div',
            errorClass: 'help-block',
            focusInvalid: false,
            ignore: "",
            rules: {
                photo: {required: true},
            },
            highlight: function (e) {
                //  $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
            },
            success: function (e) {
                $(e).closest('.form-group').removeClass('has-error');
                $(e).remove();
            },
        });
        $('._saveOut').click(function(){
            $(this).attr({
                'type':'button',
                'disabled':true
            });
            $('#frm').submit();
        });
    });
</script>
