<?php global $language ;?>
<?php if(wp_is_mobile()) { ?>

<?php
$current_url  = $_SERVER['REQUEST_URI'] ;
$current_url = str_replace('?lang=en' , '' , $current_url);
if( 'myaccount' == basename($current_url )) 
{
        if($language == 'en'){$current_active = "Overview" ;}else{$current_active = "الرئيسية" ;}
} else if('addresses.php' == basename($current_url)){
        if($language == 'en'){$current_active = 'Shipping Addresses';}else{$current_active = "عناويني " ;}
} else 
//if('my-wallet.php' == basename($current_url)){
        //if($language == 'en'){$current_active = ' '}else{$current_active = "محفظتى" ;}
//}else 
if('wishlist.php' == basename($current_url)) {
        if($language == 'en'){$current_active = 'My Wishlist' ;}else{$current_active = " قائمة أمنياتي" ;}
}else if('orders-list.php' == basename($current_url)){
        if($language == 'en'){$current_active = 'Orders & Returns' ;}else{$current_active = " طلباتي" ;}
}else if('profile.php' == basename($current_url)){
        if($language == 'en'){$current_active = 'Account Info' ;}else{$current_active = "بيانات الحساب" ;}
}else{
        if($language == 'en'){$current_active = 'Orders & Returns' ;}else{$current_active = "طلباتي" ;}
}



?>


<div class="myaccount_menu mobile">
	<?php $current_active ?>
	<div class="txt header_title_text"><span><?php echo $current_active ?></span></div>
	<ul class="select_view">
		<li class="icon_close">
			<button class="MD-close js-MD-popup-closer">
				<span class="material-symbols-rounded">close</span>
			</button>
		</li>
		<li
			class="md_menu_overall <?php if('myaccount' == basename($current_url)){echo "active" ; $current_active = Myaccount_translation('myaccount_page_sidebare_overview' , $language) ; } ?>">
			<a
				href="<?php echo home_url('myaccount/');echo ($language == 'en')? '?lang=en':''?>"><?php echo Myaccount_translation('myaccount_page_sidebare_overview', $language);?></a>
		</li>
		<li
			class="md_menu_addresse <?php if('addresses.php' == basename($_SERVER['REQUEST_URI'])){echo "active" ; $current_active = Myaccount_translation('myaccount_page_sidebare_address' , $language);  } ;?>">
			<a
				href="<?php echo home_url('myaccount/addresses.php');echo ($language == 'en')? '?lang=en':''?>"><?php echo Myaccount_translation('myaccount_page_sidebare_address' , $language);?></a>
		</li>
		<!-- <li class="md_menu_wallet <?php //if('my-wallet.php' == basename($_SERVER['REQUEST_URI'])) echo "active" ;?>"><a
                        href="<?php //echo home_url('myaccount/my-wallet.php');echo ($language == 'en')? '?lang=en':''?>"> <?php //echo Myaccount_translation('wallet_title' , $language) ?></a>
                </li> -->
		<li class="md_menu_wishlist <?php if('wishlist.php' == basename($_SERVER['REQUEST_URI'])) echo "active" ;?>">
			<a href="<?php echo home_url('myaccount/wishlist.php');echo ($language == 'en')? '?lang=en':''?>">
				<?php echo Myaccount_translation('wishlist_page_title' , $language) ?></a>
		</li>

		<li
			class="md_menu_orders <?php if('orders-list.php' == basename($_SERVER['REQUEST_URI'])) echo "active ";?> <?php if('order-details.php' == explode('?',basename($_SERVER['REQUEST_URI']) )[0] || 'return-products.php' == explode('?',basename($_SERVER['REQUEST_URI']) )[0]  ) echo "active ";?>">
			<a href="<?php echo home_url('myaccount/orders-list.php');echo ($language == 'en')? '?lang=en':''?>">
				<?php echo Myaccount_translation('myaccount_page_sidebare_orders' , $language) ?></a>
		</li>
		<li class="md_menu_profile <?php if('profile.php' == basename($_SERVER['REQUEST_URI'])) echo "active ";?>">
			<a href="<?php echo home_url('myaccount/profile.php');echo ($language == 'en')? '?lang=en':''?>">
				<?php echo Myaccount_translation('myaccount_page_sidebare_home', $language) ?></a>
		</li>
		<li class="logout">
			<a
				href="<?php if($language == 'en'){ echo  wp_logout_url('https://cloudhosta.com:63/myaccount') ; }else{echo wp_logout_url(home_url()); } ?>"><?php echo Myaccount_translation('myaccount_page_sidebare_logout', $language) ?></a>
		</li>
	</ul>

</div>
<?php } else { ?>
<div class="myaccount_menu desktop">
	<ul class="menu_myaccount">
		<li class="md_menu_overall <?php if('myaccount' == basename($_SERVER['REQUEST_URI'])) echo "active" ;?>">
			<a
				href="<?php echo home_url('myaccount/');echo ($language == 'en')? '?lang=en':''?>"><?php echo Myaccount_translation('myaccount_page_sidebare_overview', $language);?></a>
		</li>
		<li class="md_menu_addresse <?php if('addresses.php' == basename($_SERVER['REQUEST_URI'])) echo "active" ;?>"><a
				href="<?php echo home_url('myaccount/addresses.php');echo ($language == 'en')? '?lang=en':''?>"><?php echo Myaccount_translation('myaccount_page_sidebare_address', $language);?></a>
		</li>
		<!-- <li class="md_menu_wallet <?php //if('my-wallet.php' == basename($_SERVER['REQUEST_URI'])) echo "active" ;?>"><a
                href="<?php //echo home_url('myaccount/my-wallet.php');echo ($language == 'en')? '?lang=en':''?>"><?php //echo Myaccount_translation('wallet_title', $language) ?></a>
        </li> -->
		<li class="md_menu_wishlist <?php if('wishlist.php' == basename($_SERVER['REQUEST_URI'])) echo "active" ;?>"><a
				href="<?php echo home_url('myaccount/wishlist.php');echo ($language == 'en')? '?lang=en':''?>">
				<?php echo Myaccount_translation('wishlist_page_title', $language) ?></a></li>

		<li
			class="md_menu_orders <?php if('orders-list.php' == basename($_SERVER['REQUEST_URI'])) echo "active ";?> <?php if('order-details.php' == explode('?',basename($_SERVER['REQUEST_URI']) )[0] || 'return-products.php' == explode('?',basename($_SERVER['REQUEST_URI']) )[0]  ) echo "active ";?>">
			<a href="<?php echo home_url('myaccount/orders-list.php');echo ($language == 'en')? '?lang=en':''?>">
				<?php echo Myaccount_translation('myaccount_page_sidebare_orders', $language) ?></a>
		</li>
		<li class="md_menu_profile <?php if('profile.php' == basename($_SERVER['REQUEST_URI'])) echo "active ";?>"><a
				href="<?php echo home_url('myaccount/profile.php');echo ($language == 'en')? '?lang=en':''?>"><?php echo Myaccount_translation('myaccount_page_sidebare_home', $language) ?></a>
		</li>

	</ul>
	<ul class="menusupport_myaccount">
		<p> <?php echo Myaccount_translation('myaccount_page_sidebar_title_menu_help', $language) ?></p>
		<li><a href="<?php echo home_url('faqs');echo ($language == 'en')? '?lang=en':''?>">
				<?php echo Myaccount_translation('myaccount_page_sidebar_faq', $language) ?></a>
		</li>
		<li><a href="<?php echo home_url('contact-us');echo ($language == 'en')? '?lang=en':''?>">
				<?php echo Myaccount_translation('myaccount_page_sidebar_contact_us', $language) ?></a>
		</li>

		<li class="logout">
			<?php if($language == 'en'){ ?>
			<a href="<?php echo wp_logout_url(home_url() . '?lang=en' ) ; ?>">
				<?php echo Myaccount_translation('myaccount_page_sidebare_logout', $language) ?></a>

			<?php } else { ?>
			<a href=" <?php echo wp_logout_url() ;  ?>">
				<?php echo Myaccount_translation('myaccount_page_sidebare_logout', $language) ?></a>

			<?php }  ?>
		</li>
	</ul>
</div>
<?php }  ?>


<div class="overlay-mobile"></div>