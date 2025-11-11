<?php
use PHPMailer\PHPMailer\PHPMailer;
$msg = '';
if (array_key_exists('email', $_POST)) {
    require 'vendor/autoload.php';
//     $mail = new PHPMailer;
//     $mail->isSMTP();
//     $mail->Host = 'smtp-relay.brevo.com';
//     $mail->Port = 587;
//     $mail->SMTPDebug = 0;
//     $mail->SMTPAuth = true;
//   $mail->Username = 'srdevconsole@gmail.com';
//     $mail->Password = 'a7ELfk3QUg0rsSyD';
//     $mail->setFrom('support@sellerrocket.in', 'Website');
//     $mail->addAddress('kannan@sellerrocket.in','Kannan');
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
    $mail->addAddress('leads@sellerrocket.in', 'Kannan');
      // Add the additional recipient
    //   $mail->addAddress('vijay@sellerrocket.in', 'Vijay'); // Added Vijay
    if ($mail->addReplyTo($_POST['email'])) {
        $mail->Subject = 'Want a Free Digital Marketing Strategy Customized to your Business section form';
        $mail->isHTML(false);
        $mail->Body = <<<EOT
            Phone: {$_POST['phone']}
            Email: {$_POST['email']}
EOT;
        if (!$mail->send()) {
            $msg = 'Sorry, something went wrong. Please try again later.';
        } else {
            echo "<script type='text/javascript'>alert('submitted successfully!')</script>";
            header( "Location:https://sellerrocket.in/home.html" );
    
        }
    } else {
        $msg = 'Share it with us!';
    }
}
?>