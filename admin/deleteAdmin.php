<?php

session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

include("../includes/connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $adminId = $_POST['admin_id'];

    $query = "DELETE FROM admin_users WHERE id = ?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param('i', $adminId);

    if ($stmt->execute()) {
        header('Location: manageUsers.php');
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $connect->close();
} else {
    header('Location: manageUsers.php');
}
?>
