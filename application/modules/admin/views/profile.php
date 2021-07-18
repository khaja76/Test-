<style>
    .profile-info-value > span + span:before {
        content: '' !important;
    }
</style>
<h3 class="header smaller lighter">
    User Profile
    <span class="pull-right">
    <?php if (!empty($_SERVER['HTTP_REFERER']) && ($_SERVER['HTTP_REFERER'] == base_url() . 'admin/profile')) { ?>
        <a href="#" onclick="goBack()" class="btn btn-xs btn-warning"><i
                    class="fa fa-arrow-left"></i> Back</a>
    <?php } ?>
   </span>
</h3>
<?php
$role = (($_SESSION['ROLE'] == "ADMIN") || ($_SESSION['ROLE'] == "SUPER_ADMIN")) ? 'admin' : 'reception';
echo getMessage(); ?>
<div class="tabbable">
    <ul class="nav nav-tabs padding-18">
        <li class="active">
            <a data-toggle="tab" href="#home">
                <i class="green ace-icon fa fa-user bigger-120"></i>
                Profile
            </a>
        </li>
        <?php
        if ($_SESSION['ROLE'] == 'SUPER_ADMIN') {
            ?>
            <li class="hide">
                <a data-toggle="tab" href="#feed">
                    <i class="orange ace-icon fa fa-rss bigger-120"></i>
                    Others
                </a>
            </li>
        <?php } ?>
    </ul>
    <div class="tab-content no-border padding-24">
        <div id="home" class="tab-pane in active">
            <div class="row">
                <div class="col-xs-12 col-sm-3 center">
                    <span class="profile-picture">
                        <?php if (!empty($profile['thumb_img']) && file_exists(FCPATH . $profile['img_path'] . $profile['thumb_img'])) { ?>
                            <img class="max-200" alt="Avatar" src="<?php echo base_url() . $profile['img_path'] . $profile['thumb_img']; ?>"/>
                        <?php } else { ?>
                            <img src="<?php echo dummyLogo() ?>" alt="your image" class="max-200"/>
                        <?php } ?>
                    </span>
                    <div class="space space-4"></div>
                    <?php
                    if ($_SESSION['ROLE'] == 'SUPER_ADMIN') { ?>
                        <a href="<?php echo base_url() . $role ?>/profile/edit/" class="btn btn-sm btn-block btn-success">
                            <i class="ace-icon fa fa-pencil bigger-110"></i>
                            <span class="bigger-110">Edit Profile</span>
                        </a>
                    <?php } ?>
                </div><!-- /.col -->
                <div class="col-xs-12 col-sm-9">
                    <div class="profile-user-info">
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Name :</div>
                            <div class="profile-info-value">
                                <h4 class="blue"><?php echo !empty($profile['name']) ? $profile['name'] : ''; ?></h4>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Email :</div>
                            <div class="profile-info-value">
                                <span><?php echo !empty($profile['email']) ? $profile['email'] : ''; ?></span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Password :</div>
                            <div class="profile-info-value">
                                <span><?php echo !empty($profile['password']) ? $profile['password'] : ''; ?></span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Phone No :</div>
                            <div class="profile-info-value">
                                <span><?php echo !empty($profile['phone']) ? $profile['phone'] : ''; ?></span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Address :</div>
                            <div class="profile-info-value">
                                <?php !empty($profile['address1']) ? '<i class="fa fa-map-marker light-orange bigger-110"></i>' : '' ?>
                                <span><?php echo !empty($profile['address1']) ? $profile['address1'] : 'NA'; ?></span>
                                <span><?php echo !empty($profile['address2']) ? !empty($profile['address1']) ? ', ' . $profile['address2'] : $profile['address2'] : ''; ?></span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> City :</div>
                            <div class="profile-info-value">
                                <span><?php echo !empty($profile['city']) ? $profile['city'] : 'NA'; ?></span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> State :</div>
                            <div class="profile-info-value">
                                <span><?php echo !empty($profile['state_name']) ? $profile['state_name'] : '' ?></span><!-- For Super Admin -->
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Pincode :</div>
                            <div class="profile-info-value">
                                <span><?php echo !empty($profile['pincode']) ? $profile['pincode'] : 'NA'; ?></span>
                            </div>
                        </div>
                    </div>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /#home -->
        <?php
        if ($_SESSION['ROLE'] == 'SUPER_ADMIN') {
            ?>
            <div id="feed" class="tab-pane">
                <div class="profile-feed row">
                    <div class="col-sm-4">
                        <form action="" id="frm" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>License documents</label>
                                <input type="file" class="input-file-2" name="office_license"/>
                            </div>
                            <div class="form-group">
                                <label>Rental documents</label>
                                <input type="file" class="input-file-2" name="rental"/>
                            </div>
                            <div class="form-group">
                                <label>Broadband documents</label>
                                <input type="file" class="input-file-2" id="" name="rental"/>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-success btn-xs">Save</button>
                            </div>
                        </form>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div>
        <?php }
        ?>
    </div>
</div>
