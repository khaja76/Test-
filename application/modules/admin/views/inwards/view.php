<h3 class="header smaller lighter">
    View Inward
    <span class="pull-right">
        <?php if(!empty($inward) && ($inward['is_outwarded'] == 'NO')){ ?>
            <a href="<?php echo base_url() ?>admin/inwards/edit/<?php echo !empty($inward['pk_id']) ? $inward['pk_id'] : ''; ?>" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i> Edit</a>
        <?php } ?>
        <a href="#" onclick="goBack()" class="btn btn-xs btn-warning"><i class="fa fa-arrow-left"></i> Back</a>
    </span>
</h3>
<?php echo getMessage(); ?>
<?php include currentModuleView('admin')."common_pages/product_info.php"; ?>
