<?php
add_action('wp_ajax_customized_product_add_to_cart', 'mitch_customized_product_add_to_cart');
add_action('wp_ajax_nopriv_customized_product_add_to_cart', 'mitch_customized_product_add_to_cart');
function mitch_customized_product_add_to_cart(){
  $added              = array();
  $parent_id          = intval($_POST['parent_id']);
  $variations_ids     = (array)$_POST['variations_ids'];
  $visit_type         = sanitize_text_field($_POST['visit_type']);
  $visit_branch       = sanitize_text_field($_POST['visit_branch']);
  $visit_home         = sanitize_text_field($_POST['visit_home']);
  $lang = $_POST['lang'] ;
  $custom_cart_data   = array(
    'custom_cart_data' => array(
      'attributes_keys' => (array)$_POST['attributes_keys'],
      'attributes_vals' => (array)$_POST['attributes_vals'],
      'variations_ids'  => $variations_ids,
      'visit_type'      => $visit_type,
      'visit_branch'    => $visit_branch,
      'visit_home'      => $visit_home
    )
  );
  // mitch_test_vars(array($visit_type, $visit_branch, $visit_home));
  // exit;
  // $product_attributes = array_keys(get_post_meta($parent_id, '_product_attributes', true));
  if(!empty($variations_ids)){
    //$i = 0;
    $total_price = 0;
    foreach($variations_ids as $variation_id){
      $total_price = $total_price + (float)get_post_meta($variation_id, '_price', true);
      // $product_attributes = wc_get_product_variation_attributes($variation_id);
      // $variation_attributes = array();
      // if(!empty($product_attributes)){
      //   foreach($product_attributes as $attribute_key){
      //     if($attribute_key == $attributes_keys[$i]){
      //       $variation_attributes['attribute_'.$attribute_key] = $attributes_vals[$i];
      //     }else{
      //       $variation_attributes['attribute_'.$attribute_key] = 'none';
      //     }
      //   }
      // }
      // echo '<pre>';
      // var_dump($variation_attributes);
      // echo '</pre>';
      //if(!empty($variation_attributes)){
      //  $added[] = WC()->cart->add_to_cart($parent_id, 1, $variation_id, wc_get_product_variation_attributes($variation_id));//14, 1,$variation_attributes
      //}
      //$i++;
    }
  }

  $custom_cart_data['custom_cart_data']['custom_total'] = $total_price;
  $cart_item_key = WC()->cart->add_to_cart($parent_id, 1, $variation_id, wc_get_product_variation_attributes($variation_id), $custom_cart_data); //
  WC()->cart->calculate_totals();

  if($cart_item_key){
    $response = array(
      'status'       => 'success',
      'cart_count'   => WC()->cart->get_cart_contents_count(),
      'cart_content' => mitch_get_cart_content($lang),
      'redirect_to'  => home_url('cart'),
      'msg'          => 'Added To Cart Successfully.',
    );
  }else{
    $response = array(
      'status' => 'error',
      'msg'    => wc_print_notices(),
    );
  }
  // var_dump($response);
  // exit;
  echo json_encode($response);
  wp_die();
}

add_action('woocommerce_before_calculate_totals', 'mitch_recalculate_cart_item_price');
function mitch_recalculate_cart_item_price($cart_object){
	foreach($cart_object->get_cart() as $hash => $values){
    if(!empty($values['custom_cart_data'])){
      $values['data']->set_price($values['custom_cart_data']['custom_total']);
    }
	}
}

