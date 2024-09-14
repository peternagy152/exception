<?php

add_action('rest_api_init', function () {
    register_rest_route('api/v2', '/my-orders', array(
        'methods' => 'GET',
        'callback' => 'get_orders_callback',
        'permission_callback' => 'is_user_logged_in',
    ));
});

function get_orders_callback(WP_REST_Request $request)
{

    $user = wp_get_current_user();
    $orders = wc_get_orders(array('customer_id' => $user->ID));
    $orders_array = [];
    foreach ($orders as $order) {
        $data = [
            "id" => $order->get_id(),
            "date" => $order->get_date_created()->date("j/n/Y"),
            "status" => $order->get_status(),
            "total" => $order->get_total(),
        ];
        $orders_array[] = $data;
    }

    return new WP_REST_Response($orders_array, 200);
}


add_action('rest_api_init', function () {
    register_rest_route('api/v2', '/my-orders/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'get_orders_details_callback',
        'permission_callback' => 'is_user_logged_in',
    ));
});

function get_orders_details_callback(WP_REST_Request $request)
{
    $user = wp_get_current_user();
    if (get_post_meta($request['id'], '_customer_user', true) != $user->ID) {
        return new WP_Error('unauthorized order', 'you dont have permissions to access this order', array('status' => 401));
    }

    $order_obj = wc_get_order($request['id']);
    $items = [];
    foreach ($order_obj->get_items() as $item_id => $item) {
        $product_data = product_widget($item->get_product_id() , $user->ID , '-1');
        $item_data = [
            "id" => $item->get_product_id(),
            "slug" => $product_data['slug'],
            "name_en" => $product_data['name_en'],
            "name_ar" => $product_data['name_ar'],
            "image" => $product_data['image'],
            "quantity" => $item->get_quantity(),
            "subtotal" => $item->get_subtotal(),
            "total" => $item->get_total(),
        ];
        $items[] = $item_data;

    }
    $shipping = [
        "first_name" => $order_obj->get_billing_first_name() ,
        "last_name" => $order_obj->get_billing_last_name() ,
    ];

    if(empty( $order_obj->get_billing_city())){
        $shipping['type'] = "pickup" ;
        $shipping['branch'] = $order_obj->get_meta('_billing_local_pickup') ;
    }else{
        $shipping['type'] = "delivery" ;
        $shipping['city'] = get_gov_by_name( $order_obj->get_billing_state())  ;
        $shipping['area'] =get_area_by_name($order_obj->get_meta('_billing_street')) ;
        $shipping['district'] = MD_Get_street_rate_by_name_ar($order_obj->get_billing_city()) ;
        $shipping['full_address'] = $order_obj->get_billing_address_1() ;
        $shipping['floor'] =get_post_meta($request['id'], '_billing_building', true) ;
        $shipping['apartment'] =get_post_meta($request['id'], '_billing_building_2', true);


    }

    $data = [
        "id" => $order_obj->get_id(),
        "date" => $order_obj->get_date_created()->date("F j, Y"),
        "status" => $order_obj->get_status(),
        "item_count" => $order_obj->get_item_count(),
        "items" => $items,
        "shipping" => $shipping ,
        "payment_method" => $order_obj->get_payment_method(),
        "subtotal" => number_format($order_obj->get_subtotal()),
        "shipping_fees" => number_format($order_obj->get_shipping_total()),
        "discount" => number_format($order_obj->get_discount_total()),
        "total" => number_format($order_obj->get_total()),

    ];
    return new WP_REST_Response($data, 200);

}