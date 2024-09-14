<?php 
// Query WooCommerce for orders placed today
$session_info = explode('-', $_SESSION['admin_dashboard']); 
$branch_id = $session_info[2] ;

if(isset($_GET['patch'])){
    if($_GET['patch'] == 'day'){
        $today = strtotime('today');
        $args = array(
            'post_type'      => 'shop_order',
            'post_status'    => array('wc-completed', 'wc-processing', 'wc-cancelled'), 
            'date_query'     => array(
                'after'     => date('Y-m-d', $today),
                'before'    => date('Y-m-d', $today + 86400), // 86400 seconds = 1 day
                'inclusive' => true,
            ),
            'posts_per_page' => -1,
        );

    }else if($_GET['patch'] == 'week'){
        $args = array(
            'post_type'      => 'shop_order',
            'post_status'    => array('wc-completed', 'wc-processing', 'wc-cancelled'), 
            'date_query'     => array(
                'after'     => date('Y-m-d', strtotime('-8 days')),
                'before'    => date('Y-m-d', strtotime('-1 day')),
                'inclusive' => true,
            ), 
            'posts_per_page' => -1,
        );
    }else if($_GET['patch'] == 'month'){
        $args = array(
            'post_type'      => 'shop_order',
            'post_status'    => array('wc-completed', 'wc-processing', 'wc-cancelled'), 
            'date_query'     => array(
                'after'     => 'first day of last month',
                'before'    => 'first day of this month',
                'inclusive' => true,
            ),
            'posts_per_page' => -1,
        );
    }

}else{
    // Default Filter 
    // This Month 

    $args = array(
        'post_type'      => 'shop_order',
        'post_status'    => array('wc-completed', 'wc-processing', 'wc-cancelled'), 
        'date_query'     => array(
            'after'     => 'first day of this month',
            'before'    => 'today',
            'inclusive' => true,
        ),
        'posts_per_page' => -1,
    );
    
    
    
}

global $wpdb ;
$orders = get_posts($args);

$completed_count = 0 ;
$cancelled_count = 0 ;
$all_orders = 0; 
if($branch_id == 0){ 
    if ($orders) {
        foreach ($orders as $order) {
            if($order -> post_status == 'wc-completed')
            $completed_count++;
            if($order -> post_status == 'wc-cancelled')   
            $cancelled_count++ ;
        }
    
    }
    $all_orders = count($orders) ;

}else{

    if ($orders) {
        foreach ($orders as $order) {
            $order_obj = wc_get_order($order->ID);
            // Get branch_id of Order ;
            if(empty($order_obj->get_meta('_order_from_branch'))){
                $branch_name =  $order_obj->get_meta('_billing_local_pickup')  ; 
            }else{
                $branch_name =  $order_obj->get_meta('_order_from_branch')  ;
            } 

            $branch_info =  $wpdb->get_row("SELECT  *  FROM pwa_branches WHERE branch_name_ar = '{$branch_name}' ; "  );
                if($branch_info -> branch_id == $branch_id ){
                $all_orders++;
                if($order -> post_status == 'wc-completed')
                $completed_count++;
                if($order -> post_status == 'wc-cancelled')   
                $cancelled_count++ ;
            }

           


        }
    
    }
}

if($all_orders != 0 ){
    $cancellation_rate = ($cancelled_count / $all_orders) * 100 ;
}else {
    $cancellation_rate = 0 ;
}

global $theme_settings;
?>
<div class="nav_dashboard">
	<div class="container">
		<div class="section_filter">
			<ul class="branches_filter">
				<li class="<?php if(!isset($_GET['patch'])){echo 'active' ;} ?>">
					<a href="<?php echo $theme_settings['site_url']  . '/dashboard/branch.php'?>">
						<span>الشهر الحالي</span>
					</a>
				</li>
				<li class="<?php if(isset($_GET['patch']) && $_GET['patch'] == 'day'){echo 'active' ;} ?>">
					<a href="<?php echo $theme_settings['site_url']  . '/dashboard/branch.php?patch=day'?>">
						<span>اليوم</span>
					</a>

				</li>
				<li class="<?php if(isset($_GET['patch']) && $_GET['patch'] == 'week'){echo 'active' ;} ?>">
					<a href="<?php echo $theme_settings['site_url']  . '/dashboard/branch.php?patch=week'?>">
						<span>الاسبوع الماضى</span>
					</a>
				</li>
				<li class="<?php if(isset($_GET['patch']) && $_GET['patch'] == 'month'){echo 'active' ;} ?>">
					<a href="<?php echo $theme_settings['site_url']  . '/dashboard/branch.php?patch=month'?>">
						<span>الشهر الماضى</span>
					</a>
				</li>

			</ul>
			<?php

                $date = new DateTime();
                $formattedDate = strftime('%B %Y %e', $date->getTimestamp());

                // Output the formatted date

?>
			<?php if(!isset($_GET['patch'])){ ?>
			<?php
            $currentMonth = date('F'); // Get the current month in English
            $translatedMonth = $monthTranslations[$currentMonth]; // Get the Arabic translation of the current month
        ?>

			<p class="date"> خلال شهر <?php echo $translatedMonth ;  ?></p>
			<?php }else if($_GET['patch'] == 'day'){  ?>
			<?php
            global $dayTranslations;
            global $monthTranslations;
            $currentDay = $dayTranslations[date('l')]; // Get the Arabic translation of the current day
            $currentMonth = $monthTranslations[date('F')]; // Get the Arabic translation of the current month
            $currentYear = date('Y'); // Get the current year
            $currentDateArabic = $currentDay . ' ' . date('j') . ' ' . $currentMonth . ' ' . $currentYear;
        ?>
			<p class="date"> <?php echo $currentDateArabic ;  ?></p>

			<?php }else if($_GET['patch'] == 'week'){ ?>
			<?php
                                
                $startDateWeek= date('Y-m-d', strtotime('-8 days'));
                $endDateWeek = date('Y-m-d', strtotime('-1 day'));
                
            ?>
			<p class="date"> من <?php echo ($startDateWeek) ;  ?> الي <?php   echo ($endDateWeek) ?></p>
			<?php }else if($_GET['patch'] == 'month'){ ?>
			<?php
                    $previousMonth = date('F', strtotime('first day of last month')); // Get the English name of the previous month
                    $previousMonthArabic = $monthTranslations[$previousMonth]; // Get the Arabic translation of the previous month
                    ?>
			<p class="date"> خلال شهر <?php echo $previousMonthArabic ;  ?></p>
			<?php } ?>
		</div>
		<div class="section_details">
			<ul class="details">
				<li class="total">
					<h4 class="text">اجمالى الطلبات</h4>
					<h6 class="num"><?php echo $all_orders; ?></h6>
				</li>
				<li class="completed">
					<h4 class="text">طلبات مكتملة</h4>
					<h6 class="num"><?php echo $completed_count ; ?></h6>
				</li>
				<li class="cancel">
					<h4 class="text">طلبات تم إلغائها</h4>
					<h6 class="num"><?php echo $cancelled_count ; ?></h6>
				</li>
				<li class="percent">
					<h4 class="text">نسبة الإلغاء</h4>
					<h6 class="num"><?php echo intval($cancellation_rate);?> %</h6>
				</li>
			</ul>
		</div>
	</div>

</div>