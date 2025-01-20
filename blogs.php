<?php 
$page_title="Blogs";
$page_name="Blogs";
$fname="blogs.php";
include('header.php'); 

//getting all records from table start here
$result = mysqli_query($conn, "Select * FROM blogs"); 
?>   
<?php
// Display success message if added successfully
if (isset($_GET['s']) && $_GET['s'] == 'success') {
    echo '<p style="color:green;">blogs successfully added!</p>';
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
								<h3>blogs List </h3>
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
								<a href="add_blogs.php" class="btn  btn-primary">Add New Blog</a>
							</div>
								<div class="table-responsive">
					  <table id="example1" class="table" cellspacing="0">
						<thead>
							<tr>
								<th>Action</th>
							    <th>Title</th>
								<th>Image</th>
								<th>content</th>								
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
							    <td><a href="edit_blogs.php?id=<?php echo $catid; ?>" class="text-warning"><i class="fa-light fa-pen-to-square"></i></a> <a href="delete_blogs.php?id=<?php echo $catid; ?>" class="text-danger" onclick="return confirm('Are you sure you want to delete this blogs?');"><i class="fa-solid fa-trash-can"></i></a> </td>   
								<td><?php echo  $ress['title'];?>
								
								<td><img src="<?php echo $ress['image']; ?>" alt="blogs Image" style="width: 100px; height: auto;"></td>
								<td><?php echo $ress['content']; ?></td>
								 <td><div class='form-check form-switch'><input class='form-check-input' type='checkbox' role='switch' id='flexSwitchCheckChecked' " . ($row['status'] == 'active' ? 'checked' : '') . "><label class='form-check-label' for='flexSwitchCheckChecked'>Active</label></div></td>
								<td>16-03-2023</td>
								
								
								
							</tr>
						<?php }
						
						}else{
							echo "<tr><td colspan='4'>No results found</td></tr>";
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