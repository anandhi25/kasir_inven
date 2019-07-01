 
<footer class="main-footer">
      
        <strong>Copyright &copy; <?php echo date("Y") ?> <a href="http://codeslab.net">codeslab.net</a>.</strong> All rights reserved.
      </footer>
      
 </div><!-- ./wrapper -->

<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>asset/js/bootstrap.min.js" type="text/javascript"></script>
<!--<script src="--><?php //echo base_url(); ?><!--asset/js/menu.js" type="text/javascript"></script>-->
<!--<script src="--><?php //echo base_url(); ?><!--asset/js/custom-validation.js" type="text/javascript"></script>-->
<script src="<?php echo base_url(); ?>asset/js/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>asset/js/app.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>asset/js/form-validation.js" type="text/javascript"></script>
<!-- Jasny Bootstrap for NIce Image Change -->
<script src="<?php echo base_url() ?>asset/js/jasny-bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>asset/js/bootstrap-datepicker.js" ></script>
<script src="<?php echo base_url() ?>asset/js/timepicker.js" ></script>
<!-- Data Table -->
<!--<script src="--><?php //echo base_url(); ?><!--asset/js/plugins/metisMenu/metisMenu.min.js" type="text/javascript"></script>-->
<script src="<?php echo base_url(); ?>asset/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>asset/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>asset/js/chartjs/Chart.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>asset/js/chartjs/dashboard.js" type="text/javascript"></script>


    <script>
    $(document).ready(function() {
        $('#dataTables-example').dataTable();
    });
    cart_table = $('#cart_table').DataTable({
        processing: true,
        serverSide: true,
        "bDestroy": true,
        aaSorting: [[0, 'desc']],
        "ajax": {
            url: '<?php echo base_url("admin/product/cart_product_table");?>',
            "data": function (d) {

            }
        }
    });
    </script>




</body>
</html>
