<?php
if (isset($_GET['job_id']) && is_numeric($_GET['job_id'])) {
    $job_id = $_GET['job_id'];
    // $_SESSION['job_id']=$_GET['job_id'];
    include ('./connectiondb.php');
    
    // Prepare the query to fetch the job details
    $query = "
        SELECT 
            jobs.job_id,
            jobs.title,
            jobs.description,
            jobs.location,
            jobs.salary,
            jobs.posted_by,
            jobs.created_at,
            categories.name as category_name,
            categories.categorie_id
        FROM 
            jobs 
        JOIN 
            categories 
        ON 
            jobs.categorie_id = categories.categorie_id
        WHERE 
            jobs.job_id = ?
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $job_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $job = $result->fetch_assoc();
        error_log(print_r($job, true)); // Log the fetched job details
        echo json_encode(['status' => 'success', 'job' => $job]);
    } else {
        error_log('No job found for job_id: ' . $job_id); // Log the case where no job is found
        echo json_encode(['status' => 'error', 'message' => 'Job not found.']);
    }

} else {   
    error_log('Invalid or missing job_id'); // Log invalid/missing job_id
    echo '<script type="text/javascript">';
    echo 'window.location.href = "./jobs.php"';
    echo '</script>';
    exit;
}

?>
