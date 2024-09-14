<!--start category-->
<?php
global $language;
$cate_slug = $cate->slug;
$parent    = $cate->parent;
$cat_slug  = ($cate->taxonomy == 'product_cat')? $cate->slug : $cate->term_id;
$page_type = $cate->taxonomy;
// $allproducts=$cate->count;
$allproducts    = 21;
$posts_per_page = 20
?>
<div class="site-content page_list">
	<!-- <div class="section_title">
        <?php
            // woocommerce_breadcrumb(array(
            //   'delimiter'   => '',
            //   'wrap_before' => '<ul class="breadcramb">',
            //   'wrap_after'  => '</ul>',
            //   'before'      => '<li>',
            //   'after'       => '</li>',
            //   'shop'        => $fixed_string['product_single_breadcrumb']
            // ));
        ?>
        <h3><?php //echo get_field('main_title', 'product_cat_'.$cate->term_id);?></h3>
        <p><?php //echo $cate->description;?></p>
        
      </div> -->
	<!-- <div class="section_title">
        <div class="grid">
            <?php
            // woocommerce_breadcrumb(array(
            //   'delimiter'   => '',
            //   'wrap_before' => '<ul class="breadcramb">',
            //   'wrap_after'  => '</ul>',
            //   'before'      => '<li>',
            //   'after'       => '</li>',
            //   'home'        => 'Home'
            // ));
            ?>
            <h3> <?php //echo $cate->name;?></h3>
            <?php 
            // if($cate->parent != 0){
            //   $parent_cate = get_term($cate->parent, 'product_cat');
            //   if(!empty($parent_cate)){
            //     echo '<p>'.$parent_cate->name.' Tagline</p>';
            //   }
            // }
            ?>
        </div>
      </div> -->
	<div class="hero_banner">
		<?php $thumbnail_id = get_term_meta( $cate->term_id, 'thumbnail_id', true ) ?>
		<?php $image = wp_get_attachment_url( $thumbnail_id ); ?>
		<?php if(empty($image)){ ?>
		<?php // Check Parent Thumbnail  ?>
		<?php $parent_thumbnail = get_term_meta( $parent, 'thumbnail_id', true ) ?>
		<?php $parent_image = wp_get_attachment_url( $parent_thumbnail ); ?>
		<?php if(empty($parent_image)){ ?>
		<img src="<?php echo $theme_settings['theme_url'];?>/assets/img/New-hero-list.webp" alt="" />
		<?php }else{ ?>
		<img src="<?php echo $parent_image ?>" alt="" />
		<?php } ?>

		<?php }else{  ?>
		<img src="<?php echo $image ?>" alt="" />
		<?php }  ?>
		<div class="section_title">
			<?php 
               if($language == 'en'){
                woocommerce_breadcrumb(array(
                  'delimiter'   => '',
                  'wrap_before' => '<ul class="breadcramb">',
                  'wrap_after'  => '</ul>',
                  'before'      => '<li>',
                  'after'       => '</li>',
                  'home'        => 'Home'
              ));
              }else {
                woocommerce_breadcrumb();
              }
              ?>
			<h3>
				<?php  if( $language == 'en') { ?>
				<?php echo $cate->name; ?>
				<?php } else { ?>
				<?php echo get_field('attribute_in_arabic', 'product_cat_' . $cate->term_id)?>
				<?php } ?>
			</h3>
			<?php  //if($cate->parent != 0){
                //   $parent_cate = get_term($cate->parent, 'product_cat');
                //   if(!empty($parent_cate)){
                // echo '<p>'.$parent_cate->name.' Tagline</p>';
              //} } ?>
		</div>
	</div>
	<div class="grid">
		<?php 
        if(isset($cate->term_id) && !empty($cate->term_id)){
          $sub_categories = get_terms(array(
            'taxonomy'   => 'product_cat',
            'hide_empty' => false,
            'parent'     => $cate->term_id
          ));
          if(!empty($sub_categories)){
            ?>
		<div class="section_subcategory_head">
			<ul>
				<?php 
                foreach($sub_categories as $sub_category){
                  $category_img = get_field('home_image', $sub_category);
                  if(empty($category_img)){
                    $category_img = $theme_settings['theme_url'].'/assets/img/woocommerce-placeholder-min.png';
                  }
                  ?>
				<li>
					<a href="<?php echo get_term_link($sub_category->term_id);?>">
						<img src="<?php echo $category_img;?>" alt="<?php echo $sub_category->name;?>">
						<p><?php echo $sub_category->name;?></p>
					</a>
				</li>
				<?php 
                }
                ?>
			</ul>
		</div>
		<?php 
          }
        }
        ?>
		<div class="list_content">
			<?php include_once get_template_directory().'/theme-parts/filters-form.php';?>
			<div class="product list">
				<div class="grid">
					<div class="product_container">
						<ul class="products_list products" data-count="20" data-page="1" data-posts="<?php echo $allproducts; ?>"
							data-slug="<?php if(isset($cate)){echo $cat_slug;}?>"
							data-type="<?php if(isset($cate)){echo $cate->taxonomy;}?>"
							data-search="<?php if(isset($_GET['s'])){echo $_GET['s'];}?>"
							data-sort="<?php if(isset($_GET['orderby'])){echo $_GET['orderby'];}else{echo 'popularity';}?>"
							data-lang="<?php echo $theme_settings['current_lang'];?>">
							<?php
                              $category_products_ids = mitch_get_products_by_category($cate->term_id, '', $cate->taxonomy);
                              if(!empty($category_products_ids)){
                              foreach($category_products_ids as $product_id){
                                $product_data = mitch_get_short_product_data($product_id);
                                include get_template_directory().'/theme-parts/product-widget.php';
                              } } ?>
						</ul>
						<?php // if($allproducts > $posts_per_page): ?>
						<div class="section_loader spinner">
							<div class="loader"></div>
						</div>
						<?php //endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--end category-->