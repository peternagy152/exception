<?php
add_action('rest_api_init', function () {
    register_rest_route('api/v2', '/get-serving-branch', array(
        'methods' => 'GET',
        'callback' => 'get_serving_branch_callback',

    ));
});
function get_serving_branch_callback(WP_REST_Request $request) {
    $request_data = $request->get_json_params();
    if(isset($request_data['city'])){
         return MD_Get_area($request_data['city']) ;
    }else if(isset($request_data['area'])){
        return MD_Get_street($request_data['area']);
    }else if(isset($request_data['branch'])){
        return get_branch_data_by_id($request_data['branch']);

    } else{
        return  MD_get_all_data_govs();
    }

}

add_action('rest_api_init', function () {
    register_rest_route('api/v2', '/branches', array(
        'methods' => 'GET',
        'callback' => 'get_branches_callback',

    ));
});

function get_branches_callback(WP_REST_Request $request) {
    global $wpdb ;
    return $wpdb->get_results("SELECT  branch_id,address_en , address_ar , branch_name_ar , branch_name_en FROM pwa_branches");

}

add_action('rest_api_init', function () {
    register_rest_route('api/v2', '/stock-availability', array(
        'methods' => 'GET',
        'callback' => 'get_stock_availability_callback',

    ));
});

function get_stock_availability_callback(WP_REST_Request $request) {
    global $wpdb ;
    $request_data = $request->get_json_params();
    $select_branch_id = '' ;
    if(!empty($request_data['district'])){
        $street_obj   = get_street_name_by_id($request_data['district']);
        if($street_obj){
            $select_branch_id = $street_obj->branch_id ;
        }else{
            echo json_encode(['ERR' => "ERR_No_Payload", "message" => "District Not Found" ], JSON_THROW_ON_ERROR);
            exit();
        }
    }else{
        $select_branch_id = $request_data['branch'];
    }
    $out_of_stock_items = [] ;
    foreach ($request_data['items'] as $one_item){
        $product_object = $wpdb->get_row("select * from wp_posts where ID = '$one_item'") ;
        if($product_object-> post_type == "product_variation"){
            $parent_id = $product_object->post_parent ;
            $excluded_branches = get_post_meta($parent_id , "_branches" , true);
        }else {
            $excluded_branches = get_post_meta($product_object->ID, "_branches", true);
        }

        if(!empty($excluded_branches)){
            if(in_array($select_branch_id, $excluded_branches) ){
                if($product_object->post_type == "product_variation"){
                    $parent_product_object = $wpdb->get_row("select * from wp_posts where ID = '$product_object->post_parent'") ;
                    $data = [
                        "slug" =>  $parent_product_object->post_name ,
                    ];
                }else{
                    $data = [
                        "slug" =>  $product_object->post_name ,
                    ];
                }
                $out_of_stock_items [] = $one_item;
            }
        }
    }

    $data = [
        "matched_branch" => $wpdb->get_row("select  branch_id,address_en , address_ar , branch_name_ar , branch_name_en from pwa_branches where branch_id = '$select_branch_id'"),
        "out_of_stock_items" => $out_of_stock_items ,
    ];
    echo json_encode($data, JSON_THROW_ON_ERROR);




}






