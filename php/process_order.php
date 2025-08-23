<?php
session_start();
require 'db.php';

// Generate unique order number
$orderNumber = 'ORD-' . date('Ymd-His') . '-' . bin2hex(random_bytes(3));

try {
    $conn->begin_transaction();
    
    $stmt = $conn->prepare("INSERT INTO orders (order_number, item_name, price, quantity) VALUES (?, ?, ?, ?)");
    
    // Process each item in the cart
    foreach ($_POST['items'] as $item) {
        // Calculate total price for this item (price × quantity)
        $totalPrice = $item['price'] * $item['quantity'];
        
        $stmt->bind_param("ssdi", 
            $orderNumber,
            $item['name'],
            $totalPrice,  // Save the calculated total price
            $item['quantity']
        );
        
        if (!$stmt->execute()) {
            throw new Exception("Failed to insert item: " . $stmt->error);
        }
    }
    
    $conn->commit();
    
    // Store order number in session for reservation page
    $_SESSION['order_number'] = $orderNumber;
    
    // Debug output (remove in production)
    error_log("Order processed successfully. Number: $orderNumber");
    
    // CHANGED REDIRECT - using absolute URL
    $redirect_url = "http://" . $_SERVER['HTTP_HOST'] . "/restaurant_project/user/reservation.php?order_number=" . urlencode($orderNumber);
    header("Location: $redirect_url");
    exit();

} catch (Exception $e) {
    $conn->rollback();
    
    // Detailed error logging
    error_log("ORDER PROCESSING ERROR: " . $e->getMessage());
    
    // User-friendly message
    die("ERROR: Failed to save order. Please try again. Error: " . $e->getMessage());
}
?>