<?php
$wishlist_remove= '';
$theme_settings = mitch_theme_settings();
if(!empty($theme_settings['theme_abs_url'])){
	require_once $theme_settings['theme_abs_url'].'languages/'.$theme_settings['current_lang'].'.php';
}
function mitch_get_number_name($number){
  $numbers_names_list = array('zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten');
  return $numbers_names_list[$number];
}

function mitch_theme_settings(){
  $currency_symbol = get_woocommerce_currency(); //_symbol
  // if($currency_symbol == 'ر.ق'){
  //   $currency_symbol = 'QAR';
  // } 
  if(isset($_GET['lang']) ){
    $language = 'en'; 
  }else {
      $language = 'ar'; 
  }

  $theme_abs_url = '';
  $my_theme      = wp_get_theme();
  if(!empty($my_theme)){
	$theme_name = $my_theme->get('TextDomain');
	if(!empty($theme_name)){
		$theme_abs_url = preg_replace('/wp-content.*$/','',__DIR__).'wp-content/themes/'.$theme_name.'/';
	}
  }
  return array(
    'site_url'                => site_url(),
    'theme_url'               => get_template_directory_uri(),
    'theme_abs_url'           => $theme_abs_url,
    'logo_black'              => get_field('logo', 'options'),
    'logo_black_en'           => get_field('logo_black_en', 'options'),
	  'logo_white'              => get_field('logo_white', 'options'),
    'logo_white_en'              => get_field('logo_white_en', 'options'),
    'theme_favicon'           => get_field('fav_icon', 'options'),
    'theme_favicon_black'     => get_field('fav_icon_black', 'options'),
    'current_lang'            => $language,
    'curren_currency_ar'      => "جنيه",
    'curren_currency_en'      => "EGP",
    'default_country_code'    => 'EG',
    'default_country_name'    => 'Egypt',
    'default_shipping_method' => 'filters_by_cities_shipping_method',
  );
}
function mitch_test_vars($vars){
  echo '<h2 style="direction:ltr;background: #222;color: #fff;border: 2px solid #fff;padding: 5px;margin: 5px;">Data Debug:</h2>';
  if(is_array($vars)){
    foreach($vars as $var){
      echo '<pre style="direction:ltr;background: #222;color: #fff;border: 2px solid #fff;padding: 5px;margin: 5px;">';
      var_dump($var);
      echo '</pre>';
    }
  }else{
    echo '<pre style="direction:ltr;background: #222;color: #fff;border: 2px solid #fff;padding: 5px;margin: 5px;">';
    var_dump($vars);
    echo '</pre>';
  }
}

function mitch_get_active_page_class($page_name){
  if($page_name == basename(get_permalink())){
    return 'active';
  }
}

function mitch_validate_logged_in(){
  if(!is_user_logged_in()){
    wp_redirect(home_url());
    exit;
  }
}
add_action('wp_ajax_nopriv_custom_search', 'custom_search');
add_action('wp_ajax_custom_search', 'custom_search');
function custom_search(){

	$s = $_POST['s'];
  $language = $_POST['lang'];

	
  global $theme_settings;
  $new_prods1 = Search_By_Product_Name($s , '10');
  // print_r($new_prods1);
	if($new_prods1->have_posts()):
		while ($new_prods1->have_posts()) :
      $language = $_POST['lang'];
			$new_prods1->the_post();
            $product_id = get_the_ID();
			if(!empty($product_id)){
          global $product_data;
          $product_data = mitch_get_short_product_data($product_id);
		include get_template_directory().'/theme-parts/product-widget.php';
          ?>
          <!-- <li id="product_<?php echo $product_id;?>_block" class="product_widget">
              <a href="<?php echo get_the_permalink($product_id);?>" class="product_widget_box">
                <div class="img">
                    <img src="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'single-post-thumbnail')[0];?>" alt="">
                </div>
                <div class="text">
                  <div class="sec_info">
                      <h3 class="title"><?php echo get_the_title($product_id);?></h3>
                      <p class="price"><?php echo get_post_meta($product_id, '_price', true);?> <?php echo $theme_settings['curren_currency_ar'];?></p>
                  </div>
                </div>
              </a>
          </li> -->
          <?php
			}
		endwhile; wp_reset_postdata();
	else:?>
    <sec class="emty_filter">
		 <p > <?php echo ($language=="en")? 'No results found' : 'لا توجد منتجات' ; ?></p>
    </sec>
	<?php endif;
wp_die();
}

