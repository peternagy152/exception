<?php

function mitch_get_branches(){
  // global $wpdb;
  // return $wpdb->get_results("SELECT ID, post_title, post_excerpt FROM wp_posts WHERE post_type = 'branches' AND post_status = 'publish'");
	global $theme_settings;
  $args = array(
    'tax_query' => array(
      array(
        'taxonomy' => 'branches_languages',
        'field' => 'slug',
        'terms' => array(''.$theme_settings['current_lang'].'-lang')
      )
    ),
    'post_type'     =>'branches',
    'order'         => 'ASC',
    'posts_per_page'=> -1,
  );
  return get_posts($args);
}

function mitch_get_branches_ids($exclude_main = false){
	global $theme_settings;
  $args = array(
    'tax_query' => array(
      array(
        'taxonomy' => 'branches_languages',
        'field' => 'slug',
        'terms' => array(''.$theme_settings['current_lang'].'-lang')
      )
    ),
    'post_type'     =>'branches',
    'order'         => 'ASC',
    'posts_per_page'=> -1,
		'fields'        => 'ids'
  );
	if($exclude_main){
		$args['exclude'] = get_field('main_branch', 'options');
	}
  return get_posts($args);
}
function mitch_get_countries(){
	global $states_cities;
	// $WC_Countries    = new WC_Countries();
	// return $WC_Countries->get_states('EG');
	return $states_cities;
}

function mitch_get_shipping_data(){
	$zones_names      = array();
	$shipping_methods = array();
	$all_zones        = WC_Shipping_Zones::get_zones();
	if(!empty($all_zones)){
		foreach($all_zones as $zone){
			$zones_names[] = $zone['zone_name'];
			if(!empty($zone['shipping_methods'])){
				foreach($zone['shipping_methods'] as $zone_shipping_method){
					$shipping_methods[$zone_shipping_method->id] = array(
						'ins_id' => $zone_shipping_method->instance_id,
						'id'     => $zone_shipping_method->id,
						'title'  => $zone_shipping_method->title,
						'cost'   => $zone_shipping_method->cost,
						'cities' => $zone_shipping_method->cities
					);
				}
			}
		}
	}
	return array(
		'zones_names'      => $zones_names,
		'shipping_methods' => $shipping_methods
	);
}

function mitch_get_available_payment_methods_data(){
	$available_gateways = WC()->payment_gateways->get_available_payment_gateways();
	$enabled_gateways   = [];
	if($available_gateways){
		foreach($available_gateways as $gateway){
			if($gateway->enabled == 'yes'){
				$enabled_gateways[] = array(
					'id'    => $gateway->id,
					'title' => $gateway->title,
					'obj' => $gateway,
				);
			}
		}
	}
	return $enabled_gateways;
}

