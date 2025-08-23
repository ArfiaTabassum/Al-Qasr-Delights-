<?php 
include '../php/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Branches - Arabian Fine Dining</title>
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
            <h3 class="text-center">Manage Branches</h3>
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
            <h1 class="text-center">Manage Branches</h1>

            <!-- Add New Branch Form -->
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">Add New Branch</h5>
                    <form id="addBranchForm" action="../php/add_branch.php" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Branch Name:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address:</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone:</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="map_link" class="form-label">Map-Link:</label>
                            <input type="text" class="form-control" id="map_link" name="map_link" required>
                        </div>
                        <div class="mb-3">
                            <label for="lat" class="form-label">Latitude:</label>
                            <input type="text" class="form-control" id="lat" name="lat" required>
                        </div>
                        <div class="mb-3">
                            <label for="lng" class="form-label">Longitude:</label>
                            <input type="text" class="form-control" id="lng" name="lng" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Branch</button>
                    </form>                    
                </div>
            </div>

            <!-- List of Branches -->
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">Branches List</h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Map Link</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT * FROM branches";
                            $result = $conn->query($query);
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['name']}</td>
                                    <td>{$row['address']}</td>
                                    <td>{$row['phone']}</td>
                                    <td>{$row['map_link']}</td>
                                    <td>{$row['lat']}</td>
                                    <td>{$row['lng']}</td>
                            
                                    <td>
                                        <form action='../php/delete_branch.php' method='POST' class='d-inline'>
                                          <input type='hidden' name='id' value='{$row['id']}'>
                                          <button type='submit' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this branch?\");'>Delete</button>
                                        </form>
                                    </td>
                                </tr>";
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