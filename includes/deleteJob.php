<?php
session_start();
require_once './connectiondb.php'; // Ensure the path is correct

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['job_id']) || isset($_GET['job_id'])) {
    $job_id = $_POST['job_id'];

    // Check if the job_id is valid
    if (!is_numeric($job_id)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid job ID.']);
        exit;
    }

    // Prepare the DELETE statement
    $query = "DELETE FROM jobs WHERE job_id = ?";
    
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $job_id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Job ID not found or already deleted.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to execute the delete query: ' . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to prepare the delete query: ' . $conn->error]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Job ID not provided.']);
}

$conn->close();
?>
