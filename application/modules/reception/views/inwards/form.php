<div class="space"></div>
<?php echo getMessage(); ?>
<?php include_once currentModuleView('admin').'common_pages/search_customer.php';?>
<div class="space-12"></div>
<div class="row" id="load_data">
    <?php
    if (!empty($customers_data)) {
        $count = count($customers_data);
        if ($count == 1) {
            foreach ($customers_data as $customer) { ?>
                <?php include_once 'form-data.php'; ?>
            <?php }
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
    } elseif (!empty($_GET)) {
        echo "<div class='h5 text-danger text-center'>Sorry, No data found for this Searching Criteria</div>";
    }
    ?>
</div>
<div class="row">
    <div class="job-gallery text-center"></div>
</div>
<script>
    $(document).ready(function () {
        $('.cust_id').on("change",function () {
            var pk_id;
            pk_id = $(this).data('customer-pk-id');
            var url = "<?php echo base_url(); ?>";
            $.ajax({
                url: url+'reception/customers/getCustomerById/',
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
    });
</script>