<?php $product_name = 'Hifi Technologies' ?>
<div style="width: 85%;float: left;display: block;font-size: 14px; color: #333;background: #f2f2f2; margin: 10px auto; max-width: 640px; padding: 20px 50px;">
    <div style="width:90%;margin: 0 auto;">
        <div style="width:100%;margin-bottom: 15px;">
            <div style="width:50%;float: left;"><h4><?php echo $product_name; ?></h4></div>
            <div style="width:50%;float: left;text-align:right">
                <img src="<?php echo base_url() ?>data/logo-md.jpg" alt="<?php echo $product_name; ?>" width="200" height="100"/></div>
        </div>
        <div style=" border: 1px solid #fff; border-radius: 6px; background: #FFF; float: left; width: 91%;padding: 15px 30px;">
            <p>Dear <?php echo !empty($to_name) ? $to_name : ""; ?>,</p> <br/>
            <p>Your current Password is <b><?php echo !empty($password) ? $password : ""; ?></b>. </p>
            <p>Other wise you can change your <?php echo $product_name; ?> Account password by clicking the below URL</p>
            <p>
                <b><a href="<?php echo base_url(); ?>reset-password/?reset=<?php echo !empty($reset_token) ? $reset_token : ""; ?>">Click here</a></b> to Reset Password
            </p><br/>
            <p>See you soon on <?php echo $product_name; ?></p>
            <p><?php echo $product_name; ?> Care Team</p>
        </div>
    </div>
</div>
