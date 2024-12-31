<?php 
$page_title="Dashboard";
$page_name="Dashboard";
$fname="dashboard.php";
include('header.php'); 
$total_doctors = get_doctors_list();
$total_hospitals = get_hospital_list();
$total_appointments = get_appointment_list();
$total_conditions = get_conditions_list();
?>   
<!-- Main content -->
<section class="content">

	<div class="row">
		<div class="col-md-9">
			<div class="mainTitle mb-3 d-flex align-items-center justify-content-between">
				<h3>General Report </h3>
				<a href="" class="ml-auto flex reloadData">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="refresh-ccw" data-lucide="refresh-ccw" class="lucide lucide-refresh-ccw w-4 h-4 mr-3"><path d="M3 2v6h6"></path><path d="M21 12A9 9 0 006 5.3L3 8"></path><path d="M21 22v-6h-6"></path><path d="M3 12a9 9 0 0015 6.7l3-2.7"></path></svg> Reload Data
				</a>
			</div>
			
			<div class="row">
				<div class="col-md-3">
					<div class="dashboard-box zoom-in">
					<div class="dashboard-box-inner">
					<div class="icon-dashboard"><i class="fa-light fa-cart-shopping"></i></div>
					<h2><?php echo $total_doctors; ?></h2>
					<p>Total Doctor</p>
					</div>
					</div>
				</div>
				
				<div class="col-md-3">
					<div class="dashboard-box zoom-in">
					<div class="dashboard-box-inner">
					<div class="icon-dashboard"><i class="fa-light fa-hospital"></i></div>
					<h2><?php echo $total_hospitals; ?></h2>
					<p>Total Hospital</p>
					</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="dashboard-box zoom-in">
					<div class="dashboard-box-inner">
					<div class="icon-dashboard"><i class="fa-light fa-user-doctor"></i></div>
					<h2><?php echo $total_appointments; ?></h2>
					<p>Total  Appointment</p>
					</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="dashboard-box zoom-in">
					<div class="dashboard-box-inner">
					<div class="icon-dashboard"><i class="fa-light fa-user"></i></div>
					<h2><?php echo $total_conditions; ?></h2>
					<p>Total Condition</p>
					</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php 
include('footer.php'); 
?> 