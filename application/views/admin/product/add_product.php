<script src="<?php echo base_url(); ?>asset/js/tag-it.js" type="text/javascript" charset="utf-8"></script>
<link href="<?php echo base_url(); ?>asset/css/jquery.tagit.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>asset/css/tagit.ui-zendesk.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="<?php echo base_url(); ?>asset/js/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>asset/js/ajax.js" type="text/javascript" charset="utf-8"></script>



<!-- View massage -->
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>
<?php $info = $this->session->userdata('business_info'); ?>
<section class="content">
    <div class="row">
        <div class="col-md-12">

            <div class="box box-primary">
                <div class="box-header box-header-background with-border">
                    <div class="col-md-offset-3">
                        <h3 class="box-title "><?php echo $title;?></h3>
                    </div>
                </div>
                <!-- /.box-header -->

                <!-- form start -->
                <form role="form" enctype="multipart/form-data" id="addProductForm" onsubmit="return imageForm(this)"
                      action="<?php echo base_url(); ?>admin/product/save_product/<?php  if (!empty($product_info)) {
                          echo $product_info->product_id;
                      } ?>" method="post">


                    <br/><br/>

                    <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
                        <li class="<?php if(empty($tab)){ echo 'active';} ?>"><a href="#general" data-toggle="tab">General</a></li>
                        <li class="<?php
                            if(!empty($tab)){
                                echo $tab == 'price'?'active':'';
                            }
                        ?>">
                            <a href="#price" data-toggle="tab">Harga</a></li>
                        <li><a href="#deskripsi" data-toggle="tab">Deskripsi</a></li>
                        <li><a href="#inventory" data-toggle="tab">Inventory</a></li>
                        <li class="<?php
                        if(!empty($tab)){
                            echo $tab == 'attribute'?'active':'';
                        }
                        ?>">
                            <a href="#attribute" data-toggle="tab">Attribute & Tag</a></li>

                    </ul>

                    <div class="row">

                        <div class="col-md-6 col-sm-12 col-xs-12 col-md-offset-3">

                            <div id="my-tab-content" class="tab-content">
                                <!-- ***************  General Tab Start ****************** -->
                                <div class="tab-pane <?php if(empty($tab)){ echo 'active';} ?>" id="general">

                                    <div class="box-body">


                                        <!-- /.Product Code -->
                                        <?php if (!empty($product_info->product_id)) {?>
                                        <div class="form-group">
                                            <label>Kode Produk</label>
                                            <input type="text"  placeholder="Product Code"
                                                   value="<?php echo $product_info->product_code ?>"
                                                   class="form-control" disabled>
                                        </div>
                                        <?php }else { ?>

                                            <div class="form-group">
                                                <label>Kode Produk</label>
                                                <input type="text"  placeholder="Product Code"
                                                       value="<?php echo $code ?>"
                                                       class="form-control" disabled>
                                            </div>

                                        <?php } ?>

                                        <!-- /.Product Name -->
                                        <div class="form-group">
                                            <label>Nama Produk <span class="required">*</span></label>
                                            <input type="text" placeholder="Product Name" name="product_name"
                                                   value="<?php
                                                   if (!empty($product_info)) {
                                                       echo $product_info->product_name;
                                                   }
                                                   ?>"
                                                   class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label>Brand / Merek &nbsp;&nbsp;&nbsp;</label>
                                                <select name="brand_id" class="form-control col-sm-5" id="brand_id">
                                                    <option value="0">Tidak Ada Brand</option>
                                                    <?php if (!empty($brand)): ?>
                                                        <?php foreach ($brand as $v_brand) : ?>
                                                            <option value="<?php echo $v_brand->brand_id; ?>"
                                                                <?php
                                                                if (!empty($product_info)) {
                                                                    echo $v_brand->brand_id == $product_info->brand_id ? 'selected' : '';
                                                                }
                                                                ?> >
                                                                <?php echo $v_brand->name; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </select>
                                            <?php
                                            echo btn_add_modal('admin/product/add_modal_brand','myModal','Tambah');
                                            ?>
                                        </div>

                                        <!-- /.Category -->
                                        <div class="form-group">
                                            <label>Kategori Produk<span class="required">*</span> &nbsp;&nbsp;&nbsp</label>
                                            <select name="category_id" class="form-control col-sm-5" id="category" onchange="get_category(this.value)">
                                                <option value="0">Select Product Category</option>
                                                <?php if (!empty($category)): ?>
                                                    <?php foreach ($category as $v_category) : ?>
                                                        <option value="<?php echo $v_category->category_id; ?>"
                                                            <?php
                                                            if (!empty($product_info)) {
                                                                if(count($product_sub) > 0)
                                                                {
                                                                    foreach ($product_sub as $sub)
                                                                    {
                                                                        echo $v_category->category_id == $sub ? 'selected' : '';
                                                                    }
                                                                }
                                                                else
                                                                {
                                                                    echo $v_category->category_id == $product_category->category_id ? 'selected' : '';
                                                                }

                                                            }
                                                            ?> >
                                                            <?php echo $v_category->category_name; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                            <?php
                                            echo btn_add_modal('admin/product/add_modal_category','myModal','Tambah');
                                            ?>
                                        </div>

                                        <!-- /.Sub Category -->
                                        <div class="form-group">
                                            <label>Subcategory</label>
                                            <select multiple name="subcategory_id[]" class="form-control col-sm-5" id="subcategory">
                                                <option value="0">Tidak Ada Subcategory</option>
                                                <?php if (!empty($subcategory)): ?>
                                                    <?php foreach ($subcategory as $v_subcategogy) : ?>
                                                        <option value="<?php echo $v_subcategogy->subcategory_id; ?>"
                                                            <?php
                                                            if (!empty($product_info)) {
                                                                echo $v_subcategogy->subcategory_id == $product_info->subcategory_id ? 'selected' : '';
                                                            }
                                                            ?> >
                                                            <?php echo $v_subcategogy->subcategory_name; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>

                                        <!-- /.Tax -->
                                        <div class="form-group">
                                            <label>Pajak <span class="required">*</span></label>
                                            <select name="tax_id" class="form-control col-sm-5">
                                                <option value="0">Tidak Ada Pajak</option>
                                                <?php foreach($tax as $v_tax) { ?>
                                                    <option value="<?php echo $v_tax->tax_id ?>"
                                                        <?php
                                                        if (!empty($product_info)) {
                                                            echo $product_info->tax_id == $product_info->tax_id ? 'selected' : '';
                                                        }
                                                            ?>>

                                                        <?php echo $v_tax->tax_title ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <!-- /.Product Image -->
                                        <div class="form-group">
                                            <label>Product Image</label>
                                        </div>
                                        <div class="form-group">
                                            <!-- hidden  old_path when update  -->
                                            <input type="hidden" name="old_path"  value="<?php
                                            if (!empty($product_image->image_path)) {
                                                echo $product_image->image_path;
                                            }
                                            ?>">
                                            <div class="fileinput fileinput-new"  data-provides="fileinput">
                                                <div class="fileinput-new thumbnail g-logo-img" >
                                                    <?php if (!empty($product_image)): // if product image is exist then show  ?>
                                                        <img src="<?php echo base_url() . $product_image->filename; ?>" >
                                                    <?php else: // if product image is not exist then defualt a image ?>
                                                        <img src="<?php echo base_url() ?>img/product.png" alt="Product Image">
                                                    <?php endif; ?>
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail g-logo-img"  ></div>
                                                <div>
                                                    <span class="btn btn-default btn-file">
                                                        <span class="fileinput-new">
                                                            <input type="file" name="product_image" /></span>
                                                        <span class="fileinput-exists">Change</span>
                                                    </span>
                                                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                </div>
                                                <div id="valid_msg" class="required"></div>
                                            </div>
                                        </div>
                                        <!-- / Product Image -->
                                    </div>
                                    <!-- /.box-body -->

                                </div>
                                <!-- ************* General Tab End ********************** -->

                                <!-- ************* General Price Tab Start ************** -->

                                <!-- /.Price Tab Start -->
                                <div class="tab-pane

                                <?php
                                if(!empty($tab)){
                                    echo $tab == 'price'?'active':'';
                                }
                                ?>

                                " id="price">

                                    <!-- /.General Price Start -->
                                    <h4>Harga Produk</h4>
                                    <div class="box">
                                        <div class="box-body">

                                            <!-- /.Buying Price -->
                                            <!-- /.Selling Price -->
                                            <div class="form-group form-group-bottom">
                                                <label>Harga Jual</label>

                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <?php  if(!empty($info->currency))
                                                    {
                                                        echo $info->currency ;
                                                    }else
                                                    {
                                                        echo '$';
                                                    } ?>
                                                </span>
                                                <input class="form-control" name="selling_price" id="selling_price" placeholder="Selling Price"
                                                       value="<?php
                                                       if (!empty($product_price)) {
                                                           echo $product_price->selling_price;
                                                       }
                                                       ?>"
                                                       type="text">
                                            </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Harga Beli Awal</label>

                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <?php  if(!empty($info->currency))
                                                        {
                                                            echo $info->currency ;
                                                        }else
                                                        {
                                                            echo '$';
                                                        } ?>
                                                    </span>
                                                    <input type="text" id="buying_price" name="buying_price" placeholder="Buying Price"
                                                           value="<?php
                                                           if (!empty($product_price)) {
                                                               echo $product_price->buying_price;
                                                           }
                                                           ?>"
                                                           class="form-control">
                                                </div>
                                            </div>

                                        </div><!-- /.box-body -->
                                    </div><!-- /.box -->
                                    <!-- /.General Price End -->

                                    <!-- ************* General Price Tab End **************** -->

                                    <!-- ************* Special Offer Tab Start ************** -->

                                    <!-- /.Special Offer Start -->
                                    <h4>Penawaran Diskon</h4>
                                    <div class="box">
                                        <div class="box-body">

                                            <!-- /.Start Date -->
                                            <div class="form-group form-group-bottom">
                                                <label>Tanggal Mulai</label>
                                            </div>
                                            <div class="input-group">
                                                <input type="text" value="<?php
                                                if (!empty($special_offer)) {
                                                    $start_date = date('Y/m/d', strtotime($special_offer->start_date));
                                                    echo $start_date;
                                                }
                                                ?>" class="form-control datepicker" id="start_date" name="start_date" data-format="yyyy/mm/dd">

                                                <div class="input-group-addon">
                                                    <a href="#"><i class="entypo-calendar"></i></a>
                                                </div>
                                            </div>

                                            <!-- /.End Date -->
                                            <div class="form-group form-group-bottom">
                                            <div class="form-group form-group-bottom">
                                                <label >Tanggal Akhir</label>
                                            </div>
                                            <div class="input-group">
                                                <input type="text" value="<?php
                                                if (!empty($special_offer)) {
                                                    $end_date = date('Y/m/d', strtotime($special_offer->end_date));
                                                    echo $end_date;
                                                }
                                                ?>"
                                                class="form-control datepicker" name="end_date" data-format="yyyy/mm/dd">

                                                <div class="input-group-addon">
                                                    <a href="#"><i class="entypo-calendar"></i></a>
                                                </div>
                                            </div>
                                                </div>

                                            <!-- /.Selling Price -->
                                            <div class="form-group form-group-bottom">
                                                <label>Harga Diskon</label>

                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <?php  if(!empty($info->currency))
                                                    {
                                                        echo $info->currency ;
                                                    }else
                                                    {
                                                        echo '$';
                                                    } ?>
                                                </span>
                                                <input class="form-control" placeholder="Price" name="offer_price"
                                                       value="<?php
                                                       if (!empty($special_offer)) {
                                                           echo $special_offer->offer_price;
                                                       }
                                                       ?>"
                                                       type="text">
                                            </div>
                                            </div>

                                        </div><!-- /.box-body -->
                                    </div><!-- /.box -->
                                    <!-- /.Special Offer End -->

                                    <!-- ************* Special Offer Tab End ************** -->

                                    <!-- ************* Product Tier Price Start *********** -->

                                    <!-- /.Tier Price Start -->
                                    <h4>Harga Bertingkat</h4>
                                    <div class="box">
                                        <div class="box-body">

                                            <div class="table">
                                                <table class="table" id="tireFields">
                                                    <thead>

                                                    <tr>
                                                        <th class="col-sm-3">Quantity dibawah</th>
                                                        <th class="">Harga jual</th>
                                                        <th class="col-sm-2"> <a  href="javascript:void(0);" class="addTire btn btn-info "><i class="fa fa-plus"></i> Add More</a></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php if(!empty($tier_price)) {?>
                                                        <?php foreach($tier_price as $v_tire){?>
                                                            <tr>
                                                                <td><div class="form-group form-group-bottom">
                                                                    <input type="text" name="tier_quantity[]" placeholder="Quantity"
                                                                           value="<?php echo $v_tire->quantity_above ?>" class="form-control">
                                                                        </div>
                                                                </td>

                                                                <td><div class="form-group form-group-bottom">
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <?php  if(!empty($info->currency))
                                                                                {
                                                                                    echo $info->currency ;
                                                                                }else
                                                                                {
                                                                                    echo '$';
                                                                                } ?>
                                                                            </span>
                                                                            <input class="form-control" value="<?php echo $v_tire->tier_price ?>" placeholder="Price" name="tier_price[]" type="text">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <?php echo btn_delete('admin/product/delete_tire_price/' . $v_tire->tier_price_id); ?>

                                                                </td>

                                                                <input type="hidden" name="tier_price_id[]" value="<?php echo $v_tire->tier_price_id ?>">
                                                            </tr>
                                                        <?php } ?>
                                                    <?php } else {?>
                                                        <tr>
                                                            <td><div class="form-group form-group-bottom">
                                                                <input type="text" name="tier_quantity[]" placeholder="Quantity"
                                                                       value="" class="form-control">
                                                                    </div>
                                                            </td>

                                                            <td><div class="form-group form-group-bottom">
                                                                    <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <?php  if(!empty($info->currency))
                                                                                {
                                                                                    echo $info->currency ;
                                                                                }else
                                                                                {
                                                                                    echo '$';
                                                                                } ?>
                                                                            </span>
                                                                        <input class="form-control" placeholder="Price" name="tier_price[]" type="text">
                                                                    </div>
                                                                </div></td>
                                                        </tr>
                                                    <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>


                                        </div><!-- /.box-body -->
                                    </div><!-- /.box -->
                                    <!-- /.Tier Price End -->
                                </div><!-- /.Price Tab End -->

                                <div class="tab-pane" id="deskripsi">

                                    <!-- /.Product Inventory Start -->
                                    <h4>Deskripsi Produk</h4>
                                    <div class="box">
                                        <div class="box-body">

                                            <!-- /.Buying Price -->
                                            <div class="form-group">
                                                <label>Deskripsi </label>
                                                <textarea name="product_note" class="form-control autogrow" id="field-ta"
                                                          placeholder="Product Note"><?php
                                                    if (!empty($product_info)) {
                                                        echo $product_info->product_note;
                                                    }
                                                    ?></textarea>
                                            </div>

                                        </div><!-- /.box-body -->
                                    </div><!-- /.box -->
                                    <!-- /.Product Inventory End -->

                                </div>

                                <!-- ************* Product Tier Price End *********** -->

                                <!-- ************* Product Inventory Start ********** -->

                                <!-- /.Inventory Tab Start -->
                                <div class="tab-pane" id="inventory">

                                    <!-- /.Product Inventory Start -->
                                    <h4>Product Inventory</h4>
                                    <div class="box">
                                        <div class="box-body">

                                            <!-- /.Buying Price -->

                                                <input type="hidden" id="product_quantity" name="product_quantity" placeholder="Quantity"
                                                       value="<?php
                                                       if (!empty($inventory)) {
                                                           echo $inventory->product_quantity;
                                                       }
                                                       else
                                                       {
                                                           echo '0';
                                                       }
                                                       ?>"
                                                       class="form-control">

                                            <!-- /.Selling Price -->
                                            <div class="form-group">
                                                <label>Notifikasi Minimum Quantity </label>
                                                <input type="text" name="notify_quantity" placeholder="Notify Quantity"
                                                       value="<?php
                                                       if (!empty($inventory)) {
                                                           echo $inventory->notify_quantity;
                                                       }
                                                       ?>"
                                                       class="form-control">
                                            </div>

                                        </div><!-- /.box-body -->
                                    </div><!-- /.box -->
                                    <!-- /.Product Inventory End -->

                                </div>
                                <!-- /.Inventory Tab End -->

                                <!-- ************* Product Inventory End ********** -->

                                <!-- ************* Product Attribute Start ******** -->

                                <!-- /.Attribute Tab Start -->
                                <div class="tab-pane
                                <?php
                                if(!empty($tab)){
                                    echo $tab == 'attribute'?'active':'';
                                }
                                ?>
                                " id="attribute">

                                    <!-- /.Attribute Start -->
                                    <h4>Product Attribute</h4>
                                    <div class="box">
                                        <div class="box-body">
                                            <div class="table">
                                                <table class="table" id="attributeFields">
                                                    <thead>

                                                    <tr>
                                                        <th class="">Attribute</th>
                                                        <th class="">Value</th>
                                                        <th class="col-sm-2"> <a  href="javascript:void(0);" class="addAttribute btn btn-info "><i class="fa fa-plus"></i> Add More</a></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if(!empty($attribute)){ ?>
                                                            <?php foreach($attribute as $v_attribute){ ?>

                                                                <tr>
                                                                    <td>
                                                                        <select name="attribute_name[]" class="form-control">
                                                                            <option value="">Choose Attribute</option>
                                                                            <?php
                                                                            if(!empty($variasi))
                                                                            {
                                                                                foreach ($variasi as $vari)
                                                                                {
                                                                                    $sel = '';
                                                                                    if($v_attribute->attribute_set_id == $vari->attribute_set_id )
                                                                                    {
                                                                                        $sel = 'selected';
                                                                                    }
                                                                                    echo '<option value="'.$vari->attribute_set_id.'" '.$sel.'>'.$vari->attribute_name.'</option>';
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </td>
                                                                    <td>

                                                                        <input type="text" name="attribute_value[]" placeholder="Value"
                                                                               value="<?php echo $v_attribute->attribute_value ?>" class="form-control">

                                                                    </td>
                                                                    <td>
                                                                        <?php echo btn_delete('admin/product/delete_attribute/' . $v_attribute->attribute_id); ?>
                                                                    </td>
                                                                    <input type="hidden" name="attribute_id[]" value="<?php echo $v_attribute->attribute_id ?>">
                                                                </tr>
                                                            <?php } ?>
                                                        <?php } else { ?>

                                                            <tr>
                                                                <td>

                                                                    <select name="attribute_name[]" class="form-control">
                                                                        <option value="">Choose Attribute</option>
                                                                        <?php
                                                                        if(!empty($variasi))
                                                                        {
                                                                            foreach ($variasi as $vari)
                                                                            {
                                                                                echo '<option value="'.$vari->attribute_set_id.'">'.$vari->attribute_name.'</option>';
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                    <!--<input type="text"  name="attribute_name[]" placeholder="Label"
                                                                           value="" class="form-control selector" autocomplete="off">-->
                                                                </td>
                                                                <td>

                                                                    <input type="text" name="attribute_value[]" placeholder="Value"
                                                                           value="" class="form-control">

                                                                </td>
                                                            </tr>
                                                        <?php }  ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div><!-- /.box-body -->
                                    </div><!-- /.box -->
                                    <!-- /.Attribute End -->

                                    <!-- ************* Product Attribute End ******** -->

                                    <!-- /.Product Tag Start -->
                                    <h4>Product Tag</h4>
                                    <div class="box">
                                        <div class="box-body">

                                            <!-- /.Selling Price -->

                                                    <ul id="allowSpacesTags">
                                                        <?php if(!empty($product_tags)){ ?>
                                                            <?php foreach($product_tags as $v_product_tag){ ?>
                                                                <li><span><?php echo $v_product_tag->tag ?></span></li>
                                                            <?php } ?>
                                                        <?php } ?>

                                                    </ul>

                                            <input type="hidden" style="display:none;"  >
                                        </div><!-- /.box-body -->
                                    </div>
                                    <input type="checkbox" name="serial" <?php
                                     if(!empty($product_info->serial))
                                     {
                                         if($product_info->serial == '1')
                                         {
                                             echo 'checked';
                                         }
                                     }
                                    ?> value="yes"> Punya Serial
                                    <br>
                                <!-- /.Attribute Tab End -->

                                    <!-- ************* hidden input field ******** -->

                                    <!-- product image id -->
                                    <input type="hidden" name="product_image_id"
                                           value="<?php
                                           if (!empty($product_image)) {
                                               echo $product_image->product_image_id;
                                           }
                                           ?>">
                                    <!-- product price id -->
                                    <input type="hidden" name="product_price_id"
                                           value="<?php
                                           if (!empty($product_price)) {
                                               echo $product_price->product_price_id;
                                           }
                                           ?>">
                                    <!-- product special offer id -->
                                    <input type="hidden" name="special_offer_id"
                                           value="<?php
                                           if (!empty($special_offer)) {
                                               echo $special_offer->special_offer_id;
                                           }
                                           ?>">
                                    <!-- product inventory id -->
                                    <input type="hidden" name="inventory_id"
                                           value="<?php
                                           if (!empty($inventory)) {
                                               echo $inventory->inventory_id;
                                           }
                                           ?>">
                                    <!-- product code -->
                                    <?php if (empty($product_info->product_id)) {?>
                                    <input type="hidden" name="product_code"
                                           value="<?php echo $code ?>">
                                    <?php }  ?>




                        </div>
                    </div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <button type="submit"  id="submit" class="btn bg-navy col-md-offset-3" type="submit">Save Product
                        </button>
                    </div>

                </form>
            </div><!-- /.box -->
        </div><!--/.col end -->
    </div><!-- /.row -->
</section><!-- /.section -->

<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/tinymce/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: "#field-ta",
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


<script lang="javascript">

    $(document).ready(function() {
        $('#selling_price').on('change input',function () {
            var sellingEl = $(this);
            if(sellingEl.val() != '')
            {
                var selling = removeCommas(sellingEl.val());
                $('#selling_price').val(numberWithCommas(selling.toString()));
            }
        });

        $('#buying_price').on('change input',function () {
            var buyingEl = $(this);
            if(buyingEl.val() != '')
            {
                var buying = removeCommas(buyingEl.val());
                $('#buying_price').val(numberWithCommas(buying.toString()));
            }
        });

        //***************** Tier Price Option Start *****************//
        $(".addTire").click(function() {
            $("#tireFields").append(
                '<tr>\
                    <td>\
                    <div class="form-group form-group-bottom">\
                        <input type="text" name="tier_quantity[]" required placeholder="Quantity"\
            value="" class="form-control">\
            </div>\
                    </td>\
                    <td>\
                    <div class="form-group form-group-bottom">\
                        <div class="input-group">\
                <span class="input-group-addon">\
                <?php  if(!empty($info->currency))
                                                    {
                                                        echo $info->currency ;
                                                    }else
                                                    {
                                                        echo '$';
                                                    } ?>
                </span>\
            <input class="form-control" placeholder="Price" name="tier_price[]" required type="text">\
            </div>\
            </div>\
                        </td>\
                        <td><a href="javascript:void(0);" class="remTire">Remove</a></td>\
                    </tr>'
            );
        });
        //***************** Tire Price Option End *****************//


        //***************** Product Attribute Start ***************//
        $(".addAttribute").click(function() {
            $("#attributeFields").append(
                '<tr>\
                    <td>\
                        <select name="attribute_name[]" class="form-control">\
                            <option value="">Choose Attribute</option>\
                        <?php
                        if(!empty($variasi))
                        {
                            foreach ($variasi as $vari)
                            {
                                echo '<option value="'.$vari->attribute_set_id.'">'.$vari->attribute_name.'</option>';
                            }
                        }
                        ?>
                        </select>\
                    </td>\
                    <td>\
                        <input type="text" name="attribute_value[]" placeholder="Value"\
            value="" class="form-control">\
                        </td>\
                        <td><a href="javascript:void(0);" class="remAttribute">Remove</a></td>\
                        <input type="hidden" name="class_routine_details_id[]" value="">\
                    </tr>'
            );
        });
        //***************** Product Attribute End *****************//

        //Remove Tire Fields
        $("#tireFields").on('click', '.remTire', function() {
            $(this).parent().parent().remove();
        });

        //Remove Attribute Fields
        $("#attributeFields").on('click', '.remAttribute', function() {
            $(this).parent().parent().remove();
        });

    });
</script>


<script>
$(function(){
    var sampleTags = [
        <?php
        if(!empty($tags))
        foreach($tags as $v_tag){
        echo "'$v_tag->tag',";
        }

        ?>
    ];

    //-------------------------------
    // Allow spaces without quotes.
    //-------------------------------
    $('#allowSpacesTags').tagit({
       availableTags: sampleTags,
        allowSpaces: true,
        fieldName: "tages[]",
        tagLimit:3,
        autocomplete: {delay: 0, minLength: 2}
    });
});
</script>


<script>
    var options = {
        source: [
            <?php
           if(!empty($attribute_set))
           foreach($attribute_set as $v_attribute){
           echo "'$v_attribute->attribute_name',";
           }
           ?>
        ]

    };
    var result = 'input.selector';
    $(document).on('keydown.autocomplete', result, function() {
        $(this).autocomplete(options);
    });

</script>


<!--    Image Validation Check    -->


<script type="text/javascript">

</script>
