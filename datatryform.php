<?php
use PHPMailer\PHPMailer\PHPMailer;
$msg = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recaptcha_secret = "6LeZlM8qAAAAALCnNVo4OeihtM6mU-zrvkS0RbsR";
    $recaptcha_response = $_POST['g-recaptcha-response'];

    $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptcha_secret&response=$recaptcha_response");
    $response_data = json_decode($verify);

    if ($response_data->success) {
        if (array_key_exists('email', $_POST)) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $message = $_POST['op'];
            $phone = $_POST['phone'];

            // Database connection
            $servername = "localhost";
            $username = "u827204564_developers";
            $password = "X~pms=Dm7";
            $dbname = "u827204564_leaduserslist";

            $conn = new mysqli($servername, $username, $password, $dbname);
            
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            
            $stmt = $conn->prepare("INSERT INTO leads (name, phone,mail, message) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name , $phone,$email, $message);
            $stmt->execute();
            $stmt->close();
            $conn->close();

            // Send Email
        
        }
        echo "Form submitted successfully!";
    } else {
        echo "reCAPTCHA verification failed. Please try again.";
    }
}
?>
