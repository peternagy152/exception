<?php
function mitch_get_product_id_by_slug($product_slug){
  global $wpdb;
  return $wpdb->get_row("SELECT ID FROM wp_posts WHERE post_name = '$product_slug'")->ID;
}

function mitch_validate_single_product($product_obj){
  if(current_user_can('administrator') == false){
    // var_dump($product_obj->get_catalog_visibility());
    if(empty($product_obj->get_price()) || $product_obj->get_status() != 'publish' || $product_obj->get_catalog_visibility() == 'hidden'){
      wp_redirect(home_url());
      exit;
    }
  }
}

function mitch_validate_customized_product($product_data){
  if(
    empty($product_data['main_data']->get_price())        ||
    $product_data['main_data']->get_type() != 'variable'  ||
    $product_data['main_data']->get_status() != 'publish' ||
    $product_data['extra_data']['product_customized'] == false
  ){
    wp_redirect(home_url());
    exit;
    // global $wp_query;
    // $wp_query->set_404();
    // status_header(404);
    // get_template_part(404);
    //exit();
  }
}

function mitch_get_product_data($product_id){
  $main_data = wc_get_product($product_id);
  $product_parent = get_post_meta($product_id, 'product_data_parent_product', true);
  $product_childs = get_post_meta($product_id, 'product_data_product_childs', true);
  if(empty($product_childs) && !empty($product_parent)){
    $product_childs = get_post_meta($product_parent, 'product_data_product_childs', true);
  }
  return array(
    'main_data'      => $main_data,
    'extra_data'     => get_field('product_data', $product_id),
    'images'         => mitch_get_product_images($main_data->get_image_id(), $main_data->get_gallery_image_ids()),
    'product_childs' => $product_childs
  );
}
function mitch_get_product_wishlist_count($product_id){
  global $wpdb;
  return (int)$wpdb->get_row("SELECT COUNT(ID) AS count FROM `wp_mitch_wishlist` WHERE product_id = $product_id;")->count;
}
function mitch_get_product_images($featured_image_id, $gallery_images_ids){
  // var_dump(wp_get_attachment_image($featured_image_id, array(100, 100)));
  // exit;
  $product_full_images   = array();
  $product_thum_images   = array();
  // $product_full_images[] = wp_get_attachment_image($featured_image_id, array(600, 600));//wp_get_attachment_image_src($featured_image_id, 'full');
  // $product_thum_images[] = wp_get_attachment_image($featured_image_id, array(100, 100));//wp_get_attachment_image_src($featured_image_id, 'thumbnail');
  if(!empty($gallery_images_ids)){
    foreach($gallery_images_ids as $gallery_image_id){
      $product_full_images[] = wp_get_attachment_image_src($gallery_image_id, 'full')[0];//wp_get_attachment_image($gallery_image_id, array(600, 600));
      //$product_thum_images[] = wp_get_attachment_image_src($gallery_image_id, 'thumbnail')[0];//;
      $product_thum_images[] = wp_get_attachment_image_src($gallery_image_id, array(220, 100))[0];
    }
  }
  return array(
    'full'  => $product_full_images,
    'thumb' => $product_thum_images
  );
}

function mitch_get_product_attribute_name($attribute_slug){
  global $wpdb;
  return $wpdb->get_row("SELECT name FROM wp_terms WHERE slug = '$attribute_slug'")->name;
}

function mitch_get_product_attribute_name_by_id($attribute_id){
  global $wpdb;
  return $wpdb->get_row("SELECT name FROM wp_terms WHERE term_id = $attribute_id")->name;
}

function mitch_get_customized_product_variations_steps($product_variations, $attr_key, $step_number_name, $step_number_value){
  if(!empty($product_variations)){
    foreach($product_variations as $variation_obj){
      if(!empty($variation_obj['attributes']["attribute_{$attr_key}"]) && $variation_obj['attributes']["attribute_{$attr_key}"] != 'none'){
        $variation_img = wp_get_attachment_image_src($variation_obj['image_id'], 'medium')[0]; //full
        ?>
<div class="single_box" data-variation-id="<?php echo $variation_obj['variation_id'];?>"
	data-variation-price="<?php echo $variation_obj['display_price'];?>"
	data-variation-attribute-key="<?php echo $attr_key;?>"
	data-variation-attribute-val="<?php echo $variation_obj['attributes']["attribute_{$attr_key}"];?>"
	data-variation-step="<?php echo $step_number_name;?>" data-variation-img="<?php echo $variation_img;?>"
	data-next="<?php echo mitch_get_number_name($step_number_value + 1);?>">
	<img src="<?php echo $variation_img;?>" alt="">
	<h4>
		<?php echo mitch_get_product_attribute_name($variation_obj['attributes']["attribute_{$attr_key}"]); //urldecode();?>
	</h4>
</div>
<?php
      }
    }
  }
}

function mitch_get_customized_product_variations_steps_old($product_childrens, $attr_key){
  if(!empty($product_childrens)){
    foreach($product_childrens as $variation_id){
      $variation_attr_title = get_post_meta($variation_id, 'attribute_'.$attr_key.'', true);
      if(!empty($variation_attr_title)){
        //$variation_obj = wc_get_product($variation_id);
        // mitch_test_vars(array($variation_obj));
        ?>
<div class="single_box" data-variation-id="<?php echo $variation_id;?>"
	data-variation-price="<?php echo $variation_obj->get_price();?>">
	<img src="<?php echo wp_get_attachment_image_src($variation_obj->get_image_id(), 'full')[0];?>" alt="">
	<h4><?php echo mitch_get_product_attribute_name($variation_attr_title); //urldecode();?></h4>
</div>
<?php
      }
    }
  }
}

