<?php
$project_id = $_GET['project_id'];
include ("../includes/connect.php");
$query = "SELECT * FROM projects WHERE `project_id` = '$project_id'";
$project = mysqli_query($connect, $query);
$result = $project->fetch_assoc();

$query_thumb ="SELECT * FROM images WHERE `project_id` = '$project_id' AND `type`='Thumbnail'";
$thumbnail1 = mysqli_query($connect, $query_thumb);
$thumbnail = $thumbnail1->fetch_assoc();

$query_hover ="SELECT * FROM images WHERE `project_id` = '$project_id' AND `type`='Hover_image'";
$hover1 = mysqli_query($connect, $query_hover);
$hover = $hover1->fetch_assoc();

$query_image ="SELECT * FROM images WHERE `project_id` = '$project_id' AND `type`='Project-image'";
$PImage = mysqli_query($connect, $query_image);
$projectImages = [];
while ($image = $PImage->fetch_assoc()) {
    $projectImages[$image['image_id']] = $image; // Store each image with its unique ID
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Media Assignment</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/projectstyle.css">
    <link rel="stylesheet" href="layout.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<style>
    .fixed-header{
        height: 300px;
        overflow: hidden;
        overflow-y: scroll;
    }
    .media-container{
        background-color: black;
    }
    .non-fixed {
            text-align: center;
            margin-top: 350px;
            margin-bottom: 10px;
        }
        .non-fixed-2{
            margin-top: 20px;
        }
        .toggleBtn{
            position: fixed;
            top: 20px;
            right: 12px;
            z-index: 3;
        }
        /* Block used in media insert */
.block1 {
    width: 1478px;
    height: 600px;
    }

/* Adjust size for block2 in the layout-container */
.block2 {
width: 1478px;
height: 1000px;
}
.one-line{
    display: flex;
    gap: 500px;
}
/* Adjust size for block3 in the layout-container */
.block3 {
width: 715px;
height: 1000px;
}

/* Adjust size for block4 in the layout-container */
.block4 {
width: 712px;
height: 480px;
}
.column img{
    width: 100%;
    height: 100%;
    object-fit: contain ;
}
.column video{
    width: 100%;
    height: 100%;
    object-fit: contain ;
}
</style>
<body>
<button onclick="toggleHeader()" class="toggleBtn">Hide panel</button>
<div class="fixed-header" id="fixedHeader">
    <div class="header">
        <div class="one-line">
        <a href="layout.php?project_id=<?php echo $project_id;?>"><img src="../icons/back.png" alt="back-button" width="50px"></a>
        <h1 class="layout-header">Set Media</h1>
        </div>
        
        <p>Drag and drop the images into the blocks below and click on submit the images for the <?php echo $result['client'];?> project page</p>
    </div>
    <div class="media-container">
        <div class="media-item" draggable="true" id="media1">
        <?php
        $fileExtension = pathinfo($thumbnail['image_url'], PATHINFO_EXTENSION);
        if ($fileExtension === 'mp4') {
             // Display video
             echo '<video autoplay muted>';
             echo '<source src="..\uploads\\' . $thumbnail['image_url'] . '" type="video/mp4">';
             echo 'Your browser does not support the video tag.';
             echo '</video>';
        }
        else {
            // Display image
            echo '<img src="..\uploads\\' . $image['image_url'] . '" alt="project image">';
        }
        
        ?>
        </div>
        <div class="media-item" draggable="true" id="media2">
            <img src="..\uploads\<?php echo $hover['image_url'];?>" alt="Image 2" width="100%">
        </div>
        <?php foreach ($projectImages as $imageId => $image): ?>
            <div class="media-item" draggable="true" id="media<?php echo $imageId; ?>"> <!-- Append unique image ID to media item ID -->
            <?php
        $fileExtension = pathinfo($image['image_url'], PATHINFO_EXTENSION);
        if ($fileExtension === 'mp4') {
            // Display video
            echo '<video muted autoplay>';
            echo '<source src="..\uploads\\' . $image['image_url'] . '" type="video/mp4">';
            echo 'Your browser does not support the video tag.';
            echo '</video>';
        } else {
            // Display image
            echo '<img src="..\uploads\\' . $image['image_url'] . '" alt="project image">';
        }
        ?>
            </div>
        <?php endforeach; ?>
    </div>
    </div>
    <div class="non-fixed" id="nonFixedSection">
    <p>Drop the images in the blocks below</p>
    </div>
    <div class="layout-container">
        <!-- Render layout dynamically based on saved layout -->
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
                    echo '<div class="column '.$column.'">' . $column . '</div>';
                }
                echo '</div>';
            }
            echo '</div>';
        }
        ?>
