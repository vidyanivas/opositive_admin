<?php 
$page_title="Hospital";
$page_name="Hospital";
$fname="hospitals.php";
include('header.php'); 

//getting all records from table start here
$result = mysqli_query($conn, "Select * FROM hospital"); 
?>   
<!-- Main content -->
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
								<a href="add_hospital.php" class="btn  btn-primary">Add New category</a>
							</div>
								<div class="table-responsive">
					  <table id="example1" class="table" cellspacing="0">
						<thead>
							<tr>
								<th>Action</th>
								<th>Images</th>
								<th>Hospital Name</th>
								<th>Contact No</th>
								<th>Email</th>								
								<th>Status</th>
								<th>About</th>
								<th>City</th>
								<th>ADDED AT</th>
							</tr>
						</thead>
						<tbody>
						<?php if ($result && mysqli_num_rows($result) > 0){ ?>
							<?php while($ress = mysqli_fetch_array($result)){ 
								  $catid = $ress['id'];
							?>
							<tr>
								<td><a href="edit_hospital.php?id=<?php echo $catid; ?>" class="text-warning"><i class="fa-light fa-pen-to-square"></i></a> </td>
								<td><div class="treatmentImg"><img src="<?php echo $ress['image']; ?>"></div> </td>
								<td><?php echo $ress['name']; ?></td>
								<td><?php echo $ress['contact_no']; ?></td>
								<td><?php echo $ress['email_address']; ?></td>
								
								<td>
										<div class="form-check form-switch">
										  <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" <?php if($ress['status']=='active'){ ?>checked<?php } ?>>
										  <label class="form-check-label" for="flexSwitchCheckChecked">Checked switch checkbox input</label>
										</div>


								</td>
								<td> <?php echo $ress['about']; ?> </td>
								<td><?php echo $ress['city']; ?></td>
								<td><?php echo $ress['created_at']; ?></td>
							</tr>
							<?php }
						
						}else{
							echo "<tr><td colspan='9'>No results found</td></tr>";
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