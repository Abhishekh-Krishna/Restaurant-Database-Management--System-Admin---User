<?php
session_start();
include '../db/config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$full_name = $_SESSION['full_name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Taste of India</title>
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
                    <li class="nav-item"><a class="nav-link active" href="dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="restaurants.php">Outlets</a></li>
                    <li class="nav-item"><a class="nav-link" href="menu_items.php">Menu Items</a></li>
                    <li class="nav-item"><a class="nav-link" href="orders.php">Orders</a></li>
                    <li class="nav-item"><a class="nav-link" href="payments.php">Payments</a></li>
                    <li class="nav-item"><a class="nav-link" href="subscriptions.php">Subscriptions</a></li>
                    <li class="nav-item ms-lg-2"><a class="btn nav-cta" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container page-shell">
        <div class="page-hero text-center">
            <span class="eyebrow justify-content-center"><i class="bi bi-speedometer2"></i> Admin workspace</span>
            <h1 class="page-title">Admin Dashboard</h1>
            <p class="page-subtitle mx-auto">Welcome, <?php echo htmlspecialchars($full_name); ?>. Manage outlets, menu items, orders, payments, and subscriptions from one premium admin workspace.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body text-center p-4">
                        <div class="dashboard-icon mx-auto"><i class="bi bi-shop-window"></i></div>
                        <h4 class="mb-3">Manage Outlets</h4>
                        <p>Add, view, or update outlet details.</p>
                        <a href="restaurants.php" class="btn btn-premium">Open</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body text-center p-4">
                        <div class="dashboard-icon mx-auto"><i class="bi bi-journal-text"></i></div>
                        <h4 class="mb-3">Manage Menu Items</h4>
                        <p>Manage food items available in the system.</p>
                        <a href="menu_items.php" class="btn btn-premium">Open</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body text-center p-4">
                        <div class="dashboard-icon mx-auto"><i class="bi bi-receipt"></i></div>
                        <h4 class="mb-3">View Orders</h4>
                        <p>Check customer orders and their current status.</p>
                        <a href="orders.php" class="btn btn-premium">Open</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body text-center p-4">
                        <div class="dashboard-icon mx-auto"><i class="bi bi-credit-card-2-front"></i></div>
                        <h4 class="mb-3">View Payments</h4>
                        <p>See payment records and payment status details.</p>
                        <a href="payments.php" class="btn btn-premium">Open</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body text-center p-4">
                        <div class="dashboard-icon mx-auto"><i class="bi bi-stars"></i></div>
                        <h4 class="mb-3">View Subscriptions</h4>
                        <p>Check which users are subscribed or not subscribed.</p>
                        <a href="subscriptions.php" class="btn btn-premium">Open</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body text-center p-4">
                        <div class="dashboard-icon mx-auto"><i class="bi bi-box-arrow-right"></i></div>
                        <h4 class="mb-3">Logout</h4>
                        <p>Sign out from the admin dashboard safely.</p>
                        <a href="logout.php" class="btn btn-danger-soft">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
