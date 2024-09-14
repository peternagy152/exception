<?php

// Language = en or ar
function Myaccount_translation($phrase , $language){
    static $my_account_translation = array(
        // Sidebar
        'myaccount_page_sidebare_overview_en'  => 'Overview',                             'myaccount_page_sidebare_overview_ar'  => 'الرئيسية', 
        'myaccount_page_sidebare_home_en'      => 'Account Info',                         'myaccount_page_sidebare_home_ar'      => 'بيانات الحساب',
        'myaccount_page_sidebare_orders_en'    => 'Orders & Returns',                     'myaccount_page_sidebare_orders_ar'    => 'طلباتي',
        'myaccount_page_sidebare_address_en'   => 'Shipping Addresses',                   'myaccount_page_sidebare_address_ar'   => 'عناويني ',
        'myaccount_page_sidebare_profile_en'   => 'Account Info',                         'myaccount_page_sidebare_profile_ar'   => 'بياناتي',
        'myaccount_page_sidebare_logout_en'    => 'Log out',                              'myaccount_page_sidebare_logout_ar'    => 'تسجيل الخروج',
        'wishlist_page_title_en'               => 'My Wishlist',                          'wishlist_page_title_ar'               => 'قائمة أمنياتي',
        'myaccount_page_title_en'              => 'My Account',                           'myaccount_page_title_ar'              => 'حسابي',
        'myaccount_page_sidebar_need_help_en'  => 'Need Help ?',                          'myaccount_page_sidebar_need_help_ar'  => 'هل تحتاج للمساعدة؟',
        'myaccount_page_sidebar_faq_en'        => 'FAQs',                                 'myaccount_page_sidebar_faq_ar'        => 'الأسئلة المتداولة',
        'myaccount_page_sidebar_contact_us_en' => 'Contact Us',                           'myaccount_page_sidebar_contact_us_ar' => 'تواصل معنا', 
        'myaccount_page_sidebar_title_menu_help_en' => 'Need Help',                      'myaccount_page_sidebar_title_menu_help_ar' => 'تحتاج مساعدة؟', 
        'myaccount_pagination_home_en'         => 'Home' ,                                'myaccount_pagination_home_ar'         => 'الصفحة الرئيسية' ,

        // Overview Page 
        'welcome_message_title_en'             => 'Welcome To Your Account',              'welcome_message_title_ar'             => 'صفحة حسابي الرئيسية',
        'welcome_message_subtitle_en'          => 'You can manage your account info, wallet and orders',
        'welcome_message_subtitle_ar'          => 'يمكنك إدارة الطلبات والمحفظة ومعلومات الحساب الخاصة بك هنا.',
        'sharebutton_title_en'          => 'Share naseej With Family & Friends',
        'sharebutton_title_ar'          => 'شارك الموقع مع الأصحاب والعائلة',
        'sharebutton_subtitle_en'          => 'Share the below link with your beloved and get special offers',
        'sharebutton_subtitle_ar'          => 'أنسخ الرابط أدناه وشاركه مع عائلتك وأصدقائك واحصل على خصومات حصرية',
        'link_title_copy_en'      => 'Copy Link',                     'link_title_copy_ar'      => 'نسخ',
        'link_title_copied_en'      => 'Copied!',                     'link_title_copied_ar'      => 'تم نسخ',
        'overview_orders_return_title_en'      => 'Orders & Returns',                     'overview_orders_return_title_ar'      => 'طلباتى الحالية',
        'overview_orders_return_table_titles_status_en'      => 'Status',                 'overview_orders_return_table_titles_status_ar'      => 'حالة الطلب',
        'overview_orders_return_table_titles_order_no_en'     => 'Order NO.',             'overview_orders_return_table_titles_order_no_ar'     => 'رقم الطلب',
        'overview_orders_return_table_titles_date_en'         => 'Date',                  'overview_orders_return_table_titles_date_ar'         => 'التاريخ',
        'overview_orders_return_table_titles_price_en'      => 'Price',                   'overview_orders_return_table_titles_price_ar'      => 'المجموع',
        'overview_orders_return_table_titles_button_en'      => 'View Order Details',     'overview_orders_return_table_titles_button_ar'      => 'عرض',
        'wallet_balance_en'                    => 'Wallet Balance',                       'wallet_balance_ar'                    => 'رصيد محفظتي',
        'Points_keyword_en'                    => 'Points',                               'Points_keyword_ar'                    => 'النقاط',
        'Total_points_keyword_en'              => 'Total Points'   ,                       'Total_points_keyword_ar'              => 'إجمالي النقاط',
        'Edit_keyword_en'                       =>'Edit' ,                                 'Edit_keyword_ar'                       =>'تعديل' ,
        'Wishlist_no_items_en'                  =>'There’s no items in your wishlist' ,   'Wishlist_no_items_ar'                  =>'لا توجد عناصر في قائمة أمنياتك' ,
        'register_message_en'                  =>'Thank You For Joining Exception Family', 'register_message_ar'                  =>'شكرا لانضمامك لعائلة اكسبشن',


        //Shipping Addresses 
        'shipping_default_address_en'          => 'Default Address' ,                     'shipping_default_address_ar'          => 'عنوان الشحن الرئيسي' ,
        'shipping_address_en'                  => 'Address' ,                             'shipping_address_ar'                  => 'العنوان' ,
        'shipping_city_en'                     => 'City' ,                                'shipping_city_ar'                     => 'المدينة ' ,
        'shipping_area_en'                     => 'Area' ,                                'shipping_area_ar'                     => 'الحي ' ,
        'shipping_district_en'                 => 'Disrtict' ,                        'shipping_district_ar'                     => 'المنطقة' ,
        'shipping_street_en'                   => 'Street & Building No.' ,               'shipping_street_ar'                   => 'رقم واسم الشارع' ,
        'shipping_floor_en'                    => 'Floor' ,                               'shipping_floor_ar'                    => 'الطابق' ,
        'shipping_apartment_en'                => 'Apartment' ,                           'shipping_apartment_ar'                => 'الشقة' ,
        'shipping_add_new_address_en'          => 'Add New Address' ,                     'shipping_add_new_address_ar'          => 'اضف عنوان' ,
        'shipping_edit_address_en'             => 'Edit Address' ,                        'shipping_edit_address_ar'             => 'تعديل العنوان ' ,
        'shipping_make_default_en'             => 'Make Default' ,                        'shipping_make_default_ar'             => 'جعله العنوان الافتراضي' ,
        'shipping_remove_en'                   => 'Remove' ,                              'shipping_remove_ar'                   => 'حذف' ,
        'shipping_no_address_note_en'          =>'There’s no shipping addresses'   ,      'shipping_no_address_note_ar'          =>'لا يوجد عناوين للشحن '  ,
        'myaccount_page_addresses_edit_add_en'          =>'Edit Address'   ,      'myaccount_page_addresses_edit_add_ar'          => 'تعديل عنوان',

        //Wallet Page 
        'wallet_title_en'                      => 'My Wallet' ,                           'wallet_title_ar'                      => 'محفظتى' ,
        'wallet_subtitle_en'                   => 'Wallet balance are available to be used on your upcoming order, Cant be refund in cash' ,
        'wallet_subtitle_ar'                   => 'يمكن استخدام رصيد المحفظة على طلبك القادم ، ولا يمكن استردادها نقدًا' ,
        'wallet_create_account_en'             => 'Create Account' ,                      'wallet_create_account_ar'             => 'انشاء حساب' ,
        'wallet_Birthday_bonus_en'             => 'Birthday Bonus' ,                      'wallet_Birthday_bonus_ar'             => 'مكافأة عيد الميلاد' ,
        'wallet_refer_to_friend_en'            => 'Refer Friend' ,                        'wallet_refer_to_friend_ar'            => 'أحالة الصديق' ,
        'wallet_points_title_en'               => 'Points History' ,                      'wallet_points_title_ar'               => 'تاريخ النقاط' ,
        'wallet_reason_en'                     => 'Reason' ,                              'wallet_reason_ar'                     => 'السبب' ,

        // Account Info 
        'account_first_title_en'               =>'Your Info.' ,                          'account_first_title_ar'                =>'بيانات الحساب' ,
        'account_first_name_en'                =>'First Name' ,                           'account_first_name_ar'                =>'الأسم الأول' ,
        'account_last_name_en'                 =>'Last Name' ,                            'account_last_name_ar'                 =>'أسم العائلة' ,
        'account_email_en'                     =>'Email Address' ,                        'account_email_ar'                     =>'البريد الاكتروني' ,
        'account_mobile_en'                    =>'Mobile' ,                               'account_mobile_ar'                    =>'رقم الجوال' ,
        'account_birthdate_en'                 => 'Date Of Birth' ,                       'account_birthdate_ar'                 => 'تاريخ الميلاد' ,
        'account_gender_en'                    =>'Gender' ,                               'account_gender_ar'                    =>'الجنس' ,
        'account_gender_male_en'               =>'Male' ,                                 'account_gender_male_ar'               =>'ذكر' ,
        'account_gender_female_en'               =>'Female' ,                              'account_gender_female_ar'            =>'انثي' ,
        'account_change_password_en'           =>'Change Password' ,                      'account_change_password_ar'           =>'تغيير كلمة السر' ,
        'account_info_message_en'              =>'Account Info Changed Successfully',     'account_info_message_ar'              =>'تم تغيير معلومات الحساب بنجاح'  ,
        'account_save_en'                      =>'Save Changes' ,                         'account_save_ar'                      =>'احفظ التغييرات' ,
        'account__password_en'                 =>'Password' ,                             'account__password_ar'                 =>' كلمة السر' ,
        'account_Day_en'                       =>'Day',                                   'account_Day_ar'                       =>'اليوم',
        'account_Month_en'                     =>'Month',                                 'account_Month_ar'                     =>'الشهر',   
        'account_Year_en'                      =>'Year',                                  'account_Year_ar'                      =>'السنة',  
        'account_aready_have_en'               =>'Already have an Account?',              'account_aready_have_ar'               =>'لديك حساب ',       
        'account_register_en'                  =>'Register',                              'account_register_ar'                  =>'انشاء حساب ',

        //Orders & Returns  
        'Orders_shop_now_en'                  =>'Shop Now' ,                               'Orders_shop_now_ar'                  =>'تسوق الان', 
        'Orders_no_orders_en'                 =>'There’s no orders yet',                   'Orders_no_orders_ar'                 =>'لا يوجد طلبات حاليا', 
        'Orders_items_en'                     =>'Number Of Items',                         'Orders_items_ar'                     =>'عدد العناصر',
        'Orders_Order_placed_en'              =>'Order Placed',                            'Orders_Order_placed_ar'              =>'تم استلام الطلب',
        'Orders_order_preparing_en'           =>'Order Prepairing',                        'Orders_order_preparing_ar'           =>'يتم تحضير الطلب', 
        'Orders_ready_to_ship_en'             =>'Order Ready To Ship',                     'Orders_ready_to_ship_ar'             =>'الطلب جاهز للشحن',  
        'Orders_order_shipped_en'             =>'Order Shipped' ,                          'Orders_order_shipped_ar'             =>'تم شحن الطلب' ,
        'Orders_order_delivery_en'            =>'Order Delivered',                         'Orders_order_delivery_ar'            =>'تم توصيل الطلب',
        'Orders_shipping_info_en'             =>'Shipping Info',                           'Orders_shipping_info_ar'             =>'تفاصيل الشحن',
        'Orders_payment_method_en'            =>'Payment Method',                          'Orders_payment_method_ar'            =>'طريقة الدفع',


        // Some Keywords Related to Checkout and Order 
        'Order_subtotal_en'                   =>'Subtotal',                               'Order_subtotal_ar'                   =>'المبلغ',  
        'Order_total_en'                      =>'Total',                                  'Order_total_ar'                      =>'المجموع الكلي',
        'Order_shipping_en'                   =>'Shipping',                               'Order_shipping_ar'                   =>'التوصيل', 
       
        'Order_payondelivery_en'              =>'Pay On Delivery',                        'Order_payondelivery_ar'              =>'المطلوب دفعه عند الاستلام',
        'Order_wallet_redeem_en'              =>'Wallet Redeem',                          'Order_wallet_redeem_ar'              =>'خصم باستخدام النقاط',
        'Order_coupon_en'                     =>'Coupon',                                 'Order_coupon_ar'                     =>'قسيمة شراء',
        'Order_cancel_en'                     =>'Cancel Order',                           'Order_cancel_ar'                     =>'الغاء الطلب', 
        'Order_again_en'                      =>'Order Again',                            'Order_again_ar'                      =>'اعادة الطلب',
        'Order_return_request_en'             =>'Request Return',                         'Order_return_request_ar'             =>'استرجاع منتج',


        // Reset Password 
        'Reset_no_parameters_en'              =>'Something Went Wrong , You Are Not Allowed',     'Reset_no_parameters_ar'      =>'حدث خطأ ما ، غير مسموح لك',
        'Reset_success_reset_en'              =>' Your password has been reset',          'Reset_success_reset_ar'              =>' تم إعادة تعيين كلمة المرور الخاصة بك',
        'Reset_login_link_en'                 =>'Log in here',                            'Reset_login_link_ar'                 =>'سجل الدخول هنا',
        'Reset_password_reset_en'             =>' Reset Your Password',                   'Reset_password_reset_ar'             =>'اعد ضبط كلمه السر',
        'Reset_change_password_en'            =>'Change Password',                        'Reset_change_password_ar'            =>'تغيير كلمة المرور',
        'Reset_invalid_en'                    =>'Invalid key or expired link',            'Reset_invalid_ar'                    =>'مفتاح غير صالح أو ارتباط منتهي الصلاحية',
        'Reset_forgot_en'                     =>'New Password',                           'Reset_forgot_ar'                     =>'كلمة مرور جديدة',         

        //Forgot Password   
        'Forgot_success_en'                   =>'An email has been sent to your email address with instructions on how to reset your password' ,
        'Forgot_success_ar'                   =>'تم إرسال بريد إلكتروني إلى عنوان بريدك الإلكتروني مع تعليمات حول كيفية إعادة تعيين كلمة المرور الخاصة بك' ,
        'Forget_invalid_en'                   =>' Invalid email address ' ,               'Forget_invalid_ar'                   =>'عنوان البريد الإلكتروني غير صالح ' , 
        'Forgot_entry_en'                    =>'Lost your password? Please enter your Username or Email Address. You will receive a link to
        create a new password via email.',
        'Forgot_entry_ar'                    =>'فقدت كلمة المرور الخاصة بك؟ الرجاء إدخال اسم المستخدم أو عنوان البريد الإلكتروني. سوف تتلقى ارتباط إلى
        إنشاء كلمة مرور جديدة عبر البريد الإلكتروني.',
        'Forgot_username_en'                 => 'Username Or Email',                     'Forgot_username_ar'                 => 'اسم المستخدم أو البريد الالكتروني',  
       

        //Login 
        'Sign_login_keyword_en'              =>'Login',                                   'Sign_login_keyword_ar'              =>'تسجيل الدخول',
        'Sign_create_account_en'             =>'Create Account',                          'Sign_create_account_ar'             =>'إنشاء حساب',
        'Sign_create_sentience_en'           =>'By creating account you will win points on your wallet to use it later, and add more addresses and track your order.',
        'Sign_create_sentience_ar'           =>'من خلال إنشاء حساب ، ستربح نقاطًا في محفظتك لاستخدامها لاحقًا ، وإضافة المزيد من العناوين وتتبع طلبك.',
        'Sign_new_client_en'                 =>'New Client',                              'Sign_new_client_ar'                 =>'عميل جديد',
        'Sign_create_senetence2_en'          =>'If you already ordered as a guest before, Please create your account using the same mail to track your orders',
        'Sign_create_senetence2_ar'          =>'إذا كنت قد طلبت بالفعل كضيف من قبل ، فيرجى إنشاء حسابك باستخدام نفس البريد لتتبع طلباتك',

        //Register 
        'alert_profile_setting_exist_email_en' => 'There is a Problem with the Selected Email' ,
        'alert_profile_setting_exist_email_ar' => 'يوجد مشكلة في البريد الاكتروني المختار!' ,
        'alert_profile_set_phone_err_en'       => 'There is a Problem with the Selected Phone',
        'alert_profile_set_phone_err_ar'       => 'يوجد مشكلة في  رقم الهاتف المختار!',
        'alert_profile_set_pass_validate_ar'   => 'يجب ان تكون كلمة السر مكونة من 8 احرف',
        'alert_profile_set_pass_validate_en'   => 'Password Must Contain at least 8 Chars',













       
      );

      return $my_account_translation[$phrase . '_' . $language] ;
}

