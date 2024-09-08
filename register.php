<?php
session_start();
if(isset($_SESSION['email']))
{
        echo '<script type = "text/javascript">';
        echo 'alert("You are already connected ! Please log out")';
        echo '</script>';
        echo '<script type = "text/javascript">';
        echo 'window.location.href = "./index.php"';
        echo '</script>';
    
    // if ($_SESSION['role']='client'){
    //     echo '<script type = "text/javascript">';
    //     echo 'alert("already connected")';
    //     echo '</script>';
    //     echo '<script type = "text/javascript">';
    //     echo 'window.location.href = "./dashboard.php"';
    //     echo '</script>';
    // }
    // else{
    //     echo '<script type = "text/javascript">';
    //     echo 'alert("already connected")';
    //     echo '</script>';
    //     echo '<script type = "text/javascript">';
    //     echo 'window.location.href = "./jobs.html"';
    //     echo '</script>';
    // }
  
}
// else{
//     echo '<script type = "text/javascript">';
//         echo 'alert("You are not connected ! Please login")';
//         echo '</script>';
//         echo '<script type = "text/javascript">';
//         echo 'window.location.href = "./login.php"';
//         echo '</script>';
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include ('./includes/links.php')?>
    <title>SkillHub Login</title>
</head>
<body> 
  <nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid py-3">
        <a class="navbar-brand " href="./index.php">
            <img class="img-logo img-secure" src="./img/logo.png" alt="">
        </a>
        
    </div>
</nav>
    <div class="container-fluid container-lg ">
      <form id="register-form" action="" class="">
      <h4 class=" text-center mb-5">Join SkillHub</h4>
        <div class="row p-5 justify-content-center">
        <div class="col-md-4 mb-5">
    <input type="radio" id="worker" name="role" value="worker" class="d-none" required>
    <label for="worker" class="role-option btn btn-outline-primary d-flex flex-column align-items-center p-4">
        <div class="role-icon mb-3">
            <i class="fas fa-hammer fa-2x"></i>
        </div>
        <div class="role-text">
            <h3 class="h5">Join as a Worker</h3>
            <p class="text-muted">Find jobs and showcase your skills</p>
        </div>
    </label>
</div>

<div class="col-md-4 mb-5">
    <input type="radio" id="client" name="role" value="client" class="d-none" required>
    <label for="client" class="role-option btn btn-outline-primary d-flex flex-column align-items-center p-4">
        <div class="role-icon mb-3">
            <i class="fas fa-briefcase fa-2x"></i>
        </div>
        <div class="role-text">
            <h3 class="h5">Join as a Client</h3>
            <p class="text-muted">Hire skilled workers for your projects</p>
        </div>
    </label>
</div>

          
          <div class="row d-flex justify-content-center mb-5 ">
            <div class="col-lg-6 py-5 px-lg-5 d-flex  flex-column align-items-center   login">
                
                    
                    <input class="mb-3" type="text" placeholder="Full Name" name="name" id="name">
                    <input class="mb-3" type="text" placeholder="E-mail" name="email" id="email">
                    <input class="mb-3" type="text" placeholder="Phone number" name="phone" id="phone">
                    <input class="mb-3" type="password" placeholder="Password" name="password" id="password">
                    <input class="mb-3" type="password" placeholder="Password" name="password" id="password">
                    <div id="role-error" class="text-danger text-center mb-3" style="display: none;"></div> <!-- Error message -->
                    <div id="error-messages" class="alert alert-danger d-none"></div>
                    <input id="register-btn" class="btn-primary shadow-small  btn" type="submit" value="Continue">
      </form>
                <hr class="mt-4 w-100">
                <p class="text-center text-secondary"> You already have a SkillHub account?</p>
                <a href="./login.php" class="btn-primary shadow-small  btn">Login</a>
            </div>
        </div>
    </div>

   <?php include('./includes/scriptLinks.php')?>
   <script>
  $(document).ready(function() {
    // Add custom validation method for radio buttons
    $.validator.addMethod('radioRequired', function(value, element, name) {
        return $("input[name='" + name + "']:checked").length > 0;
    }, 'Please select a role');

    // Initialize validation on the form
    $('#register-form').validate({
        rules: {
            name: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            phone: {
                required: true,
                digits: true,
                minlength: 10,
                maxlength: 15
            },
            password: {
                required: true,
                minlength: 6
            },
            confirm_password: {
                required: true,
                equalTo: "#password"
            },
            role: {
                radioRequired: true
            }
        },
        messages: {
            name: "Please enter your full name",
            email: "Please enter a valid email address",
            phone: {
                required: "Please provide your phone number",
                digits: "Please enter only digits",
                minlength: "Your phone number must be at least 10 digits long",
                maxlength: "Your phone number can't exceed 15 digits"
            },
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long"
            },
            confirm_password: {
                required: "Please confirm your password",
                equalTo: "Passwords do not match"
            },
            role: "Please select a role"
        },
        submitHandler: function(form) {
            let errorMessages = [];

            // Check if a role is selected
            if ($("input[name='role']:checked").length === 0) {
                errorMessages.push('Please select a role: Worker or Client');
            }

            if (errorMessages.length > 0) {
                $('#error-messages').html(errorMessages.join('<br>')).removeClass('d-none');
                return false;
            } else {
                $('#error-messages').addClass('d-none');
            }

            // Serialize form data
            const formData = $(form).serialize() + '&action=register';
            console.log('Form Data:', formData);

            // Perform AJAX request
            $.ajax({
                url: './includes/register.php',
                method: 'POST',
                data: formData,
                success: function(response) {
                    console.log('Response:', response);

                    if (response === 'email_exists') {
                        $('#error-messages').html('Email already exists').removeClass('d-none');
                    } else if (response === 'ok') {
                        window.location = './includes/logout.php';
                    } else {
                        $('#error-messages').html('Registration failed: ' + response).removeClass('d-none');
                    }
                },
                error: function(xhr, status, error) {
                    console.log('AJAX error:', error);
                    $('#error-messages').html('An error occurred during registration: ' + error).removeClass('d-none');
                }
            });
        }
    });

    // Additional click event to clear error when radio is selected
    $("input[name='role']").on('change', function() {
        $('#error-messages').addClass('d-none');
    });
});




   </script>
</body>
</html>