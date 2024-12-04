<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function sendOTP($email, $otp) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'nathdarshan18@gmail.com';
        $mail->Password = 'hebqwmdihwshzezf';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('nathdarshan18@gmail.com', 'NFRMLG');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'OTP for NPS verification';
        $mail->Body    = 'To verify, your OTP code is ' . $otp . '. Do not share your OTP code with anyone else.';

        $mail->send();
        return 1;
    } catch (Exception $e) {
        return 0;
    }
}
?>
