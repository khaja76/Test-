<h3 class="header smaller lighter">
    Customers
    <span class="pull-right">
    <?php if ($_SESSION['ROLE'] == 'ADMIN') { ?>
        <a href="<?php echo get_role_based_link(); ?>/customers/add/" class="btn btn-primary btn-xs"> <i
                    class="fa fa-plus"></i> Add </a>
    <?php } ?>
    </span>
</h3>
<?php echo getMessage(); ?>

<div class="mt-m10">

    <form class="form-inline text-center" id="frm" method="get">

        <?php if (!empty($_SESSION) && $_SESSION['ROLE'] == 'ADMIN') { ?>
            <div class="form-group">
                <label for="email">Select Option:</label>
                <?php $types = ["customer_id" => "Customer ID", "email" => "Email ID", "mobile" => "Mobile No", "name" => "Name"]; ?>
                <select name="select_type" class="form-control customer_option input-sm">
                    <?php foreach ($types as $k => $v) { ?>
                        <option value="<?php echo $k; ?>" <?php echo !empty($_GET['select_type']) && ($_GET['select_type'] == $k) ? "selected='selected'" : ''; ?>><?php echo $v; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <input class="form-control input-sm" id="filter" name="name" type="text" placeholder="Enter Your Input"
                       value="<?php echo !empty($_GET['name']) ? $_GET['name'] : '' ?>" required/>
            </div>
        <?php } else if ($_SESSION['ROLE'] == 'SUPER_ADMIN') {
            ?>
            <div class="form-group">
                <select name="location_id" id="location_id" class="form-control input-sm">
                    <option value="">-- Select Location Name --</option>
                    <?php if (!empty($locations)) {
                        foreach ($locations as $key => $name) { ?>
                            <option value="<?php echo $key; ?>" <?php echo (!empty($_GET['location_id']) && ($key == $_GET['location_id'])) ? "selected" : "" ?>><?php echo $name; ?></option>
                        <?php }
                    } ?>
                </select>
            </div>
            <div class="form-group">
                <select name="branch_id" id="branch_id" class="form-control input-sm">
                    <option value="">-- Select Branch Name --</option>
                    <?php if (!empty($branches)) {
                        foreach ($branches as $k => $n) { ?>
                            <option value="<?php echo $k; ?>"><?php echo $n; ?></option>
                        <?php }
                    } else if (!empty($branches)) {
                        echo "<option value=''>No Branch found</option>";
                    } else if ($branches_else) {
                        foreach ($branches_else as $k => $n) {
                            ?>
                            <option value="<?php echo $k; ?>" <?php echo (!empty($_GET) && ($k == $_GET['branch_id'])) ? "selected" : "" ?>><?php echo $n; ?></option>
                            <?php
                        }
                    } ?>
                </select>
            </div>
            <?php
        } ?>
        <button type="submit"
                class="btn btn-xs btn-primary <?php (!empty($_SESSION) && (($_SESSION['ROLE'] != 'ADMIN') || ($_SESSION['ROLE'] != 'SUPER_ADMIN'))) ? 'custSearchBtn' : '' ?>">
            <i class="fa fa-search"></i> Search
        </button>
        <a href="<?php echo base_url() ?>admin/customers/" class="btn btn-danger btn-xs">Refresh</a>
        <button type="button" class="btn btn-success createMSGBtn btn-xs pull-left" data-toggle="modal"
                data-target="#SENDSMS">Create Message
        </button>
    </form>
</div>
<div class="space-4"></div>
<?php if ((!empty($_GET['location_id']) && ($_SESSION['ROLE'] == "SUPER_ADMIN")) || ($_SESSION['ROLE'] == "ADMIN")) { ?>
    <table class="table table-bordered table-hover" <!--id="--><?php /*echo !empty($customers) ? 'dtable' : ''; */ ?>">
    <thead>
    <tr>
        <th>S. No.</th>
        <th><input type="checkbox" class="ace" id="_checkAll"/>
            <label class="lbl"></label></th>
        <th>Customer Id</th>
        <th>Customer Name</th>
        <th>Email</th>
        <th>Phone No</th>
        <?php if ($_SESSION['ROLE'] == 'SUPER_ADMIN') { ?>
            <th>City</th>
            <th>State</th>
        <?php } ?>
        <th>Profile Pic</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if (!empty($customers)) {
        $i = 1;
        foreach ($customers as $customer) { ?>
            <tr>
                <td><?php echo $i ?></td>
                <td>

                    <input type="checkbox" class="ace checkCustForSMS" name="sms_cust_ids[]"
                           value="<?php echo $customer['pk_id'] ?>"/>
                    <label class="lbl"></label>
                </td>
                <td>
                    <a href="<?php echo base_url(); ?>admin/customers/view/<?php echo $customer['pk_id'] ?>"><?php echo !empty($customer['customer_id']) ? $customer['customer_id'] : ''; ?></a>
                </td>
                <td><?php echo !empty($customer['last_name']) ? $customer['first_name'] . ' ' . $customer['last_name'] : $customer['first_name']; ?></td>
                <td><?php echo !empty($customer['email']) ? $customer['email'] : ''; ?></td>
                <td><?php echo !empty($customer['mobile']) ? $customer['mobile'] : ''; ?></td>
                <?php if ($_SESSION['ROLE'] == 'SUPER_ADMIN') { ?>
                    <td><?php echo !empty($customer['city']) ? $customer['city'] : ''; ?></td>
                    <td><?php echo !empty($customer['state']) ? $customer['state'] : ''; ?></td>
                <?php } ?>
                <td>
                    <?php if (!empty($customer['img']) && file_exists(FCPATH . $customer['img_path'] . $customer['thumb_img'])) { ?>
                        <div class="gallery">
                            <a href="<?php echo base_url() . $customer['img_path'] . $customer['img']; ?>">
                                <img src="<?php echo base_url() . $customer['img_path'] . $customer['thumb_img']; ?>"
                                     class="width-height-50" alt="profile photo"/>
                            </a>
                        </div>
                    <?php } else { ?>
                        <img src="<?php echo dummyLogo() ?>" class="width-height-50"/>
                    <?php } ?>
                </td>
                <td>
                    <a href="<?php echo base_url(); ?>admin/customers/edit/<?php echo $customer['pk_id'] ?>"
                       class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>
                </td>
            </tr>
            <?php $i++;
        }
    } else { ?>
        <tr>
            <td class='text-center' colspan='<?php echo ($_SESSION['ROLE'] == 'SUPER_ADMIN') ? 9 : 7; ?>'>
                <div class="text-center text-danger">No data found</div>
            </td>
        </tr>
        <?php
    }
    ?>
    </tbody>
    </table>
    <div class="text-center"><?php echo !empty($PAGING) ? $PAGING : ''; ?></div>
<?php } ?>


<?php include currentModuleView('admin') . 'common_pages/location_search_js.php' ?>


<!-- Modal -->
<div id="SENDSMS" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Send Message</h4>
            </div>
            <div class="modal-body">
                <form method="post" id="SMS_form">
                    <input type="hidden" name="SMS_cust" id="SMS_cust" class="SMS_cust"/>
                    <div class="form-group">
                        <label for="SMS_custContent">Message</label>
                        <textarea id="SMS_custContent" class="SMS_custContent form-control" required
                                  name="SMS_custContent"></textarea>
                        <span class="text-success SMS_success"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-xs" data-dismiss="modal">Close</button>
                <button type="submit" form="SMS_form" class="btn btn-success btn-xs btn_SMS_Cust">Send</button>
            </div>
        </div>

    </div>
</div>
<script>
    $(function () {
        $('.custSearchBtn').prop('disabled', true);
        $('#filter').on('keyup', function () {
            if ($(this).val().length >= 3) {
                $('.custSearchBtn').prop('disabled', false);
            } else {
                $('.custSearchBtn').prop('disabled', true);
            }
        });
        <?php
        if(!empty($_SESSION['ROLE']) && $_SESSION['ROLE'] == 'SUPER_ADMIN'){
        ?>
        $('#frm').validate({
            errorElement: 'div',
            errorClass: 'help-block',
            focusInvalid: false,
            ignore: "",
            rules: {
                location_id: {required: true}

            },

            highlight: function (e) {
                $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
            },

            success: function (e) {
                $(e).closest('.form-group').removeClass('has-error');
                $(e).remove();
            },
            invalidHandler: function (form) {
            }
        });
        <?php
        }
        ?>
        $('.createMSGBtn').addClass('hide');
        $('.checkCustForSMS').on('change', function () {
            var chkd = $('.checkCustForSMS:checked');
            if (chkd.length >= 1) {
                $('.createMSGBtn').removeClass('hide');
            }
            var vals = chkd.map(function () {
                return this.value;
            })
                .get().join(', ');
            $('.SMS_cust').val(vals);

        });
        $('#SMS_form').on('submit', function (e) {
            e.preventDefault();
            $('.btn_SMS_Cust').attr({
                'type': 'button',
                'disabled': true
            }).text('Please wait..');
            $.ajax({
                url: '<?php echo get_role_based_link();?>/customers/send-sms/',
                type: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    $('.SMS_success').text('Message sent successfully !');
                    setTimeout(function () {
                        $('.SMS_cust,.SMS_custContent').val('');
                        $('.btn_SMS_Cust').attr({
                            'type': 'submit',
                            'disabled': false
                        }).text('Send');
                        $("input[type=checkbox]").each(function () {
                            $(this).prop("checked", false);
                        });

                        $('.btn_SMS_Cust').attr('data-dismiss', 'modal').trigger('click');
                        $('.SMS_success').text('');
                    }, 2000);

                }
            });
        });
        $('#_checkAll').on('click',function(){
            if(this.checked){
                $('.createMSGBtn').removeClass('hide');
                $('.checkCustForSMS').each(function(){
                    this.checked = true;

                });
                var chkd = $('.checkCustForSMS:checked');
                var vals = chkd.map(function () {
                    return this.value;
                })
                    .get().join(', ');
                $('.SMS_cust').val(vals);
            }else{
                $('.createMSGBtn').addClass('hide');
                $('.checkCustForSMS').each(function(){
                    this.checked = false;
                });
                $('.SMS_cust').val('');
            }
        });

        $('.checkCustForSMS').on('click',function(){
            if($('.checkCustForSMS:checked').length == $('.checkCustForSMS').length){
                $('#_checkAll').prop('checked',true);
            }else{
                $('#_checkAll').prop('checked',false);
            }
        });
    });
</script>
