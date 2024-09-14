<div class="section_accessories">
    <div class="grid">
        <div class="section_title">
            <h3>
              <p><?php echo $fixed_string['section_accessories_title1'];?></p>
              <?php echo $fixed_string['section_accessories_title2'];?>
             </h3>
        </div>
        <div class="accessories_container">
            <ul class="accessoriess_list">
            <?php
            $products_count        = 0;
            $category_products_ids = mitch_get_products_by_category(41,'');
            if(!empty($category_products_ids)){
              foreach($category_products_ids as $cat_product_id){
                if($products_count <= 2){
                  $cat_product_data = mitch_get_short_product_data($cat_product_id);
                  ?>
                  <li class="accessories_widget">
                      <a href="<?php echo $cat_product_data['product_url'];?>" class="accessories_widget_box">
                          <div class="img">
                              <img src="<?php echo $cat_product_data['product_image'];?>" alt="<?php echo $cat_product_data['product_title'];?>">
                          </div>
                          <div class="text">
                              <h3 class="title"><?php echo $cat_product_data['product_title'];?></h3>
                              <p class="price"><?php echo $cat_product_data['product_price'];?> <?php echo $theme_settings['curren_currency_ar'];?></p>
                          </div>
                      </a>
                  </li>
                  <?php
                }
                $products_count++;
              }
            }
            ?>
            </ul>
        </div>
    </div>
</div>
