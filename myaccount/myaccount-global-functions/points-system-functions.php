<?php 

// ----------------------------------------------- Points System --------------------------------------

// -------------------------- Add Setting for Shop Manager For Points System ------------------------

if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> 'Points General Settings',
		'menu_title'	=> 'Points System',
		'menu_slug' 	=> 'points-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
}

// --------------------------------------- Main Points Functions ------------------------------------
 function MD_get_user_points_info($current_user_id){
  if(!empty($current_user_id)){
    global $wpdb;
    return $wpdb->get_row("SELECT * FROM wp_mitch_points_system WHERE user_id = {$current_user_id}");
  }
  return false;
}

function MD_check_if_level_available($user_points_info , $points_settings){
  $next_level_name = "";
  $next_level_remaining_points = "";
  $level_available = true;
  if (array_key_exists($user_points_info->level_number + 1 ,$points_settings['groups'])){
    $array['level'] = 1 ;
    $array['next_level_name'] = $points_settings['groups'][$user_points_info->level_number + 1]['level_name'];
    $array['next_level_remaining_points'] = $points_settings['groups'][$user_points_info->level_number + 1]['start_from'] - $user_points_info->total_money ;
  }
  else {
    $array['level'] = 0 ;
  }

  return $array ;

}


// ------------------------------------- Charge Your Wallet ---------------------------- 
add_action('wp_ajax_MD_charge_your_wallet', 'MD_charge_your_wallet');
add_action('wp_ajax_nopriv_MD_charge_your_wallet', 'MD_charge_your_wallet');
function MD_charge_your_wallet(){

  $current_user_id = get_current_user_id();
  $post_form_data  = $_POST['form_data'];
	parse_str($post_form_data, $form_data);


  //Check if User Applied this Coupon Before 
  $applied = false ;

  if (metadata_exists( 'user', $current_user_id, $form_data['code'] ))
  {
    $applied = true ;
    $response = array(
      'status' => 'error',
      'msg'    => '<p>Coupon Applied Before </p>'
    );
  

  }

  if(!$applied){

  $points_settings  = get_field('points_settings' , "options");
  //Check if Coupon is Valid ? 
  $valid = false ;
  $coupon_index = 0 ;
  foreach($points_settings['coupons'] as $one_coupon){
    if($one_coupon['coupon_name'] == $form_data['code'])
    {
      $valid = true ;
      break ;
    }
    $coupon_index++;
  }
  if($valid == false){
    $response = array(
      'status' => 'error',
      'msg'    => '<p>Coupon Not Found </p>'
    );
  }

  if($valid){
    // Add Points To User History 
   

    // Get Current User Points 
    $user_points_record = MD_get_user_points_info($current_user_id);
  
    $Points_table = 'wp_mitch_points_system';
    $History_table = 'wp_mitch_points_history';
    $cash_history_table = 'wp_mitch_cash_history' ;

    global $wpdb;
  
    //Insert User History Record 
  
    $wpdb->insert(
      $History_table, 
      array(
          'user_id' => $current_user_id ,
          'type' => 'Increase',
          'points_number' => $points_settings['coupons'][$coupon_index]['coupon_quantity'] ,
          'msg' => 'Charge Your Wallet  - #' .  $points_settings['coupons'][$coupon_index]['coupon_name']   ,
          'points_before' =>  $user_points_record->current_points , 
          'points_after' =>  $user_points_record->current_points + $points_settings['coupons'][$coupon_index]['coupon_quantity'] ,
      )
    );

    // $wpdb->insert(
    //   $cash_history_table, 
    //   array(
    //       'user_id' => $current_user_id ,
    //       'type' => 'Increase',
    //       'cash_number' => $points_settings['coupons'][$coupon_index]['coupon_quantity'] / $points_settings['groups'][$user_points_record -> level_number]['points_to_currency'],
    //       'msg' => 'Charge Your Wallet  - #' .  $points_settings['coupons'][$coupon_index]['coupon_name']   ,
    //       'cash_before' =>  $user_points_record->current_cash , 
    //       'cash_after' =>  $user_points_record-> current_cash + $points_settings['coupons'][$coupon_index]['coupon_quantity'] / $points_settings['groups'][$user_points_record -> level_number]['points_to_currency'],
    //     )
    //   );



    // Update User Points + Check If Level Up 
    
    //Next Level Count 
    $next_level_name = "";
    $level_available = true;
    if (array_key_exists($user_points_info->level_number + 1 ,$points_settings['groups'])){
        $next_level_name = $points_settings['groups'][$user_points_info->level_number + 1]['level_name'];
        $next_level_start =  $points_settings['groups'][$user_points_info->level_number + 1]['start_from'];
  
    }
    else {
        $level_available = false ;
    }
  
    $level_up = false ;
    if($level_available){
      if($next_level_start  <= $user_points_record->total_money + $points_settings['coupons'][$coupon_index]['coupon_quantity']) {
        $level_up = true ;
      }
  
    }

    //Add Points to User  
    if($level_up){
      $wpdb->update( $Points_table ,
      array( 
       'current_points' => $user_points_record->current_points + $points_settings['coupons'][$coupon_index]['coupon_quantity'] ,
       'current_cash' =>  $user_points_record->current_cash + $points_settings['coupons'][$coupon_index]['coupon_quantity']  / $points_settings['groups'][$user_points_record -> level_number]['points_to_currency'],
       'total_points' => $user_points_record->total_points + $points_settings['coupons'][$coupon_index]['coupon_quantity'] ,
       'user_type' => $next_level_name ,
       'level_number' => $user_points_info->level_number + 1 ,
     ),
   
      array( 'user_id' => $current_user_id )
      
      ) ;
   
    }
    else{
      $wpdb->update( $Points_table ,
      array( 
       'current_points' => $user_points_record->current_points + $points_settings['coupons'][$coupon_index]['coupon_quantity'] ,
       'current_cash' =>  $user_points_record->current_cash + $points_settings['coupons'][$coupon_index]['coupon_quantity']  / $points_settings['groups'][$user_points_record -> level_number]['points_to_currency'],
       'total_points' => $user_points_record->total_points + $points_settings['coupons'][$coupon_index]['coupon_quantity'] ,
     ),
   
      array( 'user_id' => $current_user_id )
      
      ) ;
   
    }
  
    $response = array(
      'status' => 'success',
      'msg'    => '<p>Coupon Applied Successfully </p> '
    );
    add_user_meta($current_user_id , $form_data['code'] , true );

  } // if Valid

  } // if Applied

  echo json_encode($response);
  wp_die();


}