add_action('wp_ajax_mitch_create_order', 'mitch_create_order');
add_action('wp_ajax_nopriv_mitch_create_order', 'mitch_create_order');
function mitch_create_order(){
	global $fixed_string, $theme_settings;
	$response       = array();
	$post_form_data = $_POST['form_data'];
	parse_str($post_form_data, $form_data);
	$user_email   = sanitize_text_field($form_data['email']);
	$phone_number = sanitize_text_field($form_data['phone']);
	// echo '<pre>';
	// var_dump($form_data);
	// echo '</pre>';
	// exit;
	if(isset($form_data['new_account_check']) && $form_data['new_account_check'] == 'yes'){
	  if(email_exists($user_email)){
	    $response = array('status' => 'error', 'msg' => $fixed_string['alert_profile_setting_exist_email']);
	  }
	  if(empty($response)){
	    $filtered_phone_number = filter_var($phone_number, FILTER_SANITIZE_NUMBER_INT);
	    if(strlen($filtered_phone_number) < 11){
	      $response = array('status' => 'error', 'code' => '401', 'msg' => $fixed_string['alert_profile_set_phone_err']);
	    }
	  }
	  if(empty($response)){
	    if(!empty(mitch_check_phone_number_exist($phone_number))){
	      $response = array('status' => 'error', 'msg' => $fixed_string['alert_profile_setting_exist_phone']);
	    }
	  }
		if(empty($response)){
			$user_password    = esc_attr($form_data['new_password']);
	    $confirm_password = esc_attr($form_data['confirm_password']);
			if(!empty($user_password) && !empty($confirm_password)){
				$pass_number       = preg_match('@[0-9]@', $user_password);
	      $pass_uppercase    = preg_match('@[A-Z]@', $user_password);
	      $pass_lowercase    = preg_match('@[a-z]@', $user_password);
	      $pass_specialChars = preg_match('@[^\w]@', $user_password);
	      if(strlen($user_password) < 8 || !$pass_number || !$pass_uppercase || !$pass_lowercase || !$pass_specialChars) {
	        $response = array('status' => 'error', 'code' => '401', 'msg' => $fixed_string['alert_profile_set_pass_validate']);
	      }else{
	        if($user_password != $confirm_password){
	          $response = array('status' => 'error', 'msg' => $fixed_string['alert_profile_set_pass_not_match2']);
	        }
	      }
			}else{
				$response = array('status' => 'error', 'msg' => $fixed_string['alert_profile_set_password_empty']);
			}
		}
		if(empty($response)){
			$result = wp_create_user($user_email, $user_password, $user_email);
	    if(is_wp_error($result)){
	      $response = array('status' => 'error', 'msg' => $result->get_error_message());
	    }else{
				$user = get_user_by('id', $result);
	      // Add role
	      // Remove role
	      $user->remove_role('subscriber');
	      $user->remove_role('shop_manager');
	      $user->remove_role('administrator');
	      $user->add_role('customer');
	      update_user_meta($user->ID, 'first_name', sanitize_text_field($form_data['firstname']));
	      update_user_meta($user->ID, 'last_name', sanitize_text_field($form_data['lastname']));
	      update_user_meta($user->ID, 'phone_number', $phone_number);
	      wp_set_current_user($user->ID);
	      wp_set_auth_cookie($user->ID);
				if(empty(mitch_get_user_main_address($user->ID))){
					$operation = mitch_add_user_address(array(
			      'country'      => sanitize_text_field($form_data['country']),
			      'city'         => sanitize_text_field($form_data['city']),
			      'building'     => sanitize_text_field($form_data['building']),
			      'street'       => sanitize_text_field($form_data['street']),
			      'area'         => sanitize_text_field($form_data['area']),
						'address_type' => 0,
			      'user_id'      => $user->ID,
			    ));
				}
				$current_user_id = $user->ID;
			}
		}
	}else{
		$current_user_id = get_current_user_id();
	}
	if(empty($response)){
		$order_data = array(
		 'status'      => apply_filters('woocommerce_default_order_status', 'processing'),
		 'customer_id' => $current_user_id
	  );
	  $new_order = wc_create_order($order_data);
		$new_order->set_currency($theme_settings['curren_currency_ar']);
		//set Line items
		global $wpdb;
	  foreach(WC()->cart->get_cart() as $cart_item_key => $values){
			// $values['data']->set_price(mitch_get_product_price_after_rate($values['data']->price));
			mitch_update_product_total_sales($values['product_id'], $values['quantity']);
		  	$product = wc_get_product( isset($values['variation_id']) && $values['variation_id'] > 0 ? $values['variation_id'] : $values['product_id'] );
			$product->set_price($product->get_price());
			// $product->set_price(mitch_get_product_price_after_rate($product->get_price()));
		  $item_id = $new_order->add_product($product, $values['quantity']);
		  $item    = $new_order->get_item($item_id, false);
			if(!empty($values['custom_cart_data'])){
				$items_data = $values['custom_cart_data'];
				if(!empty($items_data['visit_type'])){
					update_post_meta($new_order->get_id(), 'order_visit_type', $items_data['visit_type']);
				}
				if(!empty($items_data['visit_branch'])){
					update_post_meta($new_order->get_id(), 'order_visit_branch', $items_data['visit_branch']);
				}
				if(!empty($items_data['visit_home'])){
					update_post_meta($new_order->get_id(), 'order_visit_home', $items_data['visit_home']);
				}
				$item->update_meta_data('custom_cart_data', $items_data);
				$item->set_subtotal($items_data['custom_total']);
	    		$item->set_total($items_data['custom_total']);
				if(!empty($items_data['attributes_keys'])){
					$i = 0;
					foreach($items_data['attributes_keys'] as $meta_attr_key){
						// var_dump($meta_attr_key); var_dump(); echo '<br>';
						$attr_value = $items_data['attributes_vals'][$i];
						$wpdb->query("UPDATE wp_woocommerce_order_itemmeta SET meta_value = '$attr_value' WHERE order_item_id = $item_id AND meta_key = '$meta_attr_key'");
						$i++;
					}
				}
				// echo '<pre>';
				// var_dump($values['custom_cart_data']);
				// echo '</pre>';
			}else{
				// $item->set_subtotal(mitch_get_product_price_after_rate($values['data']->price));
			}
		  $item->save();
	  }
		$coupon_code = sanitize_title($form_data['coupon_code']);
		$coupon_id   = wc_get_coupon_id_by_code($coupon_code);
		if(!empty($coupon_id)){
			$new_order->apply_coupon($coupon_code);
			update_post_meta($new_order->get_id(), 'order_applied_coupon', $coupon_code);
		}
		$new_order->calculate_totals();
	  // Coupon items
	  // if( isset($data['coupon_items'])){
	  //     foreach( $data['coupon_items'] as $coupon_item ) {
	  //         $order->apply_coupon(sanitize_title($coupon_item['code']));
	  //     }
	  // }
		$address = array(
		  'first_name' => sanitize_text_field($form_data['firstname']),
		  'last_name'  => sanitize_text_field($form_data['lastname']),
		  'company'    => '',
		  'email'      => $user_email,
		  'phone'      => $phone_number,
		  'address_1'  => sanitize_text_field($form_data['building']).', '.sanitize_text_field($form_data['street']).', '.sanitize_text_field($form_data['area']),
		  'address_2'  => '',
		  'city'       => sanitize_text_field($form_data['city']),
		  'postcode'   => '',
		  'country'    => sanitize_text_field($form_data['country']),
		  'building'   => sanitize_text_field($form_data['building']),
		  'street'     => sanitize_text_field($form_data['street']),
		  'area'       => sanitize_text_field($form_data['area'])
		);
	  $new_order->set_address($address, 'billing');
	  $new_order->set_address($address, 'shipping');
		//set shipping
		$selected_shipping_method = mitch_get_shipping_data()['shipping_methods'][explode(':', $form_data['shipping_method'][0])[0]];
		$shipping_item = new WC_Order_Item_Shipping();
	  $shipping_item->set_method_title($selected_shipping_method['title']);
	  $shipping_item->set_method_id($selected_shipping_method['id']); // set an existing Shipping method rate ID // was flat_rate:12
	  $shipping_item->set_instance_id($selected_shipping_method['ins_id']); // set an existing Shipping method rate ID // was flat_rate:12
	  $shipping_item->set_total((float)$selected_shipping_method['cost']); // (optional)
	  $new_order->add_item($shipping_item);
		//set payment
		$new_order->set_payment_method(WC()->payment_gateways->payment_gateways()[$form_data['payment_method'][0]]);
		//set notes
		if(!empty($form_data['notes'])){
			$new_order->add_order_note(sanitize_text_field($form_data['notes']));
			update_post_meta($new_order->get_id(), 'customer_notes', sanitize_text_field($form_data['notes']));
		}
		$new_order->calculate_totals();
		if(!empty($current_user_id)){
			if(empty(get_user_meta($current_user_id, 'phone_number', true))){
				update_user_meta($current_user_id, 'phone_number', sanitize_text_field($form_data['phone']));
			}
			if(empty(get_user_meta($current_user_id, 'first_name', true))){
				update_user_meta($current_user_id, 'first_name', sanitize_text_field($form_data['firstname']));
			}
			if(empty(get_user_meta($current_user_id, 'last_name', true))){
				update_user_meta($current_user_id, 'last_name', sanitize_text_field($form_data['lastname']));
			}
			update_post_meta($new_order->get_id(), '_customer_user', $current_user_id);
		}
		update_post_meta($new_order->get_id(), 'order_processing_date', $new_order->get_date_created()->date("F j, Y"));
		// echo '<pre>';
		// var_dump($product->get_price());
		// echo '</pre>';
		// exit;
		WC()->cart->empty_cart();
		if(!empty($new_order->get_id())){
			$response = array('status'   => 'success', 'order_id' => $new_order->get_id(), 'redirect_to' => home_url('thankyou/?order_id='.$new_order->get_id().''));
		}
	}
	echo json_encode($response);
	wp_die();
}
function mitch_create_order_from($order_id){
	if(!empty($order_id)){
    $r_order_obj     = wc_get_order($order_id);
    $order_data      = array(
		 'status'        => apply_filters('woocommerce_default_order_status', 'processing'),
		 'customer_id'   => get_current_user_id()
	  );
	  $new_order = wc_create_order($order_data);
		//set Line items
		global $wpdb;
	  foreach($r_order_obj->get_items() as $cart_item_key => $values){
			mitch_update_product_total_sales($values['product_id'], $values['quantity']);
		  $product = wc_get_product( isset($values['variation_id']) && $values['variation_id'] > 0 ? $values['variation_id'] : $values['product_id'] );
		  $item_id = $new_order->add_product($product, $values['quantity']);
		  $item    = $new_order->get_item($item_id, false);
			if(!empty($values['custom_cart_data'])){
				$items_data = $values['custom_cart_data'];
				if(!empty($items_data['visit_type'])){
					update_post_meta($new_order->get_id(), 'order_visit_type', $items_data['visit_type']);
				}
				if(!empty($items_data['visit_branch'])){
					update_post_meta($new_order->get_id(), 'order_visit_branch', $items_data['visit_branch']);
				}
				if(!empty($items_data['visit_home'])){
					update_post_meta($new_order->get_id(), 'order_visit_home', $items_data['visit_home']);
				}
				$item->update_meta_data('custom_cart_data', $items_data);
				$item->set_subtotal($items_data['custom_total']);
	    	$item->set_total($items_data['custom_total']);
				if(!empty($items_data['attributes_keys'])){
					$i = 0;
					foreach($items_data['attributes_keys'] as $meta_attr_key){
						// var_dump($meta_attr_key); var_dump(); echo '<br>';
						$attr_value = $items_data['attributes_vals'][$i];
						$wpdb->query("UPDATE wp_woocommerce_order_itemmeta SET meta_value = '$attr_value' WHERE order_item_id = $item_id AND meta_key = '$meta_attr_key'");
						$i++;
					}
				}
				// echo '<pre>';
				// var_dump($values['custom_cart_data']);
				// echo '</pre>';
			}
		  $item->save();
	  }
		$new_order->calculate_totals();
    //set address details
    $address = array(
			'first_name' => $r_order_obj->get_billing_first_name(),
		  'last_name'  => $r_order_obj->get_billing_last_name(),
		  'company'    => '',
		  'email'      => $r_order_obj->get_billing_email(),
		  'phone'      => $r_order_obj->get_billing_phone(),
		  'address_1'  => $r_order_obj->get_billing_address_1(),
		  'address_2'  => '',
		  'city'       => $r_order_obj->get_billing_city(),
		  'postcode'   => '',
		  'country'    => $r_order_obj->get_billing_country(),
			'building'   => get_post_meta($order_id, '_billing_building', true),
			'street'     => get_post_meta($order_id, '_billing_street', true),
			'area'       => get_post_meta($order_id, '_billing_area', true)
		);
	  $new_order->set_address($address, 'billing');
	  $new_order->set_address($address, 'shipping');
		//set shipping
    $shipping_methods = mitch_get_shipping_data()['shipping_methods'];
    $shipping_item    = new WC_Order_Item_Shipping();
    if(!empty($shipping_methods)){
      foreach($shipping_methods as $shipping_method){
        if($shipping_method['title'] == $r_order_obj->get_shipping_method()){
          $shipping_item->set_method_title($shipping_method['title']);
      	  $shipping_item->set_method_id($shipping_method['id']); // set an existing Shipping method rate ID // was flat_rate:12
      	  $shipping_item->set_instance_id($shipping_method['ins_id']); // set an existing Shipping method rate ID // was flat_rate:12
      	  $shipping_item->set_total((float)$shipping_method['cost']); // (optional)
      	  $new_order->add_item($shipping_item);
          break;
        }
      }
    }
		//set payment
    if(!empty($r_order_obj->get_payment_method())){
      $new_order->set_payment_method(WC()->payment_gateways->payment_gateways()[$r_order_obj->get_payment_method()]);
    }
		//set notes
    $old_customer_notes = sanitize_text_field(get_post_meta($order_id, 'customer_notes', true));
		if(!empty($old_customer_notes)){
			$new_order->add_order_note($old_customer_notes);
			update_post_meta($new_order->get_id(), 'customer_notes', $old_customer_notes);
		}
		$new_order->calculate_totals();
		update_post_meta($new_order->get_id(), 'order_processing_date', $new_order->get_date_created()->date("F j, Y"));
		update_post_meta($new_order->get_id(), 'auto_created_from', $order_id);
		return $new_order->get_id();
  }
	return;
}

