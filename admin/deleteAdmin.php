<?php

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

include("../includes/connect.php");

// Process the form submission for deleting an admin user
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $adminId = $_POST['admin_id'];

    // Prepare and execute the delete query
    $query = "DELETE FROM admin_users WHERE id = ?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param('i', $adminId);

    // Check if the delete operation was successful
    if ($stmt->execute()) {
        // Redirect to the manage users page on success
        header('Location: manageUsers.php');
    } else {
        // Output error message if delete operation failed
        echo "Error: " . $stmt->error;
    }

    // Close the statement and the database connection
    $stmt->close();
    $connect->close();
} else {
     // Redirect to manage users page if the request method is not POST
    header('Location: manageUsers.php');
}
?>
