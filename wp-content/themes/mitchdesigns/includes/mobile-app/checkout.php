<?php
add_action('rest_api_init', function () {
    register_rest_route('api/v2', '/checkout', array(
        'methods' => 'POST',
        'callback' => 'checkout_callback',
        'permission_callback' => 'is_user_logged_in',
    ));
});

function checkout_callback(WP_REST_Request $request) {
    $user = wp_get_current_user();
    $request_data = $request->get_json_params();
    if ($request_data && isset($request_data['billing'], $request_data['shipping'], $request_data['items'], $request_data['payment'])) {

        $order = wc_create_order();

        //Order status
        $order->set_status("wc-processing");
        $order->set_customer_id($user->ID);

        //Order Items
        foreach ($request_data['items'] as $item) {
            $order->add_product(wc_get_product($item['itemID']), $item['qty']);  //wc_get_product( $item['itemID']  , $item['qty']);
        }
        $order->calculate_totals();


        $order->set_address($request_data['billing'], 'billing');
        //Order Address And Shipping
        if ($request_data['shipping']["shipping_method"] == 'delivery') {
            //Shipping Address Info
            $order->add_meta_data('_billing_address_1', $request_data['shipping']["full_address"], true);

            //Stores Cairo in Arabic --> get from city id from the request data

            $order->add_meta_data('_billing_state', get_gov_name_by_id($request_data['shipping']["city"])->gov_name_ar, true); //city - gov
            $order->add_meta_data('_billing_street', MD_Get_area_by_area_id($request_data['shipping']["area"])->area_name_ar, true); // Area
            $order->add_meta_data('_billing_city', get_street_name_by_id($request_data['shipping']["district"])->street_name_ar, true); // District  - Street

            $order_from_branch = get_branch_data_by_id(get_street_name_by_id($request_data['shipping']["district"])->branch_id)->branch_name_ar;
            $order->add_meta_data('_order_from_branch', $order_from_branch, true);

            $order->add_meta_data('_billing_building', $request_data['shipping']["floor"], true); //Floor
            $order->add_meta_data('_billing_building_2', $request_data['shipping']["apartment"], true); // Apartment


            $shipping = new WC_Order_Item_Shipping();
            $shipping->set_method_title('Shipping Fees');
            $shipping->set_total(get_street_name_by_id($request_data['shipping']["district"])->street_rate); // optional
            $order->add_item($shipping);
        } else {
            $order->add_meta_data('_billing_local_pickup', $request_data['shipping']["branch_name"], true); //Floor

            $shipping = new WC_Order_Item_Shipping();
            $shipping->set_method_title('Free Shipping');
            $shipping->set_total(0); // optional
            $order->add_item($shipping);

        }

        if (!empty($request_data['coupon'])) {
            $order->apply_coupon($request_data['coupon']);
        }

        $order->calculate_totals();


        //Payment Method
        if ($request_data['payment']['method'] == 'cod') {
            $order->set_payment_method('cod');
            $order->set_payment_method_title('Cash On Delivery');
        } else {
            $order->set_payment_method('mpgs');
            $order->set_payment_method_title('Credit/Debit card');
        }


        $order->save();
        $response = array(
            "status" => "success",
            "order_id" => $order->get_id(),
            "key" => get_post_meta($order->get_id(), "_order_key", true),

        );

        return new WP_REST_Response($response, 200);

    }else{
        $response = array(
            "status" => "error",
            "msg" => "ERROR IN PAYLOAD" ,
        );
        return new WP_REST_Response($response , 400);
    }

}

add_action('rest_api_init', function () {
    register_rest_route('api/v2', '/orders/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'get_order_callback',
        'permission_callback' => 'is_user_logged_in',
    ));
});

