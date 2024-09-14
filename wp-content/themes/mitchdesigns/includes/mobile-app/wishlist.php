<?php


// ====================================== Wishlist ======================================
add_action('rest_api_init', function () {
    register_rest_route('api/v2', '/wishlist', array(
        'methods' => 'POST',
        'callback' => 'add_to_wishlist_callback',
        'permission_callback' => 'is_user_logged_in',
    ));
});

function add_to_wishlist_callback(WP_REST_Request $request) {
    $user = wp_get_current_user();
    $request_data = $request->get_json_params();

    if (!isset($request_data['product_id'])) {
        return new WP_REST_Response(array('status' => 'error', 'msg' => 'Missing Parameters'), 400);
    }
    $product = wc_get_product($request_data['product_id']);
    if(!$product){
        return new WP_REST_Response(array('status' => 'error', 'msg' => 'Product Not Found'), 400);
    }

    global $wpdb;

    $wishlist_entry = $wpdb->get_row($wpdb->prepare("SELECT ID FROM wp_mitch_wishlist WHERE user_id = %d AND product_id = %d",
        $user->ID,
        $request_data['product_id']
    ));

    if (empty($wishlist_entry)) {
        $wpdb->insert('wp_mitch_wishlist', array(
            'user_id' => $user->ID,
            'product_id' => $request_data['product_id']
        ));
        $response = array('status' => 'success', 'msg_code' => 'wishlist_add_success', 'msg' => 'Added to Wishlist Successfully');
    } else {
        $response = array('status' => 'error', 'msg_code' => 'wishlist_add_error', 'msg' => 'Product Already Exist in Wishlist');
    }

    return new WP_REST_Response($response, 200);
}

add_action('rest_api_init', function () {
    register_rest_route('api/v2', '/wishlist/(?P<id>\d+)', array(
        'methods' => 'DELETE',
        'callback' => 'remove_from_wishlist_callback',
        'permission_callback' => 'is_user_logged_in',
    ));
});
function remove_from_wishlist_callback(WP_REST_Request $request) {
    $user = wp_get_current_user();

    global $wpdb;
    $wpdb->query($wpdb->prepare(
        "DELETE FROM wp_mitch_wishlist WHERE user_id = %d AND product_id = %d",
        $user->ID,
        $request['id']
    ));
    $response = array('status' => 'success', 'msg' => 'Product Removed Successfully');

    return new WP_REST_Response($response, 200);
}

add_action('rest_api_init', function () {
    register_rest_route('api/v2', '/wishlist', array(
        'methods' => 'GET',
        'callback' => 'get_wishlist_callback',
        'permission_callback' => 'is_user_logged_in',
    ));
});

function get_wishlist_callback(WP_REST_Request $request) {
    $user = wp_get_current_user();
    global $wpdb;
    $product_ids = $wpdb->get_results($wpdb->prepare(
        "SELECT product_id FROM wp_mitch_wishlist WHERE user_id = %d",
        $user->ID
    ));
    $product_array = [];
    foreach ($product_ids as $product_id) {
        $product = wc_get_product($product_id->product_id);
        if ($product) {
            $product_array[] = product_widget($product_id->product_id , $user->ID , -1);
        }
    }

    return new WP_REST_Response($product_array, 200);
}





