<?php
require_once '../wp-content/themes/mitchdesigns/header.php';
mitch_validate_logged_in();
//repeat order process
mitch_repeat_order();
$user_orders = mitch_get_myorders_list();
?>
<style>
#repeat_order_button {
	width: 250px;
	background: black;
	color: white;
	font-size: 16px;
	font-weight: 600;
	line-height: 24px;
	padding: 14px 0;
	margin: 30px 30px 30px auto;
	display: block;
	text-align: center;
}
</style>
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
							<span class="<?php echo strtolower( "Silver") ; ?>"><?php echo "Silver" ; ?></span>
							<h3 class="name">
								<?php echo get_user_meta($current_user->ID, 'first_name', true).' '.get_user_meta($current_user->ID, 'last_name', true);?>
							</h3>
						</div>
					</div>

				</div>
				<div class="dashbord">
					<div class="orders">
						<ul class="MD-breadcramb">
							<li><a
									href="<?php echo home_url();?>"><?php echo Myaccount_translation('myaccount_pagination_home' , $language) ?></a>
							</li>
							<li><?php echo Myaccount_translation('myaccount_page_title' , $language) ?></li>
							<li><?php echo Myaccount_translation('myaccount_page_sidebare_orders' , $language) ?></li>
						</ul>
						<h1 class="dashboard-title">
							<?php echo Myaccount_translation('myaccount_page_sidebare_orders' , $language) ?></h1>
						<?php  if(empty($user_orders)){ ?>
						<div class="empty-content">
							<p><?php echo Myaccount_translation('Orders_no_orders' , $language) ?></p>
							<a href="<?php echo home_url();?>"
								class="js-MD-popup-opener MD-btn-go"><?php echo Myaccount_translation('Orders_shop_now' , $language) ?></a>
						</div>
						<?php } else{  ?>


						<?php if(!wp_is_mobile()) { ?>
						<div class="MD-orders-list desktop">
							<div class="section_tabel">
								<?php
                                   
                                    if(!empty($user_orders)){
                                    ?>
								<table>
									<tr>
										<th>
											<?php echo  Myaccount_translation('overview_orders_return_table_titles_order_no' , $language) ;?>
										</th>
										<th><?php echo  Myaccount_translation('overview_orders_return_table_titles_date' , $language) ;?>
										</th>
										<th><?php echo  Myaccount_translation('overview_orders_return_table_titles_status' , $language) ;?>
										</th>
										<th><?php echo  Myaccount_translation('overview_orders_return_table_titles_price' , $language) ;?>
										</th>
										<th></th>
									</tr>
									<?php $count=1; foreach($user_orders as $order_obj){
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
												<?php  echo Order_status($order_obj->get_status(), $language);?>
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
												href="<?php echo home_url($Query);?>" class="btn_back">

												<!-- <button class="show" type="button"><?php// echo $fixed_string['myaccount_page_orders_show'];?></button> -->
											</a>

										</td>
									</tr>
									<?php $count++;  } ?>
								</table>
								<?php } ?>
							</div>
						</div>
						<?php } ?>
						<?php } ?>

					</div>

				</div>
			</div>
		</div>
	</div>
	<!--end page-->
	<!-- <div id="overlay" class="overlay"></div> -->

</div>
<?php require_once '../wp-content/themes/mitchdesigns/footer.php';?>
<?php include_once 'MD-popups.php'; ?>
<script src="assets/js/my-account.js"></script>