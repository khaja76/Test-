<style>
    #email-error {
        display: block !important;
    }
</style>
<h3 class="header smaller lighter">
    Sub Ordinates
    <span class="pull-right">
    <button type="submit" form="frm" class="btn btn-sm btn-success"><i class="fa fa-floppy-o"></i> Save</button>
    <a href="#" onclick="goBack();" class="btn btn-sm btn-warning"><i class="fa fa-arrow-left"></i> Back</a>
</span>
</h3>
<?php echo getMessage(); ?>
<form class="form-horizontal" method="post" action="" id="frm" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="user_id" value="<?php echo !empty($user['user_id']) ? $user['user_id'] : ''; ?>"/>
    <input type="hidden" name="branch_pk_id" value="<?php echo !empty($user['branch_pk_id']) ? $user['branch_pk_id'] : ''; ?>"/>
    <div class="col-md-9">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-sm-5" for="name"><sup class="text-danger">*</sup> Name :</label>
                    <div class="col-sm-7">
                        <div class="clearfix">
                            <input class="form-control input-sm" name="name" value="<?php echo !empty($user['name']) ? $user['name'] : ''; ?>" placeholder="Enter Name"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-sm-5" for="Email"><sup class="text-danger">*</sup> Email :</label>
                    <div class="col-sm-7">
                        <div class="clearfix">
                            <input class="form-control input-sm" name="email" type="email" value="<?php echo !empty($user['email']) ? $user['email'] : ''; ?>" placeholder="mail@domain.com"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-sm-5" for="password"><sup class="text-danger">*</sup> Password :</label>
                    <div class="col-sm-7">
                        <div class="clearfix">
                            <input class="form-control input-sm" name="password" id="password" type="<?php echo !empty($user['password']) ? 'text' : 'password' ?>" value="<?php echo !empty($user['password']) ? $user['password'] : ''; ?>" placeholder="Enter Password"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-sm-5" for="c-password"><sup class="text-danger">*</sup> Confirm Password :</label>
                    <div class="col-sm-7">
                        <div class="clearfix">
                            <input class="form-control input-sm " name="password2" id="password2" type="<?php echo !empty($user['password']) ? 'text' : 'password' ?>" value="<?php echo !empty($user['password']) ? $user['password'] : ''; ?>" placeholder="Enter Confirm Password"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-sm-5" for="phone"><sup class="text-danger">*</sup> Mobile :</label>
                    <div class="col-sm-7">
                        <div class="clearfix">
                            <div class="input-group">
                            <span class="input-group-addon">
                                <i class="ace-icon fa fa-phone"></i>
                            </span>
                                <input type="tel" id="phone" name="phone" value="<?php echo !empty($user['phone']) ? $user['phone'] : ''; ?>" class="form-control input-sm" placeholder="Enter Your Mobile Number"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-sm-5" for="phone"><sup class="text-danger"></sup>Alternative Mobile:</label>
                    <div class="col-sm-7">
                        <div class="clearfix">
                            <div class="input-group">
                            <span class="input-group-addon">
                                <i class="ace-icon fa fa-phone"></i>
                            </span>
                                <input type="tel" name="alt_phone" maxlength="13" onkeypress="return isNumber(event);" value="<?php echo !empty($user['alt_phone']) ? $user['alt_phone'] : ''; ?>" class="form-control input-sm" placeholder="Enter Your Mobile Number"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-xs-12 col-sm-5"><sup class="text-danger">*</sup> Gender :</label>
                    <div class="col-sm-7">
                        <div class="clearfix">
                            <label class="line-height-1">
                                <input name="gender" checked value="MALE" type="radio" class="ace" <?php echo !empty($user) && ($user['gender'] == "MALE") ? "checked='checked'" : ""; ?>/>
                                <span class="lbl"> Male</span>
                            </label>
                            <label class="line-height-1">
                                <input name="gender" value="FEMALE" type="radio" class="ace" <?php echo !empty($user) && ($user['gender'] == "FEMALE") ? "checked='checked'" : ""; ?>/>
                                <span class="lbl"> Female</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-sm-5" for="role"><sup class="text-danger">*</sup> Role :</label>
                    <div class="col-sm-7">
                        <div class="clearfix">
                            <select class="form-control input-sm" name="role" id="role">
                                <option value="">----- Role For -----</option>
                                <?php
                                if ($_SESSION['ROLE'] != 'SUPER_ADMIN') {
                                    ?>
                                    <?php if (!empty($roles)) {
                                        foreach ($roles as $key => $name) { ?>
                                            <option value="<?php echo $key; ?>" <?php echo (!empty($user['role']) && ($key == $user['role'])) ? "selected='selected'" : '' ?>><?php echo $name; ?></option>
                                        <?php }
                                    } ?>
                                <?php } else if (!empty($user['role'])) { ?>
                                    <option value="<?php echo $user['role'] ?>" selected><?php echo $user['role']; ?></option>
                                <?php } else {
                                    foreach ($roles as $key => $name) { ?>
                                        <option value="<?php echo $key; ?>" <?php echo (!empty($user['role']) && ($key == $user['role'])) ? "selected='selected'" : '' ?>><?php echo $name; ?></option>
                                    <?php }
                                } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" <?php echo (!empty($_SESSION) && ($_SESSION['ROLE'] == "SUPER_ADMIN")) ? "style='display:block'" : "style='display:none'"; ?> >
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-sm-5" for=""><sup class="text-danger">*</sup> Select Location :</label>
                    <div class="col-sm-7">
                        <select name="location_id" id="location_id" class="form-control input-sm">
                            <option value="">-- Select Location Name --</option>
                            <?php if (!empty($locations)) {
                                foreach ($locations as $key => $name) { ?>
                                    <option value="<?php echo $key; ?>" <?php echo (!empty($user['location_id']) && ($key == $user['location_id'])) ? "selected='selected'" : '' ?>><?php echo $name; ?></option>
                                <?php }
                            } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-sm-5" for=""><sup class="text-danger">*</sup> Select Branch :</label>
                    <div class="col-sm-7">
                        <select name="branch_id" id="branch_id" class="form-control input-sm">
                            <option value="">-- Select Branch Name --</option>
                            <?php if (!empty($branches)) {
                                foreach ($branches as $k => $n) { ?>
                                    <option value="<?php echo $k; ?>" <?php echo (!empty($user['branch_id']) && ($k == $user['branch_id'])) ? "selected='selected'" : '' ?>><?php echo $n; ?></option>
                                <?php }
                            } ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-sm-5" for="status"><sup class="text-danger">*</sup> Status :</label>
                    <div class="col-sm-7">
                        <div class="clearfix">
                            <select class="form-control input-sm" name="status" id="status">
                                <option value="">----- Status -----</option>
                                <?php if (!empty($status)) {
                                    foreach ($status as $k => $n) { ?>
                                        <option value="<?php echo $k; ?>" <?php echo (!empty($user['status']) && ($k == $user['status'])) ? "selected='selected'" : '' ?>><?php echo $n; ?></option>
                                    <?php }
                                } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-sm-5" for=""> Address 1 :</label>
                    <div class="col-sm-7">
                        <input name="address1" value="<?php echo !empty($user['address1']) ? $user['address1'] : ''; ?>" class="form-control input-sm" placeholder="Enter Your Address"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-sm-5" for=""> Address 2 :</label>
                    <div class="col-sm-7">
                        <input name="address2" value="<?php echo !empty($user['address2']) ? $user['address2'] : ''; ?>" class="form-control input-sm" placeholder="Enter Your Address"/>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-sm-5" for=""> City :</label>
                    <div class="col-sm-7">
                        <input name="city" value="<?php echo !empty($user['city']) ? $user['city'] : ''; ?>" class="form-control input-sm" placeholder="Enter Your City"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-sm-5" for=""> State :</label>
                    <div class="col-sm-7">
                        <select class="form-control input-sm" id="state" name="state">
                            <option value="">--Select State--</option>
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
                    <label class="control-label col-sm-5" for="pincode"> Pincode :</label>
                    <div class="col-sm-7">
                        <input name="pincode" value="<?php echo !empty($user['pincode']) ? $user['pincode'] : ''; ?>" maxlength="6" onkeypress="return isNumber(event);" class="form-control input-sm" placeholder="Enter Your Pincode"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-sm-5">Select Profile Pic :</label>
                    <div class="col-sm-7">
                        <input type="file" name="photo" class="profile-input-file input-file-2" accept=".png, .jpg, .jpeg, .gif"/>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-sm-5">Upload Resume :</label>
                    <div class="col-sm-7">
                        <input type="file" name="resume" class="input-file-2" accept=".docs, .pdf" value="<?php echo !empty($documents['resume']) ? $documents['resume'] : '' ?>"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-sm-5">Experience Letter :</label>
                    <div class="col-sm-7">
                        <input type="file" name="experience" class="input-file-2" accept=".docs, .pdf" value="<?php echo !empty($documents['experience_letter']) ? $documents['experience_letter'] : '' ?>"/>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-sm-5">Bond Paper :</label>
                    <div class="col-sm-7">
                        <input type="file" name="bond_paper" class="input-file-2" accept=".docs, .pdf" value="<?php echo !empty($documents['bond_paper']) ? $documents['bond_paper'] : '' ?>"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-sm-5">Others:</label>
                    <div class="col-sm-7">
                        <input type="file" name="others" class="input-file-2" accept=".docs, .pdf" value="<?php echo !empty($documents['others']) ? $documents['others'] : '' ?>"/>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-sm-5">Others 2:</label>
                    <div class="col-sm-7">
                        <input type="file" name="others2" class="input-file-2" accept=".docs, .pdf" value="<?php echo !empty($documents['others2']) ? $documents['others2'] : '' ?>"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <?php if (!empty($user['img']) && file_exists(FCPATH . $user['img_path'] . $user['img'])) { ?>
            <img class="max-200 preview-pic" alt="Avatar" src="<?php echo base_url() . $user['img_path'] . $user['img']; ?>"/>
        <?php } else { ?>
            <img src="<?php echo dummyLogo() ?>" alt="your image" class="max-200 preview-pic "/>
        <?php } ?>
    </div>
    <div class="clearfix"></div>
