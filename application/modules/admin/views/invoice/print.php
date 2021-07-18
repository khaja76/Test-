<html>

<head>

    <title> <?php echo !empty($invoice) ? $invoice['invoice'] : '' ?></title>

</head>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css"/>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style"/>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace-skins.min.css"/>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style-custom.css"/>



<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>

<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

<style>

    @media print {
        html, body {
            height:100vh; 
            margin: 0 !important; 
            padding: 0 !important;
            overflow: hidden;
        }
        .print-third {

            width: 32% !important;

            float: left !important;

        }



        body {

            font-family: 'Roboto', sans-serif;

            margin: 0;

        }



        .spaced > li {

            margin-top: 2px;

            margin-bottom: 2px;

        }



        .m-0 {

            margin: 0;

        }



        .w-180 {

            width: 180px;

        }

        .print:last-child {

            page-break-after: auto;

        }

        html, body {

            height:100vh;

            margin: 0 !important;

            padding: 0 !important;



        }

        .well{

            margin-bottom: 0 !important;

        }

    }



    /*body{

        font-family: 'Roboto', sans-serif;

    }

    .w-100{

        width:100px;

    }

    .w-145{

        width:145px;

    }



    .w-350{

        width:350px;

    }

    .w-180{

        width:180px;

    }

    .spaced > li{

        margin-top:2px;

        margin-bottom:2px;

    }*/

</style>



<!--<link rel="stylesheet" href="<?php /*echo base_url();*/ ?>/assets/css/dashboard-styles.css"/>-->

</head>

<body onload="window.print();">

<div class="space-12"></div>

<div class="col-md-12" id="testprnt">

    <?php include 'common.php' ?>

</div>

</body>

</html>