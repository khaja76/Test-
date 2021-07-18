<h3 class="header smaller lighter">
    Payments
    <span class="pull-right">
        <span class="pull-right">
            <button type="submit" form="frm" class="btn btn-xs btn-success"><i class="fa fa-floppy-o"></i> Save</button>
            <a href="<?php echo base_url(); ?>reception/payments" class="btn btn-xs btn-warning"><i class="fa fa-arrow-left"></i> Back</a>
        </span>
    </span>
</h3>
<form class="form-inline text-center" id="search_inward">
    <div class="form-group">
        <label for="job_id"><sup class="text-danger">*</sup> Job Id :</label>
    </div>
    <div class="form-group">
        <input class="form-control input-sm" id="job_id" autofocus="autofocus" name="job_id" type="text" placeholder="Enter Job Id" value="<?= !empty($_GET['job_id']) ? $_GET['job_id'] : ''; ?>" required/>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-xs btn-primary search_inbtn"><i class="fa fa-files-o"></i> View Details</button>
    </div>
</form>
<div class="clearfix"></div>
<div class="space-6"></div>
<?php include_once currentModuleView('admin') . 'common_pages/product_info.php' ?>
