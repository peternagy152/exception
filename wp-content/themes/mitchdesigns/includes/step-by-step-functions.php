<?php 

// Database Fucntions 
function get_all_shapes(){
    global $wpdb;
    $shapes = $wpdb->get_results("SELECT DISTINCT shape_en, shape_ar,shape_slug FROM sbs_base");
    return $shapes;
}

function get_all_sizes($shape){
    global $wpdb;
    $sizes = $wpdb->get_results("SELECT DISTINCT size FROM sbs_base where shape_slug = '{$shape}'");
    return $sizes;
}

function get_all_heights($shape , $size){
    global $wpdb;
    $heights = $wpdb->get_results("SELECT  height , price FROM sbs_base where shape_slug = '{$shape}' and size = '{$size}' ");
    return $heights;
}
function get_all_sponge_cake_heights($shape , $size){
    global $wpdb;
    $heights = $wpdb->get_results("SELECT  height , price FROM sbs_sponge_base where shape_slug = '{$shape}' and size = '{$size}' ");
    return $heights;
}



function get_all_flavors(){
    global $wpdb;
    $flavors = $wpdb->get_results("SELECT DISTINCT flavor_en, flavor_ar, flavor_slug FROM sbs_flavors");
    return $flavors;

}

function get_all_fillings($flavor){
    global $wpdb;
    $fillings = $wpdb->get_results("SELECT  * FROM sbs_flavors where flavor_slug = '{$flavor}'  ");
    return $fillings;
}

function get_all_colors(){
    global $wpdb;
    $colors = $wpdb->get_results("SELECT  * FROM sbs_colors ");
    return $colors; 
    
}

function get_all_topings($shape , $size){
    global $wpdb;
    $topings = $wpdb->get_results("SELECT  type_en , type_ar , type_slug , price FROM sbs_topings where shape_slug = '{$shape}' and size = '{$size}' ");
    return $topings;
}

function get_all_shapes3d(){
    global $wpdb;
    $shapes3d = $wpdb->get_results("SELECT  * FROM sbs_shapes3d ");
    return $shapes3d;
}

function get_shape_by_slug($shape_slug){
    global $wpdb;
    $topings = $wpdb->get_results("SELECT  * FROM sbs_shapes3d where shape3d_slug = '{$shape_slug}'  ");
    return $topings;
}

function get_writing_base($shape_slug , $size){
    global $wpdb;
    $topings = $wpdb->get_row("SELECT  * FROM sbs_large_base where shape_slug = '{$shape_slug}' and size = '{$size}' ");
    return $topings;
}

function get_shape_value($shape_slug){
    global $wpdb;
    $topings = $wpdb->get_row("SELECT  * FROM sbs_base where shape_slug = '{$shape_slug}' ");
    return $topings;

}

function get_size_value($size){
    global $wpdb;
    $topings = $wpdb->get_row("SELECT  * FROM sbs_large_base where size = '{$size}' ");
    return $topings;

}

function get_flavor_value($flavor_slug){
    global $wpdb;
    $topings = $wpdb->get_row("SELECT  * FROM sbs_flavors where flavor_slug = '{$flavor_slug}' ");
    return $topings;

}
function get_filling_value($flavor_slug , $filling_slug ){
    global $wpdb;
    $topings = $wpdb->get_row("SELECT  * FROM sbs_flavors where flavor_slug = '{$flavor_slug}' and  filling_slug = '{$filling_slug}' ");
    return $topings;

}

function get_color_value($color_slug ){
    global $wpdb;
    $topings = $wpdb->get_row("SELECT  * FROM sbs_colors where color_slug = '{$color_slug}' ");
    return $topings;

}

function get_toping_value($toping_slug){
    global $wpdb;
    $topings = $wpdb->get_row("SELECT  * FROM sbs_topings where type_slug = '{$toping_slug}' ");
    return $topings;

}


// Getting Default Values 
function get_default_sizes(){
   $shapes =  get_all_shapes(); 
   $sizes = get_all_sizes($shapes[0]->shape_slug);
   return $sizes;
}



add_action('wp_ajax_sbs_change_shape', 'sbs_change_shape');
add_action('wp_ajax_nopriv_sbs_change_shape', 'sbs_change_shape');
function sbs_change_shape(){
    $selected_shape = $_POST['selected_shape'];
    $language = $_POST['lang'];

    //Class size_height_option 
    $sizes = get_all_sizes($selected_shape);
    ob_start();
    ?>
<option value="false" disabled selected>
	<?php if($language == 'en'){echo 'Select Shape' ; }else{echo 'اختر المقاس' ;} ?></option>

<?php foreach($sizes as $one_size){ ?>
<?php $enough_for =  get_writing_base($selected_shape , $one_size->size) ;  ?>
<?php //var_dump($enough_for); ?>
<option value="<?php echo $one_size->size?>">
	<?php if($language == 'en'){ echo $one_size->size . ' Enough for ' . $enough_for->number . ' person ' ; } else {echo $one_size->size . ' تكفي حتي ' . $enough_for->number . ' فرد' ;} ?>
</option>
<?php } ?>
<?php 
      $options = ob_get_clean();
    $response = array(
        'status' => 'success',
        'size' => $options ,
      );
      echo json_encode($response);
     wp_die();
}

