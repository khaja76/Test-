<div class="col-md-12">
<div class="6">
</div>
</div>
<?php if (!empty($customer)) { ?>
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
        }
        ?>

    </div>

</div>
<div class="col-md-8">
    <h4>Product Information</h4>
    <form class="form-horizontal" id="frm1" method="post" enctype="multipart/form-data">
        
        <input type="hidden" name="customer_id" class="customer_id" value="<?php echo !empty($customer['customer_id']) ? $customer['customer_id'] : '' ?>"/>
        <input type="hidden" name="cpk_id" class="cpk_id" value="<?php echo !empty($customer['pk_id']) ? $customer['pk_id'] : '' ?>"/>

        <div class="row">
            <div class="col-md-6">
                <label> Product <sup class="text-danger">*</sup>:</label>
                <input class="form-control input-sm required" name="product" placeholder="Enter Product Name"/>
            </div>
            <div class="col-md-6">
                <label> Model Number <sup class="text-danger">*</sup>:</label>
                <input class="form-control input-sm required" name="model_no" placeholder="Enter Model Number"/>
            </div>
        </div>
        <div class="space-6"></div>
        <div class="row">
            <div class="col-md-6">
                <label> Manufacturer <sup class="text-danger">*</sup>:</label>
                <input class="form-control input-sm required" name="manufacturer_name" placeholder="Enter Manufacturer Name"/>
            </div>
            <div class="col-md-6">
                <label> Serial Number <sup class="text-danger">*</sup>:</label>
                <input class="form-control input-sm required" name="serial_no" type="text" placeholder="Enter Serial Number"/>
            </div>
        </div>
        <div class="space-6"></div>
        <div class="row">
            <div class="col-md-6">
                <label> Remarks :</label>
                <textarea class="form-control input-sm" name="remarks" placeholder="Enter Remarks"></textarea>
            </div>
            <div class="col-md-6">
                <label> Accessories :</label>
                <textarea class="form-control input-sm" name="description" placeholder="Enter Description"></textarea>
            </div>
        </div>
        <div class="space-6"></div>
        <div class="row">
            <div class="col-md-6">
                <label> Gate Pass No :</label>
                
                <input type="text" id="gatepass_no" class="form-control input-sm "  name="gatepass_no" placeholder="Gate Pass no" value="<?php echo isset($_SESSION['inward']['gatepass_no']) ? $_SESSION['inward']['gatepass_no'] :''?>"/>
            </div>
            <div class="col-md-6">
                <label> Received From :</label>
                <input type="text" id="inward_dispatch_through" class="form-control input-sm "  name="inward_dispatch_through" value="<?php echo isset($_SESSION['inward']['inward_dispatch_through']) ? $_SESSION['inward']['inward_dispatch_through']:''?>"/>
            </div>
        </div>
        <div class="space-6"></div>
        <div class="row">
            <div class="col-md-4">
                <label> Upload Images :</label>
                <input type="file" name="photo[]" class="input-file-2 inward_imgs" multiple="multiple" accept=".png, .jpg, .gif">
            </div>
           
            <div class="col-md-4">
                <div class="space-12"></div>
                <div class="form-group">
                    <button type="submit" class="btn btn-xs btn-success btn-save"><i class="fa fa-floppy-o"></i> Save</button>
                </div>
            </div>
            <div class="col-md-4">
                <!--capture throght camera-->
            </div>
        </div>


    </form>

</div>
<?php } ?>
<script>
$(document).ready(function () {
    
    $('#frm1').validate();
    $('.btn-save').click(function(){
        if($('#frm1').valid()) {
            $(this).attr({
                'type': 'button',
                'disabled': true,
            });
            $('#frm1').submit();
        }
    });
});
</script>