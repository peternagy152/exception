<?php 
 /*
            $product_sizes = mitch_get_sizes_products_data($single_product_data['main_data']->get_id());
            // echo '<pre>';
            // var_dump($product_sizes);
            // echo '</pre>';
            $count_onesize = 0;
            if(!empty($product_sizes)){
              ?>
              <div class="section_size">
                  <label for="product_size"><?php echo $fixed_string['product_single_select_size'];?></label>
                  <div id="product_size" class="size">
                    <?php
                    $count         = 0;
                    foreach($product_sizes as $product_size_obj){
                      if($product_size_obj->name == 'ONESIZE'){
                        //continue;
                        $count_onesize++;
                      }
                      if($count == 0){
                        $active = 'active';
                      }else{
                        $active = '';
                      }
                      ?>
                      <div class="single_size <?php echo $active;?>" data-product-id="<?php echo $product_size_obj->ID;?>">
                        <p><?php echo $product_size_obj->name;?></p>
                      </div>
                      <?php
                      $count++;
                    }
                    ?>
                  </div>
              </div>
              <?php
            }
            $product_colors = mitch_get_colors_products_data($single_product_data['main_data']->get_id());
            if(!empty($product_colors)){
              ?>
              <div class="section_size">
                  <label for="product_color"><?php echo $fixed_string['product_single_select_color'];?></label>
                  <div id="product_color" class="size">
                    <?php
                    $count         = 0;
                    foreach($product_colors as $product_color_obj){
                      $color_code = get_field('color_hex_code', $single_product_data['main_data']->get_id().'');
                      if($count == 0){
                        $active = 'active';
                      }else{
                        $active = '';
                      }
                      ?>
                      <div class="single_size <?php echo $active;?>" data-product-id="<?php echo $product_color_obj->ID;?>">
                          <span style="<?php if($product_colors == 'White'){echo 'border: 2px solid #000;';}?>background-color: <?php echo $color_code;?>;"></span>
                          <p><?php //echo $product_color_obj->name;?></p>
                      </div>
                      <?php
                      $count++;
                    }
                    ?>
                  </div>
              </div>
              <?php
            }
            if($count_onesize == 1 && count($product_sizes) == 1){
              ?>
              <style>
              .section_size{display: none;}
              </style>
              <?php
            }*/
?>
<!-- <li id="product_<?php //echo $product_data['product_id'];?>_block" class="product_widget"
<?php// if(isset($prod_anim_count)){//echo 'data-aos="fade-left" data-aos-duration="'.$prod_anim_count.'"';}?>
  >
  <?php //if(mitch_check_wishlist_product(get_current_user_id(), $product_data['product_id'])){ ?>
    <!-- <span class="fav_btn favourite" onclick="remove_product_from_wishlist(<?php ////echo $product_data['product_id'];?>);"></span> -->
  <?php //}else{ ?>
    <!-- <span class="fav_btn not-favourite" onclick="add_product_to_wishlist(<?php ////echo $product_data['product_id'];?>);"></span> -->
  <?php //} ?>
  <!-- <a href="<?php //echo $product_data['product_url'];?>" class="product_widget_box">
      <div class="img">
          <img src="<?php //echo $product_data['product_image'];?>" alt="<?php //echo $product_data['product_title'];?>">
      </div>
      <div class="text">
        <div class="sec_info">
            <h3 class="title">
              <?php //echo $product_data['product_title'];?>
              <span>
              <?php //if(!empty($product_data['product_country_code'])){ ?>
              <img src="<?php //echo $theme_settings['theme_url'];?>/assets/img/flag/<?php //echo $product_data['product_country_code'];?>.png" alt="">
              </span>
              <?php //}?>
            </h3>
            <p class="price"><?php //echo $product_data['product_price'].' EGP';?> <?php //echo $theme_settings['curren_currency_ar'];?></p>
        </div>
        <div class="open_widget">
          <span></span>
        </div>
      </div>
  </a> -
</li>-->