add_action('wp_ajax_sbs_change_size', 'sbs_change_size');
add_action('wp_ajax_nopriv_sbs_change_size', 'sbs_change_size');
function sbs_change_size(){
    //Changing Heights 


    $selected_shape = $_POST['selected_shape'];
    $selected_size = $_POST['selected_size'] ;
    $language = $_POST['lang'] ;
    $cake_type = $_POST['selected_cake_type'] ; 

    if($cake_type == 'suger-cake'){
        $heights = get_all_heights($selected_shape , $selected_size);
    }else{
        $heights = get_all_sponge_cake_heights($selected_shape , $selected_size);
    }

    //Class size_height_option 
    ob_start();
    ?>
<option value="false" disabled selected>
	<?php if($language == 'en'){echo 'Choose Height' ; }else{echo 'اختر الارتفاع' ;} ?></option>
<?php foreach($heights as $one_height){ ?>
<option value="<?php echo $one_height->height ?>" data-price="<?php echo $one_height->price ?>">
	<?php echo $one_height->height ?> </option>
<?php }  ?>
<?php 
      $options = ob_get_clean();

    //Changing Topings in Step 5 
    $topings = get_all_topings($selected_shape , $selected_size);
    ob_start();
    ?>
<option value="false" disabled selected> <?php if($language == 'en'){echo 'Choose Topping' ; }else{echo 'اختر ' ;} ?>
</option>
<?php $type_name = 'type_' . $language; ?>
<?php foreach($topings as $one_topic){ ?>
<option value="<?php echo $one_topic->type_slug ?>" data-price="<?php echo $one_topic->price ?>">
	<?php echo $one_topic->$type_name ?> </option>
<?php } 
    $topings = ob_get_clean();

    //Chaning Base Price in Step 6 
    $base = get_writing_base($selected_shape , $selected_size);

    
    $response = array(
        'status' => 'success',
        'height' => $options ,
        'top'   => $topings ,
        'base'  => $base -> large_base_price ,
      );
      echo json_encode($response);
     wp_die();
}

// Load The Filling Based On Flavor Option
add_action('wp_ajax_nopriv_sbs_change_flavor', 'sbs_change_flavor');
add_action('wp_ajax_sbs_change_flavor', 'sbs_change_flavor');
function sbs_change_flavor(){
    $selected_flavor =  $_POST['selected_flavor']; 
    $fillings = get_all_fillings($selected_flavor);
    $language  = $_POST['lang'] ;
    ob_start();
    ?>
<?php $first_option = true ; ?>
<?php $filling_name = 'filling_'. $language ; ?>
<?php foreach($fillings as $one_filling){ ?>
<div class="s_option <?php // if($first_option){echo 'active' ;} ?> ">
	<div class="option">
		<input data-price="<?php echo $one_filling->price ;?>" value="<?php echo $one_filling->filling_slug ;?>"
			type="radio" name="filling_options" <?php if($first_option){echo 'checked' ; $first_option =false;} ?>>
		<label for="filling_options"> <?php echo $one_filling->$filling_name ;?></label>
	</div>
</div>
<?php } ?>
<?php 
    $options = ob_get_clean();

    $response = array(
        'status' => 'success',
        'filling' => $options ,
      );
      echo json_encode($response);
     wp_die();


}


add_action('wp_ajax_nopriv_sbs_add_3dshape', 'sbs_add_3dshape');
add_action('wp_ajax_sbs_add_3dshape', 'sbs_add_3dshape');
function sbs_add_3dshape(){
    $activeSlugs = $_POST['activeSlugs'];
    $language = $_POST['lang'];
    //var_dump($activeSlugs);
    ob_start();
    ?>
<?php foreach($activeSlugs as $one_slug){ ?>
<?php $one_shape3d = get_shape_by_slug($one_slug) ?>
<div class="outside min_widget " data-slug="<?php echo $one_shape3d[0]->shape3d_slug ?>"
	data-price="<?php echo $one_shape3d[0]->price  ?>">
	<div class="widget_img">
		<img src="<?php echo  $one_shape3d[0]->image_url ;?>" alt="">
		<div class="border_done">
			<i class="material-icons">done</i>
		</div>
	</div>
	<div class="widget_title">
		<?php $shape3d_name = "shape3d_" . $language ; ?>
		<h4> <?php echo $one_shape3d[0]->$shape3d_name ?></h4>
		<p><?php echo $one_shape3d[0]->price ?> <?php if($language == 'en'){echo '+ EGP';}else{echo 'ج م+';} ?></p>
	</div>
	<div class="remoe">
		<button>
			<i class="material-icons unselect_icon">close</i>
		</button>
	</div>

</div>

<?php }  ?>
<?php 
       $options = ob_get_clean();

       $response = array(
           'status' => 'success',
           'shapes3d' => $options ,
         );
     echo json_encode($response);
        wp_die();


}

