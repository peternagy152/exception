<div class="myaccount_menu desktop">
	<ul>
		<li class="<?php echo mitch_get_active_page_class('overview');?>"><a
				href="<?php echo home_url('my-account/overview');?>"><?php echo $fixed_string['myaccount_page_sidebare_overview'];?></a>
		</li>
		<li class="<?php echo mitch_get_active_page_class('addresses');?>"><a
				href="<?php echo home_url('my-account/addresses');?>"><?php echo $fixed_string['myaccount_page_sidebare_address'];?></a>
		</li>
		<li class="<?php echo mitch_get_active_page_class('my-wallet');?>"><a
				href="<?php echo home_url('my-account/my-wallet');?>">My Wallet</a>
		</li>
		<li class="<?php echo mitch_get_active_page_class('wishlist');?>"><a href="<?php echo home_url('wishlist');?>">My
				Wishlist</a></li>

		<li
			class="<?php echo mitch_get_active_page_class('orders-list');?> <?php echo mitch_get_active_page_class('order-details');?>">
			<a
				href="<?php echo home_url('my-account/orders-list');?>"><?php echo $fixed_string['myaccount_page_sidebare_orders'];?></a>
		</li>
		<li class="<?php echo mitch_get_active_page_class('profile');?>"><a
				href="<?php echo home_url('my-account/profile');?>"><?php echo $fixed_string['myaccount_page_sidebare_profile'];?></a>
		</li>

	</ul>
	<ul>
		<p>Need Help?</p>
		<li><a href="<?php echo home_url('faqs');?>">FAQs</a>
		</li>
		<li><a href="<?php echo home_url('contact-us');?>">Contact Us</a>
		</li>

		<li class="logout">
			<a
				href="<?php if($language == 'en'){ echo  wp_logout_url('https://cloudhosta.com:63/myaccount?lang=en') ; }else{echo wp_logout_url(home_url()); } ?>"><?php echo Myaccount_translation('myaccount_page_sidebare_logout', $language) ?></a>
		</li>
		</li>
	</ul>
</div>

<div class="myaccount_menu mobile">
	<div class="txt"><span><?php echo $fixed_string['myaccount_page_sidebare_overview'];?></span></div>
	<div class="select_view">
		<li class="<?php echo mitch_get_active_page_class('overview');?>"><a
				href="<?php echo home_url('my-account/overview');?>"><?php echo $fixed_string['myaccount_page_sidebare_overview'];?></a>
		</li>
		<li class="<?php echo mitch_get_active_page_class('addresses');?>"><a
				href="<?php echo home_url('my-account/addresses');?>"><?php echo $fixed_string['myaccount_page_sidebare_address'];?></a>
		</li>
		<li class="<?php echo mitch_get_active_page_class('my-wallet');?>"><a
				href="<?php echo home_url('my-account/my-wallet');?>">My Wallet</a>
		</li>
		<li class="<?php echo mitch_get_active_page_class('wishlist');?>"><a href="<?php echo home_url('wishlist');?>">My
				Wishlist</a></li>

		<li
			class="<?php echo mitch_get_active_page_class('orders-list');?> <?php echo mitch_get_active_page_class('order-details');?>">
			<a
				href="<?php echo home_url('my-account/orders-list');?>"><?php echo $fixed_string['myaccount_page_sidebare_orders'];?></a>
		</li>
		<li class="<?php echo mitch_get_active_page_class('profile');?>"><a
				href="<?php echo home_url('my-account/profile');?>"><?php echo $fixed_string['myaccount_page_sidebare_profile'];?></a>
		</li>
		<li class="logout">
		<li class="logout">
			<a
				href="<?php if($language == 'en'){ echo  wp_logout_url('https://cloudhosta.com:63/myaccount?lang=en') ; }else{echo wp_logout_url(home_url()); } ?>"><?php echo Myaccount_translation('myaccount_page_sidebare_logout', $language) ?></a>
		</li>



	</div>

</div>
<div class="overlay-mobile"></div>