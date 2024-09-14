<div class="sec_product_details">
    <div class="section_parent">
        <div class="product_details">
              <?php// if(!wp_is_mobile()){ ?>
                <div class="dropdown_info ">
                    <div class="single_info">
                      <h3 class="title_info"> <?php echo single_translate('long_desc' , $language); ?></h3>
                      <div class="content_info">
                        
                        <p><?php  echo $product_fields_data['desc']; // echo $single_product_data['main_data']->get_description();?></p>
                      </div>
                    </div>
                    <div class="single_info">
                      <h3 class="title_info"> <?php echo single_translate('retention_section' , $language); ?> </h3>
                      <div class="content_info"> 
                        <ul>
                          <li>تلقي طلبك في وقت مبكر اليوم!</li>
                         
                        </ul>
                      </div>
                    </div>

                  
                    <?php if(!empty($single_product_data['extra_data']['product_features'])){ ?>
                      <div class="single_info">
                        <h3 class="title_info">Details & Features</h3>
                        <div class="content_info">
                          <ul>
                            <?php
                            foreach($single_product_data['extra_data']['product_features'] as $feature_item){
                              ?>
                              <li><?php echo $feature_item['feature'];?></li>
                              <?php
                            }
                            ?>
                          </ul>
                        </div>
                      </div>

                    <?php } if(!empty($single_product_data['extra_data']['complete_the_look_products'])){ ?>
                      <div class="single_info">
                        <h3 class="title_info">Matching Products</h3>
                        <div class="content_info">
                          <ul class="widget">
                            <?php
                            foreach($single_product_data['extra_data']['complete_the_look_products'] as $product_obj){
                              $product_img_id  = get_post_thumbnail_id($product_obj['product']);
                              if(empty($product_img_id)){
                                continue;
                              }
                              $product_img = wp_get_attachment_image_src($product_img_id, 'single-post-thumbnail')[0];
                              ?>
                              <li>
                                <a href="<?php echo get_the_permalink($product_obj['product']);?>">
                                <img src="<?php echo $product_img;?>">
                                <h3><?php echo get_the_title($product_obj['product']);?></h3>
                                <p class="price">  <?php echo get_post_meta($product_obj['product'], '_price', true); ?>  <?php echo $theme_settings['curren_currency_ar'];?></p>
                                </a>
                              </li>
                              <?php
                            }
                            ?>
                          </ul>
                        </div>
                      </div>
                    <?php } ?>

                </div>
    </div>
</div>
