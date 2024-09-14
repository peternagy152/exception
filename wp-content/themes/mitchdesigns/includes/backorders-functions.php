<?php
function mitch_woocommerce_checkout_order_processed($order_id, $posted_data, $order){
    // Initialize
    global $wpdb;

    $check_for_back_orders = false;
    $count_order_items     = count($order->get_items());
    $backorders_items      = array();
    $procordshipitems      = array();
    $backordshipitems      = array();
    // Loop through order items
    foreach($order->get_items() as $item_key => $item){
      // Get product
      $product = $item->get_product();
      // Product is on backorder
      if($product->is_on_backorder()){
        // Will only be executed once if the order contains back orders
        if($check_for_back_orders == false){
          $check_for_back_orders = true;
        }
        if($count_order_items != 1){
          $backorders_items[$item_key] = $item;
        }
      }else{
        $procordshipitems[] = $product->get_name().' &times; '.$item['quantity'];
      }
    }
    // If current order contains backorders, retrieve the necessary data from the existing order and apply it in the new order
    if($check_for_back_orders){
      if($count_order_items == count($backorders_items)){
        $order->update_status('processing');
        $order->update_status('backorder');
        $order->add_order_note('Single Backorder');
      }else{
        // Create new order with backorders
        $backorder_order = wc_create_order();
        foreach($backorders_items as $item_key => $item){
          // Get product
          $product = $item->get_product();
          $backordshipitems[] = $product->get_name().' &times; '.$item['quantity'];
          // Add product to 'backorder' order
          $backorder_order->add_product($product, $item['quantity']);
          // Delete item from original order
          $order->remove_item($item->get_id());
        }
        // Obtain necessary information
        // Get address
        $address = array(
          'first_name' => $order->get_billing_first_name(),
          'last_name'  => $order->get_billing_last_name(),
          'email'      => $order->get_billing_email(),
          'phone'      => $order->get_billing_phone(),
          'address_1'  => $order->get_billing_address_1(),
          'address_2'  => $order->get_billing_address_2(),
          'city'       => $order->get_billing_city(),
          'state'      => $order->get_billing_state(),
          'postcode'   => $order->get_billing_postcode(),
          'country'    => $order->get_billing_country()
        );
        // Get shipping
        $shipping = array(
          'first_name' => $order->get_shipping_first_name(),
          'last_name'  => $order->get_shipping_last_name(),
          'address_1'  => $order->get_shipping_address_1(),
          'address_2'  => $order->get_shipping_address_2(),
          'city'       => $order->get_shipping_city(),
          'state'      => $order->get_shipping_state(),
          'postcode'   => $order->get_shipping_postcode(),
          'country'    => $order->get_shipping_country()
        );
        // Get order currency
        $currency = $order->get_currency();
        // Get order payment method
        $payment_gateway = $order->get_payment_method();
        //Get order shipping method
        // Iterating through order shipping items
        foreach($order->get_items('shipping') as $item_id => $item){
          // Get the data in an unprotected array
          $item_data                  = $item->get_data();
          // $shipping_data_id           = $item_data['id'];
          $shipping_data_name         = $item_data['name'];
          // $shipping_data_method_title = $item_data['method_title'];
          $shipping_data_method_id    = $item_data['method_id'];
          $shipping_data_instance_id  = $item_data['instance_id'];
          $shipping_data_total        = $item_data['total'];
        }
        if(!empty($procordshipitems)){
          mitch_set_shipping_items($order->get_id(), $procordshipitems, 'Items');
        }
        // Required information has been obtained, assign it to the 'backorder' order
        // Set address
        $backorder_order->set_address($address, 'billing');
        $backorder_order->set_address($shipping, 'shipping');
        // Set the correct currency and payment gateway
        $backorder_order->set_currency($currency);
        $backorder_order->set_payment_method($payment_gateway);
        //set shipping method
        $shipping_item = new WC_Order_Item_Shipping();
        $shipping_item->set_method_title($shipping_data_name);
        $shipping_item->set_method_id($shipping_data_method_id);
        $shipping_item->set_instance_id($shipping_data_instance_id);
        $shipping_item->set_total($shipping_data_total);
        $backorder_order->add_item($shipping_item);
        //implode(',',$backordshipitems)
        // Calculate totals
        $backorder_order->calculate_totals();
        if(!empty($backordshipitems) && !empty($shipping_item)){
          mitch_set_shipping_items($backorder_order->get_id(), $backordshipitems, 'instance_id');
        }
        //coupon handling start
        /*if(!empty($order->get_coupon_codes())){ //get_used_coupons
          foreach($order->get_coupon_codes() as $coupon_code){
            $coupon_id = wc_get_coupon_id_by_code($coupon_code);
            if(!empty($coupon_id)){
              if(get_post_meta($coupon_id, 'usage_limit', true) == 1){
                update_post_meta($coupon_id, 'usage_limit', '2');
                update_post_meta($coupon_id, 'coupon_updated_for_backorders', 'yes');
              }
              $backorder_order->apply_coupon($coupon_code);
              if(get_post_meta($coupon_id, 'coupon_updated_for_backorders', true) == 'yes' && get_post_meta($coupon_id, 'usage_limit', true) == 2){
                update_post_meta($coupon_id, 'usage_limit', '1');
              }
              //handle fixed cart coupon Start#
              if(get_post_meta($coupon_id, 'discount_type', true) == 'fixed_cart'){
                $discount_amount = get_post_meta($coupon_id, 'coupon_amount', true);

                if($discount_amount > 0){
                  $processing_order_items = count($order->get_items());
                  $backorder_order_items  = count($backorder_order->get_items());
                  $total_items_count      = $processing_order_items + $backorder_order_items;
                  $discount_per_item      = $discount_amount / $total_items_count;
                  $processing_coupon      = $wpdb->get_row("SELECT order_item_id FROM wp_woocommerce_order_items WHERE order_id = {$order->get_id()} AND order_item_type = 'coupon';");
                  if(!empty($processing_coupon)){
                    $processing_coupon_meta = $wpdb->get_row("SELECT meta_id FROM wp_woocommerce_order_itemmeta WHERE order_item_id = $processing_coupon->order_item_id AND meta_key = 'discount_amount'");
                    if(!empty($processing_coupon_meta)){
                      $proc_new_coupon_amount = $processing_order_items * $discount_per_item;
                      $update_proc = $wpdb->update('wp_woocommerce_order_itemmeta', array('meta_value' => $proc_new_coupon_amount), array('meta_id' => $processing_coupon_meta->meta_id));
                    }
                  }
                  $backorder_coupon       = $wpdb->get_row("SELECT order_item_id FROM wp_woocommerce_order_items WHERE order_id = {$backorder_order->get_id()} AND order_item_type = 'coupon';");
                  if(!empty($backorder_coupon)){
                    $backorder_coupon_meta = $wpdb->get_row("SELECT meta_id FROM wp_woocommerce_order_itemmeta WHERE order_item_id = $backorder_coupon->order_item_id AND meta_key = 'discount_amount'");
                    if(!empty($backorder_coupon_meta)){
                      $back_new_coupon_amount = $backorder_order_items * $discount_per_item;
                      $update_back = $wpdb->update('wp_woocommerce_order_itemmeta', array('meta_value' => $back_new_coupon_amount), array('meta_id' => $backorder_coupon_meta->meta_id));
                    }
                  }
                }
              }
              //handle fixed cart coupon End#
            }
          }
        }
        echo '<pre>';
        var_dump($discount_amount);
        var_dump($processing_order_items);
        var_dump($backorder_order_items);
        var_dump($total_items_count);
        var_dump($discount_per_item);
        var_dump($processing_coupon);
        var_dump($processing_coupon_meta);
        var_dump($proc_new_coupon_amount);
        var_dump($update_proc);
        var_dump($backorder_coupon);
        var_dump($backorder_coupon_meta);
        var_dump($back_new_coupon_amount);
        var_dump($update_back);
        var_dump($wpdb->last_error);
        echo '</pre>';
        exit;*/
        //coupon handling end
        //wallet handling start
        if($payment_gateway == 'wallet'){
          $method_title    = get_post_meta($order->get_id(), '_payment_method_title', true);
          $current_user_id = get_current_user_id();
          //$wallet_balance = woo_wallet()->wallet->get_wallet_balance(get_current_user_id());
          $wallet_balance = (float)get_user_meta($current_user_id, '_current_woo_wallet_balance', true);
          if($wallet_balance >= $backorder_order->get_total() && $backorder_order->get_total() != 0){
            $balance_after = $wallet_balance - $backorder_order->get_total();
            $wpdb->insert('wp_woo_wallet_transactions', array(
              'blog_id' => '1',
              'user_id' => $current_user_id,
              'type'    => 'debit',
              'amount'  => $backorder_order->get_total(),
              'balance' => $balance_after,
              'currency'=> 'EGP',
              'details' => 'For order payment #'.$backorder_order->get_id(),
            ));
            update_user_meta($current_user_id, '_current_woo_wallet_balance', $balance_after);
            // $wallet    = new Woo_Wallet_Wallet();
            // $add_debit = $wallet->debit($current_user_id, $backorder_order->get_total(), "For order payment #{$backorder_order->get_id()}");
            // echo '<pre>';
            // var_dump($add_debit);
            // echo '</pre>';
            // $order->add_order_note(sprintf( __('%s paid through wallet', 'woo-wallet' ), wc_price($backorder_order->get_total(), woo_wallet_wc_price_args($current_user_id))));
        	  update_post_meta($backorder_order->get_id(), '_payment_method', $payment_gateway);
        	  update_post_meta($backorder_order->get_id(), '_payment_method_title', $method_title);
        		update_post_meta($backorder_order->get_id(), '_paid_date', current_time('Y-m-d H:i:s'));
            /*$fee_amount = -1 * $backorder_order->get_total();
            $item_fee   = new WC_Order_Item_Fee();
            $item_fee->set_name("Via wallet");
            $item_fee->set_amount($fee_amount);
            $item_fee->set_tax_class('');
            $item_fee->set_tax_status('none');
            $item_fee->set_total($fee_amount);
            // Add Fee item to the order
            $backorder_order->add_item($item_fee);
            $backorder_order->calculate_totals();
            $backorder_order->save();*/
          }
        }
        //wallet handling end
        // var_dump($add_debit);
        // var_dump($current_user_id);
        // exit;
        // Set order note with original ID
        $backorder_order->add_order_note('Automated Backorder. Created from the original order ID: ' . $order_id);
        update_post_meta($backorder_order->get_id(), 'original_order', $order_id);
        $order->add_order_note('Automated Backorder ID: ' . $backorder_order->get_id());
        update_post_meta($order_id, 'backorder', $backorder_order->get_id());
        update_post_meta($backorder_order->get_id(), '_customer_user', $order->get_customer_id());
        update_post_meta($backorder_order->get_id(), '_created_via', 'auto_created');
        $backorder_order->calculate_totals();
        $backorder_order->save();
        // Optional: give the new 'backorder' order the correct status
        $backorder_order->update_status('backorder');
      }
      // Recalculate and save the orders
      $order->calculate_totals();
      $order->save();
    }
}
add_action('woocommerce_checkout_order_processed', 'mitch_woocommerce_checkout_order_processed', 10, 3);

function mitch_set_shipping_items($order_id, $shipping_items, $get_item_by){
  global $wpdb;
  $ship_order_item_q = $wpdb->get_row("
  SELECT meta_id, wpoi.order_item_id FROM `wp_woocommerce_order_items` AS wpoi
  INNER JOIN wp_woocommerce_order_itemmeta AS wpoim ON wpoi.order_item_id = wpoim.order_item_id
  WHERE order_id = $order_id AND order_item_type = 'shipping' AND meta_key = '$get_item_by';");
  // var_dump($wpdb->last_error);
  // var_dump($ship_order_item_q);
  if(!empty($ship_order_item_q)){
    if($get_item_by == 'Items'){
      $operation = $wpdb->update(
        'wp_woocommerce_order_itemmeta',
        array('meta_value' => implode(',',$shipping_items)),
        array('meta_id' => $ship_order_item_q->meta_id)
      );
    }else{
      $operation = $wpdb->insert(
        'wp_woocommerce_order_itemmeta',
        array(
          'order_item_id' => $ship_order_item_q->order_item_id,
          'meta_key'      => 'Items',
          'meta_value'    => implode(',',$shipping_items)
        ),
      );
    }
  }
}