// ---------------------------------------- Get USer Point History -----------------------
function MD_get_user_point_history(){
  $current_user_id = get_current_user_id();

  if(!empty($current_user_id)){
    global $wpdb;
    return $wpdb->get_results("SELECT * FROM wp_mitch_points_history WHERE user_id = {$current_user_id} " );
  }
  return false;


}
// function MD_get_user_cash_history(){
//   $current_user_id = get_current_user_id();

//   if(!empty($current_user_id)){
//     global $wpdb;
//     return $wpdb->get_results("SELECT * FROM wp_mitch_cash_history WHERE user_id = {$current_user_id} " );
//   }
//   return false;


// }



// -----------------------------Start  Handle Redeem Options in checkout  ---------------------------

add_action( 'woocommerce_after_checkout_billing_form', 'add_box_option_to_checkout' );
function add_box_option_to_checkout( $checkout ) {

  $points_settings  = get_field('points_settings' , "options"); 
  if($points_settings['general_settings']['activate']){
  //Check if User Logged In 
  if(is_user_logged_in()){

    //Check if He Has Points Enough for the O
      echo '<div id="message_fields">';
      echo '<div> Discount </div>';
      woocommerce_form_field( 'add_gift_box', array(
        'label'         => __('<div id= "message_redeem"> Redeem Your Points </div>'),
          'type'          => 'checkbox',
          'class'         => array('add_gift_box form-row-wide'),
         
          'placeholder'   => __(''),
      ));//, $checkout->get_value( 'add_gift_box' ));
          echo '</div>';
  }
}

   
}
// Update Function 
add_action('wp_ajax_MD_remove_partial_checkbox_from_checkout', 'MD_remove_partial_checkbox_from_checkout');
add_action('wp_ajax_nopriv_MD_remove_partial_checkbox_from_checkout', 'MD_remove_partial_checkbox_from_checkout');
function MD_remove_partial_checkbox_from_checkout(){

  $enought = false ;
  global $current_user;
  $points_settings  = get_field('points_settings' , "options"); 
  $user_points_info = MD_get_user_points_info($current_user->ID);
  $user_cash = $user_points_info -> current_points / $points_settings['groups'][$user_points_info -> level_number]['points_to_currency'];



  if($user_cash < WC()->cart->total ){
    $enought = false  ;
  } 
  else {
    $enought = true ;
  }

  if($user_cash == 0 ){
    $enought =true;
  }
  $response = array(
    'status' => 'success',
    'points' => $enought ,
    'total' => WC()->cart->total ,
    'total_points' => $user_points_info -> current_points ,
    'total_cash' => $user_cash ,
    'points_type' => 1, 
  );

 
  echo json_encode($response);
  wp_die();

}

