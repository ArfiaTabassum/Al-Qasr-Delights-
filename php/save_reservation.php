<?php
session_start();
require 'db.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if OTP is verified
if (!isset($_SESSION['otp_verified']) || $_SESSION['otp_verified'] !== true) {
    die("<script>alert('OTP not verified. Please start again.'); window.location.href = '../user/reservation.php';</script>");
}

// Verify all required session variables exist
$required_vars = ['full_name', 'phone', 'email', 'order_number'];
foreach ($required_vars as $var) {
    if (!isset($_SESSION[$var])) {
        die("<script>alert('Session data missing ($var). Please start over.'); window.location.href='../user/reservation.php';</script>");
    }
}

// Verify order exists before proceeding
$order_number = $conn->real_escape_string($_SESSION['order_number']);
$check_order = $conn->prepare("SELECT 1 FROM orders WHERE order_number = ? LIMIT 1");
$check_order->bind_param("s", $order_number);
$check_order->execute();

if (!$check_order->get_result()->num_rows) {
    die("<script>alert('Invalid order reference. Please order food first.'); window.location.href='../user/menu.php';</script>");
}

// Prepare data
$full_name = $conn->real_escape_string($_SESSION['full_name']);
$phone     = $conn->real_escape_string($_SESSION['phone']);
$email     = $conn->real_escape_string($_SESSION['email']);
$guests    = (int)$_POST['guests'];
$time_slot = $conn->real_escape_string($_POST['time_slot']);
$edays     = $conn->real_escape_string($_POST['edays']);
$dates     = $conn->real_escape_string($_POST['dates']);
$branch    = $conn->real_escape_string($_POST['branch']);

// Check for duplicate booking (excluding cancelled ones)
$check_query = $conn->prepare("SELECT id FROM reservations WHERE email = ? AND dates = ? AND branch = ? AND status != 'cancelled' LIMIT 1");
$check_query->bind_param("sss", $email, $dates, $branch);
$check_query->execute();

if ($check_query->get_result()->num_rows > 0) {
    die("<script>alert('You already have an active reservation for this date and branch.'); window.location.href = '../user/reservation.php';</script>");
}

// Insert reservation
$insert_query = $conn->prepare("INSERT INTO reservations (full_name, phone, email, guests, time_slot, edays, dates, branch, status, order_number) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending', ?)");

$insert_query->bind_param("sssisssss", $full_name, $phone, $email, $guests, $time_slot, $edays, $dates, $branch, $order_number);

if ($insert_query->execute()) {
    $reservation_id = $conn->insert_id;
    
    // Send confirmation email
    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = "ummehani99800@gmail.com";
        $mail->Password = "xwgn ecba yfqt qbpl";
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;

        $mail->setFrom("ummehani99800@gmail.com", "Qasr-Delights");
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = "Reservation Confirmation - QASR_DELIGHTS";
        $mail->Body = "Dear $full_name,<br><br>
                      Your reservation at <strong>$branch</strong> on <strong>$dates</strong> at <strong>$time_slot</strong> has been received.<br><br>
                      Reservation ID: $reservation_id<br>
                      Order Reference: $order_number<br>
                      Number of guests: $guests<br><br>
                      Thank you for choosing us!<br><br>
                      Regards,<br>Arabian Fine Dining";
        $mail->send();
    } catch (Exception $e) {
        error_log("Email error: " . $e->getMessage());
    }

    // Clear session data
    unset($_SESSION['otp_verified'], $_SESSION['otp_sent'], $_SESSION['otp'], 
          $_SESSION['full_name'], $_SESSION['phone'], $_SESSION['email'], $_SESSION['order_number']);
    
    echo "<script>
        alert('Reservation #$reservation_id submitted successfully! Confirmation email sent.');
        window.location.href = '../user/reservation.php';
    </script>";
} else {
    error_log("Reservation Error: " . $conn->error);
    echo "<script>
        alert('Failed to save reservation. Error: ".addslashes($conn->error)."');
        window.location.href = '../user/reservation.php';
    </script>";
}
?>