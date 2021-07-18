<h3 class="header smaller lighter">
    Inward Reports
</h3>
<form class="form-inline text-center" action="" enctype="multipart/form-data" method="get">
    <?php
    if ($_SESSION['ROLE'] == 'SUPER_ADMIN') {
        ?>
        <div class="form-group">
            <select name="location_id" id="location_id" class="form-control input-sm">
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
                        <option value="<?php echo $k; ?>" <?php echo (!empty($_GET) && ($k == $_GET['branch_id'])) ? "selected" : "" ?>><?php echo $n; ?></option>
                        <?php
                    }
                } ?>
            </select>
        </div>
        <?php
    } ?>
    <div class="form-group">
        <div class="input-daterange input-group">
            <input type="text" class="input-sm form-control" name="from_date" value="<?php echo !empty($_GET['from_date']) ? $_GET['from_date'] : ''; ?>" placeholder="Select Start Date"/>
            <span class="input-group-addon">
					<i class="fa fa-exchange"></i>
                </span>
            <input type="text" class="input-sm form-control" value="<?php echo !empty($_GET['to_date']) ? $_GET['to_date'] : ''; ?>" name="to_date" placeholder="Select End Date"/>
        </div>
    </div>
    <div class="form-group">
        <select class="form-control input-sm" name="status" id="job_status_change">
            <option value="">-- All --</option>
            <?php if (!empty($status_list)) {
                foreach ($status_list as $status) {
                    ?>
                    <option value='<?php echo $status; ?>'<?php echo (isset($_GET['status']) && $_GET['status'] == $status) ? 'selected' : '' ?>> <?php echo $status; ?></option>
                    <?php
                }
            } ?>
        </select>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-xs btn-primary"><i class="fa fa-files-o"></i> Get Records</button>
    </div>
    <div class="form-group">
        <a href="/admin/reports/export-data/?<?php echo !empty($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : ""; ?>" class="btn btn-xs btn-warning"><i class="fa fa-file-excel-o"></i> Export Data</a>
    </div>
    <a href="<?php echo get_role_based_link() ?>/reports/" class="btn btn-xs btn-danger">Refresh</a>
</form>
<div class="clearfix"></div>
<div class="space"></div>
<table class="table table-bordered table-hover" id="<?php echo !empty($inwards) ? 'dtable' : ''; ?>">
    <thead>
    <tr>
        <th>S. No</th>
        <th>Job Id</th>
        <th>Customer Name</th>
        <th>Inward Date</th>
        <th>Outward Date</th>
        <th>Status</th>
        <th>Amount</th>
        <th>Amount Paid</th>
        <th>Amount Dues</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if (!empty($inwards)) {
        $i = 1;
        foreach ($inwards as $inward) {
            $estimation = !empty($inward['estimation_amt']) ? $inward['estimation_amt'] : 0;
            $paid = !empty($inward['paid_amt']) ? $inward['paid_amt'] : 0;
            $balance = $estimation - $paid;
            ?>
            <tr>
                <td><?php echo $i ?></td>
                <td>
                    <?php echo $inward['job_id'];
                    if (!empty($inward['job_id'])) {
                        ?>
                        <span class="info">
                    <a href="<?php echo base_url() ?>admin/inwards/history/?inward=<?php echo $inward['inward_no'] ?><?php echo ($_SESSION['ROLE'] == 'SUPER_ADMIN') ? '&branch_id=' . $inward['branch_id'] : '' ?>" class="badge badge-success" data-toggle="tooltip" title="Full Information"><i class="fa fa-info"></i></a>
                    <a href="<?php echo base_url() ?>admin/inwards/view/?inward=<?php echo $inward['inward_no'] ?><?php echo ($_SESSION['ROLE'] == 'SUPER_ADMIN') ? '&branch_id=' . $inward['branch_id'] : '' ?>" class="badge badge-warning" data-toggle="tooltip" title="Inward Details"><i class="fa fa-eye"></i></a>
                   </span>
                    <?php } ?>
                </td>
                <td><?php echo !empty($inward['customer_name']) ? $inward['customer_name'] : ''; ?></td>
                <td><?php echo !empty($inward['created_on']) ? dateDB2SHOW($inward['created_on']) : ''; ?></td>
                <td><?php echo !empty($inward['outward_date']) ? dateDB2SHOW($inward['outward_date']) : ''; ?></td>
                <td><?php echo !empty($inward['status']) ? $inward['status'] : '-'; ?></td>
                <td><?php echo !empty($inward['estimation_amt']) ? '<i class="fa fa-inr"></i> ' . $inward['estimation_amt'] : '-'; ?></td>
                <td><?php echo !empty($inward['paid_amt']) ? '<i class="fa fa-inr"></i> ' . $inward['paid_amt'] : '-'; ?></td>
                <td><?php echo '<i class="fa fa-inr"></i> ' . number_format($balance, 2); ?></td>
            </tr>
            <?php
            $i++;
        }
    } else {
        echo "<tr><td colspan='10'><div class='text-center text-danger'>No data found </div></td></tr>";
    }
    ?>
    </tbody>
</table>
<?php //echo !empty($PAGING) ?$PAGING:'';?>
<?php include currentModuleView('admin') . 'common_pages/location_search_js.php' ?>