<?php
session_start();
include './connectiondb.php';

if (isset($_POST['password'])) {
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Encrypt the password
    $userId = $_SESSION['user_id']; // Assuming user_id is stored in session

    // Update query
    $updateQuery = "UPDATE users SET password = ? WHERE user_id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("si", $password, $userId);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Password missing.']);
}
?>
