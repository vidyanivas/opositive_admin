<?php 
ob_start(); // Start output buffering
$page_title="Add New Doctor";
$page_name="Doctor";
$fname="doctors.php";
include('header.php'); 
$error='';

function generateRandomFilename() {
    $randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8); // Random 8-character string
    $timestamp = date('YmdHis'); // YYYYMMDDHHMMSS format
    return $randomString . $timestamp . '.jpg'; // Random filename with timestamp
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form inputs
    $doctor_name = trim($_POST['doctor_name']) ? trim($_POST['doctor_name']) : '';
    $speciality = trim($_POST['speciality']) ? trim($_POST['speciality']) : '';
    $contact_no = isset($_POST['contact_no']) ? trim($_POST['contact_no']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $city = isset($_POST['city']) ? trim($_POST['city']) : '';
    $experience = isset($_POST['experience']) ? trim($_POST['experience']) : '';
    $education = isset($_POST['education']) ? trim($_POST['education']) : '';
    $about = isset($_POST['about']) ? trim($_POST['about']) : '';

    // Check if fields are empty
    if (empty($doctor_name) || empty($speciality) || empty($contact_no) || empty($email) || empty($city)) {
        $error = "All fields are required!";
    } else {
        // Handle the image upload
        $image_path = "";
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $image_name = $_FILES['image']['name'];
            $image_tmp = $_FILES['image']['tmp_name'];

            // Validate file size (max 5MB)
            if ($_FILES['image']['size'] > 5 * 1024 * 1024) {
                $error = "The image size must be less than 5MB.";
            }

            // Validate allowed image extensions
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'tif', 'webp'];
            $extension = pathinfo($image_name, PATHINFO_EXTENSION);
            if (!in_array(strtolower($extension), $allowedExtensions)) {
                $error = "Invalid image file type. Allowed types: jpg, jpeg, png, gif, bmp, tiff, tif, webp.";
            } else {
                // Generate a random filename and set the image path
                $image_path = 'doctor/' . generateRandomFilename();
                move_uploaded_file($image_tmp, $image_path); // Move file to the doctors folder
            }
        }

        // Default status value
        $status = isset($_POST['status']) ? 1 : 0;

        // Prepare and execute the query
        if (empty($error)) {
            $stmt = $conn->prepare("INSERT INTO doctor (`name`,`speciality`,`contact_no`,`email_address`,`city`,`exp_in_year`,`about`,`image`,`education`,`status`) VALUES (?,?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param("sssssssssi", $doctor_name, $speciality, $contact_no, $email, $city, $experience, $about, $image_path, $education, $status);
            $stmt->execute();
            // Set the success message and redirect to the doctors page
			$_SESSION['success_message'] = "Doctor added successfully!";
			header("Location: doctors.php?s=success");
            exit();
        }
    }
}

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
                    <p style="color:red;"><?php echo $error; ?></p>
                        <form name="add_doctor" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <label>Doctor  Name</label>
                                            <input type="text" name="doctor_name" class="form-control" placeholder="Doctor  Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <label>Speciality</label>
                                            <input type="text" name="speciality" class="form-control" placeholder="Speciality">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <label>Doctor's Contact No</label>
                                            <input type="text" name="contact_no" class="form-control" placeholder="Doctor's Contact No">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <label>Doctor's Email Address</label>
                                            <input type="text" name="email" class="form-control" placeholder="Doctor's Email Address">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <label>City</label>
                                            <input type="text" name="city" class="form-control" placeholder="City">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <label>Experience in year</label>
                                            <input type="text" name="experience" class="form-control" placeholder="Experience in year">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <label>Image</label><br>
                                            <input type="file" name="image" accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff,.tif,.webp">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <label>About Doctor</label>
                                            <textarea placeholder="Description" class="form-control" name="about"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <label>Doctor's Degree/Education</label><br>
                                            <input type="text" name="education" class="form-control" placeholder="Doctor's Degree/Education">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                            <label>Active Status</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked name="status">
                                                <label class="form-check-label" for="flexSwitchCheckChecked">Doctor Active</label>
                                            </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="reset" class="btn btn-secondary">Reset</button>
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