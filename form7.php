<?php
use PHPMailer\PHPMailer\PHPMailer;
if ($_SERVER["REQUEST_METHOD"] == "POST") {

$msg = '';
if (array_key_exists('email', $_POST)) {
    require 'vendor/autoload.php';
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'smtp-relay.brevo.com';
    $mail->Port = 587;
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = true;
  $mail->Username = 'srdevconsole@gmail.com';
    $mail->Password = 'a7ELfk3QUg0rsSyD';
    $mail->setFrom('support@sellerrocket.in', 'Website');
    $mail->addAddress('kannan@sellerrocket.in','Kannan');
$mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPDebug = 3;
    $mail->SMTPAuth = true;
    $mail->Username = 'deadlyrock765@gmail.com';
    $mail->Password = 'soatrigrvyntbuea';
    $mail->setFrom('support@sellerrocket.in', 'Website');
    $mail->addAddress('ceo@sellerrocket.in','Kannan');
      // Add the additional recipient
    // $mail->addAddress('vijay@sellerrocket.in', 'Vijay');
    $mail->addAddress('leads@sellerrocket.in', 'Kannan');// Added Vijay
    if ($mail->addReplyTo($_POST['email'], $_POST['name'])) {
        $mail->Subject = 'Landing Page Leads';
        $mail->isHTML(false);
        $mail->Body = <<<EOT
        Name: {$_POST['name']}
        Email: {$_POST['email']}
        Phone: {$_POST['phone']}
       
EOT;
        if (!$mail->send()) {
            $msg = 'Sorry, something went wrong. Please try again later.';
        } else {
        //    echo "Thank you for contacting us. We will get back to you shortly.";
            header( "Location:http://localhost/sr-work/posterVideo.html" );

        }
    } else {
        $msg = 'Share it with us!';
    }
}
}
?>