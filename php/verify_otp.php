<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entered_otp = $_POST['otp'];

    if (isset($_SESSION['otp']) && $entered_otp == $_SESSION['otp']) {
        $_SESSION['otp_verified'] = true;
        header("Location: ../user/reservation.php?verified=1");
        exit();
    } else {
        $_SESSION['otp_error'] = "Incorrect OTP. Please try again.";
        header("Location: ../user/reservation.php?verified=0");
        exit();
    }
} else {
    header("Location: ../user/reservation.php");
    exit();
}
?>