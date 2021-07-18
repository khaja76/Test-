<?php $inward=$message; ?>
<h3 class="header smaller lighter">
    View Message
    <span class="pull-right">
         <a class="btn btn-xs btn-warning" href="#" onclick="goBack();">
            <i class="white ace-icon fa fa-arrow-left bigger-120"></i>
       Back
        </a>
    </span>
</h3>
<?php echo getMessage() ?>
<div class="row">
    <div class="col-md-12">
        <div class="widget-box">
            <div class="widget-header widget-header-flat">
                <h4 class="widget-title">
                    <span class="font-normal">Subject: </span><?php echo $message['subject']; ?>
                </h4>
                <ul class="list-inline">
                    <li><h5 class="red">Sender : <?php echo $message['sender'] ?></h5></li>
                    <li><h5 class="green">Receiver : <?php echo $message['receiver'] ?></h5></li>
                    <?php if(!empty($message['job_id'])){?>
                      <li><h5 class="blue">Job Id :<?php echo $message['job_id']; ?></span></h5></li>
                    <?php }?>
                    <li class="pull-right red"><i class="fa fa-clock-o"></i> <?php echo dateTimeDB2SHOW($message['created_on'])?></li>
                </ul>
             
            </div>
            <div class="widget-body">
                <div class="widget-main">
                    <div class="row">
                        <div class="col-md-12">
                            <p>Description : <?php echo $message['description'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(function(){
    $('.info').css('visibility','visible');
});
</script>