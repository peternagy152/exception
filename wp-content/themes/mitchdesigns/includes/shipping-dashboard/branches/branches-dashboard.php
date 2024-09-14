<?php 
function branch_controller_callback(){

	if(isset($_POST['insert_gov'])){
		$data = [
			"gov_name_en" => $_POST['gov_name_en'] , 
			"gov_name_ar" => $_POST['gov_name_ar'] ,  

		];
		insert_government($data);
	}

	if(isset($_POST['update_gov'])){
		$data = [
			"gov_name_en" => $_POST['gov_name_en'] , 
			"gov_name_ar" => $_POST['gov_name_ar'] ,  
			"gov_id" => $_POST['update_gov']

		];
		update_government($data);
	} 

	if(isset($_POST['insert_branch'])){
		$data = [
			"branch_name_en" => $_POST['branch_name_en'] , 
			"branch_name_ar" => $_POST['branch_name_ar'] , 
			"address_en" => $_POST['address_en'] , 
			"address_ar" => $_POST['address_ar'] , 
			"branch_username" => $_POST['branch_username'] , 
			"branch_password" => $_POST['branch_password'] , 
		];
		insert_branch($data);
	}

	if(isset($_POST['update_branch'])){
		$data = [
			"branch_name_en" => $_POST['branch_name_en'] , 
			"branch_name_ar" => $_POST['branch_name_ar'] , 
			"address_en" => $_POST['address_en'] , 
			"address_ar" => $_POST['address_ar'] , 
			"branch_username" => $_POST['branch_username'] , 
			"branch_password" => $_POST['branch_password'] , 
			"branch_id" => $_POST['update_branch']
		] ;  

		update_branch($data);

	}

	if($_POST['delete_branch']){
		remove_branch($_POST['delete_branch']) ;
	}

	
        ?>

<div class="container mb-5">
	<div class="row">
		<div class="col">

			<form class="card" method="post">
				<h1> Add New Government</h1>
				<div class="mb-3">
					<label for="gov_name_en" class="form-label"> Name EN </label>
					<input name="gov_name_en" type="text" class="form-control" id="gov_name_en">
				</div>
				<div class="mb-3">
					<label for="gov_name_ar" class="form-label">Name AR </label>
					<input name="gov_name_ar" type="text" class="form-control" id="gov_name_ar">
				</div>
				<button type="submit" name="insert_gov" class="btn btn-primary">Add Government </button>
			</form>
		</div>
		<div class="col">

		</div>
	</div>
</div>


<div class="container mb-5">
	<h1> Governments </h1>
	<table class="table table-striped-columns">
		<thead>
			<tr>
				<th scope="col">#</th>
				<th scope="col">Name EN</th>
				<th scope="col">Name AR</th>
				<th scope="col">Update </th>
			</tr>
		</thead>
		<tbody>
			<?php $all_govs = MD_get_all_data_govs(); ?>
			<?php foreach($all_govs as $one_govs){ ?>
			<tr>
				<th scope="row"><?php echo $one_govs->gov_id  ;?></th>
				<form method="post">
					<td><input name="gov_name_en" style="width:90%;" type="text" value="<?php echo  $one_govs->gov_name_en  ;	?>">
					</td>
					<td> <input name="gov_name_ar" style="width:90%;" type="text" value="<?php echo  $one_govs->gov_name_ar ;?>">
					</td>
					<td><button name="update_gov" value="<?php echo $one_govs->gov_id ; ?>" class="btn btn-success"> <i
								class="bi bi-hand-thumbs-up"></i> </button></td>
				</form>
			</tr>
			<?php  } ?>
		</tbody>
	</table>

</div>

<style>
#customers {
	font-family: Arial, Helvetica, sans-serif;
	border-collapse: collapse;
	width: 100%;
}

#customers td,
#customers th {
	border: 1px solid #ddd;
	padding: 8px;
}

#customers tr:nth-child(even) {
	background-color: #f2f2f2;
}

#customers tr:hover {
	background-color: #ddd;
}

#customers th {
	padding-top: 12px;
	padding-bottom: 12px;
	text-align: left;
	background-color: #0d6efd;
	color: white;
}
</style>
<div class="container mb-5">
	<div class="row">
		<div class="col">
			<form method="post" class="card">
				<h1> Create New Branch</h1>
				<div class="mb-3">
					<label for="branch_name_en" class="form-label"> Name EN </label>
					<input name="branch_name_en" type="text" class="form-control" id="branch_name_en">
				</div>
				<div class="mb-3">
					<label for="branch_name_ar" class="form-label">Name AR </label>
					<input name="branch_name_ar" type="text" class="form-control" id="branch_name_ar">
				</div>
				<div class="mb-3">
					<label for="branch_address_en" class="form-label"> Address EN </label>
					<input name="address_en" type="text" class="form-control" id="branch_address_en">
				</div>
				<div class="mb-3">
					<label for="branch_address_ar" class="form-label">Address AR </label>
					<input name="address_ar" type="text" class="form-control" id="branch_address_ar">
				</div>
				<div class="mb-3">
					<label for="branch_username" class="form-label"> Username </label>
					<input name="branch_username" type="text" class="form-control" id="branch_username">
				</div>
				<div class="mb-3">
					<label for="branch_password" class="form-label"> Password </label>
					<input name="branch_password" type="text" class="form-control" id="branch_password">
				</div>
				<button name="insert_branch" type="submit" class="btn btn-primary">Add Branch</button>
			</form>
		</div>
		<div class="col">

		</div>
	</div>
</div>

<div class="section_branch">
	<h1> Branches </h1>

	<table id="customers" class="table table-striped-columns">
		<thead>
			<tr>
				<th scope="col">#</th>
				<th scope="col">Name EN</th>
				<th scope="col">Name AR</th>
				<th scope="col">Address EN </th>
				<th scope="col">Address AR </th>
				<th style="width:100px !important;" scope="col">Branch Username </th>
				<th style="width:100px !important;" scope="col">Branch Password </th>
				<th scope="col">Actions </th>
			</tr>
		</thead>
		<tbody>
			<?php $all_branches = get_all_branches(); ?>
			<?php foreach($all_branches as $one_branches){ ?>
			<tr>
				<th scope="row"><?php echo $one_branches->branch_id  ;?></th>
				<form method="post">
					<td> <input name="branch_name_en" type="text" value="<?php echo  $one_branches->branch_name_en  ;?> "> </td>
					<td> <input type="text" name="branch_name_ar" value="<?php echo  $one_branches->branch_name_ar ;?>"> </td>
					<td> <input type="text" name="address_en" value="<?php echo  $one_branches->address_en ;?>"> </td>
					<td> <input type="text" name="address_ar" value="<?php echo  $one_branches->address_ar ;?>"> </td>
					<td> <input type="text" name="branch_username" value="<?php echo  $one_branches->branch_username ;?>">
					</td>
					<td> <input type="text" name="branch_password" value="<?php echo  $one_branches->branch_password ;?>">
					</td>
					<td><button name="update_branch" value="<?php  echo $one_branches->branch_id  ?>" class="btn btn-success">
							<i class="bi bi-hand-thumbs-up"></i> </button> <button name="delete_branch"
							value="<?php echo $one_branches->branch_id ; ?>" type="submit" class="btn btn-danger"><i
								class="bi bi-trash"></i></button></td>
				</form>

			</tr>
			<?php  } ?>
		</tbody>
	</table>

</div>



<?php 
}