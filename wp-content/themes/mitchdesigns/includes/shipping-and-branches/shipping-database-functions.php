<?php 

function MD_get_all_data_govs(){

    global $wpdb;
    return $wpdb->get_results("SELECT * FROM pwa_shipping_gov " );
}

function MD_Get_area($gov_id){
global $wpdb ;
return $wpdb->get_results("SELECT * FROM pwa_shipping_area WHERE gov_id = {$gov_id}" );

}

function MD_Get_lang_govs($language){
global $wpdb;
if($language == 'en'){
  $name_object =  $wpdb->get_results("SELECT gov_name_en FROM pwa_shipping_gov " );
}else{
  $name_object =  $wpdb->get_results("SELECT gov_name_ar FROM pwa_shipping_gov" );
}

foreach ($name_object as $result) {
  if($language == 'en'){
      $govNames[] =   $result->gov_name_en;
  }else{
      $govNames[] =  $result->gov_name_ar;
  }

}

return $govNames;
}

function MD_Get_street($area_id){
global $wpdb ;
$street_object =  $wpdb->get_results("SELECT * FROM pwa_shipping_street WHERE area_id = {$area_id}"  );
return $street_object;

}

function MD_Get_street_rate_by_name_ar($street_name_ar) {
global $wpdb;
$street_object = $wpdb->get_row("SELECT * FROM pwa_shipping_street WHERE street_name_ar = '{$street_name_ar}'");
return $street_object;
}


function MD_Get_street_rate($street_id){
global $wpdb;
return  $wpdb->get_row("SELECT  street_rate FROM pwa_shipping_street WHERE street_id = {$street_id}"  );

}

function MD_Get_branch_by_street($street_id ){
// get branch id 
global $wpdb;
$street_info =  $wpdb->get_row("SELECT  *  FROM pwa_shipping_street WHERE street_id = {$street_id}"  );
$matched_branch =  $wpdb->get_row("SELECT  *  FROM pwa_branches WHERE branch_id = {$street_info->branch_id}"  );
return $matched_branch;
}

function MD_Get_area_by_area_id($area_id){
global $wpdb;
$area_info = $wpdb->get_row("SELECT * FROM pwa_shipping_area WHERE area_id = {$area_id}" );
return $area_info;

}

// Shipping Address Functions 
function get_gov_name_by_id($gov_id){
  global $wpdb;
  $gov_info = $wpdb->get_row("SELECT * FROM pwa_shipping_gov WHERE gov_id = {$gov_id}" );
  return $gov_info;

}

function get_street_name_by_id($street_id){
  global $wpdb;
  $street_info = $wpdb->get_row("SELECT * FROM pwa_shipping_street WHERE street_id = {$street_id}" );
  return $street_info;
}

function get_gov_by_name($gov_name_ar){
  global $wpdb;
  $gov_object = $wpdb->get_row("SELECT * FROM pwa_shipping_gov WHERE gov_name_ar = '{$gov_name_ar}'");
  return $gov_object;

}

function get_area_by_name($area_name_ar){
  global $wpdb;
  $area_object = $wpdb->get_row("SELECT * FROM pwa_shipping_area WHERE area_name_ar = '{$area_name_ar}'");
  return $area_object;

}

//Branch Data 
function get_branch_data_by_id($branch_id){
  global $wpdb;
  $gov_info = $wpdb->get_row("SELECT * FROM pwa_branches WHERE branch_id = {$branch_id}" );
  return $gov_info;

}
function get_all_branches(){
  global $wpdb ;
  return $wpdb->get_results("SELECT * FROM pwa_branches " );

}

//Area 
function gat_all_areas(){
   global $wpdb ;
  return $wpdb->get_results("SELECT * FROM pwa_shipping_area " );
}

