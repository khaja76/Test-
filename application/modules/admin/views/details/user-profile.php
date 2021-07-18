<style>
    .folder {
        width: 130px;
    }

    .folders a {
        text-decoration: none;
    }
</style>
<h3 class="header smaller lighter">
    User Profile
    <span class="pull-right">
     <a href="#" onclick="goBack()" class="btn btn-xs btn-warning"><i class="fa fa-arrow-left"></i> Back</a>
    </span>
</h3>
<?php echo getMessage(); ?>
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
                <i class="orange ace-icon fa fa-folder bigger-120"></i>
                Documents
            </a>
        </li>
    </ul>
    <div class="tab-content no-border">
        <div id="home" class="tab-pane in active">
            <?php include_once currentModuleView('admin') . 'common_pages/profile.php' ?>
        </div><!-- /#home -->
        <?php         
        if(empty($documents)){
            $documents = !empty($profile) ? $profile : ''; 
        }         
        ?>
        <div id="inwards" class="tab-pane">
            <div class="profile-feed row">
                <ul class="list-inline folders">
                    <li>
                        <?php if (!empty($documents['resume']) && file_exists(FCPATH . $documents['path'] . $documents['resume'])) { ?>
                            <a href="<?php echo base_url() . $documents['path'] . $documents['resume']; ?>" target="_blank">
                                <img src="<?php echo base_url() ?>data/icons/folder.png" alt="Documents" class="folder"/>
                            </a>
                        <?php } else {
                            ?>
                            <img src="<?php echo base_url() ?>data/icons/empty-folder.png" alt="Documents" class="folder"/>
                            <?php
                        } ?>
                        <h4 class="text-center">Resume</h4>
                    </li>
                    <li>
                        <?php if (!empty($documents['experience_letter']) && file_exists(FCPATH . $documents['path'] . $documents['experience_letter'])) { ?>
                            <a href="<?php echo base_url() . $documents['path'] . $documents['experience_letter']; ?>" target="_blank">
                                <img src="<?php echo base_url() ?>data/icons/folder.png" alt="Documents" class="folder"/>
                            </a>
                        <?php } else { ?>
                            <img src="<?php echo base_url() ?>data/icons/empty-folder.png" alt="Documents" class="folder"/>
                            <?php
                        }
                        ?>
                        <h4 class="text-center">Experience Letter</h4>
                    </li>
                    <li>
                        <?php if (!empty($documents['bond_paper']) && file_exists(FCPATH . $documents['path'] . $documents['bond_paper'])) { ?>
                            <a href="<?php echo base_url() . $documents['path'] . $documents['bond_paper']; ?>" target="_blank">
                                <img src="<?php echo base_url() ?>data/icons/folder.png" alt="Documents" class="folder"/>
                            </a>
                        <?php } else {
                            ?>
                            <img src="<?php echo base_url() ?>data/icons/empty-folder.png" alt="Documents" class="folder"/>
                            <?php
                        } ?>
                        <h4 class="text-center">Bond Paper</h4>
                    </li>
                    <li>
                        <?php if (!empty($documents['others']) && file_exists(FCPATH . $documents['path'] . $documents['others'])) { ?>
                            <a href="<?php echo base_url() . $documents['path'] . $documents['others']; ?>" target="_blank">
                                <img src="<?php echo base_url() ?>data/icons/folder.png" alt="Documents" class="folder"/>
                            </a>
                        <?php } else {
                            ?>
                            <img src="<?php echo base_url() ?>data/icons/empty-folder.png" alt="Documents" class="folder"/>
                            <?php
                        } ?>
                        <h4 class="text-center">Docs</h4>
                    </li>
                    <li>
                        <?php if (!empty($documents['others2']) && file_exists(FCPATH . $documents['path'] . $documents['others2'])) { ?>
                            <a href="<?php echo base_url() . $documents['path'] . $documents['others2']; ?>" target="_blank">
                                <img src="<?php echo base_url() ?>data/icons/folder.png" alt="Documents" class="folder"/>
                            </a>
                        <?php } else {
                            ?>
                            <img src="<?php echo base_url() ?>data/icons/empty-folder.png" alt="Documents" class="folder"/>
                            <?php
                        } ?>
                        <h4 class="text-center">Others</h4>
                    </li>
                </ul>
            </div>
        </div>
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
                                <input type="text" id="form-field-username" placeholder="Name" value="Bhargav Krishna"/>
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
                <button class="btn btn-sm" data-dismiss="modal">
                    <i class="ace-icon fa fa-times"></i>
                    Cancel
                </button>
                <button class="btn btn-sm btn-primary">
                    <i class="ace-icon fa fa-check"></i>
                    Send
                </button>
            </div>
        </div>
    </div>
</div>
