<?php 
// Global Variable for Color Hex in pa-color Taxonomy 
function Call_GLobal_Variables_For_Cart() {

    $terms = get_terms([
    'taxonomy' => 'pa_color',
    'hide_empty' => false,
    ]); 

    global $color_hex_data ;
    $color_hex_data = array();
    $temp_color_name;
    foreach($terms as $one_color){

        $temp_color_name = str_replace(' ', '', $one_color->name);
        $temp_color_name = str_replace('-' , '' , $temp_color_name);
        $temp_color_name = strtolower($temp_color_name);

        $color_hex_data[$temp_color_name] = $one_color->term_id;
    }


}

function Call_Month_Global_Array(){
  global $month_array ;
  $month_array = array('January' ,'February' ,'March','April' ,'May','June','June','August','September','October','November','December');
}

?>