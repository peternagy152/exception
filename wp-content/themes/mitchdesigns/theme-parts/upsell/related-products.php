<?php
$exclude_ids = array();
if(!isset($product_id)){
  $product_id = get_the_id();
}

if(isset($thankyou_products_ids)){
  $related_products_ids = $thankyou_products_ids;
}else{
  //$related_products_ids = wc_get_related_products($product_id, 4, $exclude_ids);
  if(!empty($first_product_category)){
    // $first_product_category = $single_product_data['main_data']->get_category_ids()[0];
    $first_category_obj     = get_term_by('id', $first_product_category, 'product_cat');
    $related_products_ids   = mitch_get_related_products($product_id, array($first_product_category));
  }
}
/*if(empty($related_products_ids) && !empty($single_product_data)){
  $related_products_ids = mitch_get_related_products($product_id, $single_product_data['main_data']->get_category_ids());
}else{
  //$related_products_ids = array();
}*/
/*echo '<pre>';
var_dump($single_product_data['main_data']->get_category_ids());
echo '</pre>';*/
if(!empty($related_products_ids)){
  ?>

<div
	class="product related <?php if(is_checkout() && !empty(is_wc_endpoint_url('order-received'))){echo 'thankyou-page';}?>">
	<div class="grid">
		<div class="head_w_Link">
			<div class="text">
				<h4><?php echo upsell_translations('other_categories', $language) ;?></h4>
			</div>
			<div class="btn_more">
				<a
					href="<?php if($language == 'en'){echo home_url('/product-category/'.$first_category_obj->slug.'?lang=en');}else{echo home_url('/product-category/'.$first_category_obj->slug.'');} ?>"><?php echo upsell_translations('load_more_button', $language) ;?></a>
			</div>
		</div>


		<!-- <div class="section_title">
        <h2><?php //if(isset($new_related_title)){echo $new_related_title;}else{echo $fixed_string['product_related_section_title'];}?></h2>
        <?php //if(!empty($first_category_obj)){ ?>
        <p>See more items in <a href="<?php //echo home_url('/product-category/'.$first_category_obj->slug.'');?>"><?php //echo $first_category_obj->name;?></a></p>
        <?php //}?>
      </div> -->
		<div class="product_container">
			<ul
				class="products_list <?php if(count($related_products_ids) >= 5 ){echo 'slider_widget';}else{echo 'no_slider';}?>">
				<?php
        foreach($related_products_ids as $r_product_id){
           if($r_product_id == 1730 || $r_product_id == 3065){continue ;}
          $product_data = mitch_get_short_product_data($r_product_id);
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