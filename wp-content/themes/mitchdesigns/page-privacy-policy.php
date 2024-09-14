<?php
require_once 'header.php';
//$page_content = get_field('about_page');
// var_dump($page_content);
global $language;

  if( $language == 'en') {
    $page_terms = get_field('head_en');
  } else {
    $page_terms = get_field('head');
  }
?>


<div id="page" class="site">
  <?php require_once 'theme-parts/main-menu.php';?>
  <!--start page-->
    <div class="site-content style_page_form">
      <div class="grid">
        <div class="page_nav_menu">
            <?php //require_once 'theme-parts/pages-sidebar.php';?>
            <div class="section_page content privacy">
              <div class="section_title">
                <div class="title">
                  <ul>
                    <li>
                        <a href="<?php echo $theme_settings['site_url'];?><?php echo ($language == 'en')? '/?lang=en':'' ?>">
                          <?php echo ($language == 'en')? 'Home':'الرئيسية' ?>
                        </a>
                    </li>
                    <li>
                        <h5><?php echo $page_terms['title'] ?></h5>
                    </li>
                  </ul>
                  <h1><?php echo $page_terms['title'] ?></h1>
                </div>
              </div>  
              <div class="page-content">
                <?php if( $language == 'en') { ?>
                   <?php echo get_field('content_en') ?>
                 <?php } else { ?>
                    <?php the_content();?>
                 <?php } ?>
              </div>
            </div>
        </div>
      </div>
    </div>
</div>
  <!--end page-->
</div>
<?php require_once 'footer.php';?>
