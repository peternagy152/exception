<?php 


add_action('wp_ajax_MD_get_areas_related_gover', 'MD_get_areas_related_gover');
add_action('wp_ajax_nopriv_MD_get_areas_related_gover', 'MD_get_areas_related_gover');
function MD_get_areas_related_gover(){

 $gover_en = $_POST['gover_en']; 
 $language = $_POST['lang'];

 $start = '<select name="area" id="area">' ;
 $middle = '';
 $end = ' </select>' ;
 $areas = MD_Get_area($gover_en);
 $area_name = "area_name_". $language ;
 if($language == 'en'){$default_area = "Choose Area" ; }else {$default_area = " اختر الحي" ;}
 if($language == 'en'){$default_street = "Choose District" ; }else {$default_street = "اختر المنطقة" ;}
 $middle = $middle . '<option   >'. $default_area.' </option>'; 
 foreach($areas as $one_area){ 
        $middle = $middle . '<option value = " ' . $one_area->area_id . '" >' . $one_area->$area_name . '</option>'; 
 }

 // Set Street 
 $empty_street = '<option   >'. $default_street.'</option>'; 

 $response = array(
     'status' => 'success',
     'areas_dropdown'    => $middle ,
     'street'            =>$empty_street,
   );
   echo json_encode($response);
  wp_die();

}

add_action('wp_ajax_MD_Get_street_related_area', 'MD_Get_street_related_area');
add_action('wp_ajax_nopriv_MD_Get_street_related_area', 'MD_Get_street_related_area');
function MD_Get_street_related_area(){
    
 $selected_area = $_POST['selected_area'];
 $language = $_POST['lang'];

 $start = '<select name="street" id="street">' ;
 $middle = '';
 $end = ' </select>' ;
 if($language == 'en'){$default_street = "Choose District" ; }else {$default_street = "اختر المنطقة" ;}
 $streets = MD_Get_street($selected_area);
 $street_name = 'street_name_' . $language;
  $middle = $middle . '<option value = "false" > '. $default_street .' </option>'; 
 foreach($streets as $one_street){ 
        $middle = $middle . '<option value = " ' . $one_street->street_id . '" >' . $one_street->$street_name . '</option>'; 
 }


 $response = array(
     'status' => 'success',
     'street'    => $middle ,
   );
   echo json_encode($response);
  wp_die();

}

add_action('wp_ajax_MD_Get_matched_branch', 'MD_Get_matched_branch');
add_action('wp_ajax_nopriv_MD_Get_matched_branch', 'MD_Get_matched_branch');
function MD_Get_matched_branch(){
    $area = $_POST['area'];
    $street = $_POST['street'];

    $matched_branch = MD_Get_branch_by_street($street);
    $area_info = MD_Get_area_by_area_id($area);
    $response = array(
        'status' => 'success',
        'area_en'    => $area_info->area_name_en,
        'area_ar'    => $area_info->area_name_ar,
        'branch_en'  => $matched_branch->branch_name_en,
        'branch_ar'  => $matched_branch->branch_name_ar,
        'branch_id'  => $matched_branch->branch_id,

      );
      echo json_encode($response);
     wp_die();
   
   }
   

   
add_action('wp_ajax_nopriv_get_city', 'get_city');
add_action('wp_ajax_get_city', 'get_city');
function get_city(){
	global  $theme_settings ;
	//$state    = $_POST['state'];
	$language     = $_POST['lang'];
    $selected_gov = $_POST['selected_gov'];
    $area_object = MD_Get_area($selected_gov , $language );
	$selected = '';
	$area   = ($language == "en")?  'Choose Area' : 'اختر الحي' ;
	$label  = ($language == "en")?  'Area':'الحي' ;
	$start  = '<label for="billing_street" class="">'. $label .' <abbr class="required" title="مطلوب">*</abbr></label><select name="billing_street" id="billing_street" class="city_select select2" autocomplete="address-level2" placeholder="" tabindex="-1" aria-hidden="true"><option value="">'.$area.'</option>';
	$end    = '</select>';
	if($area_object){
		echo $start;
		foreach($area_object as $one_area){
            //var_dump($one_area->area_id);
					  ?>
                          <option data-id = "<?php echo $one_area->area_id ?>"value="<?php echo $one_area->area_name_ar ?>"> <?php if($language =='en'){ echo $one_area->area_name_en ;}else{ echo $one_area->area_name_ar ; }?></option>
						  <?php
				
		
		  }
		echo $end;
	}else{
		echo '<label for="billing_street" class="">'. $label .'<abbr class="required" title="مطلوب">*</abbr></label>
		<input type="text" class="input-text area-text " placeholder="" name="billing_street" id="billing_street" autocomplete="address-level2">';
	}
	wp_die();
}


add_action('wp_ajax_nopriv_on_checkout_load_change_gov_field', 'on_checkout_load_change_gov_field');
add_action('wp_ajax_on_checkout_load_change_gov_field', 'on_checkout_load_change_gov_field');
function on_checkout_load_change_gov_field(){


    $language = $_POST['lang'];
    $all_govs = MD_get_all_data_govs(); 
    $gover_name = "gov_name_" . $language;
    $middle = ''; 
    foreach($all_govs as $one_gov){
        $middle = $middle . '<option data-id = "'.$one_gov->gov_id.'" value = "'.$one_gov->gov_name_ar .'" > '. $one_gov->$gover_name .' </option>';
    }
    $response = array(
        'status' => 'success',
        'gover_checkbox' => $middle ,
      );
      echo json_encode($response);
     wp_die();
}