global $states, $states_cities;
//$states_cities = get_field('states_cities','option');
$cities_data = get_field('states_cities','option');

if(have_rows('states_cities','option')){

	while(have_rows('states_cities','option')){
		the_row();
		$states['en'][get_sub_field('state_ar','option')] = get_sub_field('state_ar','option');
		$state = get_sub_field('state_en','option');
	}
}

// echo '<pre>';
// var_dump($states_cities);
// echo '</pre>';


add_filter('woocommerce_states', 'custom_woocommerce_states');
function custom_woocommerce_states($states){
	global $language, $states, $states_cities, $theme_settings;
	$test = array('ABC' , 'XYZ');
	return $test;
}

add_filter('default_checkout_billing_country', 'change_default_checkout_country');
function change_default_checkout_country() {
  return 'EG'; // country code
}

add_filter('woocommerce_checkout_fields' , 'custom_override_checkout_fields');
function custom_override_checkout_fields($fields){
	global $language,  $theme_settings;

	WC()->customer->set_billing_country('EG');
	global $current_user;
	wp_get_current_user();
	unset($fields['shipping']['shipping_first_name']);
	unset($fields['shipping']['shipping_last_name']);
	unset($fields['shipping']['shipping_phone']);
	unset($fields['shipping']['shipping_email']);
	unset($fields['shipping']['shipping_company']);
	unset($fields['shipping']['shipping_postcode']);
	unset($fields['shipping']['shipping_city']);
	unset($fields['shipping']['shipping_country']);
	unset($fields['shipping']['shipping_state']);
	unset($fields['shipping']['shipping_address_1']);
	unset($fields['shipping']['shipping_address_2']);
	unset($fields['shipping']['shipping_address_name']);
	unset($fields['billing']['billing_company']);
	unset($fields['billing']['billing_postcode']);
	unset($fields['billing']['billing_country']);
	unset($fields['shipping']['shipping_address_1']);
	unset($fields['shipping']['shipping_address_2']);
	//$fields['billing']['billing_phone']['default']= get_user_meta($current_user->ID, 'phone_number', true)
	// Adding new notes field
  $fields['billing']['billing_notes'] = array(
		'label' => _x('Message', 'label', 'woocommerce'),
		'required' => false,
		'type' => 'textarea',
		'priority'=> 50,
		'placeholder'=> '',
		'class'=> array('form-full-row')
	);
	/* dropdown area input in checkout page */
	$city_args = wp_parse_args(array(
		'type'        => 'select',
		'options'     => MD_Get_lang_govs($language),
		'input_class' => array('wc-enhanced-select')
	),$fields['billing']['billing_state']);

	$fields['account']['account_password']['placeholder'] = '';
	$fields['billing']['billing_state']          = $city_args; // Also change for billing field
	$fields['billing']['billing_state']['class'] = array('update_totals_on_change');
	$fields['billing']['billing_city']['class']  = array('update_totals_on_change', 'select2');
	$fields['billing']['billing_street']['class']  = array('update_totals_on_change', 'select3');
	$fields['billing']['billing_area']['class']  = array('update_totals_on_change');
	$fields['billing']['billing_city']['required']         = true;
	$fields['billing']['billing_steet']['required']         = true;
	$fields['billing']['billing_area']['required']         = true;
	$fields['billing']['billing_address_1']['placeholder'] = '';
	$fields['billing']['billing_phone']['type']            = 'number';
	if($language == 'en'|| (isset($_POST['lang']) && $_POST['lang'] == 'en')){
		$fields['billing']['billing_phone']['label']      = " Phone Number";
		$fields['billing']['billing_first_name']['label'] = "First Name";
		$fields['billing']['billing_last_name']['label']  = " Last Name ";
		$fields['billing']['billing_email']['label']      = " Email Address";
		$fields['billing']['billing_city']['label']       = "District";
		$fields['billing']['billing_street']['label']       = "Area";
		$fields['billing']['billing_state']['label']      = "City";
		$fields['billing']['billing_area']['label']       = "Area";
		$fields['billing']['billing_address_1']['label']  = " Street info And Full Address ";
		$fields['billing']['billing_building_2']['label'] = "Apartment";
		$fields['billing']['billing_building']['label']   = "Floor";
		$fields['account']['account_password']['label']   = 'Password';
		$fields['billing']['billing_comments']['label']   = "Note";
		$fields['billing']['billing_building_2'] = array(
			'label'    => _x('Apartment ', 'label', 'woocommerce'),
			'class'	   => array('same-row require-build'),
			'required' => true,
			'type'     => 'text',
			'priority' => 40,
		);
		$fields['billing']['billing_building'] = array(
			'label'    => _x('Floor  ', 'label', 'woocommerce'),
			'class'	   => array('same-row require-build'),
			'required' => true,
			'type'     => 'text',
			'priority' => 40
		);
		$all_branches = get_all_branches(); 
		$fields['billing']['billing_local_pickup'] = array(
			'label'    => _x('اختر الفرع', 'label', 'woocommerce'),
			'class'	   => array('same-row require-build'),
			'type'     => 'text',
			'priority' => 40 ,
			'default' => $all_branches[0]->branch_name_ar ,
			'custom_attributes' => array(
				'style' => 'display: none;'
			),
		);
		$fields['billing']['billing_delivery_date']['label']   = "Delivery Date";
		$fields['billing']['billing_delivery_date'] = array(
			'label'    => _x('Delivery Date  ', 'label', 'woocommerce'),
			'class'	   => array('same-row require-build'),
			'type'     => 'text',
			'priority' => 40 ,
			'default'  => "today" ,
		);
	}else{
		$fields['billing']['billing_phone']['label']           = "رقم الهاتف";
		$fields['billing']['billing_first_name']['label']      = "الاسم الاول";
		$fields['billing']['billing_last_name']['label']       = "الاسم الاخير";
		$fields['billing']['billing_email']['label']           = "البريد الالكتروني";
		$fields['billing']['billing_city']['label']            = "المنطقة";
		$fields['billing']['billing_street']['label']      	   = "لحى";
		$fields['billing']['billing_state']['label']           = "المدينة";
		$fields['billing']['billing_area']['label']            = "الحي";
		$fields['billing']['billing_address_1']['label']       = "رقم العقار و الشارع";
		$fields['billing']['billing_building_2']['label']      = "الشقة";
		$fields['billing']['billing_building']['label']        = "الطابق";
		$fields['account']['account_password']['label']        = 'Password';
		$fields['billing']['billing_comments']['label']        = "Notes";
		$fields['billing']['billing_building_2'] = array(
			'label'    => _x('الشقة', 'label', 'woocommerce'),
			'class'	   => array('same-row require-build'),
			'required' => true,
			'type'     => 'text',
			'priority' => 40,
		);
		$fields['billing']['billing_building'] = array(
			'label'    => _x('الطابق', 'label', 'woocommerce'),
			'class'	   => array('same-row require-build'),
			'required' => true,
			'type'     => 'text',
			'priority' => 40,
		);
		$fields['billing']['billing_building']['type'] = 'text';
		$fields['account']['account_password']['type'] = 'password';
		$fields['billing']['billing_local_pickup']['label']   = "اختر الفرع ";
		$all_branches = get_all_branches(); 
		$fields['billing']['billing_local_pickup'] = array(
			'label'    => _x('اختر الفرع', 'label', 'woocommerce'),
			'class'	   => array('same-row require-build'),
			'type'     => 'text',
			'priority' => 40 ,
			'default' => $all_branches[0]->branch_name_ar ,
			'custom_attributes' => array(
				'style' => 'display: none;'
			),
		);
		$fields['billing']['billing_delivery_date']['label']   = "Delivery Date";
		$fields['billing']['billing_delivery_date'] = array(
			'label'    => _x('Delivery Date  ', 'label', 'woocommerce'),
			'class'	   => array('same-row require-build'),
			'type'     => 'text',
			'priority' => 40 ,
			'default'  => "today" ,
		);
	}
	if(is_user_logged_in()) {
		global $current_user; wp_get_current_user();
		$fields['billing']['billing_first_name']['default'] = $current_user->user_firstname;
		$fields['billing']['billing_last_name']['default']  = $current_user->user_lastname;
		$fields['billing']['billing_phone']['default']      = "01234569" ;//get_user_meta($current_user->ID, 'phone_number', true) ;
		$fields['billing']['billing_email']['default']      = $current_user->user_email;
		if(!empty($current_user->user_email)){
			$fields['billing']['billing_email']['class'] = array('form-row-wide','hide-fld');
		}
		// if(!empty($current_user->phone)){
		// 	$fields['billing']['billing_phone']['class'] = array('form-row-wide','hide-fld');
		// }
		if(!empty($current_user->user_firstname)){
			$fields['billing']['billing_first_name']['class'] = array('form-row-first','hide-fld');
		}
		if(!empty($current_user->user_lastname)){
			$fields['billing']['billing_last_name']['class']= array('form-row-last','hide-fld');
		}
	}
	return $fields;
}





