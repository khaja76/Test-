<style>
.alert.alert-danger{
    word-break: break-word;
    }
</style>
<h3 class="header smaller lighter">
    Imported Data Details
    <span class="pull-right">
            <a href="<?php echo base_url(); ?>admin/import/upload-inwards/" class="btn btn-info btn-sm">Import</a>
    </span>
</h3>
<?php echo getMessage() ?>
<form class="form-inline text-center mt-m10" method="get" id="frm">
    <div class="form-group">
        <?php $status = array('R' => 'Repaired', 'IR' => 'Irreparable', 'S' => 'Sent As It Is','P'=>'Pending'); ?>
        <select class="form-control input-sm" name="status">
            <option value="ALL">ALL</option>
            <?php
            foreach ($status as $key => $value) {
                ?>
                <option value="<?php echo $key;?>" <?php echo (!empty($_GET['status']) && ($key==$_GET['status'])) ? 'selected' : ''?>><?php echo $value;?></option>
                <?php
            }
            ?>
        </select>
    </div>
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
        <a href="<?php echo base_url(); ?>admin/import/inwards/" class="btn btn-xs btn-danger"><i class="fa fa-refresh"></i> Refresh</a>
    </div>
</form>
<div class="space-2"></div>
<table class="table  table-bordered table-hover" id="<?php echo !empty($inwards) ? 'dtable' : ''; ?>">
    <thead>
    <tr>
        <th>S.No</th>
        <th>Customer Name</th>
        <th>Mobile</th>
        <th width="190">Job Id</th>
        <th>Description</th>
        <th>Problem</th>
        <th>Estimation</th>
        <th>Payment</th>
        <th>Inward Date</th>
        <th>Status</th>
        <td>Action</td>
    </tr>
    </thead>
    <tbody>
    <?php
    if (!empty($inwards)) {
        $i = 1;
        foreach ($inwards as $inward) {
            ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo !empty($inward['customer_details']) ? $inward['customer_details'] : '-'; ?></td>
                <td><?php echo !empty($inward['mobile']) ? $inward['mobile']:'-';?></td>
                <td><?php echo !empty($inward['job_id']) ? $inward['job_id'] : '-'; ?></td>
                <td><?php echo !empty($inward['description']) ? $inward['description'] : '-'; ?></td>
                <td><?php echo !empty($inward['problem']) ? $inward['problem'] : '-'; ?></td>
                <td><?php echo !empty($inward['estimation']) ? $inward['estimation'] : '-'; ?></td>
                <td><?php echo !empty($inward['payment']) ? $inward['payment'] : '-'; ?></td>
                <td><?php echo !empty($inward['created_on']) ? dateDB2SHOW($inward['created_on']) : '-'; ?></td>
                <td><?php echo !empty($inward['status']) ? $inward['status'] : '-'; ?></td>
                <td><a href="<?php echo get_role_based_link(); ?>/import/edit-inward/<?php echo $inward['pk_id']; ?>" title='Edit' class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="bottom"><i class="ace-icon fa fa-pencil bigger-120"></i></a></td>
            </tr>
            <?php $i++;
        }
    } else {
        ?>
        <tr>
            <td class="text-center" colspan="11">No Inward Found</td>
        </tr>
        <?php
    } ?>
    </tbody>
</table>
