<?php 
session_start();
include ('./includes/connectiondb.php');
if(isset($_SESSION['user_id']))
{
    if ($_SESSION['role']==='client'){
        echo '<script type = "text/javascript">';
        echo 'window.location.href = "./applications.php"';
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
                $user_id = $_SESSION['user_id'];
                // Query to get recent applications
                $queryRecentApplications = "
                SELECT 
                    applications.application_id,applications.worker_id,
                    jobs.title,jobs.job_id,
                    applications.status,
                    users.name AS client_name,users.user_id as client_id  
                FROM 
                    applications
                INNER JOIN 
                    jobs ON applications.job_id = jobs.job_id
                INNER JOIN
                    users ON jobs.posted_by = users.user_id  
                WHERE 
                    applications.worker_id = ?; ";

                $stmtRecentApplications = $conn->prepare($queryRecentApplications);
                $stmtRecentApplications->bind_param("i", $user_id);
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
                                            <th>Employer Name</th>
                                            <!-- <th>Application Date</th> -->
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
                                                
                                                echo "<td>" . htmlspecialchars($row['client_name']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                                                echo '<td>
                                                        <a href="./applicationDetail.php?job_id='. htmlspecialchars($row['job_id']) .'&client_id='. htmlspecialchars($row['client_id']).'&worker_id='. htmlspecialchars($row['worker_id']).'&status='. htmlspecialchars($row['status']).'&application_id='. htmlspecialchars($row['application_id']).'"
                                                        class="btn btn-primary py-1 mx-1 px-2 btn-sm">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </a>
                                                        
                                                    </td>';
                                                echo "</tr>";
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