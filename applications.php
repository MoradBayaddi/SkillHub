<?php 
session_start();
include ('./includes/connectiondb.php');
if(isset($_SESSION['email']))
{
    if ($_SESSION['role']==='worker'){
        echo '<script type = "text/javascript">';
        echo 'window.location.href = "./appliedJobs.php"';
        echo '</script>';
    }
    
  
}
else{
    echo '<script type = "text/javascript">';
        echo 'alert("Please login !")';
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
    <?php include ('./includes/links.php');?>
    <title>SkillHub: Applications</title>
</head>

<body class="">
    <?php include ('./includes/navbar.php');?>

    <div class="container mt-5">
        <div class="row">
            <!-- Sidebar with client information -->
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <h4><?php echo $_SESSION['email']; ?></h4>
                        <h3><?php echo $_SESSION['name']; ?></h3>
                        <p class=""><?php echo $_SESSION['role']; ?></p>
                        <a href="#" class="btn btn-primary">Edit Profile</a>
                    </div>
                </div>
            </div>

            <!-- Main content area -->
            <?php
                $email = $_SESSION['email'];
                // Query to get recent applications
                $queryRecentApplications = "
                SELECT a.application_id,j.title,worker.name as worker,worker.email,worker.user_id as worker_id,a.applied_at,a.status,j.job_id,client.user_id as client_id
                FROM applications a 
                INNER JOIN users as worker ON a.worker_id = worker.user_id
                INNER JOIN jobs j ON a.job_id = j.job_id
                inner join users as client on j.posted_by=client.user_id
                WHERE client.email=? ";

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
                <div class="col-md-8">
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
                                                echo "<td>" . htmlspecialchars($row['application_id']) . "</td>";
                                                echo '<td>
                                                        <a href="./applicationDetail.php?job_id='. htmlspecialchars($row['job_id']) .'&client_id='. htmlspecialchars($row['client_id']).'&worker_id='. htmlspecialchars($row['worker_id']).'&status='. htmlspecialchars($row['status']).'&application_id='. htmlspecialchars($row['application_id']).'"
                                                        class="btn btn-primary py-1 mx-1 px-2 btn-sm">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </a>
                                                        
                                                    </td>';
                                                echo "</tr>";
                                                // <a href="#" class="btn btn-success btn-sm">Accept</a>
                                                //         <a href="#" class="btn btn-danger btn-sm">Reject</a>
                                            }
                                        } else {
                                            // Display a message if no applications are found
                                            echo "<tr><td colspan='4' class='text-center'>No recent applications found</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                </div>
        </div>
    </div>

<?php include ('includes/footer.php'); ?>
<?php include ('includes/scriptLinks.php'); ?>




<script>
       
</script>




</body>

</html>