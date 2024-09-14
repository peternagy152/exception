<?php global $theme_settings; global $product_data ;  $cart = WC()->cart->get_cart(); ?>
<div id="product_<?php echo $product_data['product_id'];?>_block" class="product_widget">
	<?php if(mitch_check_wishlist_product(get_current_user_id(), $product_data['product_id'])){ ?>
	<span class="fav_btn favourite"
		onclick="remove_product_from_wishlist(<?php echo $product_data['product_id'];?>, '<?php echo $wishlist_remove;?>');"></span>
	<?php }else{ ?>
	<span class="fav_btn not-favourite"
		onclick="add_product_to_wishlist(<?php echo $product_data['product_id'];?>);"></span>
	<?php } ?>
	<span class="label new">new</span>
	<?php /*}*/
  ?>
	<?php  
  if(isset($_GET['lang']) && $_GET['lang'] == 'en' ){
    $language = 'en';
  }
  ?>


	<?php $arabic_fields = MD_product_widget_data($product_data['product_id'] , $language ); ?>
	<?php $Excluded = false; ?>
	<?php if(!empty($arabic_fields['excluded'])){ ?>
	<?php if(isset($_COOKIE['branch_id'])){
      if(in_array($_COOKIE['branch_id'] , $arabic_fields['excluded'])){
        $Excluded = true;

      }

    }
  }
    ?>
	<a class="product_widget_box <?php if($Excluded){echo 'excluded' ;} ?> "
		href="<?php echo $product_data['product_url'];?><?php echo ($language == 'en')? '?lang=en':'' ?>">
		<div class="img <?php echo($product_data['product_flip_image'])? 'has-flip':'' ?>">
			<img class="original" src="<?php echo $product_data['product_image'];?>"
				alt="<?php echo $arabic_fields['image_alt']; ?>">
			<!-- <?php //if(!empty($product_data['product_flip_image'])){ ?>
          <img  class="flip" src="<?php //echo $product_data['product_flip_image'];?>" alt="">
          <?php //}?> -->
			<?php if($arabic_fields['widget_note'] && !empty($arabic_fields['widget_text'])){ ?>
			<span class="note_offers"> <?php echo $arabic_fields['widget_text']; ?></span>
			<?php }  ?>
		</div>
		<div class="sec_info">
			<div class="sec_top">
				<h3 class="title"><?php echo $arabic_fields['name'];?></h3>
				<h4 class="note_delivery"> <?php echo $arabic_fields['subtitle'] ?></h4>
			</div>
			<div class="sec_bottom">
				<div class="price">
					<p> <?php echo number_format($product_data['product_price']);?>
						<?php echo $theme_settings['curren_currency_' . $language];?></p>
					<?php if( $product_data['product_type'] == 'simple' && $product_data['product_is_sale_simple'] == 1 ){ ?>
					<span class="discount"> <?php echo $product_data['product_regular_price'] ?>
						<?php echo $theme_settings['curren_currency_' . $language]; ?> </span>
					<?php }else if($product_data['product_type'] != 'simple' && ($product_data['product_variable_regular_price'] != $product_data['product_price'])) {  ?>
					<span class="discount"> <?php echo $product_data['product_variable_regular_price'] ?>
						<?php echo $theme_settings['curren_currency_' . $language]; ?> </span>
					<?php }  ?>

				</div>
				<?php $product_cart_id = WC()->cart->generate_cart_id( $product_data['product_id'] ); ?>
				<?php $found_in_cart =  WC()->cart->find_product_in_cart( $product_cart_id ) ; ?>
				<div class="add_cart">
					<!-- check excluded -->
					<?php if($Excluded == false ){ ?>
					<!-- check simple or Variable -->
					<?php if($product_data['product_type'] == 'simple'){ ?>
					<?php if($product_data['product_stock_status'] == 'instock'){?>
					<span style="<?php if($found_in_cart){echo 'display:none;';}else{echo 'display:block;';} ?>"
						data-quantity="<?php if($found_in_cart){echo $cart[$product_cart_id]['quantity'] ;}else{echo '0' ;} ?>"
						class="icon_add  product_<?php echo  $product_data['product_id'] ;  ?>"
						data-product_type="<?php echo $product_data['product_type'] ;?>"
						data-product_id="<?php echo $product_data['product_id'] ?>">
						<img src="<?php echo $theme_settings['theme_url'];?>/assets/img/icons/add-cart.png"
							alt="<?php echo $arabic_fields['image_alt']; ?>" />
					</span>

					<div style=" <?php if($found_in_cart){echo 'display:flex;';}else{echo 'display:none;';} ?>"
						class="section_count product_<?php echo  $product_data['product_id'] ;  ?>">
						<button class="increase increase_<?php echo $product_data['product_id'] ?>" id=""
							onclick="increaseValue(<?php echo $product_data['product_id'] ?>)" value="Increase Value"></button>
						<input class="number_count number_<?php echo $product_data['product_id'] ?>" type="number" id=""
							value="<?php if($found_in_cart ){echo $cart[$product_cart_id]['quantity'] ;} ?>" data-min="1" disabled />
						<button
							class="decrease <?php if($found_in_cart){if($cart[$product_cart_id]['quantity'] == 1){echo 'disabled' ;}} ?> decrease_<?php echo $product_data['product_id'] ?>"
							id=""
							onclick="decreaseValue( '<?php echo  $product_cart_id?>' , <?php echo $product_data['product_id'] ?>)"
							value="Decrease Value"></button>
					</div>
					<?php } else { ?>
					<p class=" excluded_text"><?php echo ($language == 'en')? 'Out Of Stock' : 'غير متوفر ' ?></p>

					<?php }  ?>

					<?php } else {  // Variable Product ?>

					<p data-quantity="<?php if($found_in_cart){echo $cart[$product_cart_id]['quantity'] ;}else{echo '0' ;} ?>"
						class="icon_add variable  product_<?php echo  $product_data['product_id'] ;  ?>"
						data-product_type="<?php echo $product_data['product_type'] ;?>"
						data-product_id="<?php echo $product_data['product_id'] ?>">
						<!-- <img src="<?php //echo $theme_settings['theme_url'];?>/assets/img/icons/add-cart.png" alt="" /> -->
						<span> <?php if($language == 'en'){echo "View Product" ;}else {echo "اظهر المنتج" ;} ?></span>
					</p>
					<?php } } else { ?>
					<p class=" excluded_text"><?php echo ($language == 'en')? 'unavailable' : 'غير متوفر بالفرع  ' ?></p>
					<?php } ?>
				</div>
			</div>
		</div>
	</a>
</div>