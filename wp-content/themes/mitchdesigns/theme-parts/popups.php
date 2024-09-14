<?php //$popup_items = get_field('header_builder_en' , "options"); ?>
<?php global $language ; ?>

<?php
//Check if Coupon is Applie for Mini-Cart 
 
if(!empty(WC()->cart->applied_coupons)){
    $coupon_code    = WC()->cart->applied_coupons[0];
    $active         = 'active';
    $dis_form_style = 'display:block;';
    $dis_abtn_style = 'display:none;';
    $dis_rbtn_style = 'display:block;';
  }else{
    $coupon_code    = '';
    $active         = '';
    $dis_form_style = '';
    $dis_abtn_style = 'display:block;';
    $dis_rbtn_style = 'display:none;';
  }
?>

<div class="search-popup popup">

	<div class="details">
		<div class="top">
			<div class="search_info">
				<div class="title_search">

					<h2><?php echo search_translate('search_title' , $language); ?></h2>
				</div>
				<button type="button" class="popup__close material-icons js-popup-closer">close</button>
			</div>
		</div>
		<div class="loader_search" style="display: none;"></div>


		<div class="sec_search">
			<form method="get" id="searchForm" onsubmit="event.preventDefault(); navigateMyForm();" class="search-formm"
				action="<?php echo home_url( '/' ); ?>">
				<input type="search" onkeydown="return (event.keyCode!=13);" id="newSearch" class="new-search"
					placeholder="<?php echo search_translate('search_subtitle' , $language); ?>" autocomplete="off"
					value="<?php if(isset($_GET['search'])) echo $_GET['search'];?>" />
				<input type="submit" id="searchSubmit" onkeydown="return (event.keyCode!=13);"
					value="<?php echo esc_attr_x('Search', 'submit button') ?>" />
			</form>
		</div>
		<div class="search-result" id="searchResult">

			<div class="product_widget_box">
				<div class="img"></div>

				<div class="sec_info">
					<h3 class="title"></h3>
					<p class="price"></p>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="popup_menu" class="menu-popup popup">
	<?php $popup_content = get_field('main_nav_and_popup' , 'options') ?>
	<div class="grid">
		<div class="details">
			<span class="close"></span>

			<div class="top">
				<div class="all-menu">
					<?php $first_row_active = false ;?>
					<?php $count_has_mega = 0; ?>
					<?php  foreach($popup_content as $popup_items){ ?>
					<?php $count_has_mega++; ?>
					<?php if($popup_items['has_mega']){ ?>
					<div class="single-menu" id="pop_<?php echo $count_has_mega ; ?>">
						<a id="pop_<?php echo $count_has_mega ; ?>" href="#" class="open_menu_pop">
							<?php echo $popup_items['item_name']  ?> </a>
						<div
							class="<?php echo $popup_items['popup_group']['style_class']; ?> box <?php if($first_row_active == false){echo 'active'; $first_row_active = true;} ?> "
							id="pop_<?php echo $count_has_mega ; ?>">
							<ul>
								<?php foreach($popup_items['popup_group']['popup_items'] as $one_item) {  ?>
								<li>
									<a href="<?php echo $one_item['item_link'] ?>"> <?php echo $one_item['item_name'] ?></a>
								</li>
								<?php } ?>
							</ul>
						</div>
					</div>
					<?php } ?>
					<?php } ?>

				</div>
			</div>

			<div class="bottom">
				<ul>
					<?php $Bottom_header = get_field('header_builder_en' , 'options');  ?>
					<?php foreach($Bottom_header['buttom_group']['buttom_items'] as $buttom_item){ ?>
					<li>
						<a href="<?php echo $buttom_item['page_link']; ?>">
							<?php echo $buttom_item['page_title']; ?></a>
					</li>


					<?php } ?>

				</ul>
			</div>




		</div>
	</div>
