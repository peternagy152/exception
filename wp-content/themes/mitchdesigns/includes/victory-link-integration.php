<?php

function generateGUID($order_id) {
    $timestamp = microtime(true);
    $randomNumber = mt_rand();
    $rawString = $order_id . $timestamp . $randomNumber;
    $hash = hash('sha256', $rawString);
    $guid = sprintf('%s-%s-%s-%s-%s',
        substr($hash, 0, 8),
        substr($hash, 8, 4),
        substr($hash, 12, 4),
        substr($hash, 16, 4),
        substr($hash, 20, 12)
    );

    return $guid;
}
function send_sms_vl($msg , $language , $order_id , $receiver , $status ){
$url = "https://smsvas.vlserv.com/VLSMSPlatformResellerAPI/NewSendingAPI/api/SMSSender/SendSMS";
$sms_id = generateGUID($order_id);
$data = array(
    "UserName" => "Exception-api",
    "Password" => "7s}!]KzoO.",
    "SMSText" => $msg,
    "SMSLang" => $language ,
    "SMSSender" => "Exception",
    "SMSReceiver" => $receiver,
    "SMSID" => $sms_id ,
);
$data_json = json_encode($data);
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Curl error: ' . curl_error($ch);
}
curl_close($ch);
    return $response ; 
}

add_action('woocommerce_order_status_changed', 'send_sms_on_order_status_change', 10, 4);
function send_sms_on_order_status_change($order_id, $old_status, $new_status, $order){
    $first_name = $order->get_billing_first_name() ; 
    $mobile_number = $order->get_billing_phone() ; 
    $order_language = "A" ;  
    if(get_post_meta($order_id , "_selected_language")[0] == "en"){
        $order_language = "E" ;
    } 


    if(get_post_status($order_id)  == "wc-processing"){
        if($order_language == "A"){
            $msg = "أهلاً " . $first_name . ", . أستلمنا الطلب بنجاح، برجاء العلم أن أحد مندوبي خدمة العملاء سوف يتصل بك لمراجعة و تأكيد الطلب " ;
        }else{
            $msg = "Hello " . $first_name .", we received the order successfully. Please note that a customer service representative will contact you to review and confirm the order.";
        }

        //$admin_msg = "Hello Admin , New Order with ID: ". $order_id . " has been submitted. Please log in to the admin panel to review and process the order.";
        $new_order_notification = "تم ارسال طلب جديد رقم :" . $order_id ;

        $VL_admin_1_response = send_sms_vl($new_order_notification , "A" , $order_id , "01099335774" , "7");
        $VL_admin_2_response = send_sms_vl($new_order_notification , "A" , $order_id , "01099959273" , "8");
        $VL_admin_3_response = send_sms_vl($new_order_notification , "A" , $order_id , "01118011118" , "9");
        //$VL_admin_4_response = send_sms_vl($new_order_notification , "A" , $order_id , "01227165958" , "6");


        $VL_response = send_sms_vl($msg , $order_language , $order_id , $mobile_number , "1");

        //Order Notes 
        // Customer 
        $order->add_order_note("victory link response : " . $VL_response);
        //Admins 
        $order->add_order_note("victory link response - admin 1  : " . $VL_admin_1_response);
        $order->add_order_note("victory link response - admin 2  : " . $VL_admin_2_response);
        $order->add_order_note("victory link response - admin 3  : " . $VL_admin_3_response);

    }else if(get_post_status($order_id) == "wc-cancelled"){
        if($order_language == "A"){
            $msg = "أهلاً " . $first_name . " لقد تم إلغاء طلبك رقم " . $order_id  ; 
        }else{
            $msg = "Hello ". $first_name .", your order #". $order_id ." has been cancelled." ;
        }
      
        $VL_response = send_sms_vl($msg , $order_language ,  $order_id , $mobile_number , "2");
        //$order->add_order_note("victory link response : " . $VL_response);
        

    }else if(get_post_status($order_id) == "wc-completed"){
        if($order_language == "A"){
            $msg = "أهلاً " . $first_name . " لقد تم توصيل طلبك رقم " . $order_id  ; 
        }else{
            $msg = "Hello ". $first_name .", your order #". $order_id ." has been delivered." ;
        }
        $VL_response = send_sms_vl($msg , $order_language , $order_id , $mobile_number , "3");
        //$order->add_order_note("victory link response : " . $VL_response);
    }else if(get_post_status($order_id) == "wc-shipped"){
        if($order_language == "A"){
            $msg = "أهلاً " . $first_name . " طلبك رقم " . $order_id . " في الطريق لك" ; 
        }else{
            $msg = "Hello ". $first_name .", your order #". $order_id ." is on the way to you ." ;

        }
       
        $VL_response = send_sms_vl($msg , $order_language , $order_id , $mobile_number , "4");
        //$order->add_order_note("victory link response : " . $VL_response);
    }else if(get_post_status($order_id) == "wc-ready-to-ship"){
        if($order_language == "A"){
            $msg = "أهلاً " . $first_name . " يتم حالياً تجهيز طلبك رقم " . $order_id  ; 
        }else{
            $msg = "Hello ". $first_name .", your order #". $order_id ." is currently being processed." ;
        }
      
        $VL_response = send_sms_vl($msg , $order_language , $order_id , $mobile_number , "5");
         //$order->add_order_note("victory link response : " . $VL_response);
    }

}











?>
