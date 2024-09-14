<?php 
// Define a custom class for the payment method
class WC_Wallet_Payment extends WC_Payment_Gateway {
 
  public $domain;
 
    public function __construct() {
      $this->domain = 'wallet_payment';
      // Add settings for the payment method
      $this->id = 'wallet_payment';
      $this->title = 'Wallet Payment';
      $this->method_title = 'Pay By Wallet';
      $this->method_description = 'Full Order Payment With Points ';

      $this->has_fields         = false;
   
      // Add payment method-specific options
      $this->init_form_fields();
      $this->init_settings();

      
      // Define user set variables
      $this->title        = $this->get_option( 'title' );
      $this->description  = $this->get_option( 'description' ); 
      $this->instructions = $this->get_option( 'instructions', $this->description );
      $this->order_status = $this->get_option( 'order_status', 'completed' );

      // Add actions to handle the payment process
      add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
      add_action( 'woocommerce_thankyou_' . $this->id, array( $this, 'thankyou_page' ) );
    }
   
    // Add settings fields for the payment method
    public function init_form_fields() {

      $this->form_fields = array(
          'enabled' => array(
              'title'   => __( 'Enable/Disable', $this->domain ),
              'type'    => 'checkbox',
              'label'   => __( 'Enable Wallet Payment', $this->domain ),
              'default' => 'yes'
          ),
          'title' => array(
              'title'       => __( 'Title', $this->domain ),
              'type'        => 'text',
              'description' => __( 'This controls the title which the user sees during checkout.', $this->domain ),
              'default'     => __( 'Wallet Payment', $this->domain ),
              'desc_tip'    => true,
          ),
          'order_status' => array(
              'title'       => __( 'Order Status', $this->domain ),
              'type'        => 'select',
              'class'       => 'wc-enhanced-select',
              'description' => __( 'Choose whether status you wish after checkout.', $this->domain ),
              'default'     => 'wc-completed',
              'desc_tip'    => true,
              'options'     => wc_get_order_statuses()
          ),
          'description' => array(
              'title'       => __( 'Description', $this->domain ),
              'type'        => 'textarea',
              'description' => __( 'Payment method description that the customer will see on your checkout.', $this->domain ),
              'default'     => __('', $this->domain),
              'desc_tip'    => true,
          ),
      );
    }
   
    // Render the payment method in the checkout form
    public function payment_fields(){

      if ( $description = $this->get_description() ) {
        $msg = 'Pay With Your Wallet [ '; 
        if(is_user_logged_in()){
          global $current_user;
          $points_settings  = get_field('points_settings' , "options"); 
          $user_points_info = MD_get_user_points_info($current_user->ID);
          $user_cash = $user_points_info -> current_points / $points_settings['groups'][$user_points_info -> level_number]['points_to_currency'];

          $msg = $msg .  number_format($user_points_info->current_points) . ' Point = ' . $user_cash . ' EGP ]' ; 
  
        }
        echo $msg ;
      }

      ?>
      <?php
  }

   
    // Process the payment and return the result
      /**
         * Process the payment and return the result.
         *
         * @param int $order_id
         * @return array
         */
    public function process_payment( $order_id ) {
      // Process the payment and return the result
      // This can be a redirect to a payment gateway or a custom result
      $order = wc_get_order( $order_id );

      $status = 'wc-' === substr( $this->order_status, 0, 3 ) ? substr( $this->order_status, 3 ) : $this->order_status;

      // Set order status
      $order->update_status( $status, __( 'Checkout with Wallet Payment. ', $this->domain ) );

      // or call the Payment complete
      // $order->payment_complete();

      // Reduce stock levels
      $order->reduce_order_stock();

      // Remove cart
      WC()->cart->empty_cart();

      // Return thankyou redirect
      return array(
          'result'    => 'success',
          'redirect'  => $this->get_return_url( $order )
      );
    }
   
    // Handle the payment process on the "thank you" page
    public function thankyou_page() {
      if ( $this->instructions )
          echo wpautop( wptexturize( $this->instructions ) );
  }
  }
  
  // Add the Wallet Payment method to WooCommerce
  function add_wallet_payment_method( $methods ) {
    $methods[] = 'WC_Wallet_Payment';
    return $methods;
  }
  add_filter( 'woocommerce_payment_gateways', 'add_wallet_payment_method' );


  // -----------------------------  Add Full Wallet Payments  -------------------------------

  add_filter( 'woocommerce_available_payment_gateways', 'hide_payment_method_based_on_subtotal' );
function hide_payment_method_based_on_subtotal( $available_gateways ) {

  if(is_checkout()){
 // If User Not Logged In Hide It 
 global $woocommerce;
 $total =  $woocommerce->cart->total;

 if(is_user_logged_in()){
   
   //Check if Partial Wallet Redeem is Applied 
   $cart_fees = WC()->cart->get_fees();
   if(!empty($cart_fees) ){
     if($cart_fees['wallet-redeem']){
       //Hide Wallet Payment 
       unset( $available_gateways['wallet_payment'] );
     }
   }
   else{
     
     //Check if he has Enough Points 
     global $current_user;
     $points_settings  = get_field('points_settings' , "options"); 
     $user_points_info = MD_get_user_points_info(get_current_user_id());
     $user_cash = $user_points_info -> current_points / $points_settings['groups'][$user_points_info -> level_number]['points_to_currency'];
     if($user_cash < $total){
       unset( $available_gateways['wallet_payment'] );
     }
     
     
   }
 }
 else {
  unset( $available_gateways['wallet_payment'] );

 }

  }

 
  return $available_gateways;
}


// ------------------------------------------- Partial Wallet Payment ----------------------------- 


add_action( 'woocommerce_cart_calculate_fees', 'woo_add_cart_fee' );
function woo_add_cart_fee( $cart ){
        if ( ! $_POST || ( is_admin() && ! is_ajax() ) ) {
        return;
    }

    if ( isset( $_POST['post_data'] ) ) {
        parse_str( $_POST['post_data'], $post_data );
    } else {
        $post_data = $_POST; // fallback for final checkout (non-ajax)
    }

    if (isset($post_data['add_gift_box'])) {

      // Calculate Discount From Users Points 
      global $current_user;
      $points_settings  = get_field('points_settings' , "options"); 
      $user_points_info = MD_get_user_points_info($current_user->ID);
      $user_cash = $user_points_info -> current_points / $points_settings['groups'][$user_points_info -> level_number]['points_to_currency'];
      WC()->cart->add_fee( 'Wallet Redeem ', -$user_cash );
      

    }

}

// Handling a Test case 

?>

