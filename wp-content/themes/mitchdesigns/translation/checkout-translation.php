<?php

function checkout_translate($phrase , $language){
    static $checkout_page_translation = array(
      'place_order_ar'     => 'اطلب الان',              'place_order_en'     => 'Order Now', 
      'under_place_order_1_ar' => 'بالنقر فوق "اطلب الآن" ، فإنك توافق على',
      'under_place_order_1_en' => 'By clicking Order Now”, you agree to our',

      'under_place_order_2_ar'=> 'الأحكام والشروط' ,
      'under_place_order_2_en'=> 'Terms And Conditions' ,

      'under_place_order_3_ar'=> 'يرجى أيضًا قراءة ' ,
      'under_place_order_3_en'=> 'Please also read our' ,

      'under_place_order_4_ar'=> 'سياسة الخصوصية' ,
      'under_place_order_4_en'=> 'Privacy Policy' ,

      'edit_ar'  => 'تعديل',         'edit_en'  => 'Edit', 
      'shopping_cart_ar'  =>'سلة التسوق',    'shopping_cart_en'  =>'Shopping Cart', 

    ); 
    return $checkout_page_translation[$phrase . '_' . $language] ;

  }

  function thankyou_translate($phrase , $language){
    static $thanks_page_translation = array(
        'thanks_title_en'                     =>'Thank You',                             'thanks_title_ar'                     =>'شكرا لك',
        'thanks_subtitle_en'                  =>'You Order Has been Recieved',           'thanks_subtitle_ar'                  =>'تم تقديم طلبك بنجاح',
        'thanks_contact_en'                   =>"If you have questions about your order, you can email us at info@exceptionpastry.com or call us at 16687",
        'thanks_contact_ar'                   =>"إذا كانت لديك أسئلة حول طلبك ، يمكنك مراسلتنا عبر البريد الإلكتروني على info@exceptionpastry.com او اتصل بنا علي 16687",
        'thanks_phone_en'                     =>'or call us at ',                        'thanks_phone_ar'                     =>'أو الاتصال بنا على',
        'thanks_order_en'                     =>'Order Number',                          'thanks_order_ar'                     =>'طلب رقم', 
        'thanks_user_info_title_en'           =>'Your Info.',                            'thanks_user_info_title_ar'           =>'بيانات العميل ',   
        'thanks_first_name_en'                =>'First Name' ,                           'thanks_first_name_ar'                =>'الاسم الاول' ,
        'thanks_last_name_en'                 =>'Last Name' ,                            'thanks_last_name_ar'                 =>'الاسم الثاني' ,
        'thanks_email_en'                     =>'Email Address' ,                        'thanks_email_ar'                     =>'البريد الاكتروني' ,
        'thanks_mobile_en'                    =>'Mobile' ,                               'thanks_mobile_ar'                    =>'الهاتف' ,
        'thanks_full_address_en'              =>'Street info and Building Number',       'thanks_full_address_ar'              =>'الشارع و رقم العقار',
        'thanks_floor_en'                     =>'Floor',                                 'thanks_floor_ar'                     =>'الطابق',
        'thanks_apartment_en'                 =>'Apartment',                             'thanks_apartment_ar'                 =>'الشقة',
        'thanks_shipping_title_en'            =>'Shipping Info',                         'thanks_shipping_title_ar'            =>'عنوان التوصيل',
        'thanks_payment_method_en'            =>'Payment Method',                        'thanks_payment_method_ar'            =>'طريقة الدفع',
        'thanks_cod_en'                       =>'Cash On Delivery',                      'thanks_cod_ar'                       =>'الدفع عند الاستلام ',
        'thanks_cc_en'                        =>'Credit Card',                           'thanks_cc_ar'                        =>'بطاقة الإئتمان',
        'thanks_vat_en'                       =>'Includes VAT',                          'thanks_vat_ar'                       =>'تتضمن ضريبة القيمة المضافة',
        'thanks_coupon_en'                    =>'Coupon',                                'thanks_coupon_ar'                    =>'قسيمة شراء',
        'thanks_shipping_en'                  =>'Shipping',                              'thanks_shipping_ar'                  =>'التوصيل',
        'thanks_total_en'                     =>'Total',                                 'thanks_total_ar'                     =>'الاجمالي',
        'thanks_subtotal_en'                  =>'Subtotal',                              'thanks_subtotal_ar'                  =>'المبلغ',
        'thanks_msg_en'                       =>'Thank you. Your order has been received.',
        'thanks_msg_ar'                       =>'شكرا لك تم استلام طلبك',
        'thanks_cart_quntity_en'              =>'Quantity',                              'thanks_cart_quntity_ar'              =>'عدد',
        'thanks_city_en'                      =>'City',                                  'thanks_city_ar'                      =>'المدينة',
        'thanks_area_en'                      =>'Area',                                  'thanks_area_ar'                      =>'الحي',
        'thanks_district_en'                  =>'District',                              'thanks_district_ar'                  =>'المنطقة',
        'pickup_store_en'                     => 'Store to Pick Up' ,                    'pickup_store_ar'                     => 'استلام من الفرع ' ,
        'thanks_delivery_date_en'             => 'Delivery Date' ,                        'thanks_delivery_date_ar'             => 'تاريخ الاستلام' ,



        
    );

    return $thanks_page_translation[$phrase . '_' . $language] ;

  }
  function payment_methods_translate($phrase , $language){
    static $payments = array(
      'cod_en'            => "Cash On Delivery",              'cod_ar'              =>'الدفع عند الاستلام',
      'nodepayment_en'    => "Credit Cart",                   'nodepayment_ar'      => "بطاقة الإئتمان",
    );

    return $payments[$phrase . '_' . $language] ;
  }

  // Very Very Important 
  // Adding new Hidden Field in Checkout to detect the intial Language of checkout 
  add_action( 'woocommerce_after_checkout_billing_form', 'add_language_field' );
  function add_language_field() {
      // Get current language from URL
      $language = isset( $_GET['lang'] ) ? $_GET['lang'] : 'ar';

      // Add hidden field
      echo '<input type="hidden" name="language" value="' . esc_attr( $language ) . '">';
  }


