<?php
// Fetch the project ID from the URL parameters
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

// Fetch the thumbnail media
$query_thumb = "SELECT * FROM images WHERE `project_id` = '$project_id' AND `type`='Thumbnail'";
$thumbnail1 = mysqli_query($connect, $query_thumb);
$thumbnail = $thumbnail1->fetch_assoc();

// Fetch layout data and media assignments
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

// Extract the media assignments for easier use
$medias = $media_assignments[0];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($result['client']); ?> - Plan Of Record</title>
    <link rel="icon" type="image/x-icon" href="../assets/favicon_io/favicon.ico">
    <script src="../main.js"></script>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="layout.css">
    <style>
        .project-layout {
            width: 100%;
            min-height: 400px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            padding: 10px;
        }
        .row {
            display: flex;
            flex-direction: row;
            width: 100%;
            justify-content: center;
        }
        .media {
            margin: 10px;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }
        .block {
            border: 0px;
            margin: 10px;
            width: 100%;
            height: 100%;
        }
        .media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .media video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .block1 {
            max-width: 1478px;
            height: 600px;
        }
        .block2 {
            max-width: 1478px;
            height: 1000px;
        }
        .block3 {
            max-width: 715px;
            height: 1000px;
        }
        .block4 {
            width: 712px;
            height: 480px;
        }
        .block5 {
            width: 1280px;
            height: 720px;
        }
        .thumbnail {
            max-width: 100%;
            height: 720px;
            overflow: hidden;
        }
        .thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .buttons {
            position: fixed;
            top: 20px;
            right: 12px;
            z-index: 200;
        }
    </style>
</head>
<body>
    <div class="basketball desktop-only"><img src="../assets/cursor.png" alt="" width="24px"></div>
    <?php include('../reusable/adminNav.php'); ?>
    <div class="buttons">
        <a href="updateProject.php?project_id=<?php echo $project_id ?>"><button>Update</button></a>
        <a href="deleteconfirm.php?project_id=<?php echo $project_id ?>"><button>Delete</button></a>
    </div>
    <div class="thumbnail">
        <?php
        if (!empty($thumbnail['image_url'])) {
            $fileExtension = strtolower(pathinfo($thumbnail['image_url'], PATHINFO_EXTENSION));
            if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
                echo '<img src="..\uploads\\' . htmlspecialchars($thumbnail['image_url']) . '" alt="Thumbnail" width="100%">';
            } elseif (in_array($fileExtension, ['mp4', 'webm', 'ogg'])) {
                echo '<video autoplay loop muted width="100%">';
                echo '<source src="..\uploads\\' . htmlspecialchars($thumbnail['image_url']) . '" type="video/' . $fileExtension . '">';
                echo 'Your browser does not support the video tag.';
                echo '</video>';
            } else {
                echo 'Unsupported media type';
            }
        } else {
            echo 'No media available';
        }
        ?>
    </div>
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
    <div class="project-layout">
        <?php
        // Iterate through each row in the layout
        foreach ($layout_blocks as $i => $row) {
            echo '<div class="row">'; // Start row
            foreach ($row as $block_index => $block_id) {
                echo '<div class="' . htmlspecialchars($block_id) . ' media">'; // Start block
                // Iterate through each media item in the block
                foreach ($medias[$i][$block_index] as $media) {
                    $media_url = '/uploads/' . htmlspecialchars($media);
                    $media_type = pathinfo($media_url, PATHINFO_EXTENSION);
                    if (in_array($media_type, ['jpg', 'jpeg', 'png'])) {
                        echo '<img src="' . $media_url . '" alt="">';
                    } elseif (in_array($media_type, ['mp4', 'webm', 'ogg'])) {
                        echo '<video muted autoplay loop>';
                        echo '<source src="' . $media_url . '" type="video/' . $media_type . '">';
                        echo 'Your browser does not support the video tag.';
                        echo '</video>';
                    } else {
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
