<?php
session_start();
include 'db/config.php';

if (!isset($_SESSION['customer_id'])) {
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
    <title>User Dashboard | Taste of India</title>
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
            <span class="eyebrow justify-content-center"><i class="bi bi-grid"></i> Customer space</span>
            <h1 class="page-title">User Dashboard</h1>
            <p class="page-subtitle mx-auto">Welcome, <?php echo htmlspecialchars($full_name); ?>. Quickly access outlets, menu browsing, your cart, subscriptions, and your orders from one clean workspace.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="card dashboard-tile h-100">
                    <div class="card-body text-center p-4">
                        <div class="dashboard-icon mx-auto"><i class="bi bi-shop-window"></i></div>
                        <h4 class="mb-3">Choose an Outlet</h4>
                        <p>Browse all outlets available for this restaurant brand.</p>
                        <a href="restaurants.php" class="btn btn-premium">Open</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card dashboard-tile h-100">
                    <div class="card-body text-center p-4">
                        <div class="dashboard-icon mx-auto"><i class="bi bi-journal-text"></i></div>
                        <h4 class="mb-3">View Menu</h4>
                        <p>Check regular menu items from selected outlets.</p>
                        <a href="menu.php" class="btn btn-premium">Open</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card dashboard-tile h-100">
                    <div class="card-body text-center p-4">
                        <div class="dashboard-icon mx-auto"><i class="bi bi-credit-card-2-front"></i></div>
                        <h4 class="mb-3">Checkout</h4>
                        <p>Place your food order quickly.</p>
                        <a href="checkout.php" class="btn btn-premium">Open</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card dashboard-tile h-100">
                    <div class="card-body text-center p-4">
                        <div class="dashboard-icon mx-auto"><i class="bi bi-receipt"></i></div>
                        <h4 class="mb-3">My Orders</h4>
                        <p>View all your recent and past orders in one place.</p>
                        <a href="my_orders.php" class="btn btn-premium">Open</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card dashboard-tile h-100">
                    <div class="card-body text-center p-4">
                        <div class="dashboard-icon mx-auto"><i class="bi bi-stars"></i></div>
                        <h4 class="mb-3">Subscription</h4>
                        <p>View your subscription details or start a new plan for your account.</p>
                        <a href="subscription.php" class="btn btn-premium">Open</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card dashboard-tile h-100">
                    <div class="card-body text-center p-4">
                        <div class="dashboard-icon mx-auto"><i class="bi bi-box-arrow-right"></i></div>
                        <h4 class="mb-3">Logout</h4>
                        <p>Sign out from your account safely.</p>
                        <a href="logout.php" class="btn btn-danger-soft">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'customer_floating_cart.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

