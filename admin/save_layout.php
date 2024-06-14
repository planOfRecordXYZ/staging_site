<?php
// Include database connection
include("../includes/connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from POST request
    $layoutData = json_decode($_POST['layout'], true);
    $projectId = $_POST['project_id'];

    // Serialize layout data to JSON
    $layoutJson = json_encode($layoutData);

    // Check if the project_id already exists in the layout table
    $checkQuery = "SELECT COUNT(*) as count FROM layout WHERE project_id = ?";
    $checkStmt = $connect->prepare($checkQuery);
    $checkStmt->bind_param("i", $projectId);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    $row = $checkResult->fetch_assoc();
    
    // If project_id exists, update the layout_data
    if ($row['count'] > 0) {
        $updateQuery = "UPDATE layout SET layout_data = ? WHERE project_id = ?";
        $updateStmt = $connect->prepare($updateQuery);
        $updateStmt->bind_param("si", $layoutJson, $projectId);

        if ($updateStmt->execute()) {
            echo "success";
        } else {
            echo "error";
        }
        $updateStmt->close();
    } else {
        // If project_id does not exist, insert a new row
        $insertQuery = "INSERT INTO layout (project_id, layout_data) VALUES (?, ?)";
        $insertStmt = $connect->prepare($insertQuery);
        $insertStmt->bind_param("is", $projectId, $layoutJson);

        if ($insertStmt->execute()) {
            echo "success";
        } else {
            echo "error";
        }
        $insertStmt->close();
    }

    // Close database connection
    $checkStmt->close();
    $connect->close();
}
?>
