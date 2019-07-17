<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>asset/nestable/nesteable.css">
<style>
    .menu-type-wrapper {
        width: 100%;
        margin-bottom: 5px;
        clear: both;
        display: table;
        margin-top: 10px;
    }
    .menu-type-wrapper .dropdown-menu {
        position: absolute;
    }
    .menu-type {
        padding: 15px 10px;
        background: #FFFFFF;
        color: #5C5A5A !important;
        margin-bottom: : 10px;
        cursor: pointer;
        border: 1px solid #ECECEC;
        width: 90%;
        float: left;
        border-right: none;
    }
    .menu-type-action {
        padding: 15px 10px;
        background: #FFFFFF;
        color: rgb(255, 152, 0) !important;
        margin-bottom: : 10px;
        border: 1px solid #ECECEC;
        width: 10%;
        float: left;
        border-left: none;
    }
    .menu-type-wrapper.active .menu-type {
        background: #ff9800 !important;
        color: #fff !important;
    }
    .menu-type-wrapper.active .menu-type-action {
        background: #ff9800 !important;
        color: #fff !important;
    }
    .menu-type .dropdown-menu {
        right: 0%;
        border-radius: 0px !important;
    }
    .loading-hide {
        margin-left: 10px;
        display: none
    }
    #nesteable a {
        color: #546973 !important;
    }
    .dd-item:hover .dd3-content {
        color: #2F2121 !important;
    }

    .menu-toggle-activate_inactive>.dd3-content {
        background: #FAE0E0 !important;
    }

    .menu-toggle-activate {
        cursor: pointer;
    }

    .dd3-content {
        height: 35px !important;
        padding: 6px 10px 5px 80px !important;
        margin: 0px !important;
    }
    .dd-handle {
        height: 35px !important;
        padding-top: 6px !important;
    }
    .dd-list ol {
        margin-top: 5px !important;
    }
    .dd-label {
        padding-left: 10px !important;
    }

</style>

<!--Massage-->
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
                            <div class="col-md-4">
                                <div class="box-warning">
                                    <div class="box-header with-border">
                                        <h3 class="box-title ">Menu</h3>
                                    </div>
                                    <div class="box-body ">
                                        <!-- Widget: user widget style 1 -->
                                        <div class="menu-type-wrapper <?= $this->uri->segment(4) == 'main-menu' ? 'active' :''; ?>">
                                            <div data-href="<?= site_url('admin/menu_front/index/'.seo_title('main menu')); ?>" class="clickable btn-block menu-type btn-group "> <?= 'Main Menu'; ?>
                                            </div>
                                            <a class="menu-type-action">
                                                &nbsp;
                                            </a>
                                        </div>
                                        <?php foreach (db_get_all_data('tbl_menu_type', 'name!= "main menu"') as $row): ?>
                                            <div class="menu-type-wrapper  <?= $this->uri->segment(4) == url_title($row->name) ? 'active' :''; ?>">
                                                 <span data-href="<?= site_url('admin/menu_front/index/'.seo_title($row->name)); ?>" class="clickable btn-block menu-type btn-group">
                                                    <?= _ent(ucwords($row->name)); ?>

                                                 </span>
                                                <?php
                                                echo btn_delete_attr('admin/menu_front/delete_type/'.$row->id,'fa fa-trash','menu-type-action');
                                                ?>

                                            </div>
                                        <?php endforeach; ?>
                                        <br>
                                        <?php
                                        echo btn_add_modal('admin/menu_front/add_menu_type','myModal','Tambah Tipe Menu','btn btn-primary');
                                        ?>

                                    </div>
                                    <!--/box body -->
                                </div>
                                <!--/box -->
                            </div>

                            <div class="col-md-8">
                                <div class="box-warning">
                                    <!-- Widget: user widget style 1 -->
                                    <div class="box-header with-border">

                                        <h3 class="box-title pull-left"><?= "Menu" ?> <?= ucwords(str_replace('-', ' ', $this->uri->segment(4))); ?></h3>
                                    </div>
                                    <div class="box-body ">
                                        <div class="message">
                                            <div class="callout callout-info btn-flat">
                                                # double click menu to active or inactive
                                            </div>
                                        </div>
                                        <!-- Widget: user widget style 1 -->
                                        <div style="margin: 15px 0px 15px 0px !important;">
                                            <a class="btn btn-flat btn-default btn_add_new" id="btn_add_new" title="add new menu (Ctrl+a)" href="<?= site_url('admin/menu_front/add_menu/'. $this->uri->segment(4)); ?>"><i class="fa fa-plus-square-o" ></i>  <?= "Tambah Menu"; ?></a>
                                            <span class="loading loading-hide"><img src="<?= base_url(); ?>/img/loading-spin-primary.svg"> <i><?= 'loading saving data'; ?></i></span>
                                        </div>
                                        <div class="dd" id="nestable">
                                            <?php
                                            $menu = display_menu_module(0, 1, $this->uri->segment(4), true);
                                            if (empty($menu)): ?>
                                                <div class="box-no-data">No data menu</div>
                                            <?php else:
                                                echo $menu;
                                            endif; ?>
                                        </div>
                                        <div class="nestable-output"></div>
                                    </div>

                                </div>
                                <!--/box body -->
                            </div>
                    </div>


                </div><!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!--/.col end -->
    </div>
    <!-- /.row -->
