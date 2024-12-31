<?php
// Include database connection
include 'inc/db_connection.php'; // Ensure this file contains your database connection
$error='';
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    // Retrieve form inputs
    $email = trim($_POST['emailid']);
    $password = trim($_POST['password']);

    // Check if fields are empty
    if (empty($email) || empty($password)) {
        $error = "Email and Password are required!";
        //exit();
    }else{
		$hashedPassword = md5($password);
		// Prepare and execute the query
		$stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
		$stmt->bind_param("ss", $email, $hashedPassword);
		$stmt->execute();
		$result = $stmt->get_result();

		// Check if user exists
		if ($result->num_rows === 1) {
			$user = $result->fetch_assoc();

			// Set session variables
			$_SESSION['id'] = $user['id'];
			$_SESSION['first_name'] = $user['first_name'];
			$_SESSION['last_name'] = $user['last_name'];
			$_SESSION['email'] = $user['email'];
			$_SESSION['contact_no'] = $user['contact_no'];
			$_SESSION['role'] = $user['role'];

			// Redirect to dashboard
			header("Location: dashboard.php");
			exit();
		} else {
			$error = "Invalid email or password!";
		}

		$stmt->close();
		$conn->close();
	}
}
?>

<!DOCTYPE html>
<html lang="en" style="height:100%">
  
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../img/favicon.webp">

    <title>Login</title>
    
	<!-- Vendors Style-->
	<link rel="stylesheet" href="css/vendors_css.css">
	  
	<!-- Style-->  
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/custom.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" integrity="sha512-q3eWabyZPc1XTCmF+8/LuE1ozpg5xxn7iO89yfSOd5/oKvyqLngoNGsx8jq92Y8eXJ/IRxQbEC+FGSYxtk2oiw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  </head>

<body class="login" style="height:100%">
	
<section class="container-fluid">
		<div class="row align-items-center justify-content-md-center h-p100">	
			<div class="col-6">
				<div class="loginLeft">
					<div class="logo"><a href="#"><img src="img/logo.png" alt="logo"></a></div>
				<img src="img/illustration.svg" width="344px">
				<h3>A few more clicks to<br> sign in to your account.</h3>
				<p>Manage all your asset of Opositive Health in one place</p>
			</div>
			</div>
			<div class="col-6">
						<div class="loginRight">
								<h2>Admin Sign In</h2>
								<p style="color:red;"><?php echo $error; ?></p>
								<form  method="post" name="loginform">
									<div class="form-group">
											<input type="email" name="emailid" class="form-control" placeholder="Email">
									</div>
									<div class="form-group">
											<input type="password" name="password" class="form-control" placeholder="Password">
									</div>
									<div class="form-group">
											<div class="form-check">
											  <input type="checkbox" id="remember" class="filled-in" >
											  <label class="form-check-label" for="remember">Remember me</label>
											</div>
									</div>
									  <button type="submit" class="btn btn-primary mt-10">Login</button>
								</form>	
						</div>
			</div>
	</div>
</section>
	
	
<!-- Vendor JS -->
<script src="js/vendors.min.js"></script>
	
	

</body>

</html>
