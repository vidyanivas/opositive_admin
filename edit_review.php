<?php
ob_start();  // Start output buffering
session_start(); // Ensure session is started
$page_title = "Edit Review";
$page_name = "Review";
$fname = "review.php";
include('header.php');
$error = '';

// Ensure the review ID is passed in the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $blog_id = $_GET['id'];

    // Fetch the existing review details from the database
    $query = "SELECT * FROM review WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $blog_id);  // Correct variable used here
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the review exists
    if ($result->num_rows > 0) {
        $blog = $result->fetch_assoc();
        $title = $blog['title'];
        $content = $blog['content'];
        $slug = $blog['slug'];
        $image_path = $blog['image'];
        $status = $blog['status'];
    } else {
        $error = "Review not found.";
    }

    $stmt->close();
} else {
    $error = "Invalid review ID.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form inputs
    $title = trim($_POST['title']) ? trim($_POST['title']) : '';
    $content = trim($_POST['content']) ? trim($_POST['content']) : '';
    $status = isset($_POST['status']) ? 1 : 0;

    // Check if fields are empty
    if (empty($title) || empty($content)) {
        $error = "All fields are required!";
    } else {
        // Generate a unique slug
        function generateSlug($title)
        {
            $slug = strtolower(trim($title));
            $slug = preg_replace('/[^a-z0-9-]+/', '-', $slug);
            return $slug;
        }

        $slug = generateSlug($title);

        // Check if the slug already exists and is not the current one
        if ($slug !== $blog['slug']) {
            $checkSlugQuery = "SELECT COUNT(*) FROM review WHERE slug = ?";  // Correct table name here
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
                $image_ext = pathinfo($image_name, PATHINFO_EXTENSION);

                // Generate a random filename while preserving the original extension
                $image_path_new = uniqid() . '.' . $image_ext;

                // Set the upload directory
                $upload_dir = 'review/';

                // Ensure the 'review' folder exists
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

        // If there are no errors, proceed to update the review in the database
        if (empty($error)) {
            // Prepare and execute the query to  update the review
            $updateQuery = "UPDATE review SET title = ?, content = ?, slug = ?, status = ?, image = ? WHERE id = ?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("sssssi", $title, $content, $slug, $status, $image_path_new, $blog_id);
            $stmt->execute();
            $stmt->close();

            // Set the success message and redirect to the reviews page
            $_SESSION['success_message'] = "Review updated successfully!";
            header("Location: review.php?s=success");
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
                <h3>Edit Review</h3>
            </div>
            <div class="box">
                <div class="box-body formOuter">
                    <p style="color:red;"><?php echo $error; ?></p>
                    <form name="edit_blog" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($title); ?>" placeholder="Review Title" required>
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
                                    <label>Content</label>
                                    <textarea name="content" class="form-control" placeholder="Review Content" required><?php echo htmlspecialchars($content); ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Active Status</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" name="status" <?php echo ($status == 1) ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="flexSwitchCheckChecked">Review Active</label>
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


                                                