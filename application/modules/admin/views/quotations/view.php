<h3 class="header smaller lighter">
    Quotation Details
    <span class="pull-right">    
        <a class="btn btn-xs btn-warning" href="<?php echo base_url().'admin/quotations/'?>">Back</a>
        <a  data-toggle="modal" data-target="#SmsModal" href="#send-mail/?pk_id=<?php echo $quotation['pk_id'];?>" class="btn  btn-xs btn-primary"> <i class="fa fa-envelope-o"></i> Send Message</a>
        <a target="_blank" href="<?php echo base_url(); ?>admin/quotations/quotation-print/<?php echo !empty($quotation) ? $quotation['pk_id'] : '' ?>" class="btn btn-xs btn-info"> <i class="fa fa-print"></i> Print</a>
    </span>
</h3>
<?php echo getMessage(); ?>
<?php include 'common.php' ?>
<?php include_once 'send-message.php' ?>
