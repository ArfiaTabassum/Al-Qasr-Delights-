<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'db.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $id = $_POST['id'];
    $email = $_POST['email'];
    $name = $_POST['name'];
    $branch = $_POST['branch'];
    $dates = $_POST['dates'];
    $time = $_POST['time_slot'];

    // Backup to deleted_reservations
    $conn->query("CREATE TABLE IF NOT EXISTS deleted_reservations LIKE reservations");
    $conn->query("INSERT INTO deleted_reservations SELECT * FROM reservations WHERE id=$id");

    // Delete original reservation
    $conn->query("DELETE FROM reservations WHERE id=$id");

    // Send email
    $mail = new PHPMailer(true);
    try {
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
        $mail->Subject = "Reservation Deleted - Qasr-Delights";
        $mail->Body = "Dear $name,<br><br>Your reservation at <strong>$branch</strong> on <strong>$dates</strong> at <strong>$time</strong> has been successfully deleted.<br><br>Thank you for letting us know.<br><br>Regards,<br>Qasr-Delights";

        $mail->send();
    } catch (Exception $e) {
        echo "<script>alert('Reservation deleted, but email could not be sent.'); window.location.href = '../user/delete_reservation.php';</script>";
        exit;
    }

    // Redirect with success
    echo "<script>alert('Your reservation has been deleted. A confirmation email has been sent.'); window.location.href = '../user/delete_reservation.php';</script>";
    exit;
} else {
    header("Location: ../user/delete_reservation.php");
    exit;
}
?>