
<!-- View massage -->
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>

<section class="content">
    <div class="row">
        <div class="col-md-12">

            <div class="box box-primary">
                <div class="box-header box-header-background with-border">
                        <h3 class="box-title "><?php echo $title;?></h3>
                </div>
                <!-- /.box-header -->

                <!-- form start -->
                <form role="form" enctype="multipart/form-data" id="add_page" action="<?php echo $url_action; ?>" method="post">
                    <input type="hidden" name="page_id" id="page_id" value="<?php if(!empty($page)) echo $page->page_id; ?>">
                    <div class="row">

                        <div class="col-md-12">

                            <div class="box-body">

                                <div class="form-group">
                                    <label for="title">Title<span class="required">*</span></label>
                                    <input type="text" name="title" id="title" placeholder="Judul halaman" required
                                           value="<?php if(!empty($page)) echo $page->title ?>"
                                           class="form-control">
                                </div>

                                <!-- /.Company Email -->
                                <div class="form-group">
                                    <label for="description">Deskripsi</label>
                                    <textarea class="form-control" name="description" id="description" rows="3"><?php
                                        if(!empty($page))
                                        {
                                            echo $page->description;
                                        }
                                        ?></textarea>
                                </div>

                                <!-- /.Address -->
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Content<span class="required">*</span></label>
                                    <textarea name="content" id="content" class="form-control" required>
                                        <?php if(!empty($page)) echo $page->content ?>
                                    </textarea>

                                </div>


                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>



                    <div class="box-footer">
                        <button type="submit" id="page_btn" class="btn bg-navy" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
        <!--/.col end -->
    </div>
    <!-- /.row -->
</section>



<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/tinymce/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: "#content",
        theme: "modern",
        height: 300,
        relative_urls: false,
        remove_script_host: false,

        plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
            "save table contextmenu directionality emoticons template paste textcolor responsivefilemanager"
        ],

        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | responsivefilemanager | print preview media fullpage | forecolor backcolor emoticons",
        style_formats: [
            {title: 'Bold text', inline: 'b'},
            {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
            {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
            {title: 'Example 1', inline: 'span', classes: 'example1'},
            {title: 'Example 2', inline: 'span', classes: 'example2'},
            {title: 'Table styles'},
            {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
        ],

        external_filemanager_path:"<?php echo base_url() ?>filemanager/",
        filemanager_title:"File Manager " ,
        external_plugins: { "filemanager" : "<?php echo base_url() ?>filemanager/plugin.min.js"}



    });
</script>
