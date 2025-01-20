<?php
ob_start();
session_start();
$page_title = "Edit Appointments";
$page_name = "Appointments";
$fname = "appointments.php";
include('header.php');




// Check if 'id' is passed in the URL for the appointment to edit
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the existing appointment details from the database
    $query = "SELECT * FROM appointment WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            // Appointment found, populate the form
            $name = $row['name'];
            $contact_no = $row['contact_no'];
            $email = $row['email'];
            $about = $row['about'];
            $city = $row['city'];
            $timeslot = $row['timeslot'];
            $country = $row['country'];
        } else {
            $_SESSION['error_message'] = "Appointment not found.";
            header("Location: appointment.php");
            exit();
        }

        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['error_message'] = "Failed to prepare the SQL statement.";
        header("Location: appointment.php");
        exit();
    }
} else {
    $_SESSION['error_message'] = "Appointment ID is required.";
    header("Location: appointment.php");
    exit();
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate form inputs
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $contact_no = mysqli_real_escape_string($conn, $_POST['contact_no']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $about = mysqli_real_escape_string($conn, $_POST['about']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $timeslot = mysqli_real_escape_string($conn, $_POST['timeslot']);
    $country = mysqli_real_escape_string($conn, $_POST['country']);

    // Validate required fields
    if (empty($name) || empty($contact_no) || empty($email)) {
        $_SESSION['error_message'] = "Name, Contact No, and Email are required.";
        header("Location: edit_appointment.php?id=$id");
        exit();
    }

    // Update the appointment in the database using prepared statement
    $query = "UPDATE appointment SET name = ?, contact_no = ?, email = ?, about = ?, city = ?, timeslot = ?, country = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    
    if ($stmt) {
        // Bind parameters
        mysqli_stmt_bind_param($stmt, "sssssssi", $name, $contact_no, $email, $about, $city, $timeslot, $country, $id);

        // Execute query
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success_message'] = "Appointment updated successfully!";
            header("Location: appointment.php?s=success"); // Redirect to the appointment page on success
            exit();
        } else {
            $_SESSION['error_message'] = "Failed to update appointment.";
            header("Location: edit_appointment.php?id=$id");
            exit();
        }

        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['error_message'] = "Failed to prepare the SQL statement.";
        header("Location: edit_appointment.php?id=$id");
        exit();
    }
}
?>

<!-- Edit Appointment Form -->
<section class="content px-2">
    <div class="row">
        <div class="col-md-12">
            <h3>Edit Appointment</h3>
            <form method="POST">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" value="<?php echo $name; ?>" required>
                </div>
                <div class="form-group">
                    <label for="contact_no">Contact No</label>
                    <input type="text" name="contact_no" class="form-control" value="<?php echo $contact_no; ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" value="<?php echo $email; ?>" required>
                </div>
                <div class="form-group">
                    <label for="about">About</label>
                    <textarea name="about" class="form-control"><?php echo $about; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" name="city" class="form-control" value="<?php echo $city; ?>">
                </div>
                <div class="form-group">
                    <label for="timeslot">Timeslot</label>
                    <input type="text" name="timeslot" class="form-control" value="<?php echo $timeslot; ?>">
                </div>
                <div class="form-group">
                    <label for="country">Country</label>
                    <input type="text" name="country" class="form-control" value="<?php echo $country; ?>">
                </div>
                <button type="submit" class="btn btn-primary">Update Appointment</button>
            </form>
        </div>
    </div>
</section>

<?php include('footer.php'); ?>

<?php ob_end_flush(); ?>
