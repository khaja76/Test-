<?php $product_name = !empty($branch['name']) ? $branch['name'] : ''; ?>
<div style="width: 100%;float: left;display: block;font-size: 14px; color: #333;background: #f2f2f2; margin: 10px auto; max-width: 640px; padding: 20px 50px;">
    <div style="width:95%;margin: 0 auto;">
        <div style="width:100%;margin-bottom: 15px;">
            <div style="width:50%;float: left;"><h4><?php echo $product_name; ?></h4></div>
            <div style="width:50%;float: left;text-align:right">
                <img src="<?php echo base_url() ?>data/branches/<?php echo !empty($branch['branch_logo']) ? $branch['branch_logo'] : ''; ?>" alt="<?php echo $product_name; ?>" width="100" height="100"/>
            </div>
        </div>
        <div style=" border: 1px solid #fff; border-radius: 6px; background: #FFF; float: left; width: 100%;padding: 15px 30px;">
            <p>Dear <?php echo !empty($customer['last_name']) ? $customer['first_name'] . ' ' . $customer['last_name'] : $customer['first_name']; ?> ( <?php echo $customer['customer_id']; ?> ) ,</p> <br/>
            <p>Your Quotation is <b><?php echo !empty($quotation_email) ? $quotation_email : ""; ?></b> for the following Inwards / Jobs. </p>
            <p>
                <?php
                echo !empty($branch['reference']) ? $branch['reference'] : '';
                ?>
            </p>
            <br/>
            <table style=" border: 1px solid #ddd;border-spacing: 0">
                <thead>
                <tr>
                    <th style="padding: 8px;line-height: 1.42857143;vertical-align: top;border: 1px solid #ddd;">Sr.no</th>
                    <th style="padding: 8px;line-height: 1.42857143;vertical-align: top;border: 1px solid #ddd;" width="300">Job Id</th>
                    <th style="padding: 8px;line-height: 1.42857143;vertical-align: top;border: 1px solid #ddd;" width="300">Description</th>
                    <th style="padding: 8px;line-height: 1.42857143;vertical-align: top;border: 1px solid #ddd;" width="400">Remarks</th>
                    <th style="padding: 8px;line-height: 1.42857143;vertical-align: top;border: 1px solid #ddd;" width="100">Amount</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (!empty($quotation['quotation_items'])) {
                    $i = 1;
                    foreach ($quotation['quotation_items'] as $inward) {
                        ?>

                        <tr>
                            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border: 1px solid #ddd;"><?php echo $i; ?></td>
                            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border: 1px solid #ddd;">
                                <h4><b><?php echo $inward['job']; ?></b></h4>

                            </td>
                            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border: 1px solid #ddd;">
                                <div>
                                    <span class="small"><?php echo !empty($inward['product']) ? $inward['product'] . ',' : '' ?></span>
                                    <span class="small"><?php echo !empty($inward['manufacturer_name']) ? $inward['manufacturer_name'] . ',' : '' ?></span>
                                </div>
                                <div>
                                    <span class="small"><?php echo !empty($inward['model_no']) ? $inward['model_no'] . ',' : '' ?></span>
                                    <span class="small"><?php echo !empty($inward['serial_no']) ? $inward['serial_no'] . ',' : '' ?></span>

                                </div>
                                <span class="small"><?php echo !empty($inward['description']) ? $inward['description'] : '' ?></span>
                            </td>
                            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border: 1px solid #ddd;"><?php echo !empty($inward['quotation_remarks']) ? $inward['quotation_remarks']:''; ?></td>
                            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border: 1px solid #ddd;"><?php echo $inward['amount']; ?></td>
                        </tr>
                        <?php
                        $i++;
                    }
                }
                ?>
                </tbody>
            </table>
            <br/>
            <p>Please contact at your branch ( <?php echo !empty($branch['name']) ? $branch['name'] : ''; ?>- <?php echo !empty($branch['branch_code']) ? $branch['branch_code'] : ''; ?> ) for more details.</p>
            <p>

            </p>
            <p>Assuring You of Our best Service always-----</p>
            <address>
                <h3><?php echo $product_name; ?></h3>
                <b> Contact :</b> <?php echo !empty($branch['phone_1']) ? $branch['phone_1'] : ''; ?>, <?php echo !empty($branch['mobile_1']) ? $branch['mobile_1'] : ''; ?><br>
                <b>Location :</b> <?php echo !empty($branch['address1']) ? $branch['address1'] : ''; ?>,<br/>
                <?php echo !empty($branch['address2']) ? $branch['address2'] : ''; ?><br/>
                <?php echo !empty($branch['city']) ? $branch['city'] : ''; ?> - <?php echo !empty($branch['pincode']) ? $branch['pincode'] : ''; ?>
            </address>
        </div>
    </div>
</div>