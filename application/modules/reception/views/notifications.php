<h3 class="header smaller lighter">
    View Inward
</h3>

<form class="form-inline text-center validation-form"  action="" enctype="multipart/form-data" method="get">
    <div class="form-group">
        <label for="job_id"><sup class="text-danger">*</sup> Job Id :</label>
    </div>
    <div class="form-group">
        <input class="form-control" id="job_id" name="job_id" type="text" placeholder="Enter Job Id" required/>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-files-o"></i> Get Record</button>
        <span class="text-success">   Approved</span>
    </div>
</form>

<?php
if (!empty($_GET['job_id'])) { ?>

    <!-- <div class="col-xs-12 col-sm-6">
         <div class="space"></div>
         <h4>Customer Information</h4>
         <div class="table-detail">
             <div class="row">
                 <div class="col-xs-12 col-sm-4">
                     <div class="text-center">
                         <img height="150" class="thumbnail inline no-margin-bottom" alt="Domain Owner's Avatar" src="assets/images/avatars/profile-pic.jpg" />
                         <br />
                         <div class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
                             <div class="inline position-relative">
                                 <a class="user-title-label" href="#">
                                     <i class="ace-icon fa fa-circle light-green"></i>
                                     &nbsp;
                                     <span class="white">Alex M. Doe</span>
                                 </a>
                             </div>
                         </div>
                     </div>
                 </div>

                 <div class="col-xs-12 col-sm-7">
                     <div class="space visible-xs"></div>

                     <div class="profile-user-info profile-user-info-striped">
                         <div class="profile-info-row">
                             <div class="profile-info-name"> Name </div>

                             <div class="profile-info-value">
                                 <span>Bhargav Krishna</span>
                             </div>
                         </div>

                         <div class="profile-info-row">
                             <div class="profile-info-name"> Phone No </div>

                             <div class="profile-info-value">

                                 <span>9440886725</span>
                             </div>
                         </div>

                         <div class="profile-info-row">
                             <div class="profile-info-name"> Email Id </div>

                             <div class="profile-info-value">
                                 <span>mydwayz@gmail.com</span>
                             </div>
                         </div>

                         <div class="profile-info-row">
                             <div class="profile-info-name"> Address </div>

                             <div class="profile-info-value">
                                 <i class="fa fa-map-marker light-orange bigger-110"></i>
                                 <span>#123, mehidipatnam, 500028</span>
                             </div>
                         </div>

                     </div>
                 </div>

             </div>
         </div>
     </div>-->
    <div class="col-xs-12 col-sm-6">
        <div class="space"></div>
        <h4>Product Information</h4>

        <div class="profile-user-info profile-user-info-striped">
            <div class="profile-info-row">
                <div class="profile-info-name"> Product Name</div>

                <div class="profile-info-value">
                    <span>PLC</span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Model Number</div>

                <div class="profile-info-value">
                    <span>321</span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Estimation</div>

                <div class="profile-info-value">
                    <span>100</span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Remarks</div>

                <div class="profile-info-value">
                    <span>OUT</span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Inward Date</div>

                <div class="profile-info-value">
                    <span>9/7/2017 17:15:53 PM</span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Product No</div>

                <div class="profile-info-value">
                    <span>12345</span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Manufacturer</div>

                <div class="profile-info-value">
                    <span>Seimens</span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Assigned to</div>

                <div class="profile-info-value">
                    <span>Reception</span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Description</div>

                <div class="profile-info-value">
                    <span>PUT</span>
                </div>
            </div>
        </div>

    </div>
    <div class="col-xs-12 col-sm-6">
        <h4>Inward Images</h4>
        <ul class="ace-thumbnails clearfix">
            <li>
                <a href="http://via.placeholder.com/200x200" title="Photo Title" data-rel="colorbox">
                    <img width="200" height="200" alt="200x200" src="http://via.placeholder.com/200x200"/>
                </a>

                <div class="tools tools-bottom">
                    <a href="#">
                        <i class="ace-icon fa fa-times red"></i>
                    </a>
                </div>
            </li>

            <li>
                <a href="http://via.placeholder.com/200x200" data-rel="colorbox">
                    <img width="200" height="200" alt="200x200" src="http://via.placeholder.com/200x200"/>
                    <div class="text">
                        <div class="inner">Sample Caption on Hover</div>
                    </div>
                </a>
                <div class="tools tools-bottom">
                    <a href="#">
                        <i class="ace-icon fa fa-times red"></i>
                    </a>
                </div>
            </li>

            <li>
                <a href="http://via.placeholder.com/200x200" data-rel="colorbox">
                    <img width="200" height="200" alt="200x200" src="http://via.placeholder.com/200x200"/>
                    <div class="text">
                        <div class="inner">Sample Caption on Hover</div>
                    </div>
                </a>

                <div class="tools tools-bottom">
                    <a href="#">
                        <i class="ace-icon fa fa-times red"></i>
                    </a>
                </div>
            </li>
            <li>
                <a href="http://via.placeholder.com/200x200" data-rel="colorbox">
                    <img width="200" height="200" alt="200x200" src="http://via.placeholder.com/200x200"/>
                    <div class="text">
                        <div class="inner">Sample Caption on Hover</div>
                    </div>
                </a>

                <div class="tools tools-bottom">
                    <a href="#">
                        <i class="ace-icon fa fa-times red"></i>
                    </a>
                </div>
            </li>

        </ul>
    </div>
    <div class="clearfix"></div>

    <!-- PAGE CONTENT ENDS -->


<?php }
?>

<script>
    $(document).ready(function() {

        $('.validation-form').validate({

            errorElement: 'div',
            errorClass: 'help-block',
            focusInvalid: false,
            ignore: "",
            rules: {
                job_id: {required: true}
            },

            messages: {
                job_id:   "Please provide Job Id ."
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



