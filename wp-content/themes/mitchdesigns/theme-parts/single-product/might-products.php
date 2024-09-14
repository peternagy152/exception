<?php
$exclude_ids = array();
if(!isset($product_id)){
  $product_id = get_the_id();
}

if(isset($thankyou_products_ids)){
  $might_products_ids = $thankyou_products_ids;
}else{
  //$might_products_ids = mitch_get_related_products($product_id, 4, $exclude_ids);
  if(!empty($second_product_category)){
    // $second_product_category = $single_product_data['main_data']->get_category_ids()[1];
    $second_category_obj     = get_term_by('id', $second_product_category, 'product_cat');
    $might_products_ids      = mitch_get_related_products($product_id, array($second_product_category));
  }
}
if(!empty($might_products_ids) && !empty($second_category_obj)){
  ?>
  <div class="product related <?php if(is_checkout() && !empty(is_wc_endpoint_url('order-received'))){echo 'thankyou-page';}?>">
    <div class="grid">
      <div class="section_title">
        <h2>You May Also Like</h2>
        <p>See more items in <a href="<?php echo home_url('/product-category/'.$second_category_obj->slug.'');?>"><?php echo $second_category_obj->name;?></a></p>
      </div>
      <div class="product_container">
        <ul class="products_list">
        <?php
        foreach($might_products_ids as $r_product_id){
          $product_data = mitch_get_short_product_data($r_product_id);
          // include '../theme-parts/product-widget.php';
          include get_template_directory().'/theme-parts/product-widget.php';
        }
        ?>
        </ul>
      </div>
    </div>
  </div>
  <?php
}
?>
