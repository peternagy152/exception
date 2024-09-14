<?php
add_action('rest_api_init', function () {
    register_rest_route('api/v2', '/products/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'single_product_callback',
        'permission_callback' => 'is_user_logged_in',
    ));
});
function single_product_callback(WP_REST_Request $request) {
    $user = wp_get_current_user();
    $request_data = $request->get_json_params();
    $branch_id = $request_data['branch_id'] ?? -1 ;
    $product = wc_get_product($request['id']);
    if(!$product){
        return new WP_Error('invalid_product', 'Invalid product id', array('status' => 400));
    }
    $cat = get_the_terms($product->get_id(), 'product_cat')[0];

    $excluded_branches = get_post_meta($request['id'], '_branches', true);
    $excluded = false ;
    if(in_array( $branch_id , $excluded_branches)){$excluded = true;}
    if($product->get_stock_status() == "outofstock" ){$stock_status = 'outofstock';} else{
        if($excluded){$stock_status = 'unavailable';}else{$stock_status = 'instock';}
    }

    $liked = mitch_check_wishlist_product($user->ID, $request['id']);
    if ($liked) {$liked = true;}else{$liked=false;}

    $data = [
        "slug" => $product->get_slug() ,
        "liked" => $liked ,
        "rating" => $product->get_average_rating() ,
        "type" => $product->get_type(),
        "name_en" => $product->get_title(),
        "name_ar" => get_post_meta($request['id'], 'product_data_arabic_title', true),
        "desc_en" => $product->get_description(),
        "desc_ar" => get_post_meta($request['id'], 'product_data_arabic_desc', true),
        "short_desc_en" =>    $product->get_short_description(),
        "short_desc_ar" => get_post_meta($request['id'], 'product_data_arabic_short_description', true),
        "images" => mitch_get_product_images($product->get_image_id(), $product->get_gallery_image_ids()) ,
        'category_slug' => $cat->slug,
        'category_name' => html_entity_decode($cat->name),
        'category_name_ar' => get_term_meta($cat->term_id, "attribute_in_arabic", true),
        'price' => $product->get_price(),
        'is_on_sale' => $product->is_on_sale(),
        'regular_price' => $product->get_regular_price(),
        'stock' => $stock_status,

    ];
    if ($product->get_type() === 'variable') {
        $multi_lang_attributes = [] ;
        $variation_attributes = $product->get_variation_attributes();
        foreach($variation_attributes as $attribute_taxonomy => $term_slug ) {
            $taxonomy = str_replace('attribute_', '', $attribute_taxonomy );
            $multi_lang_attributes [$attribute_taxonomy] = [] ;
            foreach($term_slug as $one_term_slug){
                $term = get_terms( array(
                    'taxonomy' => $taxonomy,
                    'slug' => $one_term_slug ,
                    'fields' => 'ids'
                ) );
                $attribute_arabic =  get_term_meta($term[0], 'attribute_in_arabic', true);
                $attribute_english = get_term_by( 'slug', $one_term_slug, $taxonomy )->name;
                $variations_data= [
                    "slug" => $one_term_slug ,
                    "arabic_name" => $attribute_arabic ,
                    "english_name" => $attribute_english ,
                ];
                $multi_lang_attributes [$attribute_taxonomy][]  = $variations_data ;
            }
        }
        $data['attributes'] = $multi_lang_attributes ;
        $variations = $product->get_available_variations();
        foreach ($variations as $variation) {
            $sale_price =  $variation['display_price'];
            $data['variations'][] = [
                'id' => $variation['variation_id'],
                'attributes' => $variation['attributes'],
                'price' => $variation['display_regular_price'],
                'sale_price' => $sale_price,
            ];
        }
    }
    return new WP_REST_Response($data, 200);


}


