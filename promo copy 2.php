<?php
use PHPMailer\PHPMailer\PHPMailer;
$msg = '';
if (array_key_exists('email', $_POST)) {
    require 'vendor/autoload.php';
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'smtp-relay.brevo.com';
    $mail->Port = 587;
    $mail->SMTPDebug = 3;
    $mail->SMTPAuth = true;
    $mail->Username = 'srdevconsole@gmail.com';
    $mail->Password = 'a7ELfk3QUg0rsSyD';
    $mail->setFrom('support@sellerrocket.in', 'Website');
    $mail->addAddress('prahadeesh11@gmail.com','Kannan');
     // Add the additional recipient
    // $mail->addAddress('marketing@sellerrocket.in', 'Market');
    if ($mail->addReplyTo($_POST['email'], $_POST['name'])) {
        $mail->Subject = 'Promo pop-up box section';
        $mail->isHTML(false);
        $mail->Body = <<<EOT
            Name: {$_POST['name']}
            Phone: {$_POST['phone']}
            Email: {$_POST['email']}
            Online Platform: {$_POST['op']}
            
EOT;
        if (!$mail->send()) {
            $msg = 'Sorry, something went wrong. Please try again later.';
        } else {
            header( "Location:https://sellerrocket.in/home.html" );
        }
    } else {
        $msg = 'Share it with us!';
    }
}
?>