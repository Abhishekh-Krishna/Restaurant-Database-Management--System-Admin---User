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
    $restaurant_name = mysqli_real_escape_string($conn, $_POST['restaurant_name']);
    $owner_name = mysqli_real_escape_string($conn, $_POST['owner_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    $insert_sql = "INSERT INTO Restaurant (restaurant_name, owner_name, email, phone, address)
                   VALUES ('$restaurant_name', '$owner_name', '$email', '$phone', '$address')";

    if (mysqli_query($conn, $insert_sql)) {
        $success_message = "Outlet inserted successfully.";
    } else {
        $error_message = "Failed to insert outlet.";
    }
}

$restaurant_sql = "SELECT restaurant_id, restaurant_name, owner_name, email, phone, address
                   FROM Restaurant
                   ORDER BY restaurant_id DESC";
$restaurant_result = mysqli_query($conn, $restaurant_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Outlets | Taste of India</title>
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
                    <li class="nav-item"><a class="nav-link active" href="restaurants.php">Outlets</a></li>
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
            <span class="eyebrow justify-content-center"><i class="bi bi-shop-window"></i> Outlet management</span>
            <h1 class="page-title">Manage Outlets</h1>
            <p class="page-subtitle mx-auto">Add new outlets and review the list of brand locations in one clean admin workspace.</p>
        </div>

        <div class="split-layout">
            <div>
                <div class="card surface-card">
                    <div class="card-body p-4">
                        <h3 class="panel-title">Add Outlet</h3>

                        <?php if ($success_message != "") { ?>
                            <div class="alert alert-success"><?php echo $success_message; ?></div>
                        <?php } ?>

                        <?php if ($error_message != "") { ?>
                            <div class="alert alert-danger"><?php echo $error_message; ?></div>
                        <?php } ?>

                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="restaurant_name" class="form-label">Outlet Name</label>
                                <input type="text" class="form-control" id="restaurant_name" name="restaurant_name" required>
                            </div>

                            <div class="mb-3">
                                <label for="owner_name" class="form-label">Outlet Manager Name</label>
                                <input type="text" class="form-control" id="owner_name" name="owner_name" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" required>
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-premium">
                                    <i class="bi bi-plus-circle"></i>
                                    <span>Add Outlet</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div>
                <div class="card table-card">
                    <div class="card-body p-4">
                        <h3 class="panel-title">Outlet List</h3>

                        <?php if ($restaurant_result && mysqli_num_rows($restaurant_result) > 0) { ?>
                            <div class="table-responsive">
                                <table class="table premium-table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Outlet ID</th>
                                            <th>Outlet Name</th>
                                            <th>Outlet Manager</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_assoc($restaurant_result)) { ?>
                                            <tr>
                                                <td><?php echo $row['restaurant_id']; ?></td>
                                                <td><?php echo htmlspecialchars($row['restaurant_name']); ?></td>
                                                <td><?php echo htmlspecialchars($row['owner_name']); ?></td>
                                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                                <td><?php echo htmlspecialchars($row['phone']); ?></td>
                                                <td><?php echo htmlspecialchars($row['address']); ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } else { ?>
                            <div class="alert alert-info mb-0">No outlets found.</div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
