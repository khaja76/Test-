<style>
    #serial_no-error {
        display: block !important;
    }
    .mceEditor td.mceIframeContainer iframe {
        min-height: 350px !important;
    }
    .mceEditor table {
        height: auto !important;
    }
</style>
<h3 class="header smaller">
    Add Products
    <span class="pull-right">
        <button type="submit" form="frm" class="btn btn-xs btn-success"><i class="fa fa-floppy-o"></i> Save</button>
        <a href="#" onclick="goBack();" class="btn btn-xs btn-warning"><i
                    class="fa fa-arrow-left"></i> Back</a>
    </span>
</h3>
<span class="pull-right text-danger">
    * Fields are mandatory 
</span>
<form class="form-horizontal" id="frm" method="post" enctype="multipart/form-data">
    <input type="hidden" name="pk_id" value="<?php echo !empty($product['pk_id']) ? $product['pk_id'] : ''; ?>"/>
    <div class="col-md-12">
        <?php echo getMessage(); ?>
        <div class="row">
            <!--<div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-5"><sup class="text-danger">*</sup>Category :</label>
                    <div class="col-md-7">
                        <?php /*if(!empty($categories)){*/?>
                        <select class="form-control input-sm" name="category_id">
                            <option value="">--Select Category--</option>
                            <?php /*foreach($categories as $key=>$name){
                               */?>
                                <option value="<?php /*echo $key;*/?>" <?php /*echo (!empty($product['category_id']) && ($product['category_id']==$key)) ? 'selected' :''*/?>><?php /*echo $name;*/?></option>
                            <?php
