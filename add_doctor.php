<?php 
$page_title="Add New Doctor";
$page_name="Doctor";
$fname="doctors.php";
include('header.php'); 

//getting all records from table start here
$result = mysqli_query($conn, "Select * FROM exam_categories"); 
?>   
<!-- Main content -->
<section class="content px-2">				
	<div class="row">
		<div class="col-md-12">			
			<div class="mainTitle  mt-3 mb-20 d-flex align-items-center justify-content-between">
				<h3>Add New Doctor </h3>				
			</div>
				<div class="box">
						<div class="box-body formOuter" >
							<form>
								<div class="row">
										<div class="col-md-6">
											<div class="form-group">
													<label>Doctor  Name</label>
													<input type="text" class="form-control" placeholder="Doctor  Name">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
													<label>Speciality</label>
													<input type="text" class="form-control" placeholder="Speciality">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
													<label>Doctor's Contact No</label>
													<input type="tel" class="form-control" placeholder="Doctor's Contact No">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
													<label>Doctor's Email Address</label>
													<input type="email" class="form-control" placeholder="Doctor's Email Address">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
													<label>City</label>
													<input type="text" class="form-control" placeholder="City">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
													<label>Experience in year</label>
													<input type="text" class="form-control" placeholder="Experience in year">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
													<label>Image</label><br>
													<input type="file" >
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
													<label>About Doctor</label>
													<textarea placeholder="Description" class="form-control"></textarea>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
													<label>Doctor's Degree/Education</label><br>
													<input type="text" class="form-control" placeholder="Doctor's Degree/Education">
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
													<label>Active Status</label>
														<div class="form-check form-switch">
														  <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
														  <label class="form-check-label" for="flexSwitchCheckChecked">Checked switch checkbox input</label>
														</div>
											</div>
										</div>




								</div>
								
								<div class="text-end">
									<button type="submit" class="btn btn-secondary">Reset</button>
									<button type="submit" class="btn btn-primary">Save</button>
								</div>
							</form>
						</div>
				</div>
		</div>
	</div>
				
</section>

<?php 
include('footer.php'); 
?> 