<?php
require_once 'header.php';
global $post;

// $title_ar = $post_details['title'];
// $title_en = $post-> post_title;
// $single_img = $post_details['hero_banner'];
// $page_blog = get_field('head', 143);
global $language;
  
      if( $language == 'en') {
        $page_special_cake = get_field('page_content_special_en',1607);
        $post_name = get_field('name_en', $post->ID);
        $post_description = get_field('description_en', $post->ID);
      } else {
        $page_special_cake = get_field('page_content_special',1607);
        $post_name = get_field('name_ar', $post->ID);
        $post_description = get_field('description_ar', $post->ID);
      }
?>
<div id="page" class="site">
  <?php require_once 'theme-parts/main-menu.php';?>
  <!--start page-->
  <div class="site-content special_cake">
    <div class="section_single_special_cake">
        <div class="content_single_special_cake">
          <div class="grid">
            <div class="section_top">
                <ul class="breadcramb">
                  <li>
                    <a href="<?php echo $theme_settings['site_url'];?><?php echo ($language == 'en')? '/?lang=en':'' ?>">
                        <?php echo ($language == 'en')? 'Home':'الرئيسية' ?>
                    </a>
                  </li>
                  <li>
                    <a href="<?php echo home_url('special-cake');?><?php echo ($language == 'en')? '/?lang=en':'' ?>">
                      <?php echo ($language == 'en')? 'Choose Cake':'اختر تورت' ?>
                    </a>
                  </li>
                  <li>
                    <a href="#"><?php echo $post_name; ?></a>
                  </li>
                </ul>
                <h1><?php echo $post_name; ?></h1>
                <p><?php echo $post_description; ?></p>
                <a class="link" href="<?php echo $page_special_cake['link']['url']; ?>">
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icons/whatsapp.png" alt="" width="25" height="25">
                  <?php echo $page_special_cake['link']['title']; ?>
                </a>
            </div>
            <div class="all_images">
                <?php 
                  $images = get_field('image_single');
                  $size = 'full'; // (thumbnail, medium, large, full or custom size)
                  if( $images ): ?>
                      <ul>
                          <?php foreach( $images as $image_id ): ?>
                              <li>
                                  <?php //echo wp_get_attachment_image( $image_id, $size ); ?>
                                  <img src="<?php echo wp_get_attachment_image_url($image_id, $size); ?>" alt="Image Description">

                              </li>
                          <?php endforeach; ?>
                      </ul>
                  <?php endif; ?>
            </div>
            <a class="link last" href="<?php echo $page_special_cake['link']['url']; ?>">
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icons/whatsapp.png" alt="" width="25" height="25">
              <?php echo $page_special_cake['link']['title']; ?>
            </a>
          </div>
        </div>
    </div>
  </div>
  <!--end page-->
</div>
<?php require_once 'footer.php';?>
