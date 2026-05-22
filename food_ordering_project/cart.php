<?php
session_start();
include 'db/config.php';

if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

if (isset($_GET['remove'])) {
    $remove_index = $_GET['remove'];

    if (isset($_SESSION['cart'][$remove_index])) {
        unset($_SESSION['cart'][$remove_index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }

    header("Location: cart.php");
    exit();
}

$total_amount = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart | Taste of India</title>
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
            <span class="eyebrow justify-content-center"><i class="bi bi-cart3"></i> Review before checkout</span>
            <h1 class="page-title">My Cart</h1>
            <p class="page-subtitle mx-auto">Review your selected food items, remove anything you do not need, and continue smoothly into checkout.</p>
        </div>

        <?php if (!empty($_SESSION['cart'])) { ?>
            <div class="table-card">
                <div class="table-responsive">
                    <table class="table premium-table align-middle">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Outlet</th>
                                <th>Item Type</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($_SESSION['cart'] as $index => $item) { ?>
                                <?php
                                $price = $item['price'];
                                $quantity = $item['quantity'];
                                $subtotal = $price * $quantity;
                                $total_amount += $subtotal;
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['item_name']); ?></td>
                                    <td><?php echo isset($item['outlet_name']) ? htmlspecialchars($item['outlet_name']) : 'Selected outlet'; ?></td>
                                    <td><span class="status-chip <?php echo strtolower($item['item_type']); ?>"><?php echo htmlspecialchars($item['item_type']); ?></span></td>
                                    <td>Rs. <?php echo number_format($price, 2); ?></td>
                                    <td><?php echo $quantity; ?></td>
                                    <td>Rs. <?php echo number_format($subtotal, 2); ?></td>
                                    <td><a href="cart.php?remove=<?php echo $index; ?>" class="btn btn-danger-soft btn-sm">Remove</a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="5" class="text-end table-total">Total Amount</th>
                                <th colspan="2" class="table-total">Rs. <?php echo number_format($total_amount, 2); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="quick-actions mt-4">
                    <a href="menu.php" class="btn btn-outline-premium">
                        <i class="bi bi-arrow-left-circle"></i>
                        <span>Continue Shopping</span>
                    </a>
                    <a href="checkout.php" class="btn btn-premium">
                        <i class="bi bi-credit-card"></i>
                        <span>Proceed to Checkout</span>
                    </a>
                </div>
            </div>
        <?php } else { ?>
            <div class="alert alert-info text-center">
                Your cart is empty.
            </div>

            <div class="quick-actions justify-content-center mt-4">
                <a href="menu.php" class="btn btn-outline-premium">
                    <i class="bi bi-arrow-left-circle"></i>
                    <span>Continue Shopping</span>
                </a>
                <a href="restaurants.php" class="btn btn-premium">
                    <i class="bi bi-shop-window"></i>
                    <span>Choose an Outlet</span>
                </a>
            </div>
        <?php } ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

