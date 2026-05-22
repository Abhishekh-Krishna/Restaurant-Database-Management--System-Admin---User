<?php
session_start();
include 'db/config.php';

if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

$customer_id = $_SESSION['customer_id'];

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

$cart_items = $_SESSION['cart'];
$success_message = "";
$error_message = "";
$successful_order_id = "";
$items_total = 0;
$delivery_fee = 40.00;
$final_total = 0;

foreach ($cart_items as $item) {
    $items_total += $item['price'] * $item['quantity'];
}

$subscription_sql = "SELECT subscription_id FROM Subscription
                     WHERE customer_id = '$customer_id' AND status = 'Active'
                     ORDER BY subscription_id DESC
                     LIMIT 1";
$subscription_result = mysqli_query($conn, $subscription_sql);
$has_active_subscription = $subscription_result && mysqli_num_rows($subscription_result) > 0;

if ($has_active_subscription) {
    $delivery_fee = 0.00;
}

$final_total = $items_total + $delivery_fee;

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($cart_items)) {
    $order_type = mysqli_real_escape_string($conn, $_POST['order_type']);
    $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);
    $first_item = $cart_items[0];
    $restaurant_id = 0;

    if (isset($first_item['restaurant_id']) && $first_item['restaurant_id'] > 0) {
        $restaurant_id = mysqli_real_escape_string($conn, $first_item['restaurant_id']);
    } elseif ($first_item['item_type'] == 'Regular') {
        $item_id = mysqli_real_escape_string($conn, $first_item['item_id']);
        $restaurant_query = "SELECT restaurant_id FROM Menu_Item WHERE menu_item_id = '$item_id'";
    } else {
        $item_id = mysqli_real_escape_string($conn, $first_item['item_id']);
        $restaurant_query = "SELECT restaurant_id FROM Surplus_Item WHERE surplus_item_id = '$item_id'";
    }

    if ($restaurant_id == 0) {
        $restaurant_result = mysqli_query($conn, $restaurant_query);

        if ($restaurant_result && mysqli_num_rows($restaurant_result) > 0) {
            $restaurant_row = mysqli_fetch_assoc($restaurant_result);
            $restaurant_id = $restaurant_row['restaurant_id'];
        }
    }

    if ($restaurant_id > 0) {
        $order_sql = "INSERT INTO Orders (customer_id, restaurant_id, order_type, total_amount, order_status)
                      VALUES ('$customer_id', '$restaurant_id', '$order_type', '$final_total', 'Pending')";

        if (mysqli_query($conn, $order_sql)) {
            $order_id = mysqli_insert_id($conn);
            $details_saved = true;

            foreach ($cart_items as $item) {
                $item_id = mysqli_real_escape_string($conn, $item['item_id']);
                $quantity = mysqli_real_escape_string($conn, $item['quantity']);
                $unit_price = mysqli_real_escape_string($conn, $item['price']);

                if ($item['item_type'] == 'Regular') {
                    $details_sql = "INSERT INTO Order_Details (order_id, menu_item_id, surplus_item_id, quantity, unit_price)
                                    VALUES ('$order_id', '$item_id', NULL, '$quantity', '$unit_price')";
                } else {
                    $details_sql = "INSERT INTO Order_Details (order_id, menu_item_id, surplus_item_id, quantity, unit_price)
                                    VALUES ('$order_id', NULL, '$item_id', '$quantity', '$unit_price')";
                }

                if (!mysqli_query($conn, $details_sql)) {
                    $details_saved = false;
                    break;
                }
            }

            if ($details_saved) {
                $payment_sql = "INSERT INTO Payment (order_id, amount_paid, payment_method, payment_status)
                                VALUES ('$order_id', '$final_total', '$payment_method', 'Paid')";

                if (mysqli_query($conn, $payment_sql)) {
                    $_SESSION['cart'] = array();
                    $cart_items = array();
                    $successful_order_id = $order_id;
                    $success_message = "Order placed successfully. Your Order ID is " . $order_id . ".";
                } else {
                    $error_message = "Payment could not be saved.";
                }
            } else {
                $error_message = "Order details could not be saved.";
            }
        } else {
            $error_message = "Order could not be placed.";
        }
    } else {
        $error_message = "Outlet could not be determined from cart items.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | Taste of India</title>
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
            <span class="eyebrow justify-content-center"><i class="bi bi-credit-card-2-front"></i> Final step</span>
            <h1 class="page-title">Checkout</h1>
            <p class="page-subtitle mx-auto">Review your items, choose order type and payment method, and place your order with confidence.</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card surface-card">
                    <div class="card-body p-4 p-md-5">
                        <h2 class="text-center auth-card-title mb-4">Complete Your Order</h2>

                        <?php if ($success_message != "") { ?>
                            <div class="alert alert-success text-center"><?php echo $success_message; ?></div>
                        <?php } ?>

                        <?php if ($error_message != "") { ?>
                            <div class="alert alert-danger text-center"><?php echo $error_message; ?></div>
                        <?php } ?>

                        <?php if (empty($cart_items) && $success_message == "") { ?>
                            <div class="alert alert-info text-center">
                                Your cart is empty.
                            </div>
                            <div class="text-center">
                                <a href="cart.php" class="btn btn-outline-premium">
                                    <i class="bi bi-arrow-left-circle"></i>
                                    <span>Back to Cart</span>
                                </a>
                            </div>
                        <?php } else { ?>
                            <?php if (!empty($cart_items)) { ?>
                                <div class="table-card mb-4">
                                    <div class="table-responsive">
                                        <table class="table premium-table align-middle">
                                            <thead>
                                            <tr>
                                                <th>Item Name</th>
                                                <th>Item Type</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Subtotal</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($cart_items as $item) { ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($item['item_name']); ?></td>
                                                        <td><span class="status-chip <?php echo strtolower($item['item_type']); ?>"><?php echo htmlspecialchars($item['item_type']); ?></span></td>
                                                        <td>Rs. <?php echo number_format($item['price'], 2); ?></td>
                                                        <td><?php echo $item['quantity']; ?></td>
                                                        <td>Rs. <?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <form method="POST" action="">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="order_type" class="form-label">Order Type</label>
                                            <select class="form-select" id="order_type" name="order_type" required>
                                                <option value="">Select Order Type</option>
                                                <option value="Regular">Regular</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="payment_method" class="form-label">Payment Method</label>
                                            <select class="form-select" id="payment_method" name="payment_method" required>
                                                <option value="">Select Payment Method</option>
                                                <option value="Cash on Delivery">Cash on Delivery</option>
                                                <option value="UPI">UPI</option>
                                                <option value="Card">Card</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="items_total" class="form-label">Items Total</label>
                                        <input type="text" class="form-control" id="items_total" value="Rs. <?php echo number_format($items_total, 2); ?>" readonly>
                                    </div>

                                    <div class="mb-4">
                                        <label for="delivery_fee" class="form-label">Delivery Fee</label>
                                        <input type="text" class="form-control" id="delivery_fee" value="Rs. <?php echo number_format($delivery_fee, 2); ?><?php echo $has_active_subscription ? ' (Subscription Applied)' : ''; ?>" readonly>
                                    </div>

                                    <div class="mb-4">
                                        <label for="final_total" class="form-label">Final Total</label>
                                        <input type="text" class="form-control" id="final_total" value="Rs. <?php echo number_format($final_total, 2); ?>" readonly>
                                    </div>

                                    <div class="d-grid d-md-flex justify-content-md-end">
                                        <button type="submit" class="btn btn-premium">
                                            <i class="bi bi-check2-circle"></i>
                                            <span>Place Order</span>
                                        </button>
                                    </div>
                                </form>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if ($successful_order_id != "") { ?>
        <div class="order-success-widget" role="status" aria-live="polite">
            <div class="order-success-icon">
                <i class="bi bi-check2-circle"></i>
            </div>
            <div class="order-success-copy">
                <span class="order-success-label">Order placed successfully</span>
                <strong>Order #<?php echo htmlspecialchars($successful_order_id); ?></strong>
            </div>
            <a href="my_orders.php" class="order-success-cta">
                <span>View My Orders</span>
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    <?php } ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

