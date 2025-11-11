<?php
// Get data from form and sanitize inputs
$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

// Email configuration
$to = "support@sellerrocket.com";
$subject = "Mail From Website";
$txt = "Name: " . $name . "\r\nEmail: " . $email . "\r\nMessage: " . $message;
$headers = "From: admin@sellerrocket.in\r\n" .
           "CC: somebodyelse@example.com";

// Check if email is valid and send email
if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    if (mail($to, $subject, $txt, $headers)) {
        // Redirect to home if mail is sent
        header("Location: home.html");
        exit();
    } else {
        // Handle mail sending failure
        echo "Failed to send the email. Please try again later.";
    }
} else {
    // Handle invalid email
    echo "Invalid email address. Please check and try again.";
}
?>
