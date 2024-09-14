<?php require_once 'header.php';?>
<?php wp_head() ; ?>
<?php require_once 'theme-parts/main-menu.php';
global $language;

  if( $language == 'en') {
    $page_content = get_field('contact_page_en');
    $page_contact_us = get_field('head_en');
  } else {
    $page_content = get_field('contact_page');
    $page_contact_us = get_field('head');
  }
  ?>
<!--start page-->
<div class="site-content">
	<div class="grid">
		<div class="page_nav_menu">
			<?php //require_once 'theme-parts/pages-sidebar.php';?>
			<div class="section_page contact_us">
				<div class="section_title">
					<div class="title">
						<ul>
							<li>
								<a href="<?php echo $theme_settings['site_url'];?><?php echo ($language == 'en')? '/?lang=en':'' ?>">
									<?php echo ($language == 'en')? 'Home':'الرئيسية' ?>
								</a>
							</li>
							<li>
								<h5><?php echo $page_contact_us['title'] ?></h5>
							</li>
						</ul>
						<h1><?php echo $page_contact_us['title'] ?></h1>
					</div>
				</div>
				<div class="contact_us">
					<div class="section_info">
						<div class="box">
							<?php 
                          $list_info = $page_content['list_info'];
                          if(!empty($list_info)){
                          foreach($list_info as $single_info){
                      ?>
							<div class="single_row">
								<div class="img">
									<img src="<?php echo $single_info['icon'] ; ?>" alt="">
								</div>
								<div class="text">
									<h5><?php echo $single_info['title'] ; ?></h5>
									<p><?php echo $single_info['description'] ; ?></p>
								</div>
							</div>
							<?php  } } ?>
						</div>
					</div>
					<div class="form_content">
						<h4><?php echo $page_contact_us['title'] ?></h4>
						<?php if( $language == 'en') :?>
						<?php echo do_shortcode('[fluentform id="3"]');?>
						<?php else:?>
						<?php echo do_shortcode('[fluentform id="1"]');?>
						<?php endif; ?>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
<!--end page-->
</div>
<?php require_once 'footer.php';?>
<?php wp_footer(); ?>