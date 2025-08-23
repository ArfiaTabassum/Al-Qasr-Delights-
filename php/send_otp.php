<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer files
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // DEBUG: Log existing session data
    error_log("Pre-OTP Session: " . print_r($_SESSION, true));
    
    $full_name = $_POST['full_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    // Store user info in session WITHOUT destroying existing data
    $_SESSION['full_name'] = $full_name;
    $_SESSION['phone'] = $phone;
    $_SESSION['email'] = $email;
    
    // PRESERVE EXISTING ORDER NUMBER IF SET
    if (isset($_SESSION['order_number'])) {
        error_log("Preserving order number: " . $_SESSION['order_number']);
    }

    // Generate and store OTP
    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;
    $_SESSION['otp_verified'] = false;
    $_SESSION['otp_sent'] = true;

    // Send OTP using PHPMailer
    $mail = new PHPMailer(true);
    try {
        // [Keep existing mailer code...]
        $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'ummehani99800@gmail.com';         // Your Gmail
        $mail->Password   = 'xwgn ecba yfqt qbpl';              // App password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Sender and recipient
        $mail->setFrom('ummehani99800@gmail.com', 'Qasr-Delights');
        $mail->addAddress($email, $full_name);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP for Reservation - Qasr-Delights';
        $mail->Body    = "
            <h3>Dear $full_name,</h3>
            <p>Your OTP for reservation is: <strong>$otp</strong></p>
            <p>Regards,<br>QASR-DELIGHTS Restaurant</p>
        ";

        $mail->send();
        header('Location: ../user/reservation.php');
        exit();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
        $mail->send();
        error_log("OTP sent successfully to $email");
        header('Location: ../user/reservation.php');
        exit();
    } catch (Exception $e) {
        error_log("Mail Error: " . $e->getMessage());
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    header('Location: ../user/reservation.php');
    exit();
}
?>