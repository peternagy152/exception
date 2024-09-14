<?php 
global $wpdb;
$all_branches =  $wpdb->get_results("SELECT  *  FROM pwa_branches "  );
$session_info = explode('-', $_SESSION['admin_dashboard']); 
$branch_id = $session_info[2] ;
?>
<!-- Start Page -->
<div class="admin">
	<div class="section_head">
		<div class="grid">
			<div class="content">
				<div class="logo">
					<img src="../wp-content/themes/mitchdesigns/assets/img/web_logo.png" alt="">
				</div>
				<div class="info">
					<h3>
						<?php echo $session_info[0]?>
						<a class="destroy-session" href="#">تسجيل خروج</a>
					</h3>
				</div>
			</div>
		</div>
	</div>
	<div class="grid">
		<div class="dashboard_head ">
			<div class="branch_info">
				<h2>قائمة الفروع</h2>
			</div>
			<?php  require_once "components/analytics-bar.php"; ?>
		</div>
		<div class="dashboard_tabel">
			<div class="section_tabel">
				<table>
					<tr>
						<th>اسم الفرع</th>
						<th>اجمالي الطلبات</th>
						<th> طلبات مكتملة</th>
						<th> طلبات تم الغائها</th>
						<th> نسبة الإلغاء </th>
						<th></th>
					</tr>

					<?php foreach($all_branches as $one_branch){ ?>
					<?php 
                            $completed_count = 0 ;
                            $cancelled_count = 0 ;
                            $all_orders = 0; 
                            foreach ($orders as $order) {
                                    $order_obj = wc_get_order($order->ID);
																		  if(empty($order_obj->get_meta('_order_from_branch'))){
																					$branch_name =  $order_obj->get_meta('_billing_local_pickup')  ; 
																			}else{
																					$branch_name =  $order_obj->get_meta('_order_from_branch')  ;
																			} 

																			$branch_info =  $wpdb->get_row("SELECT  *  FROM pwa_branches WHERE branch_name_ar = '{$branch_name}' ; "  );
																					if($branch_info -> branch_id == $one_branch->branch_id ){
																					$all_orders++;
																					if($order -> post_status == 'wc-completed')
																					$completed_count++;
																					if($order -> post_status == 'wc-cancelled')   
																					$cancelled_count++ ;
																			}

                        
                                    // Get branch_id of Order ;
                                    // if(empty($order_obj->get_billing_city())){
                                        
                                    //     $branch_info =  $wpdb->get_row("SELECT  *  FROM pwa_branches WHERE branch_name_ar = '{$order_obj->get_meta('_billing_local_pickup')}'"  );
                                    //     if($branch_info -> branch_id == $branch_id ){
                                    //         $all_orders++;
                                    //         if($order -> post_status == 'wc-completed')
                                    //         $completed_count++;
                                    //         if($order -> post_status == 'wc-cancelled')   
                                    //         $cancelled_count++ ;
                                    //     }
                        
                                    // }else{
                                        
                                    //     $street_info =  $wpdb->get_row("SELECT  *  FROM pwa_shipping_street WHERE street_name_ar = '{$order_obj->get_billing_city()}'"  );
                                    //     if($street_info -> branch_id == $branch_id ){
                                    //         $all_orders++;
                                    //         if($order -> post_status == 'wc-completed')
                                    //         $completed_count++;
                                    //         if($order -> post_status == 'wc-cancelled')   
                                    //         $cancelled_count++ ;
                                    //     }
                                    // }
                        
                        
                                }
                                if($all_orders != 0 ){
                                    $cancellation_rate = ($cancelled_count / $all_orders) * 100 ;
                                }else {
                                    $cancellation_rate = 0 ;
                                }

                            ?>
					<tr>
						<!-- Branch Name  -->
						<td class="branch_name">
							<?php echo $one_branch->branch_name_ar ?>
						</td>

						<!-- Order Total  -->
						<td><?php echo $all_orders; ?></td>

						<!--  Completed  -->
						<td><?php echo $completed_count ; ?></td>

						<!-- Cancel  -->
						<td><?php echo $cancelled_count ; ?></td>

						<!-- percent  -->
						<td><?php echo intval($cancellation_rate) ;?> %</td>

						<!-- Branch Details  -->
						<td class="table_action">
							<button data-branch="<?php echo $one_branch->branch_id;  ?>" class="view_branch_details"></button>
						</td>
					</tr>
					<?php }  ?>
				</table>
			</div>
		</div>

	</div>
</div>
<!-- End Page -->