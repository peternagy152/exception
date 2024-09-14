<?php 

    

add_action('wp_ajax_MD_custom_dashboard_login', 'MD_custom_dashboard_login');
add_action('wp_ajax_nopriv_MD_custom_dashboard_login', 'MD_custom_dashboard_login');
function MD_custom_dashboard_login(){

    $branches = get_all_branches();
    $credentials_array = [];
    foreach($branches as $one_branch){
        $data =  [
            'branch_id' => $one_branch->branch_id ,
            "password" => $one_branch->branch_password , 
            'user_state' => "notmaster"
        ]; 

        $credentials_array[$one_branch->branch_username] = $data ; 
    }

    $data =  [
            'branch_id' => 0,
            'password' => 'sHgLvFqMmY00',
            'user_state' => "master"
        ]; 

    $credentials_array['exception_master_admin'] = $data ; 
    // $credentials_array = array(

    //     'exception_MOHA' => array(
    //         'branch_id' => 1,
    //         'password' => 'zkW46XriSAk0',
    //         'user_state' => "notmaster"
    //     ),
    //     'exception_SOMD' => array(
    //         'branch_id' => 2,
    //         'password' => 'uPf6qbBCbd8V',
    //         'user_state' => "notmaster"
    //     ),
    //     'exception_MADI' => array(
    //         'branch_id' => 3,
    //         'password' => 'jj0qXKAF0s81',
    //         'user_state' => "notmaster"
    //     ),
    //     'exception_HDA' => array(
    //         'branch_id' => 4,
    //         'password' => 'RRmZaX68Ws1w',
    //         'user_state' => "notmaster"
    //     ),
    //     'exception_ZAHR' => array(
    //         'branch_id' => 5,
    //         'password' => 'w0MXHP6RrK0e',
    //         'user_state' => "notmaster"
    //     ),
    //     'exception_MAD' => array(
    //         'branch_id' => 6,
    //         'password' => 'aspY007S66GX',
    //         'user_state' => "notmaster"
    //     ),
    //     'exception_HOCT' => array(
    //         'branch_id' => 7,
    //         'password' => '03QebJiCnLvb',
    //         'user_state' => "notmaster"
    //     ),
    //     'exception_MANS' => array(
    //         'branch_id' => 8,
    //         'password' => '5geZYg59ZQba',
    //         'user_state' => "notmaster"
    //     ),
    //     'exception_GESR' => array(
    //         'branch_id' => 9,
    //         'password' => 'lnRk2QjiG5LR',
    //         'user_state' => "notmaster"
    //     ),
    //     'exception_TAG' => array(
    //         'branch_id' => 10,
    //         'password' => 'cZC6RjUH144s',
    //         'user_state' => "notmaster"
    //     ),
    //     'exception_OCTG' => array(
    //         'branch_id' => 11,
    //         'password' => '3aZQAW74VdVl',
    //         'user_state' => "notmaster"
    //     ),
    //     'exception_HDN' => array(
    //         'branch_id' => 12,
    //         'password' => 'oDM0EEQR5CoW',
    //         'user_state' => "notmaster"
    //     ),
    //     'exception_FAYM' => array(
    //         'branch_id' => 13,
    //         'password' => 'lUN14JMThH81',
    //         'user_state' => "notmaster"
    //     ),
    //     'exception_TRSA' => array(
    //         'branch_id' => 14,
    //         'password' => 'PtOKA3x4A9Wk',
    //         'user_state' => "notmaster"
    //     ),
    //     'exception_FYSL' => array(
    //         'branch_id' => 15,
    //         'password' => '6ToX55eUgn5g',
    //         'user_state' => "notmaster"
    //     ),
    //     'exception_OCT' => array(
    //         'branch_id' => 16,
    //         'password' => 'O3Ilqd64PSVj',
    //         'user_state' => "notmaster"
    //     ),
    //     'exception_ZAYD' => array(
    //         'branch_id' => 17,
    //         'password' => '0Lgx02fIUaLq',
    //         'user_state' => "notmaster"
    //     ),
    //     'exception_NASR' => array(
    //         'branch_id' => 18,
    //         'password' => '8azCXe9SJ2o7',
    //         'user_state' => "notmaster"
    //     ),
    //     'exception_MARI' => array(
    //         'branch_id' => 19,
    //         'password' => 'e3aMArInAKE2',
    //         'user_state' => "notmaster"
    //     ),
    //     'exception_HDS' => array(
    //         'branch_id' => 20,
    //         'password' => 'YH5Sav6bCOYg',
    //         'user_state' => "notmaster"
    //     ),
    //     'exception_rehab' => array(
    //         'branch_id' => 21,
    //         'password' => '39JY4XAAwctn',
    //         'user_state' => "notmaster"
    //     ),
    //     'exception_MANI' => array(
    //         'branch_id' => 22,
    //         'password' => 'sD9ku9G@283C',
    //         'user_state' => "notmaster"
    //     ),
    //     'exception_SHUB' => array(
    //         'branch_id' => 23,
    //         'password' => '7FLgDx9e8gQc',
    //         'user_state' => "notmaster"
    //     ),
    //       'exception_MOKA' => array(
    //         'branch_id' => 24,
    //         'password' => '566TX7nWixDd',
    //         'user_state' => "notmaster"
    //     ),
    //     "exception_master_admin" => array(
    //         'branch_id' => 0,
    //         'password' => 'sHgLvFqMmY00',
    //         'user_state' => "master"
    //     )
        
    // );
    

    $post_form_data  = $_POST['form_data'];
	parse_str($post_form_data, $form_data);

    if(isset($credentials_array[$form_data['uname']])){
        if($form_data['psw'] == $credentials_array[$form_data['uname']]['password']){

            // Create New Session For Logged In 
            session_start(); 
            $expiration = 2 * 24 * 60 * 60;
            // Set the session cookie lifetime to 15 days
            ini_set('session.cookie_lifetime', $expiration);

            $Session_data = $form_data['uname'] . '-' . $credentials_array[$form_data['uname']]['user_state'] . '-' . $credentials_array[$form_data['uname']]['branch_id'];
            $_SESSION['admin_dashboard'] = $Session_data ;
            
            global $theme_settings;
            $response = array(
                'status'       => 'success',
                'msg'          => 'Logged In ' ,
                'redirection'   => $theme_settings['site_url']
              );
        }else{
            $response = array(
                'status'       => 'error',
                'msg'          => 'خطأ في البريد الإليكتروني أو كلمة السر' ,
              );
        }
    }else{
        $response = array(
            'status'       => 'error',
            'msg'          => 'خطأ في البريد الإليكتروني أو كلمة السر' ,
          );
    }

  echo json_encode($response);
  wp_die();
}

