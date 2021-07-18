<html>
<head>
    <title><?php echo ( !empty($challan['challan'])) ? $challan['challan'] : '' ?></title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace-skins.min.css"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style-custom.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
</head>
<body onload="window.print();" onfocus="window.close();"><!--  -->
<div class="space-12"></div>
<?php include_once 'common.php' ?>
</body>
</html>