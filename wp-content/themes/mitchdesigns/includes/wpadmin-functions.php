<?php
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> 'Theme General Settings',
		'menu_title'	=> 'Theme Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Top Header',
		'menu_title'	=> 'Top Header',
		'parent_slug'	=> 'theme-general-settings',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Header & Footer Settings',
		'menu_title'	=> 'Header & Footer',
		'parent_slug'	=> 'theme-general-settings',
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'States And Cities',
		'menu_title'	=> 'States And Cities',
		'parent_slug'	=> 'theme-general-settings',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Size Guide',
		'menu_title'	=> 'Size Guide',
		'parent_slug'	=> 'theme-general-settings',
	));
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Customer reviews',
		'menu_title'	=> 'Customer reviews',
		'parent_slug'	=> 'theme-general-settings',
	));

	// acf_add_options_sub_page(array(
	// 	'page_title' 	=> 'Points System',
	// 	'menu_title'	=> 'Points System',
	// 	'parent_slug'	=> 'theme-general-settings',
	// ));

	// acf_add_options_sub_page(array(
	// 	'page_title' 	=> 'Exchange Rates',
	// 	'menu_title'	=> 'Exchange Rates',
	// 	'parent_slug'	=> 'theme-general-settings',
	// ));
	// acf_add_options_sub_page(array(
	// 	'page_title' 	=> 'Shop Settings',
	// 	'menu_title'	=> 'Shop Settings',
	// 	'parent_slug'	=> 'theme-general-settings',
	// ));
}
function mitch_wpadmin_custom_style() {
  wp_enqueue_style('mitch-wpadmin-custom-styles', get_template_directory_uri().'/wpadmin-custom.css');
}
add_action('admin_enqueue_scripts', 'mitch_wpadmin_custom_style');

add_action('admin_head', 'mitch_hide_notices_wp');
function mitch_hide_notices_wp() {
	global $post;
	if($post){
		if($post->post_type == 'shop_order'){
			if(empty(get_post_meta($post->ID, 'order_visit_type', true))){
				?>
				<style>#acf-group_61f85b960ba86{display: none !important;}</style>
				<?php
			}
		}
	}
	?>
	<style> .widefat.plugins .notice { display: none;} .column-product_type{width:100px !important;}</style>
	<?php
}

add_filter('manage_edit-shop_order_columns', 'mitch_add_order_column_to_admin_table');
function mitch_add_order_column_to_admin_table($columns){
  $columns['billing_details'] = 'Billing Info';
  return $columns;
}

add_action('manage_shop_order_posts_custom_column', 'mitch_add_order_column_to_admin_table_content');
function mitch_add_order_column_to_admin_table_content($column){
  global $post;
  if('billing_details' === $column){
    $order = wc_get_order($post->ID);
  	echo $order->get_billing_first_name(); echo " ";
    echo $order->get_billing_last_name(); echo "<br />";
    echo $order->get_billing_company(); echo "<br />";
    echo $order->get_billing_address_1(); echo ", ";
    echo $order->get_billing_address_2(); echo "<br />";
    echo $order->get_billing_city(); echo ", ";
    echo $order->get_billing_state(); echo ", ";
    echo $order->get_billing_postcode(); echo ", ";
    echo $order->get_billing_country(); echo "<br />";
    echo $order->get_billing_email(); echo "<br />";
    echo $order->get_billing_phone();
  }
}

function mitch_register_custom_order_status() {
	register_post_status('wc-shipped', array(
	  'label'                     => 'Shipped',
	  'public'                    => true,
	  'exclude_from_search'       => false,
	  'show_in_admin_all_list'    => true,
	  'show_in_admin_status_list' => true,
	  'label_count'               => _n_noop('Shipped <span class="count">(%s)</span>', 'Shipped <span class="count">(%s)</span>')
	));
	register_post_status('wc-ready-to-ship', array(
	  'label'                     => 'Ready to Ship',
	  'public'                    => true,
	  'exclude_from_search'       => false,
	  'show_in_admin_all_list'    => true,
	  'show_in_admin_status_list' => true,
	  'label_count'               => _n_noop('Ready to Ship <span class="count">(%s)</span>', 'Ready to Ship <span class="count">(%s)</span>')
	));
}
add_action('init', 'mitch_register_custom_order_status');
add_filter('wc_order_statuses', 'mitch_custom_order_status');
function mitch_custom_order_status($order_statuses){
	$order_statuses['wc-shipped'] = _x('Shipped', 'Order status', 'woocommerce');
	$order_statuses['wc-ready-to-ship']   = _x('Ready to Ship', 'Order status', 'woocommerce');
	return $order_statuses;
}

