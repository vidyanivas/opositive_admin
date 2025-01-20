<?php 
ob_start();  // Start output buffering
$page_title = "Add New hospital";
$page_name = "Hospital";
$fname = "hospital.php";
include('header.php'); 
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form inputs and fix the variable names
    $name = trim($_POST['name']) ? trim($_POST['name']) : '';
    
    $about = trim($_POST['about']) ? trim($_POST['about']) : '';
    $image = trim($_FILES['image']['name']) ? trim($_FILES['image']['name']) : '';
    $address = trim($_POST['address']) ? trim($_POST['address']) : '';
    $city = trim($_POST['city']) ? trim($_POST['city']) : '';
    $country = trim($_POST['country']) ? trim($_POST['country']) : '';
    $contact_no = trim($_POST['contact_no']) ? trim($_POST['contact_no']) : '';
    $email_address = trim($_POST['email_address']) ? trim($_POST['email_address']) : '';
    
    // Check if fields are empty
    if (empty($name) || empty($about) || empty($image) || empty($address) || empty($city) || empty($country) || empty($contact_no) || empty($email_address)) {
        $error = "All fields are required!";
    } else {
        
        // Generate a unique slug
        function generateSlug($title) {
            $slug = strtolower(trim($title));
            $slug = preg_replace('/[^a-z0-9-]+/', '-', $slug);
            return $slug;
        }

        $slug = generateSlug($category_id);

        // Check if the slug already exists in the database (use backticks for reserved word)
        $checkSlugQuery = "SELECT COUNT(*) FROM `hospital` WHERE slug = ?";
        $stmt = $conn->prepare($checkSlugQuery);
        $stmt->bind_param("s", $slug);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count > 0) {
            // If the slug already exists, append a number to make it unique
            $slug = $slug . '-' . uniqid();
        }

        // Function to generate random filename
        function generateRandomFilename($originalFileName) {
            $extension = pathinfo($originalFileName, PATHINFO_EXTENSION);
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'tif', 'webp'];
            if (!in_array(strtolower($extension), $allowedExtensions)) {
                return false; // Invalid extension
            }

            $randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);  // Random 8-character string
            $timestamp = date('YmdHis'); // Timestamp format YYYYMMDDHHMMSS

            return $randomString . $timestamp . '.' . $extension;
        }

        // Handle the image upload
        $image_path = "";
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            if ($_FILES['image']['size'] > 5 * 1024 * 1024) {
                $error = "The image size must be less than 5MB.";
            } else {
                $image_name = $_FILES['image']['name'];
                $new_image_name = generateRandomFilename($image_name);

                if ($new_image_name === false) {
                    $error = "Invalid image file type.";
                } else {
                    $upload_dir = 'hospital/';
                    if (!file_exists($upload_dir)) {
                        mkdir($upload_dir, 0777, true);  // Create the folder if it doesn't exist
                    }

                    $image_tmp = $_FILES['image']['tmp_name'];
                    $image_path = $upload_dir . $new_image_name;

                    if (!move_uploaded_file($image_tmp, $image_path)) {
                        $error = "Failed to upload image.";
                    }
                }
            }
        }

        // Default status value
        $status = isset($_POST['status']) ? 1 : 0;
       
        if (empty($error)) {
            // Prepare and execute the query
            $stmt = $conn->prepare("INSERT INTO `hospital` (`name`, `about`, `slug`, `image`, `address`, `city`, `country`, `contact_no`,`email_address`, `status`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,?)");
            $stmt->bind_param("sssssissss", $name, $about, $slug, $image_path, $address, $city, $country, $contact_no,  $email_address,$status);
            $stmt->execute();
            
            // Set the success message and redirect to the conditions page
            $_SESSION['success_message'] = "Hospital added successfully!";
            header("Location: hospital.php?s=success");
            exit();
        }
    }
}

// Getting all records from the table
$result = mysqli_query($conn, "SELECT * FROM exam_categories"); 
?>   

<!-- Main content -->
<section class="content px-2">				
    <div class="row">
        <div class="col-md-12">			
            <div class="mainTitle mt-3 mb-20 d-flex align-items-center justify-content-between">
                <h3>Add New Hospital</h3>				
            </div>
            <div class="box">
                <div class="box-body formOuter">
                    <p style="color:red;"><?php echo $error; ?></p>
                    <form name="add_blog" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" placeholder=" name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>About</label>
                                    <textarea name="about" class="form-control" placeholder="about" required></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Image</label><br>
                                    <input type="file" name="image" accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff,.tif,.webp" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" name="address" class="form-control" placeholder="address" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>city</label>
                                    <input type="text" name="city" class="form-control" placeholder="city" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Country</label>
                                    <input type="text" name="country" class="form-control" placeholder="country" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Contact_no</label>
                                    <input type="text" name="contact_no" class="form-control" placeholder="Contact" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email_address</label>
                                    <input type="text" name="email_address" class="form-control" placeholder="email_address" required>
                                </div>
                            </div>
                            
                            
                            
                            
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Active Status</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" name="status" checked>
                                        <label class="form-check-label" for="flexSwitchCheckChecked">Condition Active</label>
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






