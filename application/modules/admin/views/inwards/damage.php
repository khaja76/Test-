<h3 class="header smaller lighter">
    View Inward
</h3>
<?php echo getMessage(); ?>
<span class="text-danger pull-right">* Fields are mandatory</span>
<form class="form-inline text-center" id="frm">
    <div class="form-group">
        <label for="job_id"><sup class="text-danger">*</sup> Job Id :</label>
    </div>
    <div class="form-group">
        <input class="form-control input-sm" id="job_id" name="job_id" type="text" placeholder="Enter Job Id" value="<?= !empty($_GET['job_id']) ? $_GET['job_id'] : ''; ?>" required/>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-xs btn-primary"><i class="fa fa-files-o"></i> Get Record</button>
    </div>
</form>
<div class="clearfix"></div>
<div class="space-12"></div>
<?php
include_once currentModuleView('admin').'common_pages/product_info.php';
 ?>
<script>
    $(document).ready(function () {
        $('#frm').validate({
            errorElement: 'div',
            errorClass: 'help-block',
            focusInvalid: false,
            ignore: "",
            rules: {
                job_id: {required: true}
            },

            messages: {
                job_id: "Please provide Job Id ."
            },


            highlight: function (e) {
                $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
            },

            success: function (e) {
                $(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
                $(e).remove();
            }
        });
    });
</script>