<?php
$page_title = 'No Results';
global $language;
require_once 'header.php';?>
<div id="page" class="site">
  <?php require_once 'theme-parts/main-menu.php';?>
  <!--start page-->
  <div class="site-content">
    <div class="grid">
      <div class="page-404">
          <!-- <h1>404</h1> -->
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icons/img_404.png" alt="">
          
          <p><?php echo ($language == 'en')? 'You’ve found a page that doesn’t exist':'الصفحة غير موجودة' ?></p>
          
          <span><?php echo ($language == 'en')? "The page you’re looking for may have been moved, removed, and possbile didn't exist at all" :'يبدو أن الصفحة التي تبحثي عنها غير موجودة، فما رأيك بالعودة إلى صفحتنا الرئيسية والبدء في التسوق من هناك' ?> </span>
          <a href="<?php echo $theme_settings['site_url'];?><?php echo ($language == 'en')? '/?lang=en':'' ?>">
          <?php echo ($language == 'en')? 'Go to Homepage': ' الصفحه الرئيسيه' ?>
            
          </a>
      </div>
    </div>
  </div>
  <!--end page-->
</div>
<?php require_once 'footer.php';?>
