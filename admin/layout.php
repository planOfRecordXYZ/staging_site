<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layout Configuration</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/projectstyle.css">
    <link rel="stylesheet" href="layout.css">
    <link rel="icon" type="image/x-icon" href="./assets/favicon_io/favicon.ico">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .block {
            width: 150px;
            height: 150px;
            margin: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
            cursor: move;
            position: relative;
        }
        .layout-container {
            background-color: #F0F0F0;
            width: 100%;
            min-height: 400px;
            border: 2px dashed #ccc;
            display: flex;
            flex-direction: column;
            padding: 10px;
        }
        .layout-zone, .layout-row {
            width: 100%;
            min-height: 400px;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            padding: 20px;
        }
        .layout-row {
            flex-direction: row;
        }
        .layout-block {
            background-color: white;
            width: 100%;
            display: flex;
        }
        .column {
            background-color: white;
            overflow: hidden;
        }
        .column img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .layout-zone .column {
            margin: 5px;
            border: 1px solid #ccc;
            padding: 20px;
            flex: 1;
            position: relative;
        }
        .layout-row .column {
            margin: 5px;
            border: 1px solid #ccc;
            flex: 1;
            position: relative;
        }
        .delete-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background: red;
            color: white;
            border: none;
            cursor: pointer;
        }
        .layout-header {
            font-size: 50px;
            text-align: center;
        }
        .header {
            margin: 20px;
        }
        .header p {
            margin: 10px;
            text-align: center;
        }
        .options {
            margin: 20px;
            display: flex;
            justify-content: space-evenly;
        }
        button:hover {
            background-color: black;
            color: white;
        }
        .fixed-header {
            width: 100%;
            top: 0;
            position: fixed;
            background-color: white;
            z-index: 2;
            border: 1px solid #ccc;
        }
        .block-container {
            display: flex;
            flex-wrap: wrap;
            border: 1px solid #ccc;
            padding: 20px;
        }
        .non-fixed {
            text-align: center;
            margin-top: 470px;
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
    </style>
</head>
<body>
    <!-- Fetch project details from the database -->
    <?php
    $project_id = $_GET['project_id'];
    include ("../includes/connect.php");
    $query = "SELECT * FROM projects WHERE `project_id` = '$project_id'";
    $project = mysqli_query($connect, $query);
    $result = $project->fetch_assoc();
    ?>
    <!-- Button to toggle the visibility of the fixed header -->
    <button onclick="toggleHeader()" class="toggleBtn">Hide panel</button>
    <!-- Fixed header section -->
    <div class="fixed-header" id="fixedHeader">
        <div class="header">
            <!-- Display the project client name -->
            <h1 class="layout-header">Set Layout - <?php echo $result['client'];?></h1>
            <p>Drag and drop the blocks below to the container and click on submit layout to set the layout for the <?php echo $result['client'];?> project page</p>
        </div>
        <!-- Container for draggable blocks -->
       
        <div class="block-container">
            <div class="block" draggable="true" id="block1">1478*600</div>
            <div class="block" draggable="true" id="block2">1478*1000</div>
            <div class="block" draggable="true" id="block3">715*1000</div>
            <div class="block" draggable="true" id="block4">712*480</div>
            <div class="block" draggable="true" id="block5">1280*720</div>
             <!-- Keep adding more blocks if required and set the styling for the ID -->
        </div>
        <!-- Options for adding blocks to new columns or rows -->
        <div class="options">
            <div class="dropdown">
                <label for="layoutOption">Add to:</label>
                <select id="layoutOption">
                    <option value="newColumn">New Column</option>
                    <option value="newRow">New Row</option>
                </select>
            </div>
        </div>
    </div>
    <!-- Section to prompt user to drop blocks -->
    <div class="non-fixed" id="nonFixedSection">
        <p>Drop the blocks in the container below</p>
    </div>
    <!-- Container for the layout rows and zones -->
    <div class="layout-container" id="layout-rows">
        <div class="layout-zone" id="layoutZone">
            <!-- Blocks can be dropped here -->
        </div>
    </div>
    <!-- Button to save the layout -->
    <div class="options">
        <button onclick="saveLayout()">Save Layout</button>
    </div>

    <script>
    var actionStack = [];
    var layoutData = [];

    $(document).ready(function () {
        //function to handle the drop
        function handleDrop(e) {
            e.preventDefault();
            e.stopPropagation();

            var blockId = e.originalEvent.dataTransfer.getData('text/plain');
            var block = $('#' + blockId).clone();
            block.removeClass('block').addClass('layout-block');
            block.removeAttr('draggable');
            block.append('<button class="delete-btn" onclick="deleteBlock(this)">X</button>');

            var layoutOption = $('#layoutOption').val();
            var layoutZone = $('#layoutZone');
            var lastRow = layoutZone.children('.layout-row').last();

            if (layoutOption === 'newRow' || lastRow.length === 0) {
                var newRow = $('<div class="layout-row"></div>');
                newRow.append(block);
                layoutZone.append(newRow);
                layoutData.push([blockId]);
            } else {
                lastRow.append(block);
                layoutData[layoutData.length - 1].push(blockId);
            }

            actionStack.push({ action: 'add', element: block });
        }

        // Event listener for dragging blocks
        $('.block').on('dragstart', function (e) {
            e.originalEvent.dataTransfer.setData('text/plain', e.target.id);
            e.originalEvent.dataTransfer.effectAllowed = 'move';
        });

        // Event listener for dragging over the layout zone
        $('#layoutZone').on('dragover', function (e) {
            e.preventDefault();
            e.originalEvent.dataTransfer.dropEffect = 'move';
        });

        // Event listener for dropping blocks into the layout zone
        $('#layoutZone').on('drop', handleDrop);
    });

    // Function to save the layout
    function saveLayout() {
        var projectId = <?php echo json_encode($project_id); ?>;
        $.ajax({
            type: 'POST',
            url: 'save_layout.php',
            data: {
                layout: JSON.stringify(layoutData),
                project_id: projectId
            },
            success: function (response) {
                if (response === 'success') {
                    alert('Layout saved successfully.');
                    //redirect to set media page
                    window.location.href = 'setMedia.php?project_id=' + projectId;
                } else {
                    alert('Failed to save layout.');
                }
            },
            error: function () {
                alert('Error occurred while saving layout.');
            }
        });
    }

    // Function to delete a block from the layout
    function deleteBlock(button) {
        var block = $(button).parent();
        var row = block.parent();
        var blockId = block.attr('id');

        actionStack.push({ action: 'delete', element: block });

        var rowIndex = $('#layoutZone .layout-row').index(row);
        var colIndex = row.children().index(block);

        layoutData[rowIndex].splice(colIndex, 1);

        if (layoutData[rowIndex].length === 0) {
            layoutData.splice(rowIndex, 1);
            row.remove();
        } else {
            block.remove();
        }
    }

    // Function to undo the last action -- Currently not in use 
    function undo() {
        if (actionStack.length > 0) {
            var lastAction = actionStack.pop();
            if (lastAction.action === 'add') {
                var block = lastAction.element;
                var row = block.parent();

                var rowIndex = $('#layoutZone .layout-row').index(row);
                var colIndex = row.children().index(block);

                layoutData[rowIndex].splice(colIndex, 1);

                if (layoutData[rowIndex].length === 0) {
                    layoutData.splice(rowIndex, 1);
                    row.remove();
                } else {
                    block.remove();
                }
            } else if (lastAction.action === 'delete') {
                var block = lastAction.element;
                var row = block.parent();

                if (row.length === 0) {
                    var newRow = $('<div class="layout-row"></div>');
                    newRow.append(block);
                    $('#layoutZone').append(newRow);
                    layoutData.push([block.attr('id')]);
                } else {
                    row.append(block);
                    layoutData[layoutData.length - 1].push(block.attr('id'));
                }
            }
        }
    }

    // Function to toggle the visibility of the fixed header
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
