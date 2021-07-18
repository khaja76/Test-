<!--<div class="col-md-12">
<div class="6">
</div>
</div>
--><?php if (!empty($customer)) { ?>
    <div class="col-md-4">
        <h4>Customer Information</h4>
        <div class="profile-user-info profile-user-info-striped">
            <div class="profile-info-row">
                <div class="profile-info-name"> Customer Id</div>
                <div class="profile-info-value">
                    <span><?php echo !empty($customer['customer_id']) ? $customer['customer_id'] : ''; ?></span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Customer Name</div>
                <div class="profile-info-value">
                    <span><?php echo !empty($customer['customer_name']) ? $customer['customer_name'] : ''; ?></span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Customer Photo</div>
                <div class="profile-info-value">
                    <?php
                    if (!empty($customer['img']) && file_exists(FCPATH . $customer['img_path'] . $customer['img'])) {
                        $img = base_url() . $customer['img_path'] . $customer['img'];
                        $thumb_img = base_url() . $customer['img_path'] . "thumb_" . $customer['img'];
                        ?>
                        <div class="gallery">
                            <a href="<?php echo $img; ?>">
                                <img src="<?php echo $thumb_img; ?>" class="max-150" alt="customer name"/>
                            </a>
                        </div>
                    <?php } else { ?>
                        <img src="<?php echo dummyLogo(); ?>" class="max-150" alt="customer name"/>
                    <?php }
                    ?>
                </div>
            </div>
            <?php
            if (!empty($customer['company_name'])) {
                ?>
                <div class="profile-info-row">
                    <div class="profile-info-name">Company Name :</div>
                    <div class="profile-info-value">
                        <span><?php echo !empty($customer['company_name']) ? $customer['company_name'] : '-'; ?></span>
                    </div>
                </div>

                <?php
                if (!empty($_SESSION['ROLE']) && $_SESSION['ROLE'] != 'RECEPTIONIST') {
                    ?>
                    <div class="profile-info-row">
                        <div class="profile-info-name"> GST No. :</div>
                        <div class="profile-info-value">
                            <span><?php echo !empty($customer['gst_no']) ? $customer['gst_no'] : '-'; ?></span>
                        </div>
                    </div>
                    <div class="profile-info-row">
                        <div class="profile-info-name"> Person Name :</div>
                        <div class="profile-info-value">
                            <span><?php echo !empty($customer['contact_name']) ? $customer['contact_name'] : '-'; ?></span>
                        </div>
                    </div>
                    <div class="profile-info-row">
                        <div class="profile-info-name"> Email :</div>
                        <div class="profile-info-value">
                            <span><?php echo !empty($customer['company_mail']) ? $customer['company_mail'] : '-'; ?></span>
                        </div>
                    </div>
                    <div class="profile-info-row">
                        <div class="profile-info-name"> Phone No :</div>
                        <div class="profile-info-value">
                            <span><?php echo !empty($customer['company_mobile']) ? $customer['company_mobile'] : '-'; ?></span>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>

        </div>

    </div>
    <div class="col-md-8">
        <h4>Inwards</h4>
        <div class="space-2"></div>
        <table class="table  table-bordered table-hover" id="<?php echo !empty($inwards) ? 'dtable' : ''; ?>">
            <thead>
            <tr>
                <th>S.No</th>
                <th>Job Id</th>
                <th>Customer Name</th>
                <th>Inward Date</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (!empty($inwards)) {
                $i = 1;
                foreach ($inwards as $inward) {
                    ?>

                    <tr>
                        <td><?php echo $i; ?></td>
                        <td>
                            <?php include currentModuleView('admin') . 'common_pages/inward-view-url.php' ?>
                        </td>
                        <td><?php echo !empty($inward['customer_name']) ? $inward['customer_name'] : '--'; ?></td>
                        <td><?php echo !empty($inward['created_on']) ? dateDB2SHOW($inward['created_on']) : '--'; ?></td>
                        <td><?php echo !empty($inward['status']) ? $inward['status'] : '-'; ?></td>
                    </tr>
                    <?php $i++;
                }
            } else {
                ?>
                <tr>
                    <td class="text-center" colspan="8">No Inward Found</td>
                </tr>
                <?php
            } ?>
            </tbody>
        </table>
    </div>
<?php } ?>
<script>
    $(document).ready(function () {
        $("table tr").hover(function () {
            $(this).find('.info').css("visibility", "visible");
        }).mouseleave(function () {
            $(this).find('.info').css("visibility", "hidden");
        });
    });
</script>