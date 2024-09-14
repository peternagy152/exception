<?php
//thired party integrations
if (isset($_GET['lang'])) {
    $language = 'en';
} else {
    $language = 'ar';
}


require_once 'includes/campaign-monitor/csrest_subscribers.php';
//internal functions
require_once 'includes/global-functions.php';
require_once 'includes/products-functions.php';
require_once 'includes/wishlist-functions.php';
require_once 'includes/cart-functions.php';
require_once 'includes/checkout-functions.php';
require_once 'includes/myaccount-functions.php';
require_once 'includes/wpadmin-functions.php';
require_once 'includes/pages-functions.php';
//require_once 'includes/backorders-functions.php';


// Include All My Account Functions
require_once(ABSPATH . 'myaccount/myaccount-global-functions/myaccount-translation.php');
require_once(ABSPATH . 'myaccount/myaccount-global-functions/new-myaccount-functions.php');
//require_once( ABSPATH . 'myaccount/myaccount-global-functions/points-system-dashboard.php' );
//require_once( ABSPATH . 'myaccount/myaccount-global-functions/points-system-functions.php' );
//require_once( ABSPATH . 'myaccount/myaccount-global-functions/wallet-payment.php' );


// Translations
require_once 'translation/product-translation.php';
require_once 'translation/checkout-translation.php';
require_once 'translation/popups-translation.php';
require_once 'translation/custom-cake.php';
// Global Variables 
require_once 'includes/global-variables.php';

//Shipping Rates And Branches System 
require_once 'includes/shipping-and-branches/shipping-database-functions.php';
require_once 'includes/shipping-and-branches/shipping-rates.php';


// Custom Admin Dashboard 
require_once(ABSPATH . 'dashboard/dashboard-functions.php');

//Step By Step Cake Customizations 
require_once 'includes/step-by-step-functions.php';

//Victory Link SMS Integration 
//require_once 'includes/victory-link-integration.php';

// Shipping Dashboards 
require_once 'includes/shipping-dashboard/admin-sidebar.php';
require_once 'includes/shipping-dashboard/branches/branches-dashboard.php';
require_once 'includes/shipping-dashboard/areas/areas-dashboard.php';
require_once 'includes/shipping-dashboard/streets/streets-dashboard.php';

// Upload Settings 
// File Size Upload 

add_filter('upload_size_limit', 'wpse_163236_change_upload_size');
function wpse_163236_change_upload_size()
{
    return 1024 * 300;
}

// function restrict_upload_to_webp($data, $file, $filename, $mimes) {
//     $ext = pathinfo($filename, PATHINFO_EXTENSION);

//     if (strtolower($ext) !== 'webp') {
//         wp_die('Only .webp images are allowed for upload.');
//     }

//     return $data;
// }
// add_filter('wp_check_filetype_and_ext', 'restrict_upload_to_webp', 10, 4);

// function disable_image_sizes($sizes) {
//     return array();
// }
// add_filter('intermediate_image_sizes', 'disable_image_sizes');


// Almond Paste Special Cake 
function modify_cart_item_price($cart)
{
    // Get the product ID of the item you want to modify
    $target_product_id = 1730;
    // Loop through each cart item
    foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
        // Check if the current item matches the target product ID
        // var_dump($cart_item['variation']['selected_price']);
        if ($cart_item['product_id'] === $target_product_id) {
            $cart_item['data']->set_price($cart_item['variation']['selected_price']);
        }

        if ($cart_item['product_id'] === 3065) {
            $cart_item['data']->set_price($cart_item['variation']['price']);
        }
    }
}

add_action('woocommerce_before_calculate_totals', 'modify_cart_item_price');

function formatArabicDate($date)
{
    global $dayTranslations;
    global $monthTranslations;
    list($year, $month, $day) = explode('-', $date);
    $dayName = $dayTranslations[date('l', strtotime($date))];
    $monthName = $monthTranslations[date('F', strtotime($date))];
    $formattedDate = $dayName . ' ' . (int)$day . ' ' . $monthName . ' ' . $year;

    return $formattedDate;
}


function theme_global_variables()
{
    global $dayTranslations;
    $dayTranslations = array(
        'Sunday' => 'الأحد',
        'Monday' => 'الاثنين',
        'Tuesday' => 'الثلاثاء',
        'Wednesday' => 'الأربعاء',
        'Thursday' => 'الخميس',
        'Friday' => 'الجمعة',
        'Saturday' => 'السبت'
    );
    global $monthTranslations;
    $monthTranslations = array(
        'January' => 'يناير',
        'February' => 'فبراير',
        'March' => 'مارس',
        'April' => 'أبريل',
        'May' => 'مايو',
        'June' => 'يونيو',
        'July' => 'يوليو',
        'August' => 'أغسطس',
        'September' => 'سبتمبر',
        'October' => 'أكتوبر',
        'November' => 'نوفمبر',
        'December' => 'ديسمبر'
    );
}

