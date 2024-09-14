<?php
    if($single_product_data['main_data']->get_type() == 'simple'){
    ?>
    <div class="section_count">
        <button class="increase" id="increase" onclick="increaseValue()" value="Increase Value"></button>
        <input class="number_count" type="number" id="number" value="1" />
        <button class="decrease" id="decrease" onclick="decreaseValue()" value="Decrease Value"></button>
    </div>
    <p class="price"><?php echo number_format($single_product_price, 2);?> <?php echo $theme_settings['curren_currency_ar'];?></p>
    <button type="button" onclick="simple_product_add_to_cart(<?php echo $single_product_data['main_data']->get_id();?>);">
        <?php echo $fixed_string['product_single_page_add_to_cart'];?>
    </button>
    <?php
    }elseif($single_product_data['main_data']->get_type() == 'variable'){
        
        $default_attributes = $single_product_data['main_data']->get_default_attributes();
        if(empty($default_attributes)){
            $default_attributes = array();
        }
        $variations_attr    = array();
        $variations_data    = array();

        $product_attributes = $single_product_data['main_data']->get_attributes();
        $product_variations = $single_product_data['main_data']->get_available_variations();

        if(!empty($product_variations)){
            foreach($product_variations as $variation_obj){
                $variation_price = (float) $variation_obj['display_price'];
                $variation_stock = (int) filter_var($variation_obj['availability_html'], FILTER_SANITIZE_NUMBER_INT) * -1;

                foreach($variation_obj['attributes'] as $var_attr_key => $var_attr_value){
                    $variations_attr[] = mitch_get_product_attribute_name($var_attr_value);
                    
                    $variations_data[$var_attr_value] = array(
                        'price' => $variation_price,
                        'stock' => $variation_stock
                    );
                }
            }
        }

        if(!empty($product_attributes)){
            foreach($product_attributes as $attribute_key => $attribute_arr){

            $attribute_name = str_replace('pa_', '', $attribute_arr['name']);
            if($attribute_key == 'pa_color'){
                ?>
                <div class="section_color">
                <label><?php echo $fixed_string[$attribute_name];?></label>
                <div class="colores" id="color_option">
                    <div class="select_arrow">
                    <select id="variations_colors_select">
                        <?php
                        if(!empty($attribute_arr['options'])){
                            $count = 0;
                            foreach($attribute_arr['options'] as $option_id){
                                // echo '<pre>';
                                // var_dump($option_id);
                                // echo '</pre>'; 
                                $active       = '';
                                $color_code   = get_field('color_hex_code', 'term_'.$option_id.'');
                                $color_name   = mitch_get_product_attribute_name_by_id($option_id);
                                $color_name_s = sanitize_title($color_name);
                                if(isset($default_attributes['pa_color'])){
                                    if($default_attributes['pa_color'] ==  $color_name_s){
                                        $active = 'selected';
                                    }
                                }
                                // if(empty($active) && $count == 0){
                                //   $active = 'active';
                                // }
                                if(in_array($color_name, $variations_attr)){
                                    $variation_data = $variations_data[$color_name_s];
                                    if(!empty($variation_data)){
                                        $variation_price = ($variation_data['price']);
                                        $variation_stock = $variation_data['stock'];
                                    }else{
                                        $variation_price = 0;
                                        $variation_stock = 0;
                                    }
                                    ?>
                                    <option class="variation_option" <?php echo $active; ?> 
                                    value="<?php echo $color_name;?>" 
                                    data-price="<?php echo $variation_price;?>" 
                                    data-price-format="<?php echo number_format($variation_price, 2);?>"
                                    data-stock="<?php echo $variation_stock;?>"
                                    data-value="<?php echo $color_name_s;?>" 
                                    data-key="<?php echo 'attribute_'.$attribute_key;?>">
                                        <?php echo $color_name;?>
                                    </option>
                                    <?php
                                    $count++;
                                }
                            }
                        }
                        ?>
                    </select>
                    </div>
                </div>
                </div>
                <?php
            }else{
                ?>
                <?php
                $new_options_ordering = array();
                foreach($attribute_arr['options'] as $row_option_id){
                    $new_options_ordering[get_field('size_ordering', 'term_'.$row_option_id.'')] = $row_option_id;
                }                
                ksort($new_options_ordering);
               

                if(!empty($attribute_arr['options'])){
                    $count = 0;
                    $number_of_cols = count($attribute_arr['options']);
                    if(count($new_options_ordering) == 1){
                        ?>
                        <style>
                            .slick-track{width:100% !important;}
                        </style>
                        <?php 
                    }
                    ?>
                    <div class="select_size">
                        <label><?php echo $fixed_string[$attribute_name];?></label>
                        <div class="sizes <?php //echo ($number_of_cols > 3) ? ' size_slick' : ''; ?>" id="variations_sizes_select">
                            <div class="all">
                            <?php
                            foreach($new_options_ordering as $key => $option_id){ //$attribute_arr['options']
                                        $active      = '';
                                        $size_name   = mitch_get_product_attribute_name_by_id($option_id);
                                        $size_name_s = sanitize_title($size_name);
                                        if(isset($default_attributes[$attribute_key])){
                                            if($default_attributes[$attribute_key] == $size_name_s){
                                                $active = 'active';
                                            }
                                        }

                                if(in_array($size_name, $variations_attr)){
                                    $variation_data = $variations_data[$size_name_s];
                                    if(!empty($variation_data)){
                                        $variation_price = ($variation_data['price']);
                                        $variation_stock = $variation_data['stock'];
                                    }else{
                                        $variation_price = 0;
                                        $variation_stock = 0;
                                    }
                                    ?>
                                    <div class="single_size variation_option  <?php echo $active;?>" 
                                            data-price="<?php echo $variation_price;?>" 
                                            data-price-format="<?php echo number_format($variation_price, 2);?>"
                                            data-stock="<?php echo $variation_stock;?>"
                                            data-value="<?php echo $size_name_s;?>" 
                                            data-key="<?php echo 'attribute_'.$attribute_key;?>">
                                        <span><?php echo $size_name;?></span>
                                    </div>
                                <?php $count++; } } } ?>
                            </div>
                          
                        </div>
                    </div>
                    <?php
                }
            }
        }
        ?>
        <div class="section_count">
            <button class="increase" id="increase" onclick="increaseValue()" value="Increase Value"></button>
            <input class="number_count" type="number" id="number" value="1" />
            <button class="decrease" id="decrease" onclick="decreaseValue()" value="Decrease Value"></button>
        </div>
        <p class="price">
            <span id="product_price"><?php echo number_format($single_product_price, 2);?></span> 
            <?php echo $theme_settings['curren_currency_ar'];?>
        </p>
        <button id="variable_product_add_to_cart" onclick="variable_product_add_to_cart(<?php echo $single_product_data['main_data']->get_id();?>);" type="button">
            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/icons/cart_white.png" alt="">
            <?php echo $fixed_string['product_single_page_add_to_cart'];?>
        </button>
        <?php
    }
?>