// Month Translation 

//Order Status Translation 

// Payment Methods Translation 

// Popup Translation
function Popup($phrase , $language){
  static $popup_translation = array(

      // Change Password Popup 
      'Current_password_en'                    =>' Please Enter Your Current Password',           'Current_password_ar'                    =>'تعديل كلمه السر الحالية', 
      'Wrong_current_password_en'              =>'Passwords Does Not Match !',                    'Wrong_current_password_ar'              =>'كلمات المرور غير متطابقة !',
      'New_password_en'                        =>'Enter Your New Password',                       'New_password_ar'                        =>'أدخل كلمة المرور الجديدة',
      'Confirm_new_password_en'                =>'Confirm Your New Password',                     'Confirm_new_password_ar'                =>'قم بتأكيد كلمة المرور الجديدة الخاصة بك',
      'forgot_password_en'                     =>'Forgot Your Password?',                         'forgot_password_ar'                     =>'نسيت كلمة المرور ',  
      'account_change_password_en'             =>'Change Password' ,                              'account_change_password_ar'             =>'تغيير كلمة السر' , 
      'choose_city_en'                         =>'Choose City',                                   'choose_city_ar'                         =>'اختر المدينة',
      'choose_area_en'                         =>'Choose Area',                                   'choose_area_ar'                         =>'اختر الحي',
      'choose_district_en'                     =>'Choose District',                               'choose_district_ar'                     =>'اختر المنطقة',

     
    );

    return $popup_translation[$phrase . '_' . $language] ;
}

function Order_status($phrase , $language){
   static $status = array(

    // Change Password Popup 
    'Current_password_en'                    =>' Please Enter Your Current Password',           'Current_password_ar'                    =>'تعديل كلمه السر الحالية', 
    'completed_en'                           => 'completed' ,             'completed_ar'                           => 'تم توصيل الطلب' , 
    'cancelled_en'                           => 'cancelled' ,              'cancelled_ar'                           => 'تم  إلغاء الطلب ',
    'processing_en'                          => 'processing' ,             'processing_ar'                         => 'تم استلام طلبك',
    'refunded_en'                            => 'refunded'    ,              'refunded_ar'                            => 'تم الاسترجاع'    ,    

   
  );

  return $status[$phrase . '_' . $language] ;
}