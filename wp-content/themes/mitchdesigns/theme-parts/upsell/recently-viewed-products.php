<?php
//if(is_user_logged_in()){
  
  // var_dump($recently_viewed_products_ids);
    if(!empty($recently_viewed_products_ids)){
      if(wp_is_mobile()){
        $number_of_products = 4 ;
    }else {
        $number_of_products = 8 ;
    }
    $remaining_products = count($recently_viewed_products_ids) - $number_of_products ; 
    ?>
<div class="product recently">
	<div class="grid">
		<div class="head_w_Link">
			<div class="text">
				<h4><?php echo upsell_translations('recently_watched', $language) ;?></h4>
			</div>
		</div>
		<div class="product home">
			<div class="product_container">
				<ul
					class="products_list <?php if( count($recently_viewed_products_ids) >= 4){echo 'slider_widget';}else{echo 'no_slider';}?>">
					<?php
                  $count         = 0;
                  $count_same_id = 0;
                  foreach($recently_viewed_products_ids as $rv_product){
                    if($rv_product != get_the_ID() && $count <= $number_of_products ){
                      $product_data = mitch_get_short_product_data($rv_product); //->product_id
                      // include 'product-widget.php';
                      include get_template_directory().'/theme-parts/product-widget.php';
                    }else{
                      $count_same_id++;
                    }
                    $count++;
                  }
                  // var_dump($count);
                  // var_dump($count_same_id);
                  if($count == 1 && $count_same_id == 1){
                    ?>
					<style>
					.product.recently {
						display: none;
					}
					</style>
					<?php 
                  }
                  ?>
				</ul>
			</div>
		</div>
	</div>
</div>
<?php
  }
//}
?>