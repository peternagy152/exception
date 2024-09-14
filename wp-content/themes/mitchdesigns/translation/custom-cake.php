<?php 
function customcake_translate($phrase , $language){
    static $c_cake = array(
        'menu_step_one_en'   => 'Choose Shape',              'menu_step_one_ar'   => 'اختر الشكل',
        'menu_step_two_en'   => 'Choose Size',               'menu_step_two_ar'   => 'اختر الحجم',
        'menu_step_three_en'   => 'Choose Flavour',          'menu_step_three_ar'   => 'اختر النكهة',
        'menu_step_four_en'   => 'Choose Filling',           'menu_step_four_ar'   => 'اختر الحشوة',
        'menu_step_five_en'   => 'Cake Decoration',          'menu_step_five_ar'   => 'تزيين الكيك',
        'menu_step_six_en'   => 'Words',                     'menu_step_six_ar'   => 'كلمات',
        'menu_step_seven_en'   => 'Review',                  'menu_step_seven_ar'   => 'المراجعة',
    ); 
    return $c_cake[$phrase . '_' . $language] ;

  }