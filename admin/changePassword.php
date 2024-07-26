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

// Process the form submission for password change
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $adminId = $_POST['admin_id'];
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];

    $query = "SELECT password FROM admin_users WHERE id = ?";
    $stmt = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($stmt, 'i', $adminId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $hashedPassword);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Verify the current password
    if (password_verify($currentPassword, $hashedPassword)) {
        $newHashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        $updateQuery = "UPDATE admin_users SET password = ? WHERE id = ?";
        $updateStmt = mysqli_prepare($connect, $updateQuery);
        mysqli_stmt_bind_param($updateStmt, 'si', $newHashedPassword, $adminId);
        mysqli_stmt_execute($updateStmt);
        mysqli_stmt_close($updateStmt);

         // Set success message
        $_SESSION['message'] = "Password changed successfully.";
    } else {
        // Set error message for incorrect current password
        $_SESSION['error'] = "Incorrect current password.";
    }

    // Redirect to the manage users page
    header('Location: manageUsers.php');
    exit;
}
?>
