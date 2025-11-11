
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
            $currentDate = date('Y-m-d');
            $conn = new mysqli($servername, $username, $password, $dbname);
            
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            
            $stmt = $conn->prepare("INSERT INTO leads (name, phone, mail, message, created_at) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $name, $phone, $email, $message, $currentDate);
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
    $mail->addAddress('ceo@sellerrocket.in','Kannan');
    $mail->addAddress('leads@sellerrocket.in', 'Kannan');
    // $mail->addAddress('marketing@sellerrocket.in', 'Kannan');

    if ($mail->addReplyTo($_POST['email'], $_POST['name'])) {
        $mail->Subject = 'Grow with us lead form';
        $mail->isHTML(false);
        $mail->Body = <<<EOT
            First Name: {$_POST['name']}
            Email: {$_POST['email']}
            Phone: {$_POST['phone']}
            Message: {$_POST['op']}
EOT;
        if (!$mail->send()) {
            $msg = 'Sorry, something went wrong. Please try again later.';
        } else {

      
        $phoneNumber = "+919944331949"; 
        $whatsappMessage = "Hello, my name is $name. My email is $email.  Message: $message" ;
        $whatsappURL = "https://wa.me/" . $phoneNumber . "?text=" . urlencode($whatsappMessage);
        
        // header("Location: ". $whatsappURL);
        // exit();
     header( "Location:https://sellerrocket.in/thankyou.php" );
           
        }
    } else {
        $msg = 'Share it with us!';
    }
}
        echo "Form submitted successfully!";
    } else {
        echo "reCAPTCHA verification failed. Please try again.";
    }

}
?>