add_action('wp_ajax_simple_product_add_to_cart', 'mitch_simple_product_add_to_cart');
add_action('wp_ajax_nopriv_simple_product_add_to_cart', 'mitch_simple_product_add_to_cart');
function mitch_simple_product_add_to_cart(){
  $product_id      = intval($_POST['product_id']);
  $quantity_number = intval($_POST['quantity_number']);
  $lang = $_POST['lang']; 
  $add_to_cart_type = $_POST['add_to_cart_type'];


  if(empty($quantity_number)){
    $quantity_number = 1;
  }
  $msg             = '';
  $valid_add_to_cart = false ;
  if($product_id == 1730){
    $almond_paste = intval($_POST['almond_paste']);
    $added_to_cart   = WC()->cart->add_to_cart($product_id, 1 , 0, array('selected_price' => $almond_paste));
    $valid_add_to_cart = true ;
   // var_dump($cart->get_cart());
  }
  
  if($add_to_cart_type == 'custom'){
    $cake_text = $_POST['cake_text'] ;
    $cake_notes = $_POST['cake_notes'] ;
    $added_to_cart   = WC()->cart->add_to_cart($product_id, $quantity_number , 0, array('cake_text' => $cake_text , 'cake_notes' => $cake_notes  ));
    $valid_add_to_cart = true ;
  }
  
  if(!$valid_add_to_cart){
    $added_to_cart   = WC()->cart->add_to_cart($product_id, $quantity_number);
  }

  if($added_to_cart){
    $response = array(
      'status'       => 'success',
      'cart_count'   => WC()->cart->get_cart_contents_count(),
      'cart_content' => mitch_get_cart_content($lang),
      'cart_total'   => number_format(WC()->cart->cart_contents_total ,2),
      'msg'          => 'Added To Cart Successfully.',
    );
  }else{
    $errors = WC()->session->get('wc_notices', array())['error'];
    $count  = count($errors);
    if(isset($errors) && !empty($errors)){
      foreach($errors as $key => $error_data){
        $msg .= $error_data['notice'];
        if($count > 1){
          $msg = $msg.', ';
        }
      }
    }
    $response = array(
      'status'  => 'error',
      'code'    => 401,
      'msg'     => $msg,
    );
    wc_clear_notices();
  }
  echo json_encode($response);
  wp_die();
}

add_action('wp_ajax_get_availablility_variable_product', 'mitch_get_availablility_variable_product');
add_action('wp_ajax_nopriv_get_availablility_variable_product', 'mitch_get_availablility_variable_product');
function mitch_get_availablility_variable_product(){
  $attributes      = array();
  $quantity      = array();
  $variation_id    = 0;
  $product_id      = intval($_POST['product_id']);
  $selected_items  = $_POST['selected_items'];
  // $quantity_number = intval($_POST['quantity_number']);
  // var_dump($quantity_number);
  // exit;
  $product_obj     = wc_get_product($product_id);
  if(!empty($selected_items)){
    foreach($selected_items as $key => $value){
      foreach($value as $arr_k => $arr_v){
        $attributes[$arr_k] = urldecode($arr_v);
      }
    }
  }
  if(!empty($product_obj->get_available_variations())){
    foreach($product_obj->get_available_variations() as $variation_obj){
      if($variation_obj['attributes'] == $attributes){
        $variation_id = $variation_obj['variation_id'];
      }
    }
  }
  if(!empty($variation_id)){
    $variation = new WC_Product_Variation($variation_id);
    $quantity[] = $variation->get_stock_quantity();
    $response = array(
      'status'       => 'success',
      'quantity'   => array_sum($quantity),
      'price'   => $variation->get_price().' EGP',
      'msg'          => 'Added To Cart Successfully.'
    );
  }
  else{
    $response = array(
      'status' => 'error',
      'msg'    => wc_print_notices()
    );
  }
  echo json_encode($response);
  wp_die();
}