function mitch_get_short_product_data($product_id){
  global $wpdb;
  $product_type_arr = $wpdb->get_row("SELECT post_type FROM wp_posts WHERE ID = $product_id");
  if(!empty($product_type_arr) && $product_type_arr->post_type != 'product_variation'){
    //$product_id = $wpdb->get_row("SELECT post_parent FROM wp_posts WHERE ID = $product_id")->post_parent;
    $product_parent = get_post_meta($product_id, 'product_data_parent_product', true);
    $product_childs = get_post_meta($product_id, 'product_data_product_childs', true);
    if(empty($product_childs) && !empty($product_parent)){
      $product_childs = get_post_meta($product_parent, 'product_data_product_childs', true);
    }
    $product_img = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'full');
    if(!empty($product_img)){
      $product_img = $product_img[0];
    }else{
      $product_img =  get_stylesheet_directory_uri().'/assets/img/placeholder.webp';//wc_placeholder_img_src('300');
    }

    
    // Getting Extra Data From Product Object 
    
    $product_obj = wc_get_product( $product_id );
    $regular_variable_price = 0 ;
    if( $product_obj->get_type() != 'simple'){
      $variation_prices = $product_obj->get_variation_prices(true);
      $regular_variable_price = min($variation_prices['regular_price']);
    }
    // $product_image = ' ' ;
    // if(wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'full')[0]){
    //   $product_image = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'full')[0];
    // }else{
    //   $product_image = get_stylesheet_directory_uri().'/assets/img/placeholder.webp';
    // }
    return array(
      'product_id'           => $product_id,
      'product_title'        => get_the_title($product_id),
      'product_price'        => get_post_meta($product_id, '_price', true),
      'product_image'        => $product_img,
      //'product_image'         => (wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'full')[0])?wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'full')[0]:get_stylesheet_directory_uri().'/assets/img/placeholder.webp',
      'product_flip_image'   => get_field('product_data_flip_image', $product_id),
      'product_gallery_ids'  => array_slice(explode(',', get_post_meta($product_id, '_product_image_gallery', true)), 0, 2),
      'product_url'          => get_permalink($product_id),
      'product_parent'       => $product_parent,
      'product_childs'       => $product_childs,
      'product_sizes'        => mitch_get_sizes_products_data($product_id),
      'product_type'         => $product_obj->get_type() ,
      'product_is_sale_simple' => $product_obj->is_on_sale() ,
      'product_regular_price' => $product_obj->get_regular_price(),
      'product_stock_status' => $product_obj->get_stock_status() , 
      'product_variable_regular_price' =>  $regular_variable_price , 

    );
  }else{
    return; 
  }
}

function mitch_get_sizes_products_data($parent_product_id){
  global $wpdb;
  return $wpdb->get_results("SELECT REPLACE(post_excerpt, 'Size: ', '') AS name, ID FROM `wp_posts` WHERE post_parent = $parent_product_id AND post_type = 'product_variation' AND post_status = 'publish' AND post_excerpt LIKE '%Size:%';"); //AND post_excerpt != 'Size: ONESIZE'
}

function mitch_get_colors_products_data($parent_product_id){
  global $wpdb;
  return $wpdb->get_results("SELECT REPLACE(post_excerpt, 'Color: ', '') AS name, ID FROM `wp_posts` WHERE post_parent = $parent_product_id AND post_type = 'product_variation' AND post_status = 'publish' AND post_excerpt LIKE '%Color:%';"); //AND post_excerpt != 'Size: ONESIZE'
}
function mitch_get_products_by_category($category_id,$page_type, $taxonomy_type){
  if($page_type=="filter"){
    $number_of_posts = 1;
  }else{
    $number_of_posts = 20;
  }
  if(empty($taxonomy_type)){
    $taxonomy_type = 'product_cat';
  }
  $products_ids = get_posts(array(
    'numberposts' => $number_of_posts,
    'fields'      => 'ids',
    'post_type'   => 'product',
    'post_status' => 'publish',
    'tax_query'   => array(
      'relation'       => 'AND',
  			array(
  				'taxonomy'         => 'product_visibility',
  				'terms'            => array('exclude-from-catalog', 'exclude-from-search'),
  				'field'            => 'name',
  				'operator'         => 'NOT IN',
  				'include_children' => false,
  			),
        array(
          'taxonomy' => $taxonomy_type,
          'field'    => 'term_id',
          'terms'    => $category_id, /*category name*/
          'operator' => 'IN',
        )
    ),
    'orderby' => array('meta_value_num' => 'desc', 'date' => 'desc'),
    'order'   => 'desc',
    'meta_key'=> 'total_sales',
  ));
  shuffle($products_ids);
  return $products_ids;
}

function mitch_get_products_list(){
  return get_posts(array(
    'numberposts' => 20,
    'fields'      => 'ids',
    'post_type'   => 'product',
    'post_status' => 'publish',
    'orderby'     => array('meta_value_num' => 'desc', 'date' => 'desc'),
    'order'       => 'desc',
    'meta_key'    => 'total_sales',
    'tax_query'   => array(
      'relation'       => 'AND',
  			array(
  				'taxonomy'         => 'product_visibility',
  				'terms'            => array('exclude-from-catalog', 'exclude-from-search'),
  				'field'            => 'name',
  				'operator'         => 'NOT IN',
  				'include_children' => false,
  			),
    ),
  ));
}

add_action('wp_ajax_mitch_make_product_review', 'mitch_make_product_review');
add_action('wp_ajax_nopriv_mitch_make_product_review', 'mitch_make_product_review');
function mitch_make_product_review(){
  $response       = array();
	$post_form_data = $_POST['form_data'];
	parse_str($post_form_data, $form_data);
  $product_id   = intval($form_data['product_id']);
  $name         = sanitize_text_field($form_data['name']);
	$email        = sanitize_text_field($form_data['email']);
  $comment      = sanitize_text_field($form_data['comment']);
  $rating       = sanitize_text_field($form_data['rating']);
  $lang = $_POST['lang'];
  $comment_data = array(
    'comment_post_ID'      => $product_id,
    'comment_author'       => $name,
    'comment_author_email' => $email,
    'comment_content'      => $comment,
    'comment_date'         => current_time('Y-m-d H:i:s'),
    'user_id'              => get_current_user_id(),
    'comment_approved'     => 0,
    'comment_type'         => 'review',
  );
  $comment_id = wp_insert_comment($comment_data);
  if($comment_id){
    update_comment_meta($comment_id, 'rating', $rating);
    $response = array('status' => 'success', 'comment_data' => $comment_data, 'msg' => single_translate('success_review' , $lang));
  }else{
    $response = array('status' => 'error');
  }
  echo json_encode($response);
  wp_die();
}

function mitch_get_bought_together_products($pids, $exclude_pids = 0){
  $sub_exsql2   = '';
	$all_products = array();
	$pids_count   = count($pids);
	$pid          = implode(',',$pids);
	global $wpdb,$table_prefix;
	if ($pids_count >1 ||  ($pids_count == 1 && !$all_products = wp_cache_get( 'bought_together_'.$pid, 'ah_bought_together' )) ) {
		$subsql = "SELECT oim.order_item_id FROM ".$table_prefix."woocommerce_order_itemmeta oim where oim.meta_key='_product_id' and oim.meta_value in ($pid)";
		$sql = "SELECT oi.order_id from  ".$table_prefix."woocommerce_order_items oi where oi.order_item_id in ($subsql) limit 100";
		$all_orders = $wpdb->get_col($sql);
		if($all_orders){
			$all_orders_str = implode(',',$all_orders);
			$subsql2 = "select oi.order_item_id FROM ".$table_prefix."woocommerce_order_items oi where oi.order_id in ($all_orders_str) and oi.order_item_type='line_item'";
			if($exclude_pids){
				$sub_exsql2 = " and oim.meta_value not in ($pid)";
			}
			$sql2 = "select oim.meta_value as product_id,count(oim.meta_value) as total_count from ".$table_prefix."woocommerce_order_itemmeta oim where oim.meta_key='_product_id' $sub_exsql2 and oim.order_item_id in ($subsql2) group by oim.meta_value order by total_count desc limit 15";
			$all_products = $wpdb->get_col($sql2);
			if($pids_count==1){
				wp_cache_add( 'bought_together_'.$pid, $all_products, 'ah_bought_together' );
			}
		}
	}
  if(!empty($all_products)){
    shuffle($all_products);
  }
	return $all_products;
}

