<?php

session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

include("../includes/connect.php");

 // Fetch current admin's details from the database
 $currentadminEmail = $_SESSION['email'];

// Query to fetch the username using the email
$query = "SELECT id, username, email FROM admin_users WHERE email != '$currentadminEmail' ORDER BY created_at";
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

    <a class="btn btn-dark mb-3" href="register.php" role="button">Add Admin</a>

    <div class="row" style="justify-content: flex-start;">

        <?php 
        if (mysqli_connect_error()) {
            die("Connection error: " . mysqli_connect_error());
        }
        if ($result == null) {
            echo '<h4>No Admins present in database</h4>';
        } else {
            foreach ($result as $admin) {
                echo '
                <div class="col-sm-4 mb-3">
                    <div class="card" style="width: 18rem;">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">'.$admin['username'].'</li>
                        </ul>
                        <div class="card-body">
                           
                            <a href="#" class="card-link text-danger" onclick="confirmDelete('.$admin['id'].', \''.$admin['username'].'\')">Delete</a>
                        </div>
                    </div>
                </div>';
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

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function confirmDelete(adminId, adminName) {
        document.getElementById('adminName').textContent = adminName;
        document.getElementById('adminId').value = adminId;
        var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
    }
</script>

</body>
</html>