add_action('wp_ajax_variable_product_add_to_cart', 'mitch_variable_product_add_to_cart');
add_action('wp_ajax_nopriv_variable_product_add_to_cart', 'mitch_variable_product_add_to_cart');
function mitch_variable_product_add_to_cart(){ 
  $attributes      = array();
  $variation_id    = 0;
  $product_id      = intval($_POST['product_id']);
  $selected_items  = $_POST['selected_items'];
  $quantity_number = intval($_POST['quantity_number']);
  $lang = $_POST['lang'] ;
  $add_to_cart_type = $_POST['add_to_cart_type'];
  if(empty($quantity_number)){
    $quantity_number = 1;
  }
  $product_obj     = wc_get_product($product_id);
  // $match_attribute = false;
  if(!empty($selected_items)){
    foreach($selected_items as $key => $value){
      foreach($value as $arr_k => $arr_v){
        $attributes[$arr_k] = urldecode($arr_v);
      }
    }
  }
  if(!empty($product_obj->get_available_variations())){
    foreach($product_obj->get_available_variations() as $variation_obj){
      /*echo '<pre>';
      var_dump($variation_obj['attributes']);
      echo '</pre>';*/
      if($variation_obj['attributes'] == $attributes){
        $variation_id = $variation_obj['variation_id'];
      }
    }
  }
  $error_msg = '';
  if(!empty($variation_id)){
    if($add_to_cart_type == 'custom'){
      $custom_data = array(
        "cake_note" => $_POST['cake_notes'],
        "cake_text" => $_POST['cake_text'],
    );
    $added_to_cart   = WC()->cart->add_to_cart($product_id, $quantity_number, $variation_id, wc_get_product_variation_attributes($variation_id) , $custom_data);
    }else{
      $added_to_cart   = WC()->cart->add_to_cart($product_id, $quantity_number, $variation_id, wc_get_product_variation_attributes($variation_id));
    }
  
  }else{
    $error_msg = 'Sorry, Your selected attributes not match!';
  }
  if($added_to_cart){
    $response = array(
      'status'       => 'success',
      'cart_count'   => WC()->cart->get_cart_contents_count(),
      'cart_content' => mitch_get_cart_content($lang),
      'cart_total'   => number_format(WC()->cart->cart_contents_total ,2),
      'msg'          => 'Added To Cart Successfully.'
    );
  }else{
    if(!empty($error_msg)){
      $response = array(
        'status' => 'error',
        'msg'    => $error_msg
      );
    }else{
      $response = array(
        'status' => 'error',
        'msg'    => wc_print_notices()
      );
    }
    
  }
  echo json_encode($response);
  wp_die();
}
// add_action('wp_ajax_custom_cake_add_to_cart', 'mitch_custom_cake_add_to_cart');
// add_action('wp_ajax_nopriv_custom_cake_add_to_cart', 'mitch_custom_cake_add_to_cart');
// function mitch_custom_cake_add_to_cart(){ 
//   $attributes      = array();
//   $variation_id    = 0;
//   $product_id      = intval($_POST['product_id']);
//   $selected_items  = $_POST['selected_items'];
//   $quantity_number = intval($_POST['quantity_number']);
//   $cake_text = $_POST['cake_text'];
//   $cake_notes = $_POST['cake_notes'];
//   $lang = $_POST['lang'];
//   //  var_dump($cake_notes);
//   //  var_dump($cake_text);



//   if(empty($quantity_number)){
//     $quantity_number = 1;
//   }
//   $product_obj     = wc_get_product($product_id);
//   // $match_attribute = false;
//   if(!empty($selected_items)){
//     foreach($selected_items as $key => $value){
//       foreach($value as $arr_k => $arr_v){
//         $attributes[$arr_k] = urldecode($arr_v);
//       }
//     }
//   }

//   if(!empty($product_obj->get_available_variations())){
//     foreach($product_obj->get_available_variations() as $variation_obj){
//       if($variation_obj['attributes'] == $attributes){
//         $variation_id = $variation_obj['variation_id'];
//       }
//     }
//   }
//   $cart_item_data = array(
//     'cake_text' => $cake_text ,//$cake_text ,
//     'cake_notes' => $cake_notes , //$cake_notes,
//   );
//   if(!empty($variation_id)){
//    // $added_to_cart   = WC()->cart->add_to_cart($product_id, $quantity_number,'', array() , $cart_item_data);
//     $added_to_cart   = WC()->cart->add_to_cart($product_id, $quantity_number, $variation_id, wc_get_product_variation_attributes($variation_id) , $cart_item_data);
//   }else{
//     $error_msg = 'Sorry, Your selected attributes not match!';
//   }
//   if($added_to_cart){
//     $response = array(
//       'status'       => 'success',
//       'cart_count'   => WC()->cart->get_cart_contents_count(),
//       'cart_content' => mitch_get_cart_content($lang),
//       'cart_total'   => number_format(WC()->cart->cart_contents_total ,2),
//       'msg'          => 'Added To Cart Successfully.'
//     );
//   }else{
//     if(!empty($error_msg)){
//       $response = array(
//         'status' => 'error',
//         'msg'    => $error_msg
//       );
//     }else{
//       $response = array(
//         'status' => 'error',
//         'msg'    => wc_print_notices()
//       );
//     }
    
