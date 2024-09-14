<?php 

function areas_dashboard_callback(){
	if(isset($_POST['area_name_en'])){
		$data = [
			"area_name_en" => $_POST['area_name_en'] , 
			"area_name_ar" => $_POST['area_name_ar'] , 
			"gov_id" => $_POST['area_gov_id'] ,
		] ; 
		insert_area($data);
	}

	if(isset($_POST['delete_area'])){
		remove_area($_POST['delete_area']);
	}
	
	if(isset($_POST['update_area'])){
		$data = [
			"area_name_en" => $_POST['area_name_en'] , 
			"area_name_ar" => $_POST['area_name_ar'] , 
			"gov_id" => $_POST['gov_id'] , 
			"area_id"	=> $_POST['update_area'],

		];
		update_area($data);
	}
	?>
<div class="container mb-5">
	<div class="row">
		<div class="col">
			<form class="card" method="post">
				<h1> Add New Area</h1>
				<div class="mb-3">
					<label for="area_name_en" class="form-label"> Name EN </label>
					<input required name="area_name_en" type="text" class="form-control" id="area_name_en">
				</div>
				<div class="mb-3">
					<label for="area_name_ar" class="form-label">Name AR </label>
					<input required name="area_name_ar" type="text" class="form-control" id="area_name_ar">
				</div>
				<div class="mb-3">
					<?php $all_govs = MD_get_all_data_govs(); ?>
					<label for="gov_id" class="form-label"> Government</label>
					<select name="area_gov_id" required class="form-select" aria-label="Default select example">
						<?php foreach($all_govs as $one_gov){ ?>
						<option value="<?php echo $one_gov->gov_id ?>"> <?php echo $one_gov->gov_name_ar ?> </option>
						<?php } ?>
					</select>
				</div>
				<button type="submit" class="btn btn-primary">Add Area </button>
			</form>
		</div>
		<div class="col">

		</div>
	</div>
</div>

<div class="container">
	<h1> Areas </h1>
	<table class="table table-striped-columns">
		<thead>
			<tr>
				<th scope="col">#</th>
				<th scope="col">Name AR</th>
				<th scope="col">Name EN</th>
				<th scope="col">Government</th>
				<th scope="col">Actions </th>
			</tr>
		</thead>
		<tbody>
			<?php $all_areas = gat_all_areas(); ?>
			<?php foreach($all_areas as $one_area){ ?>
			<tr>
				<form method="post">
					<th scope="row"><?php echo $one_area->area_id  ;?></th>
					<td><input style="width:90%;" name="area_name_ar" type="text"
							value=" <?php echo  $one_area->area_name_ar ;?>"> </td>
					<td><input style="width:90%;" name="area_name_en" type="text"
							value=" <?php echo  $one_area->area_name_en ;?>"> </td>
					<td> <select name="gov_id"> <?php foreach($all_govs as $one_gov){ ?> <option
								<?php if($one_area->gov_id == $one_gov->gov_id){echo 'selected';} ?>
								value="<?php echo $one_gov->gov_id; ?>"><?php echo $one_gov->gov_name_ar; ?></option>
							<?php }  ?></select> </td>
					<td><button name="update_area" value="<?php  echo $one_area->area_id  ?>" class="btn btn-success">
							<i class="bi bi-hand-thumbs-up"></i> </button> <button name="delete_area"
							value="<?php echo $one_area->area_id ; ?>" type="submit" class="btn btn-danger"><i
								class="bi bi-trash"></i></button></td>
				</form>
			</tr>
			<?php  } ?>
		</tbody>
	</table>

</div>

<?php 
}