<?php
// Check if the form for adding a new project is submitted
if (isset($_POST['newProject'])) {
    // Retrieve data from the form
    $client = $_POST['client'];
    $description_short = $_POST['description_short'];
    $description_long = $_POST['description_long'];
    $type_of_work = $_POST['type_of_work'];
    $industry = $_POST['industry'];
    $url = $_POST['url'];
    $year = $_POST['year'];

    // Connection string
    include('../includes/connect.php');

    // SQL query to insert new project into the database using prepared statements
    $query = "INSERT INTO projects (client, description_short, description_long, type_of_work, industry, url, year) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($stmt, 'sssssss', $client, $description_short, $description_long, $type_of_work, $industry, $url, $year);
    
    // Execute the query
    if (mysqli_stmt_execute($stmt)) {
        $project_id = mysqli_insert_id($connect); // Get the ID of the newly inserted project

        // Handle file uploads
        $uploadDirectory = '../uploads/';
        $errors = []; // Array to store error messages

        // Function to handle file upload and database insertion
        function uploadFile($file, $type, $altText, $project_id, $connect, &$errors) {
            global $uploadDirectory;
            if (isset($file) && $file['error'] === UPLOAD_ERR_OK) {
                $tmpPath = $file['tmp_name'];
                $fileName = basename($file['name']);
                $uploadPath = $uploadDirectory . $fileName;

                if (move_uploaded_file($tmpPath, $uploadPath)) {
                    // Insert the file information into the database
                    $query = "INSERT INTO images (project_id, image_url, type, alt_text) 
                              VALUES (?, ?, ?, ?)";
                    $stmt = mysqli_prepare($connect, $query);
                    mysqli_stmt_bind_param($stmt, 'isss', $project_id, $fileName, $type, $altText);
                    mysqli_stmt_execute($stmt);
                } else {
                    $errors[] = "Failed to upload $altText.";
                }
            }
        }

        // Thumbnail image
        uploadFile($_FILES['Thumbnail'], 'Thumbnail', 'Thumbnail', $project_id, $connect, $errors);

        // Hover image
        uploadFile($_FILES['Hover_image'], 'Hover_image', 'Hover Image', $project_id, $connect, $errors);

        // Project images
        if (isset($_FILES['Project-image']) && count($_FILES['Project-image']['name']) > 0) {
            for ($i = 0; $i < count($_FILES['Project-image']['name']); $i++) {
                $file = [
                    'name' => $_FILES['Project-image']['name'][$i],
                    'tmp_name' => $_FILES['Project-image']['tmp_name'][$i],
                    'error' => $_FILES['Project-image']['error'][$i],
                ];
                uploadFile($file, 'Project-image', 'Project Image', $project_id, $connect, $errors);
            }
        }

        // If there are no errors, redirect to the layout page
        if (empty($errors)) {
            header("Location: layout.php?project_id=$project_id");
            exit();
        } else {
            // Display all error messages
            foreach ($errors as $error) {
                echo $error . "<br>";
            }
        }
    } else {
        // Display error message if the query fails
        echo "Failed: " . mysqli_stmt_error($stmt);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    // Display error message if the form submission is unexpected
    echo "You should not be here!";
}

// Close the connection
mysqli_close($connect);
