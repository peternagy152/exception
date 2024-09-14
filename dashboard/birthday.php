<?php
require_once "/var/www/html/exception-group.com/public_html/wp-load.php";

function log_message($message) {
    $log_file = __DIR__ . '/../logs/birthday-logs.txt';
    $currentDateTime = new DateTime('now');
    $formattedDateTime = $currentDateTime->format('Y-m-d H:i:s');
    $log_entry = $formattedDateTime . " - " . $message . "\n";
    file_put_contents($log_file, $log_entry, FILE_APPEND);
}

global $wpdb ;
$all_users = $wpdb->get_results($wpdb->prepare("SELECT ID FROM ".$wpdb->prefix."users"));
foreach ($all_users as $user) {
    $currentDateTime = new DateTime('now');
    $current_day = $currentDateTime->format('d');
    $current_month = $currentDateTime->format('m');
    //User Data
    $phone = get_user_meta($user->ID, "phone_number", true);
    $first_name = get_user_meta($user->ID, "first_name", true);
    $last_name = get_user_meta($user->ID, "last_name", true);
    $user_birth_day = (get_user_meta($user->ID, "birth_day", true));
    $user_birth_month = (get_user_meta($user->ID, "birth_month", true));
    $user_birth_month++;
    $user_birthday = DateTime::createFromFormat('d-m', sprintf('%02d-%02d', $user_birth_day, $user_birth_month));
    $user_birthday->modify('-1 day');
    $birthday_day_before = $user_birthday->format('d');
    $birthday_month_before = $user_birthday->format('m');

    if ($current_month == $birthday_month_before && $current_day == $birthday_day_before) {
        $response = (send_sms_vl("عيد ميلادك بكره ! كل سنة وانت طيب إكسبشن دايما فكرك بالحلو وعشان الحلو للحلو اطلب تورتة عيد ميلادك من ويب سايت إكسبشن www.exception-group.com", "ar", rand(999, 99999), $phone, "9"));
        log_message("Birthday message sent to " . $first_name . " " . $last_name . " user ID " . $user->ID . " with response " . $response);
    }
}






