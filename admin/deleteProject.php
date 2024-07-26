<?php
// Start the session
session_start();

$inactive = 600; // timeout period in seconds (10 minutes)

if (isset($_SESSION['timeout'])) {
    $session_life = time() - $_SESSION['timeout'];
    if ($session_life > $inactive) {
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit;
    }
}
$_SESSION['timeout'] = time();    

// Redirect to login page if not logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

if (isset($_POST['confirmDelete'])) {
    $project_id = $_POST['project_id'];
    
    // Connection string
    include('../includes/connect.php');
    
    // Step 1: Delete project from the database
    $query = "DELETE FROM projects WHERE project_id='$project_id'";
    $projectResult = mysqli_query($connect, $query);
    
    if ($projectResult) {
        // Step 2: Delete images associated with the project from the database and uploads folder
        $query_images = "SELECT image_url FROM images WHERE project_id='$project_id'";
        $imageResult = mysqli_query($connect, $query_images);
        
        if ($imageResult) {
            $uploadDirectory = '../uploads/';
            
            while ($imageRow = mysqli_fetch_assoc($imageResult)) {
                $imagePath = $uploadDirectory . $imageRow['image_url'];
                
                // Delete image file if it exists
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            
            // Step 3: Delete image records from the database
            $deleteImagesQuery = "DELETE FROM images WHERE project_id='$project_id'";
            mysqli_query($connect, $deleteImagesQuery);
        }
        
        // Step 4: Redirect to projects.php after deletion
        header("Location: projects.php");
        exit();
    } else {
        echo "Failed to delete project: " . mysqli_error($connect);
    }
} else {
    echo "You should not be here!";
}
?>