function get_order_callback(WP_REST_Request $request) {
    $user = wp_get_current_user();
    $order = wc_get_order($request['id']);
    if ($order) {
        $items = $order->get_items();

        if (is_array($items)) {
            $items_data = [];
            foreach ($items as $item_id => $item) {
                if ($item->get_product_id() === 0) {
                    continue;
                }
                $product = $item->get_product();
                $parent_id = 0 ;

                if($item->get_variation_id() == 0 ){
                    $product_id  = $item->get_product_id() ;
                    $thumbnail =  wp_get_attachment_image_src(get_post_thumbnail_id( $product_id ), 'full')[0] ?? false ;
                }else{
                    $product_id = $item->get_variation_id() ;
                    $parent_id =  $item->get_product_id() ;
                    $thumbnail =  wp_get_attachment_image_src(get_post_thumbnail_id( $parent_id ), 'full')[0] ?? false ;
                }

                $product_type = "simple";
                $product_slug = $product->get_slug();
                if ($product->is_type('variation')) {
                    $product_type = "variable";
                    $parent_id = $product->get_parent_id();
                    $variation_attributes = $product->get_variation_attributes();
                    $attr = [];
                    foreach ($variation_attributes as $attribute_taxonomy => $term_slug) {
                        $taxonomy = str_replace('attribute_', '', $attribute_taxonomy);
                        $attribute_name = wc_attribute_label($taxonomy, $product);
                        $attribute_value = get_term_by('slug', $term_slug, $taxonomy)->name;
                        $attr[] = ['name' => $attribute_name, 'value' => $attribute_value];
                    }
                }
                $items_data[] = [
                    'name' => $item->get_name(),
                    'ar_name' => $product->get_meta('product_data_arabic_title', true),
                    'thumbnail' => $thumbnail ,
                    'type' => $product_type,
                    'slug' => $product_slug,
                    'quantity' => $item->get_quantity(),
                    'subtotal' => $order->get_item_subtotal($item),
                    'total' => $order->get_item_subtotal($item) * $item->get_quantity(),
                    'attr' => $attr ?? '',
                ];
            }
        }

        $fees = $order->get_fees();
        if ($fees) {
            $fees_data = [];
            /** @var WC_Order_Item_Fee $fee */
            foreach ($fees as $fee) {
                $fees_data = ['name' => $fee->get_name(), 'amount' => $fee->get_amount()];
            }
        }

        $billing = [
            'first_name' => $order->get_billing_first_name(),
            'last_name' => $order->get_billing_last_name(),
            'email' => $order->get_billing_email(),
            'phone' => $order->get_billing_phone(),
            'created_at' => $order->get_date_created()->date('Y-m-d'),
        ];
        $shipping = [] ;

        if(empty( $order->get_billing_city())){
            $shipping['type'] = "pickup" ;
            $shipping['branch'] = $order->get_meta('_billing_local_pickup') ;
        }else{
            $shipping['type'] = "delivery" ;
            $shipping['city'] = get_gov_by_name( $order->get_billing_state())  ;
            $shipping['area'] =get_area_by_name($order->get_meta('_billing_street')) ;
            $shipping['district'] = MD_Get_street_rate_by_name_ar($order->get_billing_city()) ;
            $shipping['full_address'] = $order->get_billing_address_1() ;
            $shipping['floor'] =get_post_meta($request['id'], '_billing_building', true) ;
            $shipping['apartment'] =get_post_meta($request['id'], '_billing_building_2', true);
        }


        $data = [
            'billing' => $billing ,
            "shipping" => $shipping,
            'order' => [
                'status' => $order->get_status(),
                'items' => $items_data,
                'subtotal' => number_format($order->get_subtotal()) ,
                'shipping_fees' =>number_format($order->get_shipping_total()) ,
                'total' =>  number_format($order->get_total()),
                'discount' => number_format($order->get_total_discount()),
                'payment_method' => $order->get_payment_method(),
                'fees' => $fees_data,
            ],

        ];
        echo json_encode($data);
    } else {
        echo json_encode(['No order found']);
    }



}



