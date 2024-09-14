<?php 
if(wp_is_mobile()){
    $number_of_products = 4 ;
}else {
    $number_of_products = 8 ;
}
$products_ids = mitch_get_products_list();
shuffle($products_ids); 
if(!empty($products_ids)){
    
    $count = 0 ;
    // $remaining_products = count($products_ids) - $number_of_products ;
   ?>
     <div class="product shop">
        <div class="grid">
            <div class="head_w_Link">
                <div class="text">
                    <h4> <?php echo upsell_translations('random_products', $language) ;?></h4>
                </div>
                <div class="btn_more">
                    <a href="<?php if($language=='en'){echo $theme_settings['site_url'] . '/shop?lang=en' ;}else{echo $theme_settings['site_url'] . '/shop' ;}?>"><?php echo upsell_translations('load_more_button', $language) ;?> </a>
                </div>
            </div>
            <div class="product_container">
                <ul class="products_list <?php if($number_of_products >= 5 ){echo 'slider_widget';}else{echo 'no_slider';}?>">
                <?php
                foreach($products_ids as $products_id) {
                    if($count >= $number_of_products )
                    break;
                    $product_data = mitch_get_short_product_data($products_id); 
                    include get_template_directory().'/theme-parts/product-widget.php';
                    $count++;
                }
                ?>
                </ul>
            </div>
        </div>
    </div>
    <?php 
}