</form>
<script>
    //jQuery(function () {
    $(document).ready(function(){
        
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
                    email: true,
                    <?php if(empty($user)){ ?>
                    remote: "<?php echo base_url();?>home/checkUserMail/"
                    <?php } ?>
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
                alt_phone: {
                    digits: true,
                },
                phone: {
                    required: true,
                    phone: 'required'
                },
                <?php if(!empty($_SESSION['ROLE']) && ($_SESSION['ROLE'] == "SUPER_ADMIN")){ ?>
                location_id: {required: true},
                branch_id: {required: true},
                <?php } ?>
                gender: {required: true},
                role: {required: true},
                status: {required: true}
            },
            messages: {
                email: {
                    remote: "This E-Mail is Already exists"
                }
            },
            highlight: function (e) {
                $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
            },
            success: function (e) {
                $(e).closest('.form-group').removeClass('has-error');
                $(e).remove();
            }
        });
        $('#role').on("change", function () {
            var role = $(this).val();
            var th = $(this).closest('.row');
            if (role == 'ADMIN') {
                //th.next().show();
                $("#location_id,#branch_id").addClass('required');
            } else {
                //th.next().hide();
                $("#location_id,#branch_id").removeClass('required')
                $("#location_id ,#branch_id ").val('');
            }
        });
        <?php
        if(empty($user))
        {
        ?>
        $('#branch_id').empty();
        <?php
        }
        ?>
        $('#location_id').on("change", function () {
            var location_id = $(this).val();
            if ((location_id == "") || (location_id == null)) {
                $('#branch_id').empty();
            }
            else {
                $('#branch_id').empty();
                $.ajax({
                    type: 'POST',
                    url: "<?php echo base_url() ?>" + "admin/fetch_branches/?location_id=" + location_id,
                    dataType: 'json',
                    cache: false,
                    success: function (data) {
                        //$('#branch_id').empty();
                        $('#branch_id').append($("<option></option>").attr("value", "").text("-- Select a Branch --"));
                        $.each(data, function (key, value) {
                            $('#branch_id').append($("<option></option>").attr("value", key).text(value));
                        });
                    }
                });
            }
        })
        /*$.mask.definitions['~'] = '[+-]';
        $('#phone').mask('(999) 999-9999');
        var jQuery_1_7_0 = $.noConflict(true);  // <- this
        jQuery_1_7_0.validator.addMethod("phone", function (value, element) {
            return this.optional(element) || /^\(\d{3}\) \d{3}\-\d{4}( x\d{1,6})?$/.test(value);
        }, "Enter a valid phone number.");*/
    })
</script>