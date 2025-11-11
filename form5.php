			<script>
const params = new URLSearchParams(window.location.search);
document.getElementById("utm_source").value = params.get("utm_source") || "organic";
document.getElementById("utm_medium").value = params.get("utm_medium") || "organic";
document.getElementById("utm_campaign").value = params.get("utm_campaign") || "organic";
</script>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Make sure this path is correct

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   // CRM INTEGRATION
     $data = [
    "Name" => $_POST['name'] ?? '',
    "Phone" => $_POST['phone'] ?? '',
    "Email" => $_POST['email'] ?? '',
    
    "date" => date("Y-m-d"), // current date
    
    "Lead Source" => "Website",
    "Requirement" => $_POST['message'] ?? ''
];

    $url = "https://apps.cratiocrm.com/Customize/Webhooks/webhook.php?id=589522";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);
 
    $response = curl_exec($ch);
    curl_close($ch);
    
    echo $response;
// END
    // === Sanitize and validate inputs ===
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $message = trim($_POST['message'] ?? '');
  $utm_source=trim($_POST['utm_source'] ?? '');
    $utm_medium=trim($_POST['utm_medium'] ?? '');
    $utm_campaign=trim($_POST['utm_campaign'] ?? '');

    if (empty($name) || empty($email) || empty($message)) {
        die("Name, email, and message are required.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email address.");
    }

    // === Email sending via PHPMailer ===
    try {
        $mail = new PHPMailer(true);

        // Server settings
        $mail->isSMTP();
        $mail->Host = 'mail.sellerrocket.in'; // Your SMTP host
        $mail->SMTPAuth = true;
        $mail->Username = '_mainaccount@sellerrocket.in'; // Full email address
        $mail->Password = '@eNfAXrdA7LxD@d'; // Replace with real password or app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Use SSL/TLS
        $mail->Port = 465;

        // SSL options (optional, only if you have cert issues)
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ];

        // Debugging (optional)
        // $mail->SMTPDebug = 2;
        // $mail->Debugoutput = 'html';

        // === Email headers ===
        $mail->setFrom('ceo@sellerrocket.in', 'SellerRocket Web Form');
        $mail->addAddress('ceo@sellerrocket.in', 'Kannan'); // Receiver
        $mail->addReplyTo($email, $name); // Reply goes to user

        $mail->addCustomHeader('X-Mailer', 'PHPMailer');
        $mail->addCustomHeader('X-Priority', '3');
        $mail->addCustomHeader('Organization', 'SellerRocket');

        // === Email content ===
        $mail->isHTML(true);
        $mail->Subject = "Contact Page Form";

        $mail->Body = "
            <h3>New Contact Form Submission</h3>
            <p><b>Name:</b> " . htmlspecialchars($name) . "</p>
            <p><b>Email:</b> " . htmlspecialchars($email) . "</p>
            <p><b>Phone:</b> " . htmlspecialchars($phone) . "</p>
            <p><b>Message:</b> " . nl2br(htmlspecialchars($message)) . "</p>
      
            <hr>
            <p><i>Submitted on " . date('Y-m-d H:i:s') . "</i></p>
            <p>leads from " .htmlspecialchars($utm_source) . " <p>
        ";

        $mail->AltBody = 
            "Name: $name\n" .
            "Email: $email\n" .
            "Phone: $phone\n" .
            "Message: $message\n" ;
           

        // === Send the email ===
        $mail->send();

        // === Redirect to thank-you page ===
        header("Location: https://sellerrocket.in/thankyou.html");
        exit();

    } catch (Exception $e) {
        echo "Form submitted, but email could not be sent.<br>Mailer Error: {$mail->ErrorInfo}";
    }
    
 
}
?>

























