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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $project_id = $_POST['project_id'];
    $client = $_POST['client'];
    $description_short = $_POST['description_short'];
    $description_long = $_POST['description_long'];
    $type_of_work = $_POST['type_of_work'];
    $industry = $_POST['industry'];
    $year = $_POST['year'];
    $url = $_POST['url'];

    // Update projects table using prepared statements
    $query_project = "UPDATE projects SET 
                      client=?, 
                      description_short=?, 
                      description_long=?, 
                      type_of_work=?, 
                      industry=?, 
                      year=?, 
                      url=? 
                      WHERE project_id=?";
    $stmt = mysqli_prepare($connect, $query_project);
    mysqli_stmt_bind_param($stmt, 'sssssssi', $client, $description_short, $description_long, $type_of_work, $industry, $year, $url, $project_id);
    $result_project = mysqli_stmt_execute($stmt);

    if ($result_project) {
        // Handle image uploads
        $uploadDirectory = '../uploads/';
        $errors = [];

        // Function to generate unique file name
        function generateUniqueFileName($uploadDirectory, $fileName) {
            $filePath = $uploadDirectory . $fileName;
            $fileInfo = pathinfo($filePath);
            $baseName = $fileInfo['filename'];
            $extension = isset($fileInfo['extension']) ? '.' . $fileInfo['extension'] : '';
            $counter = 1;

            while (file_exists($filePath)) {
                $filePath = $uploadDirectory . $baseName . $counter . $extension;
                $counter++;
            }

            return basename($filePath);
        }

        // Function to handle image insertion into database
        function insertImage($connect, $project_id, $image_url, $type) {
            $query_insert = "INSERT INTO images (project_id, image_url, type, alt_text) VALUES (?, ?, ?, ?)";
            $stmt_insert = mysqli_prepare($connect, $query_insert);
            $alt_text = ucfirst(str_replace('_', ' ', $type));
            mysqli_stmt_bind_param($stmt_insert, 'isss', $project_id, $image_url, $type, $alt_text);
            mysqli_stmt_execute($stmt_insert);
            mysqli_stmt_close($stmt_insert);
        }

        // Thumbnail image
        if (isset($_FILES['Thumbnail']) && $_FILES['Thumbnail']['error'] === UPLOAD_ERR_OK) {
            $thumbnailTmpPath = $_FILES['Thumbnail']['tmp_name'];
            $thumbnailName = generateUniqueFileName($uploadDirectory, basename($_FILES['Thumbnail']['name']));
            $thumbnailUploadPath = $uploadDirectory . $thumbnailName;

            if (move_uploaded_file($thumbnailTmpPath, $thumbnailUploadPath)) {
                // Delete old thumbnail if exists
                $query_delete = "DELETE FROM images WHERE image_id=?";
                $stmt_delete = mysqli_prepare($connect, $query_delete);
                mysqli_stmt_bind_param($stmt_delete, 'i', $_POST['thumbimage_id']);
                mysqli_stmt_execute($stmt_delete);
                mysqli_stmt_close($stmt_delete);

                insertImage($connect, $project_id, $thumbnailName, 'Thumbnail');
            } else {
                $errors[] = "Failed to upload Thumbnail.";
            }
        }

        // Hover image
        if (isset($_FILES['Hover_image']) && $_FILES['Hover_image']['error'] === UPLOAD_ERR_OK) {
            $hoverTmpPath = $_FILES['Hover_image']['tmp_name'];
            $hoverName = generateUniqueFileName($uploadDirectory, basename($_FILES['Hover_image']['name']));
            $hoverUploadPath = $uploadDirectory . $hoverName;

            if (move_uploaded_file($hoverTmpPath, $hoverUploadPath)) {
                // Delete old hover image if exists
                $query_delete = "DELETE FROM images WHERE image_id=?";
                $stmt_delete = mysqli_prepare($connect, $query_delete);
                mysqli_stmt_bind_param($stmt_delete, 'i', $_POST['hoverimage_id']);
                mysqli_stmt_execute($stmt_delete);
                mysqli_stmt_close($stmt_delete);

                insertImage($connect, $project_id, $hoverName, 'Hover_image');
            } else {
                $errors[] = "Failed to upload Hover Image.";
            }
        }

        // Project images
        if (isset($_FILES['Project-image']) && count($_FILES['Project-image']['name']) > 0) {
            for ($i = 0; $i < count($_FILES['Project-image']['name']); $i++) {
                if ($_FILES['Project-image']['error'][$i] === UPLOAD_ERR_OK) {
                    $projectImageTmpPath = $_FILES['Project-image']['tmp_name'][$i];
                    $projectImageName = generateUniqueFileName($uploadDirectory, basename($_FILES['Project-image']['name'][$i]));
                    $projectImageUploadPath = $uploadDirectory . $projectImageName;

                    if (move_uploaded_file($projectImageTmpPath, $projectImageUploadPath)) {
                        insertImage($connect, $project_id, $projectImageName, 'Project-image');
                    } else {
                        $errors[] = "Failed to upload Project Image {$projectImageName}.";
                    }
                }
            }
        }

        if (empty($errors)) {
            header("Location: layout.php?project_id=$project_id");
            exit();
        } else {
            // Redirect to error.php with error messages
            $errorString = implode("<br>", $errors);
            header("Location: error.php?message=" . urlencode($errorString));
            exit();
        }
    } else {
        // Redirect to error.php with error message
        header("Location: error.php?message=" . urlencode("Error updating project: " . mysqli_error($connect)));
        exit();
    }
} else {
    // Redirect to error.php if form submission is unexpected
    header("Location: error.php?message=" . urlencode("You are not supposed to be here!"));
    exit();
}
?>
