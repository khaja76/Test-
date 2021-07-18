
<script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>
<!-- <![endif]-->
<!--[if IE]>
<script src="<?php echo base_url() ?>assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->
<script type="text/javascript">
    if ('ontouchstart' in document.documentElement) document.write("<script src='<?php echo base_url() ?>assets/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
</script>
<script>
    //jQuery(function ($) {
    $(document).ready(function(){
        var url="<?php echo base_url();?>";
        var loader = $($.parseHTML('<p>')).addClass('loader');
        $($.parseHTML('<object>')).attr({ 'data': url+'data/icons/preloader.svg', 'type': 'image/svg+xml' }).addClass('loader_img').appendTo(loader);
        loader.prependTo('body');
        $(window).load(function () {
            $('body').find(".loader").fadeOut("slow");
            $('.main-content').fadeIn("slow");
        });
    });
</script>
</body>
</html>