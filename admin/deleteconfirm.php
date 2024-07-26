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

    $project_id = $_GET['project_id'];

    // Include the database connection script
       include("../includes/connect.php");
    
    // Fetch project details
        $query = "SELECT * FROM projects WHERE `project_id` = '$project_id'";
        $project = mysqli_query($connect, $query);
        $result = $project->fetch_assoc();

        // Check if project details were fetched successfully
        if (!$result) {
            echo "Error: Failed to fetch project details.";
            exit;
        }

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
    <style>
        .delete-confirm{
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 50px;
        }
    </style>
</head>
<body>
<div class="delete-confirm" style="margin: 30px;">
<h1>Delete Project Confirmation</h1>
    <p>Are you sure you want to delete this project?</p>
    <form method="POST" action="deleteProject.php">
        <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
        
        <div class="project-details" style="border: 1px solid grey; border-radius: 10px; margin-bottom: 20px; padding:20px;">
        <div class="col">
            <div class="project-header">
                <h1><?php echo htmlspecialchars($result['client']); ?></h1>
            </div>
            <div class="industry">
                <p><?php echo htmlspecialchars($result['type_of_work']); ?></p>
                <p><?php echo htmlspecialchars($result['industry']); ?></p>
                <p><?php echo htmlspecialchars($result['year']); ?></p>
            </div>
        </div>
        <div class="col">
            <div class="project-description">
                <p><?php echo htmlspecialchars($result['description_long']); ?></p>
            </div>
        </div>
        </div>


        <button type="submit" name="confirmDelete" class="btn btn-danger">Confirm Delete</button>
        <a href="project.php?project_id=<?php echo $project_id; ?>" class="btn btn-secondary">Cancel</a>
    </form>
</div>
    
</body>
</html>
