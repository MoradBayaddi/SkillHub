<?php
if (isset($_GET['job_id']) && is_numeric($_GET['job_id']) && isset($_GET['worker_id']) && isset($_GET['client_id'])) {
    $job_id = $_GET['job_id'];
    $client_id = $_GET['client_id'];
    $worker_id = $_GET['worker_id'];
    include ('./connectiondb.php');
    
    // Prepare the query to fetch the job details
    $query = "
        SELECT a.application_id,j.job_id,worker.name as worker,worker.email,worker.phone_number,a.*,
        client.name as client_name,client.email as client_email,client.phone_number as client_phone
        FROM applications a 
        INNER JOIN users as worker ON a.worker_id = worker.user_id
        INNER JOIN jobs j ON a.job_id = j.job_id
        inner join users as client on j.posted_by=client.user_id
        WHERE 
        client.user_id=? and 
        worker.user_id=? and 
        j.job_id=? group by j.job_id;
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("iii",$client_id,$worker_id, $job_id,);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $applicationDetail = $result->fetch_assoc();
        error_log(print_r($applicationDetail, true)); // Log the fetched job details
        echo json_encode(['status' => 'success', 'applicationDetail' => $applicationDetail]);
    } else {
        error_log('No application found for job_id: ' . $job_id); // Log the case where no job is found
        echo json_encode(['status' => 'error', 'message' => 'not found.'. $job_id. $worker_id. $client,]);
    }

} else {   
    error_log('Invalid or missing job_id'); // Log invalid/missing job_id
    echo '<script type="text/javascript">';
    echo 'window.location.href = "./jobs.php"';
    echo '</script>';
    exit;
}

?>
