<?php
ob_start();
session_start();
include('header.php');

// Check if 'id' is passed in the URL to delete the appointment
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare the delete query
    $query = "DELETE FROM exam_categories WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    
    if ($stmt) {
        // Bind parameters
        mysqli_stmt_bind_param($stmt, "i", $id);

        // Execute query
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success_message'] = "Category deleted successfully!";
        } else {
            $_SESSION['error_message'] = "Failed to delete category.";
        }

        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['error_message'] = "Failed to prepare the SQL statement.";
    }

    // Redirect back to the category list page
    header("Location: category.php");
    exit();
} else {
    $_SESSION['error_message'] = "Category ID is required.";
    header("Location: category.php");
    exit();
}
?>