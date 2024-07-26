<?php
// Start the session
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

// Turn on error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
    // Ensure the connection file is included and the $connect variable is set
    if (!file_exists('../includes/connect.php')) {
        die('Error: Connection file not found.');
    } else {
        include('../includes/connect.php');
    }

    // Array to store error messages
    $errors = [];

    // Handle file uploads
    $uploadDirectory = '../uploads/';

    // Function to handle file upload and database insertion
    function uploadFile($file, $type, $altText, $connect, &$errors) {
        global $uploadDirectory;
        if (isset($file) && $file['error'] === UPLOAD_ERR_OK) {
            $tmpPath = $file['tmp_name'];
            $fileName = basename($file['name']);
            $uploadPath = $uploadDirectory . $fileName;

            // Check if file already exists and if it does duplicate the file in the directory to avoid clashes
            $fileCount = 1;
            $originalFileName = $fileName;
            while (file_exists($uploadPath)) {
                $fileName = pathinfo($originalFileName, PATHINFO_FILENAME) . '_' . $fileCount . '.' . pathinfo($originalFileName, PATHINFO_EXTENSION);
                $uploadPath = $uploadDirectory . $fileName;
                $fileCount++;
            }

            $fileType = mime_content_type($tmpPath);

            // Validate supported file types
            $supportedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'video/mp4', 'image/gif'];
            if (!in_array($fileType, $supportedTypes)) {
                $errors[] = "Unsupported file type for $altText.";
                return false;
            }

            // Move uploaded file to destination
            if (move_uploaded_file($tmpPath, $uploadPath)) {
                return $fileName; // Return the renamed filename for storage in the database
            } else {
                $errors[] = "Failed to move $altText to the upload directory.";
                return false;
            }
        } else {
            $errors[] = "Failed to upload $altText.";
            return false;
        }
    }

    // Validate and upload files before inserting the project into the database
    $thumbnail = uploadFile($_FILES['Thumbnail'], 'Thumbnail', 'Thumbnail', $connect, $errors);
    $hoverImage = uploadFile($_FILES['Hover_image'], 'Hover_image', 'Hover Image', $connect, $errors);
    $projectImages = [];
    if (isset($_FILES['Project-image']) && count($_FILES['Project-image']['name']) > 0) {
        for ($i = 0; $i < count($_FILES['Project-image']['name']); $i++) {
            $file = [
                'name' => $_FILES['Project-image']['name'][$i],
                'tmp_name' => $_FILES['Project-image']['tmp_name'][$i],
                'error' => $_FILES['Project-image']['error'][$i],
            ];
            $uploadedFile = uploadFile($file, 'Project-image', 'Project Image', $connect, $errors);
            if ($uploadedFile !== false) {
                $projectImages[] = $uploadedFile;
            }
        }
    }

    // Check if any errors occurred during file upload
    if (!empty($errors)) {
        // Redirect to error.php with error messages
        $errorString = implode("<br>", $errors);
        header("Location: error.php?message=" . urlencode($errorString));
        exit();
    }

    // If there are no errors, insert the project into the database
    $query = "INSERT INTO projects (client, description_short, description_long, type_of_work, industry, url, year) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($connect, $query);

    // Assign values to variables before passing them by reference
    $client_var = $client;
    $description_short_var = $description_short;
    $description_long_var = $description_long;
    $type_of_work_var = $type_of_work;
    $industry_var = $industry;
    $url_var = $url;
    $year_var = $year;

    mysqli_stmt_bind_param($stmt, 'sssssss', $client_var, $description_short_var, $description_long_var, $type_of_work_var, $industry_var, $url_var, $year_var);

    if (mysqli_stmt_execute($stmt)) {
        $project_id = mysqli_insert_id($connect); // Get the ID of the newly inserted project

        // Insert file details into the database
        if ($thumbnail) {
            $query = "INSERT INTO images (project_id, image_url, type, alt_text) 
                      VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($connect, $query);

            $project_id_var = $project_id;
            $thumbnail_var = $thumbnail;
            $thumbnail_type = 'Thumbnail';
            $thumbnail_alt = 'Thumbnail';

            mysqli_stmt_bind_param($stmt, 'isss', $project_id_var, $thumbnail_var, $thumbnail_type, $thumbnail_alt);
            mysqli_stmt_execute($stmt);
        }

        if ($hoverImage) {
            $query = "INSERT INTO images (project_id, image_url, type, alt_text) 
                      VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($connect, $query);

            $hoverImage_var = $hoverImage;
            $hoverImage_type = 'Hover_image';
            $hoverImage_alt = 'Hover Image';

            mysqli_stmt_bind_param($stmt, 'isss', $project_id_var, $hoverImage_var, $hoverImage_type, $hoverImage_alt);
            mysqli_stmt_execute($stmt);
        }

        foreach ($projectImages as $image) {
            $query = "INSERT INTO images (project_id, image_url, type, alt_text) 
                      VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($connect, $query);

            $image_var = $image;
            $image_type = 'Project-image';
            $image_alt = 'Project Image';

            mysqli_stmt_bind_param($stmt, 'isss', $project_id_var, $image_var, $image_type, $image_alt);
            mysqli_stmt_execute($stmt);
        }

        // Redirect to the layout page if everything is successful
        header("Location: layout.php?project_id=$project_id");
        exit();
    } else {
        // Display error message if the query fails
        echo "Failed: " . mysqli_stmt_error($stmt);
    }

    // Close the statement
    mysqli_stmt_close($stmt);

    // Close the connection
    mysqli_close($connect);
} else {
    // Redirect to error.php if form submission is unexpected
    header("Location: error.php?message=" . urlencode("You are not supposed to be here!"));
    exit();
}
?>
