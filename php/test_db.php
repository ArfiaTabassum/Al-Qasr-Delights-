<?php
include 'db.php'; // Ensure this path is correct

if ($conn) {
    echo "Database Connection Successful!";
} else {
    echo "Database Connection Failed!";
}
?>
