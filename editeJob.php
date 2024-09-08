<?php 
session_start();
$_SESSION['last_page'] = $_SERVER['REQUEST_URI'];
include('./includes/connectiondb.php');

// Check if the user is logged in and has the correct role
if(isset($_SESSION['email'])) {
    if ($_SESSION['role'] === 'worker') {
        echo '<script type="text/javascript">';
        echo 'alert("Sign in as a client to edit jobs");';
        echo 'window.location.href = "./index.php";';
        echo '</script>';
        exit();
    }
} else {
    echo '<script type="text/javascript">';
    echo 'alert("Please login!");';
    echo 'window.location.href = "./login.php";';
    echo '</script>';
    exit();
}

// Get job data to edit
$job_id = isset($_GET['job_id']) ? intval($_GET['job_id']) : 0;
if ($job_id <= 0) {
    echo '<script type="text/javascript">';
    echo 'alert("Invalid Job ID!");';
    echo 'window.location.href = "./index.php";';
    echo '</script>';
    exit();
}

$query = "SELECT * FROM jobs WHERE job_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $job_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $job = $result->fetch_assoc();
} else {
    echo '<script type="text/javascript">';
    echo 'alert("Job not found!");';
    echo 'window.location.href = "./index.php";';
    echo '</script>';
    exit();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include ('./includes/links.php'); ?>
    <title>SkillHub: Edit Job</title>
</head>
<body>
    <?php include ('./includes/navbar.php'); ?>
    <div id="alert-box"></div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <h4><?php echo $_SESSION['email']; ?></h4>
                        <h3><?php echo $_SESSION['name']; ?></h3>
                        <p><?php echo $_SESSION['role']; ?></p>
                        <a href="#" class="btn btn-primary">Edit Profile</a>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Edit Job</h4>
                    </div>
                    <div class="card-body">
                   
                        <form id="edit-job-form">
                            <div class="mb-3">
                                <label for="jobTitle" class="form-label">Job Title</label>
                                <input type="text" class="form-control" id="jobTitle" name="jobTitle" value="<?php echo htmlspecialchars($job['title']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-select" id="category" name="category" required>
                                    <?php
                                    include('./includes/connectiondb.php');
                                    $query = "SELECT * FROM `categories`";
                                    $query_run = mysqli_query($conn, $query);
                                    if (!$query_run) {
                                        die('Query failed: ' . mysqli_error($conn));
                                    }
                                    while ($row = mysqli_fetch_array($query_run)) {
                                        $selected = ($job['category_id'] == $row['categorie_id']) ? 'selected' : '';
                                        echo "<option value=\"" . htmlspecialchars($row['categorie_id']) . "\" $selected>" . htmlspecialchars($row['name']) . "</option>";
                                    }
                                    mysqli_close($conn);
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="jobDescription" class="form-label">Job Description</label>
                                <textarea class="form-control" id="jobDescription" name="jobDescription" rows="4" required><?php echo htmlspecialchars($job['description']); ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="jobLocation" class="form-label">Location</label>
                                <input type="text" class="form-control" id="jobLocation" name="jobLocation" value="<?php echo htmlspecialchars($job['location']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="jobSalary" class="form-label">Salary</label>
                                <input type="text" class="form-control" id="jobSalary" name="jobSalary" value="<?php echo htmlspecialchars($job['salary']); ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Job</button>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include ('includes/footer.php'); ?>
    <?php include ('./includes/scriptLinks.php'); ?>

    <script>
    $(document).ready(function() {
        $('#edit-job-form').validate({
            rules: {
            jobTitle: {
                required: true,
                minlength: 3
            },
            category: {
                required: true
            },
            jobDescription: {
                required: true,
                minlength: 10
            },
            jobLocation: {
                required: true
            },
            jobSalary: {
                required: true,
                number: true
            }
        },
        messages: {
            jobTitle: {
                required: "Please enter the job title",
                minlength: "Job title must be at least 3 characters long"
            },
            category: {
                required: "Please select a category"
            },
            jobDescription: {
                required: "Please enter the job description",
                minlength: "Job description must be at least 10 characters long"
            },
            jobLocation: {
                required: "Please enter the job location"
            },
            jobSalary: {
                required: "Please enter the salary",
                number: "Please enter a valid number"
            }
        },
        errorPlacement: function(error, element) {
            error.addClass('text-danger');
            error.insertAfter(element);
        },
        highlight: function(element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element) {
            $(element).removeClass('is-invalid');
        },
            // Validation rules here (same as in your add job form)
            submitHandler: function(form) {
                var jobTitle = $('#jobTitle').val();
                var category = $('#category').val();
                var jobDescription = $('#jobDescription').val();
                var jobLocation = $('#jobLocation').val();
                var jobSalary = $('#jobSalary').val();
                var job_id = <?php echo $job_id; ?>;

                $.ajax({
                    type: 'POST',
                    url: './includes/updateJob.php',
                    dataType: 'json',
                    data: {
                        job_id: job_id,
                        jobTitle: jobTitle,
                        category: category,
                        jobDescription: jobDescription,
                        jobLocation: jobLocation,
                        jobSalary: jobSalary
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#edit-job-form')[0].reset();
                            showMessage('Job updated successfully!', 'success');
                        } else {
                            showMessage('Error: ' + response.message, 'danger');
                        }
                    }
                });
            }
        });

        function showMessage(message, type) {
            var alertBox = $('<div class="alert mt-3 alert-' + type + ' alert-dismissible fade show" role="alert">' + message + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
            $('#alert-box').append(alertBox);
        }
    });
    </script>
</body>
</html>
