<?php
session_start();
include('connectiondb.php'); // Include your database connection script

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    // Query to get jobs posted by the user with the given email
    $query = "
        SELECT *
        FROM jobs
        JOIN users ON jobs.posted_by = users.user_id
        WHERE users.email = ?
        ORDER BY jobs.created_at DESC
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $jobs = [];
        while ($row = $result->fetch_assoc()) {
            $jobs[] = $row;
        }
        echo json_encode(['status' => 'success', 'jobs' => $jobs]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No jobs found for this user.']);
    }
} 
else {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
}
?>
