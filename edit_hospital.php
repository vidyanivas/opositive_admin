<?php 
ob_start();  
$page_title = "Edit Hospital";
$page_name = "Hospital";
$fname = "hospital.php";
include('header.php'); 
$error = '';

if (isset($_GET['id'])) {
    $hospital_id = (int)$_GET['id'];

    // Retrieve the hospital details from the database
    $stmt = $conn->prepare("SELECT * FROM `hospital` WHERE `id` = ?");
    $stmt->bind_param("i", $hospital_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $hospital = $result->fetch_assoc();
    $stmt->close();

    if (!$hospital) {
        $error = "Hospital not found!";
    }
} else {
    $error = "Invalid hospital ID!";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form inputs
    $name = trim($_POST['name']) ?: '';
    $about = trim($_POST['about']) ?: '';
    $image = trim($_FILES['image']['name']) ?: '';
    $address = trim($_POST['address']) ?: '';
    $city = trim($_POST['city']) ?: '';
    $country = trim($_POST['country']) ?: '';
    $contact_no = trim($_POST['contact_no']) ?: '';
    $email_address = trim($_POST['email_address']) ?: '';
    $status = isset($_POST['status']) ? 1 : 0;

    if (empty($name) || empty($about) || empty($address) || empty($city) || empty($country) || empty($contact_no) || empty($email_address)) {
        $error = "All fields are required!";
    } else {
        // Handle image upload logic as in the original script
        // If a new image is uploaded, process it, else keep the current one

        $image_path = $hospital['image'];  // Keep current image if no new one

        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            // Same image upload code as in the original script (adjust accordingly)
            // ...

            $image_path = $new_image_name;
        }

        if (empty($error)) {
            // Update hospital in the database
            $stmt = $conn->prepare("UPDATE `hospital` SET `name` = ?, `about` = ?, `image` = ?, `address` = ?, `city` = ?, `country` = ?, `contact_no` = ?, `email_address` = ?, `status` = ? WHERE `id` = ?");
            $stmt->bind_param("ssssssssii", $name, $about, $image_path, $address, $city, $country, $contact_no, $email_address, $status, $hospital_id);
            $stmt->execute();
            $stmt->close();

            $_SESSION['success_message'] = "Hospital updated successfully!";
            header("Location: hospital.php?s=success");
            exit();
        }
    }
}

?>

<!-- Edit Form -->
<section class="content px-2">				
    <div class="row">
        <div class="col-md-12">			
            <div class="mainTitle mt-3 mb-20 d-flex align-items-center justify-content-between">
                <h3>Edit Hospital</h3>				
            </div>
            <div class="box">
                <div class="box-body formOuter">
                    <p style="color:red;"><?php echo $error; ?></p>
                    <form name="edit_hospital" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" value="<?php echo $hospital['name']; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>About</label>
                                    <textarea name="about" class="form-control" required><?php echo $hospital['about']; ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Image</label><br>
                                    <input type="file" name="image" accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff,.tif,.webp">
                                    <p>Current Image: <img src="<?php echo $hospital['image']; ?>" width="100px"></p>
                                </div>
                            </div>
                            <!-- Add remaining fields similarly, pre-populate with existing values -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" name="address" class="form-control" value="<?php echo $hospital['address']; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>City</label>
                                    <input type="text" name="city" class="form-control" value="<?php echo $hospital['city']; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Country</label>
                                    <input type="text" name="country" class="form-control" value="<?php echo $hospital['country']; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Contact_no</label>
                                    <input type="text" name="contact_no" class="form-control" value="<?php echo $hospital['contact_no']; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email_address</label>
                                    <input type="text" name="email_address" class="form-control" value="<?php echo $hospital['email_address']; ?>" required>
                                </div>
                            </div>
                            
                            
                            
                            
                            
                            
                            
                            
                            <!-- More fields here -->

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Active Status</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" name="status" <?php echo $hospital['status'] ? 'checked' : ''; ?>>
                                        <label class="form-check-label">Condition Active</label>
                                    </div>
                                </div>
                            </div>                         
                        </div>
                        <div class="text-end">
                            <button type="reset" class="btn btn-secondary">Reset</button>
                            <button type="submit" class="btn btn-primary">Update</button>
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