<div class="product_widget">
    <span class="fav_btn not-favourite" onclick="add_product_to_wishlist(149);"></span>
    <div class="product_widget_box">
        <div class="img">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_01.png" alt="">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_02.png" alt="">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_03.png" alt="">
        </div>
        <a class="text" href="">
            <div class="sec_color">
                <div class="single_color">
                    <p style="background:#231f20;"></p>
                </div>
                <div class="single_color">
                <p style="background:#f8edeb;"></p>
                </div>
                <div class="single_color">
                <p style="background:#ff6926;"></p>
                </div>
            </div>
            <h3 class="title">Basic cardigan baby girl</h3>
            <div class="sec_info">
                <p class="price">340 EGP</p>
                <div class="size">
                    <div class="single_size">
                        <p>XS</p>
                    </div>
                    <div class="single_size">
                        <p>S</p>
                    </div>
                    <div class="single_size">
                        <p>M</p>
                    </div>
                    <div class="single_size">
                        <p>L</p>
                    </div>
                    <div class="single_size">
                        <p>XL</p>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

<div class="product_widget">
    <span class="fav_btn not-favourite" onclick="add_product_to_wishlist(149);"></span>
    <div class="product_widget_box">
        <div class="img">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_02.png" alt="">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_03.png" alt="">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_04.png" alt="">
        </div>
        <a class="text" href="">
            <div class="sec_color">
                <div class="single_color">
                    <p style="background:#231f20;"></p>
                </div>
                <div class="single_color">
                <p style="background:#f8edeb;"></p>
                </div>
                <div class="single_color">
                <p style="background:#ff6926;"></p>
                </div>
            </div>
            <h3 class="title">Basic cardigan baby girl</h3>
            <div class="sec_info">
                <p class="price">340 EGP</p>
                <div class="size">
                    <div class="single_size">
                        <p>XS</p>
                    </div>
                    <div class="single_size">
                        <p>S</p>
                    </div>
                    <div class="single_size">
                        <p>M</p>
                    </div>
                    <div class="single_size">
                        <p>L</p>
                    </div>
                    <div class="single_size">
                        <p>XL</p>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
<div class="product_widget">
    <span class="fav_btn not-favourite" onclick="add_product_to_wishlist(149);"></span>
    <div class="product_widget_box">
        <div class="img">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_03.png" alt="">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_04.png" alt="">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_05.png" alt="">
        </div>
        <a class="text" href="">
            <div class="sec_color">
                <div class="single_color">
                    <p style="background:#231f20;"></p>
                </div>
                <div class="single_color">
                <p style="background:#f8edeb;"></p>
                </div>
                <div class="single_color">
                <p style="background:#ff6926;"></p>
                </div>
            </div>
            <h3 class="title">Basic cardigan baby girl</h3>
            <div class="sec_info">
                <p class="price">340 EGP</p>
                <div class="size">
                    <div class="single_size">
                        <p>XS</p>
                    </div>
                    <div class="single_size">
                        <p>S</p>
                    </div>
                    <div class="single_size">
                        <p>M</p>
                    </div>
                    <div class="single_size">
                        <p>L</p>
                    </div>
                    <div class="single_size">
                        <p>XL</p>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
<div class="product_widget">
    <span class="fav_btn not-favourite" onclick="add_product_to_wishlist(149);"></span>
    <div class="product_widget_box">
        <div class="img">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_04.png" alt="">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_05.png" alt="">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_06.png" alt="">
        </div>
        <a class="text" href="">
            <div class="sec_color">
                <div class="single_color">
                    <p style="background:#231f20;"></p>
                </div>
                <div class="single_color">
                <p style="background:#f8edeb;"></p>
                </div>
                <div class="single_color">
                <p style="background:#ff6926;"></p>
                </div>
            </div>
            <h3 class="title">Basic cardigan baby girl</h3>
            <div class="sec_info">
                <p class="price">340 EGP</p>
                <div class="size">
                    <div class="single_size">
                        <p>XS</p>
                    </div>
                    <div class="single_size">
                        <p>S</p>
                    </div>
                    <div class="single_size">
                        <p>M</p>
                    </div>
                    <div class="single_size">
                        <p>L</p>
                    </div>
                    <div class="single_size">
                        <p>XL</p>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
