<?php 
$page_title = "Treatment";
$page_name = "Treatment";
$fname="treatments.php";
// Include header
include('header.php'); 

// Getting all records from the table
$result = mysqli_query($conn, "SELECT * FROM treatment");
?>
<?php
// Display success message if added successfully
if (isset($_GET['s']) && $_GET['s'] == 'success') {
    echo '<p style="color:green;">treatment successfully added!</p>';
}
?>
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
								<h3>Treatment </h3>
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
								<a href="add_treatments.php" class="btn  btn-primary">Add New Treatment</a>
							</div>
								<div class="table-responsive">
					  <table id="example1" class="table" cellspacing="0">
						<thead>
							<tr>
							<th>Action</th>
								<th>Nmae</th>
								<th>images</th>
								<th>Category_id</th>
								<th>About</th>
								<th>Address</th>
								<th>City</th>
								<th>Country</th>
								
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
							    
							<td><a href="edit_treatments.php?id=<?php echo $catid; ?>" class="text-warning"><i class="fa-light fa-pen-to-square"></i></a><a href="delete_treatments.php?id=<?php echo $catid; ?>" class="text-danger" onclick="return confirm('Are you sure you want to delete this treatments?');"><i class="fa-solid fa-trash-can"></i></a>  </td>
							<td><?php echo $ress['name']; ?></td>
							<td><img src="<?php echo $ress['image']; ?>" alt="Treatment Image" style="width: 100px; height: auto;"></td>
								<td><?php echo $ress['category_id']; ?></td>
								<td><?php echo $ress['about']; ?></td>
								<td><?php  echo $ress['address'];?></td>
								<td><?php  echo $ress['city'];?></td>
								<td><?php  echo $ress['country'];?></td>
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
							echo "<tr><td colspan='7'>No results found</td></tr>";
						}

						?>
							
						</tbody>
						
					  </table>
					</div>
						</div>
				</div>
				
		</section>

<?php 
// Include footer
include('footer.php'); 
?>
