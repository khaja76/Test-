</div><!-- /.page-content -->
</div>
</div><!-- /.main-content -->

<div class="footer">
    <div class="footer-inner">
        <div class="footer-content">
            <span class="bigger-120">
                <span class="blue bolder"><?php echo !empty($product_name) ? $product_name : ''; ?></span>
                Application &copy; 2017-2018
            </span>
        </div>
    </div>
</div>

<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
    <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
</a>
</div>
<script type="text/javascript">
    if ('ontouchstart' in document.documentElement) document.write("<script src='<?php echo base_url() ?>assets/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
</script>
<script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>


<!-- page specific plugin scripts -->

<!-- ace scripts -->
<script src="<?php echo base_url(); ?>assets/js/jquery-ui.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/ace-elements.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/ace.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.maskedinput.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.magnific-popup.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/custom-script.js"></script>
<!-- inline scripts related to this page -->
<script>
    $(function(){
        $('form').attr('autocomplete','off');
    });
</script>
</body>
</html>