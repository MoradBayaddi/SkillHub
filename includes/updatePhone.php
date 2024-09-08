<?php
session_start();
include './connectiondb.php';

if (isset($_POST['phone'])) {
    $phone = $_POST['phone'];
    $userId = $_SESSION['user_id']; // Assuming user_id is stored in session

    // Update query
    $updateQuery = "UPDATE users SET phone_number = ? WHERE user_id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("si", $phone, $userId);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Phone number missing.']);
}
?>
