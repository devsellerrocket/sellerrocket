<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Ensure this path is correct

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {


    // === 2. CRM INTEGRATION ===
    $data = [
        "Phone" => $_POST['phone'] ?? '',
        "Email" => $_POST['email'] ?? '',
        "Platform" => $_POST['platform'] ?? '',
        "Date" => date("Y-m-d"),
        "Lead Source" => "Website - Free Seller Audit Form"
    ];

    $url = "https://apps.cratiocrm.com/Customize/Webhooks/webhook.php?id=";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $response = curl_exec($ch);
    curl_close($ch);

    // === 3. SANITIZE INPUTS ===
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $platform = trim($_POST['platform'] ?? '');

    if (empty($email) || empty($phone) || empty($platform)) {
        die("Please fill in all required fields.");
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
        $mail->setFrom('ceo@sellerrocket.in', 'Website');
        $mail->addAddress('ceo@sellerrocket.in', 'kannan');  
        $mail->addReplyTo($email);

        // Headers
        $mail->addCustomHeader('X-Mailer', 'PHPMailer');
        $mail->addCustomHeader('X-Priority', '3');
        $mail->addCustomHeader('Organization', 'SellerRocket');

        // Email content
        $mail->isHTML(true);
        $mail->Subject = "Free Seller Account Audit Section Form";
        $mail->Body = "
            <h3>New Submission - Free Seller Account Audit</h3>
            <p><b>Phone:</b> " . htmlspecialchars($phone) . "</p>
            <p><b>Email:</b> " . htmlspecialchars($email) . "</p>
            <p><b>Platform:</b> " . htmlspecialchars($platform) . "</p>
            <hr>
            <p><i>Submitted on " . date('Y-m-d H:i:s') . "</i></p>
        ";

        $mail->AltBody = 
            "Phone: $phone\nEmail: $email\nPlatform: $platform\nSubmitted on: " . date('Y-m-d H:i:s');

        $mail->send();

        // Success redirect
        echo "<script>alert('Submitted successfully!');</script>";
        header("Location: https://sellerrocket.in/home.html");
        exit();

    } catch (Exception $e) {
        echo "Form submitted, but email could not be sent.<br>Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
