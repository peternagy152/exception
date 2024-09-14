<?php 
if(wp_is_mobile()){
    $number_of_products = 4 ;
}else {
    $number_of_products = 8 ;
}
$Add_Ons = mitch_get_products_by_category(59 , '','');
if(!empty($Add_Ons)){
    
    $count = 0 ;
   ?>
     <div class="product decorations">
        <div class="grid">
            <div class="head_w_Link">
                <div class="text">
                    <h4> <?php echo upsell_translations('addon_category', $language) ;?></h4>
                </div>
            </div>
            <div class="product_container ">
                <ul class="products_list <?php if($number_of_products >= 5 ){echo 'slider_widget';}else{echo 'no_slider';}?>">
                <?php
                foreach($Add_Ons as $one_Add) {
                    if($count >= $number_of_products )
                    break;
                    $product_data = mitch_get_short_product_data($one_Add); 
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


