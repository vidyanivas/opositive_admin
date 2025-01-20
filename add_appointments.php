<?php 
ob_start();  // Start output buffering at the very beginning of the script

session_start(); // Start session to use session variables

$page_title = "Add Appointment";
$page_name = "Add Appointment";
$fname="hospital.php";
include('header.php'); // Include the header


// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate form inputs
    $name =mysqli_real_escape_string ($conn, $_POST['name']);
    $contact_no = mysqli_real_escape_string($conn, $_POST['contact_no']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $about = mysqli_real_escape_string($conn, $_POST['about']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $timeslot = mysqli_real_escape_string($conn, $_POST['timeslot']);
    $country = mysqli_real_escape_string($conn, $_POST['country']);
    
    // Validate required fields
    if (empty($name) || empty($contact_no) || empty($email)) {
        $_SESSION['error_message'] = "Name, Contact No, and Email are required.";
        header("Location: add_appointment.php"); // Redirect back to the form
        exit();
    }

    // Insert into the database using prepared statement
    $query = "INSERT INTO appointment (name, contact_no, email, about, city, timeslot, country) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    
    if ($stmt) {
        // Bind parameters
        mysqli_stmt_bind_param($stmt, "sssssss", $name, $contact_no, $email, $about, $city, $timeslot, $country);
        
        // Execute query
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success_message'] = "Appointment added successfully!";
            header("Location: appointments.php?s=success"); // Redirect to appointment page on success
            exit();
        } else {
            $_SESSION['error_message'] = "Failed to add appointment.";
            header("Location: add_appointments.php"); // Redirect back on failure
            exit();
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['error_message'] = "Failed to prepare the SQL statement.";
        header("Location: add_appointments.php"); // Redirect back on failure
        exit();
    }
}
?>

<!-- Add Appointment Form -->
<section class="content px-2">
    <div class="row">
        <div class="col-md-12">
            <h3>Add New Appointment</h3>
            <form method="POST">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="contact_no">Contact No</label>
                    <input type="text" name="contact_no" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="about">About</label>
                    <textarea name="about" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" name="city" class="form-control">
                </div>
                <div class="form-group">
                    <label for="timeslot">Timeslot</label>
                    <input type="text" name="timeslot" class="form-control">
                </div>
                <div class="form-group">
                    <label for="country">Country</label>
                    <input type="text" name="country" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Add Appointment</button>
            </form>
        </div>
    </div>
</section>

<?php include('footer.php'); // Include footer ?>


