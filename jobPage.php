<?php
session_start();
$_SESSION['last_page'] = $_SERVER['REQUEST_URI'];
if(isset($_GET['job_id']) && isset($_GET['worker_id']) )
{   
$job_id = $_GET['job_id'];
$worker_id=$_GET['worker_id'];
// echo $job_id;
// echo $worker_id;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include ('./includes/links.php')?>
    <title>SkillHub Jobs Page</title>
</head>

<body class="">
    <!-- navbar -->
    <?php 
    include ('./includes/navbar.php'); 
    
    // include ('./includes/getJobPage.php'); 
    ?>
   

    <div class="container">
        <div class="row">
            <!-- Job Details -->
            <div class="col-md-9 mb-5">
                <div class="card ">
                    <div class="card-body" id="job-detail">
                        <!-- job detail  -->

                    </div>
                </div>

                <!-- Applications :  -->
                 
                <?php 
                if(isset($_SESSION['email']))
                {
                    if ($_SESSION['role']==='client'){
                    include './includes/fetchRecentApplications.php';  
                    }
                    
                    if ($_SESSION['role']==='worker'){
                        ?>
                        
                        <div class="py-3">
                            <h4>Cover Letter</h4>
                            <form id="applicationForm">
                                <div id="responseMessage"></div> <!-- Placeholder for response messages -->
                                <!-- Cover Letter Textarea -->
                                <textarea name="coverLetter" required placeholder="Write your cover letter here..."></textarea>

                                <!-- Hidden Input Fields for job_id and worker_id -->
                                <input type="hidden" name="job_id" value="<?php echo $job_id; ?>">
                                <input type="hidden" name="worker_id" value="<?php echo $worker_id; ?>">
                                
                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-primary">Apply</button>
                            </form>
                        </div>
                        <?php
                    }
                }
                else{
                    ?>
                        
                        <div class="card my-5 p-3">
                            <h5>Log in to apply</h5>
                            <a class="btn-primary mb-3" href="./login.php">Login</a>
                            <button type="submit" disabled class="btn-primary">Apply</button>
                        </div>
                        <?php
                }
                 ?>
            </div>

            <!-- Sidebar with Apply Button and Job Actions -->
            <?php include 'includes/jobActions.php' ?>
            
        </div>
    </div>
   <?php include ('./includes/footer.php')?>
   <?php include ('./includes/scriptLinks.php')?>
   <script>
$(document).ready(function () {
    function fetchJobDetails(jobId) {
        $.ajax({
            url: './includes/getJobPage.php',
            type: 'GET',
            data: { job_id: jobId },
            dataType: 'json',
            success: function (response) {
                console.log('AJAX call succeeded:', response); // Log the entire response

                if (response.status === 'success') {
                    $('#job-detail').empty();
                    const job = response.job;
                    console.log('Job details:', job); // Log job details

                    $('#job-detail').append(`
                        <div class="d-lg-flex m-0 p-0 align-items-center justify-content-between">
                        <h3 class="card-title">${job.title}</h3>
                        <p class="card-text"><strong>Posted On:</strong> ${job.created_at}</p>
                        </div>
                        <p class="card-text"><strong>Category:</strong> ${job.category_name}</p>
                        
                        <p class="card-text"><strong>Salary:</strong> ${job.salary} Dh</p>
                        <p class="card-text"><strong>Location:</strong> ${job.location}</p>
                        
                        <hr>
                        <h4>Description</h4>
                        <p>${job.description}</p>
                    `);
                } else {
                    alert(response.message);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log('AJAX error:', textStatus, errorThrown); // Log any errors
                alert('Failed to load job details. Please try again later.');
            }
        });
    }

    const urlParams = new URLSearchParams(window.location.search);
    const jobId = urlParams.get('job_id');
    console.log('Job ID:', jobId); // Log the job ID
    if (jobId) {
        fetchJobDetails(jobId);
    } else {
        alert('Job ID not provided.');
        window.location = 'jobs.php';
    }


    // delete job
$('.delete-job').on('click', function (e) {
    e.preventDefault();
    if (confirm('Are you sure you want to delete this job?')) {
                            deleteJob(jobId);
    }
});
// deleteJob:
function deleteJob(jobId) {
        $.ajax({
            url: './includes/deleteJob.php',
            type: 'POST',
            data: { job_id: jobId },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    window.location = 'myJobs.php';
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


// application form 
$('#applicationForm').on('submit', function(e) {
    e.preventDefault(); // Prevent the form from submitting the usual way

    $.ajax({
        url: './includes/applyForJob.php',
        method: 'POST',
        data: $(this).serialize(), // Send form data to PHP
        dataType: 'json', // Expect a JSON response
        success: function(response) {
            let messageClass = response.status === 'success' ? 'alert-success' : 'alert-danger';
            let message = `<div class="alert ${messageClass} alert-dismissible fade show" role="alert">
                            ${response.message}
                            
                           </div>`;
            
            $('#responseMessage').html(message);

            if (response.status === 'success') {
                // Optionally, you can redirect or update the page content after a delay
                setTimeout(function() {
                    window.location.href = "./jobs.php";
                }, 2000); // 2-second delay before redirecting
            }
        },
        error: function(xhr, status, error) {
            let message = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            An error occurred: ${error}
                            
                           </div>`;
            $('#responseMessage').html(message);
        }
    });
});



<?php include('./includes/shareBtn.php');?>

    

    
});

   </script>
</body>

</html>