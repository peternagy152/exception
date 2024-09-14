<?php

// =============================== Address Functions  ===========================
add_action('rest_api_init', function () {
    register_rest_route('api/v2', '/address', array(
        'methods' => 'POST',
        'callback' => 'add_address_callback',
        'permission_callback' => 'is_user_logged_in',
    ));
});
function add_address_callback(WP_REST_Request $request) {
    $user = wp_get_current_user();
    global $wpdb ;
    $your_table_name = 'wp_mitch_users_addresses';
    $request_data = $request->get_json_params();
    if (!$user || !$user->exists()) {
        return new WP_Error('no_user', 'Invalid token or user not found', array('status' => 401));
    }

    $check_default = $wpdb->get_row("SELECT * FROM wp_mitch_users_addresses WHERE user_id = $user->ID  AND address_type = 0 ");
    if($check_default){$address_type = 1 ;}else{$address_type = 0;}
    $wpdb->insert(
        $your_table_name,
        array(
            'user_id' => $user->ID ,
            'level_1' => $request_data['city'],
            'level_2' => $request_data['area'] ,
            'level_3' => $request_data['district'],
            'full_address' => $request_data['full_address'],
            'Floor' => $request_data['floor'],
            'apartment' => $request_data['apartment'],
            'address_type' => $address_type ,
        )
    );
    $response = array(
        'status'       => 'success',
        'msg'         => 'Address Added Successfully'
    );
    return new WP_REST_Response($response, 200);

}


add_action('rest_api_init', function () {
    register_rest_route('api/v2', '/address', array(
        'methods' => 'GET',
        'callback' => 'get_address_callback',
        'permission_callback' => 'is_user_logged_in',
    ));
});

function get_address_callback(WP_REST_Request $request) {


    $user = wp_get_current_user();
    global $wpdb;
    $address =  $wpdb->get_results("SELECT * FROM wp_mitch_users_addresses WHERE user_id = $user->ID ");
    $addresses_array = [];
    foreach ($address as $one_address) {
        $gov = get_gov_name_by_id($one_address->level_1);
        $area = MD_Get_area_by_area_id($one_address->level_2);
        $district = get_street_name_by_id($one_address->level_3);
        if($one_address->address_type == 0){$address_type = "default";}else{$address_type = "normal" ;}
        $data = [
            "address_id" => $one_address->ID,
            "city" => $gov ,
            "area" => $area ,
            "district" => $district ,
            "full_address" => $one_address->full_address,
            "floor" => $one_address->Floor,
            "apartment" => $one_address->apartment,
            "address_type" => $address_type ,
        ] ;
        $addresses_array[] = $data;
    }

    return new WP_REST_Response($addresses_array, 200);

}


add_action('rest_api_init', function () {
    register_rest_route('api/v2', '/address', array(
        'methods' => 'PATCH',
        'callback' => 'edit_address_callback',
        'permission_callback' => 'is_user_logged_in',
    ));
});
function edit_address_callback(WP_REST_Request $request) {
    $user = wp_get_current_user();
    $request_data = $request->get_json_params();
    if (!$user || !$user->exists()) {
        return new WP_Error('no_user', 'Invalid token or user not found', array('status' => 401));
    }
    global $wpdb;
    $address_id = $request_data['address_id'];
    $auth_address = $wpdb->get_row("SELECT * FROM wp_mitch_users_addresses WHERE user_id = $user->ID and ID = $address_id ;");
    if($auth_address){
        $your_table_name = 'wp_mitch_users_addresses';
        $wpdb->update( $your_table_name, array(
            'level_1' => sanitize_text_field($request_data['city']) ,
            'level_2' => sanitize_text_field($request_data['area']) ,
            'level_3' => sanitize_text_field($request_data['district']) ,
            'full_address' => sanitize_text_field($request_data['full_address']) ,
            'Floor' => sanitize_text_field($request_data['floor']) ,
            'apartment' => sanitize_text_field($request_data['apartment'])  ,
        ), array( 'ID' => $request_data['address_id'] ) ) ;

        $response = array(
            'status'       => 'success',
            'msg'         => 'Address Updated Successfully'
        );
        return new WP_REST_Response($response, 200);

    }else{
        return new WP_Error('unauthorized', 'you dont have the permissions', array('status' => 401));
    }

}



add_action('rest_api_init', function () {
    register_rest_route('api/v2', '/address', array(
        'methods' => 'DELETE',
        'callback' => 'remove_address_callback',
        'permission_callback' => 'is_user_logged_in',
    ));
});

function remove_address_callback(WP_REST_Request $request) {
    $user = wp_get_current_user();
    $request_data = $request->get_json_params();
    if (!$user || !$user->exists()) {
        return new WP_Error('no_user', 'Invalid token or user not found', array('status' => 401));
    }
    $your_table_name = 'wp_mitch_users_addresses';
    global $wpdb;
    $address_id = $request_data['address_id'];
    $auth_address = $wpdb->get_row("SELECT * FROM wp_mitch_users_addresses WHERE user_id = $user->ID and ID = $address_id ;");
    if($auth_address){
        if($auth_address->address_type == 0){
            //Change Default Address
            $current_user_id = $user->ID;
            $other_addresses = mitch_get_user_others_addresses_list($current_user_id);
            $wpdb->delete( $your_table_name, array( 'ID' => $address_id ) );
            if(!empty($other_addresses)){
                //update address to default
                $wpdb->update( $your_table_name, array( 'address_type' => '0' ), array( 'ID' => $other_addresses[0]->ID ) ) ;
            }

        }else{
            //Just Delete
            $wpdb->delete( $your_table_name, array( 'ID' => $address_id ) );
        }
        $response = array(
            'status'       => 'success',
            'msg'         => 'Address Removed Successfully'
        );
        return new WP_REST_Response($response, 200);
    }else{
        return new WP_Error('no_address', 'Invalid Address Permissions', array('status' => 401));
    }
}



add_action('rest_api_init', function () {
    register_rest_route('api/v2', '/change-default-address', array(
        'methods' => 'POST',
        'callback' => 'change_default_address_callback',
        'permission_callback' => 'is_user_logged_in',
    ));
});
function change_default_address_callback(WP_REST_Request $request) {
    $user = wp_get_current_user();
    $request_data = $request->get_json_params();
    if (!$user || !$user->exists()) {
        return new WP_Error('no_user', 'Invalid token or user not found', array('status' => 401));
    }
    global $wpdb ;

    $default_address =  $wpdb->get_row("SELECT * FROM wp_mitch_users_addresses WHERE user_id = $user->ID and address_type = 0 ;");

    $new_address = $request_data['new_address'];
    if(!$new_address){
        return new WP_Error('missing_paramter', 'New Address is required', array('status' => 400));
    }
    $your_table_name = 'wp_mitch_users_addresses';
    global $wpdb;
    $wpdb->update( $your_table_name, array( 'address_type' => '1' ), array( 'ID' => $default_address->ID ) ) ;
    $wpdb->update( $your_table_name, array( 'address_type' => '0' ), array( 'ID' => $new_address ) ) ;
    $response = array(
        'status'       => 'success',
        'msg'         => 'Default Address Changed'

    );

    return new WP_REST_Response($response, 200);


}

