<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
?>

<?php

//Query For Fetching Products 
global $language;
if(isset($_GET['search'])){
    $products = Search_By_Product_Name($_GET['search'] , '100');
} 

?>
<?php require_once 'header.php';?>
<div id="page" class="site">
  <?php require_once 'theme-parts/main-menu.php';?>
<?php if ( !$_GET['search'] ): ?>
  	<?php else : global $wp_query; ?>
<?php endif; ?>

<div class="site-content page_list">
	<div class="grid">
		<div class="list_content">
			<div class="product list  search">
				<div class="grid">
                        <div class="section_title">
                          <!-- <h2><?php //echo ($language == 'en')?'Search Results For: '.$_GET['search']:'Search Results For: '.$_GET['search']; ?></h2> -->
                            <h2><?php echo ($language == 'en')?'Search Results For: ':'Search Results For : '; ?>
                                    <span><?php echo $_GET['search'] ?></span>
                            </h2>
                        </div>
                        <?php if ($products->post_count==0){ ?>
                            <div class="search-no-result">
                                <p><?php echo ($language == 'en')? 'No Result' : 'No results' ?></p>
                            </div>
                        <?php } ?>
                        <div class="product_container">
                        <ul class="products_list products <?php echo (empty($_COOKIE['gridView']) )? 'big' :''?> <?php echo (isset($_COOKIE['gridView']) && $_COOKIE['gridView'] == 'small' )?'small':''?> <?php echo (isset($_COOKIE['gridView']) && $_COOKIE['gridView'] == 'big' )?'big':''?> <?php echo (isset($_COOKIE['gridView']) && $_COOKIE['gridView'] == 'large' )?'large':''?>" data-slug="<?php echo (is_shop())? '':$cat_slug; ?>" data-type="<?php echo (is_shop())?'shop':$term->taxonomy; ?>" data-count="20" data-page="1" data-posts="<?php echo $allproducts; ?>" data-search="<?php echo $_GET['search']?>" data-sort="<?php echo (isset($_GET['orderby']))? $_GET['orderby'] :'desc'; ?>" data-lang="<?php echo $language; ?>">
                            <?php
                            if($_GET['search']){
                                $products_query = $products;
                                if($products_query->have_posts()): 
                                    while ($products_query->have_posts()) :
                                        $products_query->the_post();
                                        $product_data = mitch_get_short_product_data(get_the_ID());
                                       
                                    wc_get_template( '../theme-parts/product-widget.php', $product_data);
                                    endwhile; wp_reset_postdata(); endif;
                            }
                            ?>
                        </ul>
                        </div>

                 
                    <?php //endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<?php
	/**
	 * Hook: woocommerce_sidebar.
	 *
	 * @hooked woocommerce_get_sidebar - 10
	 */
	// do_action( 'woocommerce_sidebar' );

require_once 'footer.php';?>
