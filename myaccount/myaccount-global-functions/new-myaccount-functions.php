<?php


// ---------------------------- New My Account Functions -----------------------------

// ---------------------------------- ADD Address ---------------------------
add_action('wp_ajax_MD_add_user_address', 'MD_add_user_address');
add_action('wp_ajax_nopriv_MD_add_user_address', 'MD_add_user_address');
function MD_add_user_address(){
  
  //Fetch Recieved Address Data 
  $city = $_POST['city'];
  $area = $_POST['area'];
  $district = $_POST['district'];
  $full_address = $_POST['full_address'];
  $floor = $_POST['floor'];
  $apartment = $_POST['apartment'];
  $came_from = $_POST['came_from'];

 
  // Insert Into Database 
  $your_table_name = 'wp_mitch_users_addresses';
  global $wpdb;
  if($came_from == 'add'){
    $wpdb->insert(
      $your_table_name, 
      array(
          'user_id' => get_current_user_id() ,
          'level_1' => $city,
          'level_2' => $area ,
          'level_3' => $district,
          'full_address' => $full_address,
          'Floor' => $floor, 
          'apartment' => $apartment,
          'address_type' => '0' ,
      )
    );

  }
  else{
    $wpdb->insert(
      $your_table_name, 
      array(
          'user_id' => get_current_user_id() ,
          'level_1' => $city,
          'level_2' => $area ,
          'level_3' => $district,
          'full_address' => $full_address,
          'Floor' => $floor, 
          'apartment' => $apartment,
      )
    );
  }
    

    
    $response = array(
      'status'       => 'success',
    );

    echo json_encode($response);
    wp_die();

  }

  // -------------------------------- Remove Address ----------------------------------
  
add_action('wp_ajax_MD_remove_address', 'MD_remove_address');
add_action('wp_ajax_nopriv_MD_remove_address', 'MD_remove_address');
function MD_remove_address(){

    //Fetch Data
    $address_id = $_POST['address_id'];
    $default_address = $_POST['default_address'];

    //Remove Row From Database by ID 
    $your_table_name = 'wp_mitch_users_addresses';
    global $wpdb;

    if($default_address == 0 ){
        $wpdb->delete( $your_table_name, array( 'id' => $address_id ) );
    }
    else {
        $current_user_id = get_current_user_id();
        $other_addresses = mitch_get_user_others_addresses_list($current_user_id); 
      
        $wpdb->delete( $your_table_name, array( 'id' => $address_id ) );
        if(!empty($other_addresses)){
            //update address to default 
              $wpdb->update( $your_table_name, array( 'address_type' => '0' ), array( 'ID' => $other_addresses[0]->ID ) ) ;
        }
    }
    

    $response = array(
      'status'       => 'success',
    );

    echo json_encode($response);
    wp_die();

}

// ------------------------------ Change Default Address ------------------------------
add_action('wp_ajax_MD_change_default_address', 'MD_change_default_address');
add_action('wp_ajax_nopriv_MD_change_default_address', 'MD_change_default_address');
function MD_change_default_address(){

  //Fetch Data 

    $current_address = $_POST['current_address'];
    $new_address = $_POST['new_address'];

    $your_table_name = 'wp_mitch_users_addresses';
    global $wpdb;

    //Change  Default Address to 1 
    $wpdb->update( $your_table_name, array( 'address_type' => '1' ), array( 'ID' => $current_address ) ) ;
    
    //Change  New Address to Default Address 
    $wpdb->update( $your_table_name, array( 'address_type' => '0' ), array( 'ID' => $new_address ) ) ;

    $response = array(
      'status'       => 'success',
    );

    echo json_encode($response);
    wp_die();

}

