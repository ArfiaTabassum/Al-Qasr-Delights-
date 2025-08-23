<?php
include '../php/db.php';

// Fetch reservations
$sql = "SELECT * FROM reservations ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
$reservations = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Categorize
$accepted = [];
$rejected = [];

foreach ($reservations as $res) {
    if ($res['status'] === 'confirmed') {
        $accepted[] = $res;
    } elseif ($res['status'] === 'cancelled') {
        $rejected[] = $res;
    }
}

// Show session message if email sent
if (isset($_SESSION['email_sent'])) {
    echo "<script>
        alert('" . $_SESSION['email_sent'] . "');
        window.location.href = 'manage_reservations.php';
    </script>";
    unset($_SESSION['email_sent']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Reservations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .side-box {
            height: 200px;
            overflow-y: auto;
            margin-bottom: 20px;
        }
    </style>
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
            <h3 class="text-center">Manage Reservations</h3>
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
        <div class="container-fluid p-4">
            <h1 class="text-center mb-4">Manage Reservations</h1>

            <!-- Reservation Table -->
            <table class="table table-bordered table-striped align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Branch</th>
                        <th>Guests</th>
                        <th>Time</th>
                        <th>Day</th>
                        <th>Date</th>
                        <th>Order Number</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservations as $res): ?>
                    <tr>
                        <td><?= $res['id'] ?></td>
                        <td><?= htmlspecialchars($res['full_name']) ?></td>
                        <td><?= htmlspecialchars($res['phone']) ?></td>
                        <td><?= htmlspecialchars($res['email']) ?></td>
                        <td><?= htmlspecialchars($res['branch']) ?></td>
                        <td><?= htmlspecialchars($res['guests']) ?></td>
                        <td><?= htmlspecialchars($res['time_slot']) ?></td>
                        <td><?= htmlspecialchars($res['edays']) ?></td>
                        <td><?= htmlspecialchars($res['dates']) ?></td>
                        <td>
                            <?php if (!empty($res['order_number'])): ?>
                            <a href="manage_orders.php?order_number=<?= urlencode($res['order_number']) ?>" class="text-primary">
                            <?= htmlspecialchars($res['order_number']) ?>
                            </a>
                            <?php else: ?>
                            <span class="text-muted">N/A</span>
                            <?php endif; ?>
                            </td>
                        <td><span class="fw-bold text-<?= $res['status'] === 'confirmed' ? 'success' : ($res['status'] === 'cancelled' ? 'danger' : 'secondary') ?>">
                            <?= ucfirst($res['status']) ?></span>
                        </td>
                        <td>
                            <?php if ($res['status'] === 'pending'): ?>
                                <!-- Confirm -->
                                <form method="post" action="../php/send_confirmation.php" class="d-inline">
                                    <input type="hidden" name="id" value="<?= $res['id'] ?>">
                                    <button type="submit" class="btn btn-success btn-sm">Confirm</button>
                                </form>
                                <!-- Cancel -->
                                <form method="post" action="../php/update_reservation_status.php" class="d-inline">
                                    <input type="hidden" name="id" value="<?= $res['id'] ?>">
                                    <input type="hidden" name="status" value="cancelled">
                                    <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                                </form>
                            <?php elseif ($res['status'] === 'confirmed'): ?>
                                <span class="text-success fw-bold">Email Sent</span>
                            <?php elseif ($res['status'] === 'cancelled'): ?>
                                <span class="text-danger fw-bold">Cancelled</span>
                            <?php else: ?>
                                <span class="text-muted">N/A</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Accepted and Rejected Summary Boxes -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card border-success side-box">
                        <div class="card-header bg-success text-white">Accepted Reservations</div>
                        <div class="card-body">
                            <?php if ($accepted): ?>
                                <?php foreach ($accepted as $a): ?>
                                    <p><strong><?= htmlspecialchars($a['full_name']) ?></strong> - <?= $a['guests'] ?> Guests at <?= $a['time_slot'] ?>
                                    <br>Phone: <?= $a['phone'] ?> | Email: <?= $a['email'] ?></p>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No accepted reservations.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-danger side-box">
                        <div class="card-header bg-danger text-white">Rejected Reservations</div>
                        <div class="card-body">
                            <?php if ($rejected): ?>
                                <?php foreach ($rejected as $r): ?>
                                    <p><strong><?= htmlspecialchars($r['full_name']) ?></strong> - <?= $r['guests'] ?> Guests at <?= $r['time_slot'] ?> 
                                    <br>Phone: <?= $r['phone'] ?> | Email: <?= $r['email'] ?></p>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No rejected reservations.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
