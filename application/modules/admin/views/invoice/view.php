
<style>
.spaced > li{
    margin-top:2px;
    margin-bottom:2px;
}
.m-0{
    margin:0;
}
</style>
<h3 class="header smaller lighter">
    Invoice Information
    <span class="pull-right">
        <a href="/admin/invoice" class="btn btn-xs btn-warning"><i class="fa fa-arrow-left"></i> Back</a>
        <a  data-toggle="modal" data-target="#SmsModal" href="#send-mail/?pk_id=<?php echo $invoice['pk_id'];?>" class="btn  btn-xs btn-primary"> <i class="fa fa-envelope-o"></i> Send Message</a>
        <a target="_blank"  href="<?php echo get_role_based_link();?>/invoice/invoice-print/<?php echo !empty($invoice['pk_id']) ? $invoice['pk_id']:''?>" class="btn btn-xs btn-info"><i class="fa fa-print"></i> Print</a>
    </span>
</h3>
<div class="clearfix"></div>
<div class="space-6"></div>
<?php  include 'common.php'?>
<?php include_once 'send-message.php' ?>


