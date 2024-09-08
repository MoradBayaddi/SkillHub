<?php
include 'connectiondb.php';

if (isset($_POST['action']) && $_POST['action'] == 'login') {
    session_start();

    // Sanitize inputs
    $email = trim($_POST['email']);
    $pass = trim($_POST['password']);

    // Prepare the SQL statement to prevent SQL injection
    $stmt_login = $conn->prepare("SELECT * FROM users WHERE email = ?");
    
    if ($stmt_login) {
        $stmt_login->bind_param("s", $email);
        $stmt_login->execute();
        $result = $stmt_login->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashedPassword = $row['password'];
            
            // Verify the password
            if (password_verify($pass, $hashedPassword)) {
                // Store user information in session variables
                $_SESSION['name'] = $row['name'];
                $_SESSION['phone'] = $row['phone_number'];
                $_SESSION['role'] = $row['role'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['user_id'] = $row['user_id'];
                // Return the role to the AJAX success function
                echo $_SESSION['role'];
            } else {
                echo 'no'; // Wrong password
            }
        } else {
            echo 'noexiste'; // No user found with that email
        }
        
        $stmt_login->close();
    } else {
        echo 'An error occurred: ' . $conn->error;
    }
    
    $conn->close();
}
?>
