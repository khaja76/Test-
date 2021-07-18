<span class="msg"></span>
<h3 class="header smaller lighter hidden-print">
    Outwards List
    <span class="pull-right">
        <a class="btn btn-xs btn-warning" href="<?php echo get_role_based_link() ?>/outwards/">
                    <i class="white ace-icon fa fa-arrow-left bigger-120"></i>
                  Back
     </a>
    <a target="_blank" href="<?php echo get_role_based_link() ?>/outwards/challan-print/?challan=<?php echo (!empty($challan['pk_id'])) ? $challan['pk_id'] : '' ?>" class="btn btn-xs btn-success">
                    <i class="white ace-icon fa fa-print bigger-120"></i>
                  Print
     </a>
    </span>
</h3>
<?php include_once 'common.php'; ?>
