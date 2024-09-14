<?php
/**
 * Cross-sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cross-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

 global $language;
defined( 'ABSPATH' ) || exit;

// $fixed_products = get_field('fixed_products',7);
$ids = array();
foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
	$ids[] = $cart_item['product_id'];
}
// $freq_ids = get_frequent_bought_together($ids);
$freq_ids = 'sdad';
 if(!empty($freq_ids)): $count=0; 
$args = array(
	'post_type'        => 'product',
	'posts_per_page'   => 6,
	'orderby' => 'rand',
	'order' => 'ASC',
	// 'post__in' => $freq_ids,
	'post_status'      => 'publish',
	'relation' => 'AND',							
	'suppress_filters' => false,
	'meta_query' => array(
		array(
			'key' => '_stock_status',
			'value' => 'instock',
			'compare' => '=',
		)
	),							
	'tax_query'    => array(
		array(
		  'taxonomy'         => 'product_visibility',
		  'terms'            => array( 'exclude-from-catalog', 'exclude-from-search' ),
		  'field'            => 'name',
		  'operator'         => 'Not IN',
		  'include_children' => false,
		),
	),
);
$products = get_posts( $args );
if(!empty($products)):
?>
	<div class="related products frequent-bought">
		<h2><?php echo($language=="en")?'Frequently bought together':"تسوق vdfveervre من غرف النوم";?></h2>
		<ul class="products-list products">	
			<?php  foreach ( $products as $post ) {
							setup_postdata($post);
							do_action( 'woocommerce_shop_loop' );

							wc_get_template_part( 'content', 'product' );
						}
						wp_reset_postdata();

				?>
		</ul>
	</div>
<?php endif; endif;?>

<?php if ( $cross_sells ):  ?>
		<div class="cross-sells related-products">
			<h2><?php esc_html_e( 'You may be interested in&hellip;', 'woocommerce' ); ?></h2>
			<?php woocommerce_product_loop_start(); ?>
				<?php foreach ( $cross_sells as $cross_sell ) : ?>
					<?php
						$post_object = get_post( $cross_sell->get_id() );
						setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.OverrideProhibited, Squiz.PHP.DisallowMultipleAssignments.Found
						wc_get_template_part( 'content', 'product' );
					?>
				<?php endforeach; ?>
			<?php woocommerce_product_loop_end(); ?>
		</div>
	<?php else:?>
				<?php
				$ids = array();
				$product_cats_ids = array();
				$count = 0;
				$counter = 0;
					foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
					$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
					$ids[$count] = $product_id;
					$new_array = wp_get_post_terms( $product_id, 'product_cat',array('fields' => 'ids') );
					foreach($new_array as $category_id):
						$cat_name = get_the_category_by_ID( $category_id );
						$cat_object = get_term_by('name', $cat_name, 'product_cat');
						$product_cats_ids[$counter] = $category_id;
						$counter++;
					endforeach;
					$count++;
				}
				$product_ids_from_cats_ids = get_posts( array(
					'post_type'   => 'product',
					'numberposts' => '6',
					'post_status' => 'publish',
					'post__not_in' => $ids,
					'meta_query' => array(
						array(
							'key' => '_stock_status',
							'value' => 'instock',
							'compare' => '=',
						)
					),
					'tax_query'   => array(
						'relation' => 'AND',
						array(
							'taxonomy' => 'product_cat',
							'field'    => 'id',
							'terms'    => $product_cats_ids,
							'operator' => 'IN',
						),
						array(
							'taxonomy'         => 'product_visibility',
							'terms'            => array( 'exclude-from-catalog', 'exclude-from-search' ),
							'field'            => 'name',
							'operator'         => 'Not IN',
							'include_children' => false,
						),
					),
				)); 
				if(count($product_ids_from_cats_ids) < 6){
					$ids = array();
					$product_cats_ids = array();
					$count = 0;
					$counter = 0;
						foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
						$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
						$ids[$count] = $product_id;
						$new_array = wp_get_post_terms( $product_id, 'product_cat',array('fields' => 'ids') );
						foreach($new_array as $category_id):
						$product_cats_ids[$counter] = $category_id;
						$counter++;
						endforeach;
						$count++;
					}
					$product_ids_from_cats_ids = get_posts( array(
						'post_type'   => 'product',
						'numberposts' => '6',
						'post_status' => 'publish',
						'post__not_in' => $ids,
						'meta_query' => array(
							array(
								'key' => '_stock_status',
								'value' => 'instock',
								'compare' => '=',
							)
						),
						'tax_query'   => array(
							'relation' => 'AND',
							array(
								'taxonomy' => 'product_cat',
								'field'    => 'id',
								'terms'    => $product_cats_ids,
								'operator' => 'IN',
							),
							array(
								'taxonomy'         => 'product_visibility',
								'terms'            => array( 'exclude-from-catalog', 'exclude-from-search' ),
								'field'            => 'name',
								'operator'         => 'Not IN',
								'include_children' => false,
							),
						),
					)); 
				}
				if(!empty($product_ids_from_cats_ids)){
				?>
				<!-- <div class="fixed-products related products"> -->
				<div class="related products">
					<h2><?php  echo ($language == 'en')? 'You May Also Like':'تسوق المزيد من الأثاث'?></h2>
					<ul class="products products-list">
						<?php global $post;
							foreach($product_ids_from_cats_ids as $post): 
							setup_postdata($post);
							global $product; 
							$product = wc_get_product($post->ID); 
							wc_get_template_part( 'content', 'product' ); ?>
						<?php endforeach; wp_reset_postdata(); ?>
					</ul>
				</div>

			<?php } endif; ?>

<? wp_reset_postdata();