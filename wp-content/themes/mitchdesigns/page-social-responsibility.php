<?php
require_once 'header.php';
$page_content = get_field('about_page');
// var_dump($page_content);
?>
<style>
.site .content {
  color: #121212;
  font-size: 13px;
  line-height: 28px;
  font-weight: 300;
}
</style>
<div id="page" class="site">
  <?php require_once 'theme-parts/main-menu.php';?>
  <!--start page-->
    <div class="site-content style_page_form">
      <div class="grid">
        <div class="page_nav_menu">
            <?php require_once 'theme-parts/pages-sidebar.php';?>
            <div class="section_page about">
                  <div class="section_title">
                      <h1 ><?php echo the_title(); ?></h1>
                  </div>
                  <div class="section_slide">
                    <div class="content">
                      <?php the_content();?>
                    </div>
                      <?php /*if(!empty($page_content['other_sections'])){ foreach($page_content['other_sections'] as $other_section){ ?>
                        <div class="single_slide">
                            <div class="img">
                                <img src="<?php echo $other_section['image'];?>" alt="">
                            </div>
                            <div class="text">
                                <h3><?php echo $other_section['title'];?></h3>
                                <div class="content">
                                  <?php echo $other_section['content'];?>
                                </div>
                            </div>
                        </div>
                      <?php } }*/ ?>
                  </div>
            </div>
        </div>
      </div>
    </div>
</div>
  <!--end page-->
</div>
<?php require_once 'footer.php';?>
