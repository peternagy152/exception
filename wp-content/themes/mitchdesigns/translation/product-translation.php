<?php 
function single_translate($phrase , $language){
  static $single_product_translation = array(

    'show_reviews_ar'  => 'اضف تقييم' ,                 'show_reviews_en'  => 'Add Review' , 
    'add_to_cart_ar' => 'اضف لعربة التسوق ' ,          'add_to_cart_en' => 'Add To Cart' , 
    'shipping_note_ar' => 'التوصيل في خلال ساعة واحدة فقط    ' ,'shipping_note_en' => 'Delivery within one hour only' ,
    'long_desc_ar'     => 'عن المنتج',                  'long_desc_en'     => 'About The Product', 
    'retention_section_ar'  =>'طرق الاحتفاظ',             'retention_section_en'  =>' Retention Methods',  
    'product_review_title_ar'  =>'تقييم المنتج',         'product_review_title_en'  =>'Review Product', 
    'product_review_subtitle_ar' => 'في رأيك، كام يستحق المنتج؟',     'product_review_subtitle_en' => 'In your opinion, how much is the product worth?', 
    'product_write_review_ar'    => 'اكتب تقييمات على هذا المنتج' ,   'product_write_review_en'    => 'Write Your Review On This Product' , 
    'not_allowed_review_ar'   =>'    فقط العملاء الذين قاموا بشراء هذا المنتج و الذين قاموا بتسجيل الدخول يمكنهم ترك مراجعة.',
    'not_allowed_review_en'   => 'Only customers who have purchased this product and are logged in can leave a review.', 
    'grade_A_ar'              => 'ممتاز' ,                'grade_A_en'              => 'Excellent' , 
    'grade_B_ar'              =>'جيد',                    'grade_B_en'              =>'good', 
    'grade_C_ar'              =>'عادي',                   'grade_C_en'              =>'Normal',
    'grade_D_ar'              =>'سئ',                     'grade_D_en'              =>'Bad',
    'grade_F_ar'              =>'سئ جداً',                 'grade_F_en'              =>'Very Bad', 
    'name_ar'                 =>'الاسم',                   'name_en'                 =>'Name', 
    'email_ar'                =>'الايميل',                 'email_en'                =>'Email',
    'leave_review_ar'         =>'اترك التقييم',           'leave_review_en'         =>'Leave Review',
    'add_review_ar'           =>'اضف التقييم',            'add_review_en'           =>'Add Review',    
    'success_review_ar'       => 'تم إدراج تقييمك وسيتم مراجعته ونشره قريبًا جدًا ، شكرًا لك.' ,
    'success_review_en'       => 'Your rating inserted and it will be reviewed and published very soon, thank you.',
     'out_of_stock_ar'  => ' غير متوفر' ,                 'out_of_stock_en'  => 'Out of Stock' ,


    );

    return $single_product_translation[$phrase . '_' . $language] ;
}

