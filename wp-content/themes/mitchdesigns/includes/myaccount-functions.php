<?php
function mitch_get_myorders_list(){
  // return get_posts(array(
  //   'numberposts' => -1,
  //   'fields'      => 'ids',
  //   'post_type'   => 'shop_order',
  //   'post_status' => 'all',
  //   'meta_key'    => '_customer_user',
  //   'meta_value'  => get_current_user_id()
  // ));
  return wc_get_orders(array('customer_id' => get_current_user_id()));
}

function mitch_check_phone_number_exist($phone_number){
  global $wpdb;
  return $wpdb->get_row("SELECT user_id FROM wp_usermeta WHERE meta_key = 'phone_number' AND meta_value = '$phone_number'");
}

function mitch_get_user_email($user_id){
  global $wpdb;
  return $wpdb->get_row("SELECT user_email FROM wp_users WHERE ID = $user_id")->user_email;
}

function mitch_get_user_pass($user_id){
  global $wpdb;
  return $wpdb->get_row("SELECT user_pass FROM wp_users WHERE ID = $user_id")->user_pass;
}

function mitch_get_user_others_addresses_list($user_id){
  global $wpdb;
  return $wpdb->get_results("SELECT * FROM wp_mitch_users_addresses WHERE user_id = $user_id AND address_type = 1");
}

function mitch_get_user_main_address($user_id){
  global $wpdb;
  return $wpdb->get_row("SELECT * FROM wp_mitch_users_addresses WHERE user_id = $user_id AND address_type = 0");
}

function mitch_update_user_address($data){
  global $wpdb;
  return $wpdb->update(
    'wp_mitch_users_addresses',
    $data,
    array('ID' => $data['ID'])
  );
}

function mitch_add_user_address($data){
  global $wpdb;
  return $wpdb->insert(
    'wp_mitch_users_addresses',
    $data
  );
}

add_action('wp_ajax_mitch_profile_settings', 'mitch_profile_settings');
add_action('wp_ajax_nopriv_mitch_profile_settings', 'mitch_profile_settings');
function mitch_profile_settings(){
  global $fixed_string;
  $response        = array();
  $current_user_id = get_current_user_id();
  $post_form_data  = $_POST[form_data];
	parse_str($post_form_data, $form_data);
  update_user_meta($current_user_id, 'first_name', sanitize_text_field($form_data['first_name']));
  update_user_meta($current_user_id, 'last_name', sanitize_text_field($form_data['last_name']));
  update_user_meta($current_user_id, 'user_birthday', sanitize_text_field($form_data['user_birthday']));

  update_user_meta($current_user_id, 'billing_state', sanitize_text_field($form_data['billing_state']));
  update_user_meta($current_user_id, 'billing_city', sanitize_text_field($form_data['billing_city']));
  update_user_meta($current_user_id, 'billing_address_1', sanitize_text_field($form_data['address']));
  update_user_meta($current_user_id, 'billing_floor', sanitize_text_field($form_data['floor_no']));
  update_user_meta($current_user_id, 'billing_apartment', sanitize_text_field($form_data['apartment']));

  $filtered_phone_number = filter_var(sanitize_text_field($form_data['phone_number']), FILTER_SANITIZE_NUMBER_INT);
  if(strlen($filtered_phone_number) < 11){
    $response = array('status' => 'error', 'code' => '401', 'msg' => $fixed_string['alert_profile_set_phone_err']);
  }else{
    update_user_meta($current_user_id, 'phone_number', $filtered_phone_number);
  }
  if(mitch_get_user_email($current_user_id) != $form_data['user_email']){
    if(email_exists($form_data['user_email'])){
      $response = array('status' => 'error', 'msg' => $fixed_string['alert_profile_setting_exist_email']);
    }else{
      wp_update_user(array(
        'ID'         => $current_user_id,
        'user_email' => esc_attr($form_data['user_email'])
      ));
    }
  }
  if(!empty($form_data['old_password']) && empty($response)){
    $old_password     = esc_attr($form_data['old_password']);
    $new_password     = esc_attr($form_data['new_password']);
    $confirm_password = esc_attr($form_data['confirm_password']);
    if(!empty($new_password) && !empty($confirm_password)){
      $pass_number       = preg_match('@[0-9]@', $new_password);
      $pass_uppercase    = preg_match('@[A-Z]@', $new_password);
      $pass_lowercase    = preg_match('@[a-z]@', $new_password);
      $pass_specialChars = preg_match('@[^\w]@', $new_password);
      if(strlen($new_password) < 8 || !$pass_number || !$pass_uppercase || !$pass_lowercase || !$pass_specialChars) {
        $response = array('status' => 'error', 'code' => '401', 'msg' => $fixed_string['alert_profile_set_pass_validate']);
      }else{
        $check_old_pass = wp_check_password($old_password, mitch_get_user_pass($current_user_id), $current_user_id);
        if($check_old_pass){
          if($new_password == $confirm_password){
            wp_set_password($new_password, $current_user_id);
          }else{
            $response = array('status' => 'error', 'msg' => $fixed_string['alert_profile_set_pass_not_match']);
          }
        }else{
          $response = array('status' => 'error', 'msg' => $fixed_string['alert_profile_set_old_pass']);
        }
      }
    }else{
      $response = array('status' => 'error', 'msg' => $fixed_string['alert_profile_set_password_empty']);
    }
  }
  if(empty($response)){
    $response = array('status' => 'success');
  }
  echo json_encode($response);
  wp_die();
}