// ------------------------------------- Edit Address ------------------------------
add_action('wp_ajax_MD_edit_address', 'MD_edit_address');
add_action('wp_ajax_nopriv_MD_edit_address', 'MD_edit_address');
function MD_edit_address(){
  //Fetch Data 
  $post_form_data  = $_POST['form_data'];
	parse_str($post_form_data, $form_data);
  $address_id = $_POST['address_id'];

  
  $your_table_name = 'wp_mitch_users_addresses';
  global $wpdb;


  //Update Database Record 
  $wpdb->update( $your_table_name, array( 
    'level_1' => sanitize_text_field($form_data['city']) ,
    'level_2' => sanitize_text_field($form_data['area']) ,
    'level_3' => sanitize_text_field($form_data['district']) ,
    'full_address' => sanitize_text_field($form_data['street_info']) , 
    'Floor' => sanitize_text_field($form_data['floor']) ,
    'apartment' => sanitize_text_field($form_data['apartment'])  , 
   ), array( 'ID' => $address_id ) ) ;


   $response = array(
    'status'       => 'success',
  );

  echo json_encode($response);
  wp_die();



}
add_action('wp_ajax_MD_address_info', 'MD_address_info');
add_action('wp_ajax_nopriv_MD_address_info', 'MD_address_info');
function MD_address_info(){
  $address_id = $_POST['address_id'];
  $index = $_POST['index'];
  $language = $_POST['lang'];

  //Get Address Info 
  if($index == 0)
  {
    //return Default Address 
    $main_address    = mitch_get_user_main_address(get_current_user_id());
     // Get All Areas Related to the selected Gov 
     $areas = MD_Get_area($main_address -> level_1); 
     $area_name = "area_name_". $language ; 
     if($language == 'en'){$default_area = "Choose Area" ; }else {$default_area = " اختر الحي" ;}
     $middle = $middle . '<option disabled value = "false" >'. $default_area.' </option>'; 
     foreach($areas as $one_area){ 
       if($one_area->area_id == $main_address-> level_2 ){
         $middle = $middle . '<option  value = "' . $one_area->area_id . '"  selected >' . $one_area->$area_name . '</option>'; 
       }else{
         $middle = $middle . '<option  value = "' . $one_area->area_id . '" >' . $one_area->$area_name . '</option>'; 
       }
           
     }
 
     if($language == 'en'){$default_street = "Choose District" ; }else {$default_street = "اختر المنطقة" ;}
     $streets = MD_Get_street($main_address -> level_2);
     $street_name = 'street_name_' . $language;
       $last = $last . '<option disabled value = "false" > '. $default_street .' </option>'; 
     foreach($streets as $one_street){ 
             $last = $last . '<option value = "' . $one_street->street_id . '" >' . $one_street->$street_name . '</option>'; 
     }
 
     $response = array(
       'status'       => 'success',
       'level_1'         => $main_address -> level_1 ,
       'level_2'         => $main_address -> level_2,
       'level_3'         => $main_address -> level_3,
       'full_address'         => $main_address-> full_address ,
       'floor'         => $main_address -> Floor  ,
       'apartment'         => $main_address -> apartment , 
       'level_2_select'    => $middle ,
       'level_3_select'    => $last,
     );
   
  


  }
  else{
    //return Address - 1 index 
    $other_addresses = mitch_get_user_others_addresses_list(get_current_user_id());

    // Get All Areas Related to the selected Gov 
    $areas = MD_Get_area($other_addresses[$index - 1] -> level_1); 
    $area_name = "area_name_". $language ; 
    if($language == 'en'){$default_area = "Choose Area" ; }else {$default_area = " اختر الحي" ;}
    $middle = $middle . '<option disabled value = "false" >'. $default_area.' </option>'; 
    foreach($areas as $one_area){ 
      if($one_area->area_id == $other_addresses[$index - 1] -> level_2 ){
        $middle = $middle . '<option  value = "' . $one_area->area_id . '"  selected >' . $one_area->$area_name . '</option>'; 
      }else{
        $middle = $middle . '<option  value = "' . $one_area->area_id . '" >' . $one_area->$area_name . '</option>'; 
      }
          
    }

    if($language == 'en'){$default_street = "Choose District" ; }else {$default_street = "اختر المنطقة" ;}
    $streets = MD_Get_street($other_addresses[$index - 1] -> level_2);
    $street_name = 'street_name_' . $language;
      $last = $last . '<option disabled value = "false" > '. $default_street .' </option>'; 
    foreach($streets as $one_street){ 
            $last = $last . '<option value = "' . $one_street->street_id . '" >' . $one_street->$street_name . '</option>'; 
    }

    $response = array(
      'status'       => 'success',
      'level_1'         => $other_addresses[$index - 1] -> level_1 ,
      'level_2'         => $other_addresses[$index - 1] -> level_2,
      'level_3'         => $other_addresses[$index - 1] -> level_3,
      'full_address'         => $other_addresses[$index - 1]-> full_address ,
      'floor'         => $other_addresses[$index - 1] -> Floor  ,
      'apartment'         => $other_addresses[$index - 1] -> apartment , 
      'level_2_select'    => $middle ,
      'level_3_select'    => $last,
    );
  

  }

  echo json_encode($response);
  wp_die();

  


}

