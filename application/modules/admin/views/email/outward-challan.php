<?php $product_name = 'Hifi Technologies' ?>
<div style="width: 85%;float: left;display: block;font-size: 14px; color: #333;background: #f2f2f2; margin: 10px auto; max-width: 640px; padding: 20px 50px;">
    <div style="width:90%;margin: 0 auto;">
        <div style="width:100%;margin-bottom: 15px;">
            <div style="width:50%;float: left;">
                <h4>
                    <?php
                    if (!empty($branch_data['name'])) {
                        if (strtolower($branch_data['name']) == 'hifi technologies') {
                            echo "<img src='" . base_url() . "assets/h.png' alt='logo'  width='150'/>";
                        } else {
                            echo $branch_data['name'];
                        }
                    }
                    ?>
                </h4>
            </div>
            <div style="width:50%;float: left;text-align:right">
                <img src="<?php echo base_url() ?>data/branches/<?php echo !empty($branch_data['branch_logo']) ? $branch_data['branch_logo']:'';?>" alt="<?php echo $product_name; ?>" width="200" height="100"/></div>
        </div>
        <div style=" border: 1px solid #fff; border-radius: 6px; background: #FFF; float: left; width: 91%;padding: 15px 30px;">
            <p>Dear <?php echo !empty($customer['last_name']) ? $customer['first_name'].' '.$customer['last_name'] : ""; ?> ( <?php echo $customer['customer_id'];?> ) ,</p> <br/>
            <p>Your Delivery Challan  is <b><?php echo !empty($challan['challan']) ? $challan['challan'] : ""; ?></b>. </p>
            <br/>
            <table style=" border: 1px solid #ddd;border-spacing: 0">
                <thead>
                <tr>
                    <th style="padding: 8px;line-height: 1.42857143;vertical-align: top;border: 1px solid #ddd;">Sr.no</th>
                    <th style="padding: 8px;line-height: 1.42857143;vertical-align: top;border: 1px solid #ddd;" width="250">Job Id</th>
                    <th style="padding: 8px;line-height: 1.42857143;vertical-align: top;border: 1px solid #ddd;" width="300">Remarks</th>
                    <th style="padding: 8px;line-height: 1.42857143;vertical-align: top;border: 1px solid #ddd;" width="300">Description</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (!empty($outwards)) {
                    $i = 1;
                    foreach ($outwards as $inward) {
                        ?>
                        <tr>
                            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border: 1px solid #ddd;"><?php echo $i; ?></td>
                            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border: 1px solid #ddd;"><?php echo $inward['job_id']; ?></td>
                            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border: 1px solid #ddd;"><?php echo $inward['remarks']; ?></td>
                            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border: 1px solid #ddd;"><?php echo $inward['description']; ?></td>
                        </tr>
                        <?php
                        $i++;
                    }
                }
                ?>
                </tbody>
            </table>
            <br/>
            <p>Please contact at your branch ( <?php echo !empty($branch_data['name']) ? $branch_data['name'] : ''; ?>-<?php echo !empty($branch_data['branch_code']) ? $branch_data['branch_code'] : ''; ?> ) for more details.</p>
            <p>
            </p>
            <address>
                <h3><?php echo $product_name; ?></h3>
                <b> Contact :</b> <?php echo !empty($branch_data['phone_1']) ? $branch_data['phone_1'] : ''; ?>, <?php echo !empty($branch_data['mobile_1']) ? $branch_data['mobile_1'] : ''; ?><br>
                <b>Location :</b> <?php echo !empty($branch_data['address1']) ? $branch_data['address1'] : ''; ?>,<br/>
                <?php echo !empty($branch_data['address2']) ? $branch_data['address2'] : ''; ?><br/>
                <?php echo !empty($branch_data['city']) ? $branch_data['city'] : ''; ?> - <?php echo !empty($branch_data['pincode']) ? $branch_data['pincode'] : ''; ?>
            </address>
        </div>
    </div>
</div>
