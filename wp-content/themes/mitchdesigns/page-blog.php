<?php require_once 'header.php';
      //$page_content = get_field('list_ar' , 743);
      //var_dump($page_content);
global $language;

      if( $language == 'en') {
        // $page_content = get_field('contact_page_en');
        $page_blog = get_field('head_en');
      } else {
        // $page_content = get_field('contact_page');
        $page_blog = get_field('head');
      }
?>

<div id="page" class="site">
  <?php require_once 'theme-parts/main-menu.php';?>
  <!--start page-->
  <div class="site-content blog">
    <div class="section_blog">
      <div class="grid">
        <div class="section_title">
          <div class="title">
            <ul>
              <li>
                  <a href="<?php echo $theme_settings['site_url'];?><?php echo ($language == 'en')? '/?lang=en':'' ?>">
                      <?php echo ($language == 'en')? 'Home':'الرئيسية' ?>
                  </a>
              </li>
              <li>
                  <h5><?php echo $page_blog['title'] ?></h5>
              </li>
            </ul>
            <h1><?php echo $page_blog['title'] ?></h1>
          </div>
          <!-- <span class="blog_total"> <?php //echo ($language == 'en')? 'Show 6 Blogs':'عرض 6 مقالات ' ?></span> -->
        </div>
        <div class="blog_list">
            <?php
                $blog_posts = mitch_get_blog_posts();

                if(!empty($blog_posts)){
            ?>
          <ul class="list">
              <?php 
                  foreach($blog_posts as $post_obj){ 
                  $page_content = get_field('list_ar' , $post_obj-> ID);
                  $title_en = $post_obj-> post_title;
                  $title_ar = $page_content['title'];
                  // $subtitle_en = $post_obj-> post_content;
                  $subtitle_en = $page_content['description'];
                  $subtitle_ar = $page_content['description_ar'];
                 
                  //$position = get_field('position');
                  //$position_ar = get_field('position_ar');
                  //echo $tit
                  // var_dump($post_obj);
                ?>
                
                <li class="single_blog">
                  <a href="<?php echo get_the_permalink($post_obj->ID);?><?php echo ($language == 'en')? '?lang=en':'' ?>" class="blog_link">
                    <div class="img">
                      <img src="<?php echo get_the_post_thumbnail_url($post_obj->ID,'full');?>" alt="<?php echo $post_obj->post_title;?>">
                    </div>
                    <div class="text">
                      <p class="date"><?php echo date('F j, Y', strtotime($post_obj->post_date));?></p>
                      <h3 class="title"> <?php echo ($language == 'en')? $title_en : $title_ar; ?></h3>
                      <p class="subtitle"><?php echo ($language == 'en')? $subtitle_en : $subtitle_ar; ?></p>
                      <p class="read_more"><?php echo ($language == 'en')? 'Read More' : 'إقرأ المزيد'; ?></p>
                    </div>
                  </a>
                </li>
              <?php } ?>
          </ul>
          <?php }else{ ?> 
            <div class="alert alert-danger"><?php echo $fixed_string['alert_blog_page_empty'];?></div>
          <?php } ?>
            <!-- <div class="section_loader">
              <div class="loader"></div>
            </div> -->
        </div>
      </div>
    </div>
  </div>
  <!--end page-->
</div>
<?php require_once 'footer.php';?>
