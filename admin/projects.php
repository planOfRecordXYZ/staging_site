<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <title>Plan of Record</title>
        <link rel="icon" type="image/x-icon" href="../assets/favicon_io/favicon.ico">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/projectstyle.css">
        <script src="../main.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <style>
            .clear button{
                font-family: var(--header-font);
                font-size: 30px;
                cursor: pointer;
                position: absolute;
                right: 120px;
            }
        </style>
    </head>
    <body>
        <div class="basketball desktop-only"><img src="../assets/cursor.png" alt="" x></div>
        <?php include('../reusable/adminNav.php');
        // Establish database connection
        include('../includes/connect.php');?>

        <div class="projects-body">
            <div class="categories">
                <div class="type-of-work">
                    <p>Type of Work</p>
                    <?php
                    // SQL query to select distinct values
                    $query = "SELECT DISTINCT type_of_work FROM projects";

                    // Execute the query
                    $result = mysqli_query($connect, $query);

                    // Initialize an array to store all type_of_work values
                    $typeOfWorkArray = array();

                    // Check if the query was successful
                    if ($result && mysqli_num_rows($result) > 0) {
                        // Fetch each row
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Split the comma-separated values and add them to the array
                            $typeOfWork = explode(',', $row['type_of_work']);
                            foreach ($typeOfWork as $type) {
                                // Trim to remove any leading/trailing spaces
                                $typeOfWorkArray[] = trim($type);
                            }
                        }
                    }

                    // Get unique values
                    $distinctTypeOfWork = array_unique($typeOfWorkArray);

                    // Display checkboxes
                    if (!empty($distinctTypeOfWork)) {
                        echo "<div class='filter-checkboxes'>";
                        foreach ($distinctTypeOfWork as $type) {
                            // Generate checkbox for each distinct value with custom class
                            echo "<label class='custom-label'><input class='custom-checkbox' type='checkbox' name='type_of_work[]' value='$type'>$type</label>";
                        }
                        echo "</div>";
                    }
                     
                    else {
                        // Display an error message if no distinct values found
                        echo "No distinct values found.";
                    }
                    ?>
                </div>
                <div class="industry">
                    <p>Industry</p>
                    <?php
                    // SQL query to select distinct values
                    $query2 = "SELECT DISTINCT industry FROM projects";

                    // Execute the query
                    $result2 = mysqli_query($connect, $query2);

                    // Initialize an array to store all industry values
                    $industries = array();

                    // Check if the query was successful
                    if ($result2 && mysqli_num_rows($result2) > 0) {
                        // Fetch each row
                        while ($row = mysqli_fetch_assoc($result2)) {
                            // Split the comma-separated values and add them to the array
                            $industries = explode(',', $row['industry']);
                            foreach ($industries as $industry) {
                                // Trim to remove any leading/trailing spaces
                                $industryArray[] = trim($industry);
                            }
                        }
                    }

                    // Get unique values
                    $distinctIndustry = array_unique($industryArray);

                    // Display checkboxes
                    if (!empty($distinctIndustry)) {
                        // Start form and checkbox list
                         echo "<div class='filter-checkboxes'>";
                        foreach ($distinctIndustry as $industry) {
                            // Generate checkbox for each distinct value with custom class
                            echo "<label class='custom-label'><input class='custom-checkbox' type='checkbox' name='industry[]' value='$industry'>$industry</label>";
                        }
                        echo "</div>";
                    }
                     else {
                        // Display an error message if no distinct values found
                        echo "No distinct values found.";
                    }
                    ?>
                </div>
                <div class="clear">
                <button type="submit" name="clearBtn" class="btn btn-button clearBtn" onclick="clearCheckboxes()">Clear</button>
                </div>
            </div>
            
            <?php
                echo '<div class="projects">';
                // Query to select all projects
                $project_query='SELECT *
                FROM projects
                ORDER BY addedtime DESC';

                $projects=mysqli_query($connect,$project_query);
                
                // Check for database connection errors
            if (mysqli_connect_error()) {
                die("Connection error: " . mysqli_connect_error());
            }
            if($projects==null){
                echo'<h4>No Projects present in database</h4>';
            }
            else
            {
                foreach($projects as $project){
                    echo '
                        <div class="project">
                            <p class="brand">'.$project['client'].'</p>
                            <p class="industry">'.$project['industry'].'</p>
                            <p class="towork">'.$project['type_of_work'].'</p>
                            <a href="project.php?project_id=' . $project['project_id'] . '">Case Study <img src="/icons/Vector.png" alt="arrow" width="20px" style="margin-left:5px;"></a>
                        </div>
                        <div class="imageList">
                            ';
                           
                            $image_query = "SELECT * FROM images WHERE project_id =" . $project['project_id'];
                            $images = mysqli_query($connect, $image_query);
                            if ($images) {
                                echo '<div class="media-list">';
                                foreach ($images as $image) {
                                    $fileExtension = strtolower(pathinfo($image['image_url'], PATHINFO_EXTENSION));
                                    if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
                                        // Display image
                                        echo '
                                            <div class="media-item image project-image">
                                                <img class="projectImage" src="../uploads/' . $image['image_url'] . '" alt="image">
                                            </div>';
                                    } elseif (in_array($fileExtension, ['mp4', 'webm', 'ogg'])) {
                                        // Display video
                                        echo '
                                            <div class="media-item image project-video">
                                                <video class="projectVideo" src="../uploads/' . $image['image_url'] . '" muted autoplay loop style="width: 100%; height: 100%; object-fit: cover;">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </div>';
                                    }
                                }
                                
                            }
                           
                            
                    echo '</div></div>';  
                }
                
            }
            ?>
             </div>
        </section>
        <?php include('../reusable/footer.php');?>
        <script>
            
           $(document).ready(function(){
            //Function to filter the projects based on industry and type
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
            $(".project").click(function(){
                var imageList = $(this).next(".imageList");
                // Check if the clicked project is already active
                if (imageList.is(":visible")) {
                    // If it's active, slide up the imageList
                    imageList.slideUp(500);
                } else {
                    // If it's not active, slide up all other imageLists and toggle the clicked one
                    $('.imageList').slideUp(500);
                    imageList.slideToggle(500);
                }
            });

            // Hide .imageList initially
            $(".imageList").hide();
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
            
        });
       
        </script>
    </body>
</html>