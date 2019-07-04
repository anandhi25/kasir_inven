<div class="modal fade modal-wide" <?php echo $modal_id;?>

    <div id="product_modal" class="modal-dialog">
        <div class="modal-content">

        </div>
    </div>

</div>

<script type="text/javascript">



    $('body').on('hidden.bs.modal', '.modal', function() {
        $(this).removeData('bs.modal');
    });


</script>