/*                            }*/?>
                        </select>
                        <?php /*}else{*/?>
                            <a href="<?php /*echo get_role_based_link().'/products/category/add';*/?>" class="btn btn-info btn-xs">Add Product Category</a>
                        <?php /*}*/?>
                    </div>
                </div>
            </div>-->
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-5"><sup class="text-danger">*</sup>Product Type:</label>
                    <div class="col-md-7">
                        <input class="form-control input-sm" id="product_type"   name="product_type" value="<?php echo !empty($product['product_type']) ? $product['product_type'] : ''; ?>" placeholder="Add/Select Product type"/>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-5"><sup class="text-danger">*</sup>Company Name :</label>
                    <div class="col-md-7">
                        <input class="form-control input-sm" id="company_name"   name="company_name" value="<?php echo !empty($product['company_name']) ? $product['company_name'] : ''; ?>" placeholder="Add Company Name"/>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-5"><sup class="text-danger">*</sup>Product Name :</label>
                    <div class="col-md-7">
                        <input class="form-control input-sm" id="product_name" name="product_name" value="<?php echo !empty($product['product_name']) ? $product['product_name'] : ''; ?>" placeholder="Add Product"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-5"><sup class="text-danger">*</sup>Model Number :</label>
                    <div class="col-md-7">
                        <input class="form-control input-sm" name="model_no" value="<?php echo !empty($product['model_no']) ? $product['model_no'] : ''; ?>" placeholder="Enter Model No">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-5"><sup class="text-danger">*</sup>Serial Number :</label>
                    <div class="col-md-7">
                        <input class="form-control input-sm required" id="serial_no" name="serial_no" value="<?php echo !empty($product['serial_no']) ? $product['serial_no'] : ''; ?>" placeholder="Enter Serial No">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10">
                <div class="form-group">
                    <label class="control-label col-md-3">Model Details :</label>
                    <div class="col-md-9">
                        <textarea rows="17" cols="110" name="description" class="form-control input-sm ckeditor" placeholder="Enter Model Details"><?php echo !empty($product['description']) ? $product['description'] : ''; ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-5">Product Cost :</label>
                    <div class="col-md-7">
                        <input class="form-control input-sm" name="price" onkeypress="return isNumber(event);" value="<?php echo !empty($product['price']) ? $product['price'] : ''; ?>" placeholder="Product Cost">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-5">Product Condition (Optional):</label>
                    <div class="col-md-7">
                        <input class="form-control input-sm" name="product_condition"   value="<?php echo !empty($product['product_condition']) ? $product['product_condition'] : ''; ?>" placeholder="Product Condition">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-5">Product Shipping Info (Optional) :</label>
                    <div class="col-md-7">
                        <input class="form-control input-sm" name="shipping"  value="<?php echo !empty($product['shipping']) ? $product['shipping'] : ''; ?>" placeholder="Product Shipping">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-5">Delivery Estimation :</label>
                    <div class="col-md-7">
                        <div class="input-group">
                            <input class="form-control input-sm" name="delivery_estimation" onkeypress="return isNumber(event);" value="<?php echo !empty($product['delivery_estimation']) ? $product['delivery_estimation'] : ''; ?>" placeholder="Product Delivery Estimation">
                            <div class="input-group-addon">
                                Days
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-5">Product Return ( Optional) :</label>
                    <div class="col-md-7">
                        <input class="form-control input-sm" name="returns"  value="<?php echo !empty($product['returns']) ? $product['returns'] : ''; ?>" placeholder="Product Returns info">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-5">Product Warranty :</label>
                    <div class="col-md-7">
                        <input class="form-control input-sm" name="warranty" value="<?php echo !empty($product['delivery_estimation']) ? $product['warranty'] : ''; ?>" placeholder="Product Warranty">
                    </div>
                </div>
            </div>
            <?php if (!empty($product['is_sold']) && $product['is_sold'] == 'YES') { ?>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-5">Add To Store :</label>
                        <div class="col-md-7">
                            <input class="ace" name="add" type="checkbox" value="add"/>
                            <label class="lbl"></label>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-5">Product Images :</label>
                    <div class="col-md-7">
                        <input type="file" name="photo[]" class="input-file-2 inward_imgs" multiple="multiple" accept=".png, .jpg, .gif">
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<div class="row">
    <div class="col-md-12 text-center">
        <?php
        if (!empty($product) && !empty($product['img_path'])) {
            $imgs = getFiles($product['img_path']);
            if (!empty($imgs)) { ?>
                <div class="gallery">
                    <?php
                    foreach ($imgs as $img) {
                        $thumb_img = str_replace(FCPATH, '', $img);
                        $img = str_replace($product['img_path'], '', $thumb_img);
                        $img = str_replace('thumb_', '', $thumb_img);
                        ?>
                        <a href="<?php echo base_url() . $img ?>">
                            <img src="<?php echo base_url() . $thumb_img ?>" class="max-200 p-1" alt="Product Image"/>
                        </a>
                    <?php } ?>
                </div>
                <?php
            } else {
                echo "No Product Images were Found";
            }
        }
        ?>
    </div>
    <input type="hidden" class="base_url" value="<?php echo base_url();?>"/>
</div>
<div class="row">
    <div class="job-gallery text-center"></div>
</div>
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>
    $(function(){
        var base_url=$('.base_url').val();
        tinymce.init({
            selector: "textarea.ckeditor",
            theme: "modern",
            plugins: ["advlist  autolink lists link image  imagetools charmap print preview anchor", "searchreplace visualblocks code fullscreen", "insertdatetime media table contextmenu paste"],
            convert_urls: false,
            content_css: 'http://skin.tinymce.com/css/preview.content.css',
            toolbar: "insertfile undo redo code | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | upload ",
            images_upload_url: base_url+'home/upload-post-image',
            images_dataimg_filter: function(img) {
                return img.hasAttribute('internal-blob');
            },
        });
    })
</script>
<script>
    $(document).ready(function () {
        $('#frm').validate({
            errorElement: 'div',
            errorClass: 'help-block',
            focusInvalid: false,
            ignore: "",
            rules: {
                company_name: {required: true},
                product_name: {required: true},
                model_no: {required: true},
                serial_no: {
                    required: true,
                    <?php if(empty($product)){ ?>
                    remote: "<?php echo base_url() ?>" + "admin/products/check-product/"
                    <?php } ?>
                }
            },
            messages: {
                serial_no: {
                    remote: "This serial number already exists !"
                }
            },
            highlight: function (e) {
                $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
            },
            success: function (e) {
                $(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
                $(e).remove();
            }
        });
        var companies = [<?php if(!empty($companies)){
            $count = count($companies);
            $i = 1;
            foreach($companies as $k=>$v){ ?>
            {
                key: "<?php echo $k ?>",
                value: "<?php echo $v ?>"
            }
            <?php
            echo ($i == $count) ? '' : ',';
            $i++;
            }
            } ?>];
        // Auto Completion Script
        $("#company_name").autocomplete({
            minLength: 0,
            source: companies,
            focus: function (event, ui) {
                $("#company_name").val(ui.item.value);
                return false;
            },
            select: function (event, ui) {
                $("#company_name").val(ui.item.value);
                return false;
            }
        }).autocomplete("instance")._renderItem = function (ul, item) {
            return $("<li>")
                .append("<div>" + item.value + "</div>")
                .appendTo(ul);
        };
        $("#product_name").on("focus", function () {
            var th = $(this);
            var val = $("#company_name").val();
            var $data = [];
            $.ajax({
                url: '<?php echo base_url() ?>' + '/admin/products/getProductsList/',
                data: {'company_name': val},
                type: 'POST',
                dataType: 'json',
                cache: false,
                success: function (data) {
                    if (data) {
                        $.each(data, function (key, val) {
                            console.log();
                            $data.push({value: val});
                        });
                        log($data);
                    }
                },
                error: function () {
                    // $("#product_id").val('');
                }
            });
            $("#product_name").autocomplete({
                minLength: 0,
                source: $data,
                focus: function (event, ui) {
                    $("#product_name").val(ui.item.value);
                    return false;
                },
                select: function (event, ui) {
                    $("#product_name").val(ui.item.value);
                    return false;
                }
            }).autocomplete("instance")._renderItem = function (ul, item) {
                return $("<li>")
                    .append("<div>" + item.value + "</div>")
                    .appendTo(ul);
            };
        });
        function log($data) {
            return $data;
        }
    })
</script>