add_action( 'wp_footer', 'woocommerce_add_gift_box' );
function woocommerce_add_gift_box() {
    if (is_checkout()) {
    ?>
    <script type="text/javascript">
    jQuery( document ).ready(function( $ ) {
        $('#add_gift_box').click(function(){
          if($('body').data('redeem') == 'true' ){
            $('body').data('redeem' , 'false');
          }else{
            $('body').data('redeem' , 'true');

          } 
          
            jQuery('body').trigger('update_checkout');
        });
    });
    </script>
    <?php
    }
}
// ----------------------------- End Handle Redeem Options in checkout  ---------------------------

// ------------------------------------- Start Adding And Removing Points to User -------------------------

add_action( 'woocommerce_order_status_completed', 'MD_add_points_to_user'  );
function MD_add_points_to_user( $order_id ) {

  //Check if Point System Is Activated 
  $points_settings  = get_field('points_settings' , "options");
  $order_obj = wc_get_order($order_id);

    $current_user_id = $order_obj->get_user_id();
    if($current_user_id == 0)
    return ;

    $full_payment = false;
    $partial_payment = false ;
    // Check if Payment method is Wallet Payment 
    if($order_obj->get_payment_method() == 'wallet_payment' ){
      $full_payment = true;
    }

    if( $order_obj->get_total_fees()  < 0 ){
      $partial_payment = true;
    }
    
    if($full_payment == false){

    // Get Current User Points 
    $user_points_record = MD_get_user_points_info($current_user_id);
    $currency_to_points = $points_settings['groups'][$user_points_record->level_number]['currency_to_points'] ;
  
    $Points_table = 'wp_mitch_points_system';
    $History_table = 'wp_mitch_points_history';
    $cash_history_table = 'wp_mitch_cash_history' ;
    global $wpdb;
  
    //Insert User History Record 
  
    if($partial_payment == true){

      // Insert Into Points History 
      $wpdb->insert(
        $History_table, 
        array(
            'user_id' => $current_user_id ,
            'type' => 'Increase',
            'points_number' => ($order_obj->get_subtotal() + $order_obj->get_total_fees() ) * $currency_to_points ,
            'msg' => 'Completed Order Reward With Partial Wallet Redeem- #' . $order_id  ,
            'points_before' =>  $user_points_record->current_points , 
            'points_after' =>  $user_points_record-> current_points +( $order_obj->get_subtotal() + $order_obj->get_total_fees() ) * $currency_to_points ,
        )
      );

      // Insert Into Cash History
     // $wpdb -> last_error ; 
      // $wpdb->insert(
      //   $cash_history_table, 
      //   array(
      //       'user_id' => $current_user_id ,
      //       'type' => 'Increase',
      //       'cash_number' => (($order_obj->get_subtotal() + $order_obj->get_total_fees() ) * $currency_to_points ) /  $points_settings['groups'][$user_points_record -> level_number]['points_to_currency'],
      //       'msg' => 'Completed Order Reward With Partial Wallet Redeem- #' . $order_id  ,
      //       'cash_before' =>  $user_points_record->current_cash , 
      //       'cash_after' =>  $user_points_record-> current_cash +(( $order_obj->get_subtotal() + $order_obj->get_total_fees() ) * $currency_to_points ) /  $points_settings['groups'][$user_points_record -> level_number]['points_to_currency'],
      //   )
      // );

    }
    else {

      $wpdb->insert(
        $History_table, 
        array(
            'user_id' => $current_user_id ,
            'type' => 'Increase',
            'points_number' => $order_obj->get_subtotal() * $currency_to_points ,
            'msg' => 'Completed Order Reward - #' . $order_id  ,
            'points_before' =>  $user_points_record->current_points , 
            'points_after' =>  $user_points_record->current_points + $order_obj->get_subtotal() * $currency_to_points ,
        )
      );

       // Insert Into Cash History 
      //  $wpdb->insert(
      //   $cash_history_table, 
      //   array(
      //       'user_id' => $current_user_id ,
      //       'type' => 'Increase',
      //       'cash_number' => (($order_obj->get_subtotal() ) * $currency_to_points ) /  $points_settings['groups'][$user_points_record -> level_number]['points_to_currency'],
      //       'msg' => 'Completed Order Reward - #' . $order_id  ,
      //       'cash_before' =>  $user_points_record->current_cash , 
      //       'cash_after' =>  $user_points_record-> current_cash +(( $order_obj->get_subtotal() ) * $currency_to_points ) /  $points_settings['groups'][$user_points_record -> level_number]['points_to_currency'],
      //   )
      // );
    }

    
  
    //Next Level Count    
    $next_level_name = "";
    $level_available = true;
    if (array_key_exists($user_points_record->level_number + 1 ,$points_settings['groups'])){
        $next_level_name = $points_settings['groups'][$user_points_record->level_number + 1]['level_name'];
        $next_level_start =  $points_settings['groups'][$user_points_record->level_number + 1]['start_from'];
  
    }
    else {
        $level_available = false ;
    }
  
    $level_up = false ;
    if($level_available){
      if($next_level_start  <= $user_points_record->total_money + $order_obj->get_subtotal() ) {
        $level_up = true ;
      }
  
    }


    //Add Points to User  
    if($level_up){

      if($partial_payment == true){
        $order_total_with_discount = $order_obj->get_subtotal() +  $order_obj->get_total_fees() ; 
        $wpdb->update( $Points_table ,
        array( 
         'current_points' => $user_points_record->current_points + ( $order_obj->get_subtotal() + $order_obj->get_total_fees() )  * $currency_to_points  ,
         'current_cash' =>  $user_points_record->current_cash +( $order_total_with_discount * $currency_to_points ) / $points_settings['groups'][$user_points_record -> level_number]['points_to_currency'],
         'total_points' => $user_points_record->total_points +( $order_obj->get_subtotal() + $order_obj->get_total_fees() ) * $currency_to_points  ,
         'total_money' => $user_points_record->total_money + ( $order_obj->get_subtotal() + $order_obj->get_total_fees() )  ,
         'user_type' => $next_level_name ,
         'level_number' => $user_points_record->level_number + 1 ,
       ),
     
        array( 'user_id' => $current_user_id )
        
        ) ;
     
      }
      else {
        $wpdb->update( $Points_table ,
        array( 
         'current_points' => $user_points_record->current_points + $order_obj->get_subtotal() * $currency_to_points  ,
         'current_cash' =>  $user_points_record->current_cash +( $order_obj->get_subtotal()  * $currency_to_points ) / $points_settings['groups'][$user_points_record -> level_number]['points_to_currency'],
         'total_points' => $user_points_record->total_points + $order_obj->get_subtotal() * $currency_to_points  ,
         'total_money' => $user_points_record->total_money + $order_obj->get_subtotal() ,
         'user_type' => $next_level_name ,
         'level_number' => $user_points_record->level_number + 1 ,
       ),
     
        array( 'user_id' => $current_user_id )
        
        ) ;
     
      }
     
    }
    else{
      $order_total_with_discount = $order_obj->get_subtotal() +  $order_obj->get_total_fees() ; 
      if($partial_payment == true){
        $wpdb->update( $Points_table ,
        array( 
         'current_points' => $user_points_record->current_points + ( $order_obj->get_subtotal() + $order_obj->get_total_fees() ) * $currency_to_points ,
         'current_cash' =>  $user_points_record->current_cash +(  $order_total_with_discount * $currency_to_points ) / $points_settings['groups'][$user_points_record -> level_number]['points_to_currency'],
         'total_points' =>   $user_points_record->total_points + ( $order_obj->get_subtotal() + $order_obj->get_total_fees() ) * $currency_to_points  ,
         'total_money' => $user_points_record->total_money +( $order_obj->get_subtotal() + $order_obj->get_total_fees() ) ,
       ),
        array( 'user_id' => $current_user_id )
        
        ) ;
      }
      else {
        $wpdb->update( $Points_table ,
        array( 
         'current_points' => $user_points_record->current_points +( $order_obj->get_subtotal()  ) * $currency_to_points  ,
         'current_cash' =>  $user_points_record->current_cash +( $order_obj->get_subtotal()  * $currency_to_points ) / $points_settings['groups'][$user_points_record -> level_number]['points_to_currency'],
         'total_points' =>   $user_points_record->total_points + ( $order_obj->get_subtotal()  ) * $currency_to_points  ,
         'total_money' => $user_points_record->total_money +( $order_obj->get_subtotal()  ) ,
       ),
        array( 'user_id' => $current_user_id )
        
        ) ;
      }
    
   
    }
  
  
  }

}

