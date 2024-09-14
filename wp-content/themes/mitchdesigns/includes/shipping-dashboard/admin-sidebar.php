<?php 

function enqueue_custom_admin_scripts() {
   
    wp_enqueue_script('bootstrap-bundle', home_url() . '/wp-content/themes/mitchdesigns/assets/vendor/bootstrap/js/bootstrap.bundle.min.js', array(), null, true);
    wp_enqueue_script('validate', home_url() . '/wp-content/themes/mitchdesigns/assets/custom.js', array(), null, true);
}
add_action('admin_enqueue_scripts', 'enqueue_custom_admin_scripts');


function enqueue_custom_admin_styles() {
    // Enqueue the necessary styles
    wp_enqueue_style('bootstrap-css',  home_url() . '/wp-content/themes/mitchdesigns/assets/vendor/bootstrap/css/bootstrap.min.css');
    wp_enqueue_style('bootstrap-icons',  home_url() . '/wp-content/themes/mitchdesigns/assets/vendor/bootstrap-icons/bootstrap-icons.css');
    //wp_enqueue_style('main-css',  home_url() . '/wp-content/themes/mitchdesigns/assets/sass/main.css');

}
add_action('admin_enqueue_scripts', 'enqueue_custom_admin_styles'); 

function load_media_files() {
    wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'load_media_files' );




function Shipping_Rates_dashboard_Controller() {
	  add_menu_page(
        'Shipping System', // Page title
        'Shipping System', // Menu title
        'manage_branch_controller' , // Capability required to access the page
        'branch-controller', // Page slug
        'branch_controller_callback' , // Callback function that displays the page
       // 'https://backend.woosonicpwa.com/wp-content/uploads/2023/10/icons8-wallet-64-1.png' , // URL of the custom icon
         //20 // Position in the menu (you can adjust this as needed)
    );
		   add_submenu_page(
        'branch-controller', // Parent menu slug
        'Areas', // Page title
        'Areas', // Menu title
        'manage_branch_controller', // Capability required to access the page
        'view-all-areas', // Page slug
        'areas_dashboard_callback' // Callback function that displays the page
    );
     add_submenu_page(
        'branch-controller', // Parent menu slug
        'Streets', // Page title
        'Streets', // Menu title
        'manage_branch_controller', // Capability required to access the page
        'view-all-streets', // Page slug
        'streets_dashboard_callback' // Callback function that displays the page
    );
}
add_action( 'admin_menu', 'Shipping_Rates_dashboard_Controller' ); 

function check_shop_manager_capability() {
    $role = get_role( 'shop_manager' );
    $admin = get_role( 'administrator' );
    $role->add_cap( 'manage_branch_controller' );
     $admin->add_cap( 'manage_branch_controller' );
}
