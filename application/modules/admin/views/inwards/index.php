<h3 class="header smaller lighter">
Inward Details
</h3>
<form class="form-inline text-center mt-m10" method="get" id="frm">
<?php if ($_SESSION['ROLE'] == 'SUPER_ADMIN') {
    ?>
    <div class="form-group">
        <select name="location_id" id="location_id" class="form-control input-sm ">
            <option value="">-- Select Location Name --</option>
            <?php if (!empty($locations)) {
                foreach ($locations as $key => $name) { ?>
                    <option value="<?php echo $key; ?>" <?php echo (!empty($_GET['location_id']) && ($key == $_GET['location_id'])) ? "selected" : "" ?>><?php echo $name; ?></option>
                <?php }
            } ?>
        </select>
    </div>
    <div class="form-group">
        <select name="branch_id" id="branch_id" class="form-control input-sm">
            <option value="">-- Select Branch Name --</option>
            <?php if (!empty($branches)) {
                foreach ($branches as $k => $n) { ?>
                    <option value="<?php echo $k; ?>"><?php echo $n; ?></option>
                <?php }
            } else if (!empty($branches)) {
                echo "<option value=''>No Branch found</option>";
            } else if ($branches_else) {
                foreach ($branches_else as $k => $n) {
                        ?>
                        <option value="<?php echo $k; ?>" <?php echo (!empty($_GET['branch_id']) && ($k == $_GET['branch_id'])) ? "selected" : "" ?>><?php echo $n; ?></option>
                    <?php 
                }
            } ?>
        </select>
    </div>
    <?php
} ?>
<div class="form-group">
    <div class="input-daterange input-group">
        <input type="text" class="input-sm form-control" name="from_date" placeholder="Select Start Date" value="<?php echo !empty($_GET['from_date']) ? $_GET['from_date'] : ''; ?>"/>
        <span class="input-group-addon">
                <i class="fa fa-exchange"></i>
            </span>
        <input type="text" class="input-sm form-control" name="to_date" placeholder="Select End Date" value="<?php echo !empty($_GET['to_date']) ? $_GET['to_date'] : ''; ?>"/>
    </div>
</div>
<div class="form-group">
    <button type="submit" class="btn btn-xs btn-primary"><i class="fa fa-files-o"></i> Get Records</button>
    <a href="<?php echo base_url(); ?>admin/inwards/" class="btn btn-xs btn-danger"><i class="fa fa-refresh"></i> Refresh</a>
</div>
</form>
<?php
include_once currentModuleView('admin') . 'common_pages/inwards.php';
include_once currentModuleView('admin') . 'common_pages/location_search_js.php' ?>