remove_action("woocommerce_checkout_order_review","woocommerce_checkout_payment",20);
add_action( 'woocommerce_checkout_shipping', 'woocommerce_checkout_payment', 20 );


add_action( 'woocommerce_after_checkout_validation', 'misha_one_err', 9999, 2);

function misha_one_err( $fields, $errors ){
	global $theme_settings;

	$language = $_POST['language'] ;
	// if any validation errors
	if( !empty( $errors->get_error_codes() ) ) {

		// remove all of them
		foreach( $errors->get_error_codes() as $code ) {
			$errors->remove( $code );
		}
	}
	// if(!$fields[ 'terms' ]){
	// 	if ($language !="en"){
	// 		$errors->add( 'validation', 'من فضلك أقرأ الشروط والأحكام وقم بقبولها لأستكمال الطلب بنجاح');
	// 	}
	// 	else{
	// 		$errors->add( 'validation', 'Please read and accept the terms and conditions to proceed with your order.' );
	// 	}
	// }
	if(empty($fields['billing_first_name'])){
		if($language == "en"){
			$errors->add('validation', 'Billing First name is a required field.');
		}else{
			$errors->add('validation', 'من فضلك أدخل الأسم الأول');
		}
	}
	if(empty($fields['billing_last_name'])){
		if($language =="en"){
			$errors->add('validation', 'Billing Last name is a required field.');
			
		}else{
			$errors->add('validation','من فضلك أدخل أسم العائله');
		}
	}
	if(empty($fields['billing_phone'])){
		if($language =="en"){
			$errors->add('validation', 'Please enter the phone number');
		}else{
			$errors->add('validation', ' الرجاء إدخال رقم الهاتف');
		}
	}
	if(empty($fields[ 'billing_email' ])){
		if($language !="en"){
			$errors->add('validation', 'من فضلك أدخل البريد الألكتروني');
		}else{
			$errors->add('validation', 'Billing Email address is a required field.');
		}
	}

	//check local pickup 
	if($_POST['shipping_option'] == 'delivery'){
		if(empty($fields[ 'billing_state' ])){
			if($language !="en"){
				$errors->add( 'validation', 'من فضلك أدخل المدينة' );
			}else{
				$errors->add( 'validation', 'Billing City is a required field.' );
			}
		}
		if(empty($fields[ 'billing_city' ])){
			if($language !="en"){
				$errors->add( 'validation', 'من فضلك أدخل المنطقة' );
			}else{
				$errors->add( 'validation', 'Billing District is a required field.' );
			}
		}
		if(empty($fields[ 'billing_street' ])){
			if($language !="en"){
				$errors->add( 'validation', 'من فضلك أدخل الحي' );
			}else{
				$errors->add( 'validation', 'Billing Area is a required field.' );
			}
		}
	
		if(empty($fields[ 'billing_address_1' ])){
			if($language != "en"){
				$errors->add( 'validation', 'من فضلك أدخل المنطقة' );
			}else{
				$errors->add( 'validation', 'Please Enter our District' );
			}
		}
		if(empty($fields['billing_building'])){ //$fields[ 'property_type' ] == 'apart' &&
			if($language != "en"){
				$errors->add( 'validation', 'من فضلك أدخل الدور' );
			}else{
				$errors->add( 'validation', 'Please enter the floor number' );
			}
		}
		if(empty($fields[ 'billing_building_2' ])){ //$fields[ 'property_type' ] == 'apart' &&
			if($language != "en"){
				$errors->add( 'validation', 'من فضلك أدخل رقم العقار' );
			}else{
				$errors->add( 'validation', 'Please enter the property number' );
			}
		}
	}


	// Check if Products is Avaliable In Stock
    global $wpdb ;
    if($_POST['shipping_option'] == 'delivery'){
        $street_info= MD_Get_street_rate_by_name_ar($fields['billing_city']);
        $branch_id = $street_info -> branch_id;
    }else{
        $branch_name_ar = $fields['billing_local_pickup'] ;
        $selected_branch = $wpdb->get_row("Select * from pwa_branches where branch_name_ar = '$branch_name_ar' ;") ;
        $branch_id = $selected_branch->branch_id ;
    }

	if (!empty($fields['billing_local_pickup']) || !empty($fields['billing_city'])) {
		foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
			$product = wc_get_product($cart_item['product_id']);
			$Excluded_branches = get_post_meta($product->get_id(), '_branches', true);
			$Excluded = false ;
			 if(!empty($Excluded_branches)){ 
			  if(in_array($branch_id , $Excluded_branches)){
				$Excluded = true;
		
			  }
		  }
			if($Excluded){
				if ($language == "ar") {
					$arabic_name = get_post_meta($product->get_id() , 'product_data_arabic_title')[0];
					$errors->add('validation', 'هذا المنتج ' . $arabic_name . ' غير متوفر في الفرع');
				} else {
					$errors->add('validation', 'This Product ' . $product->name . ' Not available at the branch');
				}
			}
		}
	}



	
}