add_action('woocommerce_order_status_processing', 'MD_redeem_points' );
function MD_redeem_points( $order_id ) {
 

     $order = wc_get_order( $order_id );
    $current_user_id = $order->get_user_id();

    // Check If user Applied Wallet Redeem Or not ? 
    if($current_user_id == 0)
    return ;

    update_post_meta($order_id, 'transaction_type' , 'increase');
    update_post_meta($order_id, 'processed_before' , true);

    
    $full_payment = false;
    $partial_payment = false ;
    // Check if Payment method is Wallet Payment 
    if($order->get_payment_method() == 'wallet_payment' ){
      $full_payment = true;

    }

    if( $order->get_total_fees()  < 0 ){
      $partial_payment = true;
    }
    

    if($full_payment || $partial_payment){
      update_post_meta($order_id , 'transaction_type' , 'decrease');


      $points_settings  = get_field('points_settings' , "options"); 
	    $user_points_info = MD_get_user_points_info($current_user_id);

       $points_to_currency = $points_settings['groups'][$user_points_info -> level_number]['points_to_currency'];

       if($full_payment)
       {
        $number_of_points_used  = $order->get_total() * $points_to_currency ;
        add_post_meta($order->get_id() , 'points_amount' ,$number_of_points_used );
        add_post_meta($order->get_id() , 'redeem_type' , 'full_payment' );
       }
       else {
        $number_of_points_used  = -($order->get_total_fees()) * $points_to_currency ;
        add_post_meta($order->get_id() , 'points_amount' ,$number_of_points_used );
        add_post_meta($order->get_id() , 'redeem_type' , 'partial_payment' );
       }

       $cash_used = $number_of_points_used / $points_to_currency ; 
       

      if($user_points_info -> current_points < $number_of_points_used){
        //if Full Payment -> Wallet Payment to Cash on Delivery 
        // if Partial payment -> remove Discount 
        return ;
      }

      // update User Points and User Points History 
      
    $Points_table = 'wp_mitch_points_system';
    $History_table = 'wp_mitch_points_history';
    $cash_history_table = 'wp_mitch_cash_history';
    global $wpdb;
  
    //Insert User History Record 
  
    $wpdb->insert(
      $History_table, 
      array(
          'user_id' => $current_user_id ,
          'type' => 'Decrease',
          'points_number' => $number_of_points_used ,
          'msg' => 'Redeem Your Points for Order #' . $order_id,
          'points_before' =>  $user_points_info->current_points , 
          'points_after' =>  $user_points_info->current_points - $number_of_points_used ,
      )
    );

    // $wpdb->insert(
    //   $cash_history_table, 
    //   array(
    //       'user_id' => $current_user_id ,
    //       'type' => 'Decrease',
    //       'cash_number' => $cash_used ,
    //       'msg' => 'Redeem Your Cash for Order #' . $order_id,
    //       'cash_before' =>  $user_points_info->current_cash , 
    //       'cash_after' =>  $user_points_info->current_points - $cash_used ,
    //   )
    // );
    
      $wpdb->update( $Points_table ,
      array( 
       'current_points' => $user_points_info->current_points - $number_of_points_used ,
       'current_cash' => $user_points_info->current_cash - $cash_used ,
     ),
      array( 'user_id' => $current_user_id )
      
      ) ;

   }

    
}



