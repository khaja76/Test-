<h3 class="header smaller lighter">
    Search Inward
    <span class="pull-right">
        <?php if(!empty($inward) && ($inward['is_outwarded'] == 'NO')){ ?>
            <a href="<?php echo get_role_based_link();?>/inwards/edit/<?php echo !empty($inward['pk_id']) ? $inward['pk_id'] : ''; ?>" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i> Edit</a>
        <?php } ?>
        <a href="#" onclick="goBack()" class="btn btn-xs btn-warning"><i class="fa fa-arrow-left"></i> Back</a>
    </span>
</h3>
<?php include currentModuleView('reception')."inwards/index.php"; ?>
