<?php
require_once 'header.php';
global $language;
  // if( $language == 'en') {
  //   $page_content = get_field('page_about_en');
  // } else {
  //   $page_content = get_field('page_about');
    
  // }
  // var_dump($page_content);
  // $sizes = get_all_heights("rectangle" , "30*40");
  // var_dump($sizes);
?>

<div id="page" class="site page_custom">
  <?php require_once 'theme-parts/main-menu.php';?>
  <!--start page-->
    <div class="site-content">
          <div class="section_page page_custom_cake">
              <div class="grid">
              <?php include_once 'theme-parts/custom-cake/steps-menu.php'; ?>
              <div class="all_step one active" id="section1">
                  <div class="grid">
                      <div class="container">
                          <div class="section_image">
                                  <!-- <div class="spriteContainer rectangle" ></div> -->
                                  <img id="cake_container" src="<?php $theme_settings['site_url']  ?>/cake_images_optimized/rectangle_white_c-white.webp" alt="">
                          </div>
                          <div class="section_data">
                                <div class="step one active" id="section1">
                                    <?php include_once 'theme-parts/custom-cake/step-one.php'; ?>
                                </div>
                                <div class="step two" id="section2">
                                    <?php include_once 'theme-parts/custom-cake/step-two.php'; ?>
                                </div>
                                <div class="step three" id="section3">
                                   <?php include_once 'theme-parts/custom-cake/step-three.php'; ?>
                                </div>
                                <div class="step four" id="section4">
                                  <?php include_once 'theme-parts/custom-cake/step-four.php'; ?>
                                </div>
                                <div class="step five" id="section5">
                                  <?php include_once 'theme-parts/custom-cake/step-five.php'; ?>
                                </div>
                                <div class="step six" id="section6">
                                  <?php include_once 'theme-parts/custom-cake/step-six.php'; ?>
                                </div>
                                <div class="step seven" id="section7">
                                  <?php include_once 'theme-parts/custom-cake/step-seven.php'; ?>
                                </div>
                                <div class="section_next">
                                  <div class="next">
                                    <button id="nextButton" class="btn_next "><?php if($language == 'en'){echo 'Next' ; }else{echo 'التالي' ;} ?></button>
                                    <a href="#popup-date" class="btn_next_pop js-popup-opener"><?php if($language == 'en'){echo 'Next' ; }else{echo 'التالي' ;} ?></a>
                                      <div class="price">
                                          <h6><?php if($language == 'en'){echo 'Total' ; }else{echo 'الاجمالي' ;} ?></h6>
                                          <p class = "total-cake-price"></p> <span><?php if($language == 'en'){echo 'EGP' ; }else{echo 'ج م' ;} ?></span> 
                                      </div>
                                  </div>
                                  <div class="prev">
                                      <button id="prevButton" class="btn_prev hidden_prev" class=""></button>
                                  </div>
                                  
                                </div>
                          </div>
                      </div>
                  </div>
              </div>








                     
                 
              </div>
          </div>
    </div>
    <?php require_once 'footer.php';?>
    <script src="<?php echo $theme_settings['theme_url'];?>/assets/js/customcake.js"></script>
    <script src="<?php echo $theme_settings['theme_url'];?>/assets/js/custom-cake-backend.js"></script>
</div>
  <!--end page-->
 