</div>
<!-- <div id="popup-switch-language" class="popup switch_language">
    <div class="popup__window switch_language">
      <button type="button" class="popup__close material-icons js-popup-closer">close</button>
      <div class="form-content">
        <h3><img class="mitchdesigns_icon_page" src="<?php //echo $theme_settings['theme_favicon'];?>" alt="" width='50'>تغيير الاعدادات</h3>
        <form id="switch_language" method="post" action="#">
            <div class="field select_arrow">
                <label for="">اختار اللغة</label>
                <select name="language" id="language" disabled>
                    <option value="Arabic" selected>العربية</option>
                    <option value="English">English</option>
                </select>
            </div>
            <div class="field select_arrow">
                <label for="">اختار العملة</label>
                <select name="curren_currency_ar" id="curren_currency_ar">
                <?php
                // $website_currencies = get_field('website_currencies', 'options');
                // if(!empty($website_currencies)){
                //   foreach($website_currencies as $website_currency){
                //     if($website_currency['code'] == $theme_settings['curren_currency_ar']){
                //       $selected = 'selected';
                //     }else{
                //       $selected = '';
                //     }
                    //echo '<option value="'.$website_currency['code'].'" '.$selected.'>'.ucwords($website_currency['code']).'</option>';
                //   }
                // }
                ?>
                </select>
            </div>
          <button type="submit" value="">حفظ</button>
        </form>
      </div>
    </div>
</div> -->
<div id="popup-remove-order" class="popup remove_order">
	<div class="popup__window remove_order">
		<div class="form-content">
			<img src="" alt="" />
			<div class="box_text">
				<h3><?php echo $fixed_string['myaccount_page_orders_cancel_title'];?></h3>
				<p><?php echo $fixed_string['myaccount_page_orders_cancel_desc'];?></p>
				<a id="cancel_order_track_button" class="link_order_track"
					href=""><?php echo $fixed_string['myaccount_page_orders_cancel_track'];?></a>
				<div class="form_action">
					<a class="close_form popup__close js-popup-closer" href="">
						<?php echo $fixed_string['myaccount_page_orders_cancel_enjoy'];?>
					</a>
					<span><?php echo $fixed_string['myaccount_page_orders_cancel_or'];?></span>
					<a id="cancel_order_proceed_button" class="continue_form"
						href=""><?php echo $fixed_string['myaccount_page_orders_cancel_proc'];?></a>
				</div>
			</div>
		</div>
	</div>
</div>
<?php if(is_cart()){ ?>

<?php }else{ ?>
<div id="popup-min-cart" class="popup min_cart">
	<div class="popup__window min_cart">

		<div id="side_mini_cart_content" class="form-content">
			<div class="coupon_cart <?php //if(!empty(WC()->cart->applied_coupons)) { echo "applied" } ?>">
				<h4 class="open-coupon "> <?php echo cart_page('do_Promo' , $language) ;?></h4>
				<div class="discount-form" style="<?php echo $dis_form_style;?>">
					<button class="close-coupon"><i class="material-icons">close</i></button>
					<div class="coupon">
						<label for="coupon_code"> <?php echo cart_page('Promo' , $language) ;?></label>
						<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="<?php echo $coupon_code;?>"
							placeholder="<?php echo 'Code';?>" />
						<button style="<?php echo $dis_abtn_style;?>" id="apply_coupon" type="submit" class="button btn">
							<?php echo '';?>

						</button>
						<button style="<?php echo $dis_rbtn_style;?>" id="remove_coupon" type="submit"
							class="button btn remove_coupon_icon">
							<?php //echo 'Remove Coupon';?>
						</button>
						<input type="hidden" name="lang" id="lang" value="">
					</div>
					<div class="message-container">
						<p id="message-success" class="message success"><?php echo cart_page('success_promo' , $language) ;?></p>
						<p id="message-fail" class="message error "><?php echo cart_page('fail_promo' , $language) ;?> </p>
					</div>

				</div>
			</div>
			<div class="non-fixed">
				<?php echo mitch_get_cart_content($language); //@ includes/cart-functions.php ?>
			</div>

		</div>
	</div>
</div>
<?php } ?>

<div id="popup-repeat-order" class="popup repeat_order">
	<div class="popup__window repeat_order">
		<button type="button" class="popup__close material-icons js-popup-closer">close</button>
		<div class="form-content">
			<span class="material-icons">error_outline</span>
			<h4>There are other items already added to the shopping cart.</h4>
			<span class="min_border"></span>
			<form action="" method="post">
				<div id="existing_items" class='option'>
					<input type="radio" id="test" name="repeat_action" value="with_items" checked>
					<label for="test">Order this order with existing items</label>
				</div>
				<div class='option'>
					<input type="radio" id="test2" name="repeat_action" value="no_items">
					<label for="test2">I only ask for this
						<p>(The contents of the current shopping cart will be deleted)</p>
					</label>
				</div>
				<input type="hidden" name="action" value="repeat_order">
				<input type="hidden" name="order_id"
					value="<?php if(isset($order_obj) && is_object($order_obj)){echo $order_obj->get_id();}?>">
				<button type="submit">Confirm</button>
			</form>
		</div>
	</div>
