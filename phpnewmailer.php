<?php

$formsubmitmsg='';

$name = $last_name =  $phone = $email = "";
if (isset($_POST['name']) && $_POST['name']!='') {
    
    
      $name = $_POST['name'];
    $last_name = $_POST['last_name'];
    
    $phone = $_POST['phone'];
    $email = $_POST["email"];
//     $fname = $_POST['name'];
//     $admission = $_POST['admission'];


//     $admissionYear = $_POST['ay'];
//     $gender = $_POST['ge'];
//     $aadhaarNumber = $_POST['anumber'];
//     $dateOfBirth = $_POST['db'];
//     $bloodGroup = $_POST['bg'];
//     $nationality = $_POST['nationality'];
// 	$religion = $_POST['religion'];
//     $community = $_POST['community'];
//     $livingStatus = $_POST['livingstatus'];
//     $subCaste = $_POST['subcaste'];
//     $age = $_POST['age'];
//     $motherTongue = $_POST['mt'];
//     $fatherName = $_POST['ffname'];
//     $fatherOccupation = $_POST['fatheroccupation'];
//     $fatherIncome = $_POST['fatherincome'];
//     $fatherMobile = $_POST['fathermobile'];
//     $motherName = $_POST['mname'];
//     $motherOccupation = $_POST['motheroccupation'];
//     $motherIncome = $_POST['motherincome'];
//     $motherMobile = $_POST['mothermobile'];
//     $fullAddress = $_POST['fulladdress'];
//     $emisNo = $_POST['emisno'];
//     $contactNumber = $_POST['cnum'];
//     $email = $_POST['email'];
// 	 $file1 = $_FILES['file1']['name'];
//   $file2 = $_FILES['file2']['name'];

//  $target_dir = "uploads/mailuploads/";
//   $file1_target_path = $target_dir . basename($file1);
//   $file2_target_path = $target_dir . basename($file2);
  
//   // Move uploaded files to the target directory
//   move_uploaded_file($_FILES["file1"]["tmp_name"], $file1_target_path);
//   move_uploaded_file($_FILES["file2"]["tmp_name"], $file2_target_path);

	
	


    $result = "
    
    name: $name <br />
last_name: $last_name <br />
email: $email <br />
phone: $phone <br />
    
    

   
";


    // require 'PHPMailer-5.2-stable/PHPMailerAutoload.php';
    require 'vendor/autoload.php';
   

    $mail = new PHPMailer;
    
    try {
        // Server settings
        // $mail->SMTPDebug = 2;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp-relay.brevo.com';                     // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'support@sellerrocket.in';                     // SMTP username
        $mail->Password   = 'SR@tanjore=2023';                               // SMTP password
        $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    
        // Recipients
        $mail->setFrom('support@sellerrocket.in', 'Sellerrocket');
        $mail->addAddress('samueljayachandran7@gmail.com', 'Sellerrocket');     // Add a recipient
		

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Sellerrocket Enquiry Form';
        $mail->Body    = $result;
    
        $mail->send();
        // echo 'Email sent successfully.';
        $formsubmitmsg='SUCCESS';
    } catch (Exception $e) {
        // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        $formsubmitmsg='ERROR';
    }
}
?>