//   }
//   echo json_encode($response);
//   wp_die();
// }

add_action('wp_ajax_cart_remove_item', 'mitch_cart_remove_item');
add_action('wp_ajax_nopriv_cart_remove_item', 'mitch_cart_remove_item');
function mitch_cart_remove_item(){
  $product_id = intval($_POST['product_id']);
  $lang = $_POST['lang'];
  if(!empty($product_id)){
    foreach(WC()->cart->get_cart() as $cart_item_key => $cart_item){
      if($cart_item['product_id'] == $product_id){
        WC()->cart->remove_cart_item($cart_item_key);
      }
    }
  }else{
    WC()->cart->remove_cart_item(sanitize_text_field($_POST['cart_item_key']));
  }
  echo json_encode(array(
    'success'      => true,
    'cart_count'   => WC()->cart->get_cart_contents_count(),
    'cart_total'   => number_format(WC()->cart->cart_contents_total ,2),
    'cart_content' => mitch_get_cart_content($lang) 
    )
  );
  wp_die();
}

add_action('wp_ajax_update_cart_items', 'mitch_update_cart_items');
add_action('wp_ajax_nopriv_update_cart_items', 'mitch_update_cart_items');
function mitch_update_cart_items(){
  $item_total      = 0;
  $post_cart_key   = sanitize_text_field($_POST['cart_item_key']);
  $quantity_number = intval($_POST['quantity_number']);
  $lang = $_POST['lang'] ;

  if(!empty($quantity_number)){
    WC()->cart->set_quantity($post_cart_key, $quantity_number);
    foreach(WC()->cart->get_cart() as $cart_item_key => $cart_item){
      if($cart_item_key == $post_cart_key){
        $item_total = $cart_item['line_subtotal'];
        break;
      }
    }

    $item_total = number_format($item_total);
    // var_dump(WC()->cart->get_cart_contents_count());
    // exit;
    echo json_encode(array(
      'success'      => true,
      'cart_count'   => WC()->cart->get_cart_contents_count(),
      'cart_total'   => number_format(WC()->cart->cart_contents_total ,2),
      'cart_content' => mitch_get_cart_content($lang),
      'item_total'   => $item_total)
    );
  }
  wp_die();
}

add_action('wp_ajax_mitch_apply_coupon', 'mitch_apply_coupon');
add_action('wp_ajax_nopriv_mitch_apply_coupon', 'mitch_apply_coupon');
function mitch_apply_coupon(){
  global $fixed_string;
  $cart_discount_div = '';
  $coupon_code       = sanitize_text_field($_POST['coupon_code']);
  $coupon_id         = wc_get_coupon_id_by_code($coupon_code);
  //$coupon_data = new WC_Coupon($coupon_code);
  if(!empty($coupon_id)){
    WC()->cart->apply_coupon($coupon_code);
    WC()->cart->calculate_totals();
    $errors = WC()->session->get('wc_notices', array())['error'];
    $count  = count($errors);
    $msg  = '';
    if(isset($errors) && !empty($errors)){
      foreach($errors as $key => $error_data){
          $msg  .= $error_data['notice'];
      }
      $response = array(
        'status' => 'error',
        'code'   => 401,
        'msg'    => $msg
      );
      wc_clear_notices();
    }else{

      $response = array('status' => 'success', 'cart_total' =>  number_format(WC()->cart->cart_contents_total ) . " EGP", 'cart_discount_div' => $cart_discount_div);
    }
  }else{
    $response = array('status' => 'error', 'code' => 401, 'msg' => 'Coupon code is wrong!');
  }
  echo json_encode($response);
  wp_die();
}

