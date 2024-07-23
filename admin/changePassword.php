<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

include("../includes/connect.php");

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

    if (password_verify($currentPassword, $hashedPassword)) {
        $newHashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        $updateQuery = "UPDATE admin_users SET password = ? WHERE id = ?";
        $updateStmt = mysqli_prepare($connect, $updateQuery);
        mysqli_stmt_bind_param($updateStmt, 'si', $newHashedPassword, $adminId);
        mysqli_stmt_execute($updateStmt);
        mysqli_stmt_close($updateStmt);

        $_SESSION['message'] = "Password changed successfully.";
    } else {
        $_SESSION['error'] = "Incorrect current password.";
    }

    header('Location: manageUsers.php');
    exit;
}
?>