</div>

<div id="popup-insta" class="popup insta">
	<div class="popup__window insta">
		<button type="button" class="popup__close material-icons js-popup-closer">close</button>
		<div class="insta-popup-content">

		</div>
	</div>
</div>

<div id="popup-Gift-Expert" class="popup Gift-Expert">
	<div class="popup__window Gift-Expert">
		<button type="button" class="popup__close material-icons js-popup-closer">close</button>
		<div class="image">
			<img src="" alt="">
		</div>
		<div class="form-content">
			<h3>
				<span>Need Help?</span>
				Ask Gift Expert
			</h3>
			<p>Please fill the below form and our gift expert helps you to find the best matching gifts for your beloved
				ones</p>
			<div id="register_form_alerts" class="ajax_alerts"></div>
			<form id="ask_gift_expert" action="<?php echo home_url('shop');?>" method="get">
				<div class="field full">
					<label for="">Gift For</label>
					<select name="product_cat" placeholder="Choose Option...">
						<!-- <option value="">choose option</option> -->
						<?php
                          $categories = get_terms(array(
                            'taxonomy'   => 'product_cat',
                            'hide_empty' => true
                          ));
                          if(!empty($categories)){
                            foreach($categories as $category){
                              echo '<option value="'.$category->slug.'">'.$category->name.'</option>';
                            }
                          }
                        ?>
					</select>
				</div>
				<div class="field full">
					<label for="">Occassion</label>
					<select name="occasion" placeholder="Choose Option...">
						<!-- <option value="" >choose option</option> -->
						<?php
                        $occasions = get_terms(array(
                          'taxonomy'   => 'occasions',
                          'hide_empty' => true
                        ));
                        if(!empty($occasions)){
                          foreach($occasions as $occasions){
                            echo '<option value="'.$occasions->slug.'">'.$occasions->name.'</option>';
                          }
                        }
                        ?>
					</select>
				</div>
				<div class="field full">
					<label for="">Their Interest</label>
					<select name="product_tag" placeholder="Choose Option...">
						<!-- <option value="">choose option</option> -->
						<?php
                          $tags = get_terms(array(
                            'taxonomy'   => 'product_tag',
                            'hide_empty' => true
                          ));
                          if(!empty($tags)){
                            foreach($tags as $tag){
                              echo '<option value="'.$tag->slug.'">'.$tag->name.'</option>';
                            }
                          }
                        ?>
					</select>
					</select>
				</div>
				<div class="field full">
					<label for="">Who Are You Gifting</label>
					<select name="forwho" placeholder="Choose Option...">
						<!-- <option value="">choose option</option> -->
						<?php
                          $forwho_list = get_terms(array(
                            'taxonomy'   => 'forwho',
                            'hide_empty' => true
                          ));
                          if(!empty($forwho_list)){
                            foreach($forwho_list as $forwho_row){
                              echo '<option value="'.$forwho_row->slug.'">'.$forwho_row->name.'</option>';
                            }
                          }
                        ?>
					</select>
				</div>
				<div class="field full">
					<label>Gender</label>
					<select name="gender" placeholder="Choose Option...">
						<!-- <option value="">choose option</option> -->
						<?php
                        //   $genders = get_terms(array(
                        //     'taxonomy'   => 'genders',
                        //     'hide_empty' => true
                        //   ));
                        //   if(!empty($genders)){
                        //     foreach($genders as $gender){
                        //       echo '<option value="'.$gender->slug.'">'.$gender->name.'</option>';
                        //     }
                        //   }
                        ?>
					</select>
				</div>
				<input type="hidden" name="filter" value="yes">
				<button type="submit" value="">
					<img src="" alt="">
					Search Gifts
				</button>
			</form>
		</div>
	</div>
</div>

