<?php
//$single_product_price = mitch_get_product_price_after_rate($single_product_data['main_data']->get_price());
//$single_product_price = $single_product_data['main_data']->get_price();
// echo '<pre>';
// var_dump($single_product_data);
// echo '</pre>';
?>
<div class="sec_info">
	<div class="top">
		<?php  $rating_avg = $single_product_data['main_data']->get_average_rating(); ?>
		<div class="reviews-avg">
			<div class="first">
				<a href="#review-section"> <?php echo single_translate('show_reviews' , $language); ?> </a>
			</div>
			<div class="second">
				<!-- <h4>Reviews</h4> -->
				<p class="bold">
					<?php echo mitch_remove_decimal_from_rating($rating_avg);?>
				</p>
				<?php
                  // $rating_avg = 4.2;
                  mitch_get_reviews_stars($rating_avg);
                ?>

			</div>


		</div>


		<!-- <pre>
         <?php// var_dump($arabic_fields) ; ?>
       </pre> -->


		<div class="first">
			<h3 class="single_title_item"
				data-type="<?php if($product_fields_data['custom_cake']){echo 'custom' ;}else{echo 'normal' ;} ?>">
				<?php  echo $product_fields_data['name'] ;?>
			</h3>
			<div class="section_wishlist">
				<div class="link">
					<?php if(mitch_check_wishlist_product(get_current_user_id(), $single_product_data['main_data']->get_id())){?>
					<button
						onclick="remove_product_from_wishlist(<?php echo $single_product_data['main_data']->get_id();?>, '', 'yes')"
						class="remove-from-wishlist"></button>
					<?php }else{ ?>
					<button onclick="add_product_to_wishlist(<?php echo $single_product_data['main_data']->get_id();?>, 'yes')"
						class="add-to-wishlist"></button>
					<?php } ?>
				</div>
			</div>
		</div>

		<?php if($product_id == '1730'){ 
          $min_amount = get_field('almond_special_cake_price', 'options');
          $short_description = get_field('short_description_almond_special_cake', 'options');
          $short_description_en = get_field('short_description_almond_special_cake_en', 'options');
        } ?>

		<?php if ($product_id == '1730') { ?>
		<div class="content_description">
			<div class="description">
				<?php echo ($language == 'en')? $short_description_en : $short_description; ?>
			</div>
			<span class="btnn more">More</span>
			<span class="btnn less hidee">less</span>
		</div>
		<?php } else { ?>
		<div class="content_description">
			<div class="description">
				<?php 
              // echo $single_product_data['main_data']->get_short_description();
              echo  $product_fields_data['short_desc'] ;
              ?>
			</div>
			<span class="btnn more">More</span>
			<span class="btnn less hidee">less</span>
		</div>
		<?php } ?>



		<p id="product_price" class="price">
			<?php if ($product_id == '1730') { ?>
			<!-- (لا يقل المبلغ عن <?php  //echo $product_fields_data['amount_less'] ;?>) -->
			<?php }else{  ?>
			<?php echo number_format($single_product_data['main_data']->get_price());?>
			<?php echo $theme_settings['curren_currency_' . $language]; ?>
			<?php } ?>
			<?php
          if($single_product_data['main_data']->is_on_sale()){
            if($single_product_data['main_data']->get_type() == 'simple'){
              $product_price = $single_product_data['main_data']->get_regular_price();
            }else{
              if($single_product_data['main_data']->get_variation_regular_price('min', true) != $single_product_data['main_data']->get_price() )
              $product_price = $single_product_data['main_data']->get_variation_regular_price('min', true);
            }
            if(!empty($product_price)){
              ?>
			<span
				class="discount"><?php echo number_format($product_price).' '.$theme_settings['curren_currency_' . $language];?></span>
			<?php
            }
          }
          ?>
		</p>

		<span class="note_points">اشتري هذا المنتج واكسب 240 نقطة تعادل 24 جنيه!</span>

	</div>
	<div class="min_middle">
		<div class="first_min_middle">
			<?php

          if($single_product_data['main_data']->get_type() == 'variable'){


            // Parent Product ID 
            $var_product_id     = $single_product_data['main_data']->get_id();
            if( false){//$product_custom_fields['custom_cake']){
            $add_to_cart_button = '<button class="add_to_cart" id="variable_add_product_to_cart" onclick="custom_cake_add_to_cart('.$var_product_id.')"> <span>'.single_translate('add_to_cart',$language).' </span></button>';
            }else{
							
              $add_to_cart_button = '<button class="add_to_cart" id="variable_add_product_to_cart" onclick="variable_product_add_to_cart('.$var_product_id.')"> <span>'.single_translate('add_to_cart',$language).' </span></button>';
            }
            // Product Attributes 
            $default_attributes = $single_product_data['main_data']->get_default_attributes();
            if(empty($default_attributes)){
              $default_attributes = array();
            }

            $variations_attr    = array();
            $variations_data    = array();

            
            $product_attributes = $single_product_data['main_data']->get_attributes();
            $product_variations = $single_product_data['main_data']->get_available_variations();


            if(!empty($product_variations)){
              $slugs = wc_get_product_terms( $var_product_id, 'pa_size', array( 'fields' => 'all' ) );
              // echo '<pre>';
              // var_dump($slugs);
              // echo '</pre>';

                  foreach($product_variations as $variation_obj){
										//var_dump($variation_obj);
                      $variation_price = (float) $variation_obj['display_price'];
                      $variation_regular_price = (float) $variation_obj['display_regular_price'];
                      $variation_stock =  (int)$variation_obj['is_in_stock'] ; //(int) filter_var($variation_obj['availability_html'], FILTER_SANITIZE_NUMBER_INT) * -1;

                      foreach($variation_obj['attributes'] as $var_attr_key => $var_attr_value){
                          $variations_attr[] = mitch_get_product_attribute_name($var_attr_value);
                          
                          $variations_data[$var_attr_value] = array(
                              'price' => $variation_price,
                              'stock' => $variation_stock,
                              'regular_price' => $variation_regular_price ,
                          );
                      }
                  }
              }
           ;

            //$empty_color = 0;
            if(!empty($product_attributes)){

              foreach($product_attributes as $attribute_key => $attribute_arr){
                
                  ?>
			<div class="select_size section_size">
				<div class="second">
					<div class="sizes size" id="product_size">
						<?php
                        if(!empty($attribute_arr['options'])){
                          $count = 0;
                          foreach($attribute_arr['options'] as $option_id){
                            $active     = '';
                            $color_name = mitch_get_product_attribute_name_by_id($option_id);
                            $color_name_arabic =  get_term_meta($option_id, 'attribute_in_arabic', true);
                            if(isset($default_attributes[$attribute_key])){
                              if($default_attributes[$attribute_key] == sanitize_title($color_name)){
                                $active = 'active';
                              }
                            }
                            foreach($slugs as $slug){
                              if ($slug->term_id == $option_id) {
                                 $attribut_slug  = $slug->slug;
                                break;
                              }
                            }
                           // echo $attribut_slug ;
                            if(in_array($color_name, $variations_attr)){
                              $variation_data = $variations_data[$attribut_slug];
                                $variation_price = $variation_data['price'];
                                $variation_stock = $variation_data['stock'];
                                $var_regular_price = $variation_data['regular_price'];
                              ?>
						<div class="single_size variation_option <?php echo $active;?>"
							data-value="<?php echo sanitize_title($color_name);?>"
							data-key="<?php echo 'attribute_'.$attribute_key;?>" data-variable_price="<?php echo  $variation_price?>"
							data-sale_price="<?php echo $var_regular_price ; ?>" data-stock="<?php echo $variation_stock ;?>">
							<p><?php if($language == 'en'){echo $color_name ;}else{echo $color_name_arabic ;}?></p>
						</div>
						<?php
                              $count++;
                            }
                          }
                        }
                        ?>
					</div>
				</div>

			</div>
			<?php } } }else{
                   if($single_product_data['main_data']->get_stock_status() == 'outofstock') {
                        $add_to_cart_button = '<button class="add_to_cart disabled "  id="simple_add_product_to_cart"><span>'.single_translate('out_of_stock',$language).' </span></button>';
                   }else{
                      $add_to_cart_button = '<button class="add_to_cart " id="simple_add_product_to_cart"><span>'.single_translate('add_to_cart',$language).' </span></button>';

                   }
           
                  
                  ?>
			<input type="hidden" name="product_id" class="single_size active"
				value="<?php echo $single_product_data['main_data']->get_id();?>"
				data-product-id="<?php echo $single_product_data['main_data']->get_id();?>">
			<?php }
                  // var_dump($single_product_data['product_childs']);
                  // var_dump($product_attributes);
                  if(empty($single_product_data['product_childs']) && empty($product_attributes)){
                    ?>
			<style>
			.single_page .section_item .content .sec_info .min_middle .section_qty {
				border-top: unset;
				margin-top: 0px;
				padding-top: 0px;
			}
			</style>
			<?php  } ?>
			<!-- <a href="#size_guide_popup" class="link_size js-popup-opener">Size Guide</a> -->
		</div>

		<?php if( $product_fields_data['custom_cake']){  ?>
		<div class="cake_note">
			<div class="single_note">
				<h6> <?php if($language == 'en'){echo 'Add words on the cake' ; }else{echo 'أضف كلام على الكيكة' ;} ?> </h6>
				<textarea id="cake_text" name=""
					placeholder="<?php if($language == 'en'){echo 'Example : Happy Birthday' ;}else{echo 'مثال: عيد ميلاد سعيد' ;} ?>"></textarea>
			</div>
			<div class="single_note">
				<h6><?php if($language == 'en'){echo 'Add Notes' ;}else{echo 'اضف ملاحظة' ;} ?></h6>
				<textarea id="cake_notes" name=""
					placeholder="<?php if($language == 'en'){echo 'Add Notes' ;}else{echo 'اضف ملاحظة';} ?>"></textarea>
			</div>
		</div>
		<?php }  ?>


		<!-- check if product id == this show field amount_less_than -->
		<?php if ($product_id == '1730') { ?>
		<div class="min_total">
			<h6><?php echo ($language == 'en')? 'Payment value' : 'قيمه الدفع' ?>
				<span>( <?php echo ($language == 'en')? 'The amount is not less than' : 'لا يقل المبلغ عن' ?>
					<?php  echo $min_amount ;?> )</span>
			</h6>
			<input type="number" id="less_than" name="less_than" min="<?php  echo $min_amount ;?>"
				value="<?php  echo $min_amount ;?>">
		</div>
		<?php } ?>

		<!-- Stock Quantity To Lock Add To Cart  -->
		<div class="section_add_cart <?php if($Excluded){echo 'sec_excluded' ;} ?> ">
			<?php if($Excluded == false ){ ?>
			<div class="section_count">
				<button class="increase" id="increase" onclick="increaseOne()" value="Increase Value"></button>
				<input class="number_count" type="number" id="number" value="1" data-min="1" data-max="" />
				<button class="decrease disabled" id="decrease" onclick="decreaseOne()" value="Decrease Value"></button>
			</div>
			<!-- check excluded -->

			<?php  echo $add_to_cart_button; ?>

			<?php } else { ?>
			<p class=" excluded_text"><?php echo ($language == 'en')? 'unavailable' : 'غير متوفر ' ?></p>
			<?php } ?>
			<?php
          // if($single_product_data['main_data']->get_stock_quantity() > 0 || $single_product_data['main_data']->get_stock_status() == 'instock'){
           
          // }elseif(($single_product_data['main_data']->get_stock_quantity() <= 0 && $single_product_data['main_data']->backorders_allowed()) || isset($single_product_data['extra_data']['backorder_product'])){
          //   echo '<button class="add_to_cart" id="simple_add_product_to_cart">Pre Order</button>';
          // }else{
          //   echo '<button class="add_to_cart disabled" disabled>Out Of Stock</button>';
          // }
          // ?>

		</div>
		<div class="sec_shipping">
			<div class="text">
				<p> <?php echo single_translate('shipping_note',$language); ?>
				</p>
			</div>
		</div>




	</div>

	<?php include_once 'product-details.php';?>
</div>