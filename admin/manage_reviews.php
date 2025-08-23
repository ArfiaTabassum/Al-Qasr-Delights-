<?php
include '../php/db.php'; // Database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Reviews - Arabian Fine Dining</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar {
            height: 100vh;
            position: sticky;
            top: 0;
        }
    </style>
</head>
<body>
<div class="d-flex">
        <!-- Sidebar -->
        <div class="bg-dark text-white p-3 sidebar" style="width: 250px;">
            <h3 class="text-center">Manage Reviews</h3>
            <ul class="nav flex-column mt-4">
                <li class="nav-item"><a href="admin_dashboard.php" class="nav-link text-white">Dashboard</a></li>
                <li class="nav-item"><a href="manage_reservations.php" class="nav-link text-white">Manage Reservations</a></li>
                <li class="nav-item"><a href="manage_reviews.php" class="nav-link text-white">Manage Reviews</a></li>
                <li class="nav-item"><a href="manage_branches.php" class="nav-link text-white">Manage Branches</a></li>
                <li class="nav-item"><a href="manage_orders.php" class="nav-link text-white active">Manage Orders</a></li>
                <li class="nav-item mt-5"><a href="php/logout.php" class="btn btn-danger w-100">Logout</a></li>
            </ul>
        </div>

    

        <!-- Main Content -->
        <div class="container mt-4">
            <h1 class="text-center">Manage Reviews</h1>
            
            <!-- Summary Box -->
            <div class="row mb-4">
                <?php
                for ($i = 5; $i >= 1; $i--) {
                    $query = "SELECT COUNT(*) as count FROM reviews WHERE rating = $i";
                    $result = $conn->query($query);
                    $row = $result->fetch_assoc();
                    $count = $row['count'];
                    echo "
                    <div class='col-md-2'>
                        <div class='card p-3 text-center'>
                            <h5>{$i} ★</h5>
                            <p class='mb-0'>{$count} reviews</p>
                        </div>
                    </div>";
                }
                ?>
            </div>
            
            <!-- Reviews Table -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Customer Reviews</h5>
                    <table class="table">
                        <thead>
                            <tr class="bg-light">
                                <th>ID</th>
                                <th>Name</th>
                                <th>Rating</th>
                                <th>Comment</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT * FROM reviews ORDER BY created_at DESC";
                            $result = $conn->query($query);

                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                                echo "<td>" . str_repeat("★", $row['rating']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['comment']) . "</td>";
                                echo "<td>
                                            <form action='../php/delete_reviews.php' method='POST'>
                                            <input type='hidden' name='id' value='" . $row['id'] . "'>
                                            <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                                        </form>
                                      </td>";
                                echo "</tr>";
                            }
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
