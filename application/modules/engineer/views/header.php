<?php
    isLoginExists();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta charset="utf-8"/>
    <title><?php  echo !empty($title) ? $title : 'HIFI Technologies'  ?></title>
    <meta name="description" content="overview &amp; stats"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <meta http-equiv="CACHE-CONTROL" content="NO-CACHE">
    <meta http-equiv="PRAGMA" content="NO-CACHE">
    <meta http-equiv="EXPIRES" content="0">
    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui.min.css"/>
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/fonts.googleapis.com.css"/>
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap-datepicker3.min.css"/>
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/magnific-popup.min.css"/>
    <!-- ace styles -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style"/>
    <!--[if lte IE 9]>
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/ace-part2.min.css" class="ace-main-stylesheet"/>
    <![endif]-->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/ace-skins.min.css"/>
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/ace-rtl.min.css"/>
    <!--[if lte IE 9]>
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/ace-ie.min.css"/>
    <![endif]-->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/style-custom.css"/>
    <!-- inline styles related to this page -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/dashboard-styles.css"/>
    <!-- ace settings handler -->
    <script src="<?php echo base_url() ?>assets/js/jquery-2.1.4.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/ace-extra.min.js"></script>
    <!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->
    <!--[if lte IE 8]>
    <script src="<?php echo base_url() ?>assets/js/html5shiv.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/respond.min.js"></script>
    <![endif]-->
</head>
<body class="skin-1">
<div id="navbar" class="navbar navbar-default ace-save-state">
    <div class="navbar-container ace-save-state" id="navbar-container">
        <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
            <span class="sr-only">Toggle sidebar</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <div class="navbar-header pull-left">
            <a href="<?php  echo base_url() ?>engineer/" class="navbar-brand">
                <small>
                    <i class="fa fa-shopping-cart"></i>
                    HIFI
                </small>
            </a>
        </div>
        <div class="navbar-buttons navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav">
                
                <li class="light-blue dropdown-modal">
                    <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                        <!--<img class="nav-user-photo" src="<?php /*echo dummyLogo() */?>" alt="Jason's Photo"/>-->
                        <span class="user-info">
									<small>Welcome,</small>
									<?php echo !empty($_SESSION) ? $_SESSION['USER_NAME'] : 'HIFI' ?>
								</span>
                        <i class="ace-icon fa fa-caret-down"></i>
                    </a>
                    <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                       <li>
                            <a href="<?php echo base_url()?>engineer/profile/">
                                <i class="ace-icon fa fa-user"></i>
                                Profile
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="<?php echo base_url(); ?>logout/">
                                <i class="ace-icon fa fa-power-off"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div><!-- /.navbar-container -->
</div>
<div class="main-container ace-save-state" id="main-container">
    <script type="text/javascript">
        try {
            ace.settings.loadState('main-container')
        } catch (e) {
        }
    </script>
    <div id="sidebar" class="sidebar responsive ace-save-state">
        <script type="text/javascript">
            try {
                ace.settings.loadState('sidebar')
            } catch (e) {
            }
        </script>
        <span class="text-center">
            <h6 class="white"> Engineer ( <?php echo !empty($_SESSION['BRANCH_CODE']) ? $_SESSION['BRANCH_CODE']:'';?> ) </h6>
        </span>
        <ul class="nav nav-list menu">
            <li <?php echo !empty(explode('/', $_SERVER['REQUEST_URI'])[2]) ? "" : "class='active'"?>>
                <a href="<?php echo base_url();  ?>engineer/">
                    <i class="menu-icon fa fa-tachometer"></i>
                    <span class="menu-text"> Dashboard </span>
                </a>
                <b class="arrow"></b>
            </li>
            <li <?php echo get_active_link(['spares']); ?>>
                <a href="<?php echo base_url(); ?>engineer/spares/">
                    <i class="menu-icon fa fa-wrench"></i>
                    <span class="menu-text">Spare Request <?php echo !empty($spare_grant_cnt) ? '<span class="badge badge-success"> '.$spare_grant_cnt.' </span>' : ''?> </span>
                </a>
                <b class="arrow"></b>
            </li>
            <li <?php echo get_active_link(['messages']); ?>>
                <a href="<?php echo base_url(); ?>engineer/messages/">
                    <i class="menu-icon fa fa-envelope"></i>
                    <span class="menu-text"> Messages  </span>
                    <?php echo !empty($messageCnt) ? '<span class="badge badge-danger">'.$messageCnt.'</span>':'' ?>
                </a>
                <b class="arrow"></b>
            </li>
            <li <?php echo get_active_link(['inwards']); ?>>
                <a href="<?php echo base_url(); ?>engineer/inwards/damage/">
                    <i class="menu-icon fa fa-camera"></i>
                    <span class="menu-text"> Damaged Images</span>
                </a>
                <b class="arrow"></b>
            </li>
            <li <?php echo get_active_link(['inwards']); ?>>
                <a href="<?php echo base_url(); ?>engineer/inwards/approvals/">
                    <i class="menu-icon fa fa-check"></i>
                    <span class="menu-text">Inward Approvals <span class="badge badge-danger"><?php echo !empty($approvals) ? $approvals : 0; ?></span></span>
                </a>
                <b class="arrow"></b>
            </li>
        </ul><!-- /.nav-list -->
        <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
            <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
        </div>
    </div>
    <div class="main-content" style="display: none">
        <div class="main-content-inner">
            <div class="page-content">
