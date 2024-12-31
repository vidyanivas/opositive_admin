<?php 
$page_title="Appointment";
$page_name="Appointment";
$fname="admins.php";
include('header.php'); 

//getting all records from table start here
$result = mysqli_query($conn, "Select * FROM exam_categories"); 
?>   
<!-- Main content -->
<!--<section class="content">
	<div class="row">
		<div class="col-md-9"> 9&nbsp;</div>
		<div class="col-md-3"> 3&nbsp;</div>
	</div>
</section>-->

<?php 
include('footer.php'); 
?> 