</div>
<div class="options">
    <button onclick="saveMediaAssignment()">Save Media Assignment</button>
    <!-- <button onclick="undo()">Undo</button> -->
</div>

<script>

    var actionStack = [];

    $(document).ready(function() {
        // Function to handle drag start on media items
        function handleMediaDragStart(e) {
            e.originalEvent.dataTransfer.setData('text/plain', e.target.id);
            e.originalEvent.dataTransfer.effectAllowed = 'move';
            console.log(e);
        }

        // Function to handle drag over on layout blocks
        function handleLayoutDragOver(e) {
            if (e.preventDefault) {
                e.preventDefault();
            }
            e.originalEvent.dataTransfer.dropEffect = 'move';
            return false;
        }

        // Function to handle drop on layout blocks
        function handleLayoutDrop(e) {
    if (e.stopPropagation) {
        e.stopPropagation();
    }
    console.log("Data transferred:", e.originalEvent.dataTransfer.getData('text/plain'));
    var mediaId = e.originalEvent.dataTransfer.getData('text/plain');
    console.log("Media ID:", mediaId); // Log the media ID
    
    // Check if it's a video or an image based on the dragged element
    var isImage = e.originalEvent.dataTransfer.types.includes('text/html') && e.originalEvent.dataTransfer.getData('text/html').includes('<img');
    
    // If it's an image, split the ID to get the filename
    if (isImage) {
        mediaId = mediaId.split('/').pop();
    }
    
    var mediaArray = mediaId.split('/');
    var mediaItem = $('#' + mediaId);
    var mediaType = isImage ? 'img' : 'video';
    var mediaSrc = "../uploads/" + mediaId;
    
    // Create the media element (img or video) with the appropriate source URL
    if (isImage) {
        var mediaElement = $('<' + mediaType + '></' + mediaType + '>');
        mediaElement.attr('src', mediaSrc);
        mediaElement.attr('style', ' width: 100%;height: 100%;object-fit: cover;}');
    } else {
        var mediaItem = $('#' + mediaId);
        var mediaSrc = mediaItem.find(mediaType === 'img' ? 'img' : 'source').attr('src');

        var sourceElement = $('<source></source>');
        sourceElement.attr('src', mediaSrc);
        sourceElement.attr('class', mediaItem);

        var mediaElement = $('<' + mediaType + '></' + mediaType + '>');
        mediaElement.append(sourceElement);
        mediaElement.attr('controls', false); // Hide controls for video element
        mediaElement.attr('style', ' width: 100%;height: 100%;object-fit: cover;}');
        mediaElement.attr('autoplay', ''); // Add autoplay for video element
        mediaElement.attr('muted', ''); // Add muted for video element
        mediaElement.attr('loop', ''); // Add loop for video element
    }

    // Append the media element inside the layout block
    $(this).empty().append(mediaElement);

    actionStack.push({ action: 'add', element: mediaElement });

    return false;
}


        // Bind drag start event to media items
        $('.media-item').on('dragstart', handleMediaDragStart);
        // Bind drag over event to layout blocks
        $('.column').on('dragover', handleLayoutDragOver);
        // Bind drop event to layout blocks
        $('.column').on('drop', handleLayoutDrop);
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
                $(this).find('img, source').each(function() {
                    console.log($(this).attr('src'));
                    var mediaType = $(this).is('img') ? 'img' : 'video';
                    if (mediaType==='img'){
                        columnMedia.push($(this).attr('src').split('/').pop());
                    }
                    else{
                        columnMedia.push($(this).attr('src').split('\\').pop());
                    }
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

    function deleteMedia(button) {
        var mediaItem = $(button).parent();
        actionStack.push({ action: 'delete', element: mediaItem });
        mediaItem.remove();
    }

    function undo() {
        if (actionStack.length > 0) {
            var lastAction = actionStack.pop();
            if (lastAction.action === 'add') {
                lastAction.element.remove();
            } else if (lastAction.action === 'delete') {
                $('.layout-block').append(lastAction.element);
            }
        }
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