function mitch_get_reviews_stars($rating_avg){
  echo '<div class="starssss">';
  if($rating_avg == 0){
    ?>
<span class="material-icons">star_outline</span>
<span class="material-icons">star_outline</span>
<span class="material-icons">star_outline</span>
<span class="material-icons">star_outline</span>
<span class="material-icons">star_outline</span>
<?php
  }elseif($rating_avg >= 1 && $rating_avg < 2){
    ?>
<span class="material-icons">star_rate</span>
<span class="material-icons">star_outline</span>
<span class="material-icons">star_outline</span>
<span class="material-icons">star_outline</span>
<span class="material-icons">star_outline</span>
<?php
  }elseif($rating_avg >= 2 && $rating_avg < 3){
    ?>
<span class="material-icons">star_rate</span>
<span class="material-icons">star_rate</span>
<span class="material-icons">star_outline</span>
<span class="material-icons">star_outline</span>
<span class="material-icons">star_outline</span>
<?php
  }elseif($rating_avg >= 3 && $rating_avg < 4){
    ?>
<span class="material-icons">star_rate</span>
<span class="material-icons">star_rate</span>
<span class="material-icons">star_rate</span>
<span class="material-icons">star_outline</span>
<span class="material-icons">star_outline</span>
<?php
  }elseif($rating_avg >= 4 && $rating_avg < 5){
    ?>
<span class="material-icons">star_rate</span>
<span class="material-icons">star_rate</span>
<span class="material-icons">star_rate</span>
<span class="material-icons">star_rate</span>
<span class="material-icons">star_outline</span>
<?php
  }elseif($rating_avg == 5){
    ?>
<span class="material-icons">star_rate</span>
<span class="material-icons">star_rate</span>
<span class="material-icons">star_rate</span>
<span class="material-icons">star_rate</span>
<span class="material-icons">star_rate</span>
<?php
  }
  echo '</div>';
}

function mitch_remove_decimal_from_rating($rating_avg){
  if(in_array($rating_avg, array('1.00', '2.00', '3.00', '4.00', '5.00'))){
    $rating_avg = intval($rating_avg);
  }
  return $rating_avg;
}

function mitch_get_best_selling_products_ids($limit){
  if(empty($limit)){
    $limit = 8;
  }
  $args = array(
    'post_type'      => 'product',
    'meta_key'       => 'total_sales',
    'orderby'        => 'meta_value_num',
    'fields'         => 'ids',
    'posts_per_page' => $limit,
  );
  return get_posts($args);
}

function mitch_update_product_total_sales($product_id, $new_quantity){
  $old_total_sales = (int)get_post_meta($product_id, 'total_sales', true);
  $new_total_sales = $old_total_sales + $new_quantity;
  update_post_meta($product_id, 'total_sales', $new_total_sales);
}

function mitch_get_new_arrival_products_ids($limit){
  
    $args = array(
      'post_type'      => 'product',
      'fields'         => 'ids',
      'posts_per_page' => $limit,
      'order_by'       => 'date',
      'order'          => 'desc'
    );
    $products = get_posts($args);
  
  return $products;
}

