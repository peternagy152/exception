<div class="exstra_item">
  <?php
  $bought_products_data = array();
  $bought_together_ids  = array();
  if(!empty($single_product_data['extra_data']['bought_with_products'])){
    foreach($single_product_data['extra_data']['bought_with_products'] as $bought_product){
      $bought_together_ids[] = $bought_product['product'];
    }
  }else{
    $bought_together_prods = mitch_get_bought_together_products(array($single_product_data['main_data']->get_id()), $single_product_data['main_data']->get_id());
    if(!empty($bought_together_prods)){
      $bought_together_ids = array_slice($bought_together_prods, 0, 2);
    }
  }
  if(!empty($bought_together_ids)){
    ?>
    <label>يتم شرائة مع</label>
    <div class="item_view">
        <div class="items">
          <div class="active-item single_item" data-id="<?php echo $single_product_data['main_data']->get_id();?>" data-price="<?php echo $single_product_price;?>">
              <img src="<?php echo $single_product_data['images']['thumb'][0];?>" alt="<?php echo $single_product_data['main_data']->get_name();?>">
          </div>
          <?php
          $products_sum   = $single_product_price;
          $products_count = 0;
          foreach($bought_together_ids as $bought_together_id){
            $bought_product_obj = wc_get_product($bought_together_id);
            $bought_price_rate  = $bought_product_obj->get_price();
            // $bought_price_rate  = mitch_get_product_price_after_rate($bought_product_obj->get_price());
            $products_sum       = $products_sum + $bought_price_rate;
            $product_img        = wp_get_attachment_image_src(get_post_thumbnail_id($bought_product_obj->get_id()), 'thumbnail');
            if(!empty($product_img)){
              $product_img = $product_img[0];
            }else{
              $product_img = wp_get_attachment_image_src(get_post_thumbnail_id($bought_product_obj->get_parent_id()), 'thumbnail');
              if(!empty($product_img)){
                $product_img = $product_img[0];
              }
            }
            if(empty($product_img)){
              $product_img = $theme_settings['site_url'].'/wp-content/uploads/woocommerce-placeholder-100x100.png';
            }
            ?>
            <div class="active-item single_item bought_product_item_<?php echo $bought_product_obj->get_id();?>"
              data-id="<?php echo $bought_product_obj->get_id();?>"
              data-price="<?php echo $bought_price_rate;?>">
                <a target="_blank" href="<?php echo get_permalink($bought_product_obj->get_id());?>">
                  <img src="<?php echo $product_img;?>" alt="<?php echo $bought_product_obj->get_name();?>">
                </a>
            </div>
            <?php
            $bought_products_data[$products_count]['id']    = $bought_product_obj->get_id();
            $bought_products_data[$products_count]['price'] = $bought_price_rate;
            $bought_products_data[$products_count]['name']  = $bought_product_obj->get_name();
            $products_count++;
          }
          ?>
        </div>
        <div class="section_add">
          <p><span>السعر الكلي</span><?php echo '<strong id="total_bought">'.$products_sum.'</strong> '.$theme_settings['curren_currency_ar'];?></p>
          <button type="button" onclick="bought_together_products_add_to_cart();" id="add_bought_product">أضف الكل لعربة التسوق</button>
        </div>
    </div>
    <div class="item_select">
        <div class="form-checkbox">
            <div class="fixed_product form-checkbox-content">
               <input type="checkbox" class="checkbox-box" disabled checked data-id="<?php echo $single_product_data['main_data']->get_id();?>">
               <label>هذا المنتج: <?php echo $single_product_data['main_data']->get_name();?> (<?php echo $single_product_price.' '.$theme_settings['curren_currency_ar'];?>)</label>
            </div>
            <?php
            if(!empty($bought_products_data)){
              foreach($bought_products_data as $bought_product_data){
                ?>
                <div class="form-checkbox-content">
                   <input
                   id="btcheck_<?php echo $bought_product_data['id'];?>"
                   onchange="bought_item_change(<?php echo $bought_product_data['id'];?>, <?php echo $single_product_price;?>, <?php echo $bought_product_data['price'];?>);"
                   type="checkbox" class="checkbox-box" checked>
                   <label>
                     <a target="_blank" href="<?php echo get_permalink($bought_product_data['id']);?>">
                       <?php echo $bought_product_data['name'];?>
                       <span>(<?php echo $bought_product_data['price'];?> <?php echo $theme_settings['curren_currency_ar'];?>)</span>
                      </a>
                   </label>
                </div>
                <?php
              }
            }
            ?>
        </div>
    </div>
    <?php
  }
  ?>
</div>
