<?php
require_once '../wp-content/themes/mitchdesigns/header.php';
mitch_validate_logged_in();
global $current_user;
$user_orders = mitch_get_myorders_list();


?>

<div id="page" class="site">
	<?php require_once '../wp-content/themes/mitchdesigns/theme-parts/main-menu.php';?>
	<!--start page-->
	<div class="site-content page_myaccount">
		<div class="grid">
			<div class="page_content">
				<div class="section_nav">
					<div class="box_nav">
						<?php include_once 'myaccount-sidebar.php';?>
						<div class="section_title">
							<!-- <img src="<?php // echo get_stylesheet_directory_uri(); ?>/assets/img/MD_myaccount_icon/login.png" alt=""> -->
							<span class="<?php echo strtolower( "Silver") ; ?>"><?php echo "Silver" ; ?></span>
							<h3 class="name">
								<?php echo get_user_meta($current_user->ID, 'first_name', true).' '.get_user_meta($current_user->ID, 'last_name', true);?>
							</h3>
						</div>
					</div>
				</div>
				<div class="dashbord">
					<div class="overview">

						<ul class="MD-breadcramb">
							<li><a
									href="<?php echo home_url();?>"><?php echo Myaccount_translation('myaccount_pagination_home' , $language) ?></a>
							</li>
							<li><?php echo Myaccount_translation('myaccount_page_title' , $language) ?></li>
							<li><?php echo Myaccount_translation('myaccount_page_sidebare_overview' , $language) ?></li>
						</ul>
						<!-- <h1 class="dashboard-title"> <?php //echo  Myaccount_translation('myaccount_page_sidebare_overview', $language) ; ?></h1> -->
						<?php if( isset($_GET['register']) && $_GET['register'] == "true" ){  ?>
						<div class=" callback-message success-message show-message  ">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/MD_myaccount_icon/star.png" alt=""
								class="success-icon">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/MD_myaccount_icon/warning.png" alt=""
								class="error-icon">

							<p> <?php echo Myaccount_translation('register_message' , $language)  ?></p>
						</div>
						<?php } ?>

						<!-- Head Title  -->
						<div class="welcome-box section">
							<div class="left">
								<h3><?php echo Myaccount_translation('welcome_message_title' , $language) ?></h3>
								<p><?php echo Myaccount_translation('welcome_message_subtitle' , $language) ?></p>
							</div>
							<!-- <div class="right">
                                <div class="points">
                                    <div class="title">
                                        <p><?php //echo Myaccount_translation('wallet_balance' , $language) ?></p>
                                        <h4><?php //echo 100 ; //$user_points_info->current_points ?> <?php //echo Myaccount_translation('Points_keyword' , $language) ?>
                                            <span>(<?php// echo 50 ; //$user_points_info->current_points  /  $points_settings['groups'][$user_points_info->level_number]['points_to_currency'] ?>
                                                EGP)</span>
                                        </h4>
                                    </div>
                                </div>

                            </div> -->
						</div>

						<!-- Share Link  -->
						<!-- <div class="sharebutton section">
                            <h2 class="sharebutton_title"><?php //echo Myaccount_translation('sharebutton_title' , $language) ?></h2>
                            <p class="sharebutton_subtitle"><?php //echo Myaccount_translation('sharebutton_subtitle' , $language) ?></p>
                            <div class="details">
                                <div class="left">
                                    <img src="<?php// echo get_stylesheet_directory_uri(); ?>/assets/img/MD_myaccount_icon/percent.png" alt="">
                                    <p class="link_copy">www.exception.com/ref=1-02o0;20409</p>
                                </div>
                                <div class="right">
                                    <button onclick="copyText()">
                                    <?php// echo Myaccount_translation('link_title_copy' , $language) ?>
                                    </button>
                                    <p class='copied-message'> <?php //echo Myaccount_translation('link_title_copied' , $language) ?></p>
                                </div>

                            </div>
                        </div> -->

						<?php if(!empty($user_orders)){  ?>
						<div class="order-details section">
							<h3 class="section-title-basic">
								<?php echo Myaccount_translation('overview_orders_return_title' , $language) ?></h3>

							<?php if(!wp_is_mobile()) { ?>
							<div class="MD-orders-list desktop">
								<div class="section_tabel">
									<?php if(!empty($user_orders)){  ?>
									<table>
										<tr>
											<th>
												<?php echo  Myaccount_translation('overview_orders_return_table_titles_order_no' , $language) ;?>
											</th>
											<th><?php echo  Myaccount_translation('overview_orders_return_table_titles_date' , $language) ;?>
											</th>
											<th>
												<?php echo  Myaccount_translation('overview_orders_return_table_titles_status' , $language) ;?>
											</th>
											<th><?php echo  Myaccount_translation('overview_orders_return_table_titles_price' , $language) ;?>
											</th>
											<th></th>
										</tr>
										<?php $order_counter = 0 ; ?>
										<?php $count=1; foreach($user_orders as $order_obj){
                                                if($order_counter == 5)
                                                break;
                                                $order_counter++;
                                                if( $order_obj->get_status() == 'pending')
                                                continue;
                                                
                                                ?>
										<tr class="<?php echo($count%2==0)?'even':'odd';?>">

											<!-- Order Num  -->
											<td class="order_number">
												<!-- <a href="<?php //echo home_url('my-account/orders-list/order-details');?>">#<?php //echo $order_obj->get_id();?></a> -->
												<p class="num not_click">#<?php echo $order_obj->get_id();?></p>
											</td>

											<!-- Order Date  -->
											<td>
												<?php echo $order_obj->get_date_created()->date("j/n/Y");?>
											</td>

											<!-- Order Status  -->
											<td class="status">
												<span class="<?php echo $order_obj->get_status();?>">
													<?php echo Order_status($order_obj->get_status(), $language);  ?>
												</span>
											</td>

											<!-- Order Price  -->
											<td>
												<?php echo number_format($order_obj->get_total()).' '. $theme_settings['curren_currency_' . $language];?>
											</td>

											<!-- Order Details  -->
											<td class="table_action">
												<a <?php 
                                                                if($language == 'en'){
                                                                    $Query = "/myaccount/order-details.php?lang=en&order_id=". $order_obj->get_id()  ;  
                                                                }else{
                                                                    $Query = "/myaccount/order-details.php?order_id=". $order_obj->get_id()  ;  
                                                                }
                                                            
                                                                ?> href="<?php echo home_url($Query);?>">
													<button class="show"
														type="button"><?php echo  Myaccount_translation('overview_orders_return_table_titles_button' , $language) ?></button>
												</a>

											</td>
										</tr>
										<?php $count++;  } ?>
									</table>
									<?php } ?>
								</div>
							</div>
							<?php } ?>

							<?php  if(wp_is_mobile()) {?>
							<div class="MD-orders-list mobile">
								<div class="section_tabel">
									<?php
                                            $user_orders = mitch_get_myorders_list();
                                            if(!empty($user_orders)){
                                            ?>
									<table>
										<tr>
											<th></th>
											<th></th>
											<th></th>
										</tr>
										<?php $count=1; foreach($user_orders as $order_obj){ ?>
										<tr class="<?php echo($count%2==0)?'even':'odd';?>">
											<td class="order_number">
												<!-- <a href="<?php //echo home_url('my-account/orders-list/order-details');?>">#<?php //echo $order_obj->get_id();?></a> -->
												<p class="num not_click">#<?php echo $order_obj->get_id();?></p>
											</td>
											<td class="status mobile">
												<span class="note_status <?php echo $order_obj->get_status();?>">
													<?php echo Order_status($order_obj->get_status(), $language); ?>
												</span>
												<span class="new">
													<?php echo $order_obj->get_date_created()->date("j/n/Y");?>
												</span>
												<span class="new price">
													<?php echo number_format($order_obj->get_total()).' '. $theme_settings['curren_currency_' . $language];?>
												</span>

											</td>

											<td class="table_action">
												<a <?php $Query = "/myaccount/order-details.php?order_id=". $order_obj->get_id()  ;   ?>
													href="<?php echo home_url($Query);?>">
													<button class="show"
														type="button"><?php echo $fixed_string['myaccount_page_orders_show'];?></button>
												</a>

											</td>
										</tr>
										<?php $count++;  } ?>
									</table>
									<?php } ?>
								</div>
							</div>
							<?php } ?>

						</div>
						<?php }else{ ?>
						<div class="empty-content">
							<p><?php echo Myaccount_translation('Orders_no_orders' , $language) ?></p>
							<a href="<?php echo home_url();?>"
								class="js-MD-popup-opener MD-btn-go"><?php echo Myaccount_translation('Orders_shop_now' , $language) ?></a>
						</div>
						<?php }  ?>

						<div class="account-info section">
							<h3 class="section-title-basic">
								<?php echo  Myaccount_translation('myaccount_page_sidebare_profile' , $language) ?></h3>
							<div class="boxes">

								<div class="change-info">
									<h4 class="title">
										<img
											src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/MD_myaccount_icon/menu/user_perp.png"
											alt="" width="20" height="20">
										<?php echo  Myaccount_translation('account_first_title' , $language) ?>
									</h4>
									<div class="MD-row">
										<!-- <label> <?php //echo Myaccount_translation('account_first_name' , $language)   ?></label> -->
										<span> <?php echo get_user_meta($current_user->ID, 'first_name', true);?>
											<?php echo get_user_meta($current_user->ID, 'last_name', true);?></span>
									</div>
									<!-- <div class="MD-row half">
                                        <label> <?php //echo Myaccount_translation('account_last_name' , $language)   ?></label>
                                        <span> <?php //echo get_user_meta($current_user->ID, 'last_name', true);?></span>
                                    </div> -->
									<div class="MD-row">
										<!-- <label><?php //echo Myaccount_translation('account_email' , $language)   ?> </label> -->
										<!-- static -->
										<span><?php echo $current_user -> user_email ?></span>
									</div>
									<div class="MD-row">
										<!-- <label> <?php //echo Myaccount_translation('account_mobile' , $language)   ?></label> -->
										<!-- static -->
										<span><?php echo get_user_meta($current_user->ID, 'phone_number', true)  ?></span>

									</div>
									<a class="link_edit_info"
										href="<?php if($language == 'en'){echo home_url('myaccount/profile.php?lang=en');}else{echo home_url('myaccount/profile.php');} ?>"><?php echo Myaccount_translation('Edit_keyword' , $language); ?></a>
								</div>

								<?php $main_address    = mitch_get_user_main_address($current_user->ID);?>
								<?php if(!empty($main_address)) { ?>
								<div class="change-info">
									<h4 class="title">
										<img
											src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/MD_myaccount_icon/menu/addresse_perp.png"
											alt="" width="20" height="20">
										<?php echo Myaccount_translation('shipping_default_address' , $language)   ?>
									</h4>
									<div class="MD-row">
										<!-- <label><?php //echo Myaccount_translation('shipping_area' , $language)   ?></label> -->
										<?php $gov_info = get_gov_name_by_id($main_address -> level_1);  ?>
										<?php $gov_name = "gov_name_" . $language ;?>
										<span> <?php echo $gov_info-> $gov_name ?></span>
									</div>

									<div class="MD-row">
										<!-- <label><?php //echo Myaccount_translation('shipping_street' , $language)   ?>.</label> -->
										<?php $area_info = MD_Get_area_by_area_id( $main_address -> level_2); ?>
										<?php $area_name = "area_name_" . $language ; ?>
										<span> <?php echo $area_info -> $area_name  ?></span>
									</div>

									<div class="MD-row">
										<!-- <label><?php //echo Myaccount_translation('shipping_street' , $language)   ?>.</label> -->
										<?php $street_info = get_street_name_by_id( $main_address -> level_3); ?>
										<?php $street_name = "street_name_" . $language ; ?>
										<span> <?php echo $street_info -> $street_name  ?></span>
									</div>

									<div class="MD-row">
										<!-- <label><?php //echo Myaccount_translation('shipping_street' , $language)   ?>.</label> -->
										<span> <?php echo $main_address -> full_address  ?></span>
									</div>
									<div class="MD-row">
										<!-- <label><?php //echo Myaccount_translation('shipping_street' , $language)   ?>.</label> -->
										<span> <?php echo $main_address -> Floor ?></span>
									</div>
									<div class="MD-row">
										<!-- <label><?php //echo Myaccount_translation('shipping_street' , $language)   ?>.</label> -->
										<span> <?php echo $main_address -> apartment ?></span>
									</div>


									<a class="link_edit_info"
										href="<?php if($language == 'en'){echo home_url('myaccount/addresses.php?lang=en');}else{echo home_url('myaccount/addresses.php');}?>"><?php echo Myaccount_translation('shipping_edit_address' , $language)   ?></a>
								</div>

								<?php } ?>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
	<!--end page-->
</div>
<?php require_once '../wp-content/themes/mitchdesigns/footer.php';?>