// load more products
add_action('wp_ajax_nopriv_get_products_ajax', 'get_products_ajax');
add_action('wp_ajax_get_products_ajax', 'get_products_ajax');
function get_products_ajax(){
	$action      = sanitize_text_field($_POST['fn_action']);
	$count       = intval($_POST['count']);
	$page        = intval($_POST['page']);
	$offset      = ($page) * $count;
	$order       = sanitize_text_field($_POST['order']);
	$type        = sanitize_text_field($_POST['type']);
	$slug        = sanitize_text_field($_POST['slug']);
	$cat         = sanitize_text_field($_POST['cat']);
	$search      = sanitize_text_field($_POST['search']);
	$ids         = $_POST['ids'];
	$lang        = $_POST['lang'];
  $colors      = (array)$_POST['colors'];
  $sizes       = (array)$_POST['sizes'];

  $collections = (array)$_POST['collections'];
  $occasions   = (array)$_POST['occasions'];
  $forwho      = (array)$_POST['forwho'];
  $genders     = (array)$_POST['genders'];

	$ajaxArgs    = array();
  $filterQuery = array();
  // echo '<pre>';
  // var_dump($_POST);
  // echo '</pre>';
  // exit;
  $ajaxArgs = array(
    "post_type"          => "product",
    "post_status"        => "publish",
    "fields"             => "ids",
    "suppress_filters"   => false,
    "tax_query"          => array(
      "relation"         => "AND",
      array(
      "taxonomy"         => "product_visibility",
      "terms"            => array("exclude-from-catalog", "exclude-from-search"),
      "field"            => "name",
      "operator"         => "NOT IN",
      "include_children" => false,
      ),
    ),
  );
  if(!empty($collections)){
    $ajaxArgs['tax_query'][]= array(
      'taxonomy' => 'collections',
      'field'    => 'term_id',
      'terms'    => $collections
    );
  }
  if(!empty($occasions)){
    $ajaxArgs['tax_query'][]= array(
      'taxonomy' => 'occasions',
      'field'    => 'term_id',
      'terms'    => $occasions
    );
  }
  if(!empty($forwho)){
    $ajaxArgs['tax_query'][]= array(
      'taxonomy' => 'forwho',
      'field'    => 'term_id',
      'terms'    => $forwho
    );
  }
    if(!empty($genders)){
      $ajaxArgs['tax_query'][]= array(
        'taxonomy' => 'genders',
        'field'    => 'term_id',
        'terms'    => $genders
      );
    }
  	if($search != ""){
  		$ajaxArgs["s"] = $search;
  	}
  	if($action == "loadmore"){
  		$ajaxArgs["offset"]         =  $offset;
  		$ajaxArgs["posts_per_page"] = $count;
  	}else{
  		$ajaxArgs["posts_per_page"] = $offset;
  	}
	  if($type == 'product_cat'){
		  $ajaxArgs['product_cat'] = $_POST['slug'];
    }elseif($type == 'new'){
  		$ajaxArgs['date_query'] = array(array('after' => date('Y-m-d', strtotime('-60 days'))));
  		$ajaxArgs['meta_query'] = array(
  			array(
  				'key'     => '_stock_status',
  				'value'   => 'instock',
  				'compare' => '=',
  			)
      );
  	}elseif($type == 'type'){
  		$ajaxArgs['tax_query'][]= array(
  			'taxonomy' => 'type',
  			'field'    => 'term_id',
  			'terms'    => array($_POST['slug'])
  		);
  	}elseif($type == 'sale'){
      $ajaxArgs['meta_query'] = array(
        'relation' => 'OR',
        array( // Simple products type
          'key'           => '_sale_price',
          'value'         => 0,
          'compare'       => '>',
          'type'          => 'numeric'
        ),
        array( // Variable products type
          'key'           => '_min_variation_sale_price',
          'value'         => 0,
          'compare'       => '>',
          'type'          => 'numeric'
        )
      );
      $ajaxArgs['post__in'] = wc_get_product_ids_on_sale();
  	}else{
  		/*$ajaxArgs['tax_query'][] = array(
  			'taxonomy' => $type,
  			'field'    => 'term_id',
  			'terms'    => array($slug),
  		);*/
  	}
    if($_POST['cats'] && count($_POST['cats']) > 0){
  		$cats                    = (array)$_POST['cats'];
  		$ajaxArgs['tax_query'][] = array(
  			'taxonomy' => 'product_cat',
  			'field'    => 'slug',
  			'terms'    => $cats,
  		);
  	}
  	if($order == 'price'){
  		$orderby              = array('meta_value_num' => 'asc', 'date' => 'desc',);
  		$ajaxArgs['meta_key'] = '_price';
  		$ajaxArgs['orderby']  = $orderby;
  		$ajaxArgs['order']    = 'asc';
  	}elseif($order == 'price-desc'){
  		$orderby              = array('meta_value_num' => 'desc', 'date' => 'desc');
  		$ajaxArgs['meta_key'] = '_price';
  		$ajaxArgs['orderby']  = $orderby;
  		$ajaxArgs['order']    = 'desc';
  	}else if($order =='featured'){
  		$orderby              = array('meta_value_num' => 'desc', 'date' => 'desc');
  		$ajaxArgs['meta_key'] = 'featured';
  		$ajaxArgs['orderby']  = $orderby;
  		$ajaxArgs['order']    = 'desc';
  	}elseif($order == 'date'){
  		$ajaxArgs['orderby'] = 'date';
  		$ajaxArgs['order']   = 'desc';
  	}else if($order == 'popularity'){
      $orderby              = array('meta_value_num' => 'desc', 'date' => 'desc');
      $ajaxArgs['meta_key'] = 'total_sales';
      $ajaxArgs['orderby']  = $orderby;
      $ajaxArgs['order']    = 'desc';
  	}elseif($order == 'stock'){
  		$orderby              = array('meta_value_num' => 'desc', 'date' => 'desc');
      $ajaxArgs['meta_key'] = '_stock_status';
      $ajaxArgs['orderby']  = 'meta_value';
      $ajaxArgs['order']    = 'ASC';
  	}else{
  		$orderby              = array('meta_value_num' => 'desc', 'date' => 'desc');
      $ajaxArgs['meta_key'] = 'total_sales';
      $ajaxArgs['orderby']  = $orderby;
      $ajaxArgs['order']    = 'desc';
  	}
  	if(is_countable($_POST['sizes']) && count($_POST['sizes'])>0){
  		$terms                   = $_POST['sizes'];
  		$ajaxArgs['tax_query'][] = array(
  			'taxonomy' => 'pa_size',
  			'field'    => 'slug',
  			'terms'    => $terms
  		);
  	}
  if(!empty($colors)){
    // $colors[] = 'red';
    // $colors[] = 'blue';
    global $wpdb;
    $colors_stmt = "'".implode("','", $colors)."'";
    //$filterQuery = $wpdb->get_results("SELECT wpp.post_id FROM wp_postmeta AS wpp INNER JOIN wp_terms AS wpt ON wpp.meta_value = wpt.term_id WHERE meta_key = 'product_data_product_color_name' AND wpt.slug IN ($colors_stmt);");
    $filterQuery    = $wpdb->get_results("SELECT wpp.post_id FROM wp_postmeta AS wpp INNER JOIN wp_posts AS wps ON wps.ID = wpp.post_id WHERE wps.post_status = 'publish' AND wpp.meta_key = 'product_data_product_color_name' AND wpp.meta_value IN ($colors_stmt)");
    $products_ids_q = array();
    if(!empty($filterQuery)){
      foreach($filterQuery as $filterQ){
        $show_product = false;
        if($type == 'product_cat' && !empty($slug)){
          $terms = get_the_terms($filterQ->post_id, 'product_cat');
          if(!empty($terms)){
            foreach($terms as $term){
              if($term->slug == $slug){
                $show_product = true;
                break;
              }
            }
          }
        }
        // echo '<pre>';
        // var_dump($show_product);
        // echo '</pre>';
        if($show_product == true){
          $products_ids_q[] = $filterQ->post_id;
        }
      }
    }
    $ajaxArgs['post__in'] = $products_ids_q;
  }
  $products_ids =  get_posts($ajaxArgs);
  //echo get_template_directory().'../theme-parts/product-widget.php';
  
  if(!empty($products_ids)){
   
    foreach($products_ids as $product_id){
      $language = $_POST['lang'];
      global $product_data;
      $product_data = mitch_get_short_product_data($product_id);
      
      //wc_get_template('../theme-parts/product-widget.php' , $product_data);
      //include get_template_directory().'../theme-parts/product-widget.php';
     require get_template_directory().'/theme-parts/product-widget.php';
    
     
    }
  }
  wp_die();
}

function mitch_add_recently_viewed_product(){
  $current_product_id = get_the_id();
  if(isset($_COOKIE['recently_viewed_products'])){
    $recently_ids   = json_decode($_COOKIE['recently_viewed_products'], true);
    $recently_ids[] = $current_product_id;
  }else{
    $recently_ids   = array();
    $recently_ids[] = $current_product_id;
  }
  $recently_json  = json_encode(array_unique($recently_ids));
  setcookie('recently_viewed_products', $recently_json, time() + (86400 * 30), "/");
}

function mitch_get_recently_viewed_products_ids(){

  if(isset($_COOKIE['recently_viewed_products'])){
    return json_decode($_COOKIE['recently_viewed_products'], true);
  }else{
    return;
  }
}

