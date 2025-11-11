<?php 
if(isset($_POST['submit'])){
    $to = "kannan@sellerrocket.in, hr@sellerrocket.in, samueljayachandran7@gmail.com"; // this is your Email address
    $from = $_POST['email']; // this is the sender's Email address
    $name = $_POST['name'];
    $last_name = $_POST['last_name'];
    $subject = "Client Inquiry";
    $phone = $_POST['phone'];
    $email = $_POST["email"];
    $subject2 = "Copy of your Client Inquiry";
    $message = $name . " " . $email . " . $phone . " . "wrote the following:" . "\n\n" . $_POST['message'];
    $message2 = "Here is a copy of your message " . $name . "\n\n" . $_POST['message'];

    $headers = "From:" . $from;
    $headers2 = "From:" . $to;
    mail($to,$subject,$message,$headers);
    mail($from,$subject2,$message2,$headers2); // sends a copy of the message to the sender
    //redirect
    header("Location:index.html");
  
    }
?>


