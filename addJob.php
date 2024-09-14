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
    else{
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
                
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Add a New Job</h4>
                    </div>
                    <div class="card-body">
                    <form id="add-job-form">
                        <div class="mb-3">
                            <label for="jobTitle" class="form-label">Job Title</label>
                            <input type="text" class="form-control" id="jobTitle" name="jobTitle" placeholder="Enter job title" required>
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select" id="category" name="category" aria-label="Category select" required>
                                <?php
                                include('./includes/connectiondb.php');
                                $query = "SELECT * FROM `categories`";
                                $query_run = mysqli_query($conn, $query);
                                if (!$query_run) {
                                    die('Query failed: ' . mysqli_error($conn));
                                }
                                while ($row = mysqli_fetch_array($query_run)) {
                                    $categorie_id = htmlspecialchars($row['categorie_id'], ENT_QUOTES, 'UTF-8');
                                    $name = htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8');
                                    echo "<option value=\"$categorie_id\">$name</option>";
                                }
                                mysqli_close($conn);
                                ?>
                                <!-- <option selected value="Other">Other</option> -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jobDescription" class="form-label">Job Description</label>
                            <textarea class="form-control" id="jobDescription" name="jobDescription" rows="4" placeholder="Enter job description" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="jobLocation" class="form-label">Location</label>
                            <input type="text" class="form-control" id="jobLocation" name="jobLocation" placeholder="Enter job location" required>
                        </div>
                        <div class="mb-3">
                            <label for="jobSalary" class="form-label">Salary</label>
                            <input type="text" class="form-control" id="jobSalary" name="jobSalary" placeholder="Enter the salary" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Job</button>
                        <div id="alert-box"></div>
                    </form>

                    </div>
                </div>

                
            </div>
        </div>
    </div>

<?php include ('includes/footer.php'); ?>
<?php include ('includes/scriptLinks.php'); ?>

<script>
$(document).ready(function() {
    // Initialize form validation
    $('#add-job-form').validate({
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
        submitHandler: function(form) {
            var jobTitle = $('#jobTitle').val();
            var category = $('#category').val();
            var jobDescription = $('#jobDescription').val();
            var jobLocation = $('#jobLocation').val();
            var jobSalary = $('#jobSalary').val();

            $.ajax({
                type: 'POST',
                url: './includes/insertJob.php',
                dataType: 'json',
                data: {
                    jobTitle: jobTitle,
                    category: category,
                    jobDescription: jobDescription,
                    jobLocation: jobLocation,
                    jobSalary: jobSalary
                },
                success: function(response) {
                    if (response.status === 'success') {
                        $('#add-job-form')[0].reset();
                        showMessage('Job added successfully!', 'success');
                    } else {
                        showMessage('Error: ' + response.message, 'danger');
                    }
                }
            });
        }
    });
    

    function showMessage(message, type) {
    console.log(message, type); // Debugging line

    var alertBox = $(
        '<div class="alert mt-3 alert-' + 
        type + 
        ' alert-dismissible fade show" role="alert">' + 
        message + 
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
    );

    $('#alert-box').append(alertBox);

    
}

});

</script>




</body>

</html>