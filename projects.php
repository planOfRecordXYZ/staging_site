<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan of Record</title>
    <link rel="icon" type="image/x-icon" href="./assets/favicon_io/favicon.ico">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/projectstyle.css">
    <link rel="stylesheet" href="./css/mobile.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <script src="./main.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="basketball desktop-only">
        <img src="./assets/cursor.png" alt="" width="24px">
    </div>
    <?php 
        // Include navigation bar
        include('reusable/nav.php'); 
        
        // Establish database connection
        include('includes/connect.php');
    ?>

    <section class="mobile-menu mobile-only closed">
            <ul class="mobile-only">
                <li><a href="./index.php">Plan of Record</a></li>
                <li id="closeToggle" class="menu-toggle"><a href="#"><img src="./assets/close.png" alt=""></a></li>
            </ul>
            <ul class="mobile-navitems">
                <li><a href="./index.php">Home</a></li>
                <li><a href="./projects.php">Index</a></li>
                <li><a href="./about.php">About</a></li>
                <li><a href="./approach.php">Approach</a></li>
                <li><a href="./contactUs.php">Contact</a></li>
            </ul>
        </section>

    <div class="projects-body">
       
        <div class="projects">
            <?php
            // Query to select all projects
            $project_query = 'SELECT * FROM projects ORDER BY addedtime DESC';
            $projects = mysqli_query($connect, $project_query);

            // Check for database connection errors
            if (mysqli_connect_error()) {
                die("Connection error: " . mysqli_connect_error());
            }

            if ($projects == null) {
                echo '<h4>No Projects present in database</h4>';
            } else {
                // Displaying projects in rows
                foreach ($projects as $project) {
                    echo '
                        <div class="project">
                            <p class="brand">' . htmlspecialchars($project['client']) . '</p>
                            <p class="industry">' . htmlspecialchars($project['industry']) . '</p>
                            <p class="towork">' . htmlspecialchars($project['type_of_work']) . '</p>
                            <p><a style="float:left;" href="project.php?project_id=' . $project['project_id'] . '">Case Study <i class="bx bx-right-arrow-alt"></i></a></p>
                        </div>
                        <div class="imageList">';
                    
                    // Query to select all images for the current project
                    $image_query = "SELECT * FROM images WHERE project_id =" . $project['project_id'];
                    $images = mysqli_query($connect, $image_query);
                    if ($images) {

                        $thumbnails = [];
                        $otherImages = [];
        
                        // Separate the thumbnail from other images
                        foreach ($images as $image) {
                            if ($image['type'] == 'Thumbnail') {
                                $thumbnails[] = $image;
                            } else {
                                $otherImages[] = $image;
                            }
                        }
        
                        // Merge the thumbnail at the front of other images
                        $sortedImages = array_merge($thumbnails, $otherImages);
        


                        echo '<div class="media-list">';
                        foreach ($sortedImages as $image) {
                            $fileExtension = strtolower(pathinfo($image['image_url'], PATHINFO_EXTENSION));
                            if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
                                // Display image
                                echo '
                                    <div class="media-item image project-image">
                                        <img class="projectImage" src="./uploads/' . htmlspecialchars($image['image_url']) . '" alt="image">
                                    </div>';
                            } elseif (in_array($fileExtension, ['mp4', 'webm', 'ogg', 'mov'])) {
                                // Display video
                                echo '
                                    <div class="media-item image project-video">
                                        <video class="projectVideo" src="./uploads/' . htmlspecialchars($image['image_url']) . '" muted autoplay loop style="width: 100%; height: 100%; object-fit: cover;">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>';
                            }
                        }
                        echo '</div>';
                    }
                    echo '</div>';
                }
            }
            ?>
        </div>


        <div class="projects-mobile mobile-only">
            <?php
            // Query to select all projects
            $project_query = 'SELECT * FROM projects ORDER BY addedtime DESC';
            $projects = mysqli_query($connect, $project_query);

            // Check for database connection errors
            if (mysqli_connect_error()) {
                die("Connection error: " . mysqli_connect_error());
            }

            if ($projects == null) {
                echo '<h4>No Projects present in database</h4>';
            } else {
                // Displaying projects in rows
                foreach ($projects as $project) {
                    echo '
                        <div class="project">
                            <p class="brand">' . htmlspecialchars($project['client']) . '</p>
                            <p class="towork">' . htmlspecialchars($project['type_of_work']) . '</p>
                            <p><a style="float:left;"><i class="bx bx-plus icon-toggle" style="font-size:24px;"></i></a></p>
                        </div>
                        <div class="imageList">';
                    
                    // Query to select all images for the current project
                    $image_query = "SELECT * FROM images WHERE project_id =" . $project['project_id'];
                    $images = mysqli_query($connect, $image_query);
                    if ($images) {

                        $thumbnails = [];
                        $otherImages = [];
        
                        // Separate the thumbnail from other images
                        foreach ($images as $image) {
                            if ($image['type'] == 'Thumbnail') {
                                $thumbnails[] = $image;
                            } else {
                                $otherImages[] = $image;
                            }
                        }
        
                        // Merge the thumbnail at the front of other images
                        $sortedImages = array_merge($thumbnails, $otherImages);
    
                        
                        echo '<div class="media-list">';
                        foreach ($sortedImages as $image) {
                            $fileExtension = strtolower(pathinfo($image['image_url'], PATHINFO_EXTENSION));
                            if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
                                // Display image
                                echo '
                                    <div class="media-item image project-image">
                                        <img class="projectImage" src="./uploads/' . htmlspecialchars($image['image_url']) . '" alt="image">
                                    </div>';
                            } elseif (in_array($fileExtension, ['mp4', 'webm', 'ogg', 'mov'])) {
                                // Display video
                                echo '
                                    <div class="media-item image project-video">
                                        <video class="projectVideo" src="./uploads/' . htmlspecialchars($image['image_url']) . '" muted autoplay loop style="width: 100%; height: 100%; object-fit: cover;">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>';
                            }
                        }
                        echo '</div>';
                    }
                    echo '
                             <div class="project-casestudy">
                                <div class="casestudy-mobile"> 
                                 <a style="float:left; color:white;" href="project.php?project_id=' . $project['project_id'] . '">See Case Study</a>
                                </div>

                                <div class="image-counter">
                                  <span class="image-count" style="float:left; color:white;">1/1</span>
                                </div>
                            </div>
                          
                            
                          ';
                    echo '</div>';
                }
            }
            ?>
        </div>
    </div>

    <?php include('reusable/footer.php'); ?>

    <script>
        $(document).ready(function(){
            // Function to filter the projects based on industry and type
            function filterProjects() {
                // Collect selected types of work and industries
                var selectedTypesOfWork = $("input[name='type_of_work[]']:checked").map(function() {
                    return $(this).val();
                }).get();
                var selectedIndustries = $("input[name='industry[]']:checked").map(function() {
                    return $(this).val();
                }).get();

                // Show all projects initially
                $(".project").show();

                // Filter projects based on selected checkboxes
                $(".project").each(function(){
                    var projectTypeOfWork = $(this).find(".towork").text().trim();
                    var projectIndustry = $(this).find(".industry").text().trim();

                    // Check if any selected type of work matches any part of the project's type of work
                    var matchesTypeOfWork = selectedTypesOfWork.some(function(value) {
                        return projectTypeOfWork.includes(value.trim());
                    });

                    // Check if any selected industry matches any part of the project's industry
                    var matchesIndustry = selectedIndustries.some(function(value) {
                        return projectIndustry.includes(value.trim());
                    });

                    // Hide projects that don't match selected types of work or industries
                    if(selectedTypesOfWork.length > 0 && !matchesTypeOfWork) {
                        $(this).hide();
                    }
                    if(selectedIndustries.length > 0 && !matchesIndustry) {
                        $(this).hide();
                    }
                });
            }

            // Call filterProjects initially to show all projects
            filterProjects();

            // Call filterProjects whenever checkboxes are changed
            $(".custom-checkbox").change(function(){
                filterProjects();
            });

            // Toggle image list visibility on project click
            $(".project").click(function(){
                var imageList = $(this).next(".imageList");
                //Variable to toggle plus icon 
                var icon = $(this).find(".icon-toggle");
                // Check if the clicked project is already active
                if (imageList.is(":visible")) {
                    // If it's active, slide up the imageList
                    imageList.slideUp(500);
                    //Removes the plus icon
                    icon.removeClass('bx-minus').addClass('bx-plus');
                } else {
                    // If it's not active, slide up all other imageLists and toggle the clicked one
                    $('.imageList').slideUp(500);
                    //Removes the minus icon
                    $('.icon-toggle').removeClass('bx-minus').addClass('bx-plus');
                    imageList.slideToggle(500);
                    //Adds the plus icon
                    icon.removeClass('bx-plus').addClass('bx-minus');
                }

                    // Update the image counter
                    var mediaItems = imageList.find('.media-item');
                    var totalImages = mediaItems.length;
                    if (totalImages > 0) {
                        updateImageCounter(0, totalImages);

                       // Observe each media item
                        const observer = new IntersectionObserver((entries) => {
                            entries.forEach(entry => {
                                if (entry.isIntersecting) {
                                    const index = mediaItems.index(entry.target);
                                    updateImageCounter(index, totalImages);
                                }
                            });
                        }, { threshold: 0.5 });

                        mediaItems.each(function() {
                            observer.observe(this);
                        });
                        } else {
                            $('.image-count').text('0/0');
                        }
            });

            // Hide .imageList initially
            $(".imageList").hide();

            // Clear function
            function clearCheckboxes() {
                // Get all checkboxes with the custom-checkbox class
                var checkboxes = document.querySelectorAll('.custom-checkbox');
                // Loop through each checkbox and set it to unchecked
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = false;
                });
                // Call filterProjects to reset the filters and show all projects
                filterProjects();
            }

            // Attach clearCheckboxes function to the Clear button
            $(".clearBtn").click(clearCheckboxes);

             // Function to update the image counter
            function updateImageCounter(currentIndex, totalImages) {
                $('.image-count').text((currentIndex + 1) + '/' + totalImages);
            }
        });
    </script>
</body>
</html>
