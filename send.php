<?php
use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // reCAPTCHA check
    $recaptcha_secret = "6LeZlM8qAAAAALCnNVo4OeihtM6mU-zrvkS0RbsR";
    $recaptcha_response = $_POST['g-recaptcha-response'];
    $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptcha_secret&response=$recaptcha_response");
    $response_data = json_decode($verify);

    if ($response_data->success) {
        $emails = array_map('trim', explode(',', $_POST['to_emails']));
        $names  = array_map('trim', explode(',', $_POST['to_names']));

        if (count($emails) !== count($names)) {
            echo "❌ Error: Number of emails and names must match.";
            exit;
        }

        $emails = array_unique($emails); // avoid duplicates
        $success = 0;
        $failure = 0;

        for ($i = 0; $i < count($emails); $i++) {
            $email = $emails[$i];
            $name  = htmlspecialchars($names[$i], ENT_QUOTES, 'UTF-8');

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) continue;

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->Port = 587;
                $mail->SMTPAuth = true;
                $mail->Username = 'deadlyrock765@gmail.com';
                $mail->Password = 'soatrigrvyntbuea';
                $mail->setFrom('support@sellerrocket.in', 'Seller Rocket');
                $mail->addAddress($email, $name);
                $mail->Subject = "Your Brand Has Potential. We Know How to Scale It";
                $mail->isHTML(false);

                // Personalized email body
                $mail->Body = <<<EOT
Dear {$name},

Hope you're doing great!

I’m Kannan Planiyappan, Founder & CEO of Seller Rocket, and a proud member of the Thanjavur YES Chapter.

We’re a team of former Amazon and Flipkart professionals with over 15 years of experience in the e-commerce industry. At Seller Rocket, we help brands scale across platforms like Amazon, Flipkart, Myntra, Ajio, and Meesho using data-driven strategies and high-performance execution.

Here are some of our key achievements:
1. ₹2.5 Cr revenue generated in just 8 months on Amazon
2. 8.7x ROAS achieved in 2 months on Myntra
3. 5x ROAS consistently across multiple brands

What we offer:
• E-commerce Account Management (India & Global)
• SEO, Website Dev & Maintenance
• Performance Marketing (Meta, LinkedIn, WhatsApp)

We’re offering a free one-on-one session to support your brand’s growth.

Kannan Palaniyappan  
+91 9944331949  
+91 9363939174  
www.sellerrocket.in
EOT;

                // Attach brochure
                $mail->addAttachment('assets/brochure.pdf', 'SellerRocket-Brochure.pdf');

                $mail->send();
                $success++;
            } catch (Exception $e) {
                $failure++;
            }
        }

        echo "✅ Emails sent: $success<br>❌ Failed: $failure";
    } else {
        echo "⚠️ reCAPTCHA verification failed.";
    }
}
?>
