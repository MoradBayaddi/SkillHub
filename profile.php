<?php
session_start();
$_SESSION['last_page'] = $_SERVER['REQUEST_URI'];
if(isset($_SESSION['user_id']))
{
    // Get job data to edit
$user_id=$_SESSION['user_id'];
if ($user_id <= 0) {
    echo '<script type="text/javascript">';
    echo 'window.location.href = "./index.php";';
    echo '</script>';
    exit();
}
include ('includes/connectiondb.php');
$query = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo '<script type="text/javascript">';
    echo 'alert("user not found!");';
    echo 'window.location.href = "./index.php";';
    echo '</script>';
    exit();
}

mysqli_close($conn);



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
    <?php include('./includes/links.php') ?>
    <title>User Profile</title>
</head>
<body>
<?php include('./includes/navbar.php') ?>

<!-- Main container -->
<div class="container my-5">
    <div class="row">
        <div class="col-md-6 offset-md-3 ">
            <h2 class="mb-4 text-center">Profile</h2>

            <!-- Profile Details -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">User Information</h5>
                    <p class="card-text"><strong>Full Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
                    <p class="card-text"><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                    <p class="card-text"><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone_number']); ?></p>
                </div>
            </div>

            <!-- Update Phone Number Form -->
            <div class="card mb-4 shadow-small">
                <div class="card-body">
                    <h5 class="card-title">Change Phone Number</h5>
                    <form id="updatePhoneForm">
                        <!-- Phone Number Input -->
                        <div class="mb-3">
                            <label for="phone" class="form-label">New Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="+123 456 789">
                        </div>

                        <!-- Error/Success Messages for Phone -->
                        <div id="phoneMessage" class="alert" style="display: none;"></div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary w-100">Update Phone Number</button>
                    </form>
                </div>
            </div>

            <!-- Update Password Form -->
            <div class="card shadow-small">
                <div class="card-body">
                    <h5 class="card-title">Change Password</h5>
                    <form id="updatePasswordForm">
                        <!-- Password Input -->
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password">
                        </div>

                        <!-- Confirm Password Input -->
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm new password">
                        </div>

                        <!-- Error/Success Messages for Password -->
                        <div id="passwordMessage" class="alert" style="display: none;"></div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary w-100">Update Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('./includes/footer.php') ?>

<!-- Include script links -->
<?php include('./includes/scriptLinks.php') ?>
<script>
    $(document).ready(function() {
    // Initialize validation on the phone update form
    $('#updatePhoneForm').validate({
        rules: {
            phone: {
                required: true, // Field must not be empty
                digits: true,   // Only digits are allowed
                minlength: 10,  // At least 10 digits (you can adjust this based on your requirement)
                maxlength: 15   // Max 15 digits for international numbers
            }
        },
        messages: {
            phone: {
                required: "Phone number is required.",
                digits: "Please enter a valid phone number.",
                minlength: "Phone number should be at least 10 digits.",
                maxlength: "Phone number cannot exceed 15 digits."
            }
        },
        errorElement: 'div',
        errorClass: 'alert alert-danger mt-2',  // Bootstrap alert class for styling the error messages
        validClass: 'is-valid',  // Bootstrap 'is-valid' class for styling valid inputs
        errorPlacement: function(error, element) {
            error.insertAfter(element);  // Place the error message below the input field
        },
        submitHandler: function(form) {
            // Send data to server (AJAX)
            $.ajax({
                url: './includes/updatePhone.php', // Path to your PHP script
                method: 'POST',
                data: { phone: $('#phone').val() },
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.status === 'success') {
                        $('#phoneMessage').addClass('alert alert-success').text('Phone number updated successfully!').show();
                        setTimeout(function() {
                        window.location.href = "./profile.php";
                        }, 2000);
                    } else {
                        $('#phoneMessage').addClass('alert alert-danger').text('Failed to update phone number.').show();
                    }
                },
                error: function(xhr, status, error) {
                    $('#phoneMessage').addClass('alert alert-danger').text('An error occurred: ' + error).show();
                }
            });
        }
    });

    // Initialize validation on the password update form
    $('#updatePasswordForm').validate({
        rules: {
            password: {
                required: true,   // Password field is required
                minlength: 6      // Password must be at least 8 characters
            },
            confirmPassword: {
                required: true,    // Confirm password is required
                equalTo: '#password'  // Must match the password field
            }
        },
        messages: {
            password: {
                required: "Password is required.",
                minlength: "Password must be at least 6 characters long."
            },
            confirmPassword: {
                required: "Please confirm your password.",
                equalTo: "Passwords do not match."
            }
        },
        errorElement: 'div',
        errorClass: 'alert alert-danger mt-2',
        validClass: 'is-valid',
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        },
        submitHandler: function(form) {
            // Send data to server (AJAX)
            $.ajax({
                url: './includes/updatePassword.php', // Path to your PHP script
                method: 'POST',
                data: { password: $('#password').val() },
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.status === 'success') {
                        $('#passwordMessage').addClass('alert alert-success').text('Password updated successfully!').show();
                        setTimeout(function() {
                        window.location.href = "./includes/logout.php";
                        }, 2000);
                    } else {
                        $('#passwordMessage').addClass('alert alert-danger').text('Failed to update password.').show();
                    }
                },
                error: function(xhr, status, error) {
                    $('#passwordMessage').addClass('alert alert-danger').text('An error occurred: ' + error).show();
                }
            });
        }
    });
});

</script>


</body>
</html>
