
<?php
use PHPMailer\PHPMailer\PHPMailer;
$msg = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (array_key_exists('email', $_POST)) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $message = $_POST['message'];
            $phone = $_POST['phone'];
            $service=$_POST['service'];
            $language=$_POST['language'];

            // Database connection
            $servername = "localhost";
            $username = "u827204564_developers";
            $password = "X~pms=Dm7";
            $dbname = "u827204564_leaduserslist";
            $currentDate = date('Y-m-d');
            $conn = new mysqli($servername, $username, $password, $dbname);
            
          
            
            $stmt = $conn->prepare("INSERT INTO bottombarform3 (name,  email,phone, message, language,service,created_at) VALUES ('1', '1', '1', '1', '1','1','1-1-1')");
// $stmt->bind_param("sssssss", $name, $phone, $email, $message,$language,$service, $currentDate);
            $stmt->execute();
            $stmt->close();
            $conn->close();
            
    require 'vendor/autoload.php';
$mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPDebug = 3;
    $mail->SMTPAuth = true;
    $mail->Username = 'deadlyrock765@gmail.com';
    $mail->Password = 'soatrigrvyntbuea';
    $mail->setFrom('support@sellerrocket.in', 'Website');
    $mail->addAddress('hello@sellerrocket.in','Kannan');
    $mail->addAddress('leads@sellerrocket.in', 'Kannan');
    // $mail->addAddress('marketing@sellerrocket.in', 'Kannan');

    if ($mail->addReplyTo($_POST['email'], $_POST['name'])) {
        $mail->Subject = 'Get free consultation section form ';
        $mail->isHTML(false); // Set to false for plain text emails
        
        // Body content of the email
        $mail->Body = <<<EOT
        Name: {$_POST['name']}
        Email: {$_POST['email']}
        Phone: {$_POST['phone']}
        Requirements: {$_POST['message']}
        Language: {$_POST['language']}
        Service: {$_POST['service']}
EOT;
        if (!$mail->send()) {
            $msg = 'Sorry, something went wrong. Please try again later.';
        } else {

      
        $phoneNumber = "+919944331949"; 
        $whatsappMessage = "Hello, my name is $name. My email is $email.  Message: $message" ;
        $whatsappURL = "https://wa.me/" . $phoneNumber . "?text=" . urlencode($whatsappMessage);
        
        // header("Location: ". $whatsappURL);
        // exit();
     header( "Location:https://sellerrocket.in/thankyou.html" );
           
        }
    } else {
        $msg = 'Share it with us!';
    }
}
        echo "Form submitted successfully!";
    } else {
        echo "reCAPTCHA verification failed. Please try again.";
    }


?>









