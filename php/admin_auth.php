<?php
session_start();

// Set timeout duration (2 hour = 7200 seconds)
$timeout_duration = 7200;

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../admin/admin_login.html");
    exit();
}

// Check for session timeout
if (isset($_SESSION['last_active']) && (time() - $_SESSION['last_active']) > $timeout_duration) {
    session_unset();            // Unset session variables
    session_destroy();          // Destroy session
    header(header: "Location: ../admin/admin_login.html?timeout=1"); // Redirect with timeout flag
    exit();
}

// Update last active time
$_SESSION['last_active'] = time();
?>
