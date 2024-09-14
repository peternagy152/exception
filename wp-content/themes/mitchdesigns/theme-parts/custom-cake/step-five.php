<?php global $language; ?>
<?php
// getting Avaliable Shapes 
$colors = get_all_colors();
$shapes3d = get_all_shapes3d();
?>
<div class="options color_and_toping_option">

	<!-- <ul class="nav">
                <li>
                    <button id="f_option1" class="s_btn active"> <?php //if($language == 'en'){echo 'Sugar Cake' ; }else{echo ' عجينة السكر ' ;} ?></button>
                </li>
                <li>
                    <button id="f_option2" class="s_btn"> <?php //if($language == 'en'){echo 'Sponge Cake' ; }else{echo 'اسفنجي' ;} ?></button>
                </li>
        </ul> -->

	<h3 class="section_title"> <?php if($language == 'en'){echo 'Cake Decoration ' ; }else{echo ' تزيين الكيك' ;} ?></h3>
	<div id="c_option1" class="content c_option1 active">
		<h3 class="section_title"> <?php if($language == 'en'){echo 'Color' ; }else{echo ' اللون' ;} ?></h3>
		<div class="options" id="color_option">
			<?php //$first_active = true ; ?>
			<?php $counter = 1 ?>
			<?php foreach($colors as $one_color){ ?>
			<div class="s_option <?php //if($first_active){echo 'active' ;} ?> " data-target="">
				<input <?php if($counter == 1){$counter++ ; echo "checked";} ?> value="<?php echo $one_color->color_slug ; ?>"
					type="radio" name="gender" id="" <?php if($first_active){echo 'checked' ; $first_active = false;} ?>>
				<label style="background-color: #<?php echo $one_color->color_hex  ?>;"
					for="<?php echo $one_color->color_en ; ?>"><?php //echo $one_color->color_ar ?></label>
			</div>
			<?php }  ?>
		</div>

		<a class="min_icons js-popup-opener" href="#popup-add-cutouts">
			<div class="section_click">
				<p> <?php if($language == 'en'){echo 'Add cutouts' ; }else{echo 'أضف مجسمات' ;} ?> </p>
				<span class="plus"></span>
			</div>
		</a>

		<div class="list_icons">
		</div>

		<div id="popup-add-cutouts" class="popup cutouts">
			<div class="popup__window select_cutouts">
				<div class="top">
					<h3> <?php if($language == 'en'){echo 'Add cutouts' ; }else{echo 'أضف مجسمات' ;} ?>
						<span> <?php if($language == 'en'){echo 'Add up to four cutouts' ; }else{echo 'أضف حتى أربعه مجسمات' ;} ?>
						</span>
					</h3>

					<!-- <button type="button" class="popup__close material-icons js-popup-closer">close</button> -->
				</div>
				<form class="section_content" action="">
					<div class="all_widget">
						<?php foreach($shapes3d as $one_shape3d){ ?>
						<div class="min_widget" data-slug="<?php echo $one_shape3d->shape3d_slug ?>"
							data-price="<?php echo $one_shape3d->price ?>">
							<div class="widget_img" style="background-color: #<?php //echo $one_color->color_hex  ?>;">
								<img src="<?php echo  $one_shape3d->image_url ;?>" alt="">
								<div class="border_done">
									<i class="material-icons">done</i>
								</div>
							</div>
							<div class="widget_title">
								<?php $shape3d_name = 'shape3d_' . $language ; ?>
								<h4><?php echo $one_shape3d->$shape3d_name ?></h4>
								<p><?php echo $one_shape3d->price ?> <?php if($language == 'en'){echo 'EGP' ; }else{echo 'ج م+' ;} ?>
								</p>
							</div>
						</div>
						<?php } ?>
					</div>

					<div class="bottom">
						<button id="add-shape3d" class="btn_add"> <?php if($language == 'en'){echo 'Add' ; }else{echo 'أضف' ;} ?>
						</button>
					</div>
				</form>

			</div>
		</div>
	</div>

	<div id="c_option2" class="content c_option2">
		<select class="s_select" name="area" id="toping_option">
			<option value="false" disabled selected> اسفنجي </option>
		</select>
	</div>

</div>