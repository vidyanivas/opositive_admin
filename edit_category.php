<?php
ob_start();  // Start output buffering
session_start(); // Ensure session is started
$page_title="Edit Category";
$page_name="Category";
$fname="category.php";
include('header.php');
$error = '';

// Ensure the category ID is passed in the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $category_id = $_GET['id'];

    // Fetch the existing category details from the database
    $query = "SELECT * FROM exam_categories WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if the category exists
    if ($result->num_rows > 0) {
        $category = $result->fetch_assoc();
        $exam_category_name = $category['exam_category_name'];
        $description = $category['description'];

        $image_path = $category['image'];
        $status = $category['status'];
    } else {
        $error = "Category not found.";
    }

    $stmt->close();
} else {
    $error = "Invalid category ID.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form inputs
    $exam_category_name = trim($_POST['exam_category_name']) ? trim($_POST['exam_category_name']) : '';
    $description = trim($_POST['description']) ? trim($_POST['description']) : '';
    $status = isset($_POST['status']) ? 1 : 0;

    // Check if fields are empty
    if (empty($exam_category_name) || empty($description)) {
        $error = "All fields are required!";
    } else {
        // Generate a unique slug
        function generateSlug($title) {
            $slug = strtolower(trim($title));
            $slug = preg_replace('/[^a-z0-9-]+/', '-', $slug);
            return $slug;
        }

        $slug = generateSlug($exam_category_name);

        // Check if the slug already exists and is not the current one
        if ($slug !== $category['slug']) {
            $checkSlugQuery = "SELECT COUNT(*) FROM exam_categories WHERE slug = ?";
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
        }

        // Handle the image upload (if a new image is uploaded)
        $image_path_new = $image_path; // Use the old image path by default

        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            // Check file size (max 5MB)
            if ($_FILES['image']['size'] > 5 * 1024 * 1024) {
                $error = "The image size must be less than 5MB.";
            } else {
                // Get the original file name and extension
                $image_name = $_FILES['image']['name'];

                // Generate a random filename while preserving the original extension
                $image_path_new = generateRandomFilename($image_name);

                if ($image_path_new === false) {
                    $error = "Invalid image file type.";
                } else {
                    // Set the upload directory
                    $upload_dir = 'blogs/';

                    // Ensure the 'blogs' folder exists
                    if (!file_exists($upload_dir)) {
                        mkdir($upload_dir, 0777, true);  // Create the folder if it doesn't exist
                    }

                    // Get the temporary file path
                    $image_tmp = $_FILES['image']['tmp_name'];

                    // Set the path for the image
                    $image_path_new = $upload_dir . $image_path_new;

                    // Move the uploaded file to the target folder
                    if (!move_uploaded_file($image_tmp, $image_path_new)) {
                        $error = "Failed to upload image.";
                    }
                }
            }
        }

        // If there are no errors, proceed to update the category in the database
        if (empty($error)) {
            // Prepare and execute the query to update the category
            $updateQuery = "UPDATE exam_categories SET exam_category_name = ?, description = ?, slug = ?, status = ?, image = ? WHERE id = ?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("sssssi", $exam_category_name, $description, $slug, $status, $image_path_new, $category_id);
            $stmt->execute();
            $stmt->close();

            // Set the success message and redirect to the category page
            $_SESSION['success_message'] = "Category updated successfully!";
            header("Location: category.php?s=success");
            exit();
        }
    }
}

// Fetch all records for categories if needed for the form (example for selecting categories)
$result = mysqli_query($conn, "SELECT * FROM exam_categories");
?>

<!-- Main content -->
<section class="content px-2">
    <div class="row">
        <div class="col-md-12">
            <div class="mainTitle mt-3 mb-20 d-flex align-items-center justify-content-between">
                <h3>Edit Category</h3>
            </div>
            <div class="box">
                <div class="box-body formOuter">
                    <p style="color:red;"><?php echo $error; ?></p>
                    <form name="edit_category" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Exam Category Name</label>
                                    <input type="text" name="exam_category_name" class="form-control" value="<?php echo htmlspecialchars($exam_category_name); ?>" placeholder="exam_category_name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Image</label><br>
                                    <input type="file" name="image" accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff,.tif,.webp">
                                    <p>Current Image: <img src="<?php echo $image_path; ?>" alt="Current Image" width="100"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Description</label>
                                    <input type="text" name="description" class="form-control" value="<?php echo htmlspecialchars($description); ?>" placeholder="description" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Active Status</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" name="status" <?php echo ($status == 1) ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="flexSwitchCheckChecked">Category Active</label>
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

