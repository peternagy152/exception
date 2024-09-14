<?php
require_once 'header.php';
$delivery_items = get_field('delivery_items', get_the_id());
?>
<div id="page" class="site" style="min-height: 1000px;">
  <?php require_once 'theme-parts/main-menu.php';?>
  <!--start page-->
  <div class="site-content style_page_form">
    <div class="grid">
      <div class="page_nav_menu">
          <?php require_once 'theme-parts/pages-sidebar.php';?>
          <div class="section_page content terms">
              <div class="section_title">
                <h1><?php echo get_the_title();?></h1>
              </div>
              <div class="page-content">
                  <?php echo get_the_content();?>
                  <?php
                  if(!empty($delivery_items)){
                    foreach($delivery_items as $delivery_item){
                      ?>
                      <div class="min_box">
                        <h3><?php echo $delivery_item['title'];?></h3>
                        <div class="term-content">
                          <?php echo $delivery_item['content'];?>
                        </div>
                      </div>
                      <?php
                    }
                  }
                  ?>
              </div>
          </div>
      </div>
    </div>
  </div>
  <!--end page-->
</div>
<?php require_once 'footer.php';?>