add_action('wp_ajax_nopriv_mitch_get_insta_content', 'mitch_get_insta_content');
add_action('wp_ajax_mitch_get_insta_content', 'mitch_get_insta_content');
function mitch_get_insta_content(){
  global $theme_settings;
  $item_id = intval($_POST['insta_item']);
  $instagram_section_details = get_field('instagram_section_details', 'options');
  if(!empty($instagram_section_details['instagram_items'])){
    $count = 1;
    foreach($instagram_section_details['instagram_items'] as $instagram_item){
      if($count == $item_id){
        ?>
        <div class="insta-popup-content">
			<div class="content">
				<div class="hero_img">
					<img src="<?php echo $instagram_item['in_image'];?>">
				</div>
				<div class="sec_gallary">
					<div class="title">
						<h4>InstaShop</h4>
						<p>In This Look</p>
					</div>
					<div class="insta_products_items">
						<?php
							if(!empty($instagram_item['products'])){
							foreach($instagram_item['products'] as $product_id){
						?>
							<div class="product_item">
								<img src="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'single-post-thumbnail')[0];?>">
								<h4><?php echo get_the_title($product_id);?></h4>
								<h5><?php echo get_post_meta($product_id, '_price', true).' '.$theme_settings['curren_currency_ar'];?></h5>
								<!-- <button onclick="simple_product_add_to_cart(<?php //echo $product_id;?>)">Add To Cart</button> -->
							</div>
						<?php } } ?>
					</div>
					<div class="text">
						<p><?php echo $instagram_item['content'];?></p>
						<a href="<?php echo $instagram_item['url'];?>">
							<ul>
								<li>
									<?php echo $instagram_item['url_text'];?>
								</li>
								<li>Instagram </li>
								<li>
									<?php echo $instagram_item['date'];?>
								</li>
							</ul>
						</a>

					</div>
				</div>
			</div>
        </div>
        <?php
      }
      $count++;
    }
  }
  wp_die();
}

function mitch_campaign_monitor_add_subscriber_birthday($user_name, $user_email, $user_birthday){
  $auth        = array('api_key' => 'dYEwki21Oyod/9c+JqTlzMkTSf8HUytCMOjsjor9PS9NTY2M4FTItmYuGwQY5O30C32xxPFxj1YDjIeNIQwGteF9qlS1kmouXtZshOkC7QXsH/R9CiXxLwxVPusuFHOnmsPtqaKl3eTEyhDOMjuemg==');
  $api_list_id = 'fb97192bdb8805924e5ba885116e02e5';
  $create_subscriber_class = new CS_REST_Subscribers($api_list_id, $auth);
  $subscriber_data         = array(
    'EmailAddress' => $user_email,
    'Name'         => $user_name,
    'CustomFields' => array(
      array(
        'Key'   => 'BirthDay',
        'Value' => $user_birthday,
        'Clear' => false,
      )
    ),
    'ConsentToTrack' => 'yes'
  );
  $create_subscriber_opt   = $create_subscriber_class->add($subscriber_data);
  if(isset($create_subscriber_opt->http_status_code)){
    $code = $create_subscriber_opt->http_status_code;
  }elseif(isset($create_subscriber_opt->Code)){
    $code = $create_subscriber_opt->Code;
  }else{
    $code = 401;
  }
  return $code;
}

function mitch_campaign_monitor_add_subscriber($user_email){
  $auth                    = array('api_key' => 'dYEwki21Oyod/9c+JqTlzMkTSf8HUytCMOjsjor9PS9NTY2M4FTItmYuGwQY5O30C32xxPFxj1YDjIeNIQwGteF9qlS1kmouXtZshOkC7QXsH/R9CiXxLwxVPusuFHOnmsPtqaKl3eTEyhDOMjuemg==');
  $api_list_id             = '416b1b45ffee033fe21875d057c7f364';
  $create_subscriber_class = new CS_REST_Subscribers($api_list_id, $auth);
  $subscriber_data         = array(
    'EmailAddress' => $user_email,
    //'Name'         => $user_name,
    'ConsentToTrack' => 'yes'
  );
  $create_subscriber_opt   = $create_subscriber_class->add($subscriber_data);
  if(isset($create_subscriber_opt->http_status_code)){
    $code = $create_subscriber_opt->http_status_code;
  }elseif(isset($create_subscriber_opt->Code)){
    $code = $create_subscriber_opt->Code;
  }else{
    $code = 401;
  }
  return $code;
}


