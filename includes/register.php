<?php
session_start();
include './connectiondb.php'; // Ensure this file contains your database connection logic

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form data
    $fullname = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $role = htmlspecialchars(trim($_POST['role']));
    
    // Check if the email already exists
    $checkEmailSql = "SELECT email FROM users WHERE email = ?";
    if ($stmt = $conn->prepare($checkEmailSql)) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Email already exists
            echo 'email_exists';
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Prepare an SQL statement to insert the user data
            $insertSql = "INSERT INTO users (name, email, password, role, phone_number) VALUES (?, ?, ?, ?, ?)";
            if ($insertStmt = $conn->prepare($insertSql)) {
                $insertStmt->bind_param('sssss', $fullname, $email, $hashedPassword, $role, $phone);

                // Execute the statement
                if ($insertStmt->execute()) {
                    // Successful insertion
                    $_SESSION['email'] = $email;
                    $_SESSION['name'] = $fullname;
                    $_SESSION['phone'] = $phone;
                    $_SESSION['role'] = $role;
                    echo 'ok';
                } else {
                    // Error during insertion
                    echo 'error';
                }

                // Close the insertion statement
                $insertStmt->close();
            } else {
                // Error preparing the insertion statement
                echo 'error';
            }
        }

        // Close the checking statement
        $stmt->close();
    } else {
        // Error preparing the checking statement
        echo 'error';
    }

    // Close the database connection
    $conn->close();
} else {
    // If not a POST request, return an error
    echo 'invalid_request';
}
?>