<div id="size_guide_popup" class="popup size_guide diff">
	<div class="popup__window size_guide">
		<button type="button" class="popup__close material-icons js-popup-closer">close</button>
		<div class="section_size">
			<!-- <div class="section_img">
                <img id="single_img" class="image "
                    src="https://www.cloudhosta.com:92/wp-content/uploads/2022/08/New-Project-27.jpg" alt="">
            </div> -->
			<div class="section_size_detalis">
				<h3>Size Guide</h3>
				<div id="single_table_1" class="sec_table active">
					<table>
						<tbody>
							<tr>
								<th></th>
								<th>XS</th>
								<th>S</th>
								<th>M</th>
								<th>L</th>
								<th>XL</th>
								<th>XXL</th>
								<th>XXXL</th>
							</tr>
							<tr class="even">
								<td>Size</td>
								<td>34</td>
								<td>36</td>
								<td>38</td>
								<td>40</td>
								<td>42</td>
								<td>44</td>
								<td>46</td>
							</tr>
							<tr class="">
								<td>BUST</td>
								<td>70</td>
								<td>78</td>
								<td>86</td>
								<td>94</td>
								<td>102</td>
								<td>110</td>
								<td>118</td>
							</tr>
							<tr class="even">
								<td>WAIST</td>
								<td>58</td>
								<td>66</td>
								<td>74</td>
								<td>82</td>
								<td>90</td>
								<td>98</td>
								<td>106</td>
							</tr>
							<tr class="">
								<td>HIPS</td>
								<td>76</td>
								<td>84</td>
								<td>92</td>
								<td>100</td>
								<td>108</td>
								<td>116</td>
								<td>124</td>
							</tr>
							<tr class="even">
								<td>Bicep</td>
								<td>26</td>
								<td>28</td>
								<td>30</td>
								<td>32</td>
								<td>34</td>
								<td>36</td>
								<td>38</td>
							</tr>
							<tr class="">
								<td>Arm Length</td>
								<td>54</td>
								<td>56</td>
								<td>58</td>
								<td>60</td>
								<td>62</td>
								<td>64</td>
								<td>66</td>
							</tr>
							<tr class="even">
								<td>Inseam</td>
								<td>24</td>
								<td>25</td>
								<td>26</td>
								<td>27</td>
								<td>28</td>
								<td>29</td>
								<td>30</td>
							</tr>
							<tr class="">
								<td>Waist To Knee</td>
								<td>50</td>
								<td>52</td>
								<td>54</td>
								<td>56</td>
								<td>58</td>
								<td>60</td>
								<td>62</td>
							</tr>
							<tr class="even">
								<td>Total Height</td>
								<td>92</td>
								<td>96</td>
								<td>100</td>
								<td>104</td>
								<td>108</td>
								<td>112</td>
								<td>116</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!----------------------------------------  Branch Popup ---------------------------- -->
<div id="select_location_popup" class="popup select_location">
	<div class="popup__window select_location">
		<div class="top">
			<h3> <?php echo popup_translate('branch_popup_title', $language); ?> </h3>
			<button type="button" class="popup__close material-icons js-popup-closer">close</button>
		</div>
		<form class="section_content" action="">
			<div class="sec_city">
				<h5> <?php echo popup_translate('gover', $language); ?> </h5>
				<?php $first_gover = true ; ?>
				<?php $govers = MD_get_all_data_govs(); ?>
				<?php $gover_name = 'gov_name_' . $language; ?>
				<?php foreach($govers as $one_gover){  ?>
				<div class="option">
					<input class="checkbox-box  gover-checkbox" type="radio" id="<?php echo  $one_gover->gov_id ?>" name="city"
						value="<?php echo $one_gover->gov_name_ar  ?>"
						<?php if($first_gover){$first_gover = false ; echo 'checked';} ?> />
					<label for="<?php echo  $one_gover->gov_id ?>"> <?php  echo ucfirst( $one_gover->$gover_name) ;?></label>
				</div>
				<?php } ?>

			</div>
			<div class="sec_select">
				<div class="row">
					<label for="area"><?php echo popup_translate('area', $language); ?> </label>
					<select name="area" id="area">
						<?php $default_area = MD_Get_area(1,$language); ?>
						<?php $name = 'area_name_' . $language ;?>
						<option value="false" selected> <?php echo popup_translate('dropdown_default', $language); ?> </option>
						<?php foreach($default_area as $one_area){ ?>
						<option value="<?php echo $one_area->area_id ?>"> <?php echo ucfirst( $one_area->$name); ?></option>
						<?php } ?>

					</select>
				</div>
			</div>
			<div class="sec_select">
				<div class="row">
					<label for="street"> <?php echo popup_translate('street', $language); ?> </label>
					<select name="street" id="street">
						<option value="false" selected> <?php echo popup_translate('dropdown_default2', $language); ?> </option>

					</select>
				</div>
			</div>
			<div id="branch_submit" class="button_action">
				<button disabled type="button"> <?php echo popup_translate('branch_popup_title', $language); ?></button>
			</div>

		</form>
	</div>
</div>

<!-- MD-popups -->