<?php
session_start();
include('../includes/connect.php'); // database connection file

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        // Prepare and execute the query
        $query = "SELECT * FROM admin_users WHERE email = ?";
        if ($stmt = $connect->prepare($query)) {
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            // Verify the password
            if ($user && password_verify($password, $user['password'])) {
                // Password is correct, start a session
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['email'] = $user['email'];
                header('Location: dashboard.php');
                exit;
            } else {
                $error = 'Invalid email or password.';
            }
            $stmt->close();
        } else {
            $error = 'Database query error.';
        }
    } else {
        $error = 'Please fill in both fields.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan of Record</title>
      <!-- Linking external CSS files -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="icon" type="image/x-icon" href="../assets/favicon_io/favicon.ico">
    <script src="../main.js"></script>
    <link rel="stylesheet" href="../css/style.css">

    <style>
        /* admin-style.css */

body {
    font-family: Arial, sans-serif;
    background-color: #F5F5F5; 
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.login-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
    width: 100%;
}

.login-box {
    background-color: #fff;
    padding: 20px 40px;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    text-align: center;
    width: 300px;
}

h2 {
    margin-bottom: 20px;
    color: #333;
    font-family: var(--header-font);
    font-size: 26px;
}

.form-group {
    margin-bottom: 15px;
}

input[type="text"],
input[type="password"] {
    width: 100%;
    padding: 10px;
    margin: 5px 0 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
    font-size: 16px;
}

button {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    background-color: #ccc;
    border: none;
    color: black;
    font-size: 16px;
    border: 2px solid black;
    border-radius: 5px;
    cursor: pointer;
}

.error {
    color: red;
    margin-bottom: 15px;
    font-size: 14px;
}

    </style>

</head>
<body>
<div class="basketball desktop-only"><img src="../assets/cursor.png" alt="" width="24px"></div>

<header>
    <ul class="desktop-only">
        <li><a href="../index.php" class="<?= $current_page == 'index.php' ? 'active-link' : '' ?>">Plan of Record</a></li>
        <li><a href="../projects.php" class="<?= $current_page == 'projects.php' ? 'active-link' : '' ?>">Index</a></li>
        <li><a href="../about.php" class="<?= $current_page == 'about.php' ? 'active-link' : '' ?>">About</a></li>
        <li><a href="../approach.php" class="<?= $current_page == 'approach.php' ? 'active-link' : '' ?>">Approach</a></li>
        <li><a href="../contactUs.php" class="<?= $current_page == 'contactUs.php' ? 'active-link' : '' ?>">Contact</a></li>
    </ul>

</header>

    <div class="login-container">
        <div class="login-box">
            <h2>Admin Login</h2>
            <?php if ($error): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
            <form action="login.php" method="post">
                <div class="form-group">
                    <input type="text" id="email" name="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <input type="password" id="password" name="password" placeholder="Password" required>
                </div>
                <!-- <div class="form-group" style="float: left;">
                    <a href="forgotPassword.php" class="card-link text-secondary">Forgot Password?</a>
                </div> -->
                <button type="submit">LOGIN</button>
            </form>
        </div>
    </div>
</body>
</html>