add_action('wp_ajax_mitch_edit_address', 'mitch_edit_address');
add_action('wp_ajax_nopriv_mitch_edit_address', 'mitch_edit_address');
function mitch_edit_address(){
  // $current_user_id = get_current_user_id();
  $post_form_data  = $_POST['form_data'];
	parse_str($post_form_data, $form_data);
  // echo '<pre>';
  // var_dump($form_data); //
  // echo '</pre>';
  // exit;
  if($form_data['operation'] == 'add_address'){
    $operation = mitch_add_user_address(array(
      'country'  => 'EG',//sanitize_text_field($form_data['country']),
      'city'     => sanitize_text_field($form_data['city']),
      'building' => sanitize_text_field($form_data['building']),
      'street'   => sanitize_text_field($form_data['street']),
      'area'     => sanitize_text_field($form_data['area']),
      'user_id'  => get_current_user_id(),
    ));
  }elseif($form_data['operation'] == 'edit_address' && !empty(intval($form_data['address_id']))){
    $operation = mitch_update_user_address(array(
      'ID'       => intval($form_data['address_id']),
      //'country'  => sanitize_text_field($form_data['country']),
      'city'     => sanitize_text_field($form_data['city']),
      'building' => sanitize_text_field($form_data['building']),
      'street'   => sanitize_text_field($form_data['street']),
      'area'     => sanitize_text_field($form_data['area']),
    ));
  }
  if($operation){
    $response = array('status' => 'success');
  }else{
    $response = array('status' => 'error');
  }
  echo json_encode($response);
  wp_die();
}