add_action('rest_api_init', function () {
    register_rest_route('api/v2', '/products', array(
        'methods' => 'GET',
        'callback' => 'get_products_callback',
        'permission_callback' => 'is_user_logged_in',
    ));
});
function get_products_callback(WP_REST_Request $request){
    $user = wp_get_current_user();
    $request_data = $request->get_json_params();

    $page = $request_data['page'] ?? 1 ;
    $products_per_page = $request_data['products_per_page'] ?? 10 ;
    $category = $request_data['category'] ?? [];
    $order = $request_data['order'] ?? "best-sellers" ;
    $branch_id = $request_data['branch_id'] ?? -1;
    $keyword = $request_data["keyword"] ?? "" ;


    $args = array(
        'posts_per_page' => $products_per_page,
        'paged' => $page,
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
    if(!empty($category)){
        $args['tax_query'][] = array(
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => $category,
        );
    }
    if($order == 'price'){
        $orderby              = array('meta_value_num' => 'asc', 'date' => 'desc',);
        $args['meta_key'] = '_price';
        $args['orderby']  = $orderby;
        $args['order']    = 'asc';
    }elseif($order == 'price-desc'){
        $orderby              = array('meta_value_num' => 'desc', 'date' => 'desc');
        $args['meta_key'] = '_price';
        $args['orderby']  = $orderby;
        $args['order']    = 'desc';
    }elseif($order == 'date'){
        $args['orderby'] = 'date';
        $args['order']   = 'desc';
    }else{
        $orderby              = array('meta_value_num' => 'desc', 'date' => 'desc');
        $args['meta_key'] = 'total_sales';
        $args['orderby']  = $orderby;
        $args['order']    = 'desc';
    }

    $products = get_posts($args);
    $data = [] ;
    foreach ($products as $one_product) {
        $data [] = product_widget($one_product , $user->ID , $branch_id);
    }

    return $data;


}




add_action('rest_api_init', function () {
    register_rest_route('api/v2', 'products/new-arrivals', array(
        'methods' => 'GET',
        'callback' => 'get_new_arrivals_callback',
        'permission_callback' => 'is_user_logged_in',
    ));
});
function get_new_arrivals_callback(WP_REST_Request $request){
    $user = wp_get_current_user();
    $request_data = $request->get_json_params();
    $branch_id = $request_data['branch_id'] ?? -1 ;
    $limit = $request_data['limit'] ?? 10 ;
    $args = array(
        'post_type'      => 'product',
        'fields'         => 'ids',
        'posts_per_page' => $limit,
        'order_by'       => 'date',
        'order'          => 'desc',
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
    );
    $products = get_posts($args);
    $data = [] ;
    foreach ($products as $one_product) {
        $data [] = product_widget($one_product , $user->ID , $branch_id);
    }

    return $data;

}


add_action('rest_api_init', function () {
    register_rest_route('api/v2', '/products/best-sellers', array(
        'methods' => 'GET',
        'callback' => 'get_best_sellers_callback',
        'permission_callback' => 'is_user_logged_in',
    ));
});
function get_best_sellers_callback(WP_REST_Request $request){
    $user = wp_get_current_user();
    $request_data = $request->get_json_params();
    $branch_id = $request_data['branch_id'] ?? -1 ;
    $limit = $request_data['limit'] ?? 10 ;

    $args = array(
        'post_type'      => 'product',
        'meta_key'       => 'total_sales',
        'orderby'        => 'meta_value_num',
        'fields'         => 'ids',
        'posts_per_page' => $limit,
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
    );
    $products = get_posts($args);
    $data = [] ;
    foreach ($products as $one_product) {
        $data [] = product_widget($one_product , $user->ID , $branch_id);
    }

    return $data;

}



add_action('rest_api_init', function () {
    register_rest_route('api/v2', '/products/random-products', array(
        'methods' => 'GET',
        'callback' => 'get_random_products_callback',
        'permission_callback' => 'is_user_logged_in',
    ));
});
function get_random_products_callback(WP_REST_Request $request){
    $user = wp_get_current_user();
    $request_data = $request->get_json_params();
    $branch_id = $request_data['branch_id'] ?? -1 ;
    $limit = $request_data['limit'] ?? 10 ;

    $args = array(
        'post_type'      => 'product',
        'fields'         => 'ids',
        'posts_per_page' => $limit,
        'orderby'          => 'rand',
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
    );
    $products = get_posts($args);
    $data = [] ;
    foreach ($products as $one_product) {
        $data [] = product_widget($one_product , $user->ID , $branch_id);
    }

    return $data;

}

add_action('rest_api_init', function () {
    register_rest_route('api/v2', '/categories', array(
        'methods' => 'GET',
        'callback' => 'get_categories_with_subcategories',
        'permission_callback' => '__return_true',
    ));
});

function get_categories_with_subcategories(WP_REST_Request $request) {
    $slug = $request->get_param('slug');
    function fetch_subcategories($category_id) {
        $args = array(
            'taxonomy' => 'product_cat',
            'parent' => $category_id,
            'hide_empty' => false,
        );
        $subcategories = get_terms($args);

        $subcategories_data = array();
        foreach ($subcategories as $subcategory) {
            $subcategories_data[] = array(
                'id' => $subcategory->term_id,
                'slug' => $subcategory->slug,
                'name_en' => html_entity_decode($subcategory->name),
                "name_ar" =>  get_field('attribute_in_arabic', 'product_cat_' .$subcategory->term_id) ,
                'subcategories' => fetch_subcategories($subcategory->term_id), // Recursive call
            );
        }

        return $subcategories_data;
    }
    if ($slug) {
        $category = get_term_by('slug', $slug, 'product_cat');
        if (!$category) {
            return new WP_Error('invalid_category', 'Invalid category slug', array('status' => 404));
        }
        $category_data = array(
            'id' => $category->term_id,
            'slug' => $category->slug,
            'name_en' => html_entity_decode($category->name) ,
            "name_ar" =>  get_field('attribute_in_arabic', 'product_cat_' .$category->term_id) ,
            'subcategories' => fetch_subcategories($category->term_id),
        );

        return new WP_REST_Response($category_data, 200);
    } else {
        $args = array(
            'taxonomy' => 'product_cat',
            'parent' => 0,
            'hide_empty' => false,
        );
        $categories = get_terms($args);
        if (empty($categories) || is_wp_error($categories)) {
            return new WP_Error('no_categories', 'No categories found', array('status' => 404));
        }
        $categories_data = array();
        foreach ($categories as $category) {
            $categories_data[] = array(
                'id' => $category->term_id,
                'slug' => $category->slug,
                'name_en' => html_entity_decode($category->name),
                "name_ar" =>  get_field('attribute_in_arabic', 'product_cat_' .$category->term_id) ,
                'subcategories' => fetch_subcategories($category->term_id),
            );
        }

        return new WP_REST_Response($categories_data, 200);
    }
}

add_action('rest_api_init', function () {
    register_rest_route('api/v2', '/products/search', array(
        'methods' => 'GET',
        'callback' => 'search_products_callback',
        'permission_callback' => 'is_user_logged_in',
    ));
});
function search_products_callback(WP_REST_Request $request){
    $user = wp_get_current_user();
    $request_data = $request->get_json_params();
    $lang = $request_data['lang'] ?? 'en';
    $keyword = $request_data['keyword'] ?? '';
    $limit = $request_data['limit'] ?? 10 ;
    $args = array(
        'post_type'      => 'product',
        'fields'         => 'ids',
        'posts_per_page' => $limit,
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
    );

    if($lang == "en"){
        $args['s'] = $keyword ;

    }else{
        $args['meta_query']  = array(
            'relation' => 'OR',
            array(
                'key' => 'product_data_arabic_title',
                'value' => $keyword,
                'compare' => 'LIKE'
            ),
        );
    }


    $products = get_posts($args);
    $data = [] ;
    foreach ($products as $one_product) {
        $data [] = product_widget($one_product , $user->ID , -1);
    }

    return $data;

}

add_action('rest_api_init', function () {
    register_rest_route('api/v2', '/coupons/(?P<code>[a-zA-Z0-9-_]+)', array(
        'methods' => 'GET',
        'callback' => 'get_coupon_callback',
        'permission_callback' => 'is_user_logged_in',
    ));
});
function get_coupon_callback(WP_REST_Request $request) {
    global $woocommerce;
    $coupon = new WC_Coupon($request['code']);

    if ((int) $coupon->get_amount() === 0) {
        $response = array(
            'status' => 'error',
            'msg' => 'Coupon not found',
            'code' => 400,
        );
        return new WP_REST_Response($response, 404); // Return 404 for not found
    } else {
        $response = array(
            'status' => 'success',
            'msg' => 'Coupon found',
            'data' => array(
                'discount_type' => $coupon->get_discount_type(),
                'discount_amount' => $coupon->get_amount(),
                'expire_at' => $coupon->get_date_expires() ? $coupon->get_date_expires()->date('Y-m-d H:i:s') : null,
                'free_shipping' => $coupon->get_free_shipping(),
            ),
            'code' => 200,
        );
        return new WP_REST_Response($response, 200); // Return 200 for success
    }
}