<div class="product_widget">
    <span class="fav_btn not-favourite" onclick="add_product_to_wishlist(149);"></span>
    <div class="product_widget_box">
        <div class="img">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_05.png" alt="">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_06.png" alt="">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_07.png" alt="">
        </div>
        <a class="text" href="">
            <div class="sec_color">
                <div class="single_color">
                    <p style="background:#231f20;"></p>
                </div>
                <div class="single_color">
                <p style="background:#f8edeb;"></p>
                </div>
                <div class="single_color">
                <p style="background:#ff6926;"></p>
                </div>
            </div>
            <h3 class="title">Basic cardigan baby girl</h3>
            <div class="sec_info">
                <p class="price">340 EGP</p>
                <div class="size">
                    <div class="single_size">
                        <p>XS</p>
                    </div>
                    <div class="single_size">
                        <p>S</p>
                    </div>
                    <div class="single_size">
                        <p>M</p>
                    </div>
                    <div class="single_size">
                        <p>L</p>
                    </div>
                    <div class="single_size">
                        <p>XL</p>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
<div class="product_widget">
    <span class="fav_btn not-favourite" onclick="add_product_to_wishlist(149);"></span>
    <div class="product_widget_box">
        <div class="img">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_06.png" alt="">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_07.png" alt="">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_08.png" alt="">
        </div>
        <a class="text" href="">
            <div class="sec_color">
                <div class="single_color">
                    <p style="background:#231f20;"></p>
                </div>
                <div class="single_color">
                <p style="background:#f8edeb;"></p>
                </div>
                <div class="single_color">
                <p style="background:#ff6926;"></p>
                </div>
            </div>
            <h3 class="title">Basic cardigan baby girl</h3>
            <div class="sec_info">
                <p class="price">340 EGP</p>
                <div class="size">
                    <div class="single_size">
                        <p>XS</p>
                    </div>
                    <div class="single_size">
                        <p>S</p>
                    </div>
                    <div class="single_size">
                        <p>M</p>
                    </div>
                    <div class="single_size">
                        <p>L</p>
                    </div>
                    <div class="single_size">
                        <p>XL</p>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
<div class="product_widget">
    <span class="fav_btn not-favourite" onclick="add_product_to_wishlist(149);"></span>
    <div class="product_widget_box">
        <div class="img">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_07.png" alt="">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_08.png" alt="">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_09.png" alt="">
        </div>
        <a class="text" href="">
            <div class="sec_color">
                <div class="single_color">
                    <p style="background:#231f20;"></p>
                </div>
                <div class="single_color">
                <p style="background:#f8edeb;"></p>
                </div>
                <div class="single_color">
                <p style="background:#ff6926;"></p>
                </div>
            </div>
            <h3 class="title">Basic cardigan baby girl</h3>
            <div class="sec_info">
                <p class="price">340 EGP</p>
                <div class="size">
                    <div class="single_size">
                        <p>XS</p>
                    </div>
                    <div class="single_size">
                        <p>S</p>
                    </div>
                    <div class="single_size">
                        <p>M</p>
                    </div>
                    <div class="single_size">
                        <p>L</p>
                    </div>
                    <div class="single_size">
                        <p>XL</p>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
<div class="product_widget">
    <span class="fav_btn not-favourite" onclick="add_product_to_wishlist(149);"></span>
    <div class="product_widget_box">
        <div class="img">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_08.png" alt="">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_09.png" alt="">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_01.png" alt="">
        </div>
        <a class="text" href="">
            <div class="sec_color">
                <div class="single_color">
                    <p style="background:#231f20;"></p>
                </div>
                <div class="single_color">
                <p style="background:#f8edeb;"></p>
                </div>
                <div class="single_color">
                <p style="background:#ff6926;"></p>
                </div>
            </div>
            <h3 class="title">Basic cardigan baby girl</h3>
            <div class="sec_info">
                <p class="price">340 EGP</p>
                <div class="size">
                    <div class="single_size">
                        <p>XS</p>
                    </div>
                    <div class="single_size">
                        <p>S</p>
                    </div>
                    <div class="single_size">
                        <p>M</p>
                    </div>
                    <div class="single_size">
                        <p>L</p>
                    </div>
                    <div class="single_size">
                        <p>XL</p>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