add_action('wp_ajax_mitch_register_users', 'mitch_register_users');
add_action('wp_ajax_nopriv_mitch_register_users', 'mitch_register_users');
function mitch_register_users(){
  global $fixed_string;
  $response        = array();
  $post_form_data  = $_POST['form_data'];
	parse_str($post_form_data, $form_data);
  $user_email = sanitize_text_field($form_data['user_email']);
  $lang = $_POST['lang'] ;
  if(email_exists($user_email)){
    $response = array('status' => 'error', 'msg' => Myaccount_translation('alert_profile_setting_exist_email' , $lang));
  }
  if(empty($response)){
    $phone_number          = sanitize_text_field($form_data['phone_number']);
    $filtered_phone_number = filter_var($phone_number, FILTER_SANITIZE_NUMBER_INT);
    // var_dump(strlen($filtered_phone_number));
    // exit;
    if(strlen($filtered_phone_number) < 11){
      $response = array('status' => 'error', 'code' => '401', 'msg' =>  Myaccount_translation('alert_profile_set_phone_err' , $lang));
    }
  }
  if(empty($response)){
    if(!empty(mitch_check_phone_number_exist($phone_number))){
      $response = array('status' => 'error', 'msg' => $fixed_string['alert_profile_setting_exist_phone']);
    }
  }
  if(empty($response)){
    $user_password    = esc_attr($form_data['user_password']);
    $confirm_password = esc_attr($form_data['confirm_password']);
    if(!empty($user_password)){
      if(strlen($user_password) < 8){ //|| !$pass_number || !$pass_uppercase || !$pass_lowercase || !$pass_specialChars
        $response = array('status' => 'error', 'code' => '401', 'msg' =>  Myaccount_translation('alert_profile_set_pass_validate' , $lang));
      }
    }else{
      $response = array('status' => 'error', 'msg' => $fixed_string['alert_profile_set_password_empty']);
    }
  }
  // var_dump($user_password);
  // var_dump($user_email);
  // var_dump($response);
  // exit;
  if(empty($response)){
    $result = wp_create_user($user_email, $user_password, $user_email);
    // var_dump($result);
    // exit;
    if(is_wp_error($result)){
      $response = array('status' => 'error', 'msg' => $result->get_error_message());
    }else{
      $user = get_user_by('ID', $result);
      // Add role
      // Remove role
      $user->remove_role('subscriber');
      $user->remove_role('shop_manager');
      $user->remove_role('administrator');
      $user->add_role('customer');
      update_user_meta($user->ID, 'first_name', sanitize_text_field($form_data['first_name']));
      update_user_meta($user->ID, 'last_name', sanitize_text_field($form_data['last_name']));
      update_user_meta($user->ID, 'phone_number', $phone_number);

      add_user_meta($user->ID , 'birth_day' , sanitize_text_field($form_data['day'] ) );
      add_user_meta($user->ID , 'birth_month' , sanitize_text_field($form_data['month'] ) );
      add_user_meta($user->ID , 'birth_year' , sanitize_text_field($form_data['year'] ) );
      add_user_meta($user->ID , 'gender' , sanitize_text_field($form_data['gender'] ) );


      // //add points to User 
      // $points_settings  = get_field('points_settings' , "options");
      // $level_name = $points_settings['groups'][0]['level_name'];
      // $account_start = $points_settings['general_settings']['account_creation_start_points'];
      // global $wpdb ;
      // $wpdb->insert('wp_mitch_points_system' ,array('user_id' => $user->ID , 'user_type' => $level_name , 'current_points' => $account_start ,'total_points' => $account_start  , 'level_number' => 0 ) );

      // // Add to User History
      // $wpdb->insert('wp_mitch_points_history' ,array(
      //   'user_id' => $user->ID ,
      //   'type' => 'Increase' ,
      //   'points_number' =>  $account_start  , 
      //   'msg' => " Account Creation Reward " ,
      //   'points_before' => 0 ,
      //   'points_after' => $account_start
      //   ) );

      
      wp_set_current_user($user->ID);
      wp_set_auth_cookie($user->ID);
      if($lang == 'en'){
          $response = array('status' => 'success', 'redirect_to' => home_url('myaccount?register=true&lang=en'));
      }else{
         $response = array('status' => 'success', 'redirect_to' => home_url('myaccount?register=true'));
      }
   
    }
  }
  // echo '<pre>';
  // var_dump($form_data);
  // echo '</pre>';
  echo json_encode($response);
  wp_die();
}

add_action('wp_ajax_mitch_login_users', 'mitch_login_users');
add_action('wp_ajax_nopriv_mitch_login_users', 'mitch_login_users');
function mitch_login_users(){
  global $fixed_string;
  $response        = array();
  $post_form_data  = $_POST[form_data];
  $lang = $_POST['lang'];
	parse_str($post_form_data, $form_data);
  $creds['user_login']    = sanitize_text_field($form_data['user_email']);
  $creds['user_password'] = esc_attr($form_data['user_password']);
  $creds['remember']      = true;
  $user = wp_signon($creds, false);
  if(is_wp_error($user)){
    if(!empty($fixed_string[$user->get_error_message()])){
      $error = $fixed_string[$user->get_error_message()];
    }else{
      if($lang == 'ar'){
        $error = 'يوجد خطأ في البيانات !';
      }else{
        $error = 'There is a problem with the data, please check again!';
      }
    }
    $response = array('status' => 'error', 'code' => '401', 'msg' => $error);
  }else{
    if($lang == 'en'){
        $response = array('status' => 'success', 'redirect_to' => home_url('myaccount/?lang=en'));
    }else{
        $response = array('status' => 'success', 'redirect_to' => home_url('myaccount/?success_login'));
    }
    
  }
  echo json_encode($response);
  wp_die();
}

// function mitch_order_cancellation_reasons() {
// 	$supports = array(
// 		'title',      // post title
// 		// 'thumbnail', // featured images
// 		// 'excerpt', // post excerpt
// 	);
// 	$labels = array(
// 		'name'           => __('Order Cancellation Reason', 'plural'),
// 		'singular_name'  => __('Order Cancellation Reason', 'singular'),
// 		'menu_name'      => __('Order Cancellation Reason', 'admin menu'),
// 		'name_admin_bar' => __('Order Cancellation Reason', 'admin bar'),
// 		'add_new'        => __('Add New Reason'),
// 		'add_new_item'   => __('Add New Reason'),
// 		'new_item'       => __('New Reason'),
// 		'edit_item'      => __('Edit Reason'),
// 		'view_item'      => __('View Reasons'),
// 		'all_items'      => __('All Reasons'),
// 		'search_items'   => __('Search Reasons'),
// 		'not_found'      => __('No Reasons found.'),
// 	);
// 	$args = array(
// 		'supports'     => $supports,
// 		'labels'       => $labels,
// 		'public'       => true,
// 		'query_var'    => true,
// 		'rewrite'      => array('slug' => 'order_cancellation_reasons'),
// 		'has_archive'  => true,
// 		'hierarchical' => false,
// 	);
// 	register_post_type('ord_cancel_reasons', $args);
// }

