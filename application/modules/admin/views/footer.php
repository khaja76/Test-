</div><!-- /.page-content -->
</div>
</div><!-- /.main-content -->
<div class="footer hidden-print">
    <div class="footer-inner">
        <div class="footer-content">
            <span class="bigger-120">
                <span class="blue bolder"><?php echo !empty($product_name) ? $product_name : ''; ?></span>
                Application &copy; <?php echo date('Y')?>
            </span>
        </div>
    </div>
</div>
<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
    <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
</a>
</div><!-- /.main-container -->
<!-- For Remvoing Row -->
<div id="dialog-confirm" class="hide">
    <div class="alert alert-info bigger-110">
        These item will be permanently deleted and cannot be recovered.
    </div>
    <div class="space-6"></div>
    <p class="bigger-110 bolder center grey">
        <i class="ace-icon fa fa-hand-o-right blue bigger-120"></i>
        Are you sure?
    </p>
</div><!-- #dialog-confirm -->
<script src="<?php echo base_url(); ?>assets/js/jquery-ui.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.ui.touch-punch.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.maskedinput.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.magnific-popup.min.js"></script>
<!-- ace scripts -->
<script src="<?php echo base_url() ?>assets/js/ace-elements.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/ace.min.js"></script>
<script src="<?php echo base_url() ?>/assets/js/custom-script.js"></script>
<!-- inline scripts related to this page -->
<script>
    //jQuery(function($) {
$(document).ready(function(){
    function loadLink() {
        var baseUrl="<?php echo base_url();?>";
        $.ajax({
            type: 'POST',
            url: baseUrl+'admin/getNotifications/',
            success: function (data) {
                $("#notifications").html(data);
            }
        });
    }
    loadLink(); // This will run on page load
    setInterval(function () {
        loadLink() // this will run after every 5 seconds
    }, 2500);
    $("body").on("click", ".skip-single", function (e) {
        e.preventDefault();
        $('#notifications').addClass('open');
        var th = $(this);
        var id = th.data('id');
        var burl = "<?php echo base_url(); ?>";
        $.ajax({
            url: burl+'admin/notifications/updateNotificationStatus/',
            type: 'POST',
            data: {'pk_id': id},
            success: function (data) {
                $('#notifications').addClass('open');
                console.log('Notification is removed');
            }
        })
    });
    $("body").on("click", ".skip_all", function (e) {
        e.preventDefault();
        $('#notifications').addClass('open');
        var th = $(this);
        var id = th.data('user_id');
        var burl = "<?php echo base_url(); ?>";
        $.ajax({
            url: burl+'admin/notifications/updateNotificationStatus/',
            type: 'POST',
            data: {'user_id': id},
            success: function (data) {
                $('#notifications').addClass('open');
                console.log('All Notifications are removed');
            }
        })
    });
});
</script>
</body>
</html>