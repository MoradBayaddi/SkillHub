<?php
session_start();
include './connectiondb.php';

if (isset($_POST['application_id'])) {
    $application_id = $_POST['application_id'];

    // Delete query
    $deleteQuery = "DELETE FROM applications WHERE application_id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $application_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success','message'=>'deleted successfuly']);
    } else {
        echo json_encode(['status' => 'error']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Application ID missing.']);
}
?>
