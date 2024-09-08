<?php 
session_start();
$_SESSION['last_page'] = $_SERVER['REQUEST_URI'];
if(isset($_SESSION['email']))
{
    if ($_SESSION['role']==='worker'){
        echo '<script type = "text/javascript">';
        echo 'alert("sing as client to post jobs")';
        echo '</script>';
        echo '<script type = "text/javascript">';
        echo 'window.location.href = "./index.php"';
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
    <title>SkillHub: Post a job</title>
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
                        <a href="./profile.php" class="btn btn-primary">Edit Profile</a>
                    </div>
                </div>
            </div>

            <!-- Main content area -->
            <div class="col-md-8">
                <!-- Add Job Section -->
                

                <!-- List of Posted Jobs -->
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
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="posted-jobs">
                                    <!-- Add more job rows as needed -->
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
       
$(document).ready(function () {
    function fetchPostedJobs() {
        $.ajax({
            url: './includes/fetchPostedJobs.php', // Path to your fetchPostedJobs.php file
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    $('#posted-jobs').empty(); // Clear any existing rows
                    response.jobs.forEach(job => {
                        $('#posted-jobs').append(`
                            <tr>
                                <td>${job.title}</td>
                                <td>${job.location}</td>
                                <td>${job.created_at}</td>
                                <td>
                                    <a href="./jobPage.php?job_id=${job.job_id}" class="btn btn-primary py-1 mx-1 px-2 btn-sm"><i class="fa-solid fa-eye"></i></a>
                                    <a href="./editeJob.php?job_id=${job.job_id}" 
                                    class="btn btn-sec mx-1 py-1 px-2 btn-sm">
                                    <i class="fa-solid fa-pen-to-square"></i></a>
                                    <a href="#" 
                                    class="btn btn-danger rouded-full mx-1 py-1 
                                    px-2 btn-sm delete-job" 
                                    data-job-id="${job.job_id}"><i class="fa-solid fa-trash"></i></a>
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