<div class="product_widget">
    <span class="fav_btn not-favourite" onclick="add_product_to_wishlist(149);"></span>
    <div class="product_widget_box">
        <div class="img">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_09.png" alt="">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_01.png" alt="">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_02.png" alt="">
        </div>
        <a class="text" href="">
            <div class="sec_color">
                <div class="single_color">
                    <p style="background:#231f20;"></p>
                </div>
                <div class="single_color">
                <p style="background:#f8edeb;"></p>
                </div>
                <div class="single_color">
                <p style="background:#ff6926;"></p>
                </div>
            </div>
            <h3 class="title">Basic cardigan baby girl</h3>
            <div class="sec_info">
                <p class="price">340 EGP</p>
                <div class="size">
                    <div class="single_size">
                        <p>XS</p>
                    </div>
                    <div class="single_size">
                        <p>S</p>
                    </div>
                    <div class="single_size">
                        <p>M</p>
                    </div>
                    <div class="single_size">
                        <p>L</p>
                    </div>
                    <div class="single_size">
                        <p>XL</p>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>



#best_selling_section_products
<div class="product_widget">
    <span class="fav_btn not-favourite" onclick="add_product_to_wishlist(149);"></span>
    <div class="product_widget_box">
        <div class="img">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_01.png" alt="">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_02.png" alt="">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_03.png" alt="">
        </div>
        <a class="text" href="">
            <div class="sec_color">
                <div class="single_color">
                    <p style="background:#231f20;"></p>
                </div>
                <div class="single_color">
                <p style="background:#f8edeb;"></p>
                </div>
                <div class="single_color">
                <p style="background:#ff6926;"></p>
                </div>
            </div>
            <h3 class="title">Basic cardigan baby girl</h3>
            <div class="sec_info">
                <p class="price">340 EGP</p>
                <div class="size">
                    <div class="single_size">
                        <p>XS</p>
                    </div>
                    <div class="single_size">
                        <p>S</p>
                    </div>
                    <div class="single_size">
                        <p>M</p>
                    </div>
                    <div class="single_size">
                        <p>L</p>
                    </div>
                    <div class="single_size">
                        <p>XL</p>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
<div class="product_widget">
    <span class="fav_btn not-favourite" onclick="add_product_to_wishlist(149);"></span>
    <div class="product_widget_box">
        <div class="img">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_02.png" alt="">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_03.png" alt="">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_04.png" alt="">
        </div>
        <a class="text" href="">
            <div class="sec_color">
                <div class="single_color">
                    <p style="background:#231f20;"></p>
                </div>
                <div class="single_color">
                <p style="background:#f8edeb;"></p>
                </div>
                <div class="single_color">
                <p style="background:#ff6926;"></p>
                </div>
            </div>
            <h3 class="title">Basic cardigan baby girl</h3>
            <div class="sec_info">
                <p class="price">340 EGP</p>
                <div class="size">
                    <div class="single_size">
                        <p>XS</p>
                    </div>
                    <div class="single_size">
                        <p>S</p>
                    </div>
                    <div class="single_size">
                        <p>M</p>
                    </div>
                    <div class="single_size">
                        <p>L</p>
                    </div>
                    <div class="single_size">
                        <p>XL</p>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
<div class="product_widget">
    <span class="fav_btn not-favourite" onclick="add_product_to_wishlist(149);"></span>
    <div class="product_widget_box">
        <div class="img">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_03.png" alt="">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_04.png" alt="">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_05.png" alt="">
        </div>
        <a class="text" href="">
            <div class="sec_color">
                <div class="single_color">
                    <p style="background:#231f20;"></p>
                </div>
                <div class="single_color">
                <p style="background:#f8edeb;"></p>
                </div>
                <div class="single_color">
                <p style="background:#ff6926;"></p>
                </div>
            </div>
            <h3 class="title">Basic cardigan baby girl</h3>
            <div class="sec_info">
                <p class="price">340 EGP</p>
                <div class="size">
                    <div class="single_size">
                        <p>XS</p>
                    </div>
                    <div class="single_size">
                        <p>S</p>
                    </div>
                    <div class="single_size">
                        <p>M</p>
                    </div>
                    <div class="single_size">
                        <p>L</p>
                    </div>
                    <div class="single_size">
                        <p>XL</p>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
