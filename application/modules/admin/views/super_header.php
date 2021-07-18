<?php
isLoginExists();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta charset="utf-8"/>
    <title><?php echo !empty($title) ? $title : 'Hifi Technologies '; ?></title>
    <meta name="description" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui.min.css"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/fonts.googleapis.com.css"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace-part2.min.css" class="ace-main-stylesheet"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace-skins.min.css"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-datepicker3.min.css"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/dashboard-styles.css"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace-ie.min.css"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style-custom.css"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/magnific-popup.min.css">
    <script src="<?php echo base_url(); ?>assets/js/html5shiv.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/respond.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript">
        if ('ontouchstart' in document.documentElement) document.write("<script src='<?php echo base_url() ?>assets/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
    </script>
</head>
<body class="skin-1">
<div id="navbar" class="navbar navbar-default ace-save-state">
    <div class="navbar-container ace-save-state" id="navbar-container">
        <div class="navbar-header pull-left">
            <a href="<?php echo base_url() ?>admin/" class="navbar-brand">
                <small>
                    <i class="fa fa-shopping-cart"></i>
                    HIFI
                </small>
            </a>
            <button class="pull-right navbar-toggle navbar-toggle-img collapsed" type="button" data-toggle="collapse" data-target=".navbar-buttons,.navbar-menu">
                <span class="sr-only">Toggle user menu</span>
                <img src="<?php echo base_url(); ?>/data/logo-xs.png" alt="Hifi Technologies"/>
            </button>
        </div>
        <div class="navbar-buttons navbar-header pull-right collapse navbar-collapse" role="navigation">
            <ul class="nav ace-nav">
                <li class="purple dropdown-modal" id="notifications"></li>
                <li class="light-blue dropdown-modal">
                    <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                        <span class="user-info">
                            <small>Welcome,</small>
                            <?php echo !empty($_SESSION) ? $_SESSION['USER_NAME'] : '' ?>
                        </span>
                        <i class="ace-icon fa fa-caret-down"></i>
                    </a>
                    <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                        <li>
                            <a href="<?php echo base_url() ?>admin/profile/">
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
        <nav role="navigation" class="navbar-menu pull-left collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li <?php echo get_active_link(['locations']); ?>>
                    <a href="<?php echo base_url(); ?>admin/locations/">
                        <i class="fa fa-map-marker bigger-110"></i> Locations &nbsp;
                    </a>
                </li>
                <li <?php echo get_active_link(['branches']); ?>>
                    <a href="<?php echo base_url(); ?>admin/branches/">
                        <i class="fa fa-map-marker bigger-110"></i> Branches &nbsp;
                    </a>
                </li>
                <li <?php echo get_active_link(['subOrdinates', 'track']); ?>>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="ace-icon fa fa-users bigger-110"></i> Sub Ordinates &nbsp;
                        <i class="ace-icon fa fa-angle-down bigger-110"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-light-blue dropdown-caret">
                        <li>
                            <a href="<?php echo base_url(); ?>admin/subOrdinates/">
                                <i class="ace-icon fa fa-eye bigger-110 blue"></i>
                                View / Edit
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>admin/subOrdinates/track/">
                                <i class="ace-icon fa fa-cube bigger-110 blue"></i>
                                Track
                            </a>
                        </li>
                    </ul>
                </li>
                <li <?php echo get_active_link(['customers']); ?>>
                    <a href="<?php echo base_url(); ?>admin/customers/">
                        <i class="ace-icon fa fa-user bigger-110"></i> Customers &nbsp;
                    </a>
                </li>
                <li <?php echo get_active_link(['messages']); ?>>
                    <a href="<?php echo base_url(); ?>admin/messages/">
                        <i class="ace-icon fa fa-envelope bigger-110"></i> Messages &nbsp;
                        <?php echo !empty($messageCnt) ? '<span class="badge badge-danger">' . $messageCnt . '</span>' : '' ?>
                    </a>
                </li>
            </ul>
        </nav>
    </div><!-- /.navbar-container -->
</div>
<div class="main-container ace-save-state" id="main-container">
    <div id="sidebar" class="sidebar responsive ace-save-state">
        
        <span class="text-center">
            <h6 class="white"> Super Admin </h6>
        </span>
        <ul class="nav nav-list">
            <li <?php echo !empty(explode('/', $_SERVER['REQUEST_URI'])[2]) ? "" : "class='active'" ?>>
                <a href="<?php echo base_url() ?>admin/">
                    <i class="menu-icon fa fa-tachometer"></i>
                    <span class="menu-text"> Dashboard </span>
                </a>
                <b class="arrow"></b>
            </li>
            <li <?php echo get_active_link(['inwards']); ?>>
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-arrow-left"></i>
                    <span class="menu-text">Inwards</span>
                    <b class="arrow fa fa-angle-down"></b>
                </a>
                <ul class="submenu">
                    <li>
                        <a href="<?php echo base_url(); ?>admin/inwards/">
                            <i class="ace-icon fa fa-eye bigger-110 blue"></i>
                            View
                        </a>
                        <b class="arrow"></b>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>admin/inwards/challans/">
                            <i class="ace-icon fa fa-image bigger-110 blue"></i>
                            Inward Challans
                        </a>
                        <b class="arrow"></b>
                    </li>
                </ul>
            </li>
            <li <?php echo get_active_link(['outwards']); ?>>
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-arrow-right "></i>
                    <span class="menu-text"> Outwards</span>
                    <b class="arrow fa fa-angle-down"></b>
                </a>
                <ul class="submenu">
                    <li>
                        <a href="<?php echo base_url(); ?>admin/outwards/">
                            <i class="ace-icon fa fa-eye bigger-110 blue"></i>
                            View
                        </a>
                        <b class="arrow"></b>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>admin/outwards/challans/">
                            <i class="ace-icon fa fa-image bigger-110 blue"></i>
                            Delivery Challans
                        </a>
                        <b class="arrow"></b>
                    </li>
                </ul>
            </li>
            <li <?php echo get_active_link(['payments']); ?>>
                <a href="<?php echo base_url(); ?>admin/payments/">
                    <i class="menu-icon fa fa-money"></i>
                    <span class="menu-text"> Payments </span>
                </a>
                <b class="arrow"></b>
            </li>
            <li <?php echo get_active_link(['reports']) ?>>
                <a href="<?php echo base_url(); ?>admin/reports/">
                    <i class="menu-icon fa fa-bar-chart"></i>
                    <span class="menu-text"> Inward Report </span>
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
