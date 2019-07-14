<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>
<!--/ Massage-->


<section class="content">
    <div class="row">
        <div class="col-md-12">

            <div class="box box-primary ">
                <div class="box-header box-header-background with-border">
                    <h3 class="box-title "><?php echo $title;?></h3>
                </div>


                <div class="box-body">
                    <div class="row">

                        <?= form_open($url_action, [
                            'name'    => 'form_menu',
                            'class'   => 'form-horizontal',
                            'id'      => 'form_menu',
                            'method'  => 'POST'
                        ]); ?>
                        <input type="hidden" value="<?= $menu_type_id; ?>" name="menu_type_id">


                        <div class="form-group menu-only">
                            <label for="content" class="col-sm-2 control-label"><?= 'Label' ?> </label>

                            <div class="col-sm-8">
                                <input type="hidden" name="icon" id="icon">

                                <div class="icon-preview">
                                    <span class="icon-preview-item"><i class="fa fa-rss fa-lg"></i></span>
                                </div>
                                <br>
                                <br>

                                <a class="btn btn-default btn-select-icon btn-flat"><?= 'Pilih Icon' ?></a>

                                <select class="chosen  chosen-select-deselect" name="icon_color" id="icon_color" tabi-ndex="5" data-placeholder="Select Color">
                                    <option value="default">Default</option>
                                    <?php foreach ($color_icon as $color): ?>
                                        <option value="<?= $color; ?>"><?= ucwords($color); ?></option>
                                    <?php endforeach; ?>
                                </select>

                            </div>
                        </div>


                        <div class="form-group ">
                            <label for="content" class="col-sm-2 control-label"><?= "Parent"; ?></label>

                            <div class="col-sm-8">
                                <select  class="form-control chosen  chosen-select-deselect" name="parent" id="parent" tabi-ndex="5" data-placeholder="Select Parent">
                                    <option value="0"></option>
                                    <?php foreach (get_menu($this->menu_model->get_id_menu_type_by_flag($this->uri->segment(4))) as $row): ?>
                                        <option value="<?= $row->id; ?>"  ><?= ucwords($row->label); ?></option>
                                        <?php if (isset($row->children) and count($row->children)): ?>
                                            <?php create_childern($row->children, 0, 1); ?>
                                        <?php endif ?>
                                    <?php endforeach; ?>

                                </select>


                                <small class="info help-block">
                                    Select one or more groups.
                                </small>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="label" class="col-sm-2 control-label"><?= "Label"; ?> <i class="required">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="label" id="label" placeholder="Label" value="<?= set_value('label'); ?>">
                                <small class="info help-block">The label of menu.</small>
                            </div>
                        </div>


                        <div class="form-group ">
                            <label for="link" class="col-sm-2 control-label"><?= "Link"; ?> <i class="required">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="link" id="link" placeholder="Link" value="<?= set_value('link'); ?>">
                                <small class="info help-block">The link of menu <i>Example : administrator/blog</i>.</small>
                            </div>
                        </div>


                        <div class="form-group ">
                            <label for="content" class="col-sm-2 control-label"><?= "Menu Type" ?></label>

                            <div class="col-sm-8">
                                <label class="col-md-2 padding-left-0">
                                    <input  type="radio" name="type" class="flat-green menu_type" value="menu" checked> <?= "Menu" ?>
                                </label>
                                <label>
                                    <input  type="radio" name="type" class="flat-green menu_type" value="label"> <?= "Label" ?>
                                </label>
                                <small class="info help-block">
                                    Type Of Menu.
                                </small>
                            </div>
                        </div>

                        <div class="row-fluid col-md-7">
                                <button name="submit_menu" class="btn btn-primary" type="submit">Simpan</button>

                        </div>


                        <?= form_close(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
    $(document).ready(function() {


        $('#icon_color').change(function(event) {
            $('.icon-preview-item').attr('class', 'icon-preview-item '+$(this).val());
        });
        var menu_type = $('.menu_type');

        menu_type.on('click', function(event) {
            var type = $(this).val();
            updateMenuType(type);
        });

        function updateMenuType(type) {
            if (type == 'menu') {
                $('.menu-only').show();
            } else {
                $('.menu-only').hide();
            }
        }


    });



</script>