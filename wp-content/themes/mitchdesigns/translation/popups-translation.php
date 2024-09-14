<?php 
function popup_translate($phrase , $language){
    static $popups = array(
        'branch_popup_title_en'   => 'Choose Branch',               'branch_popup_title_ar'   => 'اختر الفرع',
        'gover_en'                =>'City',                         'gover_ar'                =>'المدينة',
        'area_en'                 =>'Area',                         'area_ar'                 =>'الحي',
        'street_en'               =>'District',                     'street_ar'               =>' المنطقة',
        'dropdown_default_en'     =>'Choose Area',                  'dropdown_default_ar'     =>'اختر حي',
        'dropdown_default2_en'    =>'Choose District',              'dropdown_default2_ar'     =>'اختر المنطقة',

    ); 
    return $popups[$phrase . '_' . $language] ;

  }