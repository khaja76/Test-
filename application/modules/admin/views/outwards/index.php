<h3 class="header smaller lighter">
    Outwards
</h3>
<div class="mt-m10"></div>
<form class="form-inline text-center" id="frm" action="" enctype="multipart/form-data" method="get">
    <?php  if ($_SESSION['ROLE'] == 'SUPER_ADMIN') {
        ?>
        <div class="form-group">
            <select name="location_id" id="location_id" class="form-control input-sm">
                <option value="">-- Select Location Name --</option>
                <?php if (!empty($locations)) {
                    foreach ($locations as $key => $name) { ?>
                        <option value="<?php echo $key; ?>" <?php echo (!empty($_GET) && ($key == $_GET['location_id'])) ? "selected" : "" ?>><?php echo $name; ?></option>
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
                        <option value="<?php echo $k; ?>" <?php echo ($_GET['branch_id'] == $k) ? "selected" : "" ?>><?php echo $n; ?></option>
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
        <a href="<?php echo base_url()?>admin/outwards/" class="btn btn-xs btn-danger"><i class="fa fa-refresh"></i> Refresh </a>
    </div>
</form>
<div class="space-2"></div>
<?php
if (!empty($inwards)) {
    ?>
    <div class="col-md-12">
        <table class="table table-bordered table-hover" id="<?php echo !empty($inwards) ? 'dtable' : ''; ?>">
            <thead>
            <tr>
                <th>S. No.</th>
                <th>Job Id</th>
                <th>Customer Name</th>
                <th>Inward Date</th>
                <th>Status</th>
                <th>Delivery Challan</th>
                <th>Delivery Date</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 1;
            foreach ($inwards as $inward) { ?>
                <tr>
                    <td><?php echo $i ?></td>
                    <td>
                    <?php
                        if(!empty($inward['job_id']))
                        {
                            echo $inward['job_id'];
                            ?>
                                <span class="info">
                                    <a href="<?php echo get_role_based_link(); ?>/inwards/history/?inward=<?php echo $inward['job_no']; ?><?php echo (!empty($_SESSION) && $_SESSION["ROLE"]=="SUPER_ADMIN") ? "&branch_id=".$inward['branch_id']."" :"";?>" class="badge badge-success" data-toggle="tooltip" title="Full Information"><i class="fa fa-info"></i></a>
                                    <a href="<?php echo get_role_based_link(); ?>/inwards/view/?inward=<?php echo $inward['job_no']; ?><?php echo (!empty($_SESSION) && $_SESSION["ROLE"]=="SUPER_ADMIN") ? "&branch_id=".$inward['branch_id']."" :"";?>" class="badge badge-warning" data-toggle="tooltip" title="Inward Details"><i class="fa fa-eye"></i></a>
                                    
                                </span>
                            <?php 
                        } ?>
                    </td>
                    <td><?php echo !empty($inward['customer_name'] ) ? $inward['customer_name'] :'NA'; ?></td>
                    <td><?php echo !empty($inward['inward_date']) ?  dateDB2SHOW($inward['inward_date']) :'-'; ?></td>
                    <td><?php echo !empty($inward['inward_status']) ? $inward['inward_status'] :'-'; ?></td>
                    <td><?php echo !empty($inward['challan']) ? $inward['challan']:'-';?></td>
                    <td><?php echo !empty($inward['outward_date']) ? dateDB2SHOW($inward['outward_date']) :'-' ?></td>
                </tr>
                <?php
                $i++;
            }
            ?>
            </tbody>
        </table>
    </div>
    <?php
} else {
    ?>
    <div class="clearfix"></div>
    <div class="space-4"></div>
    <div  class="text-center text-danger">No Outwards found</div>
    <?php
} ?>
<div class="clearfix"></div>
<?php include currentModuleView('admin').'common_pages/location_search_js.php'?>
<script>
 $(function () {
        $('#frm').validate({
            errorElement: 'div',
            errorClass: 'help-block',
            focusInvalid: false,
            ignore: "",
            rules: {           
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