add_action('wp_ajax_MD_view_branch_details', 'MD_view_branch_details');
add_action('wp_ajax_nopriv_MD_view_branch_details', 'MD_view_branch_details');
function MD_view_branch_details(){

    $branch_id = $_POST['branch_id'] ;
    session_start(); 
    $session_info = explode('-', $_SESSION['admin_dashboard']);  
    $Session_data = $session_info[0]. '-' . $session_info[1] . '-' . $branch_id;
    $_SESSION['admin_dashboard'] = $Session_data ;
    $response =array('status' => "success" , 'msg' => "Session Updated");
    echo json_encode($response);
    wp_die();

}

add_action('wp_ajax_MD_destroy_session', 'MD_destroy_session');
add_action('wp_ajax_nopriv_MD_destroy_session', 'MD_destroy_session');
function MD_destroy_session(){

    session_start(); 
    unset($_SESSION['admin_dashboard']);
    session_destroy();
    
    $response =array('status' => "success" , 'msg' => "Session Updated");
    echo json_encode($response);
    wp_die();

}

// Exclude Function 
add_action('wp_ajax_MD_change_product_status', 'MD_change_product_status');
add_action('wp_ajax_nopriv_MD_change_product_status', 'MD_change_product_status');
function MD_change_product_status(){
    $product_id = $_POST['product_id'];
    $isChecked = $_POST['isChecked'] ;

    // isChecked = true -> Include into the Branch 
    // isChecked = False -> Exclude From Branch 

    session_start(); 
    $session_info = explode('-', $_SESSION['admin_dashboard']);   
    $branch_id = $session_info[2] ;
    $Excluded_branches = get_post_meta($product_id, '_branches', true); 
    if($isChecked == 'true'){
        //Remove From Excluded Array 
        //array_push($Excluded_branches , $branch_id );
        $index = array_search($branch_id, $Excluded_branches);
        if ($index !== false) {
            array_splice($Excluded_branches, $index, 1);
            update_post_meta($product_id, '_branches', $Excluded_branches);
        }

    }else {
        // Add the Branch to the Excluded Array 
        $new_excluded = array();
        foreach($Excluded_branches as $one_branch){
            $new_excluded[] = $one_branch;
        }
        $new_excluded[] = intval($branch_id);
        update_post_meta($product_id, '_branches', $new_excluded);
       
    }




    $response =array('status' => "success" , 'msg' => "Product Avaliablity Updated ");
    echo json_encode($response);
    wp_die();

}