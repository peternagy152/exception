<?php
 if(wp_is_mobile()){
  $number_of_products = 4 ;
  }else {
    $number_of_products = 8 ;
  }
?>
<div class="section_best">

	<div class="product home">
		<div class="product_container">
			<?php   $best_selling_ids = mitch_get_best_selling_products_ids($number_of_products);  ?>
			<ul class="products_list <?php if($number_of_products >= 5 ){echo 'slider_widget';}else{echo 'no_slider';}?>">
				<?php 
              if(!empty($best_selling_ids)){
                foreach($best_selling_ids as $product_id){
                   if($product_id == 1730 || $product_id == 3065){continue;}
                $product_data = mitch_get_short_product_data($product_id);
                include get_template_directory().'/theme-parts/product-widget.php';
              }
                }
                // echo '<pre>';
                // var_dump($best_selling_ids);
                // echo '</pre>';
                ?>
				<!-- <a class="product_widget" href="">
                  <div class="product_widget_box">
                    <div class="img">
                        <img src="<?php// echo $theme_settings['theme_url'];?>/assets/img/pro_02.png" alt="">
                      </div>   
                      <div class="sec_info">
                        <h3 class="title">New York Times Custom</h3>
                        <h4 class="brand">Birthday Book</h4>
                        <p class="price">EGP 1100</p>
                      </div>
                  </div>
                </a>  -->
			</ul>
		</div>
	</div>
</div>