function mitch_get_related_products($product_id, $product_category_ids){
  if(!empty($product_category_ids) && !empty($product_id)){
    return get_posts(array(
      'orderby'     => 'rand',
      'order'       => 'DESC',
      'post_type'   => 'product',
      'numberposts' => 4, 
      'post_status' => 'publish',
      'fields'      => 'ids',
      'exclude'     => array($product_id),
      'tax_query'   => array(
         array(
          'taxonomy' => 'product_cat',
          'field'    => 'id',
          'terms'    => $product_category_ids,
          'operator' => 'IN',
         )
      ),
     ));
  }else{
    return;
  }
}

function mitch_get_products_on_sale(){
  // $sale_products = wc_get_product_ids_on_sale();
  $args = array(
    'fields'         => 'ids',
    'post_type'      => 'product',
    'posts_per_page' => 8,
    'meta_query'     => array(
      'relation' => 'OR',
      array( // Simple products type
        'key'           => '_sale_price',
        'value'         => 0,
        'compare'       => '>',
        'type'          => 'numeric'
      ),
      array( // Variable products type
        'key'           => '_min_variation_sale_price',
        'value'         => 0,
        'compare'       => '>',
        'type'          => 'numeric'
      )
    ),
    'tax_query'   => array(
      'relation'       => 'AND',
  			array(
  				'taxonomy'         => 'product_visibility',
  				'terms'            => array('exclude-from-catalog', 'exclude-from-search'),
  				'field'            => 'name',
  				'operator'         => 'NOT IN',
  				'include_children' => false,
  			),
    ),
    'post__in' => wc_get_product_ids_on_sale()
  );
  return get_posts($args);
  // var_dump($sale_products);
}

// Register Custom Taxonomy
function mitch_custom_taxonomy_collection(){
    $labels = array(
      'name'                       => 'Collections',
      'singular_name'              => 'Collection',
      'menu_name'                  => 'Collections',
      'all_items'                  => 'All Collections',
      'parent_item'                => 'Parent Collection',
      'parent_item_colon'          => 'Parent Collection:',
      'new_item_name'              => 'New Collection Name',
      'add_new_item'               => 'Add New Collection',
      'edit_item'                  => 'Edit Collection',
      'update_item'                => 'Update Collection',
      'separate_items_with_commas' => 'Separate Collection with commas',
      'search_items'               => 'Search Collections',
      'add_or_remove_items'        => 'Add or remove Collections',
      'choose_from_most_used'      => 'Choose from the most used Collections',
    );
    $args = array(
      'labels'                     => $labels,
      'hierarchical'               => true,
      'public'                     => true,
      'show_ui'                    => true,
      'show_admin_column'          => true,
      'show_in_nav_menus'          => true,
      'show_tagcloud'              => true,
    );
    register_taxonomy('collections', 'product', $args );
}
add_action('init', 'mitch_custom_taxonomy_collection', 0);

function mitch_custom_taxonomy_theme(){
  $labels = array(
    'name'                       => 'Themes',
    'singular_name'              => 'Theme',
    'menu_name'                  => 'Themes',
    'all_items'                  => 'All Themes',
    'parent_item'                => 'Parent Theme',
    'parent_item_colon'          => 'Parent Theme:',
    'new_item_name'              => 'New Theme Name',
    'add_new_item'               => 'Add New Theme',
    'edit_item'                  => 'Edit Theme',
    'update_item'                => 'Update Theme',
    'separate_items_with_commas' => 'Separate Theme with commas',
    'search_items'               => 'Search Themes',
    'add_or_remove_items'        => 'Add or remove Theme',
    'choose_from_most_used'      => 'Choose from the most used Themes',
  );
  $args = array(
    'labels'                     => $labels,
    'hierarchical'               => true,
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
  );
  register_taxonomy('themes', 'product', $args);
}
add_action('init', 'mitch_custom_taxonomy_theme', 0);

function mitch_generate_featured_image($image_url, $post_id){
	$upload_dir = wp_upload_dir();
	$image_data = file_get_contents($image_url);
	$filename = basename($image_url);
	if(wp_mkdir_p($upload_dir['path']))     $file = $upload_dir['path'] . '/' . $filename;
	else                                    $file = $upload_dir['basedir'] . '/' . $filename;
	file_put_contents($file, $image_data);
  
	$wp_filetype = wp_check_filetype($filename, null);
	$attachment  = array(
		'post_mime_type' => $wp_filetype['type'],
		'post_title' => sanitize_file_name($filename),
		'post_content' => '',
		'post_status' => 'inherit'
	);
	$attach_id = wp_insert_attachment($attachment, $file, $post_id);
	require_once(ABSPATH . 'wp-admin/includes/image.php');
	$attach_data = wp_generate_attachment_metadata($attach_id, $file);
	$res1        = wp_update_attachment_metadata($attach_id, $attach_data);
	$res2		     = set_post_thumbnail($post_id, $attach_id);
}
function mitch_register_export_products_images_sheet_page(){
	add_submenu_page(
		'edit.php?post_type=product',
    __('Export Products Images Sheet', 'MD_mitchdesigns'),
    __('Export Products Images Sheet', 'MD_mitchdesigns'),
    'manage_options',
    'export_products_images_sheet',
    'mitch_export_products_images_sheet_page_content'
	);
}
add_action('admin_menu', 'mitch_register_export_products_images_sheet_page');

function mitch_export_products_images_sheet_page_content(){
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    global $wpdb;
    $count          = 2;
    $type           = sanitize_text_field($_POST['products_type']);
    $status         = sanitize_text_field($_POST['products_status']);
    $current_date   = current_time('Y_m_d');
    $filename       = 'MD_mitchdesigns_products_images_'.$type.'_'.$current_date.'.csv';     
    $base_url       = 'http://mdtest.com.php7-34.lan3-1.websitetestlink.com/hedayamasreya/';
    header('Content-Description: File Transfer');
    header('Content-Type: application/csv');
    header("Content-Disposition: attachment; filename=$filename");
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    if($type == 'simple'){
      $csv_header     = array(
        'SKU',
        'BaseURL',
        'Gall-',
        'Extension',
        'Images',
        'Thumb-',
      );
    }elseif($type == 'variable'){
      $csv_header     = array(
        'SKU',
        'Parent',
        'Attributes',
        'DefaultAttr',
        'DefaultAttr-lower',
        'BaseURL',
        'Gall-',
        'Extension',
        'Images',
        'Thumb-',
        'Dash',
        'Lowersize',
        'Mix'
      );
    }
    
    $handle = fopen('php://output', 'w');
    ob_clean();                       //clean slate
    fputcsv($handle, $csv_header);   //direct to buffered output
    $exported_products = $wpdb->get_results("SELECT ID FROM wp_posts WHERE post_type = 'product' AND post_status = '$status'");
    if(!empty($exported_products)){
      foreach($exported_products as $exported_product){
        $product_id   = $exported_product->ID;
        $product_type = get_the_terms($product_id, 'product_type')[0]->slug;
        $product_sku  = get_post_meta($product_id, '_sku', true);
        $CONCATENATE  = '';
        if($product_type == 'simple' && $type == 'simple'){
          $csv_data = array(
            $product_sku,
            $base_url,
            "gall-",
            ".jpg",
            $CONCATENATE,
            "thumb-"
          );
        }elseif($product_type == 'variable' && $type == 'variable'){
          $pa_size     = '';
          $defaults    = get_post_meta($product_id, '_default_attributes', true);
          $attributes  = array();
          $childs      = $wpdb->get_results("SELECT ID FROM wp_posts WHERE post_type = 'product_variation' AND post_status = '$status' AND post_parent = $product_id ORDER BY ID ASC");
          if(!empty($childs)){
            foreach($childs as $child){
              $pa_size   = ucfirst(get_post_meta($child->ID, 'attribute_pa_size', true));
              $pa_color  = ucfirst(get_post_meta($child->ID, 'attribute_pa_color', true));
              if(!empty($pa_size)){
                $attributes[] = $pa_size;
              }
              if(!empty($pa_color)){
                $attributes[] = $pa_color;
              }
            }
          }
          $csv_data    = array(
              $product_sku,
              "0",
              implode(',', $attributes),
              $pa_size,
              $pa_size,
              $base_url,
              "gall-",
              ".jpg",
              $CONCATENATE,
              "thumb-",
              "-",
              $pa_size,
              $product_sku
          );
        }
        fputcsv($handle, $csv_data);
        $count++;
      }
    }
    ob_flush();                     //dump buffer
    fclose($handle);
    die();		
  }
  ?>
