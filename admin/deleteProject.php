<?php
if (isset ($_POST['confirmDelete'])) {
    $project_id = $_POST['project_id'];
    //Connection string
    include ('../includes/connect.php');
    $query = "DELETE FROM projects WHERE `project_id`='$project_id'";
    $project = mysqli_query($connect, $query);
    //Delete all images linked to the project and remove it from uploads folder
    if ($project) {
        $query2 = "SELECT 'image_url' FROM images WHERE `project_id`='$project_id'";
        $imageResult=mysqli_query($connect, $query2);
        if($imageResult) {
            $uploadDirectory = '../uploads/';
            while($imageRow = mysqli_fetch_assoc($imageResult)) {
                $imagePath = $uploadDirectory . $imageRow['image_url'];
                if(file_exists($imagePath)) {
                    unlink($imagePath); // Delete the image file
                }
            }
            
            // Optionally, delete the image records from the database
            $deleteImagesQuery = "DELETE FROM images WHERE project_id = '$project_id'";
            mysqli_query($connect, $deleteImagesQuery);
        }
        header("Location: projects.php");
    } else {
        echo "Failed" . mysqli_error($connect);
    }
}
 else {
    echo "You should not be here!";
}