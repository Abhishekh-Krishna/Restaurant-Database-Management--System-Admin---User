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
    $restaurant_id = mysqli_real_escape_string($conn, $_POST['restaurant_id']);
    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);
    $item_name = mysqli_real_escape_string($conn, $_POST['item_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $is_available = mysqli_real_escape_string($conn, $_POST['is_available']);

    $insert_sql = "INSERT INTO Menu_Item (restaurant_id, category_id, item_name, description, price, is_available)
                   VALUES ('$restaurant_id', '$category_id', '$item_name', '$description', '$price', '$is_available')";

    if (mysqli_query($conn, $insert_sql)) {
        $success_message = "Menu item added successfully.";
    } else {
        $error_message = "Failed to add menu item.";
    }
}

$restaurants_sql = "SELECT restaurant_id, restaurant_name FROM Restaurant ORDER BY restaurant_name ASC";
$restaurants_result = mysqli_query($conn, $restaurants_sql);

$categories_sql = "SELECT category_id, category_name FROM Category ORDER BY category_name ASC";
$categories_result = mysqli_query($conn, $categories_sql);

$menu_sql = "SELECT 
                m.menu_item_id,
                m.item_name,
                r.restaurant_name,
                c.category_name,
                m.description,
                m.price,
                m.is_available
             FROM Menu_Item m
             INNER JOIN Restaurant r ON m.restaurant_id = r.restaurant_id
             INNER JOIN Category c ON m.category_id = c.category_id
             ORDER BY m.menu_item_id DESC";

$menu_result = mysqli_query($conn, $menu_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Menu Items | Taste of India</title>
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
                    <li class="nav-item"><a class="nav-link active" href="menu_items.php">Menu Items</a></li>
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
            <span class="eyebrow justify-content-center"><i class="bi bi-journal-text"></i> Menu management</span>
            <h1 class="page-title">Manage Menu Items</h1>
            <p class="page-subtitle mx-auto">Add new menu items and review the current menu catalog across outlets.</p>
        </div>

        <div class="split-layout">
            <div>
                <div class="card surface-card">
                    <div class="card-body p-4">
                        <h3 class="panel-title">Add Menu Item</h3>

                        <?php if ($success_message != "") { ?>
                            <div class="alert alert-success"><?php echo $success_message; ?></div>
                        <?php } ?>

                        <?php if ($error_message != "") { ?>
                            <div class="alert alert-danger"><?php echo $error_message; ?></div>
                        <?php } ?>

                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="restaurant_id" class="form-label">Outlet</label>
                                <select class="form-select" id="restaurant_id" name="restaurant_id" required>
                                    <option value="">Select Outlet</option>
                                    <?php if ($restaurants_result && mysqli_num_rows($restaurants_result) > 0) { ?>
                                        <?php while ($restaurant = mysqli_fetch_assoc($restaurants_result)) { ?>
                                            <option value="<?php echo $restaurant['restaurant_id']; ?>">
                                                <?php echo htmlspecialchars($restaurant['restaurant_name']); ?>
                                            </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="category_id" class="form-label">Category</label>
                                <select class="form-select" id="category_id" name="category_id" required>
                                    <option value="">Select Category</option>
                                    <?php if ($categories_result && mysqli_num_rows($categories_result) > 0) { ?>
                                        <?php while ($category = mysqli_fetch_assoc($categories_result)) { ?>
                                            <option value="<?php echo $category['category_id']; ?>">
                                                <?php echo htmlspecialchars($category['category_name']); ?>
                                            </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="item_name" class="form-label">Item Name</label>
                                <input type="text" class="form-control" id="item_name" name="item_name" required>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                            </div>

                            <div class="mb-3">
                                <label for="is_available" class="form-label">Is Available</label>
                                <select class="form-select" id="is_available" name="is_available" required>
                                    <option value="1">Available</option>
                                    <option value="0">Not Available</option>
                                </select>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-premium">
                                    <i class="bi bi-plus-circle"></i>
                                    <span>Add Menu Item</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div>
                <div class="card table-card">
                    <div class="card-body p-4">
                        <h3 class="panel-title">Menu Item List</h3>

                        <?php if ($menu_result && mysqli_num_rows($menu_result) > 0) { ?>
                            <div class="table-responsive">
                                <table class="table premium-table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Item Name</th>
                                            <th>Outlet</th>
                                            <th>Category</th>
                                            <th>Description</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_assoc($menu_result)) { ?>
                                            <tr>
                                                <td><?php echo $row['menu_item_id']; ?></td>
                                                <td><?php echo htmlspecialchars($row['item_name']); ?></td>
                                                <td><?php echo htmlspecialchars($row['restaurant_name']); ?></td>
                                                <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                                                <td><?php echo htmlspecialchars($row['description']); ?></td>
                                                <td>Rs. <?php echo number_format($row['price'], 2); ?></td>
                                                <td><span class="status-chip <?php echo $row['is_available'] == 1 ? 'available' : 'not'; ?>"><?php echo $row['is_available'] == 1 ? 'Available' : 'Not Available'; ?></span></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } else { ?>
                            <div class="alert alert-info mb-0">No menu items found.</div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

