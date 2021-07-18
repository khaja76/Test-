<?php
    isLoginExists();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo !empty($title) ? $title : 'Hifi Technologies '; ?></title>
    <meta name="description" content=""/>
    <meta http-equiv="CACHE-CONTROL" content="NO-CACHE">
    <meta http-equiv="PRAGMA" content="NO-CACHE">
    <meta http-equiv="EXPIRES" content="0">
    
    
    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui.min.css"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <!-- page specific plugin styles -->
    <!-- text fonts -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/fonts.googleapis.com.css"/>
    <!-- ace styles -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style"/>
    <!--[if lte IE 9]>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace-part2.min.css" class="ace-main-stylesheet"/>
    <![endif]-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace-skins.min.css"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-datepicker3.min.css"/>

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace-ie.min.css"/>

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style-custom.css"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/dashboard-styles.css"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/magnific-popup.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.css"/>
    <!--[if lt IE 9]>
    <script src="<?php echo base_url(); ?>assets/js/html5shiv.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/respond.min.js"></script>
    <![endif]-->
    <script src="<?php echo base_url(); ?>assets/js/jquery-2.1.4.min.js"></script>

    <!--<script type="text/javascript">
        if('ontouchstart' in document.documentElement) document.write("<script src='<?php /*echo base_url() */?>assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
    </script>-->

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
            <a href="<?php echo base_url() ?>reception/" class="navbar-brand">
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
                        
                        <span class="user-info">
									<small>Welcome,</small>
									<?php echo !empty($_SESSION) ? $_SESSION['USER_NAME'] : 'HIFI' ?>
								</span>
                        <i class="ace-icon fa fa-caret-down"></i>
                    </a>
                    <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                       <li>
                            <a href="<?php echo base_url() ?>reception/profile/">
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
            <h6 class="white"> Reception ( <?php echo !empty($_SESSION['BRANCH_CODE']) ? $_SESSION['BRANCH_CODE']:'';?> )</h6>
        </span>
        <ul class="nav nav-list">
            <li <?php echo !empty(explode('/', $_SERVER['REQUEST_URI'])[2]) ? "" : "class='active'"?>>
                <a href="<?php echo base_url() ?>reception/">
                    <i class="menu-icon fa fa-tachometer"></i>
                    <span class="menu-text"> Dashboard </span>
                </a>
                <b class="arrow"></b>
            </li>
            <li <?php echo get_active_link(['customers']);?>>
                <a href="<?php echo base_url(); ?>reception/customers">
                    <i class="menu-icon fa fa-user"></i>
                    <span class="menu-text">Add Customer </span>
                </a>
                <b class="arrow"></b>
            </li>
            <li <?php echo get_active_link(['inwards']);?>>
                <a  href="<?php echo base_url(); ?>reception/inwards/add">
                    <i class="menu-icon fa fa-arrow-left"></i>
                    <span class="menu-text">Add Inwards</span>
                </a>
            </li>
            <li <?php echo get_active_link(['messages']);?>>
                <a href="<?php echo base_url(); ?>reception/messages/">
                    <i class="menu-icon fa fa-envelope"></i>
                    <span class="menu-text"> Messages </span>
                    <?php echo !empty($messageCnt) ? '<span class="badge badge-danger">'.$messageCnt.'</span>':'' ?>
                </a>
                <b class="arrow"></b>
            </li>

            <li <?php echo get_active_link(['products','components']);?>>
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-shopping-cart"></i>
                    <span class="menu-text">Stores</span>
                    <b class="arrow fa fa-angle-down"></b>
                </a>
                <ul class="submenu">
                    <li >
                        <a href="<?php echo base_url(); ?>reception/products/">
                            <i class="ace-icon fa fa-product-hunt bigger-110 blue"></i>
                            Products
                        </a>
                        <b class="arrow"></b>
                    </li>
                    <li >
                        <a href="<?php echo base_url(); ?>reception/components/">
                            <i class="ace-icon fa fa-copyright bigger-110 blue"></i>
                            Components
                        </a>
                        <b class="arrow"></b>
                    </li>
                </ul>
            </li>
            <li <?php echo get_active_link(['spares']);?>>
                <a href="<?php echo base_url(); ?>reception/spares/">
                    <i class="menu-icon fa fa-wrench"></i>
                    <span class="menu-text"> Spare Requests </span>
                </a>
                <b class="arrow"></b>
            </li>
            <li <?php echo get_active_link(['outwards']);?>>
                <a href="<?php echo base_url(); ?>reception/outwards/">
                    <i class="menu-icon fa fa-arrow-right"></i>
                    <span class="menu-text"> Outwards </span>
                </a>
                <b class="arrow"></b>
            </li>
            <li <?php echo get_active_link(['inwards']);?>>
                <a href="<?php echo base_url(); ?>reception/inwards/approvals">
                    <i class="menu-icon fa fa-check"></i>
                    <span class="menu-text">Inward Approvals </span>
                </a>
                <b class="arrow"></b>
            </li>
            <!--<li <?php /*echo get_active_link(['payments']);*/?>>
                <a href="<?php /*echo base_url(); */?>reception/payments/">
                    <i class="menu-icon fa fa-money"></i>
                    <span class="menu-text"> Payments </span>
                </a>
                <b class="arrow"></b>
            </li>-->
        </ul><!-- /.nav-list -->
        <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
            <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
        </div>
    </div>
    <div class="main-content" >
        <div class="main-content-inner">
            <div class="page-content">