function upsell_translations($phrase , $language){
    static $upsell_section_translation = array(
        'addon_category_ar'             =>'لا تنسي الزينة' ,                'addon_category_en'             =>'Dont Forget The Decorations ' ,
        'random_products_ar'            =>'تسوق اكثر',                      'random_products_en'            =>' Shop More ', 
        'other_categories_ar'           =>'تشكيله واسعة من أشهي الأصناف في إنتظارك',    'other_categories_en'           =>'A wide variety of delicious items awaits you', 
        'recently_watched_ar'           =>'شوهد مؤخرا',                      'recently_watched_en'           => 'Recently Watched', 
        'load_more_button_ar'           =>'عرض المزيد',                     'load_more_button_en'           => 'View More',

      );
  
      return $upsell_section_translation[$phrase . '_' . $language] ;
  }


  function cart_page($phrase , $language){
    static $cart_translation =array (
      'cart_title_ar'     => 'سلة التسوق',                      'cart_title_en'      => 'Shopping Cart', 
      'item_ar'           => 'صنف',                              'item_en'           => 'Item', 
      'product_ar'        =>'المنتج',                            'product_en'        =>'Product',
      'price_ar'          =>'السعر',                             'price_en'          =>'Price', 
      'quantity_ar'       =>'الكميه',                            'quantity_en'       =>'Quantity', 
      'total_ar'          =>'الاجمالي',                           'total_en'          =>'Subtotal',
      'order_now_ar'      =>'اطلب الان',                          'order_now_en'      =>'Order Now',
      'do_Promo_ar'       =>'هل لديك برومو كود؟',               'do_Promo_en'        =>'Do You Have A Promocode ?', 
      'Promo_ar'          =>'برومو كود' ,                        'Promo_en'          =>'Promo Code' ,
      'fail_promo_ar'     =>'لم يعد الرمز الترويجي الذي أدخلته صالحًا',
      'fail_promo_en'     =>'The Promo Code You Entered is no longer valid', 
      'success_promo_ar'  =>'تم تطبيق الرمز الترويجي بنجاح', 
      'success_promo_en'  =>'The promo code is applied successfully',
      'remove_ar'         => 'حذف',                             'remove_en'         => 'Remove',
      'cart_page_ar'      =>'حقيبة التسوق',                     'cart_page_en'      =>'Cart Page', 
      'empty_cart_ar'     =>'لا توجد منتجات' ,
      'empty_cart_en'     =>'There is no Products in your cart !',
      'shop_now_ar'       => "تسوق الآن",                         'shop_now_en'       => "Shop Now",
      'edit_ar'           =>'تعديل',                              'edit_en'           =>'Edit',
        'minimum_spend_ar'           =>'الحد الأدنى للإنفاق لهذه القسيمة هو',                              'minimum_spend_en'           =>'The minimum spend for this coupon is ',

    );
    return $cart_translation[$phrase . '_' . $language] ;
  }

  function search_translate($phrase , $language){
    static $search_sidemenu_translation = array(
      'no_products_found_ar' => "لاتوجد منتجات",                'no_products_found_en' => "No Products Found !",
      "search_title_ar" => 'البحث',                             "search_title_en" => 'Search',
      'search_subtitle_ar' => 'البحث في المنتجات',             'search_subtitle_en' => 'Search In Products',

    ); 
    return $search_sidemenu_translation[$phrase . '_' . $language] ;

  }


  // =--------------------------------- Breadcrumbs Translation ----------------------
  

add_filter( 'woocommerce_breadcrumb_defaults', 'my_change_breadcrumb_delimiter' );
function my_change_breadcrumb_delimiter( $defaults ) {
	// Change the breadcrumb delimiter from '/' to '>'
	$defaults['delimiter'] = '';
	return $defaults;
}

add_filter( 'woocommerce_breadcrumb_defaults', 'custom_woocommerce_breadcrumbs' );
function custom_woocommerce_breadcrumbs() {
	global $language;
  if($language == 'en'){
    return array(
      'wrap_before' => '<ul class="breadcramb">',
      'wrap_after'  => '</ul>',
      'before'      => '<li>',
      'after'       => '</li>',
      'home'        => 'Home',
  );
  }else{
    return array(
      'wrap_before' => '<ul class="breadcramb">',
      'wrap_after'  => '</ul>',
      'before'      => '<li>',
      'after'       => '</li>',
      'home'        => 'الصفحة الرئيسية ',
  );
  }
	

}


    add_filter( 'woocommerce_get_breadcrumb', 'custom_breadcrumb', 10, 2 );
function custom_breadcrumb( $crumbs, $object_class ){
	global $language;
    // Loop through all $crumb
    if($language == 'en'){
      foreach( $crumbs as $key => $crumb ){
        foreach( $crumbs as $key => $crumb ){
          $taxonomy = 'product_cat'; // The product category taxonomy
  
          // Check if it is a product category term
          $term_array = term_exists( $crumb[0], $taxonomy );
  
          // if it is a product category term
          if ( $term_array !== 0 && $term_array !== null ) {
  
              // Get the WP_Term instance object
              $term = get_term( $term_array['term_id'], $taxonomy );
            $link = get_term_link( $term->slug, $term->taxonomy );
            $crumbs[$key][1] = $link . '?lang=en'; // or use all other dedicated functions
  
          }
      }
      }
    }else{
      foreach( $crumbs as $key => $crumb ){
        $taxonomy = 'product_cat'; // The product category taxonomy

        // Check if it is a product category term
        $term_array = term_exists( $crumb[0], $taxonomy );

        // if it is a product category term
        if ( $term_array !== 0 && $term_array !== null ) {

            // Get the WP_Term instance object
            $term = get_term( $term_array['term_id'], $taxonomy );
          $ar_title_field = get_field('attribute_in_arabic','term_' . $term->term_id);
          $link = get_term_link( $term->slug, $term->taxonomy );
          // var_dump($term);
          // HERE set your new link with a custom one
          $crumbs[$key][1] = $link; // or use all other dedicated functions
          if($ar_title_field)
          $crumbs[$key][0] = $ar_title_field; // or use all other dedicated functions

        }
    }
    }
   

    return $crumbs;
}