// add_action('woocommerce_order_status_changed','mitch_status_changed_cancelled');
// function mitch_status_changed_cancelled($order_id, $checkout = null){
// 	if(get_post_status($order_id) == 'wc-cancelled'){
// 		update_post_meta($order_id, 'order_cancelled_date', current_time('F j, Y'));
// 	}elseif(get_post_status($order_id) == 'wc-refunded'){
// 		update_post_meta($order_id, 'order_refunded_date', current_time('F j, Y'));
// 	}
// }


// Adds a custom rule type.
add_filter( 'acf/location/rule_types', function( $choices ){
    $choices[ __("Other",'acf') ]['wc_prod_attr'] = 'WC Product Attribute';
    return $choices;
} );

// Adds custom rule values.
add_filter( 'acf/location/rule_values/wc_prod_attr', function( $choices ){
    foreach ( wc_get_attribute_taxonomies() as $attr ) {
        $pa_name = wc_attribute_taxonomy_name( $attr->attribute_name );
        $choices[ $pa_name ] = $attr->attribute_label;
    }
    return $choices;
} );

// Matching the custom rule.
add_filter( 'acf/location/rule_match/wc_prod_attr', function( $match, $rule, $options ){
    if ( isset( $options['taxonomy'] ) ) {
        if ( '==' === $rule['operator'] ) {
            $match = $rule['value'] === $options['taxonomy'];
        } elseif ( '!=' === $rule['operator'] ) {
            $match = $rule['value'] !== $options['taxonomy'];
        }
    }
    return $match;
}, 10, 3 );

add_filter('manage_edit-product_columns', 'mitch_admin_products_type_column', 9999 );
function mitch_admin_products_type_column($columns){
	$columns['product_type'] = 'Product Type';
	return $columns;
}
add_filter( 'manage_product_posts_columns', 'add_custom_field_column' );
function add_custom_field_column( $columns ) {
    $columns['arabic_name'] = __( 'Product Arabic Title', 'text-domain' );
    return $columns;
}

add_action('manage_product_posts_custom_column', 'mitch_admin_products_type_column_content', 10, 2);
function mitch_admin_products_type_column_content($column, $product_id){
	if($column == 'product_type'){
		// $product = wc_get_product($product_id);
		// echo $product->get_type();
		if(get_field('product_extra_data_product_customized', $product_id)){
			echo 'Customized';
		}else{
			$terms = get_the_terms($product_id, 'product_type')[0];
			if(!empty($terms)){
				echo ucfirst($terms->name);
			}
		}
	}
	if($column == 'arabic_name'){
		echo get_post_meta($product_id , 'product_data_arabic_title')[0] . ' ';
	}

}

add_filter('acf/load_field/name=base_currency', 'mitch_make_base_currency_disabled');
function mitch_make_base_currency_disabled( $field ){ $field['disabled']='1'; return $field; }

// add_filter('acf/load_field/name=order_visit_branch', 'mitch_make_order_visit_branch_disabled');
// function mitch_make_order_visit_branch_disabled( $field ){ $field['disabled']='1'; return $field; }
//
// add_filter('acf/load_field/name=order_visit_home', 'mitch_make_order_visit_home_disabled');
// function mitch_make_order_visit_home_disabled( $field ){ $field['disabled']='1'; return $field; }


// Register New Order Statuses
function mitch_register_backorder_status(){
	register_post_status('wc-backorder', array(
		'label'                     => 'Backorder',
		'public'                    => true,
		'exclude_from_search'       => false,
		'show_in_admin_all_list'    => true,
		'show_in_admin_status_list' => true,
		'label_count'               => _n_noop('Backorder (%s)', 'Backorder (%s)')
	));
}
add_filter('init', 'mitch_register_backorder_status');
// Add New Order Statuses to WooCommerce
function mitch_add_backorder_status($order_statuses){
	$order_statuses['wc-backorder'] = _x('Backorder', 'WooCommerce Order status', 'mitchdesigns');
	return $order_statuses;
}
add_filter('wc_order_statuses', 'mitch_add_backorder_status');

function mitch_register_fulfilled_order_status(){
	register_post_status('wc-fulfilled', array(
		'label'                     => 'Fulfilled',
		'public'                    => true,
		'exclude_from_search'       => false,
		'show_in_admin_all_list'    => true,
		'show_in_admin_status_list' => true,
		'label_count'               => _n_noop('Fulfilled (%s)', 'Fulfilled (%s)')
	) );
}
add_action('init', 'mitch_register_fulfilled_order_status');
function mitch_add_fulfilled_to_order_statuses($order_statuses){
	$order_statuses['wc-fulfilled'] = _x('Fulfilled', 'WooCommerce Order status', 'mitchdesigns');
	return $order_statuses;
}
add_filter('wc_order_statuses', 'mitch_add_fulfilled_to_order_statuses');

