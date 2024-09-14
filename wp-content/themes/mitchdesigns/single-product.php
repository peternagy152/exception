<?php
require_once 'header.php';
$product_id          = get_the_id();
$single_product_data = mitch_get_product_data($product_id);
// var_dump(get_post_meta($product_id, 'product_data_product_color_name', true));
mitch_validate_single_product($single_product_data['main_data']);
mitch_add_recently_viewed_product();
global $language ;
?>
<div id="page" class="site">
	<?php require_once 'theme-parts/main-menu.php';?>
	<!--start page-->
	<div id="product_<?php echo $single_product_data['main_data']->get_id();?>_block" class="single_page"
		data-sku="<?php echo $single_product_data['main_data']->get_sku();?>"
		data-id="<?php echo $single_product_data['main_data']->get_id();?>">
		<?php $product_fields_data = MD_single_product_data($single_product_data['main_data']->get_id()) ; ?>
		<div class="section_item grid">
			<?php
    if($language == 'en'){
      woocommerce_breadcrumb();
    }else {
      woocommerce_breadcrumb();
    }
  
    ?>
			<h6 class="product_name"><?php echo $product_fields_data['name']; ?></h6>
			<?php $Excluded = false ?>
			<?php if(!empty($product_fields_data['excluded'])){ ?>
			<?php if(isset($_COOKIE['branch_id'])){
      if(in_array($_COOKIE['branch_id'] , $product_fields_data['excluded'])){
        $Excluded = true;

      }

    }
  }
    
    ?>


			<div id="single_product_alerts" class="ajax_alerts"></div>
			<div class="content <?php if($Excluded){echo 'excluded' ;} ?> ">
				<?php include_once 'theme-parts/single-product/gallary-section.php';?>
				<?php include_once 'theme-parts/single-product/info-section.php';?>
			</div>
		</div>
		<!-- <?php //include_once 'theme-parts/single-product/product-details.php';?>  -->
		<?php 
    $product_categories_ids = $single_product_data['main_data']->get_category_ids();
    shuffle($product_categories_ids);
    $first_product_category  = $product_categories_ids[0];
    if(!empty($product_categories_ids[1])){
      $second_product_category = $product_categories_ids[1];
    }
   
    ?>
		<?php //include_once 'theme-parts/single-product/might-products.php';?>
		<?php include_once 'theme-parts/upsell/addons-category.php';?>
		<?php include_once 'theme-parts/upsell/related-products.php';?>
		<?php include_once 'theme-parts/upsell/random-products.php';?>
		<?php //include_once 'theme-parts/slider-reviews.php';?>
		<?php include_once 'theme-parts/single-product/reviews-products.php';?>
		<?php include_once 'theme-parts/upsell/recently-viewed-products.php';?>

	</div>
	<!--end page-->
</div>
<?php require_once 'footer.php';?>
<div id="size_guide_popup" class="popup size_guide">
	<div class="popup__window size_guide">
		<button type="button" class="popup__close material-icons js-popup-closer">close</button>
		<?php include get_template_directory().'/theme-parts/size-guide-section.php';?>
	</div>
</div>
<?php 
$product_id = get_the_ID();
?>
<script>
function select_star(start_value) {
	$("#rating").val(start_value);
}
</script>

<?php if($single_product_data['main_data']->get_type() == 'variable'){ ?>
<script>
/*$(document).on('click', '#variations_colors_select', function(){
  var selectedItem = $(this).val();
  var price = $('option:selected',this).data("price-format");
  var stock = $('option:selected',this).data('stock');
  $('#product_price').html(price);
  if(stock <= 0){
    $('#variable_add_product_to_cart').addClass('disabled');
  }else{
    $('#variable_add_product_to_cart').removeClass('disabled');
  }
  var stock = $('#variations_colors_select option:selected').data('stock');
  if(stock == $('#number').val()){
    $('#increase').addClass('disabled');
  }else{
    $('#increase').removeClass('disabled');
  }
});*/


$(document).on('click', '.single_size.variation_option', function() {

	// var size_price . 'جنيه ' ; 

	if ($(this).data('variable_price') != $(this).data('sale_price')) {
		$('#product_price').html($(this).data('variable_price') +
			"<?php echo ' ' .  $theme_settings['curren_currency_'. $language] ;  ?>" + '<span class="discount"> ' + $(
				this).data('sale_price') + '</span>');
	} else {
		$('#product_price').html($(this).data('variable_price') +
			"<?php echo ' ' .  $theme_settings['curren_currency_'. $language] ;  ?>");
	}

	if ($(this).data('stock') == 0) {
		$("#variable_add_product_to_cart").addClass("disabled");
		if (current_lang == 'en') {
			$("#variable_add_product_to_cart").html("Out of stock ");
		} else {
			$("#variable_add_product_to_cart").html("غير متوفر");
		}

	} else {
		$("#variable_add_product_to_cart").removeClass("disabled");
		if (current_lang == 'en') {
			$("#variable_add_product_to_cart").html("Add to cart ");
		} else {
			$("#variable_add_product_to_cart").html("اضف لعربة التسوق");
		}
	}


});

$(document).ready(function() {
	$(".single_size.variation_option.active").click();
});



// var color_price = $('#variations_colors_select option:selected').data('price-format');
// if(color_price && color_price != '0.00'){
//   $('#product_price').html(color_price);
// }
// var size_price = $('#variations_sizes_select .single_size.active').data('price-format');
// // alert(size_price);
// if(size_price && size_price != '0.00'){
//   $('#product_price').html(size_price);
// }
// var stock = $('#variations_colors_select option:selected').data('stock');
// if(stock == $('#number').val()){
//   $('#increase').addClass('disabled');
// }else{
//   $('#increase').removeClass('disabled');
// }
</script>
<?php }?>