// add_action('init', 'mitch_order_cancellation_reasons');

// add_action('init', 'mitch_add_category_taxonomy_to_reasons', 0);
// function mitch_add_category_taxonomy_to_reasons(){
//   // Labels part for the GUI
//   $labels = array(
//     'name'          => __('Reason Language'),
//     'singular_name' => __('Reason Language'),
//     'menu_name'     => __('Reason Language'),
//   );
//   // Now register the non-hierarchical taxonomy like tag
//   register_taxonomy('reasons_languages','ord_cancel_reasons',array(
//     'hierarchical'          => false,
//     'labels'                => $labels,
//     'show_ui'               => true,
//     'show_in_rest'          => true,
//     'show_admin_column'     => true,
//     'update_count_callback' => '_update_post_term_count',
//     'query_var'             => true,
//     'rewrite'               => array('slug' => 'reasons_languages'),
//   ));
// }

// function mitch_get_order_cancel_reasons(){
//   global $theme_settings;
//   $args = array(
//     'tax_query' => array(
//       array(
//         'taxonomy' => 'reasons_languages',
//         'field' => 'slug',
//         'terms' => array(''.$theme_settings['current_lang'].'-lang')
//       )
//     ),
//     'post_type'     =>'ord_cancel_reasons',
//     'order'         => 'ASC',
//     'posts_per_page'=> -1,
//   );
//   return get_posts($args);
// }

function mitch_check_order_phone_number($order_id, $phone_number){
  global $wpdb;
  return $wpdb->get_row("SELECT post_id FROM wp_postmeta WHERE post_id = $order_id AND meta_key = '_billing_phone' AND meta_value = '$phone_number'");
}

add_action('wp_ajax_mitch_cancel_order', 'mitch_cancel_order');
add_action('wp_ajax_nopriv_mitch_cancel_order', 'mitch_cancel_order');
function mitch_cancel_order(){
  global $fixed_string;
  $response        = array();
  $post_form_data  = $_POST[form_data];
	parse_str($post_form_data, $form_data);
  $order_id      = intval($form_data['order_id']);
  $cancel_reason = sanitize_text_field($form_data['cancel_reason']);
  if(!empty($order_id)){
    if(!empty(mitch_check_order_phone_number($order_id, sanitize_text_field($form_data['phone_number'])))){
      $order_obj = wc_get_order($order_id);
      $order_obj->update_status('cancelled');
      // $order_obj->add_order_note('Cancel By User: '.$cancel_reason);
      $comment_id = mitch_add_user_comment(array(
        'order_id' => $order_id,
        'author'   => 'customer',
        'comment'  => 'Cancel By User: '.$cancel_reason,
        'type'     => 'order_note'
      ));
      if($comment_id){
        $response = array('status' => 'success', 'redirect_to' => home_url('my-account/orders-list/'));
      }else{
        $response = array('status' => 'error', 'msg' => $fixed_string['alert_global_error']);
      }
    }else{
      $response = array('status' => 'error', 'msg' => $fixed_string['alert_phone_not_match_order']);
    }
  }
  echo json_encode($response);
  wp_die();
}

function mitch_add_user_comment($comment_data){
  global $wpdb;
  $current_time = current_time('Y-m-d H:i:s');
  return $wpdb->insert(
    'wp_comments',
    array(
      'comment_post_ID' => $comment_data['order_id'],
      'comment_author'  => $comment_data['author'],
      'comment_agent'   => $comment_data['author'],
      'comment_content' => $comment_data['comment'],
      'comment_type'    => $comment_data['type'],
      'user_id'         => get_current_user_id(),
      'comment_date'    => $current_time,
      'comment_date_gmt'=> $current_time
    )
  );
}

function mitch_get_user_comments($order_id){
  global $wpdb;
  $current_user_id = get_current_user_id();
  return $wpdb->get_results("SELECT comment_content, comment_date FROM wp_comments WHERE comment_post_ID = $order_id AND user_id = $current_user_id AND comment_type = 'order_note' AND comment_author = 'customer'");
}