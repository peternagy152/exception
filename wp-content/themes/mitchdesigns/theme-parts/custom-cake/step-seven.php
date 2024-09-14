<?php global $language; ?>
<?php global $theme_settings ; ?>
<div class="box_details">
	<h5 class="title_details"><?php if($language == 'en'){echo 'Cake Details' ; }else{echo ' تفاصيل الكيكة' ;} ?></h5>
	<ul class="all_details">
		<li>
			<h3 class="title"><?php if($language == 'en'){echo 'Shape' ; }else{echo '  الشكل' ;} ?>
				<p class="details shape-review"></p>
			</h3>
		</li>

		<li>
			<h3 class="title"><?php if($language == 'en'){echo 'Size' ; }else{echo '  الحجم' ;} ?>
				<p class="details size-review"></p>
			</h3>
		</li>

		<li>
			<h3 class="title"><?php if($language == 'en'){echo 'Height' ; }else{echo 'الارتفاع' ;} ?>
				<p class="details height-review"></p>
			</h3>
			<p> <span class="price base-price"></span> <?php echo $theme_settings['curren_currency_'.$language] ?> </p>
		</li>

		<li>
			<h3 class="title"><?php if($language == 'en'){echo 'Flavor' ; }else{echo ' النكهة' ;} ?>
				<p class="details flavor-review"></p>
			</h3>
		</li>

		<li>
			<h3 class="title"><?php if($language == 'en'){echo 'Filling' ; }else{echo ' الحشوة' ;} ?>
				<p class="details filling-review"></p>
			</h3>
			<p> <span class="price filling-price"></span> <?php echo $theme_settings['curren_currency_'.$language] ?></p>
		</li>
		<li>
			<h3 class="title"> <?php if($language == 'en'){echo 'Cake Decoration' ; }else{echo ' تفاصيل الكيكة' ;} ?>
				<p class="details topping-review"></p>
			</h3>
		</li>
		<li>
			<h3 class="title"> <?php if($language == 'en'){echo '3D Shapes ' ; }else{echo '  مجسمات' ;} ?>
				<p class="details shapes-review"> </p>
			</h3>
			<p> <span class="price topping-price"></span> <?php echo $theme_settings['curren_currency_'.$language] ?></p>
		</li>
		<li>
			<h3 class="title"><?php if($language == 'en'){echo 'Writing' ; }else{echo ' تفاصيل الكيكة' ;} ?>
				<p class="details writing-review"></p>
			</h3>
			<p> <span class="price writing-price"></span> <?php echo $theme_settings['curren_currency_'.$language] ?></p>
		</li>
	</ul>
</div>
<div class="box_note">
	<h3> <?php if($language == 'en'){echo 'Add Note' ; }else{echo 'اضف ملاحظة' ;} ?></h3>
	<div class="textarea">
		<textarea id="order_notes" name=""></textarea>
	</div>
</div>