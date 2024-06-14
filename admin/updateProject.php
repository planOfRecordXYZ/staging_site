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
    $projectImages[] = $image;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Project - <?php echo $result['client'];?></title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
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
        .currentImages{
            width: 100%;
            overflow-x: scroll;
        }
    </style>
</head>
<body>
<div class="updateProject">
    <div class="container">
        <div class="row">
            <div class="col heading">
            <a href="project.php?project_id=<?php echo $project_id;?>"><img src="../icons/back.png" alt="back-button" width="50px"></a>
                <h1 class="display-5 mt-4 mb-4">Update Project</h1>
            </div>
            <form action="../admin/Update.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="project_id" value="<?php echo $result['project_id']; ?>">
                    <div class="form-row">
                        <div class="mb-3">
                            <label for="Client" class="form-label">Client</label>
                            <input style="width:400px;" type="text" class="form-control" id="client" name="client" value="<?php echo $result['client']; ?>" aria-describedby="client" required>
                        </div>
                        <div class="mb-3">
                            <label for="description-short" class="form-label">Short Description</label>
                            <input style="width:700px;" type="text" class="form-control" id="description_short" name="description_short" value="<?php echo $result['description_short']; ?>" aria-describedby="description_short" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description_long" class="form-label">Long Description</label>
                        <textarea type="text" class="form-control" id="description_long" name="description_long"
                            aria-describedby="Enter description_long" required><?php echo htmlspecialchars($result['description_long']); ?></textarea>
                    </div>
                    <div class="form-row">
                        <div class="mb-3">
                            <label for="type_of_work" class="form-label">Type of work</label>
                            <input style="width:400px;" type="text" class="form-control" id="type_of_work" name="type_of_work"
                                aria-describedby="Enter type_of_work" value="<?php echo $result['type_of_work']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="industry" class="form-label">Industry</label>
                            <input style="width:400px;" type="text" class="form-control" id="industry" name="industry"
                                aria-describedby="industry" value="<?php echo $result['industry']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="year" class="form-label">Year</label>
                            <input style="width:400px;" type="text" class="form-control" id="year" name="year"
                                aria-describedby="year" value="<?php echo $result['year']; ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="url" class="form-label">Website URL</label>
                        <input type="text" class="form-control" id="url" name="url" value="<?php echo $result['url']; ?>" aria-describedby="url">
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

                                    <input type="hidden" name="thumbimage_id" value="<?php echo $thumbnail['image_id']; ?>">
                                    <div id="img-upload-thumbnail"></div>
                                    <div class="currentImage">
                                        <input type="hidden" name="thumb_old" value="<?php echo $thumbnail['image_url']; ?>">
                                        Current Thumbnail:
                                        <video src="<?php echo"../uploads/". $thumbnail['image_url']; ?>" width="100px" alt="">
                                    </div>
                                    
                                    
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
                                    <input type="hidden" name="hoverimage_id" value="<?php echo $hover['image_id']; ?>">
                                    <img id="img-upload-hover" />
                                    <div class="currentImage">
                                        <input type="hidden" name="hover_old" value="<?php echo $hover['image_url']; ?>">
                                        Current Hover Image:
                                        <img src="<?php echo"../uploads/". $hover['image_url']; ?>" width="100px" alt="">
                                    </div>
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
                                    Current Project Images:
                                    <div class="currentImages" style="display:flex;gap:30px">
                                   
                                    <?php foreach ($projectImages as $projectImage): ?>
                                        <div class="currentImage">
                                            <img class="pImage" src="<?php echo "../uploads/" . $projectImage['image_url']; ?>" height="200px" alt="">
                                            <input type="hidden" name="project_image_ids[]" value="<?php echo $projectImage['image_id']; ?>">
                                            <input type="hidden" name="project_image_urls[]" value="<?php echo $projectImage['image_url']; ?>">
                                            <button type="button" class="btn btn-danger btn-sm del-btn" onclick="deleteImage(this, '<?php echo $projectImage['image_id']; ?>', '<?php echo $projectImage['image_url']; ?>')">Delete</button>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Submit button -->
                    <div class="mb-3 col text-center">
                    <button type="submit" class="btn btn-dark" name="update">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
    </div>
    <?php include('../reusable/footer.php');?>
        </div>
        <script>
            function deleteImage(button,imageId, imageUrl) {
        // Confirm deletion
    if (!confirm("Are you sure you want to delete this image?")) {
        return;
    }

    // Perform the AJAX request to delete the image
    $.ajax({
        type: "POST",
        url: "delete_image.php",
        data: { image_id: imageId, image_url: imageUrl },
        success: function(response) {
            if (response.trim() === "success") {
                // Remove the specific image container
                $(button).closest('.currentImage').remove();
               
            } else {
                // If deletion fails, display an error message
                alert("Failed to delete image.");
            }
        },
        error: function() {
            // If there's an error with the AJAX request, display an error message
            alert("Error occurred while deleting image.");
        }
    });
            }
        $(document).ready(function() {
            
            $(document).on('change', '.btn-file :file', function() {
                var input = $(this),
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                input.trigger('fileselect', [label]);
            });

            $('.btn-file :file').on('fileselect', function(event, label) {
                var input = $(this).parents('.input-group').find(':text'),
                    log = label;

                if (input.length) {
                    input.val(log);
                } else {
                    if (log) alert(log);
                }
            });

            function readURL(input, imgElementId) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            var fileExtension = input.files[0].name.split('.').pop().toLowerCase();
            if (fileExtension === 'mp4' || fileExtension === 'webm' || fileExtension === 'ogg') {
                $(imgElementId).empty(); // Clear previous content
                $('<video controls width="150">').attr('src', e.target.result).appendTo(imgElementId);
            } else {
                $(imgElementId).attr('src', e.target.result);
            }
        }

        reader.readAsDataURL(input.files[0]);
    }
}

            function readMultipleURL(input, containerId) {
            if (input.files) {
                var container = $(containerId);
                container.empty(); // Clear previous previews
                var fileNames = [];
                for (var i = 0; i < input.files.length; i++) {
                    if (input.files[i]) {
                        fileNames.push(input.files[i].name); // Add file name to the array
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            $('<img/>', {
                                'src': e.target.result,
                                'class': 'img-thumbnail',
                                'style': 'margin: 10px; max-width: 100px; max-height: 100px;'
                            }).appendTo(container);
                        }
                        reader.readAsDataURL(input.files[i]);
                    }
                }
                console.log(fileNames.length);
                // Set all file names in the text input
                var concatenatedNames = '';
                for (var i = 0; i < fileNames.length; i++) {
                    concatenatedNames += fileNames[i];
                    if (i < fileNames.length - 1) {
                        concatenatedNames += ', '; // Add separator if not the last file name
                    }
                }
                console.log(concatenatedNames);
                $('#file-names').val(concatenatedNames);
                console.log("Values: "+document.getElementById('file-names').value);

                // $('#file-names').val(fileNames.join(', ')); // Join file names with ', ' separator
            }
        }

            $("#Project-image").change(function() {
                readMultipleURL(this, '#img-upload-project-container');
            });

            $("#Thumbnail").change(function() {
                readURL(this, '#img-upload-thumbnail');
            });

            $("#Hover_image").change(function() {
                readURL(this, '#img-upload-hover');
            });
        });
    </script>
</body>

</html>