<div class="form-page site-main">
	<div class="grid">
		<div class="page-title" style="text-align:center;">
			<h1 style="text-align: center;">Export Products Images Sheet</h1>
			<!-- <h2 style="color:red;">Please Not That Sheet Cols Must Be In This Order</h2> -->
			<!-- <h2>Position | Name | SKU</h2> -->
		</div>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css"
			integrity="sha512-yVvxUQV0QESBt1SyZbNJMAwyKvFTLMyXSyBHDO4BG5t7k/Lw34tyqlSDlKIrIENIzCl+RVUNjmCPG+V/GMesRw=="
			crossorigin="anonymous" referrerpolicy="no-referrer" />
		<div class="form"
			style="position:relative;width: 500px;margin: 0 auto;background: #fff;border-radius: 20px;max-width: 100%;">
			<form method="POST" action="#" style="max-width: 300px;margin: 0px auto;padding: 30px;"
				enctype="multipart/form-data">
				<!--<p class="form-group">
					<label style="display:block;" for="note"><span style="color:red;">*</span>Upload CSV File</label>
					<input style="width: 100%;height: 35px;background: #222;color: #fff;" type="file" name="csv_file" class="form-field" accept=".csv" required/>
					</p>-->
				<div class="form-group">
					<label style="display:block" for="products_status"><span style="color:red;">*</span>Products Type</label>
					<select style="width: 100%;height: 35px;" name="products_type" class="form-field mitch_custom_select"
						required>
						<option value="">Choose Type</option>
						<option value="simple">Simple</option>
						<option value="variable">Variable</option>
					</select>
				</div>
				<div class="form-group">
					<label style="display:block" for="products_status"><span style="color:red;">*</span>Products Status</label>
					<select style="width: 100%;height: 35px;" name="products_status" class="form-field mitch_custom_select"
						required>
						<option value="">Choose Status</option>
						<option value="publish">Publish</option>
						<option value="draft">Draft</option>
						<option value="pending">Pending</option>
					</select>
				</div>
				<br><br>
				<input
					style="width: 100%;height: 45px;background-color: #000;border: none;color: #fff;font-size: 16px;text-transform: uppercase;cursor: pointer;"
					type="submit" id="searchSubmit" value="<?php echo esc_attr_x( 'Download', 'Download' ) ?>" />
			</form>
		</div>
	</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"
	integrity="sha512-rMGGF4wg1R73ehtnxXBt5mbUfN9JUJwbk21KMlnLZDJh7BkPmeovBuddZCENJddHYYMkCh9hPFnPmS9sspki8g=="
	crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
jQuery(document).ready(function() {
	jQuery(".mitch_custom_select").chosen({
		disable_search_threshold: 1,
		allow_single_deselect: true,
		disable_search: false,
		no_results_text: "Oops, nothing found!",
		width: "95%"
	})
});
</script>
<?php 
}

function mitch_single_product_reviews_avg(){
  return 'HI2';
}

//Search Function 
function Search_By_Product_Name($Keyword , $limit){
  global $wp_query;
  $params = array(
      'posts_per_page' => $limit,  
      'post_type'      => 'product', 
      's'              => $Keyword,  
      'post_status'    => 'publish', 
      'tax_query'      => array(
  			'relation'     => 'AND',
  			array(
  				'taxonomy'         => 'product_visibility',
  				'terms'            => array('exclude-from-catalog', 'exclude-from-search'),
  				'field'            => 'slug',
  				'operator'         => 'Not IN',
  				'include_children' => false,
  			),
  		),
  );
  $wc_query = new WP_Query($params);
  if($wc_query->post_count < intval($limit)){
    $params = array(
      'posts_per_page' => $limit,  
      'post_type'      => 'product', 
      'post_status'    => 'publish', 
      'meta_query' => array(
				'relation' => 'OR',
				array(
					'key' => 'product_data_arabic_title',
					'value' => $Keyword,
					'compare' => 'LIKE'
				),
			),
      'tax_query'      => array(
  			'relation'     => 'AND',
  			array(
  				'taxonomy'         => 'product_visibility',
  				'terms'            => array('exclude-from-catalog', 'exclude-from-search'),
  				'field'            => 'slug',
  				'operator'         => 'Not IN',
  				'include_children' => false,
  			),
  		),
  );
  $wc_query2 = new WP_Query($params);
  $wc_query->post_count = $wc_query->post_count + $wc_query2->post_count;
  $restOfProd = $limit - (int)$wc_query->post_count;
  $wc_query->posts = array_unique(array_merge($wc_query->posts, $wc_query2->posts), SORT_REGULAR);
  }
  return $wc_query;
}

function mitch_on_product_save($post_id, $post, $update){
    /*echo '<pre>';
    var_dump($_POST);
    echo '</pre>';*/
    $product = wc_get_product($post_id);
    if(empty($_POST['_regular_price']) && $product->get_status() != 'draft'){ //$product->get_type() == 'simple' &&   $product->get_status() == 'publish' && empty($product->get_price())
      wp_update_post(array('ID' => $post_id, 'post_status' => 'draft'));
    }
    // exit;
}

