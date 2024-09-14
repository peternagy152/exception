<?php
require_once 'header.php';
global $language;

  if( $language == 'en') {
    $page_content_special = get_field('page_content_special_en');
  } else {
    $page_content_special = get_field('page_content_special');
    
  }
// var_dump($page_content);
?>


<div id="page" class="site">
  <?php require_once 'theme-parts/main-menu.php';?>
  <!--start page-->
    <div class="site-content">
          <div class="section_page page_special">
                <div class="section_content">
                      <div class="sec_img">
                        <div class="image">
                          <img src="<?php echo $page_content_special['image'];?>" alt="">
                        </div>
                        <div class="text">
                              <h4><?php echo $page_content_special['title'];?></h4>
                              <p><?php echo $page_content_special['description'];?></p>
                              <a class="link" href="<?php echo $page_content_special['link']['url']; ?>">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icons/whatsapp.png" alt="" width="25" height="25">
                                <?php echo $page_content_special['link']['title']; ?>
                              </a>
                        </div> 
                      </div>

                      <div class="section_list">
                        <div class="grid">
                            <h4 class="title"><?php echo $page_content_special['title_slider'];?></h4>
                            <div class="section_category">
                              <?php
                                    $args = array(  
                                    'post_type' => 'specialcake',
                                    'post_status' => 'publish',
                                    'posts_per_page' => -1, 
                                    'orderby' => 'date', 
                                    'order' => 'ASC', 
                                  );
                                    $the_query = new WP_Query( $args );
                                    if ( $the_query->have_posts() ) {
                              ?>
                                <div class="list_category">
                                    <?php 
                                      while ( $the_query->have_posts() ) {
                                      $the_query->the_post();                                                                                                                
                                    ?>
                                  
                                      <a href="<?php the_permalink(); echo ($language == 'en') ? '?lang=en' : ''; ?>" class="single_cat <?php //echo $count_menu == 1 ? 'active' : ''; ?>" data-item="<?php echo get_the_ID(); ?>" id="cake_<?php echo get_the_ID(); ?>" >
                                          <div class="sec_img_list">
                                            <img src="<?php the_post_thumbnail_url(); ?>" alt="">
                                            <span class="text"><?php echo ($language == 'en')? get_field('name_en') : get_field('name_ar') ?></span>
                                          </div>
                                      </a>

                                    <?php } ?>
                                </div>
                              <?php } ?>
                            </div>
                        </div>
                        

                       
                      </div>
                </div>
          </div>
    </div>
</div>
  <!--end page-->
</div>
<?php require_once 'footer.php';?>
