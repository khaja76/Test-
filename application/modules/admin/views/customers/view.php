<style>
.profile-info-value > span + span:before {
    content:'' !important;
}
</style>
<h3 class="header smaller lighter">
    Customer Profile
    <span class="pull-right">
        <a type="button" class="btn btn-xs btn-warning" href="#" onclick="goBack();"><i class="fa fa-arrow-left"></i> Back</a>
    </span>
</h3>
<?php echo getMessage(); ?>
<?php if(!empty($profile)){ ?>
    <div class="tabbable">
        <ul class="nav nav-tabs padding-18">
            <li class="active">
                <a data-toggle="tab" href="#home">
                    <i class="green ace-icon fa fa-user bigger-120"></i>
                    Profile
                </a>
            </li>
            <li>
                <a data-toggle="tab" href="#inwards">
                    <i class="orange ace-icon fa fa-download bigger-120"></i>
                    Inwards
                </a>
            </li>
        </ul>
        <div class="tab-content no-border">
            <div id="home" class="tab-pane in active">
                <div class="row">
                    <div class="col-xs-12 col-sm-3 center">
                    <span class="profile-picture">
                        <?php if (!empty($profile['img']) && file_exists(FCPATH . $profile['img_path'] . $profile['thumb_img'])) { ?>
                            <img class="max-200" alt="Avatar" src="<?php echo base_url() . $profile['img_path'] . $profile['img']; ?>"/>
                        <?php } else { ?>
                            <img src="<?php echo dummyLogo() ?>" alt="Customer image" class="max-200"/>
                        <?php } ?>
                    </span>
                        <div class="space space-4"></div>
                    </div><!-- /.col -->
                    <div class="col-xs-12 col-sm-9">
                        <div class="col-sm-6">
                        <div class="profile-user-info">
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Customer ID :</div>
                                <div class="profile-info-value">
                                    <h4 class="blue"><?php echo !empty($profile['customer_id']) ? $profile['customer_id'] : ''; ?></h4>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Name :</div>
                                <div class="profile-info-value">
                                    <span><?php echo !empty($profile['last_name']) ? $profile['first_name'].' '.$profile['last_name'] : $profile['first_name']; ?></span>
                                </div>
                            </div>
                            <?php 
                                if(!empty($profile['company_name'])){
                            ?>
                              <div class="profile-info-row">
                                <div class="profile-info-name">Company Name :</div>
                                <div class="profile-info-value">
                                    <span><?php echo !empty($profile['company_name']) ? $profile['company_name'] : '-'; ?></span>
                                </div>
                            </div>
                            <?php
                                }
                            ?>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Email :</div>
                                <div class="profile-info-value">
                                    <span><?php echo !empty($profile['email']) ? $profile['email'] : '-'; ?></span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Mobile No :</div>
                                <div class="profile-info-value">
                                    <span><?php echo !empty($profile['mobile']) ? $profile['mobile'] : '-'; ?></span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Address :</div>
                                <div class="profile-info-value">
                                <?php !empty($profile['address1']) ? '<i class="fa fa-map-marker light-orange bigger-110"></i>':''?>
                                <span><?php echo !empty($profile['address1']) ? $profile['address1'] : '-'; ?></span>
                                <span><?php echo !empty($profile['address2']) ? !empty($profile['address1']) ? ', '.$profile['address2']:$profile['address2'] : '-'; ?></span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> City :</div>
                                <div class="profile-info-value">
                                    <span><?php echo !empty($profile['city']) ? $profile['city'] : '-'; ?></span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> State :</div>
                                <div class="profile-info-value">
                                    <span><?php echo !empty($profile['state']) ? $profile['state'] : '-'; ?></span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Pincode :</div>
                                <div class="profile-info-value">
                                    <span><?php echo !empty($profile['pincode']) ? $profile['pincode'] : '-'; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="hr hr-8 dotted"></div>  
                        </div>
                        
                             
                        <?php 
                           if(!empty($profile['company_name'])){
                        ?>
                        <div class="col-sm-6">
                            <h4 class="orange">Company Information</h4>
                            <div class="profile-user-info">
                                <div class="profile-info-row">
                                    <div class="profile-info-name">Company Name :</div>
                                    <div class="profile-info-value">
                                        <span><?php echo !empty($profile['company_name']) ? $profile['company_name'] : '-'; ?></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name">  GST No. :</div>
                                    <div class="profile-info-value">
                                        <span><?php echo !empty($profile['gst_no']) ? $profile['gst_no'] : '-'; ?></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name">  Person Name :</div>
                                    <div class="profile-info-value">
                                        <span><?php echo !empty($profile['contact_name']) ? $profile['contact_name'] : '-'; ?></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> Email :</div>
                                    <div class="profile-info-value">
                                        <span><?php echo !empty($profile['company_mail']) ? $profile['company_mail'] : '-'; ?></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> Phone No :</div>
                                    <div class="profile-info-value">
                                        <span><?php echo !empty($profile['company_mobile']) ? $profile['company_mobile'] : '-'; ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="hr hr-8 dotted"></div>
                        </div>
                        <?php
                            }
                         ?>
                            
                           
                        
                        
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /#home -->
            <div id="inwards" class="tab-pane">
                <div class="row">
                   
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Job Id</th>
                            <th>Created On</th>
                            <th>Status</th>
                            <th>Created By</th>
                            <th>Assigned To</th>
                            <th>Estimation Amt</th>
                            <th>Paid Amt</th>
                            <th>Pending Amt</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (!empty($inwards)) {
                            $i = 1;
                            foreach ($inwards as $inward) {
                                $estimation=!empty($inward['estimation_amt']) ? $inward['estimation_amt']:0;
                                $paid=!empty($inward['paid_amt']) ? $inward['paid_amt']:0;
                                $balance=$estimation-$paid;
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td>

                                      <?php include currentModuleView('admin').'common_pages/inward-view-url.php';?>
                                    </td>
                                    <td><?php echo !empty($inward['created_on']) ? dateDB2SHOW($inward['created_on']) : ''; ?></td>
                                    <td><?php echo !empty($inward['status']) ? $inward['status'] : ''; ?></td>
                                    <td><?php echo !empty($inward['created_by']) ? $inward['created_by'] : ''; ?></td>
                                    <td><?php echo !empty($inward['assigned_to']) ? $inward['assigned_to'] : '-'; ?></td>
                                    <td><?php echo number_format($estimation,2); ?></td>
                                    <td><?php echo number_format($paid,2); ?></td>
                                    <td><?php echo number_format($balance,2); ?></td>
                                </tr>
                                <?php $i++;
                            }
                        } else {
                            ?>
                            <tr>
                                <td class="text-center" colspan="9">No Inward Found</td>
                            </tr>
                            <?php
                        } ?>
                        </tbody>
                    </table>
                </div><!-- /.row -->
            </div><!-- /#feed -->
        </div>
    </div>
    <div id="send-msg" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="blue bigger">Please fill the following form fields</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="space-4"></div>
                            <div class="form-group">
                                <label for="form-field-username">Name</label>
                                <div>
                                    <input type="text" id="form-field-username" placeholder="Name" value="<?php echo $_SESSION['USER_NAME']?>" />
                                </div>
                            </div>
                            <div class="space-4"></div>
                            <div class="form-group">
                                <label for="form-field-first">Message</label>
                                <div>
                                    <textarea class="form-control" name="msg" rows="5" placeholder="Type your message here.."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-xs" data-dismiss="modal">
                        <i class="ace-icon fa fa-times"></i>
                        Cancel
                    </button>
                    <button class="btn btn-xs btn-primary">
                        <i class="ace-icon fa fa-check"></i>
                        Send
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php } else{ ?>
    <h4 class="text-center text-danger">Sorry, No data Found</h4>
<?php }?>
