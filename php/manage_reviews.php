<?php
include 'db.php'; // Include database connection

$query = "SELECT * FROM reviews ORDER BY created_at DESC";
$result = $conn->query($query);
?>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Rating</th>
            <th>Comment</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo str_repeat("★", $row['rating']); ?></td>
                <td><?php echo htmlspecialchars($row['comment']); ?></td>
                <td>
                    <form action="php/delete_review.php" method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php
$conn->close();
?>
