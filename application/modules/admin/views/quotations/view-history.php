<h3 class="header smaller lighter">
    Quotation Details
    <span class="pull-right">    
        <a class="btn btn-xs btn-warning" href="#" onclick="goBack();" >Back</a>
        <a target="_blank" href="<?php echo base_url(); ?>admin/quotations/history-print/<?php echo !empty($quotation) ? $quotation['pk_id'] : '' ?>" class="btn btn-xs btn-info"> <i class="fa fa-print"></i> Print</a>
    </span>
</h3>
<?php echo getMessage(); ?>
<?php include 'common.php' ?>

