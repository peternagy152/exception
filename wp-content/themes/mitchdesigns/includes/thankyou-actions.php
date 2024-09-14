<?php
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  global $wp;
	$error_query   = '';
  $redirect_url  = home_url($wp->request);
  if(isset($_GET['key'])){
    $key          = sanitize_text_field($_GET['key']);
    $redirect_url = $redirect_url.'?key='.$key.'&';
  }
	//$redirect_url  = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
  //$redirect_url  = sanitize_text_field($_POST['_wp_http_referer']);
	$mitch_action  = sanitize_text_field($_POST['mitch_action']);
	if($mitch_action == 'create_account'){
		$create_account_nonce = sanitize_text_field($_POST['create_account_nonce']);
		if(wp_verify_nonce($create_account_nonce, 'mitch_create_account_nonce')){
			$user_email    = $order->get_billing_email();
			$user_phone    = $order->get_billing_phone();
			$user_password = sanitize_text_field($_POST['password']);
			if(email_exists($user_email)){
				$error_query = 'already_email_exist';
		  }
			if(empty($error_query)){
				if(!empty(mitch_check_phone_number_exist($user_phone))){
					$error_query = 'already_phone_exist';
		    }
			}
			if(empty($error_query)){
				$result = wp_create_user($user_email, $user_password, $user_email);
				// echo '<pre>';
				// var_dump($result);
				// echo '</pre>';
				// exit;
				if($result){
					$user = get_user_by('id', $result);
          // Remove role
  	      $user->remove_role('subscriber');
  	      $user->remove_role('shop_manager');
  	      $user->remove_role('administrator');
					$user->add_role('customer');
		      update_user_meta($user->ID, 'first_name', $order->get_billing_first_name());
		      update_user_meta($user->ID, 'last_name', $order->get_billing_last_name());
		      update_user_meta($user->ID, 'phone_number', $user_phone);
		      wp_set_current_user($user->ID);
		      wp_set_auth_cookie($user->ID);
					wp_redirect($redirect_url.'response=create_user_success');
          exit;
				}else{
					wp_redirect($redirect_url.'response=create_user_error');
          exit;
				}
			}
    	//echo 'YesVerified';
	  }else{
	  	//echo 'NotVerified';
			$error_query = 'not_verified';
	  }
	}elseif($mitch_action == 'add_birthday'){
		$add_birthday_nonce = sanitize_text_field($_POST['add_birthday_nonce']);
		if(wp_verify_nonce($add_birthday_nonce, 'mitch_add_birthday_nonce')){
			global $wpdb;
      $user_birthday = sanitize_text_field($_POST['user_birthday']);
      $user_name     = $order->get_billing_first_name().' '.$order->get_billing_last_name();
			$data_arr      = array(
				'user_email'    => $order->get_billing_email(),
				'user_birthday' => $user_birthday,
				'created_at'    => current_time('Y-m-d h:i a')
			);
      update_user_meta(get_current_user_id(), 'user_birthday', $user_birthday);
			$insert_data = $wpdb->insert('wp_users_birthdays', $data_arr);
      mitch_campaign_monitor_add_subscriber_birthday($user_name, $order->get_billing_email(), $user_birthday);
			if($insert_data){
				wp_redirect($redirect_url.'response=add_birthday_success');
        exit;
			}else{
				wp_redirect($redirect_url.'response=add_birthday_error');
        exit;
			}
		}else{
			$error_query = 'not_verified';
		}
	}
  // var_dump($redirect_url);
  // exit;
	if(!empty($error_query)){
		wp_redirect($redirect_url.'response='.$error_query);
	}else{
		wp_redirect($redirect_url.'response=create_user_error');
	}
	exit;
}
if(isset($_GET['response'])){
	if($_GET['response'] == 'already_phone_exist'){
		?>
		<div class="alert alert-danger">
			Sorry, There's An Issue On Phone Number!
			<a style="background: #121212;color: white;padding: 10px;" class="login js-popup-opener" href="#popup-login">Login</a>
		</div>
		<?php
	}elseif($_GET['response'] == 'already_email_exist'){
		?>
		<div class="alert alert-danger">
			Sorry, There's An Issue On Email!
			<a style="background: #121212;color: white;padding: 10px;" class="login js-popup-opener" href="#popup-login">Login</a>
		</div>
		<?php
	}elseif($_GET['response'] == 'create_user_success'){
		?>
		<div class="alert alert-success">
			Registeration Done Successfully.
		</div>
		<?php
	}elseif($_GET['response'] == 'add_birthday_success'){
		?>
		<div class="alert alert-success">
			Birthday Added Successfully.
		</div>
		<?php
	}else{
		?>
		<div class="alert alert-danger">
			Sorry, There's An Issue On Registeration, Please Try Again!
		</div>
		<?php
	}
}
