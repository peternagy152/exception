<?php
require_once 'header.php';
global $post;
$post_details = get_field('list_ar', $post->ID);
$title_ar = $post_details['title'];
$title_en = $post-> post_title;
$single_img = $post_details['hero_banner'];
$content_ar = $post_details['content_ar'];
// $page_blog = get_field('head', 143);
global $language;

      if( $language == 'en') {
        // $page_content = get_field('contact_page_en');
        $page_blog = get_field('head_en',143);
      } else {
        // $page_content = get_field('contact_page');
        $page_blog = get_field('head',143);
      }
?>
<div id="page" class="site">
  <?php require_once 'theme-parts/main-menu.php';?>
  <!--start page-->
  <div class="site-content blog">
    <div class="section_single_blog">
     
      <div class="content_single_blog">
        <div class="grid">
            <ul class="breadcramb">
              <li>
                <a href="<?php echo $theme_settings['site_url'];?><?php echo ($language == 'en')? '/?lang=en':'' ?>">
                    <?php echo ($language == 'en')? 'Home':'الرئيسية' ?>
                </a>
              </li>
              <li>
                <a href="<?php echo home_url('blog');?><?php echo ($language == 'en')? '/?lang=en':'' ?>">
                    <?php echo $page_blog['title'] ?>
                </a>
              </li>
              <li>
                <a href="#"><?php echo ($language == 'en')? $title_en : $title_ar; ?></a>
              </li>
            </ul>
            <div class="section_content">
              <div class="section_title">
                  <h3 class="title"><?php echo ($language == 'en')? $title_en : $title_ar; ?></h3>
                  <p class="date"><?php echo date('F j, Y', strtotime($post->post_date));?></p>
                  <img src="<?php echo $single_img;?>" alt="">
              </div>
            </div>
         
        </div>

        <div class="grid">
            <div class="content">
                <?php echo ($language == 'en')? the_content() : $content_ar  ?>
            </div>
        </div>
      </div>
    </div>
  </div>
  <!--end page-->
</div>
<?php require_once 'footer.php';?>
