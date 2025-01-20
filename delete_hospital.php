<?php 
ob_start();  
$page_title = "Delete Hospital";
$page_name = "Hospital";
$fname = "hospitals.php";
include('header.php'); 

if (isset($_GET['id'])) {
    $hospital_id = (int)$_GET['id'];

    // Retrieve the hospital details from the database
    $stmt = $conn->prepare("SELECT * FROM `hospital` WHERE `id` = ?");
    $stmt->bind_param("i", $hospital_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $hospital = $result->fetch_assoc();
    $stmt->close();

    if ($hospital) {
        // Delete the hospital entry from the database
        $stmt = $conn->prepare("DELETE FROM `hospital` WHERE `id` = ?");
        $stmt->bind_param("i", $hospital_id);
        $stmt->execute();
        $stmt->close();

        // Optionally, delete the associated image file from the server
        if (file_exists($hospital['image'])) {
            unlink($hospital['image']);
        }

        $_SESSION['success_message'] = "Hospitals deleted successfully!";
        header("Location: hospitals.php?s=success");
        exit();
    } else {
        $_SESSION['error_message'] = "Hospital not found!";
    }
} else {
    $_SESSION['error_message'] = "Invalid hospital ID!";
}

header("Location: hospitals.php");
exit();
?>
