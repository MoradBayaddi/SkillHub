<?php

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Job</title>
    <!-- Bootstrap CSS -->
    <?php include 'includes/links.php' ?>
</head>

<body>
<?php include 'includes/navbar.php' ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h3>Apply for Job</h3>
                    </div>
                    <div class="card-body">
                        <!-- Job Information -->
                        <div id="job-info">
                            <p><strong>Job Title:</strong> <span id="job-title"></span></p>
                            <p><strong>Location:</strong> <span id="job-location"></span></p>
                            <p><strong>Salary:</strong> <span id="job-salary"></span></p>
                            <!-- Add more job details as needed -->
                        </div>

                        <!-- Cover Letter Form -->
                        <form id="applicationForm" action="applyForJob.php" method="POST">
                            <div class="form-group">
                                <label for="coverLetter" class="mb-3">Cover Letter:</label>
                                <textarea class="" id="coverLetter" name="coverLetter" rows="5"
                                    required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Application</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <?php include 'includes/scriptLinks.php' ?>

    <!-- Script to auto-fill job details and prefill cover letter -->
    <script>
        $(document).ready(function () {
            // Prefill cover letter if saved in local storage
            const savedCoverLetter = localStorage.getItem('coverLetter');
            if (savedCoverLetter) {
                $('#coverLetter').val(savedCoverLetter);
            }

            // Save cover letter to local storage before form submission
            $('#applicationForm').on('submit', function () {
                localStorage.setItem('coverLetter', $('#coverLetter').val());
            });
        });
    </script>
</body>

</html>
