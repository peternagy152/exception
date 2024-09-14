<?php
require_once '../wp-content/themes/mitchdesigns/header.php';
mitch_validate_logged_in();
$WishLish_Products = mitch_get_wishlist_products(); 

?>
<div id="page" class="site">
<?php require_once '../wp-content/themes/mitchdesigns/theme-parts/main-menu.php';?>
    <!--start page-->
    <div class="site-content page_myaccount">
        <div class="grid">
            <div class="page_content">
                <div class="section_nav">
                    <div class="box_nav">
                        <?php include_once 'myaccount-sidebar.php';?>
                        <div class="section_title">
                            <span class="<?php echo strtolower( "Silver") ; ?>"><?php echo "Silver" ; ?></span>
                            <h3 class="name">
                                <?php echo get_user_meta($current_user->ID, 'first_name', true).' '.get_user_meta($current_user->ID, 'last_name', true);?>
                            </h3>
                        </div>
                    </div>
                    
                </div>
                <div class="dashbord">
                    <div class="wishlist">
                        <ul class="MD-breadcramb">
                            <li><a href="<?php echo home_url();?>"><?php echo Myaccount_translation('myaccount_pagination_home' , $language) ?></a></li>
                            <li><?php echo Myaccount_translation('myaccount_page_title' , $language) ?></li>
                            <li><?php echo Myaccount_translation('wishlist_page_title' , $language) ?></li>
                        </ul>
                        <h1 class="dashboard-title"><?php echo Myaccount_translation('wishlist_page_title' , $language) ?></h1>

                        <?php if(empty($WishLish_Products)){ ?>
                        <div class="empty-content">
                            <p><?php echo Myaccount_translation('Wishlist_no_items' , $language) ?></p>
                            <a href="<?php if($language == 'en'){echo $theme_settings['site_url'] . '/shop?lang=en';}else{echo $theme_settings['site_url'] . '/shop';} ?>" class="js-MD-popup-opener MD-btn-go"><?php echo Myaccount_translation('Orders_shop_now' , $language) ?></a>
                        </div>
                        <?php } else { ?>
                            <div class="product_container">
                                    <div class="products_list products">
                            
                                        <?php foreach($WishLish_Products as $one_product){ ?>
                                            <?php 
                                            $product_data = mitch_get_short_product_data($one_product -> product_id);
                                            if($language == 'en'){
                                                $product_name =  $product_data['product_title'] ;
                                            }else {
                                                $product_name = get_post_meta($product_data['product_id'] , 'product_data_arabic_title')[0];
                                            }
                                        //  var_dump($one_product -> product_id);
                                                ?>
                                        









                                        <?php global $theme_settings; global $product_data ;  $cart = WC()->cart->get_cart(); ?>
                                        <div id="product_<?php echo $product_data['product_id'];?>_block" class="product_widget">
                                                <?php if(mitch_check_wishlist_product(get_current_user_id(), $product_data['product_id'])){ ?>
                                                    <span class="fav_btn favourite" onclick="remove_product_from_wishlist(<?php echo $product_data['product_id'];?>, '<?php echo $wishlist_remove;?>');"></span>
                                                <?php }else{ ?>
                                                    <span class="fav_btn not-favourite" onclick="add_product_to_wishlist(<?php echo $product_data['product_id'];?>);"></span>
                                                <?php } ?>
                                                    <span class="label new">new</span>
                                                <?php /*}*/
                                                ?>
                                                <?php  
                                                if(isset($_GET['lang']) && $_GET['lang'] == 'en' ){
                                                    $language = 'en';
                                                }
                                                ?>

                                        
                                                        <?php $arabic_fields = MD_product_widget_data($product_data['product_id'] , $language ); ?>
                                                        <?php $Excluded = false; ?>
                                                        <?php if(!empty($arabic_fields['excluded'])){ ?>
                                                        <?php if(isset($_COOKIE['branch_id'])){
                                                            if(in_array($_COOKIE['branch_id'] , $arabic_fields['excluded'])){
                                                                $Excluded = true;

                                                            }

                                                            }
                                                        }
                                                            ?>
                                                    <a class="product_widget_box <?php if($Excluded){echo 'excluded' ;} ?> " href="<?php echo $product_data['product_url'];?><?php echo ($language == 'en')? '?lang=en':'' ?>">
                                                        <div class="img <?php echo($product_data['product_flip_image'])? 'has-flip':'' ?>">
                                                        <img class="original" src="<?php echo $product_data['product_image'];?>" alt="">
                                                        <!-- <?php //if(!empty($product_data['product_flip_image'])){ ?>
                                                        <img  class="flip" src="<?php //echo $product_data['product_flip_image'];?>" alt="">
                                                        <?php //}?> -->
                                                        <?php if($arabic_fields['widget_note'] && !empty($arabic_fields['widget_text'])){ ?>
                                                        <span class="note_offers">  <?php echo $arabic_fields['widget_text']; ?></span>
                                                        <?php }  ?>
                                                        </div>   
                                                        <div class="sec_info">
                                                        <div class="sec_top">
                                                            <h3 class="title"><?php echo $arabic_fields['name'];?></h3>
                                                            <h4 class="note_delivery"> <?php echo $arabic_fields['subtitle'] ?></h4>
                                                        </div>
                                                        <div class="sec_bottom">
                                                            <div class="price">
                                                                <p> <?php echo number_format($product_data['product_price']);?> <?php echo $theme_settings['curren_currency_' . $language];?></p>
                                                                <?php if( $product_data['product_type'] == 'simple' && $product_data['product_is_sale_simple'] == 1 ){ ?>
                                                                <span class="discount"> <?php echo $product_data['product_regular_price'] ?> <?php echo $theme_settings['curren_currency_' . $language]; ?>  </span>
                                                                <?php }else if($product_data['product_type'] != 'simple' && ($product_data['product_variable_regular_price'] != $product_data['product_price'])) {  ?>
                                                                <span class="discount"> <?php echo $product_data['product_variable_regular_price'] ?> <?php echo $theme_settings['curren_currency_' . $language]; ?>  </span>
                                                                <?php }  ?>
                                                                
                                                            </div>
                                                            <?php $product_cart_id = WC()->cart->generate_cart_id( $product_data['product_id'] ); ?>
                                                            <?php $found_in_cart =  WC()->cart->find_product_in_cart( $product_cart_id ) ; ?>
                                                            <div class="add_cart" >
                                                                <!-- check excluded -->
                                                            <?php if($Excluded == false ){ ?>
                                                                <!-- check simple or Variable -->
                                                                <?php if($product_data['product_type'] == 'simple'){ ?>
                                                                <span   style = "<?php if($found_in_cart){echo 'display:none;';}else{echo 'display:block;';} ?>" data-quantity  = "<?php if($found_in_cart){echo $cart[$product_cart_id]['quantity'] ;}else{echo '0' ;} ?>" class="icon_add  product_<?php echo  $product_data['product_id'] ;  ?>" data-product_type = "<?php echo $product_data['product_type'] ;?>" data-product_id = "<?php echo $product_data['product_id'] ?>">
                                                                    <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/icons/add-cart.png" alt="" />
                                                                </span>

                                                                <div style = " <?php if($found_in_cart){echo 'display:flex;';}else{echo 'display:none;';} ?>"class="section_count product_<?php echo  $product_data['product_id'] ;  ?>">
                                                                    <button class="increase increase_<?php echo $product_data['product_id'] ?>" id="" onclick="increaseValue(<?php echo $product_data['product_id'] ?>)" value="Increase Value"></button>
                                                                    <input class="number_count number_<?php echo $product_data['product_id'] ?>" type="number" id="" value="<?php if($found_in_cart ){echo $cart[$product_cart_id]['quantity'] ;} ?>" data-min="1" disabled  />
                                                                    <button class="decrease <?php if($found_in_cart){if($cart[$product_cart_id]['quantity'] == 1){echo 'disabled' ;}} ?> decrease_<?php echo $product_data['product_id'] ?>" id="" onclick="decreaseValue( '<?php echo  $product_cart_id?>' , <?php echo $product_data['product_id'] ?>)" value="Decrease Value"></button>
                                                                </div>

                                                                <?php } else {  // Variable Product ?>

                                                                    <p data-quantity  = "<?php if($found_in_cart){echo $cart[$product_cart_id]['quantity'] ;}else{echo '0' ;} ?>" class="icon_add variable  product_<?php echo  $product_data['product_id'] ;  ?>" data-product_type = "<?php echo $product_data['product_type'] ;?>" data-product_id = "<?php echo $product_data['product_id'] ?>">
                                                                        <!-- <img src="<?php //echo $theme_settings['theme_url'];?>/assets/img/icons/add-cart.png" alt="" /> -->
                                                                        <span> <?php if($language == 'en'){echo "View Product" ;}else {echo "اظهر المنتج" ;} ?></span>
                                                                    </p>
                                                                <?php } } else { ?>
                                                                    <p class=" excluded_text"><?php echo ($language == 'en')? 'unavailable' : 'غير متوفر ' ?></p>
                                                                <?php } ?>  
                                                            </div>
                                                        </div>
                                                        </div>
                                                    </a> 
                                        </div>








                                        <?php }  ?>
                                    </div>
                            </div>
                       
                        <?php } ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!--end page-->
    <?php require_once '../wp-content/themes/mitchdesigns/footer.php';?>