// -------------------------------------- Edit Account Info -------------------------------
add_action('wp_ajax_MD_edit_account_info', 'MD_edit_account_info');
add_action('wp_ajax_nopriv_MD_edit_account_info', 'MD_edit_account_info');
function MD_edit_account_info(){

  $post_form_data  = $_POST['form_data'];
	parse_str($post_form_data, $form_data);
  $lang = $_POST['lang'] ;
  $your_table_name = 'wp_mitch_users_addresses';
  global $wpdb;

  // Update User Account Details 
  $current_user_id = get_current_user_id();
  $phone_number          = sanitize_text_field($form_data['phone_number']);
  $filtered_phone_number = filter_var($phone_number, FILTER_SANITIZE_NUMBER_INT);
  $valid = true ;
  if(strlen($filtered_phone_number) != 11){
    $valid = false ;
    $response = array('status' => 'error', 'code' => '401', 'msg' =>  Myaccount_translation('alert_profile_set_phone_err' , $lang));
  }

  if($valid){
    update_user_meta($current_user_id , 'first_name' , sanitize_text_field($form_data['first_name'] ) ); 
    update_user_meta($current_user_id , 'last_name' , sanitize_text_field($form_data['last_name'] ) );
    update_user_meta($current_user_id , 'phone_number' , sanitize_text_field($form_data['phone_number'] ) );
    update_user_meta($current_user_id , 'birth_day' , sanitize_text_field($form_data['day'] ) );
    update_user_meta($current_user_id , 'birth_month' , sanitize_text_field($form_data['month'] ) );
    update_user_meta($current_user_id , 'birth_year' , sanitize_text_field($form_data['year'] ) );
    update_user_meta($current_user_id , 'gender' , sanitize_text_field($form_data['gender'] ) );
  
  
     $response = array(
      'status'       => 'success',
    );
  }
  

  echo json_encode($response);
  wp_die();


}

add_action('wp_ajax_MD_change_account_password', 'MD_change_account_password');
add_action('wp_ajax_nopriv_MD_change_account_password', 'MD_change_account_password');
function MD_change_account_password(){

  $post_form_data  = $_POST['form_data'];
  $lang = $_POST['lang'];
	parse_str($post_form_data, $form_data);

  // Validate Current Password 
  $current_user_id = get_current_user_id();
  $user_info = get_userdata($current_user_id);
  $wp_pass = $user_info->user_pass;
  $confirm = wp_check_password($form_data['current_password'], $wp_pass, $current_user_id);
  if($confirm){

    $valid = true ;
    //Check New Password  
    if(strlen($form_data['new_password']) < 8  ){
      $response = array(
        'status'       => 'error',
        'msg'         => ($lang == 'en') ?'<p> Password Must Be More Than Or Equals 8 Charecters ! </p>' : 'يجب أن تكون كلمة المرور أكثر من أو تساوي 8 رموز!'
      );
     $valid = false ;
    }else if(!containsSpecialAndUppercase($form_data['new_password'])){
      $response = array(
        'status'       => 'error',
        'msg'         => ($lang == 'en') ? '<p> Password Must Contain at least one Uppercase letter  ! </p>' :'يجب أن تحتوي كلمة علي حرف كبير واحد' 
      );
      $valid = false ;
    }else  if($form_data['new_password'] != $form_data['confirm_password']){
      $response = array(
        'status'       => 'error',
        'msg' => ($lang == 'en') ? '<p>Passwords Do Not Match!</p>' : '<p>كلمات المرور غير متطابقة</p>'
      );
      $valid = false ;
    }

    if($valid){
      wp_set_password(sanitize_text_field($form_data['new_password'] ) , $current_user_id ) ;

      $response = array(
        'status'       => 'success', 
        'msg'         => ($lang == 'en') ?  '<p> Passwords Changed Successfully  </p>' : '<p> تم تغيير كلمات المرور بنجاح </ p>'
      );
    }
   


  }else{
    $response = array(
      'status'       => 'error',
      'msg'         => ($lang == 'en') ?  '<p> Invalid Current Password !  </p>' : '<p> كلمة المرور الحالية غير صحيحة! </p>'
    );
  }
  echo json_encode($response);
  wp_die();


}
add_action('wp_ajax_MD_order_again', 'MD_order_again');
add_action('wp_ajax_nopriv_MD_order_again', 'MD_order_again');
function MD_order_again(){
  $order_id = $_POST['order_id'] ;

  $order = wc_get_order( $order_id ); //returns WC_Order if valid order 
  $items = $order->get_items();   //returns an array of WC_Order_item or a child class (i.e. WC_Order_Item_Product)

  foreach( $items as $item ) {

      //returns the type (i.e. variable or simple)
      $type = $item->get_type();

      //the product id, always, no matter what type of product
      $product_id = $item->get_product_id();
      $product = $item->get_product();

      //a default
      $variation_id = false;

      //check if this is a variation using is_type
      if( !$product->is_type('simple') ){
          $variation_id = $item->get_variation_id();


          $added_to_cart   = WC()->cart->add_to_cart($product_id, 1, $variation_id, wc_get_product_variation_attributes($variation_id));

      }
      else {
        $added_to_cart   = WC()->cart->add_to_cart($product_id, 1); 

      }

  }

  if($added_to_cart){
    $response = array(
      'status'       => 'success',
      'cart_count'   => WC()->cart->get_cart_contents_count(),
      'cart_content' => mitch_get_cart_content(),
      'msg'          => 'Added To Cart Successfully.'
    );
  }else{
      $response = array(
        'status' => 'error',
        'msg'    => 'Item Not Found '
      );
   
  }

  

  echo json_encode($response);
  wp_die();



} 

