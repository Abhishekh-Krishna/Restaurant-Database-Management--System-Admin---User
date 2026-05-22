<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$floating_cart_count = 0;
$floating_cart_total = 0;

if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $cart_item) {
        $quantity = isset($cart_item['quantity']) ? (int) $cart_item['quantity'] : 1;
        $price = isset($cart_item['price']) ? (float) $cart_item['price'] : 0;

        $floating_cart_count += $quantity;
        $floating_cart_total += $price * $quantity;
    }
}
?>

<?php if ($floating_cart_count > 0) { ?>
    <a href="cart.php" class="floating-cart-widget" aria-label="View cart with <?php echo $floating_cart_count; ?> items">
        <span class="floating-cart-badge">
            <span class="floating-cart-icon">
                <i class="bi bi-bag-check-fill"></i>
            </span>
            <span class="floating-cart-count"><?php echo $floating_cart_count; ?></span>
        </span>

        <span class="floating-cart-copy">
            <strong>View Cart</strong>
            <small><?php echo $floating_cart_count; ?> <?php echo $floating_cart_count == 1 ? 'item' : 'items'; ?></small>
        </span>

        <span class="floating-cart-total">
            Rs. <?php echo number_format($floating_cart_total, 2); ?>
        </span>

        <span class="floating-cart-arrow">
            <i class="bi bi-arrow-right"></i>
        </span>
    </a>
<?php } ?>
