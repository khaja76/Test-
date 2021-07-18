
<style>
.profile-info-value > span + span:before {
    content:'' !important;
}
</style>
<?php
$pk_id = '';
if (($_SESSION['ROLE'] == "ADMIN") || ($_SESSION['ROLE'] == "SUPER_ADMIN")) {
    $role = "admin";
    $pk_id = $profile['user_id'];
} elseif ($_SESSION['ROLE'] == "RECEPTIONIST") {
    $role = "reception";
} else {
    $role = "engineer";
}
?>
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
        if (!empty($_SESSION['ROLE']) && (($_SESSION['ROLE'] == 'SUPER_ADMIN'))) {
            ?>
            <a href="<?php echo base_url() ?>admin/SubOrdinates/edit/<?php echo $pk_id; ?>" class="btn btn-sm btn-block btn-success">
                <i class="ace-icon fa fa-pencil bigger-110"></i>
                <span class="bigger-110">Edit Profile</span>
            </a>
        <?php }
        ?>
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
            <?php 
            if(!empty($_SESSION['ROLE']) && (($_SESSION['ROLE']=='SUPER_ADMIN')|| ($_SESSION['ROLE']=='ADMIN'))){
            ?>
            <div class="profile-info-row">
                <div class="profile-info-name"> Password :</div>
                <div class="profile-info-value">
                    <span><?php echo !empty($profile['password']) ? $profile['password'] : ''; ?></span>
                </div>
            </div>
            <?php }?>
            <div class="profile-info-row">
                <div class="profile-info-name"> Phone No :</div>
                <div class="profile-info-value">
                    <span><?php echo !empty($profile['phone']) ? $profile['phone'] : ''; ?></span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Address :</div>
                <div class="profile-info-value">
                <?php !empty($profile['address1']) ? '<i class="fa fa-map-marker light-orange bigger-110"></i>':''?>
                <span><?php echo !empty($profile['address1']) ? $profile['address1'] : 'NA'; ?></span>
                <span><?php echo !empty($profile['address2']) ? !empty($profile['address1']) ? ', '.$profile['address2']:$profile['address2'] : ''; ?></span>
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
                    <span><?php echo !empty($profile['state_name']) ? $profile['state_name'] : 'NA'; ?></span>
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
