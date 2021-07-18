<h3 class="header smaller lighter">
    Add Branch
    <span class="pull-right">
        <button type="submit" form="frm" class="btn btn-xs btn-success"><i class="fa fa-floppy-o"></i> Save</button>
        <a href="#" onclick="goBack();" class="btn btn-xs btn-warning"><i
                    class="fa fa-arrow-left"></i> Back</a>
    </span>
</h3>
<?php echo getMessage(); ?>
<span class="pull-right text-danger">
    * Fields are mandatory 
</span>

<form class="form-horizontal" id="frm" method="POST" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" id="pk_id" name="pk_id" value="<?php echo !empty($branch['pk_id']) ? $branch['pk_id'] : ""; ?>">
    <div class="col-md-9">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5" for=""><sup class="text-danger">*</sup> Select Location :</label>
                <div class="col-sm-7">
                    <select name="location_id" class="form-control input-sm">
                        <option value="">-- Select Location Name --</option>
                        <?php if (!empty($locations)) {
                            foreach ($locations as $key => $name) { ?>
                                <option value="<?php echo $key; ?>" <?php echo (!empty($branch['location_id']) && ($key == $branch['location_id'])) ? "selected='selected'" : '' ?>><?php echo $name; ?></option>
                            <?php }
                        } ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5" for=""><sup class="text-danger">*</sup> Branch Name :</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control input-sm" id="name" name="name" placeholder="Enter Branch Name" value="<?php echo !empty($branch['name']) ? $branch['name'] : ""; ?>">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5" for=""><sup class="text-danger">*</sup> Branch Code :</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control input-sm" id="branch_code" name="branch_code" placeholder="Enter Branch Code" value="<?php echo !empty($branch['branch_code']) ? $branch['branch_code'] : ""; ?>">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5" for=""><sup class="text-danger">*</sup> Inward Code :</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control input-sm" id="inward_code" name="inward_code" placeholder="Inward Code" value="<?php echo !empty($branch['inward_code']) ? $branch['inward_code'] : ""; ?>">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5" for="address"><sup class="text-danger">*</sup> Address Line 1:</label>
                <div class="col-sm-7">
                    <input class="form-control  input-sm" id="address1" name="address1" type="text" placeholder="Enter Address Line 1" value="<?php echo !empty($branch['address1']) ? $branch['address1'] : ""; ?>"/>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5" for="suite"><sup class="text-danger">*</sup> Address Line 2 :</label>
                <div class="col-sm-7">
                    <input class="form-control  input-sm" id="address2" name="address2" type="text" placeholder="Enter Address Line 2" value="<?php echo !empty($branch['address2']) ? $branch['address2'] : ""; ?>"/>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5" for="phone_1">Phone No 1:</label>
                <div class="col-sm-7">
                    <input class="form-control  input-sm" id="phone_1" onkeypress="return isNumber(event)" name="phone_1" maxlength="15" type="text" placeholder="Enter Phone 1" value="<?php echo !empty($branch['phone_1']) ? $branch['phone_1'] : ""; ?>"/>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5" for="phone_2"> Phone No 2:</label>
                <div class="col-sm-7">
                    <input class="form-control  input-sm" id="phone_2" onkeypress="return isNumber(event)" name="phone_2" maxlength="15" type="text" placeholder="Enter Phone 2" value="<?php echo !empty($branch['phone_2']) ? $branch['phone_2'] : ""; ?>"/>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5" for="mobile_1"><sup class="text-danger">*</sup> Mobile No 1:</label>
                <div class="col-sm-7">
                    <input class="form-control  input-sm" id="mobile_1" onkeypress="return isNumber(event)" maxlength="10" name="mobile_1" type="text" placeholder="Enter Mobile 1" value="<?php echo !empty($branch['mobile_1']) ? $branch['mobile_1'] : ""; ?>"/>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5" for="mobile_2">Mobile No 2:</label>
                <div class="col-sm-7">
                    <input class="form-control  input-sm" id="mobile_2" onkeypress="return isNumber(event)" name="mobile_2" maxlength="10" type="text" placeholder="Enter Mobile 2" value="<?php echo !empty($branch['mobile_2']) ? $branch['mobile_2'] : ""; ?>"/>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5" for="suite"><sup class="text-danger">*</sup> City :</label>
                <div class="col-sm-7">
                    <input class="form-control  input-sm" id="city" name="city" type="text" placeholder="Enter City" value="<?php echo !empty($branch['city']) ? $branch['city'] : ""; ?>"/>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5" for="suite"><sup class="text-danger">*</sup> State :</label>
                <div class="col-sm-7">
                    <select class="form-control input-sm _state" id="state" name="state_code">
                        <option value="">--Select State--</option>
                        <?php if (!empty($states)) {
                            foreach ($states as $state) {
                                ?>
                                <option value="<?php echo $state['state_code'] ?>" <?php echo (!empty($branch['state_code']) && ($state['state_code'] == $branch['state_code'])) ? 'selected' : '' ?>><?php echo $state['state_name'] ?></option>
                            <?php }
                        } else {
                            echo "<option value=''>No States found</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="other <?php echo (!empty($branch) &&(!empty($branch['other_location']) || $branch['state_code']=='OTH' )) ? "" : "hide"; ?>">
            <div class="col-md-6 col-md-offset-6">
                <div class="form-group">
                    <label class="control-label col-sm-5" for="other_location"><sup class="text-danger">*</sup>Location Name:</label>
                    <div class="col-sm-7">
                        <input class="form-control input-sm" id="other_location" type="text" placeholder="Enter Location Name / Details " name="other_location" value="<?php echo !empty($branch['other_location']) ? $branch['other_location'] : ""; ?>"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5" for="zip_code"><sup class="text-danger">*</sup> PIN Code :</label>
                <div class="col-sm-7">
                    <input class="form-control input-sm" id="zip_code" onkeypress="return isNumber(event)" maxlength="6" type="text" placeholder="Enter PIN Code" name="pincode" value="<?php echo !empty($branch['pincode']) ? $branch['pincode'] : ""; ?>"/>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5" for="branch_logo"> Logo :</label>
                <div class="col-sm-7">
                    <input class="form-control input-sm input-file-2 profile-input-file" id="branch_logo" type="file" name="branch_logo"/>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label col-sm-2"> Branch Info :</label>
                <div class="col-sm-10">
                    <input class="form-control input-sm" name="branch_info" value="<?php echo !empty($branch['branch_info']) ? $branch['branch_info'] : ""; ?>"/>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label col-sm-2">
                    <span data-toggle="tooltip" title="This text will show in quotaions ,Proforma and invoice page"> Reference Text : <i class="fa fa-info-circle"></i></span>
                </label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="reference" rows="5"><?php echo !empty($branch['reference']) ? $branch['reference'] : ''; ?></textarea>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label col-sm-2">
                    <span>Proforma Reference Text : </span>
                </label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="proforma_reference" rows="5"><?php echo !empty($branch['proforma_reference']) ? $branch['proforma_reference'] : ''; ?></textarea>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5" for="bank_info">Bank Info. :</label>
                <div class="col-sm-7">
                    <input class="form-control input-sm" id="bank_info" type="text" placeholder="Enter Bank Info." name="bank_info" value="<?php echo !empty($branch['bank_info']) ? $branch['bank_info'] : ""; ?>"/>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5" for="account_no">Account No. :</label>
                <div class="col-sm-7">
                    <input class="form-control input-sm" id="account_no" onkeypress="return isNumber(event);" type="text" placeholder="Enter Account No." name="account_no" value="<?php echo !empty($branch['account_no']) ? $branch['account_no'] : ""; ?>"/>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5" for="hsn_no">IFSC No. :</label>
                <div class="col-sm-7">
                    <input class="form-control input-sm " id="ifsc_no" type="text" name="ifsc_no" placeholder="Enter IFSC No." name="ifsc_no" value="<?php echo !empty($branch['ifsc_no']) ? $branch['ifsc_no'] : ""; ?>"/>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5" for="pan_no">PAN No. :</label>
                <div class="col-sm-7">
                    <input class="form-control input-sm" id="pan_no" type="text" placeholder="Enter Pan No." name="pan_no" value="<?php echo !empty($branch['pan_no']) ? $branch['pan_no'] : ""; ?>"/>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5" for="gst_no">GST No. :</label>
                <div class="col-sm-7">
                    <input class="form-control input-sm" id="gst_no" type="text" placeholder="Enter GST No." name="gst_no" value="<?php echo !empty($branch['gst_no']) ? $branch['gst_no'] : ""; ?>"/>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-sm-5" for="hsn_no"> HSN No. :</label>
                <div class="col-sm-7">
                    <input class="form-control input-sm " id="hsn_no" type="text" name="hsn_no" placeholder="Enter HSN No."  value="<?php echo !empty($branch['hsn_no']) ? $branch['hsn_no'] : ""; ?>"/>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label col-sm-2">
                    <span> Remarks : </span>
                </label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="remarks" rows="5"><?php echo !empty($branch['remarks']) ? $branch['remarks'] : ''; ?></textarea>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="space-16"></div>
        <h5 class="text-primary">Note : While you adding conditions in point wise,Please add <code>&lt;br&gt; </code>   after each point</h5>
        <div class="clearfix"></div>
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label col-sm-2">
                    <span>Inwards Terms & Conditions : </span>
                </label>
                <div class="col-sm-10">
                    <textarea class="form-control " name="inwards_tc" rows="5"><?php echo !empty($branch['inwards_tc']) ? strip_tags($branch['inwards_tc']) : ''; ?></textarea>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label col-sm-2">
                    <span>Outwards Terms & Conditions : </span>
                </label>
                <div class="col-sm-10">
                    <textarea class="form-control " name="outwards_tc" rows="5"><?php echo !empty($branch['outwards_tc']) ? strip_tags($branch['outwards_tc']) : ''; ?></textarea>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label col-sm-2">
                    <span>Quotation Terms & Conditions : </span>
                </label>
                <div class="col-sm-10">
                    <textarea class="form-control " name="quotation_tc" rows="5"><?php echo !empty($branch['quotation_tc']) ? strip_tags($branch['quotation_tc']) : ''; ?></textarea>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label col-sm-2">
                    <span>Proforma / Invoice Terms & Conditions : </span>
                </label>
                <div class="col-sm-10">
                    <textarea class="form-control " name="proforma_invoice_tc" rows="5"><?php echo !empty($branch['proforma_invoice_tc']) ? strip_tags($branch['proforma_invoice_tc']) : ''; ?></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <?php

        $path = '/data/branches/';
        if (!empty($branch['branch_logo']) && file_exists(FCPATH . $path . $branch['branch_logo'])) { ?>
            <img class="max-200 preview-pic" alt="Branch Logo" src="<?php echo base_url() . $path . $branch['branch_logo']; ?>"/>
        <?php } else { ?>
            <img src="http://placehold.it/200x200" alt="your image" class="preview-pic max-200"/>
        <?php } ?>
    </div>
</form>
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script type="text/javascript">
    //jQuery(function ($) {
    $(document).ready(function(){
        $('._state').change(function () {
            var state = $(this).val();
            if (state == 'OTH') {
                $('.other').removeClass('hide');
            } else {
                $('.other').addClass('hide');
            }
        });
        $('#frm').validate({
            errorElement: 'div',
            errorClass: 'help-block',
            focusInvalid: false,
            ignore: "",
            rules: {
                location_id: {required: true},
                name: {required: true},
                branch_code: {required: true},
                address1: {required: true},
                address2: {required: true},
                city: {required: true},
                state_code: {required: true},
                pincode: {required: true, digits: true},
                mobile_1: {required: true, digits: true, minlength: 10},
                phone_1: {digits: true},
                inward_code: {required: true},
                reference: {required: true}
            },
            highlight: function (e) {
                $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
            },
            success: function (e) {
                $(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
                $(e).remove();
            },
            invalidHandler: function (form) {
            }
        })
        tinymce.init({
            selector: "textarea.ckeditor",
            theme: "modern",
            plugins: ["advlist  autolink lists link image  imagetools charmap print preview anchor", "searchreplace visualblocks code fullscreen", "insertdatetime media table contextmenu paste"],
            convert_urls: false,
            content_css: 'http://skin.tinymce.com/css/preview.content.css',
            toolbar: "insertfile undo redo code | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | upload ",
            images_dataimg_filter: function (img) {
                return img.hasAttribute('internal-blob');
            },
        });
    })
</script>