<div class="product_widget">
    <span class="fav_btn not-favourite" onclick="add_product_to_wishlist(149);"></span>
    <div class="product_widget_box">
        <div class="img">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_04.png" alt="">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_05.png" alt="">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_06.png" alt="">
        </div>
        <a class="text" href="">
            <div class="sec_color">
                <div class="single_color">
                    <p style="background:#231f20;"></p>
                </div>
                <div class="single_color">
                <p style="background:#f8edeb;"></p>
                </div>
                <div class="single_color">
                <p style="background:#ff6926;"></p>
                </div>
            </div>
            <h3 class="title">Basic cardigan baby girl</h3>
            <div class="sec_info">
                <p class="price">340 EGP</p>
                <div class="size">
                    <div class="single_size">
                        <p>XS</p>
                    </div>
                    <div class="single_size">
                        <p>S</p>
                    </div>
                    <div class="single_size">
                        <p>M</p>
                    </div>
                    <div class="single_size">
                        <p>L</p>
                    </div>
                    <div class="single_size">
                        <p>XL</p>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
<div class="product_widget">
    <span class="fav_btn not-favourite" onclick="add_product_to_wishlist(149);"></span>
    <div class="product_widget_box">
        <div class="img">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_05.png" alt="">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_06.png" alt="">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_07.png" alt="">
        </div>
        <a class="text" href="">
            <div class="sec_color">
                <div class="single_color">
                    <p style="background:#231f20;"></p>
                </div>
                <div class="single_color">
                <p style="background:#f8edeb;"></p>
                </div>
                <div class="single_color">
                <p style="background:#ff6926;"></p>
                </div>
            </div>
            <h3 class="title">Basic cardigan baby girl</h3>
            <div class="sec_info">
                <p class="price">340 EGP</p>
                <div class="size">
                    <div class="single_size">
                        <p>XS</p>
                    </div>
                    <div class="single_size">
                        <p>S</p>
                    </div>
                    <div class="single_size">
                        <p>M</p>
                    </div>
                    <div class="single_size">
                        <p>L</p>
                    </div>
                    <div class="single_size">
                        <p>XL</p>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
<div class="product_widget">
    <span class="fav_btn not-favourite" onclick="add_product_to_wishlist(149);"></span>
    <div class="product_widget_box">
        <div class="img">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_06.png" alt="">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_07.png" alt="">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_08.png" alt="">
        </div>
        <a class="text" href="">
            <div class="sec_color">
                <div class="single_color">
                    <p style="background:#231f20;"></p>
                </div>
                <div class="single_color">
                <p style="background:#f8edeb;"></p>
                </div>
                <div class="single_color">
                <p style="background:#ff6926;"></p>
                </div>
            </div>
            <h3 class="title">Basic cardigan baby girl</h3>
            <div class="sec_info">
                <p class="price">340 EGP</p>
                <div class="size">
                    <div class="single_size">
                        <p>XS</p>
                    </div>
                    <div class="single_size">
                        <p>S</p>
                    </div>
                    <div class="single_size">
                        <p>M</p>
                    </div>
                    <div class="single_size">
                        <p>L</p>
                    </div>
                    <div class="single_size">
                        <p>XL</p>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
<div class="product_widget">
    <span class="fav_btn not-favourite" onclick="add_product_to_wishlist(149);"></span>
    <div class="product_widget_box">
        <div class="img">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_07.png" alt="">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_08.png" alt="">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_09.png" alt="">
        </div>
        <a class="text" href="">
            <div class="sec_color">
                <div class="single_color">
                    <p style="background:#231f20;"></p>
                </div>
                <div class="single_color">
                <p style="background:#f8edeb;"></p>
                </div>
                <div class="single_color">
                <p style="background:#ff6926;"></p>
                </div>
            </div>
            <h3 class="title">Basic cardigan baby girl</h3>
            <div class="sec_info">
                <p class="price">340 EGP</p>
                <div class="size">
                    <div class="single_size">
                        <p>XS</p>
                    </div>
                    <div class="single_size">
                        <p>S</p>
                    </div>
                    <div class="single_size">
                        <p>M</p>
                    </div>
                    <div class="single_size">
                        <p>L</p>
                    </div>
                    <div class="single_size">
                        <p>XL</p>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