add_action('wp_ajax_mitch_remove_coupon', 'mitch_remove_coupon');
add_action('wp_ajax_nopriv_mitch_remove_coupon', 'mitch_remove_coupon');
function mitch_remove_coupon(){
  $coupon_code   = sanitize_text_field($_POST['coupon_code']);
  $lang = $_POST['lang'] ;
  if($_POST['coupon_from'] == 'checkout'){
    global $theme_settings;
    $shipping_data = mitch_get_shipping_data()['shipping_methods'][$theme_settings['default_shipping_method']];
    $shipping_cost = $shipping_data['cost'];
  }else{
    $shipping_cost = 0;
  }
  WC()->cart->remove_coupon($coupon_code);
  WC()->cart->calculate_totals();
  $response        = array(
    'status'       => 'success',
    'cart_total'   =>  number_format(WC()->cart->cart_contents_total + $shipping_cost) . " EGP",
    'cart_count'   => WC()->cart->get_cart_contents_count(),
    'cart_content' => mitch_get_cart_content($lang),
  );
  echo json_encode($response);
  wp_die();
}

add_action('wp_ajax_mitch_bought_together_products', 'mitch_bought_together_products');
add_action('wp_ajax_nopriv_mitch_bought_together_products', 'mitch_bought_together_products');
function mitch_bought_together_products(){
  $msg          = '';
  $form_data    = $_POST['form_data'];
  $products_ids = (array)$form_data['products_ids'];
  foreach($products_ids as $product_id){
    $added_to_cart   = WC()->cart->add_to_cart($product_id, 1);
  }
  if($added_to_cart){
    $response = array(
      'status'       => 'success',
      'cart_count'   => WC()->cart->get_cart_contents_count(),
      'cart_content' => mitch_get_cart_content($lang),
      'cart_total'   => number_format(WC()->cart->cart_contents_total ,2),
      'msg'          => 'اضافة المنتجات الي سلة المشتريات',
    );
  }else{
    $errors = WC()->session->get('wc_notices', array())['error'];
    $count  = count($errors);
    if(isset($errors) && !empty($errors)){
      foreach($errors as $key => $error_data){
        $msg .= $error_data['notice'];
        if($count > 1){
          $msg = $msg.', ';
        }
      }
    }
    $response = array(
      'status'  => 'error',
      'code'    => 401,
      'msg'     => $msg,
    );
    wc_clear_notices();
  }
  echo json_encode($response);
  // if(!empty($products_ids)){
  //   echo '<pre>';
  //   var_dump($products_ids);
  //   echo '</pre>';
  // }
  wp_die();
}


