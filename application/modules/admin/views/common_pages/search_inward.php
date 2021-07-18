
<?php echo getMessage(); ?>
<!-- <span class="text-danger pull-right">
    * Fields are mandatory 
</span> -->
<form class="form-inline text-center" id="search_inward">
    <div class="form-group">
        <label for="job_id"><sup class="text-danger">*</sup> Job Id :</label>
    </div>
    <div class="form-group">
        <input class="form-control input-sm"  id="job_id" autofocus="autofocus"  name="job_id" type="text" placeholder="Enter Job Id" value="<?= !empty($_GET['job_id']) ? $_GET['job_id'] : ''; ?>" required/>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-xs btn-primary search_inbtn"><i class="fa fa-files-o"></i> View Details</button>
    </div>
</form>
<div class="space-6"></div>
<?php include_once currentModuleView('admin') . 'common_pages/product_info.php' ?>
<script>
    $(document).ready(function () {
        $('.search_inbtn').prop('disabled', true);
        $('#job_id').on('keyup', function() {
             if($(this).val().length >= 3) {
                $('.search_inbtn').prop('disabled', false);
                 } else {
                $('.search_inbtn').prop('disabled', true);
            }
        });
    });
</script>
