<?php
// Get the project ID from the query string
$project_id = $_GET['project_id'];
include("includes/connect.php");

// Fetch project details from the database
$query = "SELECT * FROM projects WHERE `project_id` = '$project_id'";
$project = mysqli_query($connect, $query);
$result = $project->fetch_assoc();

// Check if project details were fetched successfully
if (!$result) {
    echo "Error: Failed to fetch project details.";
    exit;
}

// Fetch the thumbnail media for the project
$query_thumb ="SELECT * FROM images WHERE `project_id` = '$project_id' AND `type`='Thumbnail'";
$thumbnail1 = mysqli_query($connect, $query_thumb);
$thumbnail = $thumbnail1->fetch_assoc();

// Fetch layout data and media assignments for the project
$layout_query = "SELECT * FROM layout WHERE `project_id` = '$project_id'";
$layout_result = mysqli_query($connect, $layout_query);
$layout_data = $layout_result->fetch_assoc();

// Check if layout data was fetched successfully
if (!$layout_data) {
    echo "Error: Failed to fetch layout data.";
    exit;
}

// Decode layout data and media assignments, initialize as empty arrays if decoding fails
$layout_blocks = isset($layout_data['layout_data']) ? json_decode($layout_data['layout_data'], true) : [];
if ($layout_blocks === null) {
    echo "Error: Failed to decode layout data.";
    exit;
}

$media_assignments = isset($layout_data['media_assignments']) ? json_decode($layout_data['media_assignments'], true) : [];
if ($media_assignments === null) {
    echo "Error: Failed to decode media assignments.";
    exit;
}
//accessing the array with the media items
$medias = $media_assignments[0];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($result['client']); ?> - Plan Of Record</title>
    <link rel="icon" type="image/x-icon" href="./assets/favicon_io/favicon.ico">
    <script src="./main.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="admin/layout.css">
    <style>
       
    </style>
</head>
<body>
    <div class="basketball desktop-only"><img src="./assets/cursor.png" alt="" width="24px"></div>
    <?php include('reusable/nav.php');?>

    <div class="thumbnail">
        <?php
        // The thumbnail is mostly a video but image should also be an option, so do the check for filetype and then display accordingly.
        // Check if the image_url is set and not empty
        if (!empty($thumbnail['image_url'])) {
            // Get the file extension of the image_url
            $fileExtension = strtolower(pathinfo($thumbnail['image_url'], PATHINFO_EXTENSION));

            // Check if the file extension is an image type
            if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
                echo '<img src="..\uploads\\' . htmlspecialchars($thumbnail['image_url']) . '" alt="Thumbnail" width="100%">';
            }
            // Check if the file extension is a video type
            elseif (in_array($fileExtension, ['mp4', 'webm', 'ogg'])) {
                echo '<video autoplay loop muted width="100%">';
                echo '<source src="..\uploads\\' . htmlspecialchars($thumbnail['image_url']) . '" type="video/' . $fileExtension . '">';
                echo 'Your browser does not support the video tag.';
                echo '</video>';
            } else {
                // If the file type is unsupported, you can display a placeholder or error message
                echo 'Unsupported media type';
            }
        } else {
            // Handle the case where image_url is not set or empty
            echo 'No media available';
        }
        ?>
    </div>
    <!-- Fetch and display content from the database for the project -->
    <div class="project-details">
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
    <!-- Fetch and display the layout and media and display based on the layout -->
    <div class="project-layout">
        <?php
        // Iterate through each row in layout data
        foreach ($layout_blocks as $i => $row) {
            echo '<div class="row">'; // Start row

            // Iterate through each block in the current row
            foreach ($row as $block_index => $block_id) {
                echo '<div class="' . htmlspecialchars($block_id) . ' media">'; // Start block

               
                    // Iterate through each media assignment for the current block
                    foreach ($medias[$i][$block_index] as $media) {
                        $media_url = '/uploads/' . htmlspecialchars($media);
                        $media_type = pathinfo($media_url, PATHINFO_EXTENSION);
                        if (in_array($media_type, ['jpg', 'jpeg', 'png'])) {
                            // Display image
                            echo '<img src="' . $media_url . '" alt="">';
                        } elseif (in_array($media_type, ['mp4', 'webm', 'ogg'])) {
                            // Display video
                            echo '<video muted autoplay loop>';
                            echo '<source src="' . $media_url . '" type="video/' . $media_type . '">';
                            echo 'Your browser does not support the video tag.';
                            echo '</video>';
                        } else {
                            // Unsupported media type
                            echo 'Unsupported media type';
                        }
                    }

                echo '</div>'; // End block
            }
            echo '</div>'; // End row
        }
        ?>
    </div> <!-- End project-layout -->
</body>
</html>
