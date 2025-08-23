<?php
include '../php/db.php';

// Fetch all orders with their reservation details
$query = "SELECT o.*, r.full_name, r.phone, r.email, r.branch, r.dates, r.time_slot 
          FROM orders o
          JOIN reservations r ON o.order_number = r.order_number
          ORDER BY o.created_at DESC";
$result = mysqli_query($conn, $query);

// Group orders by order_number with reservation details
$orders_by_number = [];
while ($order = mysqli_fetch_assoc($result)) {
    $orders_by_number[$order['order_number']]['items'][] = $order;
    // Store reservation details once per order
    if (!isset($orders_by_number[$order['order_number']]['reservation'])) {
        $orders_by_number[$order['order_number']]['reservation'] = [
            'full_name' => $order['full_name'],
            'phone' => $order['phone'],
            'email' => $order['email'],
            'branch' => $order['branch'],
            'dates' => $order['dates'],
            'time_slot' => $order['time_slot'],
            'created_at' => $order['created_at']
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .order-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .order-header {
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .order-item {
            padding: 8px 0;
            border-bottom: 1px dashed #eee;
        }
        .order-total {
            font-weight: bold;
            font-size: 1.1em;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="d-flex">
    <!-- Sidebar -->
    <div class="bg-dark text-white p-3 sidebar" style="width: 250px;">
        <h3 class="text-center">Admin Panel</h3>
        <ul class="nav flex-column mt-4">
            <li class="nav-item"><a href="admin_dashboard.php" class="nav-link text-white">Dashboard</a></li>
            <li class="nav-item"><a href="manage_reservations.php" class="nav-link text-white">Manage Reservations</a></li>
            <li class="nav-item"><a href="manage_orders.php" class="nav-link text-white active">Manage Orders</a></li>
            <li class="nav-item"><a href="manage_reviews.php" class="nav-link text-white">Manage Reviews</a></li>
            <li class="nav-item"><a href="manage_branches.php" class="nav-link text-white">Manage Branches</a></li>
            <li class="nav-item mt-5"><a href="../php/logout.php" class="btn btn-danger w-100">Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="container-fluid p-4">
        <h1 class="text-center mb-4">Manage Orders</h1>
        
        <?php if (empty($orders_by_number)): ?>
            <div class="alert alert-info">No orders with reservation details found.</div>
        <?php else: ?>
            <?php foreach ($orders_by_number as $order_number => $data): ?>
                <div class="order-card">
                    <div class="order-header d-flex justify-content-between">
                        <h4>Order #<?= htmlspecialchars($order_number) ?></h4>
                        <span class="text-muted"><?= $data['reservation']['created_at'] ?></span>
                    </div>
                    
                    <div class="reservation-info mb-3">
                        <h5>Reservation Details</h5>
                        <p><strong>Name:</strong> <?= htmlspecialchars($data['reservation']['full_name']) ?></p>
                        <p><strong>Phone:</strong> <?= htmlspecialchars($data['reservation']['phone']) ?></p>
                        <p><strong>Email:</strong> <?= htmlspecialchars($data['reservation']['email']) ?></p>
                        <p><strong>Branch:</strong> <?= htmlspecialchars($data['reservation']['branch']) ?></p>
                        <p><strong>Date:</strong> <?= htmlspecialchars($data['reservation']['dates']) ?></p>
                        <p><strong>Time:</strong> <?= htmlspecialchars($data['reservation']['time_slot']) ?></p>
                    </div>
                    
                    <h5>Order Items</h5>
                    <?php 
                    $total = 0;
                    foreach ($data['items'] as $item): 
                        $item_total = $item['price'] * $item['quantity'];
                        $total += $item_total;
                    ?>
                        <div class="order-item d-flex justify-content-between">
                            <div>
                                <?= htmlspecialchars($item['item_name']) ?> 
                                <small class="text-muted">x<?= $item['quantity'] ?></small>
                            </div>
                            <div>₹<?= number_format($item_total, 2) ?></div>
                        </div>
                    <?php endforeach; ?>
                    
                    <div class="order-total text-end">
                        Total: ₹<?= number_format($total, 2) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>