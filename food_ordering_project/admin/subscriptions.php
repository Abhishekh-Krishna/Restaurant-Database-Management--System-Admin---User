<?php
session_start();
include '../db/config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT 
            c.customer_id,
            c.full_name,
            c.email,
            s.plan_name,
            s.price,
            s.start_date,
            s.end_date,
            s.status
        FROM Customer c
        LEFT JOIN (
            SELECT s1.*
            FROM Subscription s1
            INNER JOIN (
                SELECT customer_id, MAX(subscription_id) AS latest_subscription_id
                FROM Subscription
                GROUP BY customer_id
            ) s2 ON s1.subscription_id = s2.latest_subscription_id
        ) s ON c.customer_id = s.customer_id
        ORDER BY c.customer_id ASC";

$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Subscriptions | Taste of India</title>
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
                    <li class="nav-item"><a class="nav-link" href="payments.php">Payments</a></li>
                    <li class="nav-item"><a class="nav-link active" href="subscriptions.php">Subscriptions</a></li>
                    <li class="nav-item ms-lg-2"><a class="btn nav-cta" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container page-shell">
        <div class="page-hero text-center">
            <span class="eyebrow justify-content-center"><i class="bi bi-stars"></i> Subscription overview</span>
            <h1 class="page-title">Customer Subscription Status</h1>
            <p class="page-subtitle mx-auto">View all customers and quickly see whether they are subscribed or not subscribed.</p>
        </div>

        <div class="card table-card">
            <div class="card-body p-4">
                <?php if ($result && mysqli_num_rows($result) > 0) { ?>
                    <div class="table-responsive">
                        <table class="table premium-table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Customer ID</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Plan Name</th>
                                    <th>Price</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                        <td><?php echo $row['customer_id']; ?></td>
                                        <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                                        <td>
                                            <?php
                                            if ($row['plan_name'] == null || $row['plan_name'] == "") {
                                                echo "Not Subscribed";
                                            } else {
                                                echo htmlspecialchars($row['plan_name']);
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($row['price'] == null || $row['price'] == "") {
                                                echo "-";
                                            } else {
                                                echo "Rs. " . number_format($row['price'], 2);
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($row['start_date'] == null || $row['start_date'] == "") {
                                                echo "-";
                                            } else {
                                                echo htmlspecialchars($row['start_date']);
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($row['end_date'] == null || $row['end_date'] == "") {
                                                echo "-";
                                            } else {
                                                echo htmlspecialchars($row['end_date']);
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($row['status'] == null || $row['status'] == "") {
                                                echo '<span class="status-chip not">Not Active</span>';
                                            } else {
                                                $status_class = strtolower($row['status']);
                                                echo '<span class="status-chip ' . $status_class . '">' . htmlspecialchars($row['status']) . '</span>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } else { ?>
                    <div class="alert alert-info text-center mb-0">
                        No customer records found.
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