function insert_area($data){
  global $wpdb ;
  $wpdb->insert(
      "pwa_shipping_area", 
      array(
        "area_name_en" => clear_text($data['area_name_en']) , 
        "area_name_ar" => clear_text($data['area_name_ar']) , 
        "gov_id"       => clear_text($data['gov_id']) ,
      )
    );
    
}
function update_area($data){
  global $wpdb ;
  $wpdb -> update(
      "pwa_shipping_area" , 
      array(
        "area_name_en" => clear_text($data['area_name_en']) , 
        "area_name_ar" => clear_text($data['area_name_ar']) , 
        "gov_id"       => clear_text($data['gov_id']) ,
      ) , 
      array("area_id" => $data['area_id']) 
  ); 
}

function remove_area($area_id){
  global $wpdb ; 
  $wpdb->delete( "pwa_shipping_street", array( 'area_id' => $area_id ) );
  $wpdb->delete( "pwa_shipping_area", array( 'area_id' => $area_id ) );
}
// Streets 
function insert_street($data){
  global $wpdb ;
  $wpdb->insert(
      "pwa_shipping_street", 
      array(
        "street_name_en" => clear_text($data['street_name_en']) , 
        "street_name_ar" => clear_text($data['street_name_ar']) , 
        "area_id"       => clear_text($data['area_id']) ,
        "branch_id"       => clear_text($data['branch_id']) ,
        "street_rate"       => clear_text($data['street_rate']) ,
      )
    );
    
}

function remove_street($street_id){
  global $wpdb ; 
  $wpdb->delete( "pwa_shipping_street", array( 'street_id' => $street_id ) );
}

function update_street($data){
  global $wpdb ;
  $wpdb -> update(
      "pwa_shipping_street" , 
      array(
        'street_name_en' => clear_text($data['street_name_en']) ,
        'street_name_ar' => clear_text($data['street_name_ar']) ,
        'area_id' => clear_text($data['area_id']) ,
        'branch_id' => clear_text($data['branch_id']) ,
        'street_rate' => clear_text($data['street_rate']) , 
      ) , 
      array("street_id" => clear_text($data['street_id'])) 
  ); 
}

// ------------------- Governments ---------------------------------- 
function insert_government($data){
  global $wpdb ;
  $wpdb->insert(
      "pwa_shipping_gov", 
      array(
        "gov_name_en" => clear_text($data['gov_name_en']) , 
        "gov_name_ar" => clear_text($data['gov_name_ar']) , 
      )
    );
    
}

function update_government($data){
   global $wpdb ;
  $wpdb -> update(
      "pwa_shipping_gov" , 
      array(
        "gov_name_en" => clear_text($data['gov_name_en']) , 
        "gov_name_ar" => clear_text($data['gov_name_ar']) , 
      ) , 
      array("gov_id" => $data['gov_id']) 
  ); 
}

function insert_branch($data){
    global $wpdb ;
    $wpdb->insert(
      "pwa_branches", 
      array(
        "branch_name_en" => clear_text($data['branch_name_en']) , 
        "branch_name_ar" => clear_text($data['branch_name_ar']) , 
        "address_en" => clear_text($data['address_en']) , 
        "address_ar" => clear_text($data['address_ar']) ,  
        "branch_username" => clear_text($data['branch_username']) , 
        "branch_password" => clear_text($data['branch_password']) , 
      )
    );
}
function remove_branch($branch_id){
  global $wpdb ; 
  $wpdb->delete( "pwa_shipping_street", array( 'branch_id' => $branch_id ) );
  $wpdb->delete( "pwa_branches", array( 'branch_id' => $branch_id ) );

}

function update_branch($data){
   global $wpdb ;
  $wpdb -> update(
      "pwa_branches" , 
      array(
      "branch_name_en" => clear_text($data['branch_name_en']) , 
        "branch_name_ar" => clear_text($data['branch_name_ar']) , 
        "address_en" => clear_text($data['address_en']) , 
        "address_ar" => clear_text($data['address_ar']) ,  
        "branch_username" => clear_text($data['branch_username']) , 
        "branch_password" => clear_text($data['branch_password']) , 
      ) , 
      array("branch_id" => $data['branch_id']) 
  ); 
}

function get_branch_by_username($username){
  global $wpdb ; 
  return $wpdb->get_row("SELECT * FROM pwa_branches where branch_username = '{$username}' ; "); 
  
}