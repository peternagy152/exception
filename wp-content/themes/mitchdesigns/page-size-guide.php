<?php
require_once 'header.php';
/*$cat_args = array(
  'orderby'    => 'name',
  'order'      => 'asc',
  'hide_empty' => false,
  'exclude'    => array(15)
);
$size_guide_details = array();
$product_categories = get_terms('product_cat', $cat_args);
if(!empty($product_categories)){
  $size_index = 0;
  foreach($product_categories as $product_category){
    $size_guide_list = get_field('size_guide_info', 'product_cat_'.$product_category->term_id);
    if(isset($size_guide_list['size_guide_image'])){
      $size_guide_details[$size_index] = array(
        'cat_name' => $product_category->name,
        'size_img' => $size_guide_list['size_guide_image'],
        'size_list'=> $size_guide_list['size_guide_list']
      );
      $size_index++;
    }
  }
}
*/
?>
<div id="page" class="site">
  <?php require_once 'theme-parts/main-menu.php';?>
  <!--start page-->
  <div class="site-content size_guide">
    <div class="grid">
        <?php include get_template_directory().'/theme-parts/size-guide-section.php';?>
    </div>
  </div>
  <!--end page-->
</div>
<?php require_once 'footer.php';?>
