<?php
require_once '../wp-content/themes/mitchdesigns/header.php';
mitch_validate_logged_in();

// $user_points_info = MD_get_user_points_info($current_user->ID);
// $points_settings  = get_field('points_settings' , "options");
//  $currency_to_points = $points_settings['groups'][$user_points_info->level_number]['currency_to_points'];
 
$terms = get_terms(array(
    'taxonomy' => 'cancelling_reasons',
    'hide_empty' => false,
));

if(isset($_GET['order_id']))
{
    $order_id  = intval($_GET['order_id']);
    if(get_post_meta($order_id, '_customer_user', true) != get_current_user_id()){
        wp_redirect(home_url('myaccount/orders-list.php'));
      exit;
    }
    $order_obj = wc_get_order($order_id);
} else {
    wp_redirect(home_url('myaccount/orders-list.php'));
}

if(empty($order_obj)){
    
    wp_redirect(home_url('myaccount/orders-list.php'));
}
else {

?>
<div id="page" class="site">
	<?php require_once '../wp-content/themes/mitchdesigns/theme-parts/main-menu.php';?>
	<!--start page-->
	<div class="site-content page_myaccount">
		<div class="grid">

			<div class="page_content">
				<div class="section_nav">
					<div class="box_nav">
						<?php include_once 'myaccount-sidebar.php';?>
						<div class="section_title">
							<span class="<?php echo strtolower( "Silver") ; ?>"><?php echo "Silver" ; ?></span>
							<h3 class="name">
								<?php echo get_user_meta($current_user->ID, 'first_name', true).' '.get_user_meta($current_user->ID, 'last_name', true);?>
							</h3>
						</div>
					</div>

				</div>
				<div class="dashbord">
					<div class="order-details">
						<ul class="MD-breadcramb">
							<li><a
									href="<?php echo home_url();?>"><?php echo Myaccount_translation('myaccount_pagination_home' , $language) ?></a>
							</li>
							<li><?php echo Myaccount_translation('myaccount_page_title' , $language) ?></li>
							<li><?php echo Myaccount_translation('myaccount_page_sidebare_orders' , $language) ?></li>
						</ul>
						<h1 class="dashboard-title">
							<?php if($language == 'en'){echo 'Order # ' . $order_id ;}else {echo 'الطلب رقم ' . $order_id; }?>
							<a class="btn_back"
								href="<?php if($language == 'en'){echo home_url('myaccount/orders-list.php?lang=en') ;}else{echo home_url('myaccount/orders-list.php');}?>"></a>
						</h1>
						<div class="track-order section">
							<div class="top">
								<ul>
									<li class='status'>
										<?php echo Myaccount_translation('overview_orders_return_table_titles_status' , $language) ?>:<span
											class="<?php echo $order_obj->get_status(); ?>"><?php echo Order_status($order_obj->get_status(), $language);  ?></span>
									</li>
									<li><?php echo Myaccount_translation('overview_orders_return_table_titles_date' , $language) ?>:
										<span> <?php echo $order_obj->get_date_created()->date("F j, Y"); ?></span></li>
									<li><?php echo Myaccount_translation('Orders_items' , $language) ?>:<span>
											<?php echo  $order_obj->get_item_count(); ?></span></li>


								</ul>
							</div>
							<div class="bottom">
								<?php if($order_obj->get_status() != 'cancelled'){ ?>
								<div class="track-bar">
									<div class="order_setup">
										<div class="step one done">
											<div class="icon">
												<i class="material-icons">done</i>
											</div>
											<div class="text">
												<h4><?php echo Myaccount_translation('Orders_Order_placed' , $language) ?></h4>

											</div>
										</div>
										<div class="step two <?php if($order_obj->get_status() != 'cancelled') echo "done" ;?>">
											<div class="icon">
												<i class="material-icons">done</i>
												<span class="num">2</span>
											</div>
											<div class="text">
												<h4><?php echo Myaccount_translation('Orders_order_preparing' , $language) ?></h4>

											</div>
										</div>
										<div class="step three 
                                        <?php if($order_obj->get_status() == 'completed' ) {
                                            echo 'done' ;
                                        }
                                        else if($order_obj->get_status() == 'ready-to-ship'){
                                            echo 'done' ;
                                        }else if($order_obj->get_status() == 'shipped'){
                                            echo 'done' ;
                                        }

                                        ?> ">
											<div class="icon">
												<i class="material-icons">done</i>
												<span class="num">3</span>
											</div>
											<div class="text">
												<h4> <?php echo Myaccount_translation('Orders_ready_to_ship' , $language) ?> </h4>

											</div>
										</div>
										<div class="step four  <?php if($order_obj->get_status() == 'completed' ) {
                                            echo 'done' ;
                                        } else if($order_obj->get_status() == 'shipped'){
                                            echo 'done' ;
                                        }
                                        ?>  ">
											<div class="icon">
												<i class="material-icons">done</i>
												<span class="num">4</span>
											</div>
											<div class="text">
												<h4><?php echo Myaccount_translation('Orders_order_shipped' , $language) ?> </h4>

											</div>
										</div>
										<div class="step five <?php if($order_obj->get_status() == 'completed' ) echo "done"; ?>">
											<div class="icon">
												<i class="material-icons">done</i>
												<span class="num">5</span>
											</div>
											<div class="text">
												<h4><?php echo Myaccount_translation('Orders_order_delivery' , $language) ?></h4>

											</div>
										</div>

									</div>
								</div>
								<?php }  ?>
							</div>
						</div>
						<div class="items-list section">
							<div class="all_items">
								<?php  foreach($order_obj->get_items() as $key => $values){  ?>
								<?php $arabic_fields = MD_product_widget_data($values['product_id'] , $language ); ?>
								<?php   $order_item_data = mitch_get_short_product_data($values['product_id']); ?>
								<div class="single-item">
									<div class="image">
										<a href=""><img src="<?php echo $order_item_data['product_image'];?>"
												alt="<?php echo $order_item_data['product_title'];?>"></a>
									</div>
									<div class="details">
										<h3 class="title"><?php echo $arabic_fields['name'];?></h3>
										<ul class="variations">
											<?php  
                                            $product    = $values->get_product();
                                            if( $product->is_type('variation') ){
                                                $variation_attributes = $product->get_variation_attributes();
                                                foreach($variation_attributes as $attribute_taxonomy => $term_slug ){
                                                    $taxonomy = str_replace('attribute_', '', $attribute_taxonomy );
                                                    $attribute_name = wc_attribute_label( $taxonomy, $product );
                                                    if( taxonomy_exists($taxonomy) ) {
                                                        $attribute_value = get_term_by( 'slug', $term_slug, $taxonomy )->name;
                                                    } else {
                                                        $attribute_value = $term_slug; 
                                                    }

                                                    $term = get_terms( array(
                                                        'taxonomy' => $taxonomy,
                                                        'slug' => $term_slug,
                                                        'fields' => 'ids'
                                                    ) );
                    
                                                    if ( ! empty( $term ) && ! is_wp_error( $term ) ) {
                                                        $tag_id = $term[0];
                                                    }
                                                    $attribute_arabic =  get_term_meta($tag_id, 'attribute_in_arabic', true);
                                                    $attribute_english = get_term_by( 'slug', $term_slug, $taxonomy )->name;

                                            ?>


											<li>
												<span><?php if($language == 'en'){echo $attribute_english ;}else{echo $attribute_arabic ;} ?></span>
											</li>

											<?php }  ?>
											<?php } ?>
										</ul>
										<h4 class="quantity">x<?php echo  $values['quantity'] ; ?></h4>
										<div class="prices">
											<div class="single-price">
												<p>
													<?php echo  number_format($values['line_total'] / $values['quantity']) .' '. $theme_settings['curren_currency_' . $language];?>
												</p>
												<?php  $regular_price = $product-> get_regular_price(); ?>


											</div>
											<div class="total-price">
												<p>
													<?php echo number_format($values['line_total']) .' '. $theme_settings['curren_currency_' . $language]  ;?>
												</p>

											</div>
										</div>
									</div>
								</div>
								<?php }  ?>
							</div>
						</div>
						<div class="shipping-info section">
							<h3 class="section-title"> <?php echo Myaccount_translation('Orders_shipping_info' , $language) ?> </h3>
							<div class="details">
								<p class="MD-row"> <?php echo $order_obj->get_billing_first_name();?>
									<?php echo $order_obj->get_billing_last_name();?> </p>
								<div class="MD-row half">
									<label> <?php echo Myaccount_translation('shipping_street' , $language) ?></label>
									<span><?php echo $order_obj->get_billing_address_1();?></span>
								</div>
								<div class="MD-row small">
									<label><?php echo popup_translate('gover', $language); ?></label>
									<span>
										<?php if($language == 'en'){ $steet_info = get_gov_by_name( $order_obj->get_billing_state()); echo $steet_info -> gov_name_en ;}else{echo $order_obj->get_billing_state();} ?></span>
								</div>
								<div class="MD-row small">
									<label><?php echo popup_translate('area', $language); ?></label>
									<span><?php if($language == 'en'){ $steet_info = get_area_by_name($order_obj->get_meta('_billing_street')); echo $steet_info -> area_name_en ;}else{echo$order_obj->get_meta('_billing_street');} ?></span>
								</div>
								<div class="MD-row small">
									<label><?php echo popup_translate('street', $language); ?></label>
									<span>
										<?php if($language == 'en'){ $steet_info = MD_Get_street_rate_by_name_ar($order_obj->get_billing_city()); echo $steet_info -> street_name_en ;}else{echo $order_obj->get_billing_city();} ?></span>
								</div>
								<div class="MD-row small">
									<label><?php echo Myaccount_translation('shipping_floor' , $language) ?></label>
									<span> <?php echo get_post_meta($order_id, '_billing_building', true) ;?></span>
								</div>
								<div class="MD-row small">
									<label><?php echo Myaccount_translation('shipping_apartment' , $language) ?></label>
									<span> <?php echo get_post_meta($order_id, '_billing_building_2', true);?> </span>
								</div>

							</div>
						</div>
						<div class="payment-method section">
							<h3 class="section-title"> <?php echo Myaccount_translation('Orders_payment_method' , $language) ?> </h3>
							<div class="MD-row">
								<?php
                                 $payment_method =  $order_obj->get_payment_method() ;
                                 $row_payment_method = $payment_method ;
                                 if($payment_method == "cod")
                                 {
                                     $payment_method = thankyou_translate('thanks_cod' , $language);
                                 }else if ($payment_method == 'nodepayment'){
                                     $payment_method = thankyou_translate('thanks_cc' , $language);
                                 }
                                
                                ?>
								<label> <?php echo $payment_method ; ?></label>
							</div>
						</div>

						<div class="final-price section">
							<div class="subtotal MD-row">
								<p class="title"><?php echo Myaccount_translation('Order_subtotal' , $language) ?></p>
								<p class="price">
									<?php echo   number_format($order_obj->get_subtotal()).' '. $theme_settings['curren_currency_' . $language] ;?>
								</p>

							</div>
							<div class="shipping MD-row">
								<p class="title"><?php echo Myaccount_translation('Order_shipping' , $language) ?></p>
								<p class="price">
									<?php echo   number_format($order_obj->get_shipping_total()) .' '. $theme_settings['curren_currency_' . $language] ;?>
								</p>
							</div>
							<?php if($order_obj->get_total_fees() < 0){ ?>
							<div class="discount MD-row">
								<p class="title"><?php echo Myaccount_translation('Order_payondelivery' , $language) ?> </p>
								<p class="price">
									<?php echo   number_format($order_obj->get_total_fees()) .' '. $theme_settings['curren_currency_' . $language] ;?>
								</p>
							</div>
							<?php  } ?>
							<?php foreach( $order_obj->get_coupon_codes() as $coupon_code ) { ?>
							<?php   $coupon = new WC_Coupon($coupon_code); ?>
							<div class="coupon MD-row">
								<p class="title">Coupon</p>
								<p class="price">
									<?php echo   number_format( -$coupon->get_amount()) .' '. $theme_settings['curren_currency_' . $language] ;?>
								</p>
							</div>
							<?php }  ?>
							<div class="total MD-row">
								<p class="title"><?php echo Myaccount_translation('Order_total' , $language) ?></p>
								<p class="price">
									<?php echo   number_format($order_obj->get_total()) .' '. $theme_settings['curren_currency_' . $language] ;?>
								</p>
							</div>
						</div>

					</div>

				</div>
			</div>
		</div>
	</div>
	<!--end page-->
	<!-- <div id="overlay" class="overlay"></div> -->

</div>

<?php require_once '../wp-content/themes/mitchdesigns/footer.php';?>
<?php include_once 'MD-popups.php'; ?>
<script src="assets/js/my-account.js"></script>


<?php }  ?>