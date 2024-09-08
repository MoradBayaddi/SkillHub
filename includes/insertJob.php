<?php
session_start();
include './connectiondb.php';

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    // Fetch user ID based on email
    $query = "SELECT user_id FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['user_id'];

        // Validate and insert job data
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['jobTitle']);
            $description = trim($_POST['jobDescription']);
            $location = trim($_POST['jobLocation']);
            $salary = trim($_POST['jobSalary']);
            $category = trim($_POST['category']);

            if (!empty($title) && !empty($description) && !empty($location) && is_numeric($salary)) {
                // Insert job into database
                $insert_query = "INSERT INTO jobs (title, description, location, salary, posted_by, categorie_id) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($insert_query);
                $stmt->bind_param('sssdis', $title, $description, $location, $salary, $user_id, $category);
                
                if ($stmt->execute()) {
                    echo json_encode(['status' => 'success']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to insert job.']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Please fill in all fields correctly.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'User not found.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
}
?>
