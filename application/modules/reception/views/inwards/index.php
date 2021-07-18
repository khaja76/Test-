<div class="clearfix"></div>
<div class="space-6"></div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-6">
        <form class="form-inline text-center" id="search_inward">
            <div class="form-group">
                <label for="job_id"><sup class="text-danger">*</sup> Job Id :</label>
            </div>
            <div class="form-group">
                <input class="form-control input-sm"  id="job_id" autofocus="autofocus"  name="job_id" type="text" placeholder="Enter Job Id" value="<?= !empty($_GET['job_id']) ? $_GET['job_id'] : ''; ?>" required/>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-xs btn-primary search_inbtn"><i class="fa fa-files-o"></i> View Details</button>
            </div>
        </form>
    </div>
    <div class="col-md-6">
        <form class="form-inline" method="get">
            <div class="form-group">
                <label for="email"><span class="text-danger">*</span>Select Option:</label>
                <?php $types = ["customer_id" => "Customer ID", "email" => "Email ID", "mobile" => "Mobile No", "name" => "Name"]; ?>
                <select name="select_type" class="form-control customer_option input-sm">
                    <?php foreach ($types as $k => $v) { ?>
                        <option value="<?php echo $k; ?>" <?php echo !empty($_GET['select_type']) && ($_GET['select_type'] == $k) ? "selected='selected'" : ''; ?>><?php echo $v; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <input class="form-control input-sm" id="cust_value" autofocus="autofocus" name="name" type="text" placeholder="Enter Your Input" value="<?php echo !empty($_GET['name']) ? $_GET['name'] : '' ?>" required/>
            </div>
            <button type="submit" class="btn btn-xs btn-primary <?php echo (!empty($_SESSION) && (($_SESSION['ROLE']!='ADMIN') || ($_SESSION['ROLE']!='SUPER_ADMIN')))  ? 'custSearchBtn':''?>"><i class="fa fa-search"></i> Search</button>
        </form>
    </div>
</div>
<div class="clearfix"></div>
<div class="space-6"></div>
<div class="row">
    <div class="col-md-12">
       <div id="load_data">
                  
           <?php include_once currentModuleView('admin') . 'common_pages/product_info.php' ?>
            <?php
                if (!empty($customers_data)) {
                    $count = count($customers_data);
                    if ($count == 1) {
                        foreach($customers_data as $customer){
                             
                           include_once currentModuleView('reception').'customers/inwards.php';
                        }
                    } else { ?>
                        <div class="col-md-6 col-md-offset-3">
                            <table class="table table-bordered table-hover text-center">
                                <thead>
                                <tr>
                                    <th class="text-center w-30px"></th>
                                    <th class="text-center w-60px">S. No.</th>
                                    <th class="text-center w-80px">Customer Id</th>
                                    <th class="text-center w-80px">Customer Name</th>
                                    <th class="text-center">Profile Pic</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i = 1;
                                foreach ($customers_data as $customer) { ?>
                                    <tr>
                                        <td class="text-center"><label>
                                                <input name="form-field-radio" type="radio" class="ace cust_id" data-customer-pk-id="<?php echo $customer['pk_id'] ?>" data-customer-id="<?php echo $customer['customer_id'] ?>">
                                                <span class="lbl"></span>
                                            </label></td>
                                        <td><?php echo $i ?></td>
                                        <td><?php echo $customer['customer_id'] ?></td>
                                        <td><?php echo !empty($customer['customer_name']) ? $customer['customer_name'] : '' ?></td>
                                        <td class="text-center">
                                            <?php if (!empty($customer['img']) && file_exists(FCPATH . $customer['img_path'] . $customer['thumb_img'])) {
                                                $img = base_url() . $customer['img_path'] . $customer['img'];
                                                $thumb_img = base_url() . $customer['img_path'] . "thumb_" . $customer['img'];
                                                ?>
                                                <div class="gallery">
                                                    <a href="<?php echo $img; ?>">
                                                        <img class="width-height-50" src="<?php echo $thumb_img; ?>"/>
                                                    </a>
                                                </div>
                                            <?php } else { ?>
                                                <img src="<?php echo dummyLogo() ?>" class="width-height-50"/>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php $i++;
                                } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php }
                }
            ?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.cust_id').on("change",function () {
            var pk_id;
            pk_id = $(this).data('customer-pk-id');
            
            var url = "<?php echo base_url(); ?>";
            $.ajax({
                url: url+'reception/customers/getCustomerAndInwardsByCId/',
                data : {'pk_id':parseInt(pk_id)},
                type : 'POST',
                success : function(data){
                    $("#load_data").html(data);
                },
                beforeSend: function(){
                    // Handle the beforeSend event
                    var loader = $($.parseHTML('<p>')).addClass('loader');
                    $($.parseHTML('<img>')).attr('src', '/data/icons/loading.gif').addClass('loader_img').appendTo(loader);
                    loader.prependTo('#load_data');
                },
                complete: function(){
                    // Handle the complete event
                    $("body").find('.loader').remove();
                }
            })
        });
        if($('#job_id').val().length<3){
            $('.search_inbtn').prop('disabled', true);
        }
        
        $('#job_id').on('keyup', function() {
            if($(this).val().length >= 3) {
                $('.search_inbtn').prop('disabled', false);
            } else {
                $('.search_inbtn').prop('disabled', true);
            }
        });
        if($('#cust_value').val().length<3){
            $('.custSearchBtn').prop('disabled', true);
        }
       
        $('#cust_value').on('keyup', function() {
            if($(this).val().length >= 3) {
                $('.custSearchBtn').prop('disabled', false);
            } else {
                $('.custSearchBtn').prop('disabled', true);
            }
        });
    });
</script>