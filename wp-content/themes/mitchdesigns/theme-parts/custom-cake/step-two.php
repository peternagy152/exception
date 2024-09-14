<?php global $language; ?>
<?php $default_sizes = get_default_sizes(); ?>
<div class="options size_option">
	<!-- <div class="s_option">
                <h3 class="section_title"> <?php if($language == 'en'){echo ' Cake Type' ; }else{echo ' نوع الكيكة' ;} ?></h3>
                <select class="s_select half_select  " name="area" id="cake_type_option">
                <option value="false" disabled selected><?php if($language == 'en'){echo 'choose cake type' ; }else{echo 'اختر نوع الكيكة ' ;} ?> </option>
                    <option value="suger-cake"><?php if($language == 'en'){echo 'Suger Cake' ; }else{echo 'كيك عجينة السكر ' ;} ?> </option>
                    <option value="sponge-cake"><?php if($language == 'en'){echo 'Sponge Cake' ; }else{echo 'كيك اسفنجي ' ;} ?> </option>
                </select>
            </div> -->

	<div class="options color_and_toping_option">
		<ul class="nav">
			<li>
				<button id="f_option1" class="s_btn active">
					<?php if($language == 'en'){echo 'Sugar Cake' ; }else{echo ' عجينة السكر ' ;} ?></button>
			</li>
			<li>
				<button id="f_option2" class="s_btn">
					<?php if($language == 'en'){echo 'Sponge Cake' ; }else{echo 'اسفنجي' ;} ?></button>
			</li>
		</ul>
	</div>


	<div class="s_option">
		<h3 class="section_title"> <?php if($language == 'en'){echo 'Size' ; }else{echo 'المقاس' ;} ?></h3>
		<select class="s_select  " name="area" id="size_option">
			<option value="false" disabled selected>
				<?php if($language == 'en'){echo 'choose size' ; }else{echo 'اختر المقاس ' ;} ?> </option>
			<?php foreach($default_sizes as $one_size){ ?>
			<?php 	$enough_for =  get_writing_base("rectangle" , $one_size->size) ; ?>
			<option value="<?php echo $one_size->size ?>">
				<?php if($language == 'en'){ echo $one_size->size . ' Enough for ' . $enough_for->number . ' person ' ; } else {echo $one_size->size . ' تكفي حتي ' . $enough_for->number . ' فرد' ;} ?>
			</option>
			<?php } ?>
		</select>
	</div>



	<div class="s_option">
		<h3 class="section_title"> <?php if($language == 'en'){echo ' Height' ; }else{echo ' الارتفاع' ;} ?></h3>
		<select class="s_select half_select hidden_height" name="area" id="height_option">
			<option value="false" disabled selected>
				<?php if($language == 'en'){echo 'choose height' ; }else{echo 'اختر الارتفاع' ;} ?> </option>
		</select>
	</div>
</div>