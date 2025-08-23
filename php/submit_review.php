<?php
include 'db.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $rating = intval($_POST['rating']); // Ensure it's an integer
    $comment = trim($_POST['comment']);

    // Use a prepared statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO reviews (name, rating, comment) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $name, $rating, $comment); // "s" for string, "i" for integer

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();

        // Redirect back to the review page after successful submission
        header('Location: ../user/review.php');
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
