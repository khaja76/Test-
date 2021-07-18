<?php $product_name = !empty($branch_data['name']) ? $branch_data['name'] : 'HiFi Technologies'; ?>
<div style="width: 85%;float: left;display: block;font-size: 14px; color: #333;background: #f2f2f2; margin: 10px auto; max-width: 640px; padding: 20px 50px;">
    <div style="width:90%;margin: 0 auto;">
        <div style="width:100%;margin-bottom: 15px;">
            <div style="width:50%;float: left;"><h4><?php echo $product_name; ?></h4></div>
            <div style="width:50%;float: left;text-align:right">
                <?php
                if (!empty($branch_data['branch_logo'])){
                ?>
                <img src="<?php echo base_url() ?>data/branches/<?php echo $branch_data['branch_logo'] ?>" alt="<?php echo $product_name; ?>" width="100" height="100"/></div>
            <?php
            }else {
            ?>
            <img src="<?php echo base_url() ?>data/logo-md.jpg" alt="<?php echo $product_name; ?>" width="100" height="100"/></div>
        <?php
        }
        ?>
    </div>
    <div style=" border: 1px solid #fff; border-radius: 6px; background: #FFF; float: left; width: 91%;padding: 15px 30px;">

        <p>Dear <?php echo !empty($last_name) ? $first_name . ' ' . $last_name : $first_name; ?>,</p> <br/>
        <p>Greetings from <?php echo $product_name; ?>,</p><br/>
        <p>Thanks for choosing our Industrial Electronic Repair Center <?php echo $product_name; ?>. Your customer ID is generated as <b><?php echo !empty($customer_id) ? $customer_id : ""; ?></b></p>
        <p>Your Registered Phone Number is <b><?php echo !empty($mobile) ? $mobile : ""; ?></b> . </p>

        <br/>
        <p>Assuring You of Our best Service always-----</p>
        <p><?php echo $product_name; ?> Care Team</p>
    </div>
</div>
</div>