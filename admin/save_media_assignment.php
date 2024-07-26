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

include ("../includes/connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $project_id = $_POST['project_id'];
    $mediaAssignments = $_POST['mediaAssignments'];

    // Prepare and execute the SQL query to insert the JSON string into the layout table
    $query = "UPDATE layout SET media_assignments = ? WHERE project_id = ?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param('si', $mediaAssignments, $project_id);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }

    $stmt->close();
    $connect->close();
}
?>
