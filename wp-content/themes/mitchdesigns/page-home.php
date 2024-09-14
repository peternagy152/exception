<?php
require_once 'header.php';
global $language;

  if( $language == 'en') {
    $home_content = get_field('home_group_en');
  } else {
    $home_content = get_field('home_group_ar');
  }
?>

<div id="page" class="site">
	<?php require_once 'theme-parts/main-menu.php';?>
	<!--start page-->
	<div class="site-content home">
		<div class="page_home">
			<?php global $theme_settings; ?>
			<?php
          if(!wp_is_mobile()){
            include_once 'theme-parts/home/hero-slider.php';
          }else{
            include_once 'theme-parts/home/hero-slider-mobile.php';
          }
      ?>
			<?php //include_once 'theme-parts/home/hero-slider.php';?>


			<?php include_once 'theme-parts/home/service-section.php';?>
			<?php include_once 'theme-parts/home/categories-section.php';?>

			<!-- New Arrivals -->
			<div class="section_new_arrival">
				<div class="grid">
					<div class="head_w_Link">
						<div class="text">
							<h4><?php echo $home_content['new_arrivals_title']; ?></h4>
							<p><?php echo $home_content['new_arrivals_subtitle']; ?></p>
						</div>
						<div class="btn_more">
							<?php if(!empty($home_content['new_arrivals_link']['title'] )): ?>
							<a href="<?php echo $home_content['new_arrivals_link']['url']; ?>">
								<?php echo $home_content['new_arrivals_link']['title']; ?>
							</a>
							<?php endif; ?>
						</div>
					</div>
					<?php include_once 'theme-parts/upsell/new-arrival.php';?>
				</div>
			</div>



			<!-- Best Sellers -->
			<div class="section_best_sellers">
				<div class="grid">
					<?php if($home_content['best_sellers_title']): ?>
					<div class="head_w_Link">
						<div class="text">
							<h4><?php echo $home_content['best_sellers_title']; ?></h4>
							<p><?php echo $home_content['best_sellers_subtitle']; ?></p>
						</div>
						<div class="btn_more">
							<?php if(!empty($home_content['best_sellers_link']['title'] )): ?>
							<a href="<?php echo $home_content['best_sellers_link']['url']; ?>">
								<?php echo $home_content['best_sellers_link']['title']; ?>
							</a>
							<?php endif; ?>
						</div>
					</div>
					<?php endif; ?>
					<?php include_once 'theme-parts/upsell/best-selling.php';?>
				</div>
			</div>

			<!-- Banners  -->
			<?php include_once 'theme-parts/home/repeater-banners.php';?>



			<!-- Recently Watched -->
			<?php $recently_viewed_products_ids = mitch_get_recently_viewed_products_ids();  ?>
			<?php if(!empty($recently_viewed_products_ids)){ ?>
			<div class="section_recently_watched ">
				<div class="grid">
					<?php if($home_content['recently_watched_title']): ?>
					<div class="head_w_Link">
						<div class="text">
							<h4><?php echo $home_content['recently_watched_title']; ?></h4>
							<p><?php echo $home_content['recently_watched_subtitle']; ?></p>
						</div>
						<div class="btn_more">
							<?php if(!empty($home_content['recently_watched_link']['title'] )): ?>
							<a href="<?php echo $home_content['recently_watched_link']['url']; ?>">
								<?php echo $home_content['recently_watched_link']['title']; ?>
							</a>
							<?php endif; ?>
						</div>
					</div>
					<?php endif; ?>

					<?php include_once 'theme-parts/upsell/recently-viewed-products.php';?>
				</div>
			</div>
			<?php }  ?>

			<!-- Instagram Section  -->

		</div>
		<!--end page-->
		 <a class="js-popup-opener" href="#popup-banner" style="display:none;"></a>
	</div>
	<?php require_once 'footer.php';?>