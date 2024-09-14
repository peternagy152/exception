<?php
/* Template Name: New Arrival */
require_once 'header.php'; global $post; //var_dump($post);
global $language;

if( $language == 'en') {
  $page_best_sellers = get_field('head_en');
} else {
  $page_best_sellers = get_field('head');
}
?>
<style>
  .product_container .products_list .product_widget .label.new{display:none !important;}
</style>
<div id="page" class="site">
  <?php require_once 'theme-parts/main-menu.php';?>
  <!--start page-->
  <div class="site-content page_list">
    <div class="section_title_list">
      <div class="grid">
          <h3><?php echo $page_best_sellers['title']; ?></h3>
          <!-- <p><?php //echo $page_new_arrival; ?></p> -->
      </div>
    </div>
    <div class="grid">
      <div class="list_content">
        <div class="product list new">
          <div class="grid">
            
            <div class="product_container section_new">
              <ul class="products_list products">
                <?php
                $best_selling_products = mitch_get_best_selling_products_ids(20);
                foreach($best_selling_products as $product_id){
                  $product_data = mitch_get_short_product_data($product_id);
                  if(!empty($product_data)){
                    include get_template_directory().'/theme-parts/product-widget.php';
                  }
                }
                ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--end page-->
</div>
<?php require_once 'footer.php';?>
