
<div class="space-6"></div>
<?php echo getMessage(); ?>
<h3 class="header smaller lighter">
    Edit Customer
    <span class="pull-right">
        <a  href="#" onclick="goBack();"  class="btn btn-warning btn-xs"><i class="fa fa-angle-double-left"></i> Back</a>
        <button data-keyboard="false" data-backdrop="false" class="btn btn-xs btn-primary preview" type="button" data-toggle="modal"> Preview </button>
    </span>
</h3>

<?php
if (!empty($customer)) { ?>
    <div id="userModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content modal-sm m-a">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title no-margin">Customer Information</h4>
                </div>
                <div class="">
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
                                    <img src="<?php echo $thumb_img; ?>" class="max-150" alt="customer name"/>
                                <?php } else { ?>
                                    <img src="<?php echo dummyLogo(); ?>" class="max-150" alt="customer name"/>
                                <?php }
                                ?>
                            </div>
                        </div>
                        <?php if(!empty($customer['company_name'])){?>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Company Name</div>
                            <div class="profile-info-value">
                                <span><?php echo  $customer['company_name']; ?></span>
                            </div>
                        </div>
                        <?php } ?>
                        <?php if(!empty($customer['contact_name'])){?>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Person Name </div>
                            <div class="profile-info-value">
                                <span><?php echo  $customer['contact_name']; ?></span>
                            </div>
                        </div>
                        <?php } ?>
                        <?php if(!empty($customer['company_mail'])){?>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Company Mail</div>
                            <div class="profile-info-value">
                                <span><?php echo  $customer['company_mail']; ?></span>
                            </div>
                        </div>
                        <?php } ?>
                        <?php if(!empty($customer['company_mobile'])){?>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Contact No</div>
                            <div class="profile-info-value">
                                <span><?php echo  $customer['company_mobile']; ?></span>
                            </div>
                        </div>
                        <?php } ?>
                        <?php if(!empty($customer['gst_no'])){?>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> GST No</div>
                            <div class="profile-info-value">
                                <span><?php echo  $customer['gst_no']; ?></span>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<form class="form-horizontal" id="frm" method="POST" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="pk_id" value="<?php echo !empty($customer['pk_id']) ? $customer['pk_id'] : ''; ?>"/>
    <input type="hidden" name="customer_id" value="<?php echo !empty($customer['customer_id']) ? $customer['customer_id'] : ''; ?>"/>
    <div class="col-md-9">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5"><sup class="text-danger">*</sup> First Name :</label>
                <div class="col-sm-7">
                    <input value="<?php echo !empty($customer['first_name']) ? $customer['first_name'] : ''; ?>" class="form-control input-sm" id="first_name" name="first_name" placeholder="Enter First Name">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5"> Last Name :</label>
                <div class="col-sm-7">
                    <input value="<?php echo !empty($customer['last_name']) ? $customer['last_name'] : ''; ?>" class="form-control input-sm" id="last_name" name="last_name" placeholder="Enter Last Name">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5"> Email Id :</label>
                <div class="col-sm-7">
                    <input value="<?php echo !empty($customer['email']) ? $customer['email'] : ''; ?>" type="email" class="form-control input-sm" id="email_id" name="email" placeholder="Enter Email Id">
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5"><sup class="text-danger">*</sup> Phone No :</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control no-spin input-sm" onkeypress="return isNumber(event)"
                           maxlength="10" id="phone_no" value="<?php echo !empty($customer['mobile']) ? $customer['mobile'] : ''; ?>" name="mobile" placeholder="Enter Phone Number"/>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5">Phone No :</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control no-spin  input-sm" onkeypress="return isNumber(event)"
                           maxlength="13" id="phone_no2" name="opt_mobile" value="<?php echo !empty($customer['opt_mobile']) ? $customer['opt_mobile'] : ''; ?>" placeholder="Enter Phone Number (optional)"/>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5"><sup class="text-danger">*</sup> Address Line 1:</label>
                <div class="col-sm-7">
                    <input class="form-control input-sm" id="address1" name="address1" value="<?php echo !empty($customer['address1']) ? $customer['address1'] : ''; ?>" placeholder="Enter Address Line 1"/>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5"> Address Line 2 :</label>
                <div class="col-sm-7">
                    <input class="form-control input-sm" id="address2" name="address2" value="<?php echo !empty($customer['address2']) ? $customer['address2'] : ''; ?>" placeholder="Enter Address Line 2"/>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5"><sup class="text-danger">*</sup> City :</label>
                <div class="col-sm-7">
                    <input class="form-control input-sm" id="city" name="city" value="<?php echo !empty($customer['city']) ? $customer['city'] : ''; ?>" placeholder="Enter City"/>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5"><sup class="text-danger">*</sup> State :</label>
                <div class="col-sm-7">
                    <select class="form-control input-sm" id="state" name="state">
                        <option value="">--Select State</option>
                        <?php if (!empty($states)) {
                            foreach ($states as $state) {
                                ?>
                                <option value="<?php echo $state['state_code'] ?>" <?php echo (!empty($customer['state_code']) && ($state['state_code'] == $customer['state_code'])) ? 'selected' : '' ?>><?php echo $state['state_name'] ?></option>
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
                <label class="control-label col-sm-5"> PIN Code :</label>
                <div class="col-sm-7">
                    <input class="form-control no-spin input-sm" onkeypress="return isNumber(event)"
                           maxlength="6" type="text" placeholder="Enter PIN Code" name="pincode" value="<?php echo !empty($customer['pincode']) ? $customer['pincode'] : ''; ?>"/>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5"> Occupation :</label>
                <div class="col-sm-7">
                    <input class="form-control input-sm" id="occupation" name="occupation" value="<?php echo !empty($customer['occupation']) ? $customer['occupation'] : ''; ?>" placeholder="Enter Occupation"/>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5"> Profile Picture :</label>
                <div class="col-sm-7">
                    <input type="file" class="profile-input-file input-file-2" name="photo" accept=".png, .jpg, .jpeg, .gif">
                </div>
            </div>
        </div>

        <div class="col-md-6 hide">
            <div class="form-group">
                <label class="control-label col-sm-5"> Capture Profile Pic :</label>
                <div class="col-sm-7">
                    <button type="button" class="btn btn-sm btn-primary"><i class="fa fa-camera"></i> Capture Profile Pic :</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <?php if (!empty($customer['img']) && file_exists(FCPATH . $customer['img_path'] . $customer['img'])) { ?>
            <img class="max-200 preview-pic" alt="Avatar" src="<?php echo base_url() . $customer['img_path'] . $customer['img']; ?>"/>
        <?php } else { ?>
            <img src="http://placehold.it/200x200" alt="your image" class="preview-pic max-200"/>
        <?php } ?>
    </div>

    <div id="cus-company-product" class="col-md-10 hr16">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5" for="company"> Company Name :</label>
                <div class="col-sm-7">
                    <input class="form-control input-sm" id="company" name="company_name" value="<?php echo !empty($customer['company_name']) ? $customer['company_name'] : ''; ?>" placeholder="Enter Company Name"/>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5" for="company_mail">Company Mail Id :</label>
                <div class="col-sm-7">
                    <input class="form-control input-sm" id="company_mail" type="email" name="company_mail" value="<?php echo !empty($customer['company_mail']) ? $customer['company_mail'] : ''; ?>" placeholder="Enter Company Mail Id"/>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5" for="person_name">Person Name(Optional) :</label>
                <div class="col-sm-7">
                    <input class="form-control input-sm" id="person_name" name="company_user_name" value="<?php echo !empty($customer['contact_name']) ? $customer['contact_name'] : ''; ?>" placeholder="Enter Person Name"/>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5">Phone No(Optional) :</label>
                <div class="col-sm-7">
                    <input class="form-control no-spin  input-sm" name="company_mobile" onkeypress="return isNumber(event)"
                           maxlength="13" value="<?php echo !empty($customer['company_mobile']) ? $customer['company_mobile'] : ''; ?>" placeholder="Enter Phone Number (optional)"/>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5">GST No :</label>
                <div class="col-sm-7">
                    <input class="form-control input-sm" id="gst_no" name="gst_no" value="<?php echo !empty($customer['gst_no']) ? $customer['gst_no'] : ''; ?>" placeholder="Enter GST No."/>
                </div>
            </div>
        </div>
    </div>
    <div id="modal-form" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="bigger no-margin">Customer Details</h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-md-12">
                            <div id="previewData"></div>

                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-xs close-modal" data-dismiss="modal">
                        <i class="ace-icon fa fa-times"></i>
                        Cancel
                    </button>

                    <button class="btn btn-xs btn-primary btnSave" type="submit">
                        <i class="ace-icon fa fa-check"></i>
                        Save
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript">
    //jQuery(function ($) {
    $(document).ready(function(){
        var frm = $('#frm');
        $('.preview').on('click', function () {
            frm.validate({
                errorElement: 'div',
                errorClass: 'help-block',
                focusInvalid: false,
                ignore: "",
                rules: {
                    first_name: {required: true},
                    address1: {required: true},
                    mobile: {
                        required: true,
                        minlength:10,
                        maxlength:10,

                    },
                    city: {required: true},
                    state: {required: true},
                    pincode:{minlength:6,maxlength:6},
                    opt_mobile:{minlength:9,maxlength:15},

                },

                highlight: function (e) {
                    $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
                },

                success: function (e) {
                    $(e).closest('.form-group').removeClass('has-error');
                    $(e).remove();
                }
            });
            
          
            
            function checkVal(val){
                var $value = (val.length >0)  ?  val : '';
                return $value;
            }
            
            if (frm.valid()) {
                $('.preview').attr('data-target', '#modal-form');
                $("#previewData").html(
                    '<div class="row">' +
                    '<div class="col-xs-12 col-sm-12">' +
                    '<div class="space visible-xs"></div>' +
                    '<div class="profile-user-info profile-user-info-striped">' +
                    '<div class="profile-info-row">' +
                    '<div class="profile-info-name">  Name </div>' +
                    '<div class="profile-info-value">' +
                    '<span>' + checkVal($("#first_name").val()) + '&nbsp' + checkVal($("#last_name").val()) + '</span>' +
                    '</div>' +
                    '</div>' +
                    '<div class="profile-info-row">' +
                    '<div class="profile-info-name"> Email </div>' +
                    '<div class="profile-info-value">' +
                    '<span>' + checkVal($("#email_id").val()) + '</span>' +
                    '</div>' +
                    '</div>' +
                    '<div class="profile-info-row">' +
                    '<div class="profile-info-name"> Address </div>' +
                    '<div class="profile-info-value">' +
                    '<i class="fa fa-map-marker light-orange bigger-110"></i>' +
                    '<span>' + checkVal($("#address1").val()) + '&nbsp' + checkVal($("#address2").val()) + '</span>' +
                    '</div>' +
                    '</div>' +
                    '<div class="profile-info-row">' +
                    '<div class="profile-info-name"> Phone No </div>' +
                    '<div class="profile-info-value">' +
                    '<span>' + checkVal($("#phone_no").val()) + '</span>' +
                    '</div>' +
                    '</div>' +
                    '<div class="profile-info-row">' +
                    '<div class="profile-info-name"> City </div>' +
                    '<div class="profile-info-value">' +
                    '<span>' + checkVal($("#city").val()) + '</span>' +
                    '</div>' +
                    '</div>' +
                    '<div class="profile-info-row">' +
                    '<div class="profile-info-name"> State </div>' +
                    '<div class="profile-info-value">' +
                    '<span>' + checkVal($("#state").val()) + '</span>' +
                    '</div>' +
                    '</div>' +
                    '<div class="profile-info-row">' +
                    '<div class="profile-info-name"> Occupation </div>' +
                    '<div class="profile-info-value">' +
                    '<span>' + checkVal($("#occupation").val()) + '</span>' +
                    '</div>' +
                    '</div>' +
                    '<div class="profile-info-row is-comp-check">'+
                    '</div>'  +
                    '<div class="profile-info-row is-compperson-check">'+
                    '</div>'  +
                    '<div class="profile-info-row is-compmail-check">'+
                    '</div>'  +
                    '<div class="profile-info-row is-company_mobile-check">'+
                    '</div>'  +
                    '<div class="profile-info-row is-gst-check">'+
                    '</div>'  +
                    '</div>' +
                    '</div>' +
                    '</div>');

            }
            if($('#company').val()!=''){
               $('.is-comp-check').html('<div class="profile-info-name">Company Name </div><div class="profile-info-value"><span>' + checkVal($("#company").val()) + '</span></div>');
           }
           if($('#person_name').val()!=''){
               $('.is-compperson-check').html('<div class="profile-info-name">Person Name </div><div class="profile-info-value"><span>' +checkVal( $("#person_name").val()) + '</span></div>');
           }
           if($('#company_mail').val()!=''){
               $('.is-compmail-check').html('<div class="profile-info-name">Company Mail </div><div class="profile-info-value"><span>' + checkVal($("#company_mail").val()) + '</span></div>');
           }
           if($('#company_mobile').val()!=''){
               $('.is-company_mobile-check').html('<div class="profile-info-name">Contact No. </div><div class="profile-info-value"><span>' + checkVal($("#company_mobile").val()) + '</span></div>');
           }
           if($('#gst_no').val()!=''){
               $('.is-gst-check').html('<div class="profile-info-name">GST No. </div><div class="profile-info-value"><span>' + checkVal($("#gst_no").val()) + '</span></div>');
           }
        });

        $(document).on('click', '.close-modal', function () {
            $('.preview').attr('data-target', '');
        });

        $(".btnSave").on("click", function (e) {
            frm.submit();
            $('.btnSave').addClass('disabled').attr('type', 'button');
            e.preventDefault();
        });

        $('#cus-company-product-check').click(function () {
            if (this.checked) {
                $('#cus-company-product').removeClass('hide');
            } else {
                $('#cus-company-product').addClass('hide');
            }
        });
    })

</script>
