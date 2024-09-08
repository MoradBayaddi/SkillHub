<?php
session_start();
include './connectiondb.php';

if (isset($_POST['application_id']) && isset($_POST['status'])) {
    $application_id = $_POST['application_id'];
    $status = $_POST['status'];

    // Update query
    $updateQuery = "UPDATE applications SET status = ? WHERE application_id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("si", $status, $application_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Application ID or status missing.']);
}
?>
