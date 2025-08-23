<?php
include 'db.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id']; // Get review ID from form

    // Prepare and execute delete query
    $stmt = $conn->prepare("DELETE FROM reviews WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("Location: ../admin/manage_reviews.php"); // Redirect back to reviews page
        exit();
    } else {
        echo "Error deleting review: " . $conn->error;
    }
}
?>
