<?php //delete_post_meta(32499, 'products_prices_list'); 

global $language ;

if( $language == 'en') {
  $header_items = get_field('header_builder_en', 'options');
} else {
  $header_items = get_field('header_builder_ar', 'options');
}
?>
<div class="section_header">
    <div class="top-slider">
      <div class="grid">
        <div class="content">
          <div class="section_note">
            <img src="<?php echo get_field('icon', 'options')  ?>" alt="" width="16"; heghit="16">
              <?php 
                    if( $language == 'en') {
                      $top_header_items = get_field('top_header_en', 'options');
                    } else {
                      $top_header_items = get_field('top_header', 'options');
                    }
                    if(!empty($top_header_items)){
                    foreach($top_header_items as $top_header_item){
                ?>
                  <p> <?php echo $top_header_item['content']  ?></p> 
                <?php  } } ?>
          </div>
          <div class="support_menu">
              <nav class="main_nav_support">
                <ul class="main_menu_support" >
                        <?php
                         $header_support = get_field('header_support', 'options');
                          if(!empty($header_support)){
                          $current_page_obj = get_queried_object();
                          foreach($header_support as $header_item_support){
                          $item_url = '';
                          $active   = '';
                        ?>
                              <li class="single_menu">
                                <a href="<?php echo $header_item_support['url_page'];?><?php echo ($language == 'en')? '?lang=en':'' ?>" class="link <?php echo $active;?>">
                                  <?php if( $language == 'en') { ?>
                                      <?php echo $header_item_support['item_name_en'];?>
                                  <?php } else { ?>
                                      <?php echo $header_item_support['item_name_ar'];?>
                                   <?php } ?>
                                </a>
                              </li>
                        <?php  } } ?>
                            
                </ul>
              </nav>
              <div class="section_lang">
                <ul>
                  <li class="text">
                      <?php $current_url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>
                      <?php $current_url = strtok($current_url, '?'); ?>
                      <?php $current_english_url = $current_url . '?lang=en' ;?>
                      <?php if( $language == 'en') :?>
                        <button href= " <?php echo $current_url ?>" onclick=' Set_language_cookie("<?php echo $current_url ?>" , "ar")' class="switcher-lnk" data-lang="english"> العربية</button>
                      <?php else:?>
                        <button href=" <?php  echo $current_english_url?>"  onclick=' Set_language_cookie("<?php echo $current_english_url ?>" , "en")' class="switcher-lnk ar-font" data-lang="arabic">English</button>
                      <?php endif; ?>
                  </li>
                </ul>
              </div>
              <div class="section_call">
                <a href="tel:<?php echo get_field('phone', 'options')  ?>"><?php echo get_field('phone', 'options')  ?></a>
                <img src="<?php echo get_field('icon_call', 'options')  ?>" alt="" Width="13"; height="13";>
              </div>
          </div>
        </div>
      </div>
    </div>
    <div class="section_header_col_one">
      <div class="grid">
        <div class="content">
          <div class="sec_right">
            <div class="logo">
                  <a href="<?php echo $theme_settings['site_url'];?><?php echo ($language == 'en')? '/?lang=en':'' ?>">
                  
                    <?php if( $language == 'en') : ?>
                      <img src="<?php echo $theme_settings['logo_black_en'];?>" alt="">
                      <?php   else : ?>
                        <img src="<?php echo $theme_settings['logo_black'];?>" alt="">
                      <?php endif; ?>
                  </a>
            </div>
            <div class="section_branch">
              <a  class="bk_branch js-popup-opener" href="#select_location_popup">
                <div class="branch_name">
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icons/branch_name.png" alt="" width="15" height="15">
                  <?php $cookie_branch = 'branch_name_' .$language; ?>
                  <p> <?php if(isset($_COOKIE[$cookie_branch])){echo $_COOKIE[$cookie_branch] ; }else{  echo popup_translate('branch_popup_title' , $language) ;} ?></p>
                </div>
              </a>
            </div>
            <div class="new_search search">
                <span class="icon_search"></span>
            </div>
          </div>
          <div class="sec_left">

            <!-- wishlist  -->
              <?php if(!is_user_logged_in()){ ?>
                  <div class="wishlist">
                      <a href="<?php echo home_url('myaccount/user-login.php');?>"  class="js-popup-opener"></a>
                  </div>
                  <?php } else { ?>
                    <div class="wishlist">
                      <a href="<?php echo home_url('myaccount/wishlist.php');echo ($language == 'en')? '?lang=en':''?>"></a>
                  </div>
              <?php  } ?>

              <!-- my_account  -->
              <?php if(!is_user_logged_in()){ ?>
                <div class="my_account">
                    <a href="<?php echo home_url('myaccount/user-login.php');echo ($language == 'en')? '?lang=en':''?>" class="title_login">
                        <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/icons/login.png" alt="">
                    </a>
                </div>
              <?php } else { ?>
                <div class="my_account">
                    <a href="<?php echo home_url('myaccount');echo ($language == 'en')? '?lang=en':''?>" class="title_login">
                        <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/icons/login.png" alt="">
                        <span><?php echo ($language == 'en')? 'MyAccount':'حسابي' ?></span> 
                    </a>
                </div>
              <?php } ?>

              <!-- cart  -->
              <?php if(!is_cart()){ ?>
                <div class="cart">
                  <a href="#popup-min-cart" class="js-popup-opener">
                    <div class="section_icon_cart">
                      <span class=" header_total total">
                        <?php echo number_format(WC()->cart->cart_contents_total ,2);?> 
                        <?php //echo $theme_settings['current_currency_'.$language];?>
                      </span>
                      <span id="cart_total_count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                      <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/icons/cart.png" alt="">
                    </div>
                  </a>
                </div>
              <?php  } ?>
          </div>
        </div>
      </div>
    </div>
    <div class="section_header_col_three sticky">
        <div class="grid">
            <div class="section_bottom">
              <nav class="main-nav">
                <ul class="main-menu" >
                            <?php
                                // $header_items = get_field('header_builder_ar', 'options');
                                if(!empty($header_items)){
                                $current_page_obj = get_queried_object();
                                foreach($header_items as $header_item){
                                
                                $item_url = '';
                                $active   = '';
                                    if($header_item['item_type'] == 'product_cat'){
                                      // var_dump($header_item['url_product_cat']->term_id);
                                      // var_dump($page_id);
                                      // if(isset($current_page_obj->term_id) && $header_item['url_product_cat']->term_id == $current_page_obj->term_id){
                                      //   $active = 'active';
                                      // }
                                    }else{
                                      if(isset($current_page_obj->post_title) && $header_item['item_name'] == $current_page_obj->post_title){
                                        $active = 'active';
                                      }
                                    }
                                    // if($header_item['item_type'] == 'product_cat'){
                                    //   $item_url = home_url('product-category/'.$header_item['url_product_cat']->slug);
                                    // }elseif($header_item['item_type'] == 'page'){
                                    //   $item_url = $header_item['url_page'];
                                    // }
                                    if($header_item['item_group']['item_has_mega_dropdown']){
                                      ?>
                                      <li class="single_menu has-mega">
                                          <a href="<?php echo $item_url;?>" class="category_link 1 <?php echo $active;?>">
                                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icons/menu_all.png" alt="" width="20" height="20">
                                            <?php echo $header_item['item_name'];?>
                                          </a>
                                          <div class="mega-menu">
                                            <div class="box grid">
                                              <div class="header_content">
                                                  <div class="col one">
                                                      <div class="nav_menu">
                                                            <ul class="single_side menu">
                                                              
                                                                  <?php //$home_content = get_field('home_group_ar'); ?>
                                                                  <?php //$header_items = get_field('header_builder_ar', 'options'); ?> 
                                                                  
                                                                  <?php   
                                                                          $count_menu= 1;
                                                                          foreach($header_items as $header_item){
                                                                          if($header_item['item_group']['item_has_mega_dropdown']){
                                                                          foreach($header_item['item_group']['mega_menu_options']['mega_menu_cols'] as $one_category){
                                                                          $Link = $theme_settings['site_url'].'/product-category/' .  $one_category['item']->slug;
                                                                  ?>

                                                                    <li class="single_menu_list has-mega menu_<?php echo $count_menu; ?> <?php echo $count_menu == 1 ? 'active' : ''; ?>" data-menu="menu_<?php echo $count_menu ?>">
                                                                        <a class="link" href="<?php echo $Link;  ?><?php echo ($language == 'en')? '/?lang=en':'' ?>">
                                                                            <img src="<?php echo $one_category['icon'] ?>" alt="">
                                                                            <?php //echo  get_field('attribute_in_arabic', 'product_cat_'.$one_category['item']->term_id); ?>
                                                                            
                                                                            <?php  if( $language == 'en') { ?>
                                                                              <?php echo $one_category['item']->name; ?>
                                                                              <?php } else { ?>
                                                                                <?php echo  get_field('attribute_in_arabic', 'product_cat_'.$one_category['item']->term_id); ?>
                                                                            <?php } ?>

                                                                        </a>
                                                                    </li>


                                                                    <li class="single_menu_list_sub menu_<?php echo $count_menu; ?> <?php echo $count_menu == 1 ? 'active' : ''; ?>">
                                                                        <div class="sub_cat">
                                                                            <ul>
                                                                                <?php 
                                                                                    $termchildren = get_terms('product_cat',array('child_of' => $one_category['item']->term_id));
                                                                                    
                                                                                    foreach($termchildren as $child){
                                                                                    
                                                                                ?>
                                                                                      <li class="mega_menu_link">
                                                                                          <a class="link_menu" href="<?php echo $Link ?>/<?php echo $child->slug ?><?php echo ($language == 'en')? '/?lang=en':'' ?>"> 
                                                                                              <?php  if( $language == 'en') { ?>
                                                                                                <?php echo $child->name; ?>
                                                                                              <?php } else { ?>
                                                                                                <?php echo get_field('attribute_in_arabic', 'product_cat_'.$child->term_id); ?>
                                                                                              <?php } ?>
                                                                                            
                                                                                          </a>
                                                                                      </li>
                                                                                <?php } ?>
                                                                            </ul>
                                                                        </div>
                                                                    </li>

                                                                    <li class="single_menu_list_img has-mega menu_<?php echo $count_menu; ?> <?php echo $count_menu == 1 ? 'active' : ''; ?>">
                                                                        <div class="sec_img">
                                                                            <img src="<?php echo $one_category['hover_image'] ?>" alt="">
                                                                        </div>
                                                                    </li>

                                                                <?php $count_menu++;  }   }  }  // End Else ?>

                                                            </ul>
                                                      </div>
                                                  </div>
                                                  <div class="col two">
                                                      
                                                  </div>
                                                  <div class="col three">
                                                      <!-- <img src="<?php //echo get_stylesheet_directory_uri(); ?>/assets/img/menu-cat.webp" alt="">                   -->
                                                  </div>
                                              </div>
                                            </div>
                                          </div>
                                      </li>
                              
                                    <?php }else{ ?>


                                  <?php if($header_item['item_type'] == 'page'){  ?>
                                      <li class="single_menu">
                                        <a href="<?php echo $header_item['url_page'];?><?php echo ($language == 'en')? '?lang=en':'' ?>"
                                          class="category_link 3 <?php echo $active;?>">
                                            <?php echo $header_item['item_name'];?>
                                        </a>
                                      </li>
                                  <?php } elseif($header_item['item_type'] == 'product_cat'){  
                                     $Link_menu_head = $theme_settings['site_url'].'/product-category/' .  $header_item['url_product_category']->slug;
                                    ?>
                                    
                                        <li class="single_menu">
                                          <a href="<?php  echo $Link_menu_head;?><?php echo ($language == 'en')? '/?lang=en':'' ?>"
                                            class="category_link">
                                            <?php echo $header_item['item_name'];?>
                                          </a>
                                        </li>                                 
                                <?php } } } } ?>
                            
                </ul>
              </nav>
            </div>
        </div>
    </div>
</div>