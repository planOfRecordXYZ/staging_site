<?php

  session_start();

  // Redirect to login page if not logged in
  if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
      header('Location: login.php');
      exit;
  }

$project_id = $_GET['project_id'];
include("../includes/connect.php");

// Fetch project details
$query = "SELECT * FROM projects WHERE `project_id` = '$project_id'";
$project = mysqli_query($connect, $query);
$result = $project->fetch_assoc();

// Fetch all images associated with the project
$query_images = "SELECT * FROM images WHERE `project_id` = '$project_id'";
$images_result = mysqli_query($connect, $query_images);
// $images = [];
$thumbnails = [];
$other_images = [];

while ($image = mysqli_fetch_assoc($images_result)) {
  //  $images[$image['image_id']] = $image;  Store each image with its unique ID
    if ($image['type'] == 'Thumbnail') {
        $thumbnails[] = $image;
    } else {
        $other_images[] = $image;
    }
}

// Combine thumbnails with other images to ensure thumbnails appear first
$images = array_merge($thumbnails, $other_images);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan of Record</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/projectstyle.css">
    <link rel="stylesheet" href="layout.css">
    <link rel="icon" type="image/x-icon" href="../assets/favicon_io/favicon.ico">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../main.js"></script>
</head>
<style>
    /* Your CSS styles here */
</style>
<body>
<div class="basketball desktop-only"><img src="../assets/cursor.png" alt="" width="24px"></div>
<button onclick="toggleHeader()" class="toggleBtn">Hide panel</button>
<div class="fixed-header" id="fixedHeader">
    <div class="header">
        <!-- Header content -->
        <h1 class="layout-header">Set Media - <?php echo $result['client']; ?></h1>
        <p>Drag and drop the images into the blocks below and click on submit to assign them for the project page.</p>
    </div>
    <div class="media-container">
        <!-- Display draggable media items -->
        <?php foreach ($images as $image): ?>
            <div class="media-item" draggable="true" data-image-id="<?php echo $image['image_id']; ?>">
                <?php
                $fileExtension = pathinfo($image['image_url'], PATHINFO_EXTENSION);
                if ($fileExtension === 'mp4') {
                    // Display video
                    echo '<video autoplay muted>';
                    echo '<source src="../uploads/' . $image['image_url'] . '" type="video/mp4">';
                    echo 'Your browser does not support the video tag.';
                    echo '</video>';
                } else {
                    // Display image
                    echo '<img src="../uploads/' . $image['image_url'] . '" alt="project image">';
                }
                ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<div class="non-fixed" id="nonFixedSection">
    <p>Scroll to view the image list and drop each image in the blocks below. </p>
</div>
<div class="layout-container">
    <!-- Render layout blocks dynamically based on saved layout -->
    <?php
    // Fetch layout data from the database
    $layout_query = "SELECT * FROM layout WHERE `project_id` = '$project_id'";
    $layout_result = mysqli_query($connect, $layout_query);

    while ($layout_row = mysqli_fetch_assoc($layout_result)) {
        echo '<div class="layout-row">';
        // Render layout blocks dynamically
        $blocks = json_decode($layout_row['layout_data'], true); // Decode JSON array
        foreach ($blocks as $block) {
            echo '<div class="layout-block">';
            foreach ($block as $column) {
                echo '<div class="column ' . $column . '">' . $column . '</div>';
            }
            echo '</div>';
        }
        echo '</div>';
    }
    ?>
</div>
<div class="options">
    <button onclick="saveMediaAssignment()">Save Media Assignment</button>
</div>
<script>
    var actionStack = [];

    $(document).ready(function() {
        // Function to handle drag start on media items
        $('.media-item').on('dragstart', function(e) {
            var imageId = $(this).data('image-id');
            e.originalEvent.dataTransfer.setData('text/plain', imageId);
            e.originalEvent.dataTransfer.effectAllowed = 'move';
            console.log('Dragging:', imageId);
        });

        // Function to handle drag over on layout blocks
        $('.column').on('dragover', function(e) {
            e.preventDefault();
            e.originalEvent.dataTransfer.dropEffect = 'move';
            return false;
        });

        // Function to handle drop on layout blocks
        $('.column').on('drop', function(e) {
            e.preventDefault();
            var imageId = e.originalEvent.dataTransfer.getData('text/plain');
            console.log('Dropped Image ID:', imageId); // Log the image ID

            if (!imageId) {
                console.error("Dropped element does not have a valid ID.");
                return false;
            }

            var mediaItem = $('.media-item[data-image-id="' + imageId + '"]');

            if (!mediaItem.length) {
                console.error("No element found with ID: " + imageId);
                return false;
            }

            var mediaElement;
            if (mediaItem.find('video').length > 0) {
                // Detect video file extension
                var videoSrc = mediaItem.find('source').attr('src');
                var videoExtension = videoSrc.split('.').pop().toLowerCase();

                // Handle different video formats
                switch (videoExtension) {
                    case 'mp4':
                    case 'webm':
                    case 'ogg':
                    case 'mov':
                        mediaElement = $('<video autoplay muted loop style="width: 100%; height: 100%; object-fit: cover;"><source src="' + videoSrc + '" type="video/' + videoExtension + '"></video>');
                        break;
                    default:
                        console.error("Unsupported video format: " + videoExtension);
                        return false;
                }
                } else {
                    var imgSrc = mediaItem.find('img').attr('src');
                    mediaElement = $('<img src="' + imgSrc + '" alt="project image" style="width: 100%; height: 100%; object-fit: cover;">');
                }

            $(this).empty().append(mediaElement);
            actionStack.push({ action: 'add', element: mediaElement });

            return false;
        });
    });

    function saveMediaAssignment() {
        var projectId = <?php echo json_encode($project_id); ?>;
        var mediaAssignments = [];

        $('.layout-row').each(function() {
            var layoutRow = [];
            $(this).find('.layout-block').each(function() {
                var block = [];
                $(this).find('.column').each(function() {
                    var columnMedia = [];
                    $(this).find('img, video').each(function() {
                        var mediaSrc = $(this).is('img') ? $(this).attr('src').split('/').pop() : $(this).find('source').attr('src').split('/').pop();
                        columnMedia.push(mediaSrc);
                    });
                    block.push(columnMedia);
                });
                layoutRow.push(block);
            });
            mediaAssignments.push(layoutRow);
        });

        var mediaAssignmentsJSON = JSON.stringify(mediaAssignments);

        $.ajax({
            type: 'POST',
            url: 'save_media_assignment.php',
            data: {
                mediaAssignments: mediaAssignmentsJSON,
                project_id: projectId
            },
            success: function(response) {
                if (response === 'success') {
                    alert('Media assignments saved successfully.');
                    window.location.href = 'project.php?project_id=' + projectId;
                } else {
                    alert('Failed to save media assignments.');
                }
            },
            error: function() {
                alert('Error occurred while saving media assignments.');
            }
        });
    }

    function toggleHeader() {
        var header = $('#fixedHeader');
        var nonFixedSection = $('#nonFixedSection');
        var toggleBtn = $('.toggleBtn');
        if (header.is(':visible')) {
            header.slideUp(500);
            toggleBtn.text('Show Panel');
        } else {
            header.slideDown(500);
            toggleBtn.text('Hide Panel');
        }
        nonFixedSection.toggleClass('non-fixed-2');
    }
</script>

</body>
</html>
