<h3 class="header smaller lighter">
    Customer Profile
    <span class="pull-right">
        <button type="submit" form="frm" class="btn btn-sm btn-success"><i class="fa fa-floppy-o"></i> Save</button>
        <button onclick="goBack()" class="btn btn-sm btn-warning"><i class="fa fa-arrow-left"></i> Back</button>
    </span>
</h3>
<?php echo getMessage(); ?>
<form class="form-horizontal" method="post" action="" id="frm" enctype="multipart/form-data">
    <input type="hidden" name="pk_id" value="<?php echo !empty($customer['pk_id']) ? $customer['pk_id'] : ''; ?>"/>
    <div class="col-md-9">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-sm-5" for="status"> Status :</label>
                    <div class="col-sm-7 mt-8">
                        <?php echo (!empty($customer['is_active']) && ($customer['is_active'] == '1')) ? 'Active' : 'Inactive'; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5" for="name"><sup class="text-danger">*</sup>First Name :</label>
                <div class="col-sm-7">
                    <div class="clearfix">
                        <input onkeypress="return onlyAlphabets(event,this);" class="form-control input-sm" name="first_name" type="text" value="<?php echo !empty($customer['first_name']) ? $customer['first_name'] : ''; ?>" placeholder=" Enter First Name"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5" for="name"><sup class="text-danger">*</sup>Last Name :</label>
                <div class="col-sm-7">
                    <div class="clearfix">
                        <input onkeypress="return onlyAlphabets(event,this);" class="form-control input-sm" name="last_name" type="text" value="<?php echo !empty($customer['last_name']) ? $customer['last_name'] : ''; ?>" placeholder=" Enter Last Name"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5" for="Email"><sup class="text-danger">*</sup> Email :</label>
                <div class="col-sm-7">
                    <div class="clearfix">
                        <input class="form-control input-sm" name="email" type="email" value="<?php echo !empty($customer['email']) ? $customer['email'] : ''; ?>" placeholder="mail@domain.com" readonly/>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5" for="phone"><sup class="text-danger">*</sup> Mobile :</label>
                <div class="col-sm-7">
                    <div class="clearfix">
                        <div class="input-group">
                    <span class="input-group-addon">
                        <i class="ace-icon fa fa-phone"></i>
                    </span>
                            <input type="tel" id="phone" name="mobile" value="<?php echo !empty($customer['mobile']) ? $customer['mobile'] : ''; ?>" class="form-control input-sm" placeholder="Enter Your Mobile Number"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5" for="password"><sup class="text-danger">*</sup> Password :</label>
                <div class="col-sm-7">
                    <div class="clearfix">
                        <input class="form-control input-sm" name="password" id="password" type="password" value="<?php echo !empty($customer['password']) ? $customer['password'] : ''; ?>" placeholder="Enter Password"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5" for="c-password"><sup class="text-danger">*</sup> Confirm Password :</label>
                <div class="col-sm-7">
                    <div class="clearfix">
                        <input class="form-control input-sm" name="password2" id="password2" type="password" placeholder="Enter Confirm Password"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5" for=""> Address 1 :</label>
                <div class="col-sm-7">
                    <input type="text" name="address1" value="<?php echo !empty($customer['address1']) ? $customer['address1'] : ''; ?>" class="form-control input-sm" placeholder="Enter Your Address"/>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5" for=""> Address 2 :</label>
                <div class="col-sm-7">
                    <input type="text" name="address2" value="<?php echo !empty($customer['address2']) ? $customer['address2'] : ''; ?>" class="form-control input-sm" placeholder="Enter Your Address"/>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5" for=""> City :</label>
                <div class="col-sm-7">
                    <input onkeypress="return onlyAlphabets(event,this);" type="text" name="city" value="<?php echo !empty($customer['city']) ? $customer['city'] : ''; ?>" class="form-control input-sm" placeholder="Enter Your City"/>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5" for=""> State :</label>
                <div class="col-sm-7">
                    <input type="text" name="state" value="<?php echo !empty($customer['state']) ? $customer['state'] : ''; ?>" class="form-control input-sm" placeholder="Enter Your State"/>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5" for="pincode"> Pin Code :</label>
                <div class="col-sm-7">
                    <input type="text" name="pincode" value="<?php echo !empty($customer['pincode']) ? $customer['pincode'] : ''; ?>" class="form-control input-sm" placeholder="Enter Your Pincode" maxlength="6"/>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5" for="input-file-2">Select user Pic :</label>
                <div class="col-sm-7">
                    <input type="file" name="photo" class="user-input-file input-file-2" accept=".png, .jpg, .jpeg, .gif"/>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3" id="img-previews">
        <?php if (!empty($customer['thumb_img']) && file_exists(FCPATH . $customer['img_path'] . $customer['thumb_img'])) { ?>
            <img class="width-height-150" alt="Avatar" src="<?php echo base_url() . $customer['img_path'] . $customer['thumb_img']; ?>"/>
        <?php } else { ?>
            <img src="<?php echo dummyLogo() ?>" alt="your image" class="width-height-150"/>
        <?php } ?>
    </div>
    <div class="clearfix"></div>
</form>
<script>
    //jQuery(function ($) {
    $(document).ready(function(){
        $.mask.definitions['~'] = '[+-]';
        $('#phone').mask('(999) 999-9999');
        var jQuery_1_7_0 = $.noConflict(true);  // <- this
        jQuery_1_7_0.validator.addMethod("phone", function (value, element) {
            return this.optional(element) || /^\(\d{3}\) \d{3}\-\d{4}( x\d{1,6})?$/.test(value);
        }, "Enter a valid phone number.");
        $('#frm').validate({
            errorElement: 'div',
            errorClass: 'help-block',
            focusInvalid: false,
            ignore: "",
            rules: {
                name: {
                    required: true,
                    minlength: 3
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 5
                },
                <?php  if(empty($customer)){ ?>
                password2: {
                    required: true,
                    minlength: 5,
                    equalTo: "#password"
                },
                <?php } ?>
                phone: {
                    required: true,
                    phone: 'required'
                },
                gender: {
                    required: true
                },
                role: {
                    required: true
                },
                status: {
                    required: true
                },
                pincode: {
                    digits: true
                }
            },
            messages: {
                name: "Please provide Name .",
                email: {
                    required: "Please provide a valid email.",
                    email: "Please provide a valid email."
                },
                password: {
                    required: "Please specify a password.",
                    minlength: "Please specify a secure password."
                },
                gender: "Please choose gender"
            },
            highlight: function (e) {
                $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
            },
            success: function (e) {
                $(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
                $(e).remove();
            },
            errorPlacement: function (error, element) {
                if (element.is('input[type=checkbox]') || element.is('input[type=radio]')) {
                    var controls = element.closest('div[class*="col-"]');
                    if (controls.find(':checkbox,:radio').length > 1) controls.append(error);
                    else error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
                }
                else if (element.is('.chosen-select')) {
                    error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
                }
                else error.insertAfter(element.parent());
            },
            invalidHandler: function (form) {
            }
        });
    })
</script>
<script>
    function goBack() {
        window.history.go(-1);
    }
</script>