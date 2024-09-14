<?php
function mitch_add_wishlist_product($product_id){
  $current_user_id = get_current_user_id();
  if(!empty($current_user_id)){
    global $wpdb;
    if(empty($wpdb->get_row("SELECT ID FROM wp_mitch_wishlist WHERE user_id = {$current_user_id} AND product_id = {$product_id}"))){
      return $wpdb->insert('wp_mitch_wishlist', array(
        'user_id'    => $current_user_id,
        'product_id' => $product_id
      ));
    }
  }
  return false;
}

function mitch_remove_wishlist_product($product_id){
  $current_user_id = get_current_user_id();
  if(!empty($current_user_id)){
    global $wpdb;
    return $wpdb->query("DELETE FROM wp_mitch_wishlist WHERE user_id = {$current_user_id} AND product_id = $product_id");
  }
  return false;
}

function mitch_get_wishlist_products(){
  $current_user_id = get_current_user_id();
  if(!empty($current_user_id)){
    global $wpdb;
    return $wpdb->get_results("SELECT product_id FROM wp_mitch_wishlist WHERE user_id = {$current_user_id}");
  }
  return false;
}

function mitch_check_wishlist_product($current_user_id, $product_id){
  //$current_user_id = get_current_user_id();
  if(!empty($current_user_id)){
    global $wpdb;
    return $wpdb->get_row("SELECT ID FROM wp_mitch_wishlist WHERE user_id = {$current_user_id} AND product_id = {$product_id}");
  }
  return false;
}

add_action('wp_ajax_add_product_to_wishlist', 'mitch_add_product_to_wishlist_action');
add_action('wp_ajax_nopriv_add_product_to_wishlist', 'mitch_add_product_to_wishlist_action');
function mitch_add_product_to_wishlist_action(){
  $product_id      = intval($_POST['product_id']);
  // var_dump($product_id);
  // exit;
  if($product_id){
    $add = mitch_add_wishlist_product($product_id);
  }

  if($add){
    $response = array('status'     => 'success');
  }else{
    $response = array('status'     => 'error');
  }
  echo json_encode($response);
  wp_die();
}

add_action('wp_ajax_remove_product_from_wishlist', 'mitch_remove_product_from_wishlist_action');
add_action('wp_ajax_nopriv_remove_product_from_wishlist', 'mitch_remove_product_from_wishlist_action');
function mitch_remove_product_from_wishlist_action(){
  $product_id      = intval($_POST['product_id']);
  if($product_id){
    $delete = mitch_remove_wishlist_product($product_id);
  }
  if($delete){
    $response = array('status'     => 'success');
  }else{
    $response = array('status'     => 'error');
  }
  echo json_encode($response);
  wp_die();
}
