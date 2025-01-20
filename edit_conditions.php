<?php 
ob_start();  // Start output buffering
$page_title = "Edit Condition";
$page_name = "Condition";
$fname = "Conditions.php";
include('header.php'); 
$error = '';

// Check if 'id' is provided in the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the existing condition data from the database
    $stmt = $conn->prepare("SELECT * FROM `condition` WHERE `id` = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $condition = $result->fetch_assoc();
    } else {
        $error = "Condition not found!";
    }
} else {
    $error = "Invalid condition ID!";
}

// Handle form submission for updating the condition
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form inputs and fix the variable names
    $name = trim($_POST['name']) ? trim($_POST['name']) : '';
    $category_id = trim($_POST['category_id']) ? trim($_POST['category_id']) : '';
    $image = $_FILES['image']['name'] ? $_FILES['image']['name'] : ''; // Allow updating image
    $about = trim($_POST['about']) ? trim($_POST['about']) : '';
    $address = trim($_POST['address']) ? trim($_POST['address']) : '';
    $city = trim($_POST['city']) ? trim($_POST['city']) : '';
    $country = trim($_POST['country']) ? trim($_POST['country']) : '';
    
    // Check if fields are empty
    if (empty($name) || empty($category_id) || empty($about) || empty($address) || empty($city) || empty($country)) {
        $error = "All fields are required!";
    } else {
        // Generate a unique slug
        function generateSlug($title) {
            $slug = strtolower(trim($title));
            $slug = preg_replace('/[^a-z0-9-]+/', '-', $slug);
            return $slug;
        }

        $slug = generateSlug($category_id);

        // Handle the image upload if a new image is uploaded
        if (!empty($image)) {
            $image_path = "";
            if ($_FILES['image']['error'] == 0) {
                if ($_FILES['image']['size'] > 5 * 1024 * 1024) {
                    $error = "The image size must be less than 5MB.";
                } else {
                    $image_name = $_FILES['image']['name'];
                    $new_image_name = generateRandomFilename($image_name);

                    if ($new_image_name === false) {
                        $error = "Invalid image file type.";
                    } else {
                        $upload_dir = 'condition/';
                        if (!file_exists($upload_dir)) {
                            mkdir($upload_dir, 0777, true);
                        }

                        $image_tmp = $_FILES['image']['tmp_name'];
                        $image_path = $upload_dir . $new_image_name;

                        if (!move_uploaded_file($image_tmp, $image_path)) {
                            $error = "Failed to upload image.";
                        }
                    }
                }
            }
        } else {
            // Keep the existing image if no new image is uploaded
            $image_path = $condition['image'];
        }

        $status = isset($_POST['status']) ? 1 : 0;

        if (empty($error)) {
            // Update the condition in the database
            $stmt = $conn->prepare("UPDATE `condition` SET `name` = ?, `category_id` = ?, `slug` = ?, `image` = ?, `about` = ?, `address` = ?, `city` = ?, `country` = ?, `status` = ? WHERE `id` = ?");
            $stmt->bind_param("ssssssssii", $name, $category_id, $slug, $image_path, $about, $address, $city, $country, $status, $id);
            $stmt->execute();

            // Set the success message and redirect to the conditions page
            $_SESSION['success_message'] = "Condition updated successfully!";
            header("Location: conditions.php?s=success");
            exit();
        }
    }
}

// Get all categories for the category dropdown
$categories_result = mysqli_query($conn, "SELECT * FROM exam_categories"); 
?>   

<section class="content px-2">
    <div class="row">
        <div class="col-md-12">            
            <div class="mainTitle mt-3 mb-20 d-flex align-items-center justify-content-between">
                <h3>Edit Condition</h3>                
            </div>
            <div class="box">
                <div class="box-body formOuter">
                    <p style="color:red;"><?php echo $error; ?></p>
                    <form name="edit_condition" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($condition['name']); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Category ID</label>
                                    <input type="text" name="category_id" class="form-control" value="<?php echo htmlspecialchars($condition['category_id']); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Image</label><br>
                                    <input type="file" name="image" accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff,.tif,.webp">
                                    <img src="<?php echo htmlspecialchars($condition['image']); ?>" alt="Current Image" width="100">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>About</label>
                                    <textarea name="about" class="form-control" required><?php echo htmlspecialchars($condition['about']); ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" name="address" class="form-control" value="<?php echo htmlspecialchars($condition['address']); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>City</label>
                                    <input type="text" name="city" class="form-control" value="<?php echo htmlspecialchars($condition['city']); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Country</label>
                                    <input type="text" name="country" class="form-control" value="<?php echo htmlspecialchars($condition['country']); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Active Status</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" name="status" <?php echo ($condition['status'] == 1) ? 'checked' : ''; ?>>
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
