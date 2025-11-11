<?php
use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';

$msg = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $recaptcha_secret = "6LeZlM8qAAAAALCnNVo4OeihtM6mU-zrvkS0RbsR";
    $recaptcha_response = $_POST['g-recaptcha-response'];

    $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptcha_secret&response=$recaptcha_response");
    $response_data = json_decode($verify);


        // Sanitize and collect input
        $name     = $_POST['name'] ?? '';
        $email    = $_POST['email'] ?? '';
        $phone    = $_POST['phone'] ?? '';
        $message  = $_POST['message'] ?? '';
        $service  = $_POST['service'] ?? '';
        $language = $_POST['language'] ?? 'English'; // Optional fallback

        // Store in database
     

        // Send Email
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->Port       = 587;
        $mail->SMTPAuth   = true;
        $mail->Username   = 'deadlyrock765@gmail.com';
        $mail->Password   = 'soatrigrvyntbuea';
        $mail->setFrom('support@sellerrocket.in', 'Website');
        $mail->addAddress('ceo@sellerrocket.in', 'Kannan');
        $mail->addAddress('leads@gmail.com', 'Leads');

        if ($mail->addReplyTo($email, $name)) {
            $mail->Subject = 'Get free consultation section form';
            $mail->isHTML(false);
            $mail->Body = <<<EOT
Name: $name
Email: $email
Phone: $phone
Requirements: $message
Language: $language
Service: $service
EOT;

            if ($mail->send()) {
                // Optional WhatsApp redirection
                // $wa = "https://wa.me/+919944331949?text=" . urlencode("Hello, my name is $name. My email is $email. Message: $message");
                // header("Location: $wa");

                header("Location: https://sellerrocket.in/thankyou.html");
                exit();
            } else {
                $msg = 'Mail error: ' . $mail->ErrorInfo;
            }
        } else {
            $msg = 'Invalid reply-to address.';
        }
     
    

    if ($msg) echo "<p>$msg</p>";
}
?>