// Node Payment Translation 
add_filter('wpnp_fields_labels', 'wpnp_fields', 10, 1);
function wpnp_fields( $translations ) {
	if(isset($_POST['post_data'])){
        $post_data = explode("&",$_POST['post_data']);
        foreach($post_data as $one_data){
        if(str_contains($one_data , 'language')){
            if(str_contains($one_data , 'en')){
                $language = 'en' ;
            }else{
                $language = 'ar';

            }

        }
        }
    }else {
        $language = 'ar' ;
    }

	if($language == 'en'){
		$translations['cardholder_name'] = "Card Holder Name";
		$translations['card_number'] = "Card Number";
		$translations['expiry_date'] = "Expiry Date";
		$translations['cvc'] = "CVC";
	}
   
    return $translations;
} 

// -------------------------------------- Coupon Functions Translation  ------------------

// ------------------------------Coupon Error Messages ---------------------------
add_filter( 'woocommerce_coupon_error','coupon_error_message_change',10,3 );
function coupon_error_message_change($err, $err_code, $parm ){
	//if(!isset($_POST['coupon_from'])){
		global $language_temp,$theme_settings;
        if($_SERVER['REQUEST_URI'] == '/?wc-ajax=apply_coupon'){
            if(str_contains($err , 'minimum spend')){
                ?>
                <script>
                    if($('body').hasClass('rtl')) {
                        $('.woocommerce-notices-wrapper').html('<ul class="woocommerce-error" role="alert"><li><?php echo " الحد الأدنى للإنفاق لهذه القسيمة هو ".  $parm->minimum_amount ."جنيه " ;?></li></ul>');
                    }else{
                        <?php
                        $err = "The minimum amount for this coupon is " . $parm->minimum_amount . " EGP" ;
                        ?>

                    }
                </script>
                <?php
            }
        }

		switch ( $err_code ) {
			case 105:
			/* translators: %s: coupon code */
			?>
			<script>
			if($('body').hasClass('rtl')){
				$('.woocommerce-notices-wrapper').html('<ul class="woocommerce-error" role="alert"><li><?php echo 'كوبون '. $parm->get_code()." غير موجود " ;?></li></ul>');
			}
			else{
				$('.woocommerce-notices-wrapper').html('<ul class="woocommerce-error" role="alert"><li><?php echo "Coupon ". $parm->get_code()." does not exist!" ;?></li></ul>');
			}
			</script>
			<?php
			case 107:
				/* translators: %s: coupon code */
				?>
				<script>
				if($('body').hasClass('rtl')){
					$('.woocommerce-notices-wrapper').html('<ul class="woocommerce-error" role="alert"><li><?php echo 'لقد انتهت صلاحية الكوبون.' ;?></li></ul>');
				}
				else{
					$('.woocommerce-notices-wrapper').html('<ul class="woocommerce-error" role="alert"><li><?php echo "Coupon code expired.";?></li></ul>');
				}
				</script>
                <?php
			break;
		 }
		return $err;
	//}
}

