<?php
/* Template Name: Deals & Offers */
require_once 'header.php'; global $post; //var_dump($post);
global $language;

if( $language == 'en') {
  $page_sale = get_field('head_en');
} else {
  $page_sale = get_field('head');
}
?>
<div id="page" class="site">
  <?php require_once 'theme-parts/main-menu.php';?>
  <!--start page-->
  <div class="site-content page_list">
    <div class="section_title_list">
      <div class="grid">
      <h3><?php echo $page_sale['title']; ?></h3>
      </div>
    </div>
    <div class="grid">
      <div class="list_content">
        <?php //include_once get_template_directory().'/theme-parts/filters-form.php';?>
        <div class="product list sale">
          <div class="grid">
          
            <div class="product_container">
              <ul class="products_list products" data-type="sale" data-sort="">
                <?php
                $sale_products = mitch_get_products_on_sale();
                foreach($sale_products as $product_id){
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
