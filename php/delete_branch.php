<?php
include '../php/db.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $branch_id = intval($_POST['id']); // Convert to integer for security

    // Prepare SQL query to delete the branch
    $query = "DELETE FROM branches WHERE id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("i", $branch_id);

        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            // Redirect back to manage_branches.php with success message
            header("Location: ../admin/manage_branches.php?success=Branch deleted successfully");
            exit();
        } else {
            $stmt->close();
            $conn->close();
            // Redirect with an error message if deletion fails
            header("Location: ../admin/manage_branches.php?error=Failed to delete branch");
            exit();
        }
    } else {
        $conn->close();
        header("Location: ../admin/manage_branches.php?error=Database query failed");
        exit();
    }
}

header("Location: ../admin/manage_branches.php");
exit();
?>
