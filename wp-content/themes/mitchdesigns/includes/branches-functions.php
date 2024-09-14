<?php
    global $language;

//Get Team 
add_action( 'wp_ajax_nopriv_get_branche_ajax', 'get_branche_ajax' );
add_action( 'wp_ajax_get_branche_ajax', 'get_branche_ajax' );
function get_branche_ajax(){
	$action = sanitize_text_field($_POST['fn_action']);
	$count    = intval($_POST['count']);
	$page     = intval($_POST['page']);
	$offset   = ($page) * $count;
	$language        = $_POST['lang'];
	$cat = sanitize_text_field($_POST['cat']);
	$ajaxArgs = array(
		"post_type" => 'branch',
		'post_status' => 'publish',
    	"fields" => 'ids',
		"suppress_filters" => false,
		);
	
	if($action == "loadmore"){
		$ajaxArgs["offset"] = $offset;
		$ajaxArgs["posts_per_page"] = $count;
	}else{
		$ajaxArgs["posts_per_page"] = $offset;
	}
	
	$ajaxArgs['orderby'] ='date';
	$ajaxArgs['order'] = 'desc';

	if($cat){
		$ajaxArgs['tax_query'][]= array(
			'taxonomy'=>'cities',
			'field' => 'term_id',
			'terms' => $cat,
			);
	}
	
		$products_ids =  get_posts($ajaxArgs);
		if(!empty($products_ids))  $count_list = 1;{
		
		foreach($products_ids as $product_id){ 

		$title_ar = get_field('branch_arabic_name', $product_id);
		$address = get_field('branch_arabic_address', $product_id);
		$address_en = get_field('branch_english_address', $product_id);
		$branch_open = get_field('branch_open', $product_id);
		$branch_close = get_field('branch_close', $product_id);
		$branch_open_en = get_field('branch_open_en', $product_id);
		$branch_close_en = get_field('branch_close_en', $product_id);
		$branch_map = get_field('location_link', $product_id);
		// $phone = get_field('phone', $product_id);		
	?>
		<a class="single_branch"  data-item="<?php echo $product_id; ?>" id="product_<?php echo $product_id; ?>_block" href="#product_<?php echo $product_id; ?>_block <?php //echo get_the_permalink($product_id); ?>">
			<div class="box">
				

				<h3><?php echo ($language == 'en')? get_the_title($product_id) : $title_ar ?></h3>
				<p><?php echo ($language == 'en')?  $address_en : $address ?></p>
				<!-- <span class="call">
					<img src="<?php //echo get_stylesheet_directory_uri(); ?>/assets/img/icons/call-black.png" alt="" width="15" height="15">
					<?php //echo $phone ?>
				</span> -->
				<ul class="time">
					<li>
						<h6><?php echo ($language == 'en')? 'Working Hours :' : 'مواعيد العمل :' ?></h6>
					</li>
					<li><?php echo ($language == 'en')?  $branch_open_en : $branch_open ?></li>
					<span>-</span>
					<li><?php echo ($language == 'en')?  $branch_close_en : $branch_close ?></li>
				</ul>
					<?php $all_kind = get_field('branch_kind', $product_id); if( $all_kind ):  ?>
					 <ul class="kind">
					 		<?php if( $all_kind && in_array('pastry', $all_kind ) ) {  ?>
								<li>
									<span><?php echo ($language == 'en')? 'Pastry' : 'حلواني' ?></span>
								</li>
							<?php }  if( $all_kind && in_array('pizza', $all_kind ) ) {  ?>
								<li>
									<span><?php echo ($language == 'en')? 'Pizza' : 'بيتزا' ?></span>
								</li>
							<?php }  if( $all_kind && in_array('cafe', $all_kind ) ) { ?>
								<li>
								<span><?php echo ($language == 'en')? 'Cafe' : 'كافية' ?></span>
								</li>
							<?php } ?>
							
					</ul>
				<?php endif; ?>
			</div>
		</a>

  <?php  $count_list++; }  }  wp_die();  }


// //Get Team Loader
// add_action( 'wp_ajax_nopriv_get_branche_ajax_count', 'get_branche_ajax_count' );
// add_action( 'wp_ajax_get_branche_ajax_count', 'get_branche_ajax_count' );

// function get_branche_ajax_count(){
// 	$count    = intval($_POST['count']);
// 	$page     = intval($_POST['page']);
// 	$offset   = ($page) * $count;
// 	$cat = sanitize_text_field($_POST['cat']);
// 	$ajaxArgs = array(
// 		"post_type" => 'team',
// 		"posts_per_page"=> -1 ,
//     	"fields" => 'ids',
// 		'post_status' => 'publish',
// 		"suppress_filters" => false,
// 		"offset" =>$offset,
// 	);
// 		$ajaxArgs['orderby'] ='date';
// 		$ajaxArgs['order'] = 'desc';
// 	if($cat){
// 		$ajaxArgs['tax_query'][]= array(
// 			'taxonomy'=>'cities',
// 			'field' => 'term_id',
// 			'terms' => $cat,
// 			);
// 	}
// 	$ajaxQuery =  get_posts($ajaxArgs);
// 		if($ajaxQuery){
// 			echo count($ajaxQuery);
// 		}else{
// 			echo "0";
// 		}
// 	wp_die();
// }