<div class="product_widget">
    <span class="fav_btn not-favourite" onclick="add_product_to_wishlist(149);"></span>
    <div class="product_widget_box">
        <div class="img">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_08.png" alt="">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_09.png" alt="">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_01.png" alt="">
        </div>
        <a class="text" href="">
            <div class="sec_color">
                <div class="single_color">
                    <p style="background:#231f20;"></p>
                </div>
                <div class="single_color">
                <p style="background:#f8edeb;"></p>
                </div>
                <div class="single_color">
                <p style="background:#ff6926;"></p>
                </div>
            </div>
            <h3 class="title">Basic cardigan baby girl</h3>
            <div class="sec_info">
                <p class="price">340 EGP</p>
                <div class="size">
                    <div class="single_size">
                        <p>XS</p>
                    </div>
                    <div class="single_size">
                        <p>S</p>
                    </div>
                    <div class="single_size">
                        <p>M</p>
                    </div>
                    <div class="single_size">
                        <p>L</p>
                    </div>
                    <div class="single_size">
                        <p>XL</p>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
<div class="product_widget">
            <span class="fav_btn not-favourite" onclick="add_product_to_wishlist(149);"></span>
            <div class="product_widget_box">
                <div class="img">
                    <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_09.png" alt="">
                    <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_01.png" alt="">
                    <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/pro_02.png" alt="">
                </div>
                <a class="text" href="">
                    <div class="sec_color">
                        <div class="single_color">
                            <p style="background:#231f20;"></p>
                        </div>
                        <div class="single_color">
                        <p style="background:#f8edeb;"></p>
                        </div>
                        <div class="single_color">
                        <p style="background:#ff6926;"></p>
                        </div>
                    </div>
                    <h3 class="title">Basic cardigan baby girl</h3>
                    <div class="sec_info">
                        <p class="price">340 EGP</p>
                        <div class="size">
                            <div class="single_size">
                                <p>XS</p>
                            </div>
                            <div class="single_size">
                                <p>S</p>
                            </div>
                            <div class="single_size">
                                <p>M</p>
                            </div>
                            <div class="single_size">
                                <p>L</p>
                            </div>
                            <div class="single_size">
                                <p>XL</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>


        <div class="single_top">
            <span class="bk great_value"></span>
            <h5 class="text">
              Great Value
              <p>express shipping for when you left your weekend fit till last minute</p>
            </h5>
        </div>
        <div class="single_top">
          <span class="bk fast_shaipping"></span>
          <h5 class="text">
            Fast Shipping
            <p>exclusive hand-crafted pieces designed in Sydney</p>
          </h5>
        </div>
        <div class="single_top">
            <span class="bk like"></span>
            <h5 class="text">Return Guaranteed
                <p>exclusive hand-crafted pieces designed in Sydney</p>
            </h5>
        </div>



        <div class="bottom">
            <div class="single_bottom">
                <div class="text">
                    <span class="icon"><img src="<?php echo $theme_settings['theme_url'];?>/assets/img/icons/icon_cash.png" alt=""></span>
                    <p>Pay Cash on Delivery</p>
                </div>
            </div>
            <div class="single_bottom">
                <div class="text">
                    <span class="icon"><img src="<?php echo $theme_settings['theme_url'];?>/assets/img/icons/icon_card.png" alt=""></span>
                    <p>Pay Cash on Delivery</p>
                </div>
            </div>
            <div class="single_bottom">
                <div class="text">
                    <span class="icon"><img src="<?php echo $theme_settings['theme_url'];?>/assets/img/icons/gift_card.png" alt=""></span>
                    <p>Pay Cash on Delivery</p>
                </div>
            </div>
            <div class="single_bottom">
                <div class="text">
                    <p>Pay Cash on Delivery</p>
                    <span class="icon"><img src="<?php echo $theme_settings['theme_url'];?>/assets/img/icons/valu.png" alt=""></span>
                </div>
            </div>
        </div>
