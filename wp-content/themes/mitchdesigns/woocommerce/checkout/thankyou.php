<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.7.0
 */
defined( 'ABSPATH' ) || exit;
global $theme_settings;
global $language ;
require_once get_template_directory().'/includes/thankyou-actions.php';
?>
<style>
.alert {
	margin-bottom: 10px;
}
</style>
<div class="woocommerce-order">
	<?php
	if($order) :
		do_action('woocommerce_before_thankyou', $order->get_id());
		$backorder_id = get_post_meta($order->get_id(), 'backorder', true);
		if($backorder_id){
			$backorder_obj = wc_get_order($backorder_id);
		}else{
			$backorder_obj = '';
		}
		?>
	<?php if($order->has_status('failed')) : ?>
	<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed">
		<?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?>
	</p>
	<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
		<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>"
			class="button pay"><?php esc_html_e( 'Pay', 'woocommerce' ); ?></a>
		<?php if ( is_user_logged_in() ) : ?>
		<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>"
			class="button pay"><?php esc_html_e( 'My account', 'woocommerce' ); ?></a>
		<?php endif; ?>
	</p>

	<?php else : ?>
	<div class="thanks_page">
		<div class="left">
			<p class="title woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received ">
				<?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( thankyou_translate('thanks_title' , $language), 'woocommerce' ), $order ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icons/thanks_icon.png" alt="" width="40"
					height="40">
			</p>
			<p class="subtitle woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received ">
				<?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( thankyou_translate('thanks_subtitle' , $language), 'woocommerce' ), $order ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</p>
			<p class="desc woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received ">
				<?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( thankyou_translate('thanks_contact' , $language), 'woocommerce' ), $order ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</p>

			<div class="woocommerce-customer-details">

				<div class="first">
					<h4> <?php echo thankyou_translate('thanks_user_info_title' , $language)?> </h4>
					<div class="row half">
						<label for=""> <?php echo thankyou_translate('thanks_first_name' , $language) ?> </label>
						<p><?php echo $order->get_billing_first_name();?></p>
					</div>
					<div class="row half">
						<label for=""> <?php echo thankyou_translate('thanks_last_name' , $language) ?></label>
						<p><?php echo $order->get_billing_last_name();?></p>
					</div>
					<div class="row full">
						<label for=""> <?php echo thankyou_translate('thanks_email' , $language) ?></label>
						<p><?php echo $order->get_billing_email();?></p>
					</div>
					<div class="row full">
						<label for=""> <?php echo thankyou_translate('thanks_mobile' , $language) ?></label>
						<p><?php echo $order->get_billing_phone();?></p>
					</div>
				</div>
				<?php // Shipping Method  ?>
				<?php if(!empty( $order->get_billing_city())){ ?>
				<div class="first">
					<h4> <?php echo thankyou_translate('thanks_shipping_title' , $language); ?></h4>
					<div>
						<div class="row half">
							<label for=""><?php echo popup_translate('gover', $language); ?> </label>
							<p>
								<?php if($language == 'en'){ $steet_info = get_gov_by_name( $order->get_billing_state()); echo $steet_info -> gov_name_en ;}else{echo $order->get_billing_state();} ?>
							</p>
						</div>
						<div class="row half">
							<label for=""><?php echo popup_translate('area', $language); ?> </label>
							<p>
								<?php if($language == 'en'){ $steet_info = get_area_by_name($order->get_meta('_billing_street')); echo $steet_info -> area_name_en ;}else{echo$order->get_meta('_billing_street');} ?>
							</p>
						</div>
						<div class="row half">
							<label for=""><?php echo popup_translate('street', $language); ?> </label>
							<p>
								<?php if($language == 'en'){ $steet_info = MD_Get_street_rate_by_name_ar($order->get_billing_city()); echo $steet_info -> street_name_en ;}else{echo $order->get_billing_city();} ?>
							</p>
						</div>

					</div>

					<div>
						<div class="row full">
							<label for=""><?php echo thankyou_translate('thanks_full_address' , $language) ?></label>
							<p><?php echo $order->get_billing_address_1();?></p>
						</div>
					</div>

					<div>
						<div class="row half">
							<label for=""> <?php echo thankyou_translate('thanks_floor' , $language) ?></label>
							<p><?php echo get_post_meta($order->get_id(), '_billing_building', true);?></p>
						</div>

						<div class="row half">
							<label for=""><?php echo thankyou_translate('thanks_apartment' , $language) ?></label>
							<p><?php echo get_post_meta($order->get_id(), '_billing_building_2', true);?></p>
						</div>
					</div>
					<div>
						<div class="row full">
							<label for=""><?php echo thankyou_translate('thanks_delivery_date' , $language) ?></label>
							<p>
								<?php if($order->get_meta('_billing_delivery_date') == 'today'){if($language == 'en'){echo 'today' ; }else{echo 'اليوم' ; }}else{ echo $order->get_meta('_billing_delivery_date') ;}?>
							</p>
						</div>
					</div>

				</div>
				<?php } else{ ?>
				<div class="first">
					<div>
						<div class="row full">
							<label for=""><?php echo thankyou_translate('pickup_store' , $language) ?></label>
							<p><?php echo $order->get_meta('_billing_local_pickup') ;?></p>
						</div>
						<div class="row full">
							<label for=""><?php echo thankyou_translate('thanks_delivery_date' , $language) ?></label>
							<p>
								<?php if($order->get_meta('_billing_delivery_date') == 'today'){if($language == 'en'){echo 'today' ; }else{echo 'اليوم' ; }}else{ echo $order->get_meta('_billing_delivery_date') ;}?>
							</p>
						</div>
					</div>

				</div>
				<?php }  ?>
				<div class="first">
					<?php
                    $payment_method =  get_post_meta( $order->get_id(), '_payment_method', true ); 
                    $row_payment_method = $payment_method ;
                    if($payment_method == "cod")
                    {
                        $payment_method = thankyou_translate('thanks_cod' , $language);
                    }else if ($payment_method == 'nodepayment'){
                        $payment_method = thankyou_translate('thanks_cc' , $language);
                    }
                   

                    ?>
					<h4> <?php echo thankyou_translate('thanks_payment_method' , $language) ?> </h4>
					<p> <?php echo $payment_method ?></p>

				</div>
				<!-- <div class="note">
                    <p>If you have questions about your order, you can email us at info@exception.com
                        or call us at <a href="tel:012 9857 3984">012 9857 3984</a> </p>
                    <a href="<?php //echo home_url('/myaccount/order-details.php?order_id='.$order->get_id());?>"
                        class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received track_order">
                        <?php //echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Order Status', 'woocommerce' ), $order ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </a>

                </div> -->
			</div>
			<div class="thanks_grid congratulations">
				<div class="section_congratulations">
					<?php
							$count_widgets = 0;
							/*$points_no     = get_post_meta($order->get_id(), '_order_earned_points_no', true);
							if(!empty($points_no)){
								$count_widgets++;
								?>
					<div class="top">
						<div class="text">
							<h3>Congratulations!</h3>
							<p>
								You’ve earned
								<?php echo $points_no;?>
								rewards points for your purchase today, and these points will be credited to your
								account immediately.
							</p>
						</div>
						<div class="icon">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/thank_gift_01.png" alt="">
						</div>
					</div>
					<?php
							}*/
							?>
				</div>
			</div>
			<?php
					if($count_widgets == 0){
						?>
			<style>
			.thanks_grid.congratulations {
				display: none;
			}
			</style>
			<?php
					}
					?>
		</div>
		<div class="order_review-content">
			<div class="box-con sticky-box">
				<div id="order_review_thanks" class="woocommerce-checkout-review-order">
					<div class="order-title">
						<h3>
							<?php
									if(!empty($backorder_obj)){
										echo 'Processing Order <span> #'.$order->get_order_number().' </span><br>';
										echo 'Pre Order #'.$backorder_id;
									}else{
										echo thankyou_translate('thanks_order',$language) . '  <span> #'.$order->get_order_number().'</span>';
									}
									?>
							<!--<span>
										<?php
										/*if(!empty($backorder_obj) || $order->get_status() == 'backorder'){
											echo 'Next Day Delivery in Cairo & 3-5 Days Outside Cairo';
										}else{
											echo 'Next Day Delivery in Cairo & 3-5 Days Outside Cairo';
										}*/
										?>
									</span>-->
						</h3>
						<!-- <p>لتوصيل خلال ساعتين في القاهرة و ٣ ساعات في باقي المدن</p> -->
						<!-- <a href="">Cash on Delivery</a> -->
					</div>
					<table class="shop_table woocommerce-checkout-review-order-table">
						<tbody>
							<tr class="cart_item">
								<?php
									$order_items = $order->get_items();
									if(!empty($backorder_obj)){
										$backorder_items = $backorder_obj->get_items();
										$order_items     = array_merge($order_items, $backorder_items);
									}
                                    // Get ALL Colors Hexa Code 
                                    $ALL_Colors = get_terms([
                                        'taxonomy' => 'pa_color',
                                        'hide_empty' => false,
                                    ]);
									foreach($order_items as $item_id => $item){
										$product    = $item->get_product();
										$price      = $product->get_price();
										$product_id = $item->get_product_id();
										$data       = $item->get_data();    
                                        $arabic_fields = MD_product_widget_data($product_id , $language);
                                        
                                        //var_dump($product);
										// $order_items_data = array_map( );
										// $custom_field = get_post_meta( $product_id, '_tmcartepo_data', true);
										// print_r($data);
										?>
								<td class="product-name">
									<div class="product-thumb-name">
										<a href="<?php echo get_the_permalink($product_id);?><?php echo ($language == 'en')? '?lang=en':'' ?>"
											class="cart_pic">
											<?php 
												$product_img = get_the_post_thumbnail_url($product_id);
												if(empty($product_img)){
													$product_img = wc_placeholder_img_src('100');
												}
												?>
											<img width="300" height="300" src="<?php echo $product_img;?>"
												class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt=""
												sizes="(max-width: 300px) 100vw, 300px"></a>
										<div class="product-name-container">
											<div class="right">
												<!-- Product Name -->
												<?php 
                                                     $product_name = $product->get_name();
                                                    if(strpos($product_name , "-") !== false){
                                                        //$index = 
                                                        $product_name = substr($product_name , 0 , strpos($product_name , "-"));
                                                    }
                                                    ?>
												<h3 class="product-title"><?php echo $arabic_fields['name'] ; ?></h3>

												<?php 
                                                //Check if Product is Variable or Not 
                                                if( $product->is_type('variation') ){
                                                ?>
												<ul class="variations">
													<!-- ------- Variations HERE  ------------  -->
													<?php
                                                    	$variation_attributes = $product->get_variation_attributes();
                                                        // Loop through each selected attributes
                                                            foreach($variation_attributes as $attribute_taxonomy => $term_slug ){
                                                                $taxonomy = str_replace('attribute_', '', $attribute_taxonomy );
                                                                // The label name from the product attribute
                                                                $attribute_name = wc_attribute_label( $taxonomy, $product );
                                                                //var_dump($attribute_name); 
                                                                // if( taxonomy_exists($taxonomy) ) {
                                                                //     $attribute_value = get_term_by( 'slug', $term_slug, $taxonomy )->name;

                                                                // } else {
                                                                //     $attribute_value = $term_slug; // For custom product attributes
                                                                // }
                                                             
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

                                                                //var_dump($attribute_value);
                                                                ?>
													<li> <?php if($language == 'en'){echo $attribute_english ;}else{echo $attribute_arabic ;}  ?>
													</li>

													<?php 

                                                            }
                                                    
                                                    ?>

												</ul>
												<?php } // if Product Variable ?>

												<div class="prices">
													<div class="single-price">
														<p><span class="woocommerce-Price-amount amount">
																<?php if($product_id != 1730 && $product_id != 3065){  ?>
																<?php echo number_format($price);?>

																<span class="woocommerce-Price-currencySymbol">
																	<?php echo  $theme_settings['curren_currency_' . $language]  ?></span>
															</span> <?php }  ?> </p>
														<?php  echo number_format($item->get_subtotal()); ?>
														</p>
														<?php 
                                                         $regular_price = $product-> get_regular_price();
                                                        
                                                        ?>
														<?php// $Show_Sale_price = false ; ?>
														<?php //if($regular_price != $item->get_subtotal()) { ?>
														<?php //$Show_Sale_price = true ; ?>
														<!-- <p class="sale"> <?php//  echo $theme_settings['curren_currency_' . $language] .number_format($regular_price) ; ?> </p> -->
														<?php //} ?>

													</div>
													<div class="total-price" style="display:none;">
														<p>
															<?php  echo  number_format($item->get_subtotal()) . $theme_settings['curren_currency_' . $language]; ?>
														</p>
														<!-- <?php if($Show_Sale_price) { ?>
                                                        <p class="sale">  <?php echo $theme_settings['curren_currency_' . $language] .  number_format($item->get_quantity() * $regular_price ); ?> </p>
                                                        <?php } ?> -->
													</div>
												</div>
												<h4 class="quantity">
													<span><?php echo thankyou_translate('thanks_cart_quntity' , $language) ?>:</span>
													<?php echo $item->get_quantity();?>
												</h4>
											</div>

											<div class="left">
												<span class="woocommerce-Price-amount amount">
													<bdi>
														<?php if($product_id == '1730'){ 
                                                            
                                                                $selectedPrice = null;
                                                                $metaData = $item->get_meta_data();
                                                                
                                                                foreach ($metaData as $meta) {
                                                                    if ($meta->key === 'selected_price') {
                                                                        $selectedPrice = $meta->value;
                                                                        break;
                                                                    }
                                                                }
                                                                
                                                                echo $selectedPrice;
                                                                
                                                             } else if($product_id == 3065){
                                                                $selectedPrice = null;
                                                                $metaData = $item->get_meta_data();
                                                                
                                                                foreach ($metaData as $meta) {
                                                                    if ($meta->key === 'price') {
                                                                        $selectedPrice = $meta->value;
                                                                        break;
                                                                    }
                                                                }
                                                                
                                                                echo $selectedPrice;
                                                              }else{ 
                                                       echo $item->get_quantity() * $price;
                                                        }  ?>
														<span class="woocommerce-Price-currencySymbol">
															<?php echo $theme_settings['curren_currency_' .$language]; ?> </span>

													</bdi>
												</span>
											</div>
											<!-- <strong class="product-quantity">×&nbsp;1</strong> -->
										</div>
									</div>
								</td>
								<?php } ?>
							</tr>
							<tr class="order-price">
								<th><?php echo thankyou_translate('thanks_subtotal' , $language) ?></th>
								<td>
									<?php echo number_format($order->get_subtotal()).' '.$theme_settings['curren_currency_' .$language];?>
								</td>
							</tr>

							<?php if($order->get_used_coupons()) { ?>
							<tr class="order-delivery coupon">
								<th> <?php echo thankyou_translate('thanks_coupon' , $language) ?> </th>

								<td><?php echo $order->get_used_coupons()[0]; ?></td>
							</tr>
							<?php }  ?>

							<tr class="order-delivery">
								<th><?php echo thankyou_translate('thanks_shipping' , $language) ?></th>
								<td><?php echo ($order->get_shipping_total()).' '. $theme_settings['curren_currency_' .$language];?>
								</td>
							</tr>
							<?php if($order->get_total_fees() < 0){ ?>
							<tr class="order-total">
								<th>
									<?php if($language == 'en'){echo 'Pay Upon Delivery' ;}else{ echo 'المطلوب دفعه عند الاستلام ' ;} ?>
								</th>
								<td><?php echo ($order->get_total_fees() * -1 ).' '. $theme_settings['curren_currency_' .$language];?>
								</td>
							</tr>
							<?php }  ?>

						</tbody>
						<tfoot>

							</tr>




							<tr class="order-total">
								<th><?php echo thankyou_translate('thanks_total' , $language) ?></th>
								<td>
									<?php echo number_format($order->get_total() ). $theme_settings['curren_currency_' .$language]; ?>
									<p class="total_note"> <?php echo thankyou_translate('thanks_vat' , $language) ?></p>
								</td>

							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
    <?php // Enhanced Conversion ?>
    <script>
        var enhanced_conversion_data = {
            "email": '<?php echo $order->get_billing_email(); ?>'
        };
        gtag('set', 'user_data', {
            "email": '<?php echo $order->get_billing_email(); ?>',
        });
        gtag('event', 'conversion', {
            'send_to': 'AW-16491470480/QEU2CK3uypsZEJC937c9',
            'value': <?php echo $order->get_subtotal(); ?>,
            'currency': 'EGP',
            'transaction_id': <?php echo $order->get_order_number(); ?>
        });

    </script>


	<?php //include_once '../../theme-parts/home/trending-products.php';?>
	<?php// var_dump(get_template_directory()) ?>
	<?php endif; ?>
	<?php else : ?>
	<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received">
		<?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'woocommerce' ), null ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</p>
	<?php endif; ?>


</div>
<?php //include_once get_template_directory().'/theme-parts/home/trending-products.php' ?>