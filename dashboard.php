<?php
session_start();
include('./includes/connectiondb.php');
if(isset($_SESSION['email']))
{
    $email = $_SESSION['email'];

    if ($_SESSION['role']==='client'){
        // Count of active jobs
        $queryActiveJobs = "
            SELECT COUNT(*) AS active_jobs 
            FROM jobs 
            INNER JOIN users ON jobs.posted_by = users.user_id 
            WHERE users.email = ? AND jobs.status = 'Active'";
        $stmtActiveJobs = $conn->prepare($queryActiveJobs);
        $stmtActiveJobs->bind_param("s", $email);
        $stmtActiveJobs->execute();
        $stmtActiveJobs->bind_result($active_jobs);
        $stmtActiveJobs->fetch();
        $stmtActiveJobs->close();

        // Count of applications received
        $queryApplicationsReceived = "
        SELECT COUNT(*) AS applications_received 
        FROM applications 
        INNER JOIN jobs ON applications.job_id = jobs.job_id 
        INNER JOIN users ON jobs.posted_by = users.user_id 
        WHERE users.email = ? ";
        $stmtApplicationsReceived = $conn->prepare($queryApplicationsReceived);
        $stmtApplicationsReceived->bind_param("s", $email);
        $stmtApplicationsReceived->execute();
        $stmtApplicationsReceived->bind_result($applications_received);
        $stmtApplicationsReceived->fetch();
        $stmtApplicationsReceived->close();

        // Count of jobs completed
        $queryJobsCompleted = "
        SELECT COUNT(*) AS jobs_completed 
        FROM jobs 
        INNER JOIN users ON jobs.posted_by = users.user_id 
        WHERE users.email = ? AND jobs.status = 'Completed'";
        $stmtJobsCompleted = $conn->prepare($queryJobsCompleted);
        $stmtJobsCompleted->bind_param("s", $email);
        $stmtJobsCompleted->execute();
        $stmtJobsCompleted->bind_result($jobs_completed);
        $stmtJobsCompleted->fetch();
        $stmtJobsCompleted->close();
    }
    else{
        echo '<script type = "text/javascript">';
        echo 'alert("You can not see this page : sign as a client ")';
        echo '</script>';
        echo '<script type = "text/javascript">';
        echo 'window.location.href = "./login.php"';
        echo '</script>';
    }
}
else{
        echo '<script type = "text/javascript">';
        echo 'alert("You are not connected ! Please login")';
        echo '</script>';
        echo '<script type = "text/javascript">';
        echo 'window.location.href = "./login.php"';
        echo '</script>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include('./includes/links.php') ?>
    <title>Client Dashboard</title>
</head>
<body>
     <!-- small devices navigation menu  -->
     <?php include './includes/dashboardNav.php' ?>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include './includes/dashboardSidebar.php' ?>

            <!-- Main Content -->
            <main class="col-md-10 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                    <div class="d-none d-md-block">
                        <a href="./includes/logout.php" class="btn btn-link">LogOut</a>
                        <a href="./profile.php" class="btn btn-primary">Profile</a>
                    </div>
                </div>

                <!-- Welcome Section -->
                <div class="card card-custom mb-4">
                    <div class="card-body">
                        <h4 class="card-title">Welcome back, <?php echo $_SESSION['name']; ?> !</h4>
                        <p class="card-text">Here's a quick overview of your activities.</p>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card card-custom">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Active Jobs</h5>
                                        <p class="card-text display-4"><?php echo $active_jobs; ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card card-custom">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Applications Received</h5>
                                        <p class="card-text display-4">
                                        <?php echo $applications_received; ?> </p>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>

                <!-- Active Jobs Section -->
                <div class="card card-custom mb-4">
                    <div class="card-header">
                        <h4 class="card-title">Active Jobs</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Job Title</th>
                                        <th>Location</th>
                                        <th>Date Posted</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="posted-jobs">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="./myJobs.php" class="btn btn-primary">View All Jobs</a>
                    </div>
                </div>

                <?php
                $email = $_SESSION['email'];
                // Query to get recent applications
                $queryRecentApplications = "
                SELECT j.title,worker.name as worker,worker.email,worker.user_id as worker_id,a.applied_at,a.status,j.job_id,client.user_id as client_id
                FROM applications a 
                INNER JOIN users as worker ON a.worker_id = worker.user_id
                INNER JOIN jobs j ON a.job_id = j.job_id
                inner join users as client on j.posted_by=client.user_id
                WHERE client.email=? and a.status='pending'";

                $stmtRecentApplications = $conn->prepare($queryRecentApplications);
                $stmtRecentApplications->bind_param("s", $email);
                $stmtRecentApplications->execute();
                $result = $stmtRecentApplications->get_result();
                // Close the statement
                $stmtRecentApplications->close();
                // Close the database connection
                $conn->close();
                ?>
                <!-- Recent Applications Section -->
                <div class="card card-custom mb-4">
                    <div class="card-header">
                        <h4 class="card-title">Recent Applications</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Job Title</th>
                                        <th>Applicant Name</th>
                                        <th>Application Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Check if there are any recent applications
                                    if ($result->num_rows > 0) {
                                        // Fetch and display each row
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['worker']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['applied_at']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                                            echo '<td>
                                                    <a href="./applicationDetail.php?job_id='. htmlspecialchars($row['job_id']) .'&client_id='. htmlspecialchars($row['client_id']).'&worker_id='. htmlspecialchars($row['worker_id']).'&status='. htmlspecialchars($row['status']).'"
                                                    class="btn btn-primary py-1 mx-1 px-2 btn-sm">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </a>
                                                    
                                                </td>';
                                            echo "</tr>";
                                        }
                                    } else {
                                        // Display a message if no applications are found
                                        echo "<tr><td colspan='5' class='text-center'>No recent applications found</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="./Applications.php" class="btn btn-primary">View All Applications</a>
                    </div>
                </div>
                
            </main>
        </div>
    </div>

    <?php include ('./includes/scriptLinks.php'); ?>
<script>
               
$(document).ready(function () {
    function fetchPostedJobs() {
        $.ajax({
            url: './includes/fetchPostedJobs.php', // Path to your fetchPostedJobs.php file
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    $('#posted-jobs').empty(); // Clear any existing rows
                    // Limit the jobs displayed to the first 4
                    response.jobs.slice(0, 4).forEach(job => {
                        $('#posted-jobs').append(`
                            <tr>
                                <td>${job.title}</td>
                                <td>${job.location}</td>
                                <td>${job.created_at}</td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td>
                                    <a href="./jobPage.php?job_id=${job.job_id}" class="btn btn-primary py-1 mx-1 px-2 btn-sm">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="./editeJob.php?job_id=${job.job_id}" class="btn btn-sec mx-1 py-1 px-2 btn-sm">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a href="#" class="btn btn-danger rounded-full mx-1 py-1 px-2 btn-sm delete-job" data-job-id="${job.job_id}">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        `);
                    });


                    // Attach delete event handler after rows are appended
                    $('.delete-job').on('click', function (e) {
                        e.preventDefault();
                        const jobId = $(this).data('job-id');

                        if (confirm('Are you sure you want to delete this job?')) {
                            deleteJob(jobId);
                        }
                    });
                } else {
                    alert(response.message);
                }
            },
            error: function () {
                alert('Failed to load jobs. Please try again later.');
            }
        });
    }

    // Function to delete job
    function deleteJob(jobId) {
        $.ajax({
            url: './includes/deleteJob.php',
            type: 'POST',
            data: { job_id: jobId },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    fetchPostedJobs(); // Refresh the job list after deletion
                } else {
                    // aler(response.status);
                    alert('Failed to delete the job. Please try again.');
                }
            },
            error: function () {
                alert('Failed to delete the job. Please try again later.');
            }
        });
    }

    // Call the function to load the jobs on page load
    fetchPostedJobs();
});
     </script>
</body>
</html>