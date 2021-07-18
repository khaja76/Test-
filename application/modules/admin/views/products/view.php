<style>
    /* Page Styels */
    .carousel-control.left, .carousel-control.right {
        background: none !important;
    }
    .item {
        text-align: center;
        background: #2c6aa04f;
    }
    .item img {
        max-width: 100%;
        margin: 0 auto;
        height: 270px !important;
    }
</style>
<h3 class="header smaller lighter">
    Product Details
    <span class="pull-right">
<a href="#" onclick="goBack();" class="btn btn-xs btn-warning"><i class="fa fa-arrow-left"></i>  Back</a>
</span>
</h3>
<div class="row">
    <?php if (!empty($product)) { ?>
        <div class="col-sm-12">
            <div class="ibox-product product-detail">
                <div class="ibox-content">
                    <div class="row">
                        <?php
                        $imgs = getFiles($product['img_path']);
                        if (!empty($imgs)) {
                            ?>
                            <div class="col-md-5">
                                <div class="product-images slick-initialized slick-slider" role="toolbar">
                                    <div id="myCarousel-product" class="carousel slide" data-ride="carousel">
                                        <!-- Wrapper for slides -->
                                        <div class="carousel-inner">
                                            <?php
                                            $i = 1;
                                            foreach ($imgs as $img) {
                                                $thumb_img = str_replace(FCPATH, '', $img);
                                                $img = str_replace($product['img_path'], '', $thumb_img);
                                                $img = str_replace('thumb_', '', $thumb_img);
                                                ?>
                                                <div class="item <?php echo ($i == 1) ? 'active' : '' ?>">
                                                    <img src="<?php echo base_url() . $img ?>" alt="Product image"/>
                                                </div>
                                                <?php
                                                $i++;
                                            }
                                            ?>
                                        </div>
                                        <!-- Left and right controls -->
                                        <a class="left carousel-control" href="#myCarousel-product" data-slide="prev">
                                            <span class="glyphicon glyphicon-chevron-left"></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="right carousel-control" href="#myCarousel-product" data-slide="next">
                                            <span class="glyphicon glyphicon-chevron-right"></span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php
                        } ?>
                        <div class="col-md-7">
                            <h2 class="font-bold m-b-xs">
                                <?php echo !empty($product['product_name']) ? $product['product_name'] : '' ?>
                                <?php
                                if (!empty($product['is_sold']) && $product['is_sold'] == 'YES') {
                                    $color = 'btn-danger';
                                    $text = 'Sold Out !';
                                    $action = false;
                                } else {
                                    $color = 'btn-success';
                                    $text = 'Available';
                                    $action = true;
                                }
                                if ($_SESSION['ROLE'] != 'RECEPTIONIST') {                                
                                ?>                                
                                <a class="btn <?php echo $color; ?> btn-xs pull-right" data-toggle="tooltip" title="Click here to Sell thi product" <?php echo ($action) ? 'id="updateStockDialog"' : '' ?> data-product-id=<?php echo !empty($product['pk_id']) ? $product['pk_id'] : ''; ?>><?php echo $text ?></a>
                                <?php } ?>
                            </h2>
                            <hr>
                            <div>
                                <?php
                                if ($_SESSION['ROLE'] != 'RECEPTIONIST') {   
                                if (!empty($product['is_sold']) && $product['is_sold'] == 'YES') {
                                    $linkText = "Add To Store";
                                } else {
                                    $linkText = "Edit Product";
                                }
                                ?>
                                <a class="btn btn-primary btn-xs pull-right" href="<?php echo get_role_based_link(); ?>/products/edit/<?php echo $product['pk_id'] ?>"><?php echo $linkText; ?></a>
                            <?php } ?>
                                <h3 class="product-main-price"><i class="fa fa-inr"></i> <?php echo !empty($product['price']) ? number_format($product['price'], 2) : 'NA' ?> </h3>
                            </div>
                            <hr>
                            <h4>Model description</h4>
                            <div class="small text-muted product-description">
                                <?php echo !empty($product['description']) ? $product['description'] : '' ?>
                            </div>
                            <div class="dl-horizontal m-t-md">
                                <table class="table table-responsive table-striped table-bordered">
                                    <thead>
                                    <tr></tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th class="w-140"><span class="text-primary">Company Name</span></th>
                                        <th><?php echo !empty($product['company_name']) ? $product['company_name'] : '' ?></th>
                                    </tr>
                                    <tr>
                                        <th class="w-140"><span class="text-primary">Model No</span></th>
                                        <th><?php echo !empty($product['model_no']) ? $product['model_no'] : '' ?></th>
                                    </tr>
                                    <tr>
                                        <th class="w-140"><span class="text-primary">Serial no</span></th>
                                        <th><?php echo !empty($product['serial_no']) ? $product['serial_no'] : '' ?></th>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox-footer">
                        <span class="pull-right">
                        <input type="hidden" id="pName" value="<?php echo !empty($product['product_name']) ? $product['product_name'] : '' ?>"/>
                            <b>Added on -</b> <i class="fa fa-clock-o"></i> <?php echo !empty($product['created_on']) ? dateTimeDB2SHOW($product['created_on']) : '' ?>
                            <b class="blue">Created By -</b> <i class="fa fa-user"></i> <?php echo !empty($product['created_by']) ? $product['created_by'] : '' ?>
                        </span>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<div class="hide updateStockModel">
    <div class="row">
        <div class="col-md-12">
            <form action="" id="updateStatus" method="post">
                <div class="form-group">
                    <label class="control-label">Product Name </label>
                    <b class="pName blue"></b>
                    <input type="hidden" class="prodcut_id" name="product_id"/>
                </div>
                <div class="form-group">
                    <label class="control-label">Remarks</label>
                    <textarea name="remarks" class="form-control" rows="2" cols="35">
                    </textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-sm updateStockBtn">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="table-header">
            Usage History
        </div>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Sr.no</th>
                <th>Remarks</th>
                <th>Sold by</th>
                <th>Sold Date</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (!empty($product['history'])) {
                $i = 0;
                foreach ($product['history'] as $history) {
                    $i++;
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo !empty($history['remarks']) ? $history['remarks'] : ''; ?></td>
                        <td><?php echo !empty($history['sold_by']) ? $history['sold_by'] : ''; ?></td>
                        <td><?php echo !empty($history['sold_date']) ? dateTimeDB2SHOW($history['sold_date']) : ''; ?></td>
                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='4' class='text-center text-danger'>No data found !</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(function () {
        $("#updateStockDialog").on('click', function (e) {
            e.preventDefault();
            var product_id = $(this).data('product-id');
            var pro_name = $('#pName').val();
            $('.prodcut_id').val(product_id);
            $('.pName').html(pro_name);
            $(".updateStockModel").removeClass('hide').dialog({
                resizable: false,
                width: '400',
                modal: true,
                title: "<div class='widget-header'><h5 class='smaller'><i class='ace-icon fa fa-tasks'></i> Update Status</h5></div>",
                title_html: true
            });
        });
        $('#updateStatus').on('submit', function () {
            var product_id = $(this).data('product-id');
            var th = $(this);
            var formData = th.serialize();
            $.ajax({
                type: 'POST',
                cache: false,
                data: formData,
                url: '<?php echo base_url() ?>' + 'admin/products/updateProductStatus/',
                success: function (response) {
                    console.log(response)
                }
            });
        });
    });
</script>