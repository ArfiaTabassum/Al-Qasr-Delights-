<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone']);
    $google_map_link = trim($_POST['google_map_link']);
    // Modified insert query
    $stmt = $conn->prepare("INSERT INTO branches (name, address, phone, map_link) VALUES (?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        die("SQL Error: " . $conn->error);
    }

    $stmt->bind_param("ssssdd", $name, $address, $phone, $google_map_link);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("Location: ../admin/manage_branches.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>