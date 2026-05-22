<?php
session_start();
include '../db/config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$payments_sql = "SELECT 
                    p.payment_id,
                    o.order_id,
                    p.payment_date,
                    p.amount_paid,
                    p.payment_method,
                    p.payment_status
                 FROM Payment p
                 INNER JOIN Orders o ON p.order_id = o.order_id
                 ORDER BY p.payment_id DESC";

$payments_result = mysqli_query($conn, $payments_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Payments | Taste of India</title>
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
                    <li class="nav-item"><a class="nav-link" href="orders.php">Orders</a></li>
                    <li class="nav-item"><a class="nav-link active" href="payments.php">Payments</a></li>
                    <li class="nav-item"><a class="nav-link" href="subscriptions.php">Subscriptions</a></li>
                    <li class="nav-item ms-lg-2"><a class="btn nav-cta" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container page-shell">
        <div class="page-hero text-center">
            <span class="eyebrow justify-content-center"><i class="bi bi-credit-card-2-front"></i> Payment records</span>
            <h1 class="page-title">View Payments</h1>
            <p class="page-subtitle mx-auto">Review payment history, amounts, methods, and statuses across all processed orders.</p>
        </div>

        <div class="card table-card">
            <div class="card-body p-4">
                <h2 class="panel-title">Payment List</h2>

                <?php if ($payments_result && mysqli_num_rows($payments_result) > 0) { ?>
                    <div class="table-responsive">
                        <table class="table premium-table table-hover">
                            <thead>
                                <tr>
                                    <th>Payment ID</th>
                                    <th>Order ID</th>
                                    <th>Payment Date</th>
                                    <th>Amount Paid</th>
                                    <th>Payment Method</th>
                                    <th>Payment Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($payments_result)) { ?>
                                    <tr>
                                        <td><?php echo $row['payment_id']; ?></td>
                                        <td><?php echo $row['order_id']; ?></td>
                                        <td><?php echo htmlspecialchars($row['payment_date']); ?></td>
                                        <td>Rs. <?php echo number_format($row['amount_paid'], 2); ?></td>
                                        <td><?php echo htmlspecialchars($row['payment_method']); ?></td>
                                        <td><span class="status-chip <?php echo strtolower($row['payment_status']); ?>"><?php echo htmlspecialchars($row['payment_status']); ?></span></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } else { ?>
                    <div class="alert alert-info mb-0">No payments found.</div>
                <?php } ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
