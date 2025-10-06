<?php

$to = 'youremail@gmail.com';
$email_from = 'noreply@yourwebsite.com';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = trim($_POST['firstname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $repeat_password = $_POST['repeat-password'];

    $errors = [];

    
    if (empty($firstname)) {
        $errors[] = 'Firstname is required';
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Valid email is required';
    }

    if (empty($password)) {
        $errors[] = 'Password is required';
    } elseif (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters';
    }

    if ($password !== $repeat_password) {
        $errors[] = 'Passwords do not match';
    }

    
    if (empty($errors)) {
        $email_subject = 'New Signup';
        $email_body = "Firstname: $firstname.\n". "Email: $email.\n";

        $headers = "From: $email_from \r\n";
        $headers .= "Reply-To: $email \r\n";

        mail($to, $email_subject, $email_body, $headers);
        header("Location: login.html");
    } else {
        
        $error_string = implode("&", array_map(function($error) {
            return "error[]=" . urlencode($error);
        }, $errors));
        header("Location: signup.html?$error_string");
    }
} else {
    
    header("Location: signup.html");
}
?>
