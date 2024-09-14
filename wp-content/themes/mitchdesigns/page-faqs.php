<?php
require_once 'header.php';
$faq_items = get_field('faqs');
$page_faqs = get_field('head');
global $language;

  if( $language == 'en') {
    $faq_items = get_field('faqs_en');
    $page_faqs = get_field('head_en');
  } else {
    $faq_items = get_field('faqs');
    $page_faqs = get_field('head');
  }

?>

<div id="page" class="site">
  <?php require_once 'theme-parts/main-menu.php';?>
  <!--start page-->
  <div class="site-content faqs">
    <div class="grid">
      <div class="page_nav_menu">
          <?php //require_once 'theme-parts/pages-sidebar.php';?>
          <div class="section_page">
            <div class="section_title">
                  <div class="title">
                    <ul>
                      <li>
                          <a href="<?php echo $theme_settings['site_url'];?><?php echo ($language == 'en')? '/?lang=en':'' ?>">
                                <?php echo ($language == 'en')? 'Home':'الرئيسية' ?>
                          </a>
                      </li>
                      <li>
                          <h5><?php echo $page_faqs['title'] ?></h5>
                      </li>
                    </ul>
                    <h1><?php echo $page_faqs['title'] ?></h1>
                  </div>
            </div>  
            <div class="page-content">
              <div class="section_faq">
                  <?php if(!empty($faq_items)){
                    foreach($faq_items['faqs_repeater'] as $faq_item){
                  ?>
                    <div class="single_faq">
                        <h3 class="title_faq"><?php echo $faq_item['title_faq'];?></h3>
                        <div class="content_faq">
                          <?php echo $faq_item['description_faq'];?>
                        </div>
                    </div>
                  <?php } } ?>
              </div>
            </div>
           
            
          </div>
      </div>
    </div>
  </div>
  <!--end page-->
</div>
<?php require_once 'footer.php';?>