add_action('wp_ajax_nopriv_get_street', 'get_street');
add_action('wp_ajax_get_street', 'get_street');
function get_street(){
	global  $theme_settings ;
	$language     = $_POST['lang'];
    $selected_area = $_POST['selected_area'];
    $area_object = MD_Get_street($selected_area , 'ar' );
	$selected = '';
	$area   = ($language == "en")?  'Choose District' : 'اختر المنطقة' ;
	$label  = ($language == "en")?  'District' : 'المنطقة';
	$start  = '<label for="billing_city" class="">'. $label .' <abbr class="required" title="مطلوب">*</abbr></label><select name="billing_city" id="billing_city" class="city_select select2" autocomplete="address-level2" placeholder="" tabindex="-1" aria-hidden="true"><option value="">'.$area.'</option>';
	$end    = '</select>';
	if($area_object){
		echo $start;
		foreach($area_object as $one_area){
            //var_dump($one_area->area_id);
					  ?>
                          <option data-id = "<?php echo $one_area->street_id ?>" value="<?php echo $one_area->street_name_ar ?>"> <?php if($language =='en'){ echo $one_area->street_name_en ;}else{ echo $one_area->street_name_ar ; }?></option>
						  <?php
				
		
		  }
		echo $end;
	}else{
		echo '<label for="billing_city" class="">'. $label .'<abbr class="required" title="مطلوب">*</abbr></label>
		<input type="text" class="input-text area-text " placeholder="" name="billing_city" id="billing_city" autocomplete="address-level2">';
	}
	wp_die();
}


//Shipping Fees 
function Shipping_fees( $rates, $package ) {
  //var_dump("Peter");
	
	$applied_coupons = WC()->cart->get_applied_coupons();
	$coupon_with_free_shipping = false ;
	foreach( $applied_coupons as $coupon_code ){

		$coupon = new WC_Coupon($coupon_code);
	
		if($coupon->get_free_shipping()){
			$coupon_with_free_shipping =true ;
			foreach ( $rates as $rate_id => $rate ) {
					$cost = $rate->get_cost();
					// New rate cost
					$rate->set_cost( $cost - ( $cost * 100 ) / 100 );
					}
		}
	
	  }
    
    //Free Shipping Over 300 
    $enable_free_shipping = get_field('enable_free_shipping', 'options');
    if($enable_free_shipping){
      $limit =  get_field('subtotal_limit', 'options');
      if(WC()->cart->subtotal >= $limit){
        foreach ( $rates as $rate_id => $rate ) {
          $rate->set_cost( 0 );
          }
          return $rates;
      }
    }

    

	  if(!$coupon_with_free_shipping){
      //var_dump(WC()->customer->get_shipping_option());
	  
        $street = WC()->customer->get_billing_city(); 

        // Get Street Rate 
        $current_rate = 0 ;
        
        if(!empty($street)){
            $street_object = MD_Get_street_rate_by_name_ar($street);
            if($street_object){
                $current_rate =  $street_object->street_rate;
            }
           
        }
        

        foreach ( $rates as $rate_id => $rate ) {
            $rate->set_cost($current_rate);

            }

	
	
        }
      return $rates;
    }
    add_filter( 'woocommerce_package_rates', 'Shipping_fees', 1, 2 );

    // ------------------------------ Adding Branches in Product Page ----------------------
    
   function add_branches_meta_box() {
    add_meta_box(
      'branches_meta_box',
      'Branches',
      'display_branches_meta_box',
      'product',
      'side',
      'default'
    );
  }
  
  function display_branches_meta_box($post) {
    // Retrieve the current value of the branches meta field
    $branches = get_post_meta($post->ID, '_branches', true);
    global $wpdb ;
    // Query the branches table to retrieve a list of branches
    $branches_list = $wpdb->get_results("SELECT * FROM pwa_branches");
    
    // Display the checkboxes for the branches
    foreach ($branches_list as $branch) {
        if(!empty($branches)){
            $checked = in_array($branch->branch_id, $branches) ? 'checked' : '';
        }else{
            $checked ='';
        }
     
      echo '<label>';
      echo '<input type="checkbox" name="branches[]" value="' . $branch->branch_id . '" ' . $checked . '> ';
      echo $branch->branch_name_ar;
      echo '</label><br>';
    }
  }
  
  add_action('add_meta_boxes_product', 'add_branches_meta_box');

  function save_branches_meta_box($post_id) {
    // Check if the current user can edit the post
    if (!current_user_can('edit_post', $post_id)) {
      return;
    }
    
    // Save the selected branches to the product meta
    if (isset($_POST['branches'])) {
      update_post_meta($post_id, '_branches', $_POST['branches']);
    } else {
      delete_post_meta($post_id, '_branches');
    }
  }
  
  add_action('save_post_product', 'save_branches_meta_box');


