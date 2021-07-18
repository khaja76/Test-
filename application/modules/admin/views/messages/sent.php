<?php
if (($_SESSION['ROLE'] == "ADMIN") || ($_SESSION['ROLE'] == "SUPER_ADMIN")) {
    $role = "admin";
} elseif ($_SESSION['ROLE'] == "RECEPTIONIST") {
    $role = "reception";
} else {
    $role = "engineer";
}
?>
<h3 class="header smaller lighter">
    Messages - Sent
    <span class="pull-right">
    <a class="btn btn-xs btn-warning" href="<?php echo base_url().$role ?>/messages/compose/">
        <i class="white ace-icon fa fa-commenting bigger-120"></i>
        Compose
    </a>
    <a class="btn btn-xs btn-info" href="<?php echo base_url().$role ?>/messages/inbox/">
        <i class="white ace-icon fa fa-envelope bigger-120"></i>
        Inbox
    </a>
</span>
</h3>
<?php echo getMessage(); ?> 
<div class="mt-m10"></div>
<form class="form-inline text-center" id="frm" action="" enctype="multipart/form-data" method="get">
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
        <button type="submit" class="btn btn-xs btn-primary"><i class="fa fa-envelope-o"></i> Get Messages</button>
        <a href="<?php echo get_role_based_link()?>/messages/" class="btn btn-xs btn-danger"><i class="fa fa-refresh"></i> Refresh </a>
    </div>
</form>
<div class="space-2"></div>
<div class="row">
    <div class="col-xs-12 col-sm-12">

        <table class="table table-bordered table-hover datatable-custom">
            <thead>
            <tr>
                <th>S. No.</th>
                <th>Job Id</th>
                <th>Message To</th>
                <th>Subject</th>
                <th>Description</th>
                <th>Sent Date &amp; Time</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (!empty($messages)) {
                $i = 1;
                foreach ($messages as $inward) { ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td>
                            <input type="hidden" class="inward_pk_id" value="<?php echo !empty($inward['pk_id']) ? $inward['pk_id'] : '0'; ?>"/>
                            <input type="hidden" class="job_id" value="<?php echo !empty($inward['job_id']) ? $inward['job_id'] : '0'; ?>"/>

                          
                            <?php
                            if(!empty($inward['job_id'])){
                                echo $inward['job_id'];
                       
                        } ?>
                        </td>
                        <td><?php echo !empty($inward['receiver']) ? $inward['receiver'] : '-'; ?></td>
                        <td><?php echo !empty($inward['subject']) ? $inward['subject'] : '-'; ?></td>
                        <td><?php echo (!empty($inward['description']) && strlen($inward['description']) >=59) ? substr($inward['description'],0,59).' ......' : $inward['description']; ?></td>
                        <td><?php echo !empty($inward['created_on']) ? dateTimeDB2SHOW($inward['created_on']) : '-'; ?></td>
                        <td><a href="<?php echo get_role_based_link();?>/messages/view/?message=<?php echo !empty($inward['pk_id']) ? $inward['pk_id'] : '-'; ?>" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i> </a> 
                            </td>
                    </tr>
                    <?php
                    $i++;
                }
            } else {
                echo "<tr><td colspan='7'><p class='text-center'> No Message found </p></td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
</div>