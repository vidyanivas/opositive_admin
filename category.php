<?php 
$page_title="Dashboard";
$page_name="Dashboard";
include('header.php'); 
$total_doctors = get_doctors_list();
$total_hospitals = get_hospital_list();
$total_appointments = get_appointment_list();
$total_conditions = get_conditions_list();

//getting all records from table start here
$result = mysqli_query($conn, "Select * FROM exam_categories"); 
?>   
<?php
// Display success message if added successfully
if (isset($_GET['s']) && $_GET['s'] == 'success') {
    echo '<p style="color:green;">Conditions successfully added!</p>';
}
?>

<!-- Main content -->
<!--<section class="content">
	<div class="row">
		<div class="col-md-9"> 9&nbsp;</div>
		<div class="col-md-3"> 3&nbsp;</div>
	</div>
</section>-->

<section class="content px-2">
				
				<div class="row">
						<div class="col-md-12">
							<div class="filterOuter">
									<h5>Filter</h5>
									<div class="filterinner d-flex align-items-center">
											<select class="selectpicker">
													<option>Status</option><option>Active</option><option>In Active</option>
											</select>
											<div class="serchBar">
													<input type="text" class="form-control" placeholder="Global Search">
													<i class="fa-light fa-magnifying-glass"></i>
											</div>
									</div>
							</div>
							<div class="mainTitle innerTitle mt-3 d-flex align-items-center justify-content-between">
								<h3>category List </h3>
								<a href="#" class="btn  ms-auto filterBtn"><i class="fa-light fa-print"></i> Print</a>
								<div class="dropdown mx-2">
								  <button class="btn filterBtn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
								    <i class="fa-light fa-file-lines"></i> Export
								  </button>
								  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
								    <li><a class="dropdown-item" href="#"><i class="fa-light fa-file-lines"></i> Export CSV</a></li>
								    <li><a class="dropdown-item" href="#"><i class="fa-light fa-file-lines"></i> Export JSON</a></li>
								    <li><a class="dropdown-item" href="#"><i class="fa-light fa-file-lines"></i> Export XLSX</a></li>
								    <li><a class="dropdown-item" href="#"><i class="fa-light fa-file-lines"></i> Export HTML</a></li>
								  </ul>
								</div>
								<a href="add_category.php" class="btn  btn-primary">Add New category</a>
							</div>
								<div class="table-responsive">
					  <table id="example1" class="table" cellspacing="0">
						<thead>
							<tr>
								<th>Action</th>
								<th>Exam_category_name</th>
								<th>Iimage</th>								
								<th>Description</th>
								<th>Status</th>
							    <th>ADDED AT</th>
							</tr>
						</thead>
						<tbody>
						<?php if ($result && mysqli_num_rows($result) > 0){ ?>
							<?php while($ress = mysqli_fetch_array($result)){ 
								  $catid = $ress['id'];
							?>
							<tr>
								<td><a href="edit_category.php?id=<?php echo $catid; ?>" class="text-warning"><i class="fa-light fa-pen-to-square"></i></a><a href="delete_category.php?id=<?php echo $catid; ?>" class="text-danger" onclick="return confirm('Are you sure you want to delete this category');"><i class="fa-solid fa-trash-can"></i></a> </td>
								<td><?php echo $ress['exam_category_name']; ?></td>
								<td><img src="<?php echo $ress['image']; ?>" alt="Category Image" style="width: 100px; height: auto;"></td>
								<td><?php echo $ress['description']; ?></td>
								
								
								<td>
									<div class="form-check form-switch">
									  <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" <?php if($ress['status']=='active'){ ?>checked<?php } ?>>
									  <label class="form-check-label" for="flexSwitchCheckChecked">Checked switch checkbox input</label>
									</div>
								</td>
								<td>16-03-2023</td>
								
								
								
							</tr>
						<?php }
						
						}else{
							echo "<tr><td colspan='5'>No results found</td></tr>";
						}

						?>
							
							
						</tbody>
						
					  </table>
					</div>
						</div>
				</div>
				
		</section>

<?php 
include('footer.php'); 
?> 