function mitch_get_cart_content($lang){
  if(empty($lang))
  {
    $lang = 'ar';
  }
  
  global $fixed_string, $theme_settings ;
  $items            = WC()->cart->get_cart();
  $cart_total       = WC()->cart->cart_contents_total;
  $cart_items_count = WC()->cart->get_cart_contents_count();
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
  if($cart_items_count == 0){
    $mini_class = 'empty_min_cart';
  }else{
    $mini_class = 'min_cart';
  }
  $cart_content = '
  <div id="mini_cart" class="'.$mini_class.'">
    <div class="top">
      <div class="cart_info">
        <div class="title_min_cart">
          <h2> '. cart_page('cart_title' , $lang)  .'</h2>
          <div class="section_icon_cart">
              <p id="cart_total_count">'.$cart_items_count.'<span>' .cart_page('item' , $lang).'</span> </p>
          </div>
        </div>
        <button type="button" class="popup__close material-icons js-popup-closer">close</button>
      </div>
    </div>
    <div class="all_item">';
      if(!empty($items)){
        $count_items = 0;
        foreach($items as $item => $values){
          $arabic_fields = MD_product_widget_data( $values['product_id'] , $lang);
          $products_ids[]    = $values['product_id'];
          $cart_product_data = mitch_get_short_product_data($values['product_id']);
          $order             = $cart_items_count - $count_items;
          if(!empty($values['variation_id'])){
            $product_id = $values['variation_id'];
          }else{
            $product_id = $values['product_id'];
          }
          if(get_post_meta($product_id, '_backorders', true) == 'yes' || get_post_meta($product_id, '_stock_status', true) == 'onbackorder'){
            $product_backorder = '<br>(Pre Order)';
          }else{
            $product_backorder = '';
          }
          $item_product_id   = $values['product_id'];
          if(!empty($values['variation_id'])){
            $item_product_id = $values['variation_id'];
          }
          $item_stock        = get_post_meta($item_product_id, '_stock', true);
          $cart_content     .= '
          <div id="mini_cart_'.$item.'" class="single_item" style="order: '.$order.';">
              <div class="sec_item">
                  <div class="img">
                      <img height="100" src="'.$cart_product_data['product_image'].'" alt="'.$cart_product_data['product_title'].'">
                  </div>
                  <div class="info">
                      <div class="info_top">
                        <div class="text">
                            <a href="'.$cart_product_data['product_url'].'">
                            <h4>'.$arabic_fields['name'].' '.$product_backorder.'</h4>
                              <h6 class="note_delivery"> '.$arabic_fields['subtitle'].' </h6>
                            </a>';
                            if(!empty($values['variation']) && $values['product_id'] != 3065){
                              $cart_content .= '<ul>';

                              $remove = "attribute_pa_";
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
                                if($lang == 'en'){
                                  $cart_content .= '<li>'. $attribute_english .'</li>';
                                }else {
                                  $cart_content .= '<li>' .$attribute_arabic .'</li>';
                                }
                                  
                                
                              
                              }
                              $cart_content .= '</ul>';
                            }
                            $cart_content .= '
                        </div>
                        <a class="remove_min_cart href="javascript:void(0);" onclick="cart_remove_item(\''.$item.'\', \''.$values['product_id'].'\', \'mini_cart\');">'.cart_page('remove' , $lang).'</a>

                      </div>
                      <div class="info_bottom">
                       
                        <div class="price">
                              <p class="total_price"><span id="line_subtotal_'.$item.'">'.number_format($values['line_subtotal']).'</span> '.$theme_settings['curren_currency_' . $lang].'</p>
                        </div>
                        <div class="section_qty">

                            <button class="increase" id="increase" onclick="increaseValueByID(\'number_'.$item.'\' );update_cart_items(\''.$item.'\', \'mini_cart\' ,\''.$item_stock.'\', \''.$values['product_id'].'\');" value="Increase Value"></button>
                            <input class="number_count" type="number" id="number_'.$item.'" value="'.$values['quantity'].'" />
                            <button class="decrease" id="decrease" onclick="decreaseValueByID(\'number_'.$item.'\');update_cart_items(\''.$item.'\', \'mini_cart\' , \''.$item_stock.'\', \''.$values['product_id'].'\');" value="Decrease Value"></button>
                        </div>
                        

                      </div>
                  </div>
              </div>
          </div>';
          $count_items++;
          
        }
        //"'.$item.'", ''
      }else{
        $cart_content .= '
        <div class="section_emty">
            <img src="'.$theme_settings['theme_url'].'/assets/img/icons/cart.png" alt="">
            <p> '.cart_page('empty_cart' , $lang).'</p>
            
            <a class="shop" href="';
            $shop_url = home_url();
            if($lang == 'en'){  $shop_url = home_url('shop/?lang=en') ;} else {$shop_url = home_url('shop');}
          
            $cart_content = $cart_content . $shop_url .
            '">
              <button type="button"> '.cart_page('shop_now' , $lang ).'</button>
            </a>
        </div>';
      }
      $cart_content .= '
    </div>
    <div class="bottom">
      <div class="bottom_info">
        <div class="info_min_cart">
          <h4>'.cart_page('total' , $lang).'</h4>
          <div class="sec_price">
            <p class="price">'.number_format(WC()->cart->cart_contents_total).'</span> '.$theme_settings['curren_currency_' . $lang].'</p>' ;
            if(WC()->cart->cart_contents_total != WC()->cart->subtotal){
              $cart_content = $cart_content . '
            <p class="price-discount">'.number_format(WC()->cart->subtotal).'</span> '.$theme_settings['curren_currency_' . $lang].'</p> ' ;
            }
            $cart_content = $cart_content . '
            <span class="qun">'.$cart_items_count.' Item</span>
          </div>
        </div>
      </div>
      <div class="button_action">
          <a class="open_checkout" href="' ;
              $checout_url = home_url();
              if($lang == 'en'){  $checout_url = home_url('checkout/?lang=en') ;} else {$checout_url = home_url('checkout');}
            
              $cart_content = $cart_content . $checout_url . '"
            <button type="button"> '.cart_page('order_now' , $lang).' </button>
          </a>
          <a class="open_cart" href="';
              $cart_url = home_url();
              if($lang == 'en'){  $cart_url = home_url('cart/?lang=en') ;} else {$cart_url = home_url('cart');}
            
              $cart_content = $cart_content . $cart_url . '"
            <button type="button"> '.cart_page('cart_page' , $lang).'</button>
          </a>
      </div>
      
    </div>
  </div>
  ';
    return $cart_content;
}