add_action('after_setup_theme', 'theme_global_variables');

// Remove Cash on Delivery payment method if product with ID "3383" is in the cart
add_filter('woocommerce_available_payment_gateways', 'remove_cod_for_specific_product');

function remove_cod_for_specific_product($available_gateways)
{
    // Check if the product with ID "3065" is in the cart
    if (is_product_in_cart(1730) || is_product_in_cart(3065)) {
        // Remove the Cash on Delivery payment method
        unset($available_gateways['cod']);
    }

    return $available_gateways;
}

// Helper function to check if a product is in the cart
function is_product_in_cart($product_id)
{
    if (WC()->cart != null) {
        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            $product = $cart_item['data'];
            if ($product->get_id() === $product_id) {
                return true;
            }
        }
    }

    return false;
}

function save_custom_data_to_order_item_meta($item, $cart_item_key, $values, $order)
{


    if (isset($values['cake_note']) || $values['cake_text']) {
        $cake_note = $values['cake_note'];
        $cake_text = $values['cake_text'];
        $item->add_meta_data('cake_note', $cake_note);
        $item->add_meta_data('cake_text', $cake_text);
    }

    // if(isset($values['shape']) ){
    //     $shape_name = get_shape_value($values['shape']);
    //     $flavor_name = get_flavor_value($values['flavor']);
    //     $filling_name = get_filling_value($values['flavor'] , $values['filling']);

    //     $color_name = "" ;
    //     if(!empty($values['color'])){
    //         $color_name = get_color_value($color);
    //     }
    //     $toping_name = "";

    //     if(!empty($values['toping'])){
    //         $toping_name = get_toping_value($toping);
    //     }
    //   $item->add_meta_data('shape', $shape_name -> shape_ar ,  );
    //   $item->add_meta_data('size', $values['size'] );
    //   $item->add_meta_data('height', $values['height'] );
    //   $item->add_meta_data('flavor',  $flavor_name -> flavor_ar );
    //   $item->add_meta_data('filling', $filling_name -> filling_ar );
    //   $item->add_meta_data('color',$color_name -> color_ar  );
    //   $item->add_meta_data('toping', $toping_name -> type_ar );
    // }


}

add_action('woocommerce_checkout_create_order_line_item', 'save_custom_data_to_order_item_meta', 10, 4);


// Add custom radio options
add_action('woocommerce_review_order_before_payment', 'add_custom_radio_options');
function add_custom_radio_options()
{
    global $language;
    $custom_cake_found = false;
    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
        if ($cart_item['product_id'] == 3065) {
            $custom_cake_found = true;
            break;
        }
    }
    if ($custom_cake_found) {
        ?>
        <div class="new_downpayment_options">
            <?php

            $discount = WC()->cart->subtotal * 0.4;
            if ($language == 'en') {
                $full = " Full Payment " . WC()->cart->subtotal . 'EGP';
                $part = 'Pay Deposit at Delivery ' . $discount . ' EGP';
            } else {

                $full = "ادفع كامل المبلغ الان  " . WC()->cart->subtotal . 'جنيه';
                $part = 'ادفع عربون و الباقي عند الاستلام ' . $discount . 'جنيه';
            }
            ?>
            <ul class="choose_option">
                <li class="single_option active">
                    <input class="input_downpayment" type="radio" id="radio_option_1" name="downpayment_option"
                           value="full"
                           checked/>
                    <label class="label_downpayment" for="radio_option_1"> <?php echo $full ?> </label>
                </li>

                <li class="single_option">
                    <input class="input_downpayment" type="radio" id="radio_option_2" name="downpayment_option"
                           value="part"/>
                    <label class="label_downpayment" for="radio_option_2"> <?php echo $part ?> </label>
                </li>

            </ul>
        </div>
    <?php }
}

//add_action('woocommerce_after_checkout_billing_form', 'shipping_or_local_pick_options');
function shipping_or_local_pick_options()
{

    echo '<div id="shipping-options">';
    // Option 1
    echo '<label for="home"><input type="radio" id="home" name="shipping_option" value="delivery" checked /> Home Delivery  </label>';
    echo '<label for="local"><input type="radio" id="local" name="shipping_option" value="local"   />  Local Pickup </label><br />';
    // Option 2

    echo '</div>';
}