//  ---------------------------Coupon Success Messages ----------------------------------

  add_filter( 'woocommerce_coupon_message', 'filter_woocommerce_coupon_message', 10, 3 );

function filter_woocommerce_coupon_message($msg, $msg_code, $coupon) {
  if ( is_wc_endpoint_url( 'checkout' ) ) {
  
    if($msg === __('Coupon code applied successfully.', 'woocommerce')) {
	?>
		<script>
		if($('body').hasClass('rtl')){
			$('.woocommerce-notices-wrapper').html('<ul class="woocommerce-message" role="alert"><li><?php echo 'تم تفعيل الكوبون بنجاح' ;?></li></ul>');
		}
		else{
			$('.woocommerce-notices-wrapper').html('<ul class="woocommerce-message" role="alert"><li><?php echo "Coupon code applied successfully" ;?></li></ul>');
		}
		</script>
	<?php
	}
    if($msg === __('Coupon code already applied!', 'woocommerce')) {
	?>
		<script>
		if($('body').hasClass('rtl')){
			$('.woocommerce-notices-wrapper').html('<ul class="woocommerce-message" role="alert"><li><?php echo 'تم تفعيل كوبون '. $coupon->get_code()." بنجاح" ;?></li></ul>');
		}
		else{
			$('.woocommerce-notices-wrapper').html('<ul class="woocommerce-message" role="alert"><li><?php echo "Coupon ". $coupon->get_code()." applied successfully." ;?></li></ul>');
		}
		</script>
	<?php
	}
    if(strpos($msg,'removed') !== false || strpos($msg,'إزالة') !== false) {
	?>
			<script>
		if($('body').hasClass('rtl')){
			$('.woocommerce-notices-wrapper').html('<ul class="woocommerce-message" ><li><?php echo '.تم حذف كوبون ';?></li></ul>');
		}
		else{
			$('.woocommerce-notices-wrapper').html('<ul class="woocommerce-message"><li><?php echo "Coupon Removed.";?></li></ul>');
		}
		</script>
	<?php
	}
	?>
			<script>
			$('.woocommerce-notices-wrapper').html('<ul class="woocommerce-message" role="alert"><li><?php echo $msg ;?></li></ul>');
		</script>
	<?php
    return $msg;
}
}

add_filter( 'gettext', 'woocommerce_rename_coupon_field_on_cart', 10, 3 );
function woocommerce_rename_coupon_field_on_cart( $translated_text, $text, $text_domain ) {
  if(isset($_COOKIE['current_language'])){
    $language = $_COOKIE['current_language'];
  }else {
    $language = 'ar';
  }
	if($language == 'ar'){
    if ('Coupon has been removed.' === $text){
      $translated_text = '<span class="hide-en">تم مسح الكوبون</span>';
    }
}
	return $translated_text;
}

function filter_woocommerce_cart_totals_coupon_html($coupon_html, $coupon, $discount_amount_html)
{
	// Change text
  if(isset($_COOKIE['current_language'])){
    $language = $_COOKIE['current_language'];
  }else {
    $language = 'ar';
  }

	if ($language == "en") {
	  //$coupon_html = str_replace('[حذف]', '[Remove]', $coupon_html);
	} else {
		$coupon_html = str_replace('EGP', 'جنيه', $coupon_html);
		$coupon_html = str_replace('[Remove]', '[حذف]', $coupon_html);
	}
	return $coupon_html;
}
add_filter('woocommerce_cart_totals_coupon_html', 'filter_woocommerce_cart_totals_coupon_html', 10, 3);


// ----------------------------- Thanks Page English Link Redirection ----------------------- 
function custom_thankyou_redirect( $redirect_url, $order ) {
  // Get the order ID and order token
  $order_id    = $order->get_id();
  $order_token = $order->get_order_key();

  global $theme_settings ;
 
  if(isset($_COOKIE['current_language'])){
    $language = $_COOKIE['current_language'];
  }else {
    $language = 'ar';
  }

  if($language == 'en'){
    $redirect_url = $theme_settings['site_url'] . '/checkout/order-received/' . $order_id . '/?key=' . $order_token . '&lang=en';
  }
    
  return $redirect_url;
}

add_filter( 'woocommerce_get_checkout_order_received_url', 'custom_thankyou_redirect', 10, 2 );