//Get Review Data 


add_action('wp_ajax_nopriv_sbs_cake_review', 'sbs_cake_review');
add_action('wp_ajax_sbs_cake_review', 'sbs_cake_review');
function sbs_cake_review(){
    $shape = $_POST['shape'];
    $size = $_POST['size']; 
    $height = $_POST['height'];
    $flavor = $_POST['flavor']; 
    $filling = $_POST['filling']; 
    $color = $_POST['color'];  
    $toping = $_POST['toping']; 
    $shapes = $_POST['shapes'] ;
    $language = $_POST['lang']; 

    $shape_name = get_shape_value($shape);
    $size_name = get_size_value($size);
    $flavor_name = get_flavor_value($flavor);
    $filling_name = get_filling_value($flavor , $filling);

    $color_name = "" ;
    if(!empty($color)){
        $color_name = get_color_value($color);
    }
    $toping_name = "";

    if(!empty($toping)){
        $toping_name = get_toping_value($toping);
    }
   
    $flavor_lang = "flavor_" . $language ;
    $filling_lang = "filling_" . $language ;
    $shape_lang = "shape_" . $language ;
    $flavor_lang = "flavor_" . $language ;
    $color_lang = "color_" . $language ;
    $type_lang = "type_" . $language ;

    $shapes_string = '' ; 
    // var_dump($shapes);
    // exit; 
        foreach($shapes[0] as $one_shape){
            $shape_value = get_shape_by_slug($one_shape); 
            if($language == 'en'){
               $shapes_string .= '-' . $shape_value[0]->shape3d_en ; 
            }else{
                 $shapes_string .= '-' . $shape_value[0]->shape3d_ar ; 
            }
         
        }


 $response = array(
           'status' => 'success', 
           'shape' => $shape_name ->  $shape_lang , 
           'size'   => $size_name -> number ,
           'flavor' => $flavor_name ->  $flavor_lang  ,
           'filling' => $filling_name ->  $filling_lang , 
           'color' => $color_name -> $color_lang  ,
           'toping' => $toping_name ->  $type_lang, 
           'shapes_final' => $shapes_string , 
         );
     echo json_encode($response);
        wp_die();


}


// Add Custom Cake To Cart 
add_action('wp_ajax_nopriv_sbs_add_to_cart', 'sbs_add_to_cart');
add_action('wp_ajax_sbs_add_to_cart', 'sbs_add_to_cart');
function sbs_add_to_cart(){
    global $theme_settings ;
    $shape = $_POST['shape'];
    $size = $_POST['size']; 
    $height = $_POST['height'];
    $flavor = $_POST['flavor']; 
    $filling = $_POST['filling']; 
    $color = $_POST['color'];  
    $toping = $_POST['toping']; 
    $shapes3d = $_POST['shapes3d'] ; 

    $text_on_cake = $_POST['text_on_cake'];
    $text_on_base = $_POST['text_on_base'];
    $notes_on_order = $_POST['notes_on_order'];
    $delivery_date = $_POST['delivery_date'];
    $delivery_time = $_POST['delivery_time'];

    $price = $_POST['price'] ; 

    $shape_name = get_shape_value($shape);
    $size_name = get_size_value($size);
    $flavor_name = get_flavor_value($flavor);
    $filling_name = get_filling_value($flavor , $filling);

    $color_name = "" ;
    if(!empty($color)){
        $color_name = get_color_value($color);
    }
    $toping_name = "";

    if(!empty($toping)){
        $toping_name = get_toping_value($toping);
    }


    $added_to_cart   = WC()->cart->add_to_cart(3065, 1 , 0, array(
        'shape' =>  $shape_name -> shape_ar  , 
        'size' => $size , 
        'height' => $height , 
        'flavor' => $flavor_name -> flavor_ar , 
        'filling' => $filling_name -> filling_ar , 
        'color' => $color_name -> color_ar , 
        'toping' => $toping_name -> type_ar ,
        'shapes3d' => $shapes3d , 
        'text_on_cake' => $text_on_cake , 
        'text_on_base' => $text_on_base , 
        'notes_on_order' => $notes_on_order , 
        'delivery_date' =>  $delivery_date ,
        'delivery_time' => $delivery_time ,

        'price' => $price ,
    ));
    if($_POST['lang'] == en){
        $redirect_link = $theme_settings['site_url'] . '/cart?lang=en' ;
    }else{
         $redirect_link = $theme_settings['site_url'] . '/cart' ;
    }

    $response = array(
        'status' => 'success' , 
        'redirect' => $redirect_link ,
    );

    echo json_encode($response);
        wp_die();
}