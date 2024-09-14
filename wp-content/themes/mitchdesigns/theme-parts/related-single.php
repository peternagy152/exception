<?php  if(get_field('has_products',$single_product_data['main_data']->get_id())):
      $products = get_field('products',$single_product_data['main_data']->get_id());
      if($products):
      ?>

<div class="product related single_related">
    <div class="grid">
        <div class="section_title">
          <h2><?php echo get_field('products_title',$single_product_data['main_data']->get_id());?></h2>
          <p><?php echo get_field('products_subtitle',$single_product_data['main_data']->get_id());?></p>
        </div>
        <div class="product_container">
          <div class="products_list">
            <?php foreach($products as $product_id):?>
            <div class="product_widget">
                <a class="product_widget_box" href="<?php echo get_the_permalink($product_id);?>">
                    <div class="img">
                      <img src="<?php echo get_the_post_thumbnail_url($product_id);?>" alt="IMAGE" />
                    </div>
                    <div class="text">
                      <div class="sec_color">
                        <div class="single_color">
                          <p></p>
                        </div>
                        <div class="single_color">
                          <p></p>
                        </div>
                        <div class="single_color">
                          <p></p>
                        </div>
                      </div>
                      <h3 class="title"><?php echo get_the_title($product_id);?></h3>
                      <div class="sec_info">
                        <p class="price"><?php echo get_post_meta( $product_id, '_price', true).' EGP';?></p>
                        <div class="size">
                            <div class="single_size">
                                <p>XS</p>
                            </div>
                            <div class="single_size">
                                <p>S</p>
                            </div>
                            <div class="single_size">
                                <p>M</p>
                            </div>
                            <div class="single_size">
                                <p>L</p>
                            </div>
                            <div class="single_size">
                                <p>XL</p>
                            </div>
                        </div>
                      </div>
                    </div>
                </a>
            
            </div>
            <?php endforeach;?>
          </div>
        
        </div>
    </div>
</div>
<?php endif; endif;?>