// --------------------------------------- Create Custom Post for Cancelled Orders ---------------------------- 
// function MD_order_cancel_system() {
// 	$supports = array(
// 		'title', 'editor'     
// 	);
// 	$labels = array(
// 		'name'           => __('Cancelled Orders', 'plural'),
// 		'singular_name'  => __('Cancelled Orders', 'singular'),
// 		'menu_name'      => __('Cancelled Orders', 'admin menu'),
// 		'name_admin_bar' => __('Cancelled Orders', 'admin bar'),
// 		'add_new'        => __('Add Cancelled Order'),
// 		'add_new_item'   => __('Add Cancelled Order'),
// 		'new_item'       => __('Cancel New Orders'),
// 		'edit_item'      => __('Edit Reason'),
// 		'view_item'      => __('View Reasons'),
// 		'all_items'      => __('All Cancelled Orders'),
// 		'search_items'   => __('Search Orders'),
// 		'not_found'      => __('No Order found.'),
// 	);
// 	$args = array(
// 		'supports'     => $supports,
// 		'labels'       => $labels,
// 		'public'       => true,
// 		'query_var'    => true,
// 		'rewrite'      => array('slug' => 'cancelled_orders'),
// 		'has_archive'  => true,
// 		'hierarchical' => false,
// 	);
// 	register_post_type('cancel_order', $args);
// }

// add_action('init', 'MD_order_cancel_system');

// add_action('init', 'mitch_add_category_taxonomy_to_cancelled_orders', 0);
// function mitch_add_category_taxonomy_to_cancelled_orders(){
//   // Labels part for the GUI
//   $labels = array(
//     'name'          => __('Reasons'),
//     'singular_name' => __('Reasons'),
//     'menu_name'     => __('Reasons'),
//   );
//   // Now register the non-hierarchical taxonomy like tag
//   register_taxonomy('cancelling_reasons','cancel_order',array(
//     'hierarchical'          => false,
//     'labels'                => $labels,
//     'show_ui'               => true,
//     'show_in_rest'          => true,
//     'show_admin_column'     => true,
//     'update_count_callback' => '_update_post_term_count',
//     'query_var'             => true,
//     'rewrite'               => array('slug' => 'cancelling_reasons'),
//   ));
// }

// ------------------------------------ Cancel Order ------------------------------------------

add_action('wp_ajax_MD_order_cancel', 'MD_order_cancel');
add_action('wp_ajax_nopriv_MD_order_cancel', 'MD_order_cancel');
function MD_order_cancel(){

  $order_id = $_POST['order_id'];
  
  $post_form_data  = $_POST['form_data'];
	parse_str($post_form_data, $form_data);


  //Get Order by Order Id 
  $order_obj = wc_get_order($order_id);
  if(!empty($order_obj)){
    if($order_obj->get_status() == 'completed')
    {
      $response = array(
        'status' => 'error',
        'msg'    => 'Order Is Completed '
      );
    }
    else {

              
      wp_insert_post(array(
        'post_title'=>'Order #' . $order_id . " Reason :" . sanitize_text_field($form_data['reasons']), 
        'post_type'=>'cancel_order', 
        'post_content'=> sanitize_text_field($form_data['other_reasons']) ,
        'post_status'   => 'publish',
      ));

      $order_obj->update_status('cancelled');
      

      $response = array(
        'status' => 'success',
        'msg'    => 'Cancelled '
      );
    }
   
  }

  echo json_encode($response);
  wp_die();

  
}

