<a data-toggle="dropdown" class="dropdown-toggle" href="#">
    <i class="ace-icon fa fa-bell icon-animated-bell"></i>
    <span class="badge badge-important"><?php echo $notification_cnt; ?></span>
</a>
<ul class="dropdown-menu-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
    <li class="dropdown-header">
        <i class="ace-icon fa fa-exclamation-triangle"></i>
        <?php echo $notification_cnt . " Notification"; ?>
    </li>
    <?php if ($notification_cnt > 0) { ?>
        <li class="dropdown-content">
            <ul class="dropdown-menu dropdown-navbar navbar-pink">
                <?php foreach ($notifications as $notification) { ?>
                    <li class="pos-rel">
                        <a href="<?php echo base_url() ?>admin/notifications/?notification_id=<?php echo $notification['pk_id'] ?>">
                            <i class="btn btn-xs btn-primary fa fa-user"></i>
                            <?php echo !empty($notification['title']) ? $notification['title'] : ''; ?>
                        </a>
                        <div class="pull-right">
                            <span class="skip-single pos-abs" data-id="<?php echo $notification['pk_id'] ?>">Skip</span>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </li>
        <li class="dropdown-footer">
            <div class="pull-left">
                <a href="<?php echo base_url() ?>admin/notifications/?view=unread">
                    See All
                </a>
            </div>
            <div class="pull-right">
                <span class="skip_all" data-user_id="<?php echo !empty($notification['user_id']) ? $notification['user_id'] : ''; ?>"> Skip All </span>
            </div>
        </li>
    <?php } ?>
</ul>
