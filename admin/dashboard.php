<?php

    session_start();

    // Redirect to login page if not logged in
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        header('Location: login.php');
        exit;
    }

    include("../includes/connect.php");

       // Fetch current admin's details from the database
       $adminEmail = $_SESSION['email'];

       // Query to fetch the username using the email
       $query = "SELECT username FROM admin_users WHERE email = '$adminEmail'";
       $result = mysqli_query($connect, $query);
       $admin = mysqli_fetch_assoc($result);
   
       // Get the username
       $adminUsername = $admin['username'];

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
    <style>
      .card:hover{
        filter: drop-shadow(0 0 0.1rem #001);
      }
    </style>
</head>
<body>
<div class="basketball desktop-only"><img src="../assets/cursor.png" alt="" width="24px"></div>

<?php include('../reusable/adminNav.php');?>

<div style="margin: 30px;">

<!-- Admin's View Section -->
<div class="container" style="margin-top: 150px; margin-left:0;">
    <h3>Welcome, <?php echo htmlspecialchars($adminUsername); ?>!</h3>
</div>
</div>


<div class="contanier" style="margin-top: 50px; padding: 10px 40px;">
<div class="row" style="justify-content: flex-start;">
  <div class="col-sm-6 mb-3">

    <div class="card bg-secondary w-50 mb-3" style="max-width: 18rem;">
    <a href="projects.php">
      <div class="card-body">
        <h5 class="card-title text-white">View Index</h5>
      </div>
    </a>
    </div>

    <div class="card bg-secondary w-50 mb-3" style="max-width: 18rem;">
    <a href="manageUsers.php">
      <div class="card-body">
        <h5 class="card-title text-white">Manage Users</h5>
      </div>
    </a>
    </div>

  </div>


  <div class="col-sm-6 mb-3">
    <div class="card bg-dark w-50" style="max-width: 18rem;">
    <a href="newProject.php">
      <div class="card-body">
        <h5 class="card-title text-white">Add Project</h5>
      </div>
    </a>
    </div>
  </div>
 
  
</div>
</div> 

<div>
  <?php include('../reusable/footer.php');?>
</div>
</body>
</html>



