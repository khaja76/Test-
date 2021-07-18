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
    Current Messages - Inbox
    <span class="pull-right">
        <a class="btn btn-xs btn-warning" href="<?php echo base_url().$role ?>/messages/compose/">
            <i class="white ace-icon fa fa-commenting bigger-120"></i>
            Compose
        </a>
        <a class="btn btn-xs btn-primary" href="<?php echo base_url().$role ?>/messages/sent/">
            <i class="white ace-icon fa fa-paper-plane-o bigger-120"></i>
            Sent

        </a>
    </span>
</h3>
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
    <div class="col-xs-12 col-sm-12 ">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>S. No.</th>
                <th>Job Id</th>
                <th>Message From</th>
                <th>Subject</th>
                <th>Description</th>
                <th>Received Date &amp; Time</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (!empty($messages)) {
                $i = 1;
                foreach ($messages as $message) { ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td>

                            <?php echo !empty($message['job_id']) ? $message['job_id'] : '-'; ?>
                            <?php if(!empty($message['job_id'])){?>
                            <span class="info">
                              <a href="<?php echo base_url().$role ?>/inwards/history/?inward=<?php echo !empty($message['inward_no']) ? $message['inward_no'] : '001' ?>" class="badge badge-success" data-toggle="tooltip" title="Full Information"><i class="fa fa-info"></i></a>
                                <a href="<?php echo base_url().$role ?>/inwards/view/?inward=<?php echo !empty($message['inward_no']) ? $message['inward_no'] : '001' ?>" class="badge badge-warning" data-toggle="tooltip" title="Inward Details"><i class="fa fa-eye"></i></a>
                            </span>
                            <?php }?>

                        </td>
                        <td><?php echo !empty($message['sender']) ? $message['sender'] : '-'; ?></td>
                        <td><?php echo !empty($message['subject']) ? $message['subject'] : '-'; ?>...</td>
                        <td><?php echo (!empty($message['description']) && strlen($message['description']) >=59) ? substr($message['description'],0,59).'...' : $message['description']; ?></td>
                        <td><?php echo !empty($message['created_on']) ? dateTimeDB2SHOW($message['created_on']) : '-'; ?></td>
                        <td><a href="<?php echo base_url().$role ?>/messages/view/?message=<?php echo !empty($message['pk_id']) ? $message['pk_id'] : '-'; ?>"  class="btn btn-xs btn-primary"><i class="fa fa-eye"></i> </a></td>
                           
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