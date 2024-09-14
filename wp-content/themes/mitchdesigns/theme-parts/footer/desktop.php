<?php $footer_builder = get_field('footer_builder_en', 'option'); ?>

<?php
global $language;

  if( $language == 'en') {
    $footer_builder = get_field('footer_builder_en', 'option');
  } else {
    $footer_builder = get_field('footer_builder_ar', 'option');
  }
// var_dump($page_content);
?>

<div class="section_footer">
  <div class="grid">
      <div class="top">
          <div class="section_start">
              <div class="logo">
                  <a href="<?php echo $theme_settings['site_url'];?><?php echo ($language == 'en')? '/?lang=en':'' ?>">
                      <?php if( $language == 'en') : ?>
                        <img src="<?php echo $theme_settings['logo_white_en'];?>" alt="">
                      <?php   else : ?>
                        <img src="<?php echo $theme_settings['logo_white'];?>" alt="">
                      <?php endif; ?>
                   
                  </a>
              </div>
              <div class="menu">
                      <?php
                      // echo '<pre>';
                      // var_dump($footer_builder);
                      // echo '</pre>';
                      if(!empty($footer_builder['footer_col_no_1']['items'])){
                        ?>
                        <ul class="single_menu">
                          <?php if($footer_builder['footer_col_no_1']['title'] ): ?>
                            <li><h5><?php echo $footer_builder['footer_col_no_1']['title'];?></h5></li>
                          <?php endif; ?>
                          <?php
                          foreach($footer_builder['footer_col_no_1']['items'] as $item_obj){
                            if($item_obj['type'] == 'page'){
                              $item_title = '';
                              $item_url   = $item_obj['page'];
                            }elseif($item_obj['type'] == 'category'){
                              $item_title = $item_obj['category']->name;
                              $item_url   = home_url('/product-category/'.$item_obj['category']->slug);
                            }
                            if(!empty($item_obj['custom_title'])){
                              $item_title = $item_obj['custom_title'];
                            }
                            ?>
                            <li>
                              <a href="<?php echo $item_url;?><?php echo ($language == 'en')? '?lang=en':'' ?>">
                                <?php echo $item_title;?>
                              </a>
                            </li>
                            <?php
                          }
                          ?>
                        </ul>
                        <?php
                      }
                      if(!empty($footer_builder['footer_col_no_2']['items'])){
                        ?>
                        <ul class="single_menu">
                          <li><h5><?php echo $footer_builder['footer_col_no_2']['title'];?></h5></li>
                          <?php
                              if(!empty($footer_builder['footer_col_no_2']['items'])){
                              foreach($footer_builder['footer_col_no_2']['items'] as $item_obj){
                              if($item_obj['type'] == 'page'){
                                $item_title = '';
                                $item_url   = $item_obj['page'];
                              }elseif($item_obj['type'] == 'category' && $item_obj['category']){
                                $item_title = $item_obj['category']->name;
                                $item_url   = home_url('/product-category/'.$item_obj['category']->slug);
                              }
                              if(!empty($item_obj['custom_title'])){
                                $item_title = $item_obj['custom_title'];
                              }
                              ?>
                              <li>
                                <a href="<?php echo $item_url;?><?php echo ($language == 'en')? '?lang=en':'' ?>">
                                  <?php echo $item_title;?>
                                </a>
                              </li>
                            <?php } } ?>
                              <li class="hotline_and_email">
                                <a class="hotline" href="tel:11687">
                                  16687
                                  <img src="<?php echo get_field('icon_call', 'options')  ?>" alt="" Width="20"; height="20";>
                                </a>
                                <a class="mail" href="mailto:info@exceptionpastry.com">
                                    info@exceptionpastry.com
                                </a>
                              </li>
                        </ul>
                        <?php
                      }
                      if(!empty($footer_builder['footer_col_no_3']['items'])){
                        ?>
                        <ul class="single_menu">
                              <li><h5><?php echo $footer_builder['footer_col_no_3']['title'];?></h5></li>
                                  <?php
                                    if(!empty($footer_builder['footer_col_no_3']['items'])){
                                    foreach($footer_builder['footer_col_no_3']['items'] as $item_obj){
                                    // var_dump($item_obj['page']);
                                    if($item_obj['type'] == 'page'){
                                      $item_title = '';
                                      $item_url   = $item_obj['page'];
                                    }elseif($item_obj['type'] == 'category'){
                                      $item_title = $item_obj['category']->name;
                                      $item_url   = home_url('/product-category/'.$item_obj['category']->slug);
                                    }
                                    if(!empty($item_obj['custom_title'])){
                                      $item_title = $item_obj['custom_title'];
                                    }
                                    if(!is_user_logged_in() && strpos($item_obj['page'], 'my-account') !== false){
                                  ?>
                              <li>
                                  <a class="title_myaccount login js-popup-opener" href="#popup-login">
                                    <?php echo $item_title;?>
                                  </a>
                              </li>
                              <?php }else{ ?>
                                <li>
                                  <a href="<?php echo $item_url;?>">
                                    <?php echo $item_title;?>
                                  </a>
                                </li>
                              <?php } } } ?> 
                        </ul>
                      <?php } ?>

              </div>
          </div>
          <div class="section_end">
                  <div class="section_info">
                    <img src="<?php echo $footer_builder['footer_col_no_4']['top_section_icon'];?>" alt="" width= "80"; height="80";>
                    <h4><?php echo $footer_builder['footer_col_no_4']['top_section_title'];?></h4>
                    <p><?php echo $footer_builder['footer_col_no_4']['top_section_content'];?></p>
                  </div>
                  <div class="company_social">
                        <form class="js-cm-form" id="subForm" action="https://www.createsend.com/t/subscribeerror?description=" method="post" data-id="5B5E7037DA78A748374AD499497E309EBD4FD93D83AE192A4077722EB77853D107B10944740F76D968E33B58EBF83194A3128205A62C43FCE1B98CB79001F4BA">
                              <input autocomplete="Email" aria-label="Email" class="js-cm-email-input qa-input-email" id="fieldEmail" maxlength="200" name="cm-bhhxdj-bhhxdj" required="" type="email" placeholder="<?php echo ($language == 'en')? 'Enter the email address':'أدخل عنوان البريد الالكتروني' ?>">
                          <button class="btn" type="submit"><?php echo ($language == 'en')? 'Subscribe':'أشترك' ?></button>
                        </form>
                      <script type="text/javascript" src="https://js.createsend1.com/javascript/copypastesubscribeformlogic.js"></script>
                  </div>
          </div>
      </div>
      <div class="bottom">
        <div class="mitchdesigns-logo">
              <a href="https://www.mitchdesigns.com/" target="_blank">
                  <div class="image">
                      <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/md-logo.png" alt="">
                  </div>
                  <p>Web Design by MitchDesigns</p>
              </a>
        </div>
        <div class="website_details">
          <img class="payment_icons" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/payments/payment_icons.png" alt="">
          <p class="copy_right">© <?php echo date('Y');?><?php echo ($language == 'en')? 'All Copyrights belong to Exception 2023 ':'جميع حقوق النشر تنتمي إلى إكسبشن ٢٠٢٣' ?> </p>
        </div>
       
         
      </div>
  
  </div>
</div>
