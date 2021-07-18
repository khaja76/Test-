<?php
if(!empty($inward['job_id']))
{
    echo $inward['job_id'];
    ?>
        <span class="info">
            <a href="<?php echo get_role_based_link(); ?>/inwards/history/?inward=<?php echo $inward['inward_no']; ?><?php echo (!empty($_SESSION) && $_SESSION["ROLE"]=="SUPER_ADMIN") ? "&branch_id=".$inward['branch_id']."" :"";?>" class="badge badge-success" data-toggle="tooltip" title="Full Information"><i class="fa fa-info"></i></a>
            <a href="<?php echo get_role_based_link(); ?>/inwards/view/?inward=<?php echo $inward['inward_no']; ?><?php echo (!empty($_SESSION) && $_SESSION["ROLE"]=="SUPER_ADMIN") ? "&branch_id=".$inward['branch_id']."" :"";?>" class="badge badge-warning" data-toggle="tooltip" title="Inward Details"><i class="fa fa-eye"></i></a>
        </span>
    <?php 
} ?>