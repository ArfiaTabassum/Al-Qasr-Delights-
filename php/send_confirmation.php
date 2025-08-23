<?php
session_start();
require 'db.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    // Get reservation details
    $query = "SELECT * FROM reservations WHERE id = '$id' LIMIT 1";
    $result = mysqli_query($conn, $query);
    $res = mysqli_fetch_assoc($result);

    if ($res) {
        $email = $res['email'];
        $name = $res['full_name'];

        // Update status
        $update = "UPDATE reservations SET status = 'confirmed' WHERE id = '$id'";
        if (mysqli_query($conn, $update)) {

            // Send confirmation email
            $mail = new PHPMailer(true);
            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'ummehani99800@gmail.com';
                $mail->Password = 'xwgn ecba yfqt qbpl';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                // Recipients
                $mail->setFrom('ummehani99800@gmail.com', 'Qasr-Delights');
                $mail->addAddress($email, $name);

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Reservation Confirmed';
                $mail->Body    = "
                    Dear <strong>{$name}</strong>,<br><br>
                    Your reservation has been <strong>confirmed</strong> successfully.We are looking forward to serve u.<br><br>
                    <strong>Details:</strong><br>
                    Guests: {$res['guests']}<br>
                    Time: {$res['time_slot']}<br>
                    Date: {$res['dates']}<br>
                    Day: {$res['edays']}<br>
                    Branch: {$res['branch']}<br><br>
                    Thank you for choosing us!<br>
                    <em>- Your Restaurant-->Qasr-Delights</em>
                    Your Order Number:{$res['order_number']}<br><br>
                   Present this number at the restaurant for faster service.</p>
                ";

                $mail->send();
                $_SESSION['email_sent'] = "Confirmation email sent successfully.";
            } catch (Exception $e) {
                $_SESSION['email_sent'] = "Failed to send confirmation email. Error: " . $mail->ErrorInfo;
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
    header('Location: ../adminmanage_reservations.php');
    exit();
}
