<div class="trending-products">
    <div class="title">
        <h2> Trending Products </h2>
    </div>
    <div class="products">
        <div class="top">
            <ul>
                <li class="trending" data-cat="featured">Featured</li>
                <li class="trending active" data-cat="arrivals">New Arrivals</li>
                <li class="trending" data-cat="best">Best Selling</li>
            </ul>
        </div>
        <div class="list">
            <?php  $category_products_ids = mitch_get_new_arrival_products_ids(6); ?>
            <div class="trending-container product_container">
                <div class="products_list">
                    <?php
                  if(!empty($category_products_ids)){
                    foreach($category_products_ids as $product_id){
                      $product_data = mitch_get_short_product_data($product_id);
                      ?>
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
                        <a class="product_widget_box" href="<?php echo $product_data['product_url'];?><?php echo ($language == 'en')? '?lang=en':'' ?>">
                            <div class="img <?php echo($product_data['product_flip_image'])? 'has-flip':'' ?>">
                                <img class="original" src="<?php echo $product_data['product_image'];?>" alt="">
                                <?php if(!empty($product_data['product_flip_image'])){ ?>
                                <img class="flip" src="<?php echo $product_data['product_flip_image'];?>" alt="">
                                <?php }?>
                            </div>
                            <div class="sec_info">
                                <h3 class="title"><?php echo $product_data['product_title'];?></h3>
                                <p class="price"><?php echo number_format($product_data['product_price']);?>
                                    <?php echo $theme_settings['curren_currency_ar'];?></p>
                            </div>
                        </a>
                    </div>
                    <?php 

                    }
                  }
                ?>
                </div>

            </div>

            <?php //include_once get_template_directory().'/theme-parts/upsell/best-selling.php';?>
        </div>
    </div>
</div>
