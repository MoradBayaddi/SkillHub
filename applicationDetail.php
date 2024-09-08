<?php
session_start();
$_SESSION['last_page'] = $_SERVER['REQUEST_URI'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include ('./includes/links.php')?>
    <title>Application Details</title>
</head>

<body class="">
    <!-- navbar -->
    <?php 
    include ('./includes/navbar.php'); 
    // include ('./includes/getJobPage.php'); 
    if(isset($_GET['status'])){
        $status=$_GET['status'];

        if(isset($_GET['application_id'])){
            $application_id=$_GET['application_id'];
        }
        
    }
    ?>
   
    <div class="container">
        <div class="row">
            <!-- Job Details -->
            <div class="col-md-9 ">
                <div class="card mb-4">
                    <div class="card-body" id="job-detail">
                        <!-- job detail  -->

                    </div>
                </div>
            </div>

            <!-- Sidebar with Apply Button and Job Actions -->
            <div class="col-md-3">

            <div class="card mb-4 shadow-small">
                    <?php
                    if ($_SESSION['role']==='worker'){
                        if($status==='rejected' || $status==='pending' ){
                            ?>
                            <div class="card-body ">
                            
                            <div class="" id="statusMessage"></div>
    
                            <a href="#" 
                                class="btn btn-danger w-100 mb-3 btn-lg delete-application" 
                                data-application-id="<?php echo $application_id; ?>">
                                Delete my application
                            </a>            
                            </div>
                            <?php
                        }
                        else{
                            ?>
                            <div class="card-body ">
                            
                            <div class="" id="statusMessage"></div>
                            <div class="" id="clientContact">
                                <!-- get the client contact info after the worker accepted -->
                            </div>
                                    
                            </div>
                            <?php
                        }
                        
                        
                    }else{
                        ?>
                        <div class="card-body ">
                            
                            <h6 ><strong>Status: <?php echo $status?></strong></h6> 
                            <a href="#" 
                            class="btn btn-success bg-primary btn-lg w-100 mb-3 update-status" 
                            data-application-id="<?php echo $application_id; ?>" 
                            data-status="accepted">
                            Accept
                            </a>
                            <a href="#" 
                            class="btn btn-danger w-100 mb-3 btn-lg update-status" 
                            data-application-id="<?php echo $application_id; ?>" 
                            data-status="rejected">
                            Reject
                            </a>                    
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <div class="px-3" id="responseMessage"></div>
            </div>
        </div>
        
        
       
    </div>
    

   <?php include ('./includes/footer.php')?>
   <?php include ('./includes/scriptLinks.php')?>
   <script>
$(document).ready(function () {
    
    function fetchApplicationDetails(jobId,workerId,clientId) {
        $.ajax({
            url: './includes/getApplicationDetail.php',
            type: 'GET',
            data: { job_id: jobId,
                    client_id:clientId,
                    worker_id:workerId },
            dataType: 'json',
            success: function (response) {
                console.log('AJAX call succeeded:', response); // Log the entire response
                
                if (response.status === 'success') {
                    
                    $('#job-detail').empty();
                    const applicationDetail = response.applicationDetail;
                    let status=applicationDetail.status;
                    let messageClass = applicationDetail.status === 'accepted' 
                    ? 'alert-success' 
                    : applicationDetail.status === 'pending' 
                    ? 'alert-warning' 
                    : applicationDetail.status === 'rejected' 
                    ? 'alert-danger' 
                    : 'alert-secondary';

                    let message = `<p class="alert ${messageClass} alert-dismissible fade show" role="alert">
                        Application Status   <strong>${status}</strong>            
                                </p>`;
                    $('#statusMessage').append(message);
                    let clientContact=`
                    
                        <h6 class=""> Employer Name: <strong>${applicationDetail.client_name}</strong></h6>
                        <hr>
                        <p>Email: <strong>${applicationDetail.client_email}</strong></p>
                        <p>Phone: <strong>${applicationDetail.client_phone}</strong></p>`;
                    $('#clientContact').append(clientContact);

                    $('#job-detail').append(`
                        <div class="d-lg-flex m-0 p-0 align-items-center justify-content-between">
                        <h3 class="card-title">${applicationDetail.worker}</h3>
                        <p class="card-text mb-3 mb-lg-0"><strong>Applied On: </strong>${applicationDetail.applied_at}</p>
                        </div>
                        <p class="card-text"><strong>E-mail: </strong>${applicationDetail.email}</p>
                        
                        <p class="card-text"><strong>Phone Number: </strong>
                        <span id="phoneNumber" style="cursor: pointer;">${applicationDetail.phone_number}</span>
                        </p>
                        <span id="copyMessage" class="text-success ml-2" style="display: none;">Copied!</span>
                        <hr>
                        <h4>Cover Letter</h4>
                        <p>${applicationDetail.cover_letter}</p>
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
    const clientId = urlParams.get('worker_id');
    const workerId = urlParams.get('client_id');
    // console.log('Job ID:', jobId); // Log the job ID
    if (jobId,clientId,workerId) {
        fetchApplicationDetails(jobId,clientId,workerId);
    } else {
        // alert('Job ID not provided.');
        window.location.href = "./index.php";
    }

    // delete application 
    $('.delete-application').on('click', function(e) {
        e.preventDefault();
        var applicationId = $(this).data('application-id');

        if (confirm("Are you sure you want to delete this application?")) {
            $.ajax({
                url: './includes/deleteApplication.php',
                method: 'POST',
                data: { application_id: applicationId },
                dataType: 'json',
                success: function(response) {

                    let messageClass = response.status === 'success' ? 'alert-success' : 'alert-danger';
                    let message = `<div class="alert ${messageClass} alert-dismissible fade show" role="alert">
                                    ${response.message}
                                    
                                </div>`;
                    
                    $('#responseMessage').html(message);
                    
                    if (response.status === 'success') {
                        setTimeout(function() {
                    window.location.href = "./applications.php";
                    }, 2000);
                    } else {
                        
                        alert('Failed to delete application.');
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred: ' + error);
                }
            });
        }
    });

    // Handle update status
    $('.update-status').on('click', function(e) {
        e.preventDefault();
        var applicationId = $(this).data('application-id');
        var status = $(this).data('status');

        $.ajax({
            url: './includes/updateApplicationStatus.php',
            method: 'POST',
            data: { application_id: applicationId, status: status },
            dataType: 'json',
            success: function(response) {
                    let messageClass = response.status === 'success' ? 'alert-success' : 'alert-danger';
                    let message = `<div class="alert ${messageClass} alert-dismissible fade show" role="alert">
                    Application status updated successfuly to                
                   
                     <strong>${status}</strong>
                                    
                                </div>`;
                    $('#responseMessage').html(' '+message);
                if (response.status === 'success') {
                    setTimeout(function() {
                    window.location.href = "./applications.php";
                    }, 2000);
                    // $('#responseMessage').html(message);
                    // Optionally update the status in the UI
                    // alert('Application status updated to ' + status + '.');
                    // location.reload();
                } else {
                    alert('Failed to update status.');
                }
            },
            error: function(xhr, status, error) {
                alert('An error occurred: ' + error);
            }
        });
    });

<?php include('./includes/shareBtn.php');?>


    

    
});

   </script>
</body>

</html>