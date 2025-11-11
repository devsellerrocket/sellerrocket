<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Make sure this path is correct

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // === 1. GOOGLE RECAPTCHA VERIFICATION ===
    $recaptcha_secret = "6LeZlM8qAAAAALCnNVo4OeihtM6mU-zrvkS0RbsR"; // Your secret key
    $recaptcha_response = $_POST['g-recaptcha-response'] ?? '';

    // if (empty($recaptcha_response)) {
    //     die("Verification failed: No reCAPTCHA token provided.");
    // }

    $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$recaptcha_secret}&response={$recaptcha_response}&remoteip=" . $_SERVER['REMOTE_ADDR']);
    $response_data = json_decode($verify);

    // if (empty($response_data->success) || !$response_data->success) {
    //     die("Verification failed: reCAPTCHA check did not pass.");
    // }

    // === 2. CRM INTEGRATION ===
    $data = [
        "Name" => $_POST['name'] ?? '',
        "Phone" => $_POST['phone'] ?? '',
        "Email" => $_POST['email'] ?? '',
        "Service" => $_POST['service'] ?? '',
        "date" => date("Y-m-d"), // current date
        "language" => $_POST['language'] ?? '',
        "Lead Source" => "Website",
        "Requirement" => $_POST['message'] ?? ''
    ];

    $url = "https://apps.cratiocrm.com/Customize/Webhooks/webhook.php?id=151115";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $response = curl_exec($ch);
    curl_close($ch);

    // === 3. SANITIZE AND VALIDATE INPUTS ===
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $message = trim($_POST['message'] ?? '');
    $language = trim($_POST['language'] ?? '');
    $service = trim($_POST['service'] ?? '');
    $utm_source=trim($_POST['utm_source'] ?? '');
    $utm_medium=trim($_POST['utm_medium'] ?? '');
    $utm_campaign=trim($_POST['utm_campaign'] ?? '');

    if (empty($name) || empty($email) || empty($message)) {
        die("Name, email, and message are required.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email address.");
    }

    // === 4. EMAIL SENDING VIA PHPMailer ===
    try {
        $mail = new PHPMailer(true);

        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'mail.sellerrocket.in';
        $mail->SMTPAuth = true;
        $mail->Username = '_mainaccount@sellerrocket.in';
        $mail->Password = '@eNfAXrdA7LxD@d';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ];

        // Recipients
        $mail->setFrom('dev@sellerrocket.in', 'SellerRocket Web Form');
        $mail->addAddress('dev@sellerrocket.in', 'Kannan');
        $mail->addReplyTo($email, $name);

        // Headers
        $mail->addCustomHeader('X-Mailer', 'PHPMailer');
        $mail->addCustomHeader('X-Priority', '3');
        $mail->addCustomHeader('Organization', 'SellerRocket');

        // Email content
        $mail->isHTML(true);
        $mail->Subject = "Get Free Consultation Section Form";

        $mail->Body = "
            <h3>New Contact Form Submission</h3>
            <p><b>Name:</b> " . htmlspecialchars($name) . "</p>
            <p><b>Email:</b> " . htmlspecialchars($email) . "</p>
            <p><b>Phone:</b> " . htmlspecialchars($phone) . "</p>
            <p><b>Message:</b> " . nl2br(htmlspecialchars($message)) . "</p>
            <p><b>Language:</b> " . htmlspecialchars($language) . "</p>
            <p><b>Service:</b> " . htmlspecialchars($service) . "</p>
            <hr>
            <p><i>Submitted on " . date('Y-m-d H:i:s') . "</i></p>
            <p>leads from " .htmlspecialchars($utm_source) . " <p>
        ";

        $mail->AltBody = 
            "Name: $name\nEmail: $email\nPhone: $phone\nMessage: $message\nLanguage: $language\nService: $service\n";

        $mail->send();

        // Redirect to thank-you page
        header("Location: https://sellerrocket.in/thankyou.html");
        exit();

    } catch (Exception $e) {
        echo "Form submitted, but email could not be sent.<br>Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
		<script>
const params = new URLSearchParams(window.location.search);
document.getElementById("utm_source").value = params.get("utm_source") || "organic";
document.getElementById("utm_medium").value = params.get("utm_medium") || "organic";
document.getElementById("utm_campaign").value = params.get("utm_campaign") || "organic";
</script>