</section>
<script src="<?= base_url(); ?>asset/nestable/jquery.nestable.js"></script>
<script src="<?php echo base_url() ?>asset/js/notify.js"></script>
<script>
    $(document).ready(function() {
        var timeout;
        $('.dd').on('change', function() {
            clearTimeout(timeout);
            timeout = setTimeout(updateOrderMenu, 2000);
        });

        function updateOrderMenu(ignoreMessage) {
            $('.loading').removeClass('loading-hide');
            var shownotif = true;
            var menu = $('.dd').nestable('serialize');

            if (typeof shownotif == 'undefined') {
                var shownotif = true;
            }


            if (typeof ignoreMessage == 'undefined') {
                var ignoreMessage = false;
            }

            $.ajax({
                url: '<?php echo base_url();?>' + 'admin/menu_front/save_ordering',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    'menu': menu
                },
            })
                .done(function(res) {
                    if (res.success) {
                       // $('.sidebar-menu').html(res.menu);
                        if (shownotif) {
                            if (!ignoreMessage) {
                                $.notify(res.message, {
                                    className:'info',
                                    clickToHide: false,
                                    autoHide: true,
                                    globalPosition: 'top center'});
                            }
                        }
                    } else {
                        if (shownotif) {
                            if (!ignoreMessage) {
                                $.notify(res.message, {
                                    className:'info',
                                    clickToHide: false,
                                    autoHide: true,
                                    globalPosition: 'top center'});
                            }
                        }
                    }
                })
                .fail(function() {
                    if (!ignoreMessage) {
                        $.notify('Error save data please try again later', {
                            className:'error',
                            clickToHide: false,
                            autoHide: true,
                            globalPosition: 'top center'});
                    }
                })
                .always(function() {
                    $('.loading').addClass('loading-hide');
                });
        }

        $('#nestable').nestable({
            group: 1
        });


        $('.clickable').on('click', function() {
            var href = $(this).attr('data-href');

            window.location.href = href;

            return false;
        });

        function setMenuActive(id, status) {
            var data = [];

            data.push({
                name: 'status',
                value: status
            });
            data.push({
                name: 'id',
                value: id
            });

            $.ajax({
                url: '<?php echo base_url() ?>' + '/admin/menu_front/set_status',
                type: 'POST',
                dataType: 'JSON',
                data: data,
            })
                .done(function(data) {
                    if (data.success) {
                        $.notify(data.message, {
                            className:'info',
                            clickToHide: false,
                            autoHide: true,
                            globalPosition: 'top center'});
                        updateOrderMenu(true)
                    } else {
                        $.notify(data.message, {
                            className:'error',
                            clickToHide: false,
                            autoHide: true,
                            globalPosition: 'top center'});
                    }

                })
                .fail(function() {
                    $.notify('Error update status', {
                        className:'error',
                        clickToHide: false,
                        autoHide: true,
                        globalPosition: 'top center'});
                });
        }

        $('.menu-toggle-activate').dblclick(function(event) {
            event.stopPropagation();
            var status = $(this).data('status');
            var id = $(this).data('id');

            switch (status) {
                case undefined : case 0 :
                $(this).removeClass('menu-toggle-activate_inactive');
                $(this).data('status', 1)
                setMenuActive(id,  1);
                break;
                case 1 :
                    $(this).addClass('menu-toggle-activate_inactive');
                    $(this).data('status', 0)
                    setMenuActive(id,  0);
                    break;
            }
        });
    });
</script>
