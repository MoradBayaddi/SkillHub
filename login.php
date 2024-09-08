<?php
session_start();

if(isset($_SESSION['email']))
{
        // echo '<script type = "text/javascript">';
        // echo 'alert("already connected")';
        // echo '</script>';
        echo '<script type = "text/javascript">';
        echo 'window.location.href = "./index.php"';
        echo '</script>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="Cache-control" content="no-cache">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="-1">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include ('./includes/links.php'); ?>
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
    <div class="container-fluid container-lg mb-5">
        <div class="row p-5 p-lg-1 mx-lg-5 m-lg-0 mb-5  ">
            <div class="col-lg-8 mx-lg-auto py-5 d-flex  flex-column align-items-center   login">
                <h4 class=" text-center mb-5">Log in to SkillHub</h4>
                <form id="loginForm" class="d-flex gap-lg-2 gap-3 flex-column align-items-center ">
                    <div id="login-error" class="error-message alert alert-danger" style="display:none;">
                        
                    </div> <!-- Error message div -->
                    <input class="mb-3" type="text" placeholder="E-mail or Username" name="email" id="email" required>
                    <input class="mb-3" type="password" placeholder="Password" name="password" id="password" required>
                    <button id="login-submit" class="btn-primary shadow-small  btn">Continue</button>
                </form>
                <hr class="mt-4 w-100">
                <p class="text-center text-secondary"> Don't have a SkillHub account?</p>
                <a href="./register.php" class="btn-primary shadow-small  btn">Sign Up</a>
            </div>
        </div>
    </div>
    

    <script src="https://kit.fontawesome.com/f7066038ac.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
    <!-- <script src="../script.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
    
    <script>
$(document).ready(function() {
    // Initialize validation
    $('#loginForm').validate({
        errorClass: "error",  // Apply the custom error class to messages
        errorLabelContainer: "#login-error", // Container for the error messages
        submitHandler: function(form) {
            // Serialize form data
            const formData = $(form).serialize() + '&action=login';

            // Perform the AJAX request
            $.ajax({
                url: './includes/login.php',
                method: 'POST',
                data: formData,
                success: function(response) {
                    console.log('Response:', response);

                    if (response === 'worker') {
                        const lastPage = '<?php echo isset($_SESSION['last_page']) ? $_SESSION['last_page'] : ''; ?>';
                        
                        if (lastPage) {
                            window.location.href = lastPage;
                        } else {
                            window.location.href = './jobs.php';
                        }
                    } else if (response === 'client') {
                        const lastPage = '<?php echo isset($_SESSION['last_page']) ? $_SESSION['last_page'] : ''; ?>';

                        window.location.href = lastPage;
                        // window.location = 'dashboard.php';
                    } else if (response === 'no') {
                        $('#login-error').html('Wrong email or password.').show();
                    } else if (response === 'noexiste') {
                        $('#login-error').html('This account doesn\'t exist.').show();
                    } else {
                        $('#login-error').html('An unexpected error occurred.').show();
                    }
                },
                error: function(xhr, status, error) {
                    $('#login-error').html('An error occurred: ' + error).show();
                }
            });
        },
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
            }
        },
        messages: {
            email: {
                required: "Please enter your email.",
                email: "Please enter a valid email address."
            },
            password: {
                required: "Please enter your password.",
            }
        }
    });
});
    </script>

</body>
</html>