<h3 class="header smaller lighter">
 User Profile
    <span class="pull-right">
        <button type="submit" form="frm" class="btn btn-xs btn-success"><i class="fa fa-floppy-o"></i> Save</button>
        <button onclick="goBack()" class="btn btn-xs btn-warning"><i class="fa fa-arrow-left"></i> Back</button>
    </span>
</h3>
<?php echo getMessage(); ?>
<form class="form-horizontal" method="post" action="" id="frm" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="user_id" value="<?php echo !empty($user['user_id']) ? $user['user_id'] : ''; ?>"/>
    <div class="col-md-9 col-sm-9 col-xs-12">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label class="control-label col-md-5 col-sm-5 col-xs-12" for="role"> Role :</label>
                    <div class="col-sm-7 mt-8 col-md-7  col-xs-12">
                        <?php echo !empty($user['role']) ? $user['role'] : ''; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label class="control-label col-sm-5" for="status"> Status :</label>
                    <div class="col-sm-7 mt-8">
                        <?php echo !empty($user['status']) ? $user['status'] : ''; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5" for="name"><sup class="text-danger">*</sup> Name :</label>
                <div class="col-sm-7">
                    <div class="clearfix">
                        <input class="form-control input-sm" name="name" type="text" value="<?php echo !empty($user['name']) ? $user['name'] : ''; ?>" placeholder="Enter Name" <?php echo ($_SESSION['ROLE']=='SUPER_ADMIN') ?'' :'disabled'?>/>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5" for="Email"><sup class="text-danger">*</sup> Email :</label>
                <div class="col-sm-7">
                    <div class="clearfix">
                        <input class="form-control input-sm" name="email" type="email" value="<?php echo !empty($user['email']) ? $user['email'] : ''; ?>" placeholder="mail@domain.com" readonly/>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5" for="password"><sup class="text-danger">*</sup> Password :</label>
                <div class="col-sm-7">
                    <div class="clearfix">
                        <input class="form-control input-sm" name="password" id="password" type="<?php echo !empty($user['password']) ? 'text' :'password'?>" value="<?php echo !empty($user['password']) ? $user['password'] : ''; ?>" placeholder="Enter Password"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5" for="c-password"><sup class="text-danger">*</sup> Confirm Password :</label>
                <div class="col-sm-7">
                    <div class="clearfix">
                        <input class="form-control input-sm" name="password2" id="password2" type="<?php echo !empty($user['password']) ? 'text' :'password'?>" placeholder="Enter Confirm Password" value="<?php echo !empty($user['password']) ? $user['password'] : ''; ?>"/>
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
                            <input type="tel" id="phone" name="phone" value="<?php echo !empty($user['phone']) ? $user['phone'] : ''; ?>" class="form-control input-sm" placeholder="Enter Your Mobile Number"  <?php echo ($_SESSION['ROLE']=='SUPER_ADMIN') ?'' :'disabled'?>/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-5"> Gender :</label>
                <div class="col-sm-7">
                    <div class="clearfix">
                        <label class="line-height-1">
                            <input name="gender" checked value="MALE" type="radio" class="ace" <?php echo !empty($user) && ($user['gender'] == "MALE") ? "checked='checked'" : ""; ?>/>
                            <span class="lbl"> Male</span>
                        </label>
                        <label class="line-height-1">
                            <input name="gender" value="FEMALE" type="radio" class="ace" <?php echo !empty($user) && $user['gender']== "FEMALE" ? "checked='checked'" : "";  ?>/>
                            <span class="lbl"> Female</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5" for=""> Address 1 :</label>
                <div class="col-sm-7">
                    <input type="text"  name="address1" value="<?php echo !empty($user['address1']) ? $user['address1'] : ''; ?>" class="form-control input-sm" placeholder="Enter Your Address"/>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5" for=""> Address 2 :</label>
                <div class="col-sm-7">
                    <input type="text"  name="address2" value="<?php echo !empty($user['address2']) ? $user['address2'] : ''; ?>" class="form-control input-sm" placeholder="Enter Your Address"/>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5" for=""> City :</label>
                <div class="col-sm-7">
                    <input type="text" onkeypress="return onlyAlphabets(event,this);" name="city" value="<?php echo !empty($user['city']) ? $user['city'] : ''; ?>" class="form-control input-sm" placeholder="Enter Your City"/>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5" for=""> State :</label>
                <div class="col-sm-7">
                <select class="form-control input-sm" id="state" name="state">
                        <option value="">--Select State</option>
                        <?php if (!empty($states)) {
                            foreach ($states as $state) {
                                ?>
                                <option value="<?php echo $state['state_code'] ?>" <?php echo (!empty($user['state']) && ($state['state_code'] == $user['state'])) ? 'selected' : '' ?>><?php echo $state['state_name'] ?></option>
                            <?php }
                        } else {
                            echo "<option value=''>No States found</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5" for="pincode"> Pin Code :</label>
                <div class="col-sm-7">
                    <input type="text" name="pincode" onkeypress="return isNumber(event);" value="<?php echo !empty($user['pincode']) ? $user['pincode'] : ''; ?>" class="form-control input-sm" placeholder="Enter Your Pincode" maxlength="6"/>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5" for="input-file-2">Select user Pic :</label>
                <div class="col-sm-7">
                    <input type="file" name="photo" class="profile-input-file input-file-2" accept=".png, .jpg, .jpeg, .gif"/>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-12">
        <?php if (!empty($user['thumb_img']) && file_exists(FCPATH . $user['img_path'] . $user['thumb_img'])) { ?>
            <img class="max-200 preview-pic" alt="Avatar" src="<?php echo base_url() . $user['img_path'] . $user['thumb_img']; ?>"/>
        <?php } else { ?>
            <img src="<?php echo dummyLogo() ?>" alt="your image" class="max-200 preview-pic"/>
        <?php } ?>
    </div>
    <div class="clearfix"></div>
</form>
<script>
    $(document).ready(function () {
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
             
                password2: {
                    required: true,
                    minlength: 5,
                    equalTo: "#password"
                },
               
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
            }
        });
    })
</script>