// --------------------------------------- On Changing Order Status Scenarios  ----------------------------------
add_action('woocommerce_order_status_changed', 'MD_points_change_order_status', 10, 3);
function MD_points_change_order_status($order_id, $old_status, $new_status){

  global $wpdb ;
  $Points_table = 'wp_mitch_points_system';
  $History_table = 'wp_mitch_points_history';
  
  // Get Order Object 
  $order = wc_get_order( $order_id );
  $current_user_id = $order->get_user_id();

  // Check If User Was Logged in Or Not 
  if($current_user_id == 0)
  return ;

  $points_settings  = get_field('points_settings' , "options"); 
  $user_points_info = MD_get_user_points_info($current_user_id);
  $points_to_currency = $points_settings['groups'][$user_points_info -> level_number]['points_to_currency'];
  $currency_to_points = $points_settings['groups'][$user_points_info->level_number]['currency_to_points'] ;
  //Check if User Applied Full Redeem OR Partial Redeem 
  $full_payment = false;
    $partial_payment = false ;
    // Check if Payment method is Wallet Payment 
    if($order->get_payment_method() == 'wallet_payment' ){
      $full_payment = true;

    }

    if( $order->get_total_fees()  < 0 ){
      $partial_payment = true;
    }
    
    

  // User Side
  if($old_status == 'processing' && ($new_status == 'cancel-request' || $new_status == "cancelled" )){
    // Check if User Applied Full Redeem OR Partial Redeem 
    
    if($partial_payment || $full_payment){

        // Get Number of Used Point to Refund
        if($full_payment){
          $number_of_points_used  = $order->get_total() * $points_to_currency ;
        }
        else {
          $number_of_points_used  = -($order->get_total_fees()) * $points_to_currency ;
        }

        $cash_used = $number_of_points_used / $points_to_currency ; 

        // Insert New Row in User History 
        $wpdb->insert(
          $History_table, 
          array(
              'user_id' => $current_user_id ,
              'type' => 'Increase',
              'points_number' => $number_of_points_used ,
              'msg' => 'Points Refund  - Order Cancelled With Points Redeem #' . $order_id,
              'points_before' =>  $user_points_info->current_points , 
              'points_after' =>  $user_points_info->current_points + $number_of_points_used ,
          )
        );

        // Update User Points 
        $wpdb->update( $Points_table ,
        array( 
        'current_points' => $user_points_info->current_points + $number_of_points_used ,
        'current_cash' => $user_points_info->current_cash + $cash_used ,
      ),
        array( 'user_id' => $current_user_id )
        
        ) ;

    }


  }

  if($old_status == 'completed' && ($new_status == 'return-request')){
    // Points Are Added to the Account And Now we need to Remove 
    if($full_payment == false){

      if($partial_payment == true){

        // Insert Into Points History 
        $wpdb->insert(
          $History_table, 
          array(
              'user_id' => $current_user_id ,
              'type' => 'Decrease',
              'points_number' => ($order->get_subtotal() + $order->get_total_fees() ) * $currency_to_points ,
              'msg' => ' Points Deducted For Return Request  - #' . $order_id  ,
              'points_before' =>  $user_points_info->current_points , 
              'points_after' =>  $user_points_info-> current_points -( $order->get_subtotal() + $order->get_total_fees() ) * $currency_to_points ,
          )
        );
        $order_total_with_discount = $order->get_subtotal() + $order->get_total_fees() ;
        $wpdb->update( $Points_table ,
        array( 
         'current_points' => $user_points_info->current_points - ( $order->get_subtotal() + $order->get_total_fees() ) * $currency_to_points ,
         'current_cash' =>  $user_points_info->current_cash -( $order_total_with_discount  * $currency_to_points ) / $points_settings['groups'][$user_points_info -> level_number]['points_to_currency'],
         'total_points' =>   $user_points_info->total_points - ( $order->get_subtotal() + $order->get_total_fees() ) * $currency_to_points  ,
         'total_money' => $user_points_info->total_money -( $order->get_subtotal() + $order->get_total_fees() ) ,
       ),
        array( 'user_id' => $current_user_id )
        
        ) ;
      }
      else {
  
        $wpdb->insert(
          $History_table, 
          array(
              'user_id' => $current_user_id ,
              'type' => 'Decrease',
              'points_number' => $order->get_subtotal() * $currency_to_points ,
              'msg' => ' Points Deducted For Return Request  - #' . $order_id  ,
              'points_before' =>  $user_points_info->current_points , 
              'points_after' =>  $user_points_info->current_points - $order->get_subtotal() * $currency_to_points ,
          )
        );
        $order_total_with_discount = $order->get_subtotal() + $order->get_total_fees() ; 
        $wpdb->update( $Points_table ,
        array( 
         'current_points' => $user_points_info->current_points - ( $order->get_subtotal() + $order->get_total_fees() ) * $currency_to_points ,
         'current_cash' =>  $user_points_info->current_cash -( $order_total_with_discount * $currency_to_points ) / $points_settings['groups'][$user_points_info -> level_number]['points_to_currency'],
         'total_points' =>   $user_points_info->total_points - ( $order->get_subtotal() + $order->get_total_fees() ) * $currency_to_points  ,
         'total_money' => $user_points_info->total_money -( $order->get_subtotal() + $order->get_total_fees() ) ,
       ),
        array( 'user_id' => $current_user_id )
        
        ) ;
  
      }




    }


  }
  




}


?>