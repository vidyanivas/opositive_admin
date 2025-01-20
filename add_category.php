<?php 
ob_start();  // Start output buffering
$page_title="Add New Category";
$page_name="Category";
$fname="category.php";
include('header.php'); 
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form inputs
    $exam_category_name = trim($_POST['exam_category_name']) ? trim($_POST['exam_category_name']) : '';
    $description = trim($_POST['description']) ? trim($_POST['description']) : '';
    
    // Check if fields are empty
    if (empty($titexam_category_namele) || empty($description)) {
        $error = "All fields are required!";
    } else {
        
        // Generate a unique slug
        function generateSlug($title) {
            $slug = strtolower(trim($title));
            $slug = preg_replace('/[^a-z0-9-]+/', '-', $slug);
            return $slug;
        }

        $slug = generateSlug($title);

        // Check if the slug already exists in the database
        $checkSlugQuery = "SELECT COUNT(*) FROM category WHERE slug = ?";
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
            // Extract the file extension from the original filename
            $extension = pathinfo($originalFileName, PATHINFO_EXTENSION);

            // Validate the extension (allow only the supported image types)
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'tif', 'webp'];
            if (!in_array(strtolower($extension), $allowedExtensions)) {
                return false; // Invalid extension
            }

            // Generate a random string for uniqueness
            $randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);  // Random 8-character string
            $timestamp = date('YmdHis'); // Timestamp format YYYYMMDDHHMMSS

            // Return the random filename with the original extension
            return $randomString . $timestamp . '.' . $extension;
        }

        // Handle the image upload
        $image_path = "";
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            // Check file size (max 5MB)
            if ($_FILES['image']['size'] > 5 * 1024 * 1024) {
                $error = "The image size must be less than 5MB.";
            } else {
                // Get the original file name and extension
                $image_name = $_FILES['image']['name'];

                // Generate a random filename while preserving the original extension
                $new_image_name = generateRandomFilename($image_name);

                if ($new_image_name === false) {
                    $error = "Invalid image file type.";
                } else {
                    // Set the upload directory
                    $upload_dir = 'category/';

                    // Ensure the 'blogs' folder exists
                    if (!file_exists($upload_dir)) {
                        mkdir($upload_dir, 0777, true);  // Create the folder if it doesn't exist
                    }

                    // Get the temporary file path
                    $image_tmp = $_FILES['image']['tmp_name'];

                    // Set the path for the image
                    $image_path = $upload_dir . $new_image_name;

                    // Move the uploaded file to the target folder
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
            $stmt = $conn->prepare("INSERT INTO exam_categories (``, `exam_category_name`, `image`, `description`, `status`) VALUES (?, ?, ?, ?, ?)");
            
            $stmt->bind_param("sssis", $exam_category_name, $description, $status, $image_path);
            $stmt->execute();
            // Set the success message and redirect to the doctors page
             $_SESSION['success_message'] = "Category added successfully!";
            header("Location: category.php?s=success");
            exit();
        }
    }
}

// Getting all records from the table start here
$result = mysqli_query($conn, "SELECT * FROM exam_categories"); 
?>   

<!-- Main content -->
<section class="content px-2">				
    <div class="row">
        <div class="col-md-12">			
            <div class="mainTitle mt-3 mb-20 d-flex align-items-center justify-content-between">
                <h3>Add New Blog</h3>				
            </div>
            <div class="box">
                <div class="box-body formOuter">
                    <p style="color:red;"><?php echo $error; ?></p>
                    <form name="add_blog" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Exam_category_name</label>
                                    <input type="text" name="exam_category_name" class="form-control" placeholder="exam_category_name" required>
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
                                    <label>status</label>
                                    <input type="text" name="status" class="form-control" placeholder="status" required>
                                </div>
                            </div>
							<div class="col-md-12">
                                <div class="form-group">
                                    <label>Active Status</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" name="status" checked>
                                        <label class="form-check-label" for="flexSwitchCheckChecked">Doctor Active</label>
                                    </div>
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
