<?php
require_once 'header.php';

global $language;

  if( $language == 'en') {
    $terms_items = get_field('terms_items_en', get_the_id());
    $page_terms = get_field('head_en');
  } else {
    $terms_items = get_field('terms_items', get_the_id());
    $page_terms = get_field('head');
  }

?>
<div id="page" class="site" style="min-height: 1000px;">
  <?php require_once 'theme-parts/main-menu.php';?>
  <!--start page-->
  <div class="site-content style_page_form">
    <div class="grid">
      <div class="page_nav_menu">
          <?php //require_once 'theme-parts/pages-sidebar.php';?>
          <div class="section_page content terms">
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
              <div class="page-content ">
                  <?php echo get_the_content();?>
                  <?php if(!empty($terms_items)){
                    foreach($terms_items as $term_item){
                  ?>
                    <div class="min_box">
                      <h3><?php echo $term_item['title'];?></h3>
                      <div class="term-content">
                        <?php echo $term_item['content'];?>
                      </div>
                    </div>
                  <?php } } ?>
              </div>
          </div>
      </div>
    </div>
  </div>
  <!--end page-->
</div>
<?php require_once 'footer.php';?>
