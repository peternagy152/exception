<?php 
function streets_dashboard_callback()
{
	if(isset($_POST['insert_street'])){
		$data = [
			"street_name_en" => $_POST['street_name_en'] , 
			"street_name_ar" => $_POST['street_name_ar'] ,  
			"area_id" => $_POST['area_id'] , 
			"branch_id" => $_POST['branch_id'], 
			"street_rate"=>$_POST['street_rate']
		];
		insert_street($data);
	}
	if(isset($_POST['delete_street'])){
		remove_street($_POST['delete_street']);
	}
	if(isset($_POST['update_street'])){
		$data = [
			"street_name_en" => $_POST['street_name_en'] , 
			"street_name_ar" => $_POST['street_name_ar'] , 
			"branch_id" => $_POST['branch_id'] , 
			"area_id" => $_POST['area_id'] , 
			"street_rate" => $_POST['street_rate'] ,  
			"street_id" => $_POST['update_street'] , 

		];
		update_street($data);
		
	}
	
	?>

<?php $all_branches = get_all_branches(); ?>
<?php $all_areas =  gat_all_areas(); ?>
<div class="container mb-4">
	<div class="row">
		<div class="col  ">
			<h1> Streets </h1>
			<form class="card" method="post">
				<h3> Add street </h3>
				<div class="mb-3">
					<label for="street_name_en" class="form-label"> Name EN </label>
					<input required name="street_name_en" type="text" class="form-control" id="street_name_en">
				</div>
				<div class="mb-3">
					<label for="street_name_ar" class="form-label">Name AR </label>
					<input required name="street_name_ar" type="text" class="form-control" id="street_name_ar">
				</div>
				<div class="mb-3">
					<label for="street_rate" class="form-label">Street Rate </label>
					<input required name="street_rate" type="number" class="form-control" id="street_rate">
				</div>

				<div class="mb-3">
					<label for="area_id" class="form-label"> Area </label>
					<select name="area_id" required class="form-select" aria-label="Default select example">
						<?php foreach($all_areas as $one_area){ ?>
						<option value="<?php echo $one_area->area_id ?>"> <?php echo $one_area->area_name_ar ?> </option>
						<?php } ?>
					</select>
				</div>
				<div class="mb-3">
					<label for="branch_id" class="form-label"> Branch </label>
					<select name="branch_id" required class="form-select" aria-label="Default select example">
						<?php foreach($all_branches as $one_branch){ ?>
						<option value="<?php echo $one_branch->branch_id ?>"> <?php echo $one_branch->branch_name_ar ?> </option>
						<?php } ?>
					</select>
				</div>
				<button type="submit" name="insert_street" class="btn btn-primary">Add Street </button>
			</form>
		</div>
		<div class="col">

		</div>
	</div>
</div>
<?php 
if(isset($_GET['selected_area'])){
	$selected_area = $_GET['selected_area'];
}else{
	$selected_area = "1";
}
$selected_area_object =  MD_Get_area_by_area_id($selected_area);


?>
<div class="container-fluid">
	<div class="row">
		<div class="col-2">
			<ul class="nav flex-column">
				<?php foreach($all_areas as $one_area){ ?>
				<li class="nav-item">
					<a style="color:black;text-align: center; <?php if($one_area->area_id == $selected_area){echo "background-color: #0d6efd;";} ?>"
						class="nav-link" aria-current="page"
						href="<?php echo home_url() . "/wp-admin/admin.php?page=view-all-streets&selected_area=" . $one_area->area_id ;  ?>"><?php echo $one_area->area_name_ar ;?></a>
				</li>
				<?php }  ?>
			</ul>
		</div>
		<div class="col">
			<div class="">
				<?php $streets  = MD_Get_street($selected_area); ?>
				<h1><?php echo $selected_area_object->area_name_ar ; ?></h1>
				<h1>---------------------------------------------</h1>
				<table class="table table-striped-columns">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Name AR</th>
							<th scope="col">Name EN</th>
							<th scope="col">Branch</th>
							<th scope="col"> Area </th>
							<th style="width:100px !important;" scope="col">Street Rate</th>
							<th scope="col">Actions </th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($streets as $one_street){ ?>
						<tr>
							<form method="post">
								<th scope="row"><?php echo $one_street->street_id  ;?></th>
								<td><input type="text" name="street_name_ar" value=" <?php echo  $one_street->street_name_ar ;?>"> </td>
								<td><input type="text" name="street_name_en" value=" <?php echo  $one_street->street_name_en ;?>"> </td>
								<td> <select name="branch_id"> <?php foreach($all_branches as $one_branch){ ?> <option
											<?php if($one_street->branch_id == $one_branch->branch_id){echo 'selected';} ?>
											value="<?php echo $one_branch->branch_id; ?>"><?php echo $one_branch->branch_name_ar; ?></option>
										<?php }  ?></select> </td>
								<td> <select name="area_id"> <?php foreach($all_areas as $one_area){ ?> <option
											<?php if($one_area->area_id == $one_street->area_id){echo 'selected';} ?>
											value="<?php echo $one_area->area_id; ?>"><?php echo $one_area->area_name_ar; ?></option>
										<?php }  ?></select> </td>
								<td style="width:100px !important;"><input name="street_rate" style="width:100px !important;"
										type="number" value="<?php echo $one_street->street_rate ;?>"> </td>
								<td><button name="update_street" value="<?php  echo $one_street->street_id  ?>" class="btn btn-success">
										<i class="bi bi-hand-thumbs-up"></i> </button> <button name="delete_street"
										value="<?php echo $one_street->street_id ; ?>" type="submit" class="btn btn-danger"><i
											class="bi bi-trash"></i></button></td>
							</form>

						</tr>
						<?php  } ?>
					</tbody>
				</table>

			</div>
		</div>
	</div>
</div>






<?php 
}