<html>
<head>
    <title> <?php echo !empty($quotation) ? $quotation['quotation'] : '' ?></title>
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
        .mr-0 {
            margin: 0 0 5px !important;
        }        
        b,strong,h1,h2,h3,h4,h5,h6{font-weight:normal;}
    }
    .quote:last-child {
        page-break-after: auto;
    }
</style>
</head>
<body onload="window.print();" onfocus="window.close();">
<div class="space-12"></div>
<div class="col-md-12 print">
    <?php include 'common.php' ?>
</div>
</body>
</html>