<?php
session_start();
include 'db/config.php';

if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

$customer_id = $_SESSION['customer_id'];

$sql = "SELECT order_id, order_date, order_type, total_amount, order_status
        FROM Orders
        WHERE customer_id = '$customer_id'
        ORDER BY order_date DESC";

$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders | Taste of India</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="customer-theme.css">
</head>
<body>
    <?php include 'customer_navbar.php'; ?>

    <div class="container page-shell">
        <div class="page-hero text-center">
            <span class="eyebrow justify-content-center"><i class="bi bi-receipt"></i> Order history</span>
            <h1 class="page-title">My Orders</h1>
            <p class="page-subtitle mx-auto">Track your recent and past orders, including order type, total amount, and current status.</p>
        </div>

        <?php if ($result && mysqli_num_rows($result) > 0) { ?>
            <div class="table-card">
                <div class="table-responsive">
                    <table class="table premium-table align-middle">
                        <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Order Date</th>
                            <th>Order Type</th>
                            <th>Total Amount</th>
                            <th>Order Status</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                <?php
                                $order_type_class = strtolower($row['order_type']);
                                $status_class = strtolower($row['order_status']);
                                ?>
                                <tr>
                                    <td>#<?php echo $row['order_id']; ?></td>
                                    <td><?php echo $row['order_date']; ?></td>
                                    <td><span class="status-chip <?php echo $order_type_class; ?>"><?php echo htmlspecialchars($row['order_type']); ?></span></td>
                                    <td>Rs. <?php echo number_format($row['total_amount'], 2); ?></td>
                                    <td><span class="status-chip <?php echo $status_class; ?>"><?php echo htmlspecialchars($row['order_status']); ?></span></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } else { ?>
            <div class="alert alert-info text-center">
                No orders found.
            </div>
        <?php } ?>

        <?php if (!$result) { ?>
            <div class="alert alert-danger text-center">
                Error loading orders.
            </div>
        <?php } ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

