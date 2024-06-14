<!DOCTYPE html>
<html>

<head>
    <!-- Meta charset and title -->
    <meta charset="UTF-8" />
    <title>Add Project</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link rel="icon" type="image/x-icon" href="../assets/favicon_io/favicon.ico">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/projectstyle.css">
    <style>
        .heading{
            display: flex;
            align-items: center;
            gap: 12px;
        }
    </style>
</head>
<?php
// Include navigation
include ('../reusable/adminNav.php');
include ('../includes/connect.php');
?>

<body>
    <div class="new-project">
    <div class="container">
        <div class="row">
            
            <div class="col heading">
                <a href="projects.php"><img src="../icons/back.png" alt="back-button" width="50px"></a>
                <h1 class="display-5 mt-4 mb-4">Add Project</h1>
            </div>
        </div>
        <?php
        // New Project form
        echo '
        <div class="container">
            <div class="row">
                <form action="../admin/addProject.php" method="POST" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="mb-3">
                            <label for="Client" class="form-label">Client</label>
                            <input style="width:400px;" type="text" class="form-control" id="client" name="client" aria-describedby="client" required>
                        </div>
                        <div class="mb-3">
                            <label for="description-short" class="form-label">Short Description</label>
                            <input style="width:700px;" type="text" class="form-control" id="description_short" name="description_short" aria-describedby="description_short" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description_long" class="form-label">Long Description</label>
                        <textarea type="text" class="form-control" id="description_long" name="description_long"
                            aria-describedby="Enter description_long" required></textarea>
                    </div>
                    <div class="form-row">
                        <div class="mb-3">
                            <label for="type_of_work" class="form-label">Type of work</label>
                            <input style="width:400px;" type="text" class="form-control" id="type_of_work" name="type_of_work"
                                aria-describedby="Enter type_of_work" required>
                        </div>
                        <div class="mb-3">
                            <label for="industry" class="form-label">Industry</label>
                            <input style="width:400px;" type="text" class="form-control" id="industry" name="industry"
                                aria-describedby="industry" required>
                        </div>
                        <div class="mb-3">
                            <label for="year" class="form-label">Year</label>
                            <input style="width:400px;" type="text" class="form-control" id="year" name="year"
                                aria-describedby="year" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="url" class="form-label">Website URL</label>
                        <input type="text" class="form-control" id="url" name="url" aria-describedby="url">
                    </div>
                    <div class="form-row">
                    <div class="mb-3">
                        <label for="Thumbnail" class="form-label">Thumbnail Video</label>
                        <div class="container">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group" style="width:400px;">
                                        <span class="input-group-btn">
                                            <span class="btn btn-dark btn-file">
                                                Browse <input type="file" id="Thumbnail" name="Thumbnail" accept=".png, .jpg, .jpeg, .mp4">
                                            </span>
                                        </span>
                                        <input type="text" class="form-control" readonly>
                                    </div>
                                    <img id="img-upload-thumbnail" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="Hover_image" class="form-label">Hover Image</label>
                        <div class="container">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group" style="width:400px;">
                                        <span class="input-group-btn">
                                            <span class="btn btn-dark btn-file">
                                                Browse <input type="file" id="Hover_image" name="Hover_image" accept=".png, .jpg, .jpeg, .mp4">
                                            </span>
                                        </span>
                                        <input type="text" name="Hover_image" class="form-control" readonly>
                                    </div>
                                    <img id="img-upload-hover" />
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="mb-5">
                        <label for="Project-image" class="form-label">Upload the project images</label>
                        <div class="container">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <span class="btn btn-dark btn-file">
                                                Browse <input type="file" id="Project-image" name="Project-image[]" multiple accept=".png, .jpg, .jpeg, .mp4">
                                            </span>
                                        </span>
                                        <input type="text" class="form-control" name="Project-image" id="file-names" readonly>
                                    </div>
                                    <div id="img-upload-project-container"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Submit button -->
                    <div class="mb-3 col text-center">
                    <button type="submit" class="btn btn-dark" name="newProject">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        '; ?>
    </div>
    </div>
    <?php include('../reusable/footer.php');?>
    <script>
        $(document).ready(function() {  
            $(document).on('change', '.btn-file :file', function() {
    // This function triggers when a file input changes
    var input = $(this),
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [label]);
});

$('.btn-file :file').on('fileselect', function(event, label) {
    // This function updates the text input with the file name when a file is selected
    var input = $(this).parents('.input-group').find(':text'),
        log = label;

    if (input.length) {
        input.val(log);
    } else {
        if (log) alert(log);
    }
});

function readURL(input, imgElementId) {
    // This function reads the file URL and displays the image or video in the specified element
    if (input.files && input.files[0]) {
        var file = input.files[0];
        var reader = new FileReader();

        // Check if the file type is an image or a video
        if (file.type.startsWith('image/')) {
            reader.onload = function(e) {
                $(imgElementId).attr('src', e.target.result).show();
                $(imgElementId).siblings('video').hide(); // Hide the video element if it exists
            }
            reader.readAsDataURL(file);
        } else if (file.type.startsWith('video/')) {
            var video = $('<video/>', {
                'src': URL.createObjectURL(file),
                'controls': true,
                'style': 'max-width: 100%; height: auto;'
            });

            $(imgElementId).hide(); // Hide the image element
            $(imgElementId).siblings('video').remove(); // Remove any existing video element
            $(imgElementId).parent().append(video); // Append the new video element
        }
    }
}

function readMultipleURL(input, containerId) {
    // This function reads multiple files and displays them as thumbnails in the specified container
    if (input.files) {
        var container = $(containerId);
        container.empty(); // Clear previous previews
        var fileNames = [];
        for (var i = 0; i < input.files.length; i++) {
            if (input.files[i]) {
                var file = input.files[i];
                fileNames.push(file.name); // Add file name to the array

                // Check if the file type is an image
                if (file.type.startsWith('image/')) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('<img/>', {
                            'src': e.target.result,
                            'class': 'img-thumbnail',
                            'style': 'margin: 10px; max-width: 100px; max-height: 100px;'
                        }).appendTo(container);
                    }
                    reader.readAsDataURL(file);
                }
                // Check if the file type is a video
                else if (file.type.startsWith('video/')) {
                    var video = document.createElement('video');
                    video.src = URL.createObjectURL(file);
                    video.controls = true;
                    video.classList.add('video-thumbnail');
                    video.style.margin = '10px';
                    video.style.maxWidth = '100px';
                    video.style.maxHeight = '100px';
                    container.append(video);
                }
            }
        }
        // Set all file names in the text input
        $('#file-names').val(fileNames.join(', ')); // Join file names with ', ' separator
    }
}

// Event listener for changes in the project image input
$("#Project-image").change(function() {
    readMultipleURL(this, '#img-upload-project-container');
});

// Event listener for changes in the thumbnail image input
$("#Thumbnail").change(function() {
    readURL(this, '#img-upload-thumbnail');
});

// Event listener for changes in the hover image input
$("#Hover_image").change(function() {
    readURL(this, '#img-upload-hover');
});
});

    </script>
</body>

</html>
