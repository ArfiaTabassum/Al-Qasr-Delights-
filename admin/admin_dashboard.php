<?php
include '../php/db.php';

// Get today's reservation count
$today = date('Y-m-d');
$reservationQuery = "SELECT COUNT(*) AS total FROM reservations WHERE DATE(created_at) = '$today'";
$reservationResult = $conn->query($reservationQuery);

if (!$reservationResult) {
    die("SQL Error: " . $conn->error);
}

$reservationCount = $reservationResult->fetch_assoc()['total'];

// Good/Bad review percentages
$reviewStatsQuery = "SELECT
    SUM(CASE WHEN rating >= 4 THEN 1 ELSE 0 END) AS good,
    SUM(CASE WHEN rating < 4 THEN 1 ELSE 0 END) AS bad,
    COUNT(*) AS total
    FROM reviews";
$reviewStatsResult = $conn->query($reviewStatsQuery);
$reviewStats = $reviewStatsResult->fetch_assoc();
$goodPercent = $reviewStats['total'] ? round(($reviewStats['good'] / $reviewStats['total']) * 100) : 0;
$badPercent = 100 - $goodPercent;

// Pending reservations
$pendingQuery = "SELECT * FROM reservations WHERE status = 'pending'";
$pendingReservations = $conn->query($pendingQuery);

// Data for the past 7 days
$labels = [];
$reservationCounts = [];
$goodReviewPercents = [];
for ($i = 6; $i >= 0; $i--) {
    $day = date('Y-m-d', strtotime("-$i days"));
    $labels[] = date('D', strtotime($day));

    // Daily reservation count
    $resQuery = "SELECT COUNT(*) as count FROM reservations WHERE DATE(created_at) = '$day'";
    $resResult = $conn->query($resQuery);
    $reservationCounts[] = ($resResult && $resResult->num_rows > 0) ? (int)$resResult->fetch_assoc()['count'] : 0;

    // Daily good review percentage
    $revQuery = "SELECT
        SUM(CASE WHEN rating >= 4 THEN 1 ELSE 0 END) AS good,
        COUNT(*) AS total
        FROM reviews WHERE DATE(created_at) = '$day'";
    $revResult = $conn->query($revQuery);
    $revData = ($revResult && $revResult->num_rows > 0) ? $revResult->fetch_assoc() : ['good' => 0, 'total' => 0];
    $percent = ($revData['total'] > 0) ? round(($revData['good'] / $revData['total']) * 100) : 0;
    $goodReviewPercents[] = $percent;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Arabian Fine Dining</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="styles.css">
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
            <h3 class="text-center">Admin Dashboard</h3>
            <ul class="nav flex-column mt-4">
                <li class="nav-item"><a href="#" class="nav-link text-white">Dashboard</a></li>
                <li class="nav-item"><a href="manage_reservations.php" class="nav-link text-white">Manage Reservations</a></li>
                <li class="nav-item"><a href="manage_reviews.php" class="nav-link text-white">Manage Reviews</a></li>
                <li class="nav-item"><a href="manage_branches.php" class="nav-link text-white">Manage Branches</a></li>
                <li class="nav-item"><a href="manage_orders.php" class="nav-link text-white active">Manage Orders</a></li>
                <li class="nav-item mt-5"><a href="php/logout.php" class="btn btn-danger w-100">Logout</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="container mt-4">
            <h1 class="text-center">Admin Dashboard</h1>

            <!-- Statistics -->
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card text-center p-3">
                        <h5>Today's Reservations</h5>
                        <h3><?php echo $reservationCount; ?></h3>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center p-3">
                        <h5>Good Reviews</h5>
                        <h3><?php echo $goodPercent; ?>%</h3>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center p-3">
                        <h5>Bad Reviews</h5>
                        <h3><?php echo $badPercent; ?>%</h3>
                    </div>
                </div>
            </div>

            <!-- Charts -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <canvas id="reservationsChart"></canvas>
                </div>
                <div class="col-md-6">
                    <canvas id="reviewsChart"></canvas>
                </div>
            </div>

            <!-- Pending Reservations -->
            <div class="mt-4">
                <h3>Pending Reservations</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Guests</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while ($row = $pendingReservations->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['full_name']; ?></td>
                            <td><?php echo date('Y-m-d', strtotime($row['created_at'])); ?></td>
                            <td><?php echo $row['time_slot']; ?></td>
                            <td><?php echo $row['guests']; ?></td>
                            <td><a href="confirm_reservation.php?id=<?php echo $row['id']; ?>" class="btn btn-success">Approve</a></td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        const labels = <?php echo json_encode($labels); ?>;
        const reservationData = <?php echo json_encode($reservationCounts); ?>;
        const reviewData = <?php echo json_encode($goodReviewPercents); ?>;

        new Chart(document.getElementById("reservationsChart"), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: "Reservations",
                    backgroundColor: "#007bff",
                    data: reservationData
                }]
            }
        });

        new Chart(document.getElementById("reviewsChart"), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: "Good Reviews (%)",
                    borderColor: "#28a745",
                    fill: false,
                    data: reviewData
                }]
            }
        });
    </script>
</body>
</html>