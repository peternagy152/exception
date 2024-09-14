<?php

add_action('rest_api_init', function () {
    register_rest_route('api/v2', '/register', array(
        'methods' => 'POST',
        'callback' => 'register_user_callback',
        'permission_callback' => '__return_true',
    ));
});

function register_user_callback(WP_REST_Request $request ) {
    global $wpdb;
    $request_data = $request->get_json_params();
    $response = array();
    $valid_data = true;

    // Check parameters
    $required_fields = array('first_name', 'last_name', 'email', 'phone', 'birth_day', 'birth_month', 'birth_year', 'password', 'gender');
    foreach ($required_fields as $field) {
        if (!isset($request_data[$field])) {
            $valid_data = false;
            $response = array('status' => 'error', 'msg' => "Missing Parameter: $field");
            return new WP_REST_Response($response, 400);
        }
    }

    if (email_exists($request_data['email'])) {
        $valid_data = false;
        $response = array('status' => 'error', 'msg' => "Email exists");
    }

    if ($valid_data && !empty(check_phone_number_exist($request_data['phone']))) {
        $valid_data = false;
        $response = array('status' => 'error', 'msg' => "Phone exists");
    }

    if ($valid_data) {
        $result = wp_create_user($request_data['email'], $request_data['password'], $request_data['email']);
        if (is_wp_error($result)) {
            $response = array('status' => 'error', 'msg' => $result->get_error_message());
        } else {
            $user = get_user_by('ID', $result);
            $user->set_role('customer');
            update_user_meta($user->ID, 'first_name', sanitize_text_field($request_data['first_name']));
            update_user_meta($user->ID, 'last_name', sanitize_text_field($request_data['last_name']));
            update_user_meta($user->ID, 'user_type', sanitize_text_field($request_data['user_type']));
            update_user_meta($user->ID, 'phone_number', sanitize_text_field($request_data['phone']));
            update_user_meta($user->ID, 'registered_by', sanitize_text_field("wp"));
            update_user_meta($user->ID, 'birth_day', sanitize_text_field($request_data['birth_day']));
            update_user_meta($user->ID, 'birth_month', sanitize_text_field($request_data['birth_month']));
            update_user_meta($user->ID, 'birth_year', sanitize_text_field($request_data['birth_year']));
            update_user_meta($user->ID, 'gender', sanitize_text_field($request_data['gender']));
            wp_set_current_user($user->ID);
            wp_set_auth_cookie($user->ID);
            $response = array('status' => 'success', 'msg' => "Account Created");
        }
    }

    return new WP_REST_Response($response, 200);
}
function check_phone_number_exist($phone_number) {
    global $wpdb;
    return $wpdb->get_row($wpdb->prepare("SELECT user_id FROM wp_usermeta WHERE meta_key = 'phone_number' AND meta_value = %s", $phone_number));
}

add_action('rest_api_init', function () {
    register_rest_route('api/v2', '/profile', array(
        'methods' => 'GET',
        'callback' => 'get_profile_callback',
        'permission_callback' => 'is_user_logged_in',
    ));
});

function get_profile_callback(WP_REST_Request $request) {
    $user = wp_get_current_user();

    if (!$user || !$user->exists()) {
        return new WP_Error('no_user', 'Invalid token or user not found', array('status' => 401));
    }

    // Get user data
    $user_data = array(
        'ID' => $user->ID,
        'first_name' => $user->first_name,
        'last_name' => $user->last_name,
        'email' => $user->user_email,
        'phone' => $user->phone_number,
        'birth_day' => $user->birth_day,
        'birth_month' => $user->birth_month,
        'birth_year' => $user->birth_year,
        'gender' => $user->gender,
    );

    return new WP_REST_Response($user_data, 200);
}




add_action('rest_api_init', function () {
    register_rest_route('api/v2', '/profile', array(
        'methods' => 'PUT',
        'callback' => 'edit_profile_callback',
        'permission_callback' => 'is_user_logged_in',
    ));
});
function edit_profile_callback(WP_REST_Request $request) {
    $user = wp_get_current_user();
    $request_data = $request->get_json_params();
    if (!$user || !$user->exists()) {
        return new WP_Error('no_user', 'Invalid token or user not found', array('status' => 401));
    }
    update_user_meta($user->ID , 'first_name' , sanitize_text_field($request_data['first_name'] ) );
    update_user_meta($user->ID , 'last_name' , sanitize_text_field($request_data['last_name'] ) );
    update_user_meta($user->ID , 'phone_number' , sanitize_text_field($request_data['phone'] ) );

    update_user_meta($user->ID , 'birth_day' , sanitize_text_field($request_data['birth_day'] ) );
    update_user_meta($user->ID , 'birth_month' , sanitize_text_field($request_data['birth_month'] ) );
    update_user_meta($user->ID , 'birth_year' , sanitize_text_field($request_data['birth_year'] ) );
    update_user_meta($user->ID , 'gender' , sanitize_text_field($request_data['gender'] ) );

    $user_data = array(
        'ID' => $user->ID,
        'first_name' => $user->first_name,
        'last_name' => $user->last_name,
        'email' => $user->user_email,
        'phone' => $user->phone_number,
        'birth_day' => $user->birth_day,
        'birth_month' => $user->birth_month,
        'birth_year' => $user->birth_year,
        'gender' => $user->gender,
    );

    return new WP_REST_Response($user_data, 200);

}



// ============================================= Password =======================================
add_action('rest_api_init', function () {
    register_rest_route('api/v2', '/change-password', array(
        'methods' => 'POST',
        'callback' => 'change_password_callback',
        'permission_callback' => 'is_user_logged_in',
    ));
});
function change_password_callback(WP_REST_Request $request) {
    $user = wp_get_current_user();
    $request_data = $request->get_json_params();
    if (!$user || !$user->exists()) {
        return new WP_Error('no_user', 'Invalid token or user not found', array('status' => 401));
    }

    if (!isset($request_data['current_password'], $request_data['new_password'])) {
        return new WP_REST_Response(array('status' => 'error', 'msg' => 'Missing Parameters'), 400);
    }

    $user_info = get_userdata($user->ID);
    $wp_pass = $user_info->user_pass;
    $confirm = wp_check_password($request_data['current_password'], $wp_pass, $user->ID);
    if($confirm){
        wp_set_password(sanitize_text_field($request_data['new_password'] ) , $user->ID ) ;
        $response = array(
            'status'       => 'success',
            'msg'         => 'Passwords Changed Successfully'
        );
    }else{
        $response = array(
            'status'       => 'error',
            'msg'         => 'Invalid current password'
        );

    }
    return new WP_REST_Response($response, 200);
}

add_action('rest_api_init', function () {
    register_rest_route('api/v2', '/delete-account', array(
        'methods' => 'DELETE',
        'callback' => 'delete_account_callback',
        'permission_callback' => 'is_user_logged_in',
    ));
});
function delete_account_callback(WP_REST_Request $request) {
    require_once(ABSPATH.'wp-admin/includes/user.php' );
    $user = wp_get_current_user();
    $request_data = $request->get_json_params();
    if(empty($request_data['password'])){
        return new WP_Error('error', 'Password Is Required.', array('status' => 400));
    }
    if(wp_check_password($request_data['password'],$user->user_pass,$user->ID)){
        $result = wp_delete_user($user->ID );
        return new WP_REST_Response(array('status' => 'success', 'msg' => 'Account deleted successfully'), 200);
    }else{
        return new WP_Error('error', 'Incorrect Password.', array('status' => 401));
    }


}