add_filter( 'woocommerce_cart_shipping_method_full_label', 'bbloomer_remove_shipping_label', 9999, 2 );

function bbloomer_remove_shipping_label( $label, $method ) {
    $new_label = preg_replace( '/^.+:/', '', $label );
    return $new_label;
}



function mitch_check_user_exist_by_email($user_email){
  global $wpdb;
  return $wpdb->get_row("SELECT ID FROM `wp_users` WHERE user_email = '$user_email';");
}

function mitch_check_user_birthday_exit($user_email){
  global $wpdb;
  return $wpdb->get_row("SELECT ID FROM `wp_users_birthdays` WHERE user_email = '$user_email';");
}


add_action('woocommerce_checkout_create_order', 'mitch_before_checkout_create_order', 20, 2);
function mitch_before_checkout_create_order($order){

	// Add Branch Name in Order 
	$street_info= MD_Get_street_rate_by_name_ar($_POST['billing_city']);
	$branch_id = $street_info -> branch_id;

	//Get Branch Name 
	$branch_data = get_branch_data_by_id($branch_id);
	$order->update_meta_data('_order_from_branch', $branch_data-> branch_name_ar );

	$order->update_meta_data('_selected_language', $_POST['language'] );

}
function display_billing_street_in_admin_order( $order ) {
	echo "-------------------- ORDER DETAILS -------------------";
	if(empty( $order->get_billing_city())){
		echo '<p><strong>استلام من  الفرع   :</strong> ' . $order->get_meta('_billing_local_pickup') . '</p>';
		if($order->get_meta('_billing_delivery_date') == 'today'){
			echo '<p><strong>تاريخ التسليم   : </strong> اليوم</p>';
		}else{
			echo '<p><strong>تاريخ التسليم   :</strong> ' . $order->get_meta('_billing_delivery_date') . '</p>';
		}
		

	}else{
		
		if($order->get_meta('_billing_delivery_date') == 'today'){
			echo '<p><strong>تاريخ التسليم   : </strong> اليوم</p>';
		}else{
			echo '<p><strong>تاريخ التسليم   :</strong> ' . $order->get_meta('_billing_delivery_date') . '</p>';
		}
		echo '<p><strong> المدينة : </strong> ' . $order->get_billing_state() . '</p>';
		echo '<p><strong>الحي :</strong> ' . $order->get_meta('_billing_street') . '</p>';
		echo '<p><strong>المنطقة :</strong> ' . $order->get_billing_city() . '</p>';
		echo '<p><strong>رقم العقار والشارع  :</strong> ' . $order->get_billing_address_1() . '</p>';
		echo '<p><strong>الطابق  :</strong> ' . $order->get_meta('_billing_building') . '</p>';
		echo '<p><strong>الشقة :</strong> ' . $order->get_meta('_billing_building_2') . '</p>'; 
		echo '<p><strong>الفرع :</strong> ' . $order->get_meta('_order_from_branch') . '</p>';  
		
	}
   
}
add_action( 'woocommerce_admin_order_data_after_billing_address', 'display_billing_street_in_admin_order', 10, 1 );
