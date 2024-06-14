<?php
include ("../includes/connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $project_id = $_POST['project_id'];
    $mediaAssignments = $_POST['mediaAssignments'];

    // Prepare and execute the SQL query to insert the JSON string into the layout table
    $query = "UPDATE layout SET media_assignments = ? WHERE project_id = ?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param('si', $mediaAssignments, $project_id);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }

    $stmt->close();
    $connect->close();
}
?>
