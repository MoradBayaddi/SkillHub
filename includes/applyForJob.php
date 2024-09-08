<?php
session_start();
include './connectiondb.php';

$response = array('status' => 'error', 'message' => 'Something went wrong.');

if (isset($_SESSION['email']) && $_SESSION['role'] === 'worker') {
    // Check the IDs and cover letter
    if (isset($_POST['job_id']) && isset($_POST['worker_id']) && isset($_POST['coverLetter'])) {
        $job_id = $_POST['job_id'];
        $worker_id = $_POST['worker_id'];
        $cover_letter = $_POST['coverLetter'];

        // Check if the worker has already applied for this job
        $checkQuery = "SELECT * FROM applications WHERE job_id = ? AND worker_id = ?";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param("ii", $job_id, $worker_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $response['status'] = 'error';
            $response['message'] = 'You have already applied for this job.';
        } else {
            // Insert the application into the database
            $applyQuery = "INSERT INTO applications (job_id, worker_id, cover_letter) VALUES (?, ?, ?)";
            $stmt->prepare($applyQuery);
            $stmt->bind_param("iis", $job_id, $worker_id, $cover_letter);
            
            if ($stmt->execute()) {
                $response['status'] = 'success';
                $response['message'] = 'Your application has been submitted successfully.';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Failed to submit your application. Please try again later.';
            }
        }
        $stmt->close();
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Missing required fields.';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'You must be logged in as a worker to apply for this job.';
}

echo json_encode($response);



// $response = array('status' => 'error', 'message' => 'Something went wrong.');

// if (isset($_SESSION['email']) && $_SESSION['role'] === 'worker') {
//     if (isset($_POST['job_id'])) {
//         $job_id = $_POST['job_id'];
//         $worker_id = $_SESSION['user_id']; // Assuming you store the user's ID in the session as `user_id`
        
//         // Check if the worker has already applied for this job
//         $checkQuery = "SELECT * FROM applications WHERE job_id = ? AND worker_id = ?";
//         $stmt = $conn->prepare($checkQuery);
//         $stmt->bind_param("ii", $job_id, $worker_id);
//         $stmt->execute();
//         $result = $stmt->get_result();
        
//         if ($result->num_rows > 0) {
//             $response['message'] = 'You have already applied for this job.';
//         } else {
//             // Insert the application into the database
//             $applyQuery = "INSERT INTO applications (job_id, worker_id,cover) VALUES (?, ?)";
//             $stmt = $conn->prepare($applyQuery);
//             $stmt->bind_param("ii", $job_id, $worker_id);
            
//             if ($stmt->execute()) {
//                 $response['status'] = 'success';
//                 $response['message'] = 'Your application has been submitted successfully.';
//             } else {
//                 $response['message'] = 'Failed to submit your application. Please try again later.';
//             }
//         }

//         $stmt->close();
//     } else {
//         $response['message'] = 'Job ID is missing.';
//     }
// } else {
//     $response['message'] = 'You must be logged in as a worker to apply for this job.';
// }

// echo json_encode($response);
?>