add_action('woocommerce_cart_calculate_fees', 'woo_add_cart_fee');
function woo_add_cart_fee($cart)
{
    if (!$_POST || (is_admin() && !is_ajax())) {
        return;
    }
    if (isset($_POST['post_data'])) {
        parse_str($_POST['post_data'], $post_data);
    } else {
        $post_data = $_POST; // fallback for final checkout (non-ajax)
    }

    if (isset($post_data['downpayment_option'])) {
        $discount = WC()->cart->subtotal * 0.6;
        if ($post_data['downpayment_option'] == 'part') {
            WC()->cart->add_fee('Rest Value', -$discount);
        }


    }
}

function clear_text($text)
{
    if (!$text) return;
    $text = trim($text);
    $text = stripslashes($text);
    return $text;


}

// Custom Fields [variation_system_id]  for Product Variations
// Add custom field to product variations
function add_variation_custom_field($loop, $variation_data, $variation)
{
    woocommerce_wp_text_input(array(
        'id' => '_variation_system_id[' . $loop . ']',
        'label' => __('System ID', 'woocommerce'),
        'placeholder' => __('Enter System ID', 'woocommerce'),
        'desc_tip' => 'true',
        'description' => __('Enter the system ID for this variation.', 'woocommerce'),
        'value' => get_post_meta($variation->ID, '_variation_system_id', true)
    ));
}

add_action('woocommerce_variation_options_pricing', 'add_variation_custom_field', 10, 3);

// Save custom field for product variations
function save_variation_custom_field($variation_id, $loop)
{
    $system_id = $_POST['_variation_system_id'][$loop];
    if (!empty($system_id)) {
        update_post_meta($variation_id, '_variation_system_id', esc_attr($system_id));
    }
}

add_action('woocommerce_save_product_variation', 'save_variation_custom_field', 10, 2);
// Remove Rank Math meta description
function remove_rank_math_meta_description()
{
    if (function_exists('rank_math_the_seo_framework')) {
        remove_action('wp_head', 'rank_math_description', 2);
    }
}

add_action('init', 'remove_rank_math_meta_description');

function rankmath_disable_features()
{
    global $post;
    remove_all_actions('rank_math/head');
}

add_action('wp_head', 'rankmath_disable_features', 1);


add_filter('jwt_auth_expire', 'custom_jwt_auth_expire');

function custom_jwt_auth_expire($expire)
{
    // Set the token to expire in a very long time (e.g., 100 years)
    return time() + (YEAR_IN_SECONDS * 100);
}

//Mobile App Endpoints

//Mobile App - My Account Functions
require_once 'includes/mobile-app/myaccount.php';
require_once 'includes/mobile-app/address.php';
require_once 'includes/mobile-app/my-orders.php';
require_once 'includes/mobile-app/wishlist.php';

//Branch System
require_once 'includes/mobile-app/branch.php';

// products
require_once 'includes/mobile-app/product.php';
require_once 'includes/mobile-app/checkout.php';
//Static Pages
require_once 'includes/mobile-app/static-pages.php';


function product_widget($product_id, $user_id , $branch_id)
{

    $product = wc_get_product($product_id);
    $liked = mitch_check_wishlist_product($user_id, $product_id);
    if ($liked) {$liked = true;}else{$liked=false;}
    $product_img = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'full');
    if (!empty($product_img)) {
        $product_img = $product_img[0];
    } else {
        $product_img = get_stylesheet_directory_uri() . '/assets/img/placeholder.webp';
    }
    $regular_variable_price = 0;
    if ($product->get_type() != 'simple') {
        $variation_prices = $product->get_variation_prices(true);
        $regular_variable_price = min($variation_prices['regular_price']);
    }

    $excluded_branches = get_post_meta($product_id, '_branches', true);
    $excluded = false ;
    if(in_array( $branch_id , $excluded_branches)){$excluded = true;}
    if($product->get_stock_status() == "outofstock" ){$stock_status = 'outofstock';} else{
        if($excluded){$stock_status = 'unavailable';}else{$stock_status = 'instock';}
    }

    $data = [
        "id" => $product_id,
        "liked" => $liked,
        "rating" => $product->get_average_rating() ,
        "slug" => $product->get_slug(),
        "name_en" => $product->get_name(),
        "name_ar" => get_post_meta($product_id, 'product_data_arabic_title')[0],
        "subtitle_en" => get_post_meta($product_id, 'product_data_subtitle_en')[0],
        "subtitle_ar" => get_post_meta($product_id, 'product_data_subtitle_ar')[0],
        "widget_note_text_en" => get_post_meta($product_id, 'product_data_widget_note_text_en')[0],
        "widget_note_text_ar" => get_post_meta($product_id, 'product_data_widget_note_text_ar')[0],
        "image" => $product_img,
        "type" => $product->get_type(),
        'price' => $product->get_price(),
        'is_on_sale' => $product->is_on_sale(),
        'regular_price' => $product->get_regular_price(),
        'product_variable_regular_price' => $regular_variable_price,
        "stock" => $stock_status,
    ];

    return $data;


}