function mitch_get_featured_product_ids($limit){

$products_ids = wc_get_featured_product_ids();
shuffle($products_ids);
if(count($products_ids) > $limit){
  $featured = array_slice($products_ids , 0 , $limit);
} else {
  $featured = $products_ids ;
}


return $featured ;
}

// load more products
add_action('wp_ajax_nopriv_get_products_ajax_count', 'get_products_ajax_count');
add_action('wp_ajax_get_products_ajax_count', 'get_products_ajax_count');
function get_products_ajax_count(){
	global $language;
	$action   = sanitize_text_field($_POST['fn_action']);
	$count    = intval($_POST['count']);
	$page     = intval($_POST['page']);
	$offset   = ($page) * $count;
	$order    = sanitize_text_field($_POST['order']);
	$type     = sanitize_text_field($_POST['type']);
	$slug     = sanitize_text_field($_POST['slug']);
	$cat      = sanitize_text_field($_POST['cat']);
	$search   = sanitize_text_field($_POST['search']);
	$ids      = $_POST['ids'];
	$lang     = $_POST['lang'];
  $colors   = (array)$_POST['colors'];
  $sizes    = (array)$_POST['sizes'];
	$ajaxArgs = array();
  $filterQuery = array();
	// if($lang == "en"){
	// 	$language = "en";
	// }else{
	// 	$language = "";
	// }
  /*if(!empty($colors) || !empty($sizes)){
    if(!empty($colors)){
      // $colors[] = 'red';
      // $colors[] = 'blue';
      global $wpdb;
      $colors_stmt  = "'".implode("','", $colors)."'";
      $filterQuery = $wpdb->get_results("SELECT wpp.post_id FROM wp_postmeta AS wpp INNER JOIN wp_terms AS wpt ON wpp.meta_value = wpt.term_id WHERE meta_key = 'product_data_product_color_name' AND wpt.slug IN ($colors_stmt);");
    }
  }else{*/
    if($type=="sale"){
  		// $ajaxQuery = get_on_sale_products_ids(-1,0,$slug,78);
  	}elseif($type=="less_100"){
  		// $ajaxQuery = get_products_less_100_ids(-1,0,$slug,'');
  	}else{
  	$ajaxArgs = array(
  		"post_type"        => 'product',
  		"posts_per_page"   => -1 ,
      "fields"           => 'ids',
  		'post_status'      => 'publish',
  		"suppress_filters" => false,
  		"offset"           => $offset,
  		'tax_query'        => array(
  			'relation'       => 'AND',
  			array(
  				'taxonomy'         => 'product_visibility',
  				'terms'            => array( 'exclude-from-catalog', 'exclude-from-search' ),
  				'field'            => 'name',
  				'operator'         => 'Not IN',
  				'include_children' => false,
  			),
  		),
  		// 'meta_query'=>array(
  		// 	'relation' => 'AND',
  		// 	array(
  		// 		'key' => '_stock_status',
  		// 		'value' => 'instock',
  		// 		'compare' => '=',
  		// 	),
  		// ),
  	);
  	if($search !=""){
  		$ajaxArgs["s"] = $search;
  	}
  	// if($action == "loadmore"){
  	// 	$ajaxArgs["offset"] = $offset;
  	// 	$ajaxArgs["posts_per_page"] = $count;
  	// }else{
  	// 	$ajaxArgs["posts_per_page"] = $offset;
  	// }
  	if($type == 'product_cat'){
  		$ajaxArgs['product_cat'] = $_POST['slug'];
  	}elseif($type == 'new'){
  		$ajaxArgs['date_query'] = array(
  			array('after' => date('Y-m-d', strtotime('-30 days')))
  		);
  	}elseif($type == 'type'){
  		$ajaxArgs['tax_query'][] = array(
  			'taxonomy'=>'type',
  			'field' => 'term_id',
  			'terms' => array($_POST['slug'])
  		);
  	}elseif($type == 'shop'){

  	}elseif($type == 'sale'){
  		// $ajaxArgs['post__in'] = get_on_sale_products_ids_only(0,24,'',78);
  	}else if($type == 'products-list'){
  		$ajaxArgs['post__in'] = $ids;
  	}else if($type == 'total-sales'){
  	}elseif($type == 'less_100'){
  		// $ajaxArgs['post__in'] = get_products_less_100_ids_only(0,24,'','');
  	}else{
  		$ajaxArgs['tax_query'][] = array(
				'taxonomy' => $type,
				'field' => 'term_id',
				'terms' => array($slug),
  		);
  	}
  	if($order == 'price'){
  		$orderby = array(
              'meta_value_num' => 'asc',
              'date' => 'desc',
          );
  		$ajaxArgs['meta_key'] = '_price';
  		$ajaxArgs['orderby'] = $orderby;
  		$ajaxArgs['order'] = 'asc';
  	}else if($order == 'price-desc'){
  		$orderby = array(
              'meta_value_num' => 'desc',
              'date' => 'desc',
          );
  		$ajaxArgs['meta_key'] = '_price';
  		$ajaxArgs['orderby'] = $orderby;
  		$ajaxArgs['order'] = 'desc';
  	}else if($order =='featured'){
  		$orderby = array(
  			'meta_value_num' => 'desc',
  			'date' => 'desc',
  		);
  		$ajaxArgs['meta_key'] = 'featured';
  		$ajaxArgs['orderby'] = $orderby;
  		$ajaxArgs['order'] = 'desc';
  	}
  	else if($order =='date'){
  		// $orderby = array(
  		// 	'meta_value_num' => 'desc',
  		// 	'date' => 'desc',
  		// );
  		// $ajaxArgs['meta_key'] = 'featured';
  		$ajaxArgs['orderby'] ='date';
  		$ajaxArgs['order'] = 'desc';
  	}else if($order == 'popularity'){

  	    $orderby = array(
              'meta_value_num' => 'desc',
              'date' => 'desc',
          );
          $ajaxArgs['meta_key'] = 'total_sales';
          $ajaxArgs['orderby'] = $orderby;
          $ajaxArgs['order'] = 'desc';
  	}else if($order == 'stock'){
  		$orderby = array(
              'meta_value_num' => 'desc',
              'date' => 'desc',
          );
  	    $ajaxArgs['meta_key'] = '_stock_status';
  	    $ajaxArgs['orderby'] = $orderby;
  	    $ajaxArgs['order'] = 'ASC';
  	}else{
  		$orderby = array(
              'meta_value_num' => 'desc',
              'date' => 'desc',
          );

          $ajaxArgs['meta_key'] = 'total_sales';
          $ajaxArgs['orderby'] = $orderby;
          $ajaxArgs['order'] = 'desc';
  	}
  	if($_POST['min_price']!=''){
  		$min_price = intval($_POST['min_price']);
  		$max_price = intval($_POST['max_price']);
  		if($max_price!=0){
  			$ajaxArgs['meta_query'][] = array(
  				'relation' => 'AND',
  				 array(
  					'key' => '_price',
  					'value' => array($min_price,$max_price),
  					'compare' => 'between',
  					'type' => 'numeric'
  				),
  			);
  		}else{
  			$ajaxArgs['meta_query'][] = array(
  			'relation' => 'AND',
              array(
                  'key' => '_price',
                  'value' => $min_price,
  				'compare' => '>=',
  				'type' => 'numeric'
              )
          );
  		}
  	}
  	if($_POST['brand'] && count($_POST['brand'])>0){
  		$brand = $_POST['brand'];
  		$ajaxArgs['tax_query'][]= array(
  			'taxonomy'=>'brand',
  			'field' => 'slug',
  			'terms' => $brand,
  			);
  	}
  	if($_POST['cats'] && count($_POST['cats'])>0){
  		$cats = $_POST['cats'];
  		$ajaxArgs['tax_query'][]= array(
  			'taxonomy'=>'product_cat',
  			'field' => 'slug',
  			'terms' => $cats,
  			);
  	}
  	if($_POST['label'] && count($_POST['label'])>0){
  		$labels = $_POST['label'];
  		$ajaxArgs['tax_query'][]= array(
  			'taxonomy'=>'label',
  			'field' => 'slug',
  			'terms' => $labels,
  		);
  	}
    if(is_countable($_POST['sizes']) && count($_POST['sizes'])>0){
      $terms                   = $_POST['sizes'];
      $ajaxArgs['tax_query'][] = array(
        'taxonomy' => 'pa_size',
        'field'    => 'slug',
        'terms'    => $terms
      );
    }
    if(!empty($colors)){
      // $colors[] = 'red';
      // $colors[] = 'blue';
      global $wpdb;
      $colors_stmt = "'".implode("','", $colors)."'";
      //$filterQuery = $wpdb->get_results("SELECT wpp.post_id FROM wp_postmeta AS wpp INNER JOIN wp_terms AS wpt ON wpp.meta_value = wpt.term_id WHERE meta_key = 'product_data_product_color_name' AND wpt.slug IN ($colors_stmt);");
      $filterQuery    = $wpdb->get_results("SELECT wpp.post_id FROM wp_postmeta AS wpp INNER JOIN wp_posts AS wps ON wps.ID = wpp.post_id WHERE wps.post_status = 'publish' AND wpp.meta_key = 'product_data_product_color_name' AND wpp.meta_value IN ($colors_stmt)");
      $products_ids_q = array();
      if(!empty($filterQuery)){
        foreach($filterQuery as $filterQ){
          $products_ids_q[] = $filterQ->post_id;
        }
      }
      $ajaxArgs['post__in'] = $products_ids_q;
    }
  	$ajaxQuery =  get_posts($ajaxArgs);
  	}
  //}
  if($filterQuery){
    echo count($filterQuery);
  }elseif($ajaxQuery){
		echo count($ajaxQuery);
	}else{
		echo "0";
	}
	wp_die();
}

