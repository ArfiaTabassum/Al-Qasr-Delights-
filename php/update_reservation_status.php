<?php
session_start();
require 'db.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];

    // Get reservation details
    $query = "SELECT * FROM reservations WHERE id = '$id' LIMIT 1";
    $result = mysqli_query($conn, $query);
    $res = mysqli_fetch_assoc($result);

    if ($res) {
        $email = $res['email'];
        $name = $res['full_name'];

        // Update reservation status
        $update = "UPDATE reservations SET status = '$status' WHERE id = '$id'";
        if (mysqli_query($conn, $update)) {
            // Send cancellation email
            if ($status === 'cancelled') {
                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'ummehani99800@gmail.com';
                    $mail->Password = 'xwgn ecba yfqt qbpl';
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;

                    $mail->setFrom('ummehani99800@gmail.com', 'Qasr-Delights');
                    $mail->addAddress($email, $name);

                    $mail->isHTML(true);
                    $mail->Subject = 'Reservation Cancelled';
                    $mail->Body    = "
                        Dear <strong>{$name}</strong>,<br><br>
                        We regret to inform you that your reservation has been <strong>cancelled, as we are completely booked for the day.</strong>.<br><br>
                        <strong>Details:</strong><br>
                        Guests: {$res['guests']}<br>
                        Time: {$res['time_slot']}<br>
                        Date: {$res['dates']}<br>
                        Day: {$res['edays']}<br>
                        Branch: {$res['branch']}<br><br>
                        Please try again next time. we would be happy to serve u next time you come<br><br>
                        <em>- Your Restaurant-->Qasr-Delights</em>
                    ";

                    $mail->send();
                    $_SESSION['email_sent'] = "Cancellation email sent successfully.";
                } catch (Exception $e) {
                    $_SESSION['email_sent'] = "Failed to send cancellation email. Error: " . $mail->ErrorInfo;
                }
            } else {
                $_SESSION['email_sent'] = "Reservation status updated.";
            }
        } else {
            $_SESSION['email_sent'] = "Failed to update reservation status.";
        }
    } else {
        $_SESSION['email_sent'] = "Reservation not found.";
    }

    header('Location: ../admin/manage_reservations.php');
    exit();
} else {
    header('Location: ../admin/manage_reservations.php');
    exit();
}
?>