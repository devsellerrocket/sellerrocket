<?php
session_start();

// Check if the OTP is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['otp'])) {
    $entered_otp = $_POST['otp'];

    // Check if OTP matches
    if ($entered_otp == $_SESSION['otp']) {
        // OTP is valid, process the form data (you can save it in the database, for example)
        $user_data = $_SESSION['user_data'];

        // Example: Save user data (like name, email, etc.) to a database
        // Here we're just echoing the data for demonstration purposes
        echo "OTP Verified! Form submission successful. Here are the details:<br>";
        echo "Name: " . $user_data['name'] . "<br>";
        echo "Email: " . $user_data['email'] . "<br>";
        echo "Phone: " . $user_data['phone'] . "<br>";
        echo "Message: " . $user_data['message'] . "<br>";
        echo "Language: " . $user_data['language'] . "<br>";
        echo "Service: " . $user_data['service'] . "<br>";

        // Optionally, clear the session after successful verification
        session_unset();
        session_destroy();

    } else {
        // Invalid OTP
        echo "Invalid OTP. Please try again.";
    }
} else {
    echo "OTP not received.";
}
?>