// ------------------------------------------- Order Return Functions ----------------------------------------- 
//Add Custom Post For Return Requests 
// function MD_return_requests() {
//   $supports = array(
// 		'title', // post title
// 		'thumbnail', // featured images
// 		'excerpt', // post excerpt
// 	);
// 	$labels = array(
// 		'name'           => _x('Returns Requests', 'plural'),
// 		'singular_name'  => _x('Returns Request', 'singular'),
// 		'menu_name'      => _x('Returns Requests', 'admin menu'),
// 		'name_admin_bar' => _x('Returns Requests', 'admin bar'),
// 		'add_new'        => _x('Add New', 'add new'),
// 		'add_new_item'   => __('Add New Returns Request'),
// 		'new_item'       => __('New Returns Request'),
// 		'edit_item'      => __('Edit Returns Request'),
// 		'view_item'      => __('View Returns Request'),
// 		'all_items'      => __('All Returns Requests'),
// 		'search_items'   => __('Search Returns Requests'),
// 		'not_found'      => __('No Returns Requests found.'),
// 	);

// 	$values = array(
// 		'supports'     => $supports,
// 		'labels'       => $labels,
// 		'public'       => true,
// 		'query_var'    => true,
// 		'rewrite'      => array('slug' => 'returns_requests'),
// 		'has_archive'  => true,
// 		'hierarchical' => false,
// 	);
// 	register_post_type('returns_requests', $values);
// }

// add_action('init', 'MD_return_requests');

// -------------------------- Return Function ------------------------------ 

add_action('wp_ajax_MD_return_request_function', 'MD_return_request_function');
add_action('wp_ajax_nopriv_MD_return_request_function', 'MD_return_request_function');
function MD_return_request_function(){


  $post_form_data  = $_POST['form_data'];
	parse_str($post_form_data, $form_data);

  $order_id = $_POST['order_id'];
  
  $id = wp_insert_post(array(
    'post_title'=>'Return Request For Order #' . $order_id , 
    'post_type'=>'returns_requests', 
    'post_status'   => 'publish',
  ));


  foreach($form_data['product_id'] as $one_product){
    //Get Product Name 
    $product = wc_get_product( $one_product );
    $product_name = $product->get_name();  

    $quantity = "";
    foreach($form_data['product_quantity'] as $one_quantity){
      $one_quantity = explode("-",$one_quantity);
      if($one_product == $one_quantity[1])
      {
        $quantity = $one_quantity[0];
      }

      
       

    }
    $row =  array(
      "product_name" => $product_name,
      "quantity" => $quantity ,

     );
    add_row('products' , $row , $id);

  }

  // change Order Status to Request Return 
  $order_obj = wc_get_order($order_id);
  $order_obj->update_status('return-request');


}

// ------------------------------------------------- Register New Order Status ------------------- ----------------
// Request Return ----------------------------------
// function register_request_return_order_status() {
//   register_post_status( 'wc-return-request', array(
//       'label'                     => 'Return Request',
//       'public'                    => true,
//       'exclude_from_search'       => false,
//       'show_in_admin_all_list'    => true,
//       'show_in_admin_status_list' => true,
//       'label_count'               => _n_noop( 'Return Request <span class="count">(%s)</span>', 'Return Request <span class="count">(%s)</span>' )
//   ) );
// }
// add_action( 'init', 'register_request_return_order_status' );


add_filter( 'wc_order_statuses', 'custom_order_status');
function custom_order_status( $order_statuses ) {
  $order_statuses['wc-return-request'] = _x( 'Return Request', 'Order status', 'woocommerce' ); 
  return $order_statuses;
}

// Cancel Request ---------------------------------------------------------------

// function register_cancel_request_order_status() {
//   register_post_status( 'wc-cancel-request', array(
//       'label'                     => 'Cancel Request',
//       'public'                    => true,
//       'exclude_from_search'       => false,
//       'show_in_admin_all_list'    => true,
//       'show_in_admin_status_list' => true,
//       'label_count'               => _n_noop( 'Return Request <span class="count">(%s)</span>', 'Return Request <span class="count">(%s)</span>' )
//   ) );
// }
// add_action( 'init', 'register_cancel_request_order_status' );


// add_filter( 'wc_order_statuses', 'custom_cancel_request_order_status');
// function custom_cancel_request_order_status( $order_statuses ) {
//   $order_statuses['wc-cancel-request'] = _x( 'Cancel Request', 'Order status', 'woocommerce' ); 
//   return $order_statuses;
// }


// ------------------------------------------- Forgot Password Functions -----------------------------
function containsSpecialAndUppercase($string) {
  // Check for at least one uppercase letter
  if (preg_match('/[A-Z]/', $string)) {
      return true;
  }
return false;
}




?>