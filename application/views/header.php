<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta charset="utf-8"/>
    <title><?php echo !empty($title) ? $title : 'Hifi Technologies'; ?></title>
    <meta name="description" content="User login page"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/font-awesome/4.5.0/css/font-awesome.min.css"/>
    <!-- text fonts -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/fonts.googleapis.com.css"/>
    <!-- ace styles -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/ace.min.css"/>
    <!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->
    <!--[if lte IE 8]>
    <script src="<?php echo base_url() ?>assets/js/html5shiv.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/respond.min.js"></script>
    <![endif]-->
    <script src="<?php echo base_url() ?>assets/js/jquery-2.1.4.min.js"></script>
    <style>
        .login-container {
            margin-top: 5%;
        }

        div.help-block {
            color: red;
        }

        .loader {
            position: absolute;
            top: 50%;
            left: 50%;
            margin-top: -150px;
            margin-left: -150px;
            z-index: 1;
        }

        .login-box .forgot-password-link {
            color: #337ab7;
            line-height: 2.5;
        }

        body {
            background: url('<?php echo base_url();?>data/bg-img.jpg') no-repeat;
            -webkit-background-size: cover;
            background-size: cover;
        }

        h4.header {
            margin-top: 0
        }
    </style>
</head>
<body class="login-layout">