// For Product Widget 
function MD_product_widget_data($product_id , $language){ 

  //$language = 'en';
  $name = ' ' ;
  $subtitle = ' ' ; 
  $widget_note_text = ' ' ;
  $widget_note = ' ' ;
   
  $Excluded_branches = get_post_meta($product_id, '_branches', true);
  if($language === 'en'){ // English Fields 
    $product  = wc_get_product($product_id);

    $name = $product -> get_name(); 

    if(isset( get_post_meta($product_id , 'product_data_subtitle_en')[0])){
      $subtitle =  get_post_meta($product_id , 'product_data_subtitle_en')[0]; 
    }

    if(isset( get_post_meta($product_id , 'product_data_widget_note_text_en')[0])){
      $widget_note_text = get_post_meta($product_id , 'product_data_widget_note_text_en')[0] ;
    }
    $image_alt = $name . ' - Exception Pastry - Egypt ';

  } else {

    if(isset(get_post_meta($product_id , 'product_data_arabic_title')[0])){
        $name = get_post_meta($product_id , 'product_data_arabic_title')[0];
      } 

    if(isset( get_post_meta($product_id , 'product_data_subtitle_ar')[0])){
      $subtitle =  get_post_meta($product_id , 'product_data_subtitle_ar')[0]; 
    }

    if(isset( get_post_meta($product_id , 'product_data_widget_note_text_ar')[0])){
      $widget_note_text = get_post_meta($product_id , 'product_data_widget_note_text_ar')[0] ;

    }
    $image_alt = $name . ' - حلواني اكسبشن  - مصر ';
   
    
  }
  if(isset(get_post_meta($product_id , 'product_data_widget_note')[0])){
    $widget_note =  get_post_meta($product_id , 'product_data_widget_note')[0];
  }



  
   $data_array = array(
    'name'            => $name ,
    'subtitle'        => $subtitle,
    'widget_note'     => $widget_note,
    'widget_text'     => $widget_note_text ,
    'excluded'        => $Excluded_branches,
    'image_alt'       => $image_alt,
    'custom_cake'       => get_post_meta($product_id , 'product_data_custom_cake' , true),
   );
   return $data_array;

} 


function MD_single_product_data($product_id){
  global $language ;
  $name =' ';
  $desc_field = ' ' ;
  $short_desc_field = ' ' ;
  $Excluded_branches = get_post_meta($product_id, '_branches', true);

  if($language == 'en'){ // English Fields 
    $product  = wc_get_product($product_id);
    $name = $product -> get_name();
    $desc_field = $product->get_description(); 
    $short_desc_field = $product->get_short_description();
    $image_alt = $name . ' - Exception Pastry - Egypt ';

  }else { // Arabic Fields 
      if(isset(get_post_meta($product_id , 'product_data_arabic_title')[0])){
        $name = get_post_meta($product_id , 'product_data_arabic_title')[0];
      } 
      if( isset( get_post_meta($product_id , 'product_data_arabic_desc')[0] )){
        $desc_field  = get_post_meta($product_id , 'product_data_arabic_desc')[0]; 
      }

      if( isset(get_post_meta($product_id , 'product_data_arabic_short_description')[0] )){
        $short_desc_field  = get_post_meta($product_id , 'product_data_arabic_short_description')[0]; 
      }
      $image_alt = $name . ' - حلواني اكسبشن  - مصر ';
  } 

  

    $data_array = array(
        'name'              => $name ,
        'short_desc'        => $short_desc_field ,
        'desc'              => $desc_field,
        'excluded'          => $Excluded_branches,
        'image_alt'         =>$image_alt,
        'custom_cake'       => get_post_meta($product_id , 'product_data_custom_cake' , true),
      ); 
      return $data_array ; 
      
        


  }