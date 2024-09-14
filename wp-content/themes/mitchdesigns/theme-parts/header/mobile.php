<?php
// Header Data 
$popup_content = get_field('main_nav_and_popup' , 'options');
// $Bottom_header = get_field('header_builder_en' , 'options');
//  $home_content = get_field('home_group_ar'); 


 global $language;

if( $language == 'en') {
  $header_items = get_field('header_builder_en', 'options');
  $top_header_items = get_field('top_header_en', 'options');
  $home_content = get_field('home_group_en'); 

} else {
  $header_items = get_field('header_builder_ar', 'options');
  $top_header_items = get_field('top_header', 'options');
  $home_content = get_field('home_group_ar'); 

}
?>
<div class="section_header_mobile">
    <div class="top-slider">
      <div class="grid">
        <div class="content">
          <div class="section_note">
            <img src="<?php echo get_field('icon', 'options')  ?>" alt="" width="16"; heghit="16">
              <?php 
                    //$top_header_items = get_field('top_header', 'options');
                    if(!empty($top_header_items)){
                    foreach($top_header_items as $top_header_item){
                ?>
                  <p> <?php echo $top_header_item['content']  ?></p> 
                <?php  } } ?>
          </div>
        </div>
      </div>
    </div>


    <?php if( strpos(($_SERVER['REQUEST_URI']) , 'myaccount')  == false){ ?>
    <div class="section_header_col_one">
        <div class="top_mobile">
            <div class="right">
                <div class="menu_button_mobile">
                    <button type="button" class="menu_mobile_icon open">
                         <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/icons/menu.png" alt="">
                    </button>
                    <button type="button" class="menu_mobile_icon close"> 
                        <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/icons/menu-close.png" alt="">
                    </button>
                </div>
                <div class="logo">
                    <a href="<?php echo $theme_settings['site_url'];?><?php echo ($language == 'en')? '/?lang=en':'' ?>">
                        <img src="<?php echo get_field('logo_mobile', 'options')  ?>" alt="">
                        <!-- <img src="<?php //echo $theme_settings['theme_url'];?>/assets/img/icons/Logo-fv.png" alt=""> -->
                    </a>
                </div>
            </div>

            
            <div class="left">
                <div class="section_branch">
                    <a class="bk_branch js-popup-opener" href="#select_location_popup">
                        <div class="branch_name">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icons/branch_name.png" alt="" width="15" height="15">
                            <?php $cookie_branch = 'branch_name_' .$language; ?>
                            <p> <?php if(isset($_COOKIE[$cookie_branch])){echo $_COOKIE[$cookie_branch] ; }else{  echo popup_translate('branch_popup_title' , $language) ;} ?></p>
                        </div>
                    </a>
                </div>
                <!-- <div class="section_lang">
                    <ul>
                        <li>
                            <?php //$current_url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>
                            <?php //$current_url = strtok($current_url, '?'); ?>
                            <?php //$current_english_url = $current_url . '?lang=en' ;?>
                            <?php //if( $language == 'en') :?>
                                <a href=" <?php //echo $current_url ?>" class="switcher-lnk" data-lang="english">
                                    <img src="<?php //echo get_stylesheet_directory_uri(); ?>/assets/img/country/egypt.png" alt="" width="25" height="15">
                                </a>
                            <?php //else:?>
                        
                                <a href=" <?php // echo $current_english_url?>"  class="switcher-lnk ar-font" data-lang="arabic">
                                    <img src="<?php //echo get_stylesheet_directory_uri(); ?>/assets/img/country/usa.png" alt="" width="25" height="15">
                                </a>
                            <?php //endif; ?>
                        </li>
                    </ul>
                </div> -->
                <!-- wishlist -->
                <!-- <?php //if(!is_user_logged_in()){ ?>
                    <div class="wishlist">
                        <a href="<?php //echo home_url('myaccount/user-login.php');?>" class="js-popup-opener"></a>
                    </div>
                <?php //} else { ?>
                    <div class="wishlist">
                        <a href="<?php //echo home_url('myaccount/wishlist.php');?>"></a>
                    </div>
                <?php  //} ?> -->
                
                <!-- Cart -->
                <?php if(!is_cart()){ ?>
                    <div class="cart">
                        <a href="#popup-min-cart" class="js-popup-opener">
                            <div class="section_icon_cart">
                            <?php //echo WC()->cart->get_total();?>
                            <span id="cart_total_count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                            <!-- <span id="cart_total"><?php //echo WC()->cart->get_cart_subtotal(); ?></span> -->
                            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/icons/cart.png" alt="">
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
            
        </div>
    </div>
    <?php } ?>


    <?php if( strpos(($_SERVER['REQUEST_URI']) , 'myaccount')  !== false){ ?>
    <div class="my-account-header">
        <div class="top_mobile">
            <div class="center">
                <div class="logo">
                    <a href="<?php echo $theme_settings['site_url'];?>">
                        <img src="<?php echo $theme_settings['logo_black'];?>" alt="">
                    </a>
                </div>
            </div>
            <div class="right">
                <a href="<?php echo $theme_settings['site_url'];?><?php echo ($language == 'en')? '/?lang=en':'' ?>" class="MD-btn-go"><?php echo ($language == 'en')? 'Home page':'الصفحة الرئيسية' ?></a>
            </div>
        </div>
    </div>
    <?php } ?>
  

    <div class="mobile-nav">
        <div class="section_nav">
            <div class="new_search search">
                <span class="icon_search"></span>
            </div>
            <ul class="main-menu" >
                    <?php
                        //$header_items = get_field('header_builder_ar', 'options');
                        if(!empty($header_items)){
                        $current_page_obj = get_queried_object();
                        foreach($header_items as $header_item){
                        $item_url = '';
                        $active   = '';
                        if($header_item['item_type'] == 'product_cat'){
                            // var_dump($header_item['url_product_cat']->term_id);
                            // var_dump($page_id);
                            // if(isset($current_page_obj->term_id) && $header_item['url_product_cat']->term_id == $current_page_obj->term_id){
                            // $active = 'active';
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
                            <li class="single_menu_mob has-mega">
                                <h5 class="category_link active<?php echo $active;?>">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icons/menu_all.png" alt="" width="20" height="20">
                                    <?php echo $header_item['item_name'];?>
                                </h5>
                                <div class="mega-menu active">
                                    <div class="box grid">
                                        <ul class="single_side menu">
                                            
                                                <?php //$home_content = get_field('home_group_ar'); ?>
                                                <?php //$header_items = get_field('header_builder_ar', 'options'); ?> 
                                                
                                                <?php   
                                                        foreach($header_items as $header_item){
                                                        if($header_item['item_group']['item_has_mega_dropdown']){
                                                        foreach($header_item['item_group']['mega_menu_options']['mega_menu_cols'] as $one_category){
                                                        $Link = $theme_settings['site_url'].'/product-category/' .  $one_category['item']->slug;
                                                ?>

                                                <li class="single_menu_list has-mega" >
                                                   <h6 class="link">
                                                        <img src="<?php echo $one_category['icon'] ?>" alt="">
                                                        <?php  if( $language == 'en') { ?>
                                                            <?php echo $one_category['item']->name; ?>
                                                        <?php } else { ?>
                                                            <?php echo  get_field('attribute_in_arabic', 'product_cat_'.$one_category['item']->term_id); ?>
                                                        <?php } ?>
                                                    </h6>
                                                    
                                                </li>


                                                <li class="single_menu_list_sub">
                                                    <div class="sub_cat">
                                                        <span class="back_menu_button">
                                                            <?php  if( $language == 'en') { ?>
                                                                <?php echo $one_category['item']->name; ?>
                                                            <?php } else { ?>
                                                                <?php echo  get_field('attribute_in_arabic', 'product_cat_'.$one_category['item']->term_id); ?>
                                                            <?php } ?>
                                                        </span>
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

                                            <?php }  }  } //$count_menu++;    // End Else ?>

                                            
                                        </ul>

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

                                        <?php if(!is_user_logged_in()){ ?>
                                            <div class="my_account">
                                                <a href="<?php echo home_url('myaccount/user-login.php');echo ($language == 'en')? '?lang=en':''?>" class="title_login">
                                                    <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/icons/login.png" alt="">
                                                    <span><?php echo ($language == 'en')? 'Sign in':'تسجيل الدخول' ?></span> 
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
                                    </div>
                                </div>
                            </li>
                        <?php }else{ ?>
                                <?php if($header_item['item_type'] == 'page'){  ?>
                                      <li class="single_menu_mob">
                                        <a href="<?php echo $header_item['url_page'];?><?php echo ($language == 'en')? '?lang=en':'' ?>"
                                          class="category_link 3 <?php echo $active;?>">
                                            <?php echo $header_item['item_name'];?>
                                        </a>
                                      </li>
                                  <?php } elseif($header_item['item_type'] == 'product_cat'){  
                                     $Link_menu_head = $theme_settings['site_url'].'/product-category/' .  $header_item['url_product_category']->slug;
                                    ?>
                                    
                                        <li class="single_menu_mob">
                                          <a href="<?php  echo $Link_menu_head;?><?php echo ($language == 'en')? '/?lang=en':'' ?>"
                                            class="category_link">
                                            <?php echo $header_item['item_name'];?>
                                          </a>
                                        </li>                                 
                        <?php } } } } ?>
                    
            </ul>
        </div>
    </div>

</div>
