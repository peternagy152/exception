<?php
 if(wp_is_mobile()){
  $number_of_products = 4 ;
  }else {
    $number_of_products = 8 ;
  }
?>
<div class="section_new">
	<div class="product home">
		<div class="product_container">
			<?php    $new_arrival_ids = mitch_get_new_arrival_products_ids($number_of_products);  ?>
			<ul class="products_list <?php if($number_of_products >= 5 ){echo 'slider_widget';}else{echo 'no_slider';}?>">
				<?php
         if(!empty($new_arrival_ids)){
           foreach($new_arrival_ids as $new_arrival_id){
            if($new_arrival_id == 1730 || $new_arrival_id == 3065)
            continue ;
             $product_data = mitch_get_short_product_data($new_arrival_id);
             include get_template_directory().'/theme-parts/product-widget.php';
           }
         }
        ?>

			</ul>
		</div>
	</div>
</div>