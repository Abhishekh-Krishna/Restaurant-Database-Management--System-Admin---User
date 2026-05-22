<?php
session_start();
include 'db/config.php';

if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

$customer_id = $_SESSION['customer_id'];
$success_message = "";
$error_message = "";
$subscription = null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['subscribe'])) {
    $plan_name = mysqli_real_escape_string($conn, $_POST['plan_name']);
    $price = 0;

    if ($plan_name == "Monthly") {
        $price = 199.00;
    } elseif ($plan_name == "Premium Monthly") {
        $price = 499.00;
    }

    $start_date = date("Y-m-d");
    $end_date = date("Y-m-d", strtotime("+30 days"));
    $status = "Active";

    $insert_sql = "INSERT INTO Subscription (customer_id, plan_name, price, start_date, end_date, status)
                   VALUES ('$customer_id', '$plan_name', '$price', '$start_date', '$end_date', '$status')";

    if (mysqli_query($conn, $insert_sql)) {
        $success_message = "Subscription created successfully.";
    } else {
        $error_message = "Subscription could not be created: " . mysqli_error($conn);
    }
}

$subscription_sql = "SELECT subscription_id, plan_name, price, start_date, end_date, status
                     FROM Subscription
                     WHERE customer_id = '$customer_id'
                     ORDER BY subscription_id DESC
                     LIMIT 1";
$subscription_result = mysqli_query($conn, $subscription_sql);

if ($subscription_result && mysqli_num_rows($subscription_result) > 0) {
    $subscription = mysqli_fetch_assoc($subscription_result);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription | Taste of India</title>
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
            <span class="eyebrow justify-content-center"><i class="bi bi-stars"></i> Premium access</span>
            <h1 class="page-title">Subscription</h1>
            <p class="page-subtitle mx-auto">View your current subscription details or start a new subscription plan for your account.</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card surface-card">
                    <div class="card-body p-4 p-md-5">
                        <?php if ($success_message != "") { ?>
                            <div class="alert alert-success text-center"><?php echo $success_message; ?></div>
                        <?php } ?>

                        <?php if ($error_message != "") { ?>
                            <div class="alert alert-danger text-center"><?php echo $error_message; ?></div>
                        <?php } ?>

                        <?php if ($subscription) { ?>
                            <h2 class="auth-card-title text-center mb-4">Current Subscription</h2>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="table-card h-100">
                                        <p class="mb-2"><strong>Plan Name:</strong> <?php echo htmlspecialchars($subscription['plan_name']); ?></p>
                                        <p class="mb-2"><strong>Price:</strong> Rs. <?php echo number_format($subscription['price'], 2); ?></p>
                                        <p class="mb-2"><strong>Start Date:</strong> <?php echo htmlspecialchars($subscription['start_date']); ?></p>
                                        <p class="mb-0"><strong>End Date:</strong> <?php echo htmlspecialchars($subscription['end_date']); ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="table-card h-100 d-flex flex-column justify-content-center align-items-md-start align-items-center text-center text-md-start">
                                        <span class="status-chip <?php echo strtolower($subscription['status']); ?> mb-3"><?php echo htmlspecialchars($subscription['status']); ?></span>
                                        <p class="section-note mb-0">Your latest subscription is active on this account. You can keep using the platform with your current plan details shown here.</p>
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>
                            <h2 class="auth-card-title text-center mb-3">Subscribe Now</h2>
                            <p class="auth-card-subtitle text-center">Choose a simple subscription plan to activate your account benefits.</p>

                            <form method="POST" action="">
                                <div class="mb-4">
                                    <label for="plan_name" class="form-label">Plan Name</label>
                                    <select class="form-select" id="plan_name" name="plan_name" required>
                                        <option value="">Select Plan</option>
                                        <option value="Monthly">Monthly</option>
                                        <option value="Premium Monthly">Premium Monthly</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Plan Prices</label>
                                    <div class="table-card">
                                        <p class="mb-2"><strong>Monthly:</strong> Rs. 199.00</p>
                                        <p class="mb-0"><strong>Premium Monthly:</strong> Rs. 499.00</p>
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" name="subscribe" class="btn btn-premium">
                                        <i class="bi bi-check2-circle"></i>
                                        <span>Subscribe</span>
                                    </button>
                                </div>
                            </form>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'customer_floating_cart.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

