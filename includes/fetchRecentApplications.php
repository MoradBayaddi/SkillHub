<?php
                $job_id = $_GET['job_id'];
                include ('./includes/connectiondb.php');
                $email = $_SESSION['email'];
                // Query to get recent applications
                $queryRecentApplications = "
                SELECT j.title,worker.name as worker,worker.email,worker.user_id as worker_id,a.applied_at,a.status,j.job_id,client.user_id as client_id
                FROM applications a 
                INNER JOIN users as worker ON a.worker_id = worker.user_id
                INNER JOIN jobs j ON a.job_id = j.job_id
                inner join users as client on j.posted_by=client.user_id
                WHERE client.email=? and j.job_id=?"  ;

                $stmtRecentApplications = $conn->prepare($queryRecentApplications);
                $stmtRecentApplications->bind_param("si", $email,$job_id);
                $stmtRecentApplications->execute();
                $result = $stmtRecentApplications->get_result();
                // Close the statement
                $stmtRecentApplications->close();
                // Close the database connection
                $conn->close();
                ?>
                <!-- Recent Applications Section -->
                <div class="card card-custom my-4">
                    <div class="card-header">
                        <h4 class="card-title">Recent Applications</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        
                                        <th>Applicant Name</th>
                                        <th>Email</th>
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
                                            
                                            echo "<td>" . htmlspecialchars($row['worker']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
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