function mitch_repeat_order(){
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if($_POST['action'] == 'repeat_order'){
      // $new_order_id = mitch_create_order_from(intval($_POST['order_id']));
      // if($new_order_id){
      //   wp_redirect(home_url('my-account/orders-list/?order_id='.$new_order_id.''));
      //   exit;
      // }
      // var_dump($_POST);
      // exit;
      if($_POST['repeat_action'] == 'no_items'){
        WC()->cart->empty_cart();
      }
      $custom_cart_data = array();
      $r_order_obj      = wc_get_order(intval($_POST['order_id']));
      foreach($r_order_obj->get_items() as $cart_item_key => $values){
        if(!empty($values['custom_cart_data'])){
  				$items_data = $values['custom_cart_data'];
  				if(!empty($items_data['visit_type'])){
            $custom_cart_data['visit_type'] = $items_data['visit_type'];
  				}
  				if(!empty($items_data['visit_branch'])){
            $custom_cart_data['visit_branch'] = $items_data['visit_branch'];
  				}
  				if(!empty($items_data['visit_home'])){
            $custom_cart_data['visit_home'] = $items_data['visit_home'];
  				}
          if(!empty($items_data['attributes_keys'])){
            $custom_cart_data['attributes_keys'] = $items_data['attributes_keys'];
  				}
          if(!empty($items_data['attributes_vals'])){
            $custom_cart_data['attributes_vals'] = $items_data['attributes_vals'];
  				}
          $total_price = 0;
          // echo '<pre>';
          // var_dump($values);
          // echo '</pre>';
          // exit;
          if(!empty($items_data['variations_ids'])){
            foreach($items_data['variations_ids'] as $variation_id){
              $total_price = $total_price + (float)get_post_meta($variation_id, '_price', true);
            }
          }
          $custom_cart_data['custom_total'] = $total_price;
          $custom_cart_data_arr             = array('custom_cart_data' => $custom_cart_data);
          // echo '<pre>';
          // var_dump($custom_cart_data_arr);
          // echo '</pre>';
          // exit;
          $added_to_cart = WC()->cart->add_to_cart($values['product_id'], 1, $variation_id, wc_get_product_variation_attributes($variation_id), $custom_cart_data_arr);
  			}else{
          if(!empty($values['variation_id'])){
            $product_id = $values['variation_id'];
          }else{
            $product_id = $values['product_id'];
          }
          $added_to_cart   = WC()->cart->add_to_cart($product_id, $values['quantity']);
        }
      }
      if($added_to_cart){
        wp_redirect(home_url('cart'));
        exit;
      }
    }
    wp_redirect(home_url('my-account/orders-list/?order_id='.intval($_POST['order_id']).'&response=error'));
    exit;
  }
}

//update cart prices to rate price
/*add_action( 'woocommerce_before_calculate_totals', 'add_custom_item_price', 10 );
function add_custom_item_price($cart_object){
  foreach($cart_object->get_cart() as $item_values){
    ## Set the new item price in cart
    // $item_values['data']->set_price(mitch_get_product_price_after_rate($item_values['data']->price));
    @$item_values['data']->set_price($item_values['data']->price);
  }
}*/

function mitch_get_cart_content_fresh(){

  $lang = $_POST['lang'];



  $response = array(
    'status'       => 'success',
    'cart_count'   => WC()->cart->get_cart_contents_count(),
    'cart_content' => mitch_get_cart_content($lang),
    'cart_subtotal' => WC()->cart->subtotal,
    'lang'          => $lang,
  );
  echo json_encode($response);
  wp_die();
}
add_action('wp_ajax_get_cart_content_fresh', 'mitch_get_cart_content_fresh');
add_action('wp_ajax_nopriv_get_cart_content_fresh', 'mitch_get_cart_content_fresh');