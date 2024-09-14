<?php require_once 'header.php';?>
<?php
global $language ; 
$items  = WC()->cart->get_cart();
if(empty($items)){
  wp_redirect(home_url());
  exit;
}
if(!empty(WC()->cart->applied_coupons)){
  $coupon_code    = WC()->cart->applied_coupons[0];
  $active         = 'active';
  $dis_form_style = 'display:block;';
  $dis_abtn_style = 'display:none;';
  $dis_rbtn_style = 'display:block;';
}else{
  $coupon_code    = '';
  $active         = '';
  $dis_form_style = '';
  $dis_abtn_style = 'display:block;';
  $dis_rbtn_style = 'display:none;';
}
// $new_order = wc_get_order(200);
// $new_order->calculate_totals();
// global $wpdb;
// $wpdb->query("DELETE FROM wp_woocommerce_order_itemmeta WHERE order_item_id = 39 AND (meta_key = '_line_subtotal' OR meta_key = '_line_total');");
?>
 
<div id="page" class="site">
  <?php require_once 'theme-parts/main-menu.php';?>
  <!--start page-->
  <div class="page_cart">
      <div class="cart">
          <div class="grid">
              <!-- <div class="sectio_title_cart">
                  <h2>
                    <p class="cart_subtitle">
                    <?php //echo $fixed_string['cart_sub_title'];?>
                    </p>
                    <?php //echo $fixed_string['cart_main_title'];?>
                  </h2>
              </div> -->
              <div class="sectio_title_cart">
                <h2> <?php echo cart_page('cart_title' , $language); ?></h2>
                <div class="section_icon_cart">
                    <p id="cart_total_count"><?php echo WC()->cart->get_cart_contents_count(); ?>
                      
                    </p>
                    <span> <?php echo cart_page('item' , $language); ?></span>
                    <!-- <img src="<?php //echo $theme_settings['theme_url']; ?>/assets/img/new_icons/cart.png" alt=""> -->
                </div>
                
              </div>
              <div class="section_cart">
              <div class="table-title">
                      <p> <?php echo cart_page('product' , $language); ?></p>
                      <p> <?php echo cart_page('price' , $language); ?> </p>
                      <p> <?php echo cart_page('quantity' , $language); ?> </p>
                      <p> <?php echo cart_page('total' , $language); ?></p>
                    </div>
                  <div class="cart_list">
                   
                    <?php
                      $products_ids = array();
                      if(!empty($items)){
                      foreach($items as $item => $values){
                      $products_ids[]    = $values['product_id'];
                      $arabic_fields = MD_product_widget_data( $values['product_id'] , $language ); 
                       
                      $cart_product_data = mitch_get_short_product_data($values['product_id']);
                     // var_dump($cart_product_data);
                      $item_product_id   = $values['product_id'];
                      if(!empty($values['variation_id'])){
                        $item_product_id = $values['variation_id'];
                      }
                    ?>
                      <div id="cart_page_<?php echo $item;?>" class="single_item">
                          <div class="sec_item size">
                              <div class="img">
                                  <img height="100px" src="<?php echo $cart_product_data['product_image'];?>" alt="<?php echo $cart_product_data['product_title'];?>">
                              </div>
                              <div class="info">
                                  <div class="text">
                                      <a class="title_link" href="<?php echo $cart_product_data['product_url'];?>">
                                          <h4><?php echo $arabic_fields['name'];?></h4>
                                          <h6 class="note_delivery"> <?php echo $arabic_fields['subtitle'] ; ?></h6>
                                      </a>
                                      <?php
                                       if($item_product_id != 1730 || $item_product_id != 3065 ){
                                        if(!empty($values['custom_cart_data'])){
                                          ?>
                                          <ul>
                                          <?php
                                          foreach($values['custom_cart_data']['attributes_vals'] as $attr_val){
                                            ?>
                                            <li><?php echo mitch_get_product_attribute_name($attr_val);?></li>
                                            <?php
                                          }
                                          ?>
                                          </ul>
                                        <?php }elseif(!empty($values['variation'])){
                                          ?>
                                          <ul>
                                          <?php
                                          
                                          foreach($values['variation'] as $key => $value){
                                            
                                            $attribute_taxonomy = str_replace('attribute_','',$key);
                                            $term = get_terms( array(
                                                'taxonomy' => $attribute_taxonomy,
                                                'slug' => $value,
                                                'fields' => 'ids'
                                            ) );
  
                                            if ( ! empty( $term ) && ! is_wp_error( $term ) ) {
                                                $tag_id = $term[0];
                                            }
                                            $attribute_arabic =  get_term_meta($tag_id, 'attribute_in_arabic', true);
                                            $attribute_english = str_replace('-' , '' , $value);
                                           
                                            ?>
                                              <!-- <li> <?php // echo $attribute_name ?> <?php// if($language == 'en'){echo $attribute_english ;}else{echo $attribute_arabic;} ?></li> -->
                                              
                                              
                                           
                                            <?php
                                          }
                                          ?>
                                          </ul>
                                        <?php }
                                       }?>
                                      
                                      <div class="price">
                                      <p>
                                        <?php
                                        if($item_product_id != 1730  && $item_product_id != 3065){
                                          if(!empty($values['custom_cart_data'])){
                                            echo number_format(($values['line_subtotal'] / $values['quantity']));
                                          }else{
                                            echo number_format($cart_product_data['product_price']);
                                          }
                                         echo $theme_settings['curren_currency_' . $language];
                                        }
                                       
                                        ?>
                                        
                                      </p>
                                      <!-- <?php //if($cart_product_data['product_price'] != $values['data'] -> get_regular_price() ){ ?>
                                      <p class="sale_price">
                                        <?php
                                          //echo number_format($values['data'] -> get_regular_price());
                                        ?>
                                        <?php //echo $theme_settings['curren_currency_' . $language];?>
                                      </p>
                                      <?php  //} ?> -->
                                      </div>
                                     
                                  </div>
                                  
                              </div>
                          </div>
                          <div class="sec_price size">
                              <p>
                                <?php
                                if($item_product_id == 1730){
                                  echo  number_format($values['variation']['selected_price']);
                                }else if($item_product_id == 3065){
                                  echo  number_format($values['variation']['price']);
                                }else{
                                  if(!empty($values['custom_cart_data'])){
                                    echo number_format(($values['line_subtotal'] / $values['quantity']));
                                  }else{
                                    echo number_format($cart_product_data['product_price']);
                                  }
                                }
                               
                                ?>
                                <?php echo $theme_settings['curren_currency_' . $language];?>
                              </p>
                          </div>
                          <?php //if($item_product_id != 1730){ ?>
                          <div class="section_count">
                              <button class="increase" id="increase" onclick="increaseValueByID('number_<?php echo $item;?>');update_cart_items('<?php echo $item;?>', 'cart_page');" value="Increase Value"></button>
                              <input class="number_count" type="number" id="number_<?php echo $item;?>" value="<?php echo $values['quantity'];?>" />
                              <button class="decrease" id="decrease" onclick="decreaseValueByID('number_<?php echo $item;?>');update_cart_items('<?php echo $item;?>', 'cart_page');" value="Decrease Value"></button>
                          </div>
                          <?php// }  ?>
                          <div class="last size">
                            <p class="total_price">
                              <span id="line_subtotal_<?php echo $item;?>"><?php echo number_format($values['line_subtotal']);?></span>
                              <?php echo $theme_settings['curren_currency_' . $language];?>
                            </p>
                            <a class="remove_page_cart" href="javascript:void(0);" onclick="cart_remove_item('<?php echo $item;?>', '');"><?php echo cart_page('remove' , $language); ?></a>

                          </div>
                        
                      </div>
                    <?php
                  } } 
                   ?>
                  </div>
                  <div class="cart_action">
                      <div class="right">
                        <div class="total_price">
                          <p> <?php echo cart_page('total' , $language); ?></p>
                          <div class="sec_price">
                            <span class="cart_total" id="cart_total">
                              <?php echo number_format(WC()->cart->cart_contents_total);?> 
                              <?php echo $theme_settings['curren_currency_' . $language];?>
                            </span>
                            <!-- <span id="cart_total" class="cart_total discount"><?php //echo WC()->cart->cart_contents_total;?> <?php //echo $theme_settings['curren_currency_' . $language];?></span>  -->
                          </div>

                        </div>
                        <a href="<?php echo home_url('checkout');?><?php echo ($language == 'en')? '/?lang=en':'' ?>">
                          <button type="button">  <?php echo cart_page('order_now' , $language); ?> </button>
                        </a>
                      </div>
                      <div class="left">
                        <div class="coupon_cart">
                            <h4 class="open-coupon "> <?php echo cart_page('do_Promo' , $language); ?></h4>
                            <div class="discount-form" style="<?php echo $dis_form_style;?>">
                                <button class="close-coupon"><i class="material-icons">close</i></button>
                                <div class="coupon">
                                  <label for="coupon_code"> <?php echo cart_page('Promo' , $language); ?></label>
                                  <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="<?php echo $coupon_code;?>" placeholder="<?php echo 'Code';?>" />
                                  <button style="<?php echo $dis_abtn_style;?>" id="apply_coupon" type="submit" class="button btn">
                                    <?php echo '';?>

                                  </button>
                                  <button style="<?php echo $dis_rbtn_style;?>" id="remove_coupon" type="submit" class="button btn remove_coupon_icon">
                                    <?php //echo 'Remove Coupon';?>

                                  </button>
                                  <input type="hidden" name="lang" id="lang" value="">
                                </div>
                                <div class="message-container">
                                <p  id = "message-success" class="message success"><?php echo cart_page('success_promo' , $language) ?></p>
                                <p   id = "message-fail" class="message error "><?php echo cart_page('fail_promo' , $language) ?></p>
                                </div>
                               
                            </div>
                        </div>
                      </div>
                     
                  </div>
              </div>
          </div>
      </div>
      <?php
      shuffle($products_ids);
      $product_id        = $products_ids[0];
      // // mitch_test_vars(array($product_id));
      // $new_related_title = $fixed_string['cart_related_products_title'];
      // include_once 'theme-parts/related-products.php';
      ?>
  </div>
  <!--end page-->
</div>
<!--  --------------------------------- Upsell And Cross Sell  ---------------------------------  -->
<?php 
?>
    <?php include_once 'theme-parts/upsell/addons-category.php';?>
     <?php include_once 'theme-parts/upsell/random-products.php';?>
<?php require_once 'footer.php';?>
