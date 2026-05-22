<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$current_page = basename($_SERVER['PHP_SELF']);
$is_logged_in = isset($_SESSION['customer_id']);
$customer_name = '';

if ($is_logged_in && isset($_SESSION['full_name']) && trim($_SESSION['full_name']) !== '') {
    $customer_name = trim($_SESSION['full_name']);
}

function customer_nav_active($page_name, $current_page) {
    return $page_name === $current_page ? ' active' : '';
}
?>
<nav class="navbar navbar-expand-lg premium-navbar sticky-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="assets/logo.svg" alt="Taste of India" class="brand-logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item"><a class="nav-link<?php echo customer_nav_active('index.php', $current_page); ?>" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link<?php echo customer_nav_active('restaurants.php', $current_page); ?>" href="restaurants.php">Outlets</a></li>
                <li class="nav-item"><a class="nav-link<?php echo customer_nav_active('menu.php', $current_page); ?>" href="menu.php">Menu</a></li>
                <?php if ($is_logged_in) { ?>
                    <li class="nav-item"><a class="nav-link<?php echo customer_nav_active('cart.php', $current_page); ?>" href="cart.php">Cart</a></li>
                    <li class="nav-item"><a class="nav-link<?php echo customer_nav_active('my_orders.php', $current_page); ?>" href="my_orders.php">My Orders</a></li>
                    <li class="nav-item"><a class="nav-link<?php echo customer_nav_active('subscription.php', $current_page); ?>" href="subscription.php">Subscription</a></li>
                    <?php if ($customer_name !== '') { ?>
                        <li class="nav-item"><span class="nav-link disabled">Welcome, <?php echo htmlspecialchars($customer_name); ?></span></li>
                    <?php } ?>
                    <li class="nav-item ms-lg-2"><a class="btn nav-cta" href="logout.php">Logout</a></li>
                <?php } else { ?>
                    <li class="nav-item"><a class="nav-link<?php echo customer_nav_active('login.php', $current_page); ?>" href="login.php">Login</a></li>
                    <li class="nav-item ms-lg-2"><a class="btn nav-cta" href="register.php">Register</a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>
