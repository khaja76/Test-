<h3 class="header smaller lighter">
    Damaged Images
    <?php if (isset($_GET['inward'])) { ?>
        <span class="pull-right">
    <a href="#" onclick="goBack()" class="btn btn-xs btn-warning"><i class="fa fa-arrow-left"></i> Back</a>
</span>
    <?php } ?>
</h3>
<?php echo getMessage(); ?>
<div class="row">
    <div class="col-md-offset-1 col-md-5">
        <form class="form-inline" method="get">
            <div class="form-group">
                <label for="inward">Job Id :</label>
                <input class="form-control input-sm filter" autofocus="autofocus" id="inward " name="inward" type="text" placeholder="Enter Job Id" value="<?php echo !empty($_GET['inward']) ? $_GET['inward'] : '' ?>"/>
                <button type="submit" class="btn btn-xs btn-primary search_inbtn"><i class="fa fa-files-o"></i> Get Record</button>
            </div>
        </form>
    </div>
    <div class=" col-md-5">
        <?php
        if (!empty($_GET)) {
            if (!empty($inward)) {
                if ($inward['is_outwarded'] != 'YES') {
                    ?>
                    <form class="form-inline" method="POST" id="damageForm" enctype="multipart/form-data">
                        <input type="hidden" name="job_id" value="<?php echo $inward['job_id'] ?>"/>
                        <input type="hidden" name="pk_id" value="<?php echo $inward['pk_id'] ?>"/>
                        <input type="hidden" name="inward_no" value="<?php echo $inward['inward_no'] ?>"/>
                        <input type="hidden" name="customer_id" value="<?php echo $inward['customer_pk_id'] ?>"/>
                        <div class="form-group col-md-12">
                            <div class="col-md-7">
                                <input type="file" name="photo[]" class="input-file-2 inward_imgs required" multiple="multiple" accept=".png, .jpg,.jpeg, .gif">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-xs btn-success saveDamageInwardBtn"><i class="fa fa-files-o"></i> Submit</button>
                            </div>
                            <div class="col-md-1">
                                <a href="<?php echo base_url(); ?>engineer/inwards/damage/" class="btn btn-xs btn-danger">Refresh</a>
                            </div>
                        </div>
                    </form>
                    <?php
                } else {
                    echo "<button class='btn btn-success btn-xs'> <i class='fa fa-check'></i> Delivered </button>";
                }
            }
        }
        ?>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="job-gallery text-center"></div>
</div>
<div class="clearfix"></div>
<div class="space-6"></div>
<?php
if (!empty($_GET)) {
    if (!empty($inward)) {
        include_once currentModuleView('admin') . 'common_pages/product_info.php';
    } else {
        echo "<h5 class='text-danger text-center'>Sorry, No Inward Found with searching Data</h5>";
    }
}
?>
<script>
    $(document).ready(function () {
        $('#damageForm').validate();
        $('.search_inbtn').prop('disabled', true);
        $('.filter').on('keyup', function () {
            if ($(this).val().length >= 3) {
                $('.search_inbtn').prop('disabled', false);
            } else {
                $('.search_inbtn').prop('disabled', true);
            }
        });
    });
</script>