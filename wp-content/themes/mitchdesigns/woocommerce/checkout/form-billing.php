<?php
/**
 * Checkout billing information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-billing.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.9
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} 
global $language;
/** @global WC_Checkout $checkout */
global $theme_settings;
$language = $theme_settings['current_lang'];
?>
<div class="woocommerce-billing-fields">
	<?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>

	<div class="woocommerce-billing-fields__field-wrapper<?php echo(is_user_logged_in())? ' user-logged-in' : ''; ?>">
		<!-- Shipping_method -->
		<div class="N_shipping_method">
			<h3><?php echo($language == 'en')? 'Delivery Method' : 'طريقة التوصيل'; ?></h3>
			<ul class="choose_option">
				<li class="single_option active">
					<input class="input_shipping" type="radio" id="home" name="shipping_option" value="delivery" checked />
					<label class="label_shipping"
						for="home"><?php if($language == 'en'){echo 'Home Delivery' ; }else{echo 'توصيل إلى المنزل' ;} ?></label>
				</li>

				<li class="single_option">
					<input class="input_shipping" type="radio" id="local" name="shipping_option" value="local" />
					<label class="label_shipping"
						for="local"><?php if($language == 'en'){echo 'Local Pickup' ; }else{echo 'الاستلام من الفرع' ;} ?></label>
				</li>

			</ul>
		</div>

		<!-- Shipping_method -->
		<?php $custom_cake_found = false ; ?>
		<?php $custom_cake_date = '9/23/2023' ; ?>
		<?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) { 
			if($cart_item['product_id'] == 3065 ){
				
				$custom_cake_found = true ; 
				$custom_cake_date = $cart_item['variation']['delivery_date'];
				break ;
				}
			}
			  ?>
		<div class="N_delivery_time">
			<h3><?php echo($language == 'en')? 'Delivery Time' : 'تاريخ التوصيل'; ?></h3>
			<ul class="choose_option">
				<?php if(!$custom_cake_found){ ?>
				<li class="single_option active">
					<input class="input_date" type="radio" id="delivery_today" name="delivery_time" value="today" checked />
					<label class="label_date" for="today">
						<?php if($language == 'en'){echo 'Today' ; }else{echo 'اليوم' ;} ?>
						<span><?php if($language == 'en'){echo 'within 60 minutes' ; }else{echo 'في غضون 60 دقيقة' ;} ?></span>
					</label>
				</li>
				<?php } ?>

				<li class="single_option option_date <?php if($custom_cake_found){echo 'e_show active' ;} ?> ">
					<input class="input_date" type="radio" id="delivery_in_date" name="delivery_time" value=""
						<?php if($custom_cake_found){echo 'checked' ;} ?> />
					<label class="label_date" id="l-date" for="delivery_in_date">
						<?php if($language == 'en'){echo 'Delivery Date' ; }else{echo  '  تاريخ التوصيل  ' ;} ?>
						<?php if($custom_cake_found){ ?>
						<span id="set-date"> <?php echo $custom_cake_date;  ?></span>
						<?php }else{  ?>

						<span id="set-date"><?php if($language == 'en'){echo 'Choose Date' ; }else{echo ' اختر تاريخ ' ;} ?></span>
						<?php }  ?>
					</label>
					<a href="#popup-date"
						class="edit_date js-popup-opener"><?php if($language == 'en'){echo 'Edit' ; }else{echo 'تعديل' ;} ?></a>
				</li>
			</ul>
		</div>

		<div class="billing-fileds-container">
			<?php  //if(empty(is_user_logged_in())){ ?>
			<!-- <h2>Checkout As A Guest</h2> -->
			<?php //} ?>
			<h3><?php echo($language == 'en')? 'Your Info.' : 'بيانات العميل'; ?></h3>
			<?php if(is_user_logged_in()): global $current_user; wp_get_current_user(); ?>
			<div class="user-info">
				<p class="user-name">
					<small></small><?php echo get_user_meta($current_user->ID, 'first_name', true).' '. get_user_meta($current_user->ID, 'last_name', true); ?>
				</p>
				<p class="user-email"><small></small><?php echo $current_user->user_email; ?></p>
			</div>
			<?php endif; ?>
			<?php
					$fields = $checkout->get_checkout_fields( 'billing' );
					$mybillingfields=array(
						"billing_first_name",
						"billing_last_name",
						"billing_email",
						"billing_phone",
						// "billing_notes",
					);
					foreach ($mybillingfields as $key) {
						woocommerce_form_field( $key, $checkout->checkout_fields['billing'][$key], $checkout->get_value( $key ) );
					}
				?>
		</div>
		<?php if ( ! is_user_logged_in() && $checkout->is_registration_enabled() ) : ?>
		<div class="woocommerce-account-fields">
			<?php if ( ! $checkout->is_registration_required() ) : ?>

			<p class="form-row form-row-wide create-account">
				<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
					<input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" id="createaccount"
						<?php checked( ( true === $checkout->get_value( 'createaccount' ) || ( true === apply_filters( 'woocommerce_create_account_default_checked', false ) ) ), true ) ?>
						type="checkbox" name="createaccount" value="1" />
					<span
						class="create-acc"><?php echo ($language == "en")? 'Create New account?':'أريد إنشاء حساب جديد'; ?></span>
					<!-- <span class="instruction"><?php //echo ($language == "en")? 'Create a new account to subscribe to the points program and get special discount coupons':'قم بتسجيل حساب جديد للإشتراك في برنامج النقاط والحصول علي كوبونات خصم متميزة'; ?></span> -->
				</label>
			</p>

			<?php endif; ?>

			<?php do_action( 'woocommerce_before_checkout_registration_form', $checkout ); ?>

			<?php if ( $checkout->get_checkout_fields( 'account' ) ) : ?>

			<div class="create-account">
				<?php foreach ( $checkout->get_checkout_fields( 'account' ) as $key => $field ) : ?>
				<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
				<?php endforeach; ?>
				<div class="clear"></div>
			</div>

			<?php endif; ?>

			<?php do_action( 'woocommerce_after_checkout_registration_form', $checkout ); ?>
		</div>
		<?php endif; ?>
		<div class="shipping-fileds-container">
			<h3 id="shipping_method_title">
				<?php if($language == 'en'){echo 'Shipping Address';}else{echo 'عنوان التوصيل' ;} ?></h3>

			<?php if(is_user_logged_in()): global $current_user; wp_get_current_user(); ?>
			<?php 	
						$current_user_id = get_current_user_id();
						$main_address    = mitch_get_user_main_address($current_user_id);
						$other_addresses = mitch_get_user_others_addresses_list($current_user_id);
					?>
			<div class="user-address N_address">
				<ul class="choose_option">
					<!-- Default Address -->
					<?php $street_info = get_street_name_by_id( $main_address -> level_3); ?>
					<?php $street_name = "street_name_" . $language ; ?>
					<?php $area_info = MD_Get_area_by_area_id( $main_address -> level_2); ?>
					<?php $area_name = "area_name_" . $language ; ?>
					<?php $gov_info = get_gov_name_by_id($main_address -> level_1);  ?>
					<?php $gov_name = "gov_name_" . $language ;?>

					<?php if($street_info){ ?>

					<li class="single_option active address_option" data-full="<?php echo $main_address -> full_address  ?>"
						data-floor="<?php echo $main_address -> Floor ?>" data-app="<?php echo $main_address -> apartment ?>"
						data-gov="<?php echo $gov_info-> gov_name_ar ?>" data-area="<?php echo $area_info -> area_name_ar ?>"
						data-street="<?php echo $street_info -> street_name_ar ?>">
						<input class="input_address" type="radio" id="default" name="address_option" value="default" checked />
						<label class="label_address" for="default">

							<div class="top_field">
								<p class="not_title"> <?php echo $street_info -> $street_name  ?></p>
								-
								<p class="not_title"> <?php echo $area_info -> $area_name  ?></p>
								-
								<p class="not_title"> <?php echo $gov_info-> $gov_name ?></p>
							</div>
							<div class="bottom_field">
								<p class="with_title">
									<span><?php if($language == 'en'){echo 'Shipping Address';}else{echo ' عنوان التوصيل :' ;} ?></span>
									<?php echo $main_address -> full_address  ?>
								</p>
								-
								<p class="with_title">
									<span><?php if($language == 'en'){echo 'Apartment';}else{echo ' شقة :' ;} ?></span>
									<?php echo $main_address -> apartment ?>
								</p>
								-
								<p class="with_title">
									<span><?php if($language == 'en'){echo 'Floor';}else{echo 'الدور :' ;} ?></span>
									<?php echo $main_address -> Floor ?>
								</p>
							</div>


						</label>
					</li>
					<?php }  ?>

					<!-- Other Addresses -->
					<?php 
								$count = 1;
								foreach($other_addresses as $one_address){ 
							?>
					<?php $street_info = get_street_name_by_id( $one_address -> level_3); ?>
					<?php $street_name = "street_name_" . $language ; ?>
					<?php $area_info = MD_Get_area_by_area_id( $one_address -> level_2); ?>
					<?php $area_name = "area_name_" . $language ; ?>
					<?php $gov_info = get_gov_name_by_id($one_address -> level_1);  ?>
					<?php $gov_name = "gov_name_" . $language ;?>
					<li class="single_option address_option " data-full="<?php echo  $one_address -> full_address ?>"
						data-floor="<?php echo  $one_address -> Floor ?>" data-app="	<?php echo  $one_address -> apartment ?>"
						data-gov="<?php echo $gov_info-> gov_name_ar ?>" data-area="<?php echo $area_info -> area_name_ar ?>"
						data-street="<?php echo $street_info -> street_name_ar ?>">
						<input class="input_address" type="radio" name="address_option" value="address-<?php echo $count ?>" />
						<label class="label_address" for="address-<?php echo $count ?>">
							<div class="top_field">

								<p class="not_title"> <?php echo $street_info -> $street_name  ?></p>
								-

								<p class="not_title"> <?php echo $area_info -> $area_name  ?></p>
								-
								<?php $gov_info = get_gov_name_by_id($one_address -> level_1);  ?>
								<?php $gov_name = "gov_name_" . $language ;?>
								<p class="not_title"> <?php echo $gov_info-> $gov_name ?></p>
							</div>
							<div class="bottom_field">
								<p class="with_title">
									<span><?php if($language == 'en'){echo 'Shipping Address';}else{echo ' عنوان التوصيل :' ;} ?></span>
									<?php echo  $one_address -> full_address ?>
								</p>
								-
								<p class="with_title">
									<span><?php if($language == 'en'){echo 'Apartment';}else{echo ' شقة :' ;} ?></span>
									<?php echo  $one_address -> apartment ?>
								</p>
								-
								<p class="with_title">
									<span><?php if($language == 'en'){echo 'Floor';}else{echo 'الدور :' ;} ?></span>
									<?php echo  $one_address -> Floor ?>
								</p>
							</div>
						</label>
					</li>
					<?php $count++; }  ?>

				</ul>
				<a href="#add-new-addresss" class="js-MD-popup-opener MD-btn-add">
					<?php if($language == 'en'){echo 'Add New Address';}else{echo 'أضف عنوان جديد' ;} ?></a>

				<div class="MD-popup" id="add-new-addresss">
					<div class="popup__window">
						<button class="MD-close js-MD-popup-closer"><span class="material-symbols-rounded">
								close
							</span></button>
						<!-- <h2 class="MD-popup-title add-address"> <?php //echo Myaccount_translation('shipping_add_new_address' , $language) ?> </h2> -->
						<h2 class="MD-popup-title">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/MD_myaccount_icon/menu/addresse.png"
								alt="" width="25" height="25">
							<?php echo Myaccount_translation('shipping_add_new_address' , $language) ?>
						</h2>
						<?php
								$main_address    = mitch_get_user_main_address($current_user_id);
								?>
						<form id="form-add" class="MD-inputs" method="#" action="POST"
							data-where="<?php if(empty($main_address)){ echo "add" ;} ?>">
							<div class="MD-field">
								<label for=""><?php echo Myaccount_translation('shipping_city' , $language) ?> <span>*</span></label>
								<select name="city" id="city" required>
									<?php $gov_name  = "gov_name_" . $language ;?>
									<option value=""><?php echo Popup('choose_city' , $language)  ?></option>
									<?php $all_govs = MD_get_all_data_govs();  ?>
									<?php foreach($all_govs as $one_gov){ ?>
									<option value="<?php echo $one_gov->gov_id ?>"><?php echo $one_gov->$gov_name ?></option>
									<?php }  ?>

								</select>
							</div>
							<div class="MD-field">
								<label for=""><?php echo Myaccount_translation('shipping_area' , $language) ?> <span>*</span></label>
								<select name="area" id="add_address_area" required="required">
									<option value=""><?php echo Popup('choose_area' , $language)  ?></option>
								</select>
							</div>
							<div class="MD-field">
								<label for=""><?php echo Myaccount_translation('shipping_district' , $language) ?>
									<span>*</span></label>
								<select name="district" id="add_area_district">
									<option value=""><?php echo Popup('choose_district' , $language)  ?></option>

								</select>
							</div>
							<div class="MD-field">
								<label for=""><?php echo Myaccount_translation('shipping_street' , $language) ?> <span>*</span></label>
								<input class="full-address" type="text" name="street_info" required>
							</div>
							<div class="MD-field half_full">
								<label for=""><?php echo Myaccount_translation('shipping_floor' , $language) ?><span>*</span></label>
								<input class="floor" type="number" name="floor" required>
							</div>
							<div class="MD-field half_full">
								<label for=""><?php echo Myaccount_translation('shipping_apartment' , $language) ?>
									<span>*</span></label>
								<input class="apartment" type="number" name="apartment" required>
							</div>
							<button type="submit" class="MD-btn checkout-add-address ">
								<?php echo Myaccount_translation('shipping_add_new_address' , $language) ?> </button>
						</form>

					</div>
				</div>
			</div>
			<?php endif; ?>

			<?php
					$fields = $checkout->get_checkout_fields( 'billing' );
					$mybillingfields=array(
						// "billing_country",
						"billing_state",
						"billing_street",
						"billing_city",
						"billing_address_1",
						"billing_building",
						"billing_building_2",
						"billing_local_pickup",
						"billing_delivery_date",
						// "billing_time_slot",
						// "billing_notes",
					);
					foreach ($mybillingfields as $key) {
						//print_r($checkout->checkout_fields['billing'][$key]);
						woocommerce_form_field( $key, $checkout->checkout_fields['billing'][$key], $checkout->get_value( $key ) );
					}
				?>
			<?php $all_branches = get_all_branches();  ?>
			<!-- <input type="hidden" name="billing_country" id="billing_country" value="EG" autocomplete="country" class="country_to_state" readonly="readonly">	 -->
			<!-- <span class="description" id="billing_building-description" aria-hidden="true" style="font-size: 12px;padding-right: 5px;"> Please enter the property number and the floor and apartment number</span> -->
			<div id="store-select" class="local_select_branch" style="display:none">
				<div class="single_branch">
					<a class="btn_local_select_branch js-popup-opener" href="#popup-local-select-branch"></a>
					<p class="branch_name">
						<?php if($language == 'ar'){$branch_name = "branch_name_ar" ; }else{ $branch_name = "branch_name_en" ; } ?>
						<?php if($language == 'ar'){$branch_address = "address_ar" ; }else{ $branch_address = "address_en" ; } ?>
						<?php echo $all_branches[0]->$branch_name ; ?>
						<span> <?php echo $all_branches[0]->$branch_address; ?></span>
					</p>
				</div>
			</div>

			<div id="popup-local-select-branch" class="popup local_select_branch">
				<div class="popup__window select_branch">
					<div class="top">
						<h3> <?php if($language == 'en'){echo 'Choose Branch' ; }else{echo 'اختار الفرع' ;} ?> </h3>
						<button type="button" class="popup__close material-icons js-popup-closer">close</button>
					</div>
					<div class="section_content" id="local-select-branch">
						<div class="all_branches">
							<?php 
									
									$count = 1;
									foreach($all_branches as $one_branch){ 
										if($one_branch->address_en == "")
										continue;
									?>
							<div class="single_pop_branch  <?php if($count == 1){echo 'selected' ;} ?>"
								data-address="<?php echo $one_branch->address_ar ; ?>"
								data-address_en="<?php echo $one_branch->address_en ; ?>"
								data-value_ar="<?php echo $one_branch->branch_name_ar ; ?>"
								data-value_en="<?php echo $one_branch->branch_name_en ?>"
								value="<?php echo $one_branch -> branch_id ?>">
								<p class="branch_pop_name">
									<?php echo ($language == 'en')?  $one_branch->branch_name_en  : $one_branch->branch_name_ar  ?>
									<span><?php echo ($language == 'en')? $one_branch->address_en: $one_branch->address_ar ?></span>
								</p>
								<span class="check"><i class="material-icons">done</i></span>
							</div>
							<?php $count++; } ?>

						</div>
					</div>
					<div class="bottom">
						<button id="change_store" class="btn_confirm">
							<?php if($language == 'en'){echo 'Confirmation' ; }else{echo 'تاكيد' ;} ?> </button>
					</div>

				</div>
			</div>
		</div>

		<div class="next_checkout">
			<button id="btncheckout" class="btn_checkout"><?php if($language == 'en'){echo 'Next' ; }else{echo 'التالي' ;} ?>
			</button>
		</div>




		<?php
		// $fields = $checkout->get_checkout_fields( 'billing' );
		// $mybillingfields=array(
		// 	"billing_country",
		// );
		// foreach ($mybillingfields as $key) {
		// 	woocommerce_form_field( $key, $checkout->checkout_fields['billing'][$key], $checkout->get_value( $key ) );
		// }
		?>
	</div>

	<?php do_action( 'woocommerce_after_checkout_billing_form', $checkout ); ?>
</div>