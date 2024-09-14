<?php
require_once 'header.php'; global $post; //var_dump($post);?>
<div id="page" class="site">
  <?php require_once 'theme-parts/main-menu.php';?>
  <!--start page-->
    <div class="site-content style_page_form">
      <div class="grid">
        <div class="page_nav_menu">
            <?php require_once 'theme-parts/pages-sidebar.php';?>
            <div class="section_page career">
                  <div class="section_title">
                      <h1 ><?php echo get_field('title_page'); ?></h1>
                  </div>

                  <div class="section_form">
                    <div class="form_one">
                      <h3 class="form_title"><?php echo get_field('title'); ?></h3>
                      <p class="desc"><?php echo get_field('description'); ?></p>
                      <a class="link_form" href="<?php echo get_field('link'); ?>">Apply Now</a>
                    </div>
                    <div class="form_two">
                      <h3 class="form_title"><?php echo get_field('title_form_two'); ?></h3>
                      <?php if( have_rows('section_form') ): ?>
                        <div class="all_form">
                            <?php while( have_rows('section_form') ): the_row(); ?>
                                <div class="single_form">
                                    <h2><?php the_sub_field('title'); ?></h2>
                                      <a class="link_form" href="<?php echo the_sub_field('link_form'); ?>">Apply For This Job</a>
                                </div>
                            <?php endwhile; ?>
                        </div>
                      <?php endif; ?>
                    </div>
                  </div>
            </div>
        </div>
      </div>
    </div>
</div>
<?php require_once 'footer.php';?>
