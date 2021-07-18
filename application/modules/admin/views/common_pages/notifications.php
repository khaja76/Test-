<?php
if (($_SESSION['ROLE'] == "ADMIN") || ($_SESSION['ROLE'] == "SUPER_ADMIN")) {
    $role = "admin";
} elseif ($_SESSION['ROLE'] == "RECEPTIONIST") {
    $role = "reception";
} else {
    $role = "engineer";
}
?>
<style>
    .media .media-body {
        display: block !important;
    }

    .search-media {
        margin-bottom: 5px;
    }

    .unread:hover {
        text-decoration: none;
    }

    .mlr-n-10 {
        margin-left: -10px;
        margin-right: -10px;
    }
</style>
<h3 class="header smaller lighter">
    Notifications
    <span class="pull-right">
        <a class="btn btn-xs btn-info" href="<?php echo base_url() ?>admin/notifications/?view=all">
            <i class="white ace-icon fa fa-th bigger-120"></i> View All
        </a>
        <a class="btn btn-xs btn-danger" href="<?php echo base_url() ?>admin/notifications/">
            <i class="white ace-icon fa fa-refresh bigger-120"></i> Refresh
        </a>
    </span>
</h3>
<div class="clearfix"></div>
<div class="">
    <div class="col-md-12">
        <div class="col-md-8 col-md-offset-2">
            <form action="" class="text-center form-inline" method="GET">
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
<!--                    <a href="--><?php //echo base_url(); ?><!--admin/notifications/" class="btn btn-xs btn-danger"><i class="fa fa-refresh"></i> Refresh</a>-->
                </div>
            </form>
        </div>
        <div class="clearfix"></div>
        <div class="space"></div>
    </div>
</div>
<div class="clearfix"></div>
<div class="space-2"></div>
<div class="clearfix"></div>
<?php if (!empty($notification)) { ?>
    <div class="row">
        <div class="col-sm-12 mt-m10">
            <div class="well">
                <div class="media  no-border">
                    <div class="media-body">
                        <div>
                            <h4 class="media-heading green">
                                <?php echo !empty($notification['title']) ? $notification['title'] : '' ?>
                            </h4>
                        </div>
                        <p><?php echo !empty($notification['type']) ? $notification['type'] : '' ?></p>
                        <div class="action-buttons-list bigger-25">
                            <i class="ace-icon fa fa-map-marker blue"></i> Branch : <?php echo !empty($notification['branch_name']) ? $notification['branch_name'] : '' ?>
                            <i class="ace-icon fa fa-user blue"></i> Created by : <?php echo !empty($notification['created_by']) ? $notification['created_by'] : '' ?>
                            <i class="ace-icon fa fa-clock-o blue"></i> <?php echo !empty($notification['created_on']) ? dateTimeDB2SHOW($notification['created_on']) . '' : '' ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<div class="clearfix"></div>
<div class="row">
    <div class="col-sm-12 mt-m10">
        <?php
        if (!empty($notification_cnt)) { 
            $ntfTitle = (!empty($_GET['view']) && ($_GET['view']=='all')) ? 'All Notifications' : 'Unread Notifications';            
            ?>
            <h4><?php echo $ntfTitle; ?> (<?php echo !empty($notification_cnt) ? $notification_cnt : '0' ?>)</h4>
        <?php }
        if (!empty($notifications)) {
            foreach ($notifications as $notif) {
                ?>
                <div class="mlr-n-10">
                    <div class="col-md-6">
                        <div class="media search-media border-red">
                            <div class="media-body">
                                <div>
                                    <a href="<?php echo base_url() . $role . '/notifications/?notification_id=' . $notif['pk_id'] ?>" class="blue unread">
                                        <h5 class="media-heading <?php echo (!empty($notif['is_viewed']) && $notif['is_viewed'] == 'YES') ? 'green' : 'red ' ?>">
                                            <?php echo !empty($notif['title']) ? $notif['title'] : '' ?>
                                        </h5>
                                    </a>
                                </div>
                                <p><?php echo !empty($notif['type']) ? $notif['type'] : '' ?></p>
                                <div class="action-buttons-list bigger-25">
                                    <i class="ace-icon fa fa-map-marker blue"></i> Branch : <?php echo !empty($notif['branch_name']) ? $notif['branch_name'] : '' ?>
                                    <i class="ace-icon fa fa-user blue"></i> Created by : <?php echo !empty($notif['created_by']) ? $notif['created_by'] : '' ?>
                                    <i class="ace-icon fa fa-clock-o blue"></i> <?php echo !empty($notif['created_on']) ? dateDB2SHOW($notif['created_on']) . '' : '' ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            echo (!empty($PAGING)) ? $PAGING : '';
            ?>
            <?php
        } else if (!isset($_GET['notification_id'])) {
            echo "<h4 class='text-danger text-center'>You haven't received any new notifications !</h4>";
        }
        ?>
    </div>
</div>