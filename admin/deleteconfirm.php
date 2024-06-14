<?php

    $project_id = $_GET['project_id'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Project Confirmation</title>
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
<div class="delete-confirm">
<h1>Delete Project Confirmation</h1>
    <p>Are you sure you want to delete this project?</p>
    <form method="POST" action="deleteProject.php">
        <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
        <button type="submit" name="confirmDelete" class="btn btn-danger">Confirm Delete</button>
        <a href="project.php?project_id=<?php echo $project_id; ?>" class="btn btn-secondary">Cancel</a>
    </form>
</div>
    
</body>
</html>
