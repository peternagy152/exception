<?php
add_action('rest_api_init', function () {
    register_rest_route('api/v2', 'home', array(
        'methods' => 'GET',
        'callback' => 'get_home_callback',
        'permission_callback' => 'is_user_logged_in',
    ));
});
function get_category_slug_from_url($url) {
    $parsed_url = parse_url($url);
    $path = $parsed_url['path'];
    $path_parts = explode('/', trim($path, '/'));
    $index = array_search('product-category', $path_parts);
    if ($index !== false && isset($path_parts[$index + 1])) {
        return $path_parts[$index + 1];
    }

    return null;
}

function get_home_callback(WP_REST_Request $request) {

    $lang = $request->get_param('lang');
    if ($lang == 'en') {
        $home_content =  get_field('home_group_en', 13);

    }else {
        $home_content =  get_field('home_group_ar', 13);
    }

    $banners = [] ;
    foreach ($home_content['hero_section']['images'] as $banner) {
        $banners [] = $banner['banner_mobile'] ;
    }

    $categories = [];
    foreach ($home_content['categories_content']as $cat) {
        $data = [
            "title" => $cat['category_title'],
            "subtitle" => $cat['category_subtitle'],
            "image" => $cat['category_image'],
            "slug" => get_category_slug_from_url( $cat['category_link']),
        ];
        $categories[] = $data;
    }

    $response = array(
        "banner" => $banners ,
        "categories" => $categories
    );


    return new WP_REST_Response($response);

}


add_action('rest_api_init', function () {
    register_rest_route('api/v2', '/about-us', array(
        'methods' => 'GET',
        'callback' => 'get_about_us_callback',
        'permission_callback' => '',
    ));
});

function get_about_us_callback(WP_REST_Request $request) {

    $lang = $request->get_param('lang');
    if ($lang == 'en') {
        $page_content = get_field('page_about_en', 133);
    } else{
        $page_content = get_field('page_about', 133); // Assuming you have a field for Arabic content
    }

    //Hero
    if($page_content["video_or_images"]) {
        $hero["hero"] = $page_content['video_hero'] ;
    }else{
        $hero["hero"] = $page_content['image_hero'] ;
    }
    $hero["title"] = $page_content['title_hero'] ;
    $hero["subtitle"] = $page_content['subtitle_hero'] ;

    $content_with_image = [
        "image" => $page_content['image_one'] ,
        "title" => $page_content['title_one'] ,
        "desc" => $page_content['description_one'] ,
    ];


    $repeated_section_image = [] ;
    foreach ($page_content['content_image_repeater'] as $one_section) {
        $data = [];
        if($one_section['image_has_slider']) {
            $data['image'] = $one_section['slider_image'] ;
        }else{
            $data['image'] = $one_section['image_second'] ;
        }
        $data['title'] = $one_section['title_second'] ;
        $data['desc'] = $one_section['description_second'] ;

        $repeated_section_image[] = $data;
    }
    $our_values = [
        "title" => $page_content['title_values'] ,
        "values" => $page_content['all_values'] ,
    ] ;

    $response = array(
        "hero" => $hero,
        "sub_hero" => $page_content['subhero_repeater'] ,
        "content_with_image" => $content_with_image ,
        "middle_content" => $page_content['text'] ,
        "repeated_content_with_slider" => $repeated_section_image ,
        "our_values" => $our_values ,
        "footer_section" => $page_content['page_repeater'] ,
    ) ;
    return new WP_REST_Response($response);


}


add_action('rest_api_init', function () {
    register_rest_route('api/v2', 'contact-us', array(
        'methods' => 'GET',
        'callback' => 'get_contact_us_callback',
        'permission_callback' => '',
    ));
});

function get_contact_us_callback(WP_REST_Request $request) {
    $lang = $request->get_param('lang');
    if ($lang == 'ar') {
        $page_content = get_field("contact_page" , "135");
    }else {
        $page_content = get_field("contact_page_en" , "135");
    }
    return new WP_REST_Response($page_content);

}

add_action('rest_api_init', function () {
    register_rest_route('api/v2', '/contact-us/', array(
        'methods' => 'POST',
        'callback' => 'insert_contact_us_form_callback',
        'permission_callback' => '',
    ));
});

function insert_contact_us_form_callback(WP_REST_Request $request) {
    $request_data = $request->get_json_params();
    if (empty($request_data['first_name']) || empty($request_data['last_name'])) {
        return new WP_Error('error', 'First name and last name are required.', array('status' => 400));
    }
    if (empty($request_data['email']) || !filter_var($request_data['email'], FILTER_VALIDATE_EMAIL)) {
        return new WP_Error('error', 'A valid email address is required.', array('status' => 400));
    }
    if (empty($request_data['phone']) || !preg_match('/^[0-9]{10,15}$/', $request_data['phone'])) {
        return new WP_Error('error', 'A valid phone number is required.', array('status' => 400));
    }
    if (empty($request_data['message'])) {
        return new WP_Error('error', 'Message is required.', array('status' => 400));
    }



    $url  = home_url() . "/wp-admin/admin-ajax.php?t=" . time();
    $data_fields = [
        'names' => $request_data["first_name"] .  $request_data["last_name"] ,
        'email' => 	$request_data["email"],
        'numeric-field_4' => $request_data["phone"],
        'message' => $request_data["message"],
    ];

    $data = [
        'data' => http_build_query($data_fields),
        'action' => 'fluentform_submit',
        'form_id' => 1,
    ];

// Headers
    $headers = [
        'accept: */*',
        'accept-language: en-US,en;q=0.9,ar;q=0.8',
        'cache-control: no-cache',
        'content-type: application/x-www-form-urlencoded; charset=UTF-8',
        "User-Agent: {$_SERVER['HTTP_USER_AGENT']}"
    ];


    $response = wp_remote_post($url, array(
        'method'  => 'POST',
        'body'    => http_build_query($data),
        'headers' => $headers,
        'sslverify'   => false,
        'timeout' => 120
    ));


    if (!is_wp_error($response)) {
        $body = json_decode(wp_remote_retrieve_body($response), true);
        if($body['success']){
            return new WP_REST_Response(['status' => 'success', 'code' => 200]);
        }else {
            return new WP_Error('error', $body , array('status' => 400));
        }
    } else {
        $error_message = $response->get_error_message();
        return new WP_Error('error', $error_message , array('status' => 400));
    }


}


add_action('rest_api_init', function () {
    register_rest_route('api/v2', '/branches-page/(?P<lang>[a-zA-Z0-9_-]+)', array(
        'methods' => 'GET',
        'callback' => 'get_branches_page_callback',
        'permission_callback' => '',
    ));
});

function get_branches_page_callback(WP_REST_Request $request){

    $args = array(
        'post_type' => 'branch',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'DESC',
    );

    $branches = get_posts($args);
    return $branches;


}


