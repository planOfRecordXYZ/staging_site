<?php
// Start the session
session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

include ("../includes/connect.php");
// Check if image ID and URL are provided
if(isset($_POST['image_id']) && isset($_POST['image_url'])) {
    // Assuming you have a function to validate and sanitize inputs, if not, make sure to implement it
    $image_id = $_POST['image_id'];
    $image_url = $_POST['image_url'];

    // Perform any necessary validation or checks here

    // Delete image from the database
    $query = "DELETE FROM images WHERE image_id = '$image_id'";
    // Execute the query
    mysqli_query($connect, $query);
    // Delete image file from the file system
    $uploadDirectory = '../uploads/';
    //Remove the media linked to the project
    $imagePath = $uploadDirectory . $image_url;
    if(file_exists($imagePath)) {
        unlink($imagePath);
    }

    // Provide feedback to the client-side JavaScript
    echo "success";
} else {
    // If image ID or URL is missing, return an error message
    echo "error";
}

