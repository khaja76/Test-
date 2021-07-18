
<?php
$j = !empty($i) ? $i : '';
if (!empty($inward)) {
        $close = false;
    ?>
    <h3 class="header smaller lighter">
        Edit Inward
        <span class="pull-right">

        <a href="#" onclick="goBack()" class="btn btn-xs btn-warning"><i class="fa fa-arrow-left"></i> Back</a>
    </span>
    </h3>
    <div class="panel panel-primary">
        <div class="row padding-10 no-margin">
            <div class="col-md-4 col-xs-12">
                <div class="text-center">
                    <div class="space-6"></div>
                    <div id="accordion" class="accordion-style1 panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#customerInfo<?php echo $j; ?>">
                                        <i class="ace-icon fa fa-angle-<?php echo ($close) ? 'right' : 'down' ?> bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                        Customer Information
                                    </a>
                                </h4>
                            </div>

                            <div class="panel-collapse collapse <?php echo ($close) ? '' : 'in' ?>" id="customerInfo<?php echo $j; ?>">

                                <div class="panel-body">
                                    <div class="profile-user-info profile-user-info-striped">
                                        <div class="profile-info-row">
                                            <div class="profile-info-name">Id</div>
                                            <div class="profile-info-value">
                                                <span><?php echo !empty($inward['customer_id']) ? $inward['customer_id'] : ''; ?></span>
                                            </div>
                                        </div>
                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Name</div>
                                            <div class="profile-info-value">
                                                <span><?php echo !empty($inward['customer_name']) ? $inward['customer_name'] : ''; ?></span>
                                            </div>
                                        </div>
                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Photo</div>
                                            <div class="profile-info-value">
                                                <?php
                                                if (!empty($inward['img']) && file_exists(FCPATH . $inward['customer_path'] . $inward['img'])) {
                                                    $img = $inward['customer_path'] . $inward['img'];
                                                    $thumb_img = $inward['customer_path'] . "thumb_" . $inward['img'];
                                                }
                                                if (!empty($img)) { ?>
                                                    <div class="gallery">
                                                        <a href="<?php echo base_url() . $img; ?>">
                                                            <img src="<?php echo base_url() . $thumb_img; ?>" class="max-200" alt="customer name"/>
                                                        </a>
                                                    </div>
                                                <?php } else { ?>
                                                    <div id="img-preview">
                                                        <img src="<?php echo dummyLogo(); ?>" alt="customer name"/>
                                                    </div>
                                                <?php }
                                                ?>
                                            </div>
                                        </div>
                                        <?php
                                        if (!empty($inward['company_name'])) {
                                            ?>
                                            <div class="profile-info-row">
                                                <div class="profile-info-name">Company</div>
                                                <div class="profile-info-value">
                                                    <span><?php echo !empty($inward['company_name']) ? $inward['company_name'] : ''; ?></span>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Inwards-->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#inwards<?php echo $j; ?>">
                                        <i class="ace-icon fa fa-angle-<?php echo (!$close) ? 'right' : 'down' ?> bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                        &nbsp;Inward Images
                                    </a>
                                </h4>
                            </div>
                            <div class="panel-collapse collapse <?php echo (!$close) ? '' : 'in' ?>" id="inwards<?php echo $j; ?>">
                                <div class="panel-body">
                                    <?php $imgs = getFiles($inward['img_path']);
                                    if (!empty($imgs)) { ?>
                                        <div class="gallery">
                                            <?php
                                            foreach ($imgs as $img) {
                                                $thumb_img = str_replace(FCPATH, '', $img);
                                                $img = str_replace($inward['img_path'], '', $thumb_img);
                                                $img = str_replace('thumb_', '', $thumb_img);
                                                ?>
                                                <div style="display: inline-block">
                                                    <a href="<?php echo base_url() . $img ?>">
                                                        <img src="<?php echo base_url() . $thumb_img ?>" class="max-150 p-1" alt="Inward Image"/>
                                                    </a>
                                                    <span data-img = "<?php echo $img; ?>" data-thumb = "<?php echo $thumb_img; ?>" class="remove">Remove</span>
                                                </div>

                                            <?php } ?>
                                        </div>
                                        <?php
                                    } else {
                                        echo "<span class='text-center text-danger'>No Inward Images were Found</span>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <!--Damage Images-->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#damage<?php echo $j; ?>">
                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                        &nbsp;Damaged Images
                                    </a>
                                </h4>
                            </div>
                            <div class="panel-collapse collapse " id="damage<?php echo $j; ?>">
                                <div class="panel-body">
                                    <?php
                                    if (!empty($inward['damage_img_path'])) {
                                        $imgs = getFiles($inward['damage_img_path']);
                                        if (!empty($imgs)) { ?>
                                            <div class="gallery">
                                                <?php
                                                foreach ($imgs as $img) {
                                                    $thumb_img = str_replace(FCPATH, '', $img);
                                                    $img = str_replace($inward['img_path'], '', $thumb_img);
                                                    $img = str_replace('thumb_', '', $thumb_img);
                                                    ?>
                                                    <a href="<?php echo base_url() . $img ?>">
                                                        <img src="<?php echo base_url() . $thumb_img ?>" class="max-150 p-1" alt="Inward Image"/>
                                                    </a>
                                                <?php } ?>
                                            </div>
                                            <?php
                                        }
                                    } else {
                                        echo "<span class='text-center text-danger'>No Damaged Images were Found</span>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <!-- Outward Images -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#outward<?php echo $j; ?>">
                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                        &nbsp;Outward Images
                                    </a>
                                </h4>
                            </div>
                            <div class="panel-collapse collapse " id="outward<?php echo $j; ?>">
                                <div class="panel-body">

                                    <?php
                                    if (!empty($inward['outward_images_path'])) {
                                        $imgs = getFiles($inward['outward_images_path']);
                                        if (!empty($imgs)) { ?>
                                            <div class="gallery">
                                                <?php
                                                foreach ($imgs as $img) {
                                                    $thumb_img = str_replace(FCPATH, '', $img);
                                                    $img = str_replace($inward['outward_images_path'], '', $thumb_img);
                                                    $img = str_replace('thumb_', '', $thumb_img);
                                                    ?>
                                                    <a href="<?php echo base_url() . $img ?>">
                                                        <img src="<?php echo base_url() . $thumb_img ?>" class="max-150 p-1" alt="Outward Image"/>
                                                    </a>
                                                <?php } ?>
                                            </div>
                                            <?php
                                        }
                                    } else {
                                        echo "<span class='text-center text-danger'>No Outward Images were Found</span>";
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8  col-xs-12">
                <h5>Product Information</h5>
                <form class="form-horizontal" id="frm" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="inward_id" value="<?php echo !empty($inward['pk_id']) ? $inward['pk_id'] : '' ?>"/>

                    <div class="row">
                        <div class="col-md-6">
                            <label> Product <sup class="text-danger">*</sup>:</label>
                            <input class="form-control input-sm required" name="product" placeholder="Enter Product Name"  value="<?php echo !empty($inward['product']) ? $inward['product'] : '' ?>"/>
                        </div>
                        <div class="col-md-6">
                            <label> Model Number <sup class="text-danger">*</sup>:</label>
                            <input class="form-control input-sm required" name="model_no" placeholder="Enter Model Number"  value="<?php echo !empty($inward['model_no']) ? $inward['model_no'] : '' ?>" />
                        </div>
                    </div>
                    <div class="space-6"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <label> Manufacturer <sup class="text-danger">*</sup>:</label>
                            <input class="form-control input-sm required" name="manufacturer_name" placeholder="Enter Manufacturer Name"  value="<?php echo !empty($inward['manufacturer_name']) ? $inward['manufacturer_name'] : '' ?>" />
                        </div>
                        <div class="col-md-6">
                            <label> Serial Number <sup class="text-danger">*</sup>:</label>
                            <input class="form-control input-sm required" name="serial_no" type="text" placeholder="Enter Serial Number"  value="<?php echo !empty($inward['serial_no']) ? $inward['serial_no'] : '' ?>" />
                        </div>
                    </div>
                    <div class="space-6"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <label> Remarks :</label>
                            <textarea class="form-control input-sm" name="remarks" placeholder="Enter Remarks"><?php echo !empty($inward['remarks']) ? $inward['remarks'] : '' ?></textarea>
                        </div>
                        <div class="col-md-6">
                            <label> Accessories :</label>
                            <textarea class="form-control input-sm" name="description" placeholder="Enter Description"><?php echo !empty($inward['description']) ? $inward['description'] : '' ?></textarea>
                        </div>
                    </div>
                    <div class="space-6"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <label> Gate Pass No :</label>

                            <input type="text" id="gatepass_no" class="form-control input-sm "  name="gatepass_no" placeholder="Gate Pass no"  value="<?php echo !empty($inward['gatepass_no']) ? $inward['gatepass_no'] : '' ?>"/>
                        </div>
                        <div class="col-md-6">
                            <label> Received From :</label>
                            <input type="text" id="inward_dispatch_through" class="form-control input-sm "  name="inward_dispatch_through"  value="<?php echo !empty($inward['inward_dispatch_through']) ? $inward['inward_dispatch_through'] : '' ?>"/>
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
                                <button type="submit" class="btn btn-xs btn-success"><i class="fa fa-floppy-o"></i> Save</button>
                            </div>
                        </div>
                    </div>

                    <!--<button type="submit" class="btn btn-xs btn-success"><i class="fa fa-floppy-o"></i> Save</button>-->
                </form>
                <div class="row">
                    <div class="job-gallery text-center"></div>
                </div>
            </div>

        </div>
        <div class="space-10"></div>

    </div>
<?php } else{
    echo "<div class='text-danger text-center'>Sorry, No Job Id Found with searching Data</div>";
} ?>

<script>
    $(document).ready(function(){
        $("body").on('click','.remove',function () {
            var thumb,img;
            var th = $(this);
            thumb = th.data('thumb');
            img = th.data('img');
            var base_url="<?php echo base_url();?>";
            $.ajax({
                type : 'POST',
                url : base_url+'admin/removeImages/',
                data : {'thumb':thumb,'img':img},
                success : function(data){
                    th.parent('div').hide();
                }
            });
        });
    })
</script>