<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $query = "SELECT * FROM admin WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // For plain text password comparison
        if ($password === $row['password']) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $username;
            $_SESSION['last_active'] = time();
            header("Location: ../admin/admin_dashboard.php");
            exit();
        } else {
            echo "<script>alert('Invalid username or password.'); window.location.href = '../admin/admin_login.html';</script>";
        }
    } else {
        echo "<script>alert('Invalid username or password.'); window.location.href = '../admin/admin_login.html';</script>";
    }

    $stmt->close();
}
$conn->close();
?>
