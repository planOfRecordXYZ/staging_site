<?php
include ("../includes/connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $project_id = $_POST['project_id'];
    $client = $_POST['client'];
    $description_short =  $_POST['description_short'];
    $description_long = $_POST['description_long'];
    $type_of_work =  $_POST['type_of_work'];
    $industry = $_POST['industry'];
    $year = $_POST['year'];
    $url = $_POST['url'];
    $thumb_old=$_POST['thumb_old'];
    $thumbimage_id=$_POST['thumbimage_id'];
    $hover_old=$_POST['hover_old'];
    $hoverimage_id=$_POST['hoverimage_id'];

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
    mysqli_stmt_close($stmt);

    if ($result_project) {
        // Handle image uploads
        $uploadDirectory = '../uploads/';
        $errors = [];

        // Thumbnail image
        if (isset($_FILES['Thumbnail']) && $_FILES['Thumbnail']['error'] === UPLOAD_ERR_OK) {
            $thumbnailTmpPath = $_FILES['Thumbnail']['tmp_name'];
            $thumbnailName = basename($_FILES['Thumbnail']['name']);
            $thumbnailUploadPath = $uploadDirectory . $thumbnailName;
            if($thumbnailName!=''){
                $updated_file=$thumbnailName;
                // Assuming $thumb_old holds the old thumbnail filename
                $oldThumbnailPath = $uploadDirectory . $thumb_old;

                // Check if the old file exists and delete it
                if (file_exists($oldThumbnailPath)) {
                    unlink($oldThumbnailPath);
                }
            } else {
                $updated_file=$thumb_old;
            }
            if (move_uploaded_file($thumbnailTmpPath, $thumbnailUploadPath)) {
                $query2 = "UPDATE images SET image_url=? WHERE image_id=?";
                $stmt2 = mysqli_prepare($connect, $query2);
                mysqli_stmt_bind_param($stmt2, 'si', $updated_file, $thumbimage_id);
                mysqli_stmt_execute($stmt2);
                mysqli_stmt_close($stmt2);
            } else {    
                $errors[] = "Failed to upload Thumbnail.";
            }
        }

        // Hover image
        if (isset($_FILES['Hover_image']) && $_FILES['Hover_image']['error'] === UPLOAD_ERR_OK) {
            $hoverTmpPath = $_FILES['Hover_image']['tmp_name'];
            $hoverName = basename($_FILES['Hover_image']['name']);
            $hoverUploadPath = $uploadDirectory . $hoverName;
            if($hoverName!=''){
                $updated_file=$hoverName;
                // Assuming $thumb_old holds the old thumbnail filename
                $oldHoverPath = $uploadDirectory . $hover_old;

                // Check if the old file exists and delete it
                if (file_exists($oldHoverPath)) {
                    unlink($oldHoverPath);
                }
            } else {
                $updated_file=$hover_old;
            }
            if (move_uploaded_file($hoverTmpPath, $hoverUploadPath)) {
                $query3 = "UPDATE images SET image_url=? WHERE image_id=?";
                $stmt3 = mysqli_prepare($connect, $query3);
                mysqli_stmt_bind_param($stmt3, 'si', $updated_file, $hoverimage_id);
                mysqli_stmt_execute($stmt3);
                mysqli_stmt_close($stmt3);
            } else {    
                $errors[] = "Failed to upload Hover Image.";
            }
        }

        // Project images
        if (isset($_FILES['Project-image']) && count($_FILES['Project-image']['name']) > 0) {
            for ($i = 0; $i < count($_FILES['Project-image']['name']); $i++) {
                if ($_FILES['Project-image']['error'][$i] === UPLOAD_ERR_OK) {
                    $projectImageTmpPath = $_FILES['Project-image']['tmp_name'][$i];
                    $projectImageName = basename($_FILES['Project-image']['name'][$i]);
                    $projectImageUploadPath = $uploadDirectory . $projectImageName;

                    if (move_uploaded_file($projectImageTmpPath, $projectImageUploadPath)) {
                        $query4 = "INSERT INTO images (project_id, image_url, type, alt_text) VALUES (?, ?, 'Project-image', 'Project Image')";
                        $stmt4 = mysqli_prepare($connect, $query4);
                        mysqli_stmt_bind_param($stmt4, 'is', $project_id, $projectImageName);
                        mysqli_stmt_execute($stmt4);
                        mysqli_stmt_close($stmt4);
                    } else {
                        $errors[] = "Failed to upload Project Image {$projectImageName}.";
                    }
                }
            }
        }

        if (empty($errors)) {
            header("Location: project.php?project_id=$project_id");
            exit();
        } else {
            foreach ($errors as $error) {
                echo $error . "<br>";
            }
        }
    } else {
        echo "Error updating project: " . mysqli_error($connect);
    }
}