// Display Arabic Product title in Order backend 
add_action( 'woocommerce_admin_order_item_headers', 'add_custom_order_item_header' );
function add_custom_order_item_header() {
    echo '<th>Arabic Name</th>';
}
// Add custom field to each product item in order
add_action( 'woocommerce_admin_order_item_values', 'add_custom_field_to_order_item', 10, 3 );
function add_custom_field_to_order_item( $product, $item, $item_id ) {
	if ( $product && is_object( $product ) && method_exists( $product, 'get_type' ) ) {
	if($product->get_type() == "simple"){
		$custom_field_value = get_post_meta($product->get_id() , 'product_data_arabic_title')[0] ; 
	}else {

		$product_obj = wc_get_product($product->get_id());
		$product_parent = wc_get_product( $product_obj->get_parent_id() );
		$custom_field_value = get_post_meta($product_parent->get_id() , 'product_data_arabic_title')[0] ;
	}
	printf( '<td class="my-custom-field">%s</td>', esc_html( $custom_field_value ) );
}
  
   
}




//Branches
function Branches() {

	$supports = array(
		'title', // post title
		'thumbnail', // featured images
		// 'excerpt', // post excerpt

	);

	$labels = array(
		'name' => _x('Branches', 'plural'),
		'singular_name' => _x('Branch', 'singular'),
		'menu_name' => _x('Branches', 'admin menu'),
		'name_admin_bar' => _x('Branches', 'admin bar'),
		'add_new' => _x('Add New', 'add new'),
		'add_new_item' => __('Add New Branch'),
		'new_item' => __('New Branch'),
		'edit_item' => __('Edit Branch'),
		'view_item' => __('View Branches'),
		'all_items' => __('All Branches'),
		'search_items' => __('Search Branch'),
		'not_found' => __('No Branches found.'),
	);

	$args = array(
		'supports' => $supports,
		'labels' => $labels,
		'public' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'branch'),
		'has_archive' => true,
		'hierarchical' => false,
	);
	register_post_type('branch', $args);
}

add_action('init', 'Branches');


add_action('init', 'mitch_add_city_type_taxonomy_branches');
function mitch_add_city_type_taxonomy_branches()
{
	
  // Labels part for the GUI
  $labels = array(
    'name'          => __('Branch type', 'taxonomy general name'),
    'singular_name' => _x('Branch type', 'taxonomy singular name'),
    'search_items' =>  __('Search Branch type'),
    'all_items' => __('All Branch types'),
    'parent_item' => __('Parent Branch type'),
    'parent_item_colon' => __('Parent Branch type:'),
    'edit_item' => __('Edit Branch type'),
    'update_item' => __('Update Branch type'),
    'add_new_item' => __('Add New Branch type'),
    'new_item_name' => __('New Branch type'),
    'menu_name'     => __('Cities'),
  );

  register_taxonomy('cities', array('branch'), array(
    'hierarchical'          => true,
    'labels'                => $labels,
    'show_ui'               => true,
    'show_in_rest'          => true,
    'show_admin_column'     => false,
    'update_count_callback' => '_update_post_term_count',
    'query_var'             => true,
    'rewrite'               => array('slug' => 'cities'),
  ));
}

require_once 'branches-functions.php';


//Special-Cake
function Specialcake() {

	$supports = array(
		'title', // post title
		'thumbnail', // featured images
		// 'excerpt', // post excerpt
	);

	$labels = array(
		'name' => _x('specialcake', 'plural'),
		'singular_name' => _x('specialcake', 'singular'),
		'menu_name' => _x('Special Cake', 'admin menu'),
		'name_admin_bar' => _x('specialcake', 'admin bar'),
		'add_new' => _x('Add New', 'add new'),
		'add_new_item' => __('Add New specialcake'),
		'new_item' => __('New specialcake'),
		'edit_item' => __('Edit specialcake'),
		'view_item' => __('View specialcake'),
		'all_items' => __('All specialcake'),
		'search_items' => __('Search specialcake'),
		'not_found' => __('No specialcake found.'),
	);

	$args = array(
		'supports' => $supports,
		'labels' => $labels,
		'public' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'specialcake'),
		'has_archive' => true,
		'hierarchical' => false,
	);
	register_post_type('specialcake', $args);
}

add_action('init', 'specialcake');
