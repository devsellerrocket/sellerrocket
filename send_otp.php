<?php
session_start();

// Check if required form data is received
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['phone'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];
    $language = $_POST['language'];
    $service = $_POST['service'];

    // Generate a 6-digit OTP
    $otp = rand(100000, 999999);

    // Save OTP and user data in session
    $_SESSION['otp'] = $otp;
    $_SESSION['user_data'] = [
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'message' => $message,
        'language' => $language,
        'service' => $service
    ];

    // Use Twilio API to send the OTP via SMS
    require 'vendor/autoload.php';
    use Twilio\Rest\Client;

    // Twilio credentials (replace with your own)
    $sid = 'YOUR_TWILIO_SID';
    $token = 'YOUR_TWILIO_AUTH_TOKEN';
    $twilio_phone = 'YOUR_TWILIO_PHONE_NUMBER';
    $client = new Client($sid, $token);

    try {
        // Send the OTP to the user's phone number
        $client->messages->create(
            $phone,
            [
                'from' => $twilio_phone,
                'body' => "Your OTP is: $otp"
            ]
        );

        // Return success response
        echo json_encode([
            'status' => 'success',
            'message' => 'OTP sent successfully!'
        ]);
    } catch (Exception $e) {
        // Handle errors
        echo json_encode([
            'status' => 'error',
            'message' => 'Error sending OTP. Please try again.'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid form submission.'
    ]);
}
?>
