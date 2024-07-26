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


$error = ''; // Initialize the error variable
$success = false; //Initialize the success variable

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $query = "INSERT INTO admin_users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $connect->prepare($query);
    $stmt->bind_param('sss', $username, $email, $password);

    if ($stmt->execute()) {
        $success = true;
    } else {
        $error = "Error: " . $stmt->error;
    }
    $stmt->close();
    $connect->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan of Record</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/x-icon" href="../assets/favicon_io/favicon.ico">
    <script src="../main.js"></script>
    <style>

        body {
            font-family: Arial, sans-serif;
            background-color: #F5F5F5; 
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .register-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            width: 100%;
        }

        .register-box {
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
<?php include('../reusable/adminNav.php');?>
    
    <div class="register-container">
        <div class="register-box">
            <h2>Add Admin</h2>
            <?php if (!empty($error)): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
            <form action="register.php" method="POST" onsubmit="return validateForm()">
                <div class="form-group">
                    <input type="text" id="username" name="username" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <input type="text" id="email" name="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <input type="password" id="password" name="password" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
                </div>
                <button type="submit">REGISTER</button>
            </form>
        </div>
    </div>


     <!-- Optional: Bootstrap Modal Example -->
    <!-- Uncomment below to use Bootstrap modal -->
    
    <div class="modal" tabindex="-1" role="dialog" id="successModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Success!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Admin user registered successfully!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="returnToManageUsers()">Back to Manage Users</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>

    
   

    <script>
        // JavaScript function to handle redirection
        function returnToManageUsers() {
            window.location.href = "manageUsers.php";
        }

        // JavaScript function to validate registration form
        function validateForm() {
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('confirm_password').value;

            if (password !== confirmPassword) {
                alert("Passwords do not match. Please try again.");
                return false;
            }
            return true;
        }

        // Show modal if registration was successful
        <?php if ($success): ?>
            $(document).ready(function() {
                $('#successModal').modal('show');
            });
        <?php endif; ?>
    </script>
</body>
</html>
