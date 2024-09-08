<?php
include('./connectiondb.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $job_id = intval($_POST['job_id']);
    $jobTitle = htmlspecialchars($_POST['jobTitle']);
    $category = intval($_POST['category']);
    $jobDescription = htmlspecialchars($_POST['jobDescription']);
    $jobLocation = htmlspecialchars($_POST['jobLocation']);
    $jobSalary = floatval($_POST['jobSalary']);

    $query = "UPDATE jobs SET title = ?, categorie_id = ?, description = ?, location = ?, salary = ? WHERE job_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sissdi", $jobTitle, $category, $jobDescription, $jobLocation, $jobSalary, $job_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update job.']);
    }

    $stmt->close();
    mysqli_close($conn);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>