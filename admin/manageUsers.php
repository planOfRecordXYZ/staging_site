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

 // Fetch current admin's details from the database
 $currentadminEmail = $_SESSION['email'];

// Query to fetch the username using the email
$query = "SELECT id, username, email FROM admin_users";
$result = mysqli_query($connect, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan of Record</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/x-icon" href="../assets/favicon_io/favicon.ico">
    <link rel="stylesheet" href="../css/projectstyle.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <script src="../main.js"></script>
</head>
<body>
<div class="basketball desktop-only"><img src="../assets/cursor.png" alt="" width="24px"></div>

<?php include('../reusable/adminNav.php');?>

<div class="container" style="margin-top: 150px; padding: 10px 40px;">

 <!-- Display messages -->
 <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success">
            <?php 
            echo $_SESSION['message']; 
            unset($_SESSION['message']);
            ?>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php 
            echo $_SESSION['error']; 
            unset($_SESSION['error']);
            ?>
        </div>
    <?php endif; ?>

    <a class="btn btn-dark mb-3" href="register.php" role="button">Add Admin</a>

    <div class="row" style="justify-content: flex-start;">

        <?php 
        if (mysqli_connect_error()) {
            die("Connection error: " . mysqli_connect_error());
        }
        // Display a message if no admins are present in the database
        if ($result == null) {
            echo '<h4>No Admins present in database</h4>';
        } else {
             // Loop through the admin users and display them
            foreach ($result as $admin) {
                // Highlight the current admin user
                if($admin['email'] == $currentadminEmail){
                    echo '
                <div class="row" style="justify-content: flex-start; order: -1; border-bottom: 1px solid #CCC; margin-bottom: 20px;">
                <div class="col-sm-4 mb-3">
                    <div class="card" style="width: 18rem;">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">'.$admin['username'].'</li>
                        </ul>
                        <div class="card-body">
                            <a href="#" class="card-link text-secondary" onclick="changePassword('.$admin['id'].', \''.$admin['username'].'\')">Change Password</a>
                            <a href="#" class="card-link text-danger" onclick="confirmDelete('.$admin['id'].', \''.$admin['username'].'\')">Delete</a>
                        </div>
                    </div>
                </div>
                </div>';
                }
                else{
                    echo '
                    <div class="row" style="justify-content: flex-start;">
                    <div class="col-sm-4 mb-3">
                        <div class="card" style="width: 18rem;">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">'.$admin['username'].'</li>
                            </ul>
                            <div class="card-body">
                                <a href="#" class="card-link text-danger" onclick="confirmDelete('.$admin['id'].', \''.$admin['username'].'\')">Delete</a>
                            </div>
                        </div>
                    </div>
                    </div>';
                }
            }   
        }   
        ?>

    </div>
</div>

<div>
  <?php include('../reusable/footer.php'); ?>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete admin <span id="adminName"></span>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" action="deleteAdmin.php" method="POST">
                    <input type="hidden" name="admin_id" id="adminId">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Change Password for <span id="changePasswordAdminName"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="changePasswordForm" action="changePassword.php" method="POST" onsubmit="return validateChangePasswordForm();">
                    <input type="hidden" name="admin_id" id="changePasswordAdminId">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_new_password" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password" required>
                    </div>
                    <div id="changePasswordError" class="alert alert-danger" style="display: none;"></div>
                    <button type="submit" class="btn btn-secondary">Change Password</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Function to confirm deletion of an admin user
    function confirmDelete(adminId, adminName) {
        document.getElementById('adminName').textContent = adminName;
        document.getElementById('adminId').value = adminId;
        var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
    }

    // Function to initiate password change for an admin user
    function changePassword(adminId, adminName) {
        document.getElementById('changePasswordAdminName').textContent = adminName;
        document.getElementById('changePasswordAdminId').value = adminId;
        var changePasswordModal = new bootstrap.Modal(document.getElementById('changePasswordModal'));
        changePasswordModal.show();
    }

    // Function to validate the change password form
    function validateChangePasswordForm() {
        var currentPassword = document.getElementById('current_password').value;
        var newPassword = document.getElementById('new_password').value;
        var confirmNewPassword = document.getElementById('confirm_new_password').value;
        var errorDiv = document.getElementById('changePasswordError');

        if (newPassword !== confirmNewPassword) {
            errorDiv.textContent = "New passwords do not match.";
            errorDiv.style.display = "block";
            return false;
        }

        errorDiv.style.display = "none";
        return true;
    }
</script>

</body>
</html>
