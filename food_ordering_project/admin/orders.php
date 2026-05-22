<?php
session_start();
include '../db/config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$success_message = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);
    $order_status = mysqli_real_escape_string($conn, $_POST['order_status']);

    $update_sql = "UPDATE Orders SET order_status = '$order_status' WHERE order_id = '$order_id'";

    if (mysqli_query($conn, $update_sql)) {
        $success_message = "Order status updated successfully.";
    } else {
        $error_message = "Failed to update order status.";
    }
}

$orders_sql = "SELECT 
                    o.order_id,
                    c.full_name,
                    o.restaurant_id,
                    o.order_date,
                    o.order_type,
                    o.total_amount,
                    o.order_status
               FROM Orders o
               INNER JOIN Customer c ON o.customer_id = c.customer_id
               ORDER BY o.order_id DESC";

$orders_result = mysqli_query($conn, $orders_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders | Taste of India</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="admin-theme.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg admin-navbar sticky-top">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">
                <img src="../assets/logo.svg" alt="Taste of India" class="brand-logo">
                <span>Admin</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="restaurants.php">Outlets</a></li>
                    <li class="nav-item"><a class="nav-link" href="menu_items.php">Menu Items</a></li>
                    <li class="nav-item"><a class="nav-link active" href="orders.php">Orders</a></li>
                    <li class="nav-item"><a class="nav-link" href="payments.php">Payments</a></li>
                    <li class="nav-item"><a class="nav-link" href="subscriptions.php">Subscriptions</a></li>
                    <li class="nav-item ms-lg-2"><a class="btn nav-cta" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container page-shell">
        <div class="page-hero text-center">
            <span class="eyebrow justify-content-center"><i class="bi bi-receipt"></i> Order oversight</span>
            <h1 class="page-title">Manage Orders</h1>
            <p class="page-subtitle mx-auto">Update order statuses and monitor recent customer orders in a clean, responsive admin view.</p>
        </div>

        <div class="split-layout">
            <div>
                <div class="card surface-card">
                    <div class="card-body p-4">
                        <h3 class="panel-title">Update Order Status</h3>

                        <?php if ($success_message != "") { ?>
                            <div class="alert alert-success"><?php echo $success_message; ?></div>
                        <?php } ?>

                        <?php if ($error_message != "") { ?>
                            <div class="alert alert-danger"><?php echo $error_message; ?></div>
                        <?php } ?>

                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="order_id" class="form-label">Order ID</label>
                                <input type="number" class="form-control" id="order_id" name="order_id" required>
                            </div>

                            <div class="mb-3">
                                <label for="order_status" class="form-label">New Order Status</label>
                                <input type="text" class="form-control" id="order_status" name="order_status" required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-premium">
                                    <i class="bi bi-arrow-repeat"></i>
                                    <span>Update Status</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div>
                <div class="card table-card">
                    <div class="card-body p-4">
                        <h3 class="panel-title">Order List</h3>

                        <?php if ($orders_result && mysqli_num_rows($orders_result) > 0) { ?>
                            <div class="table-responsive">
                                <table class="table premium-table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Customer Name</th>
                                            <th>Outlet ID</th>
                                            <th>Order Date</th>
                                            <th>Order Type</th>
                                            <th>Total Amount</th>
                                            <th>Order Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_assoc($orders_result)) { ?>
                                            <tr>
                                                <td><?php echo $row['order_id']; ?></td>
                                                <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                                                <td><?php echo $row['restaurant_id']; ?></td>
                                                <td><?php echo htmlspecialchars($row['order_date']); ?></td>
                                                <td><?php echo htmlspecialchars($row['order_type']); ?></td>
                                                <td>Rs. <?php echo number_format($row['total_amount'], 2); ?></td>
                                                <td><span class="status-chip <?php echo strtolower($row['order_status']); ?>"><?php echo htmlspecialchars($row['order_status']); ?></span></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } else { ?>
                            <div class="alert alert-info mb-0">No orders found.</div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
