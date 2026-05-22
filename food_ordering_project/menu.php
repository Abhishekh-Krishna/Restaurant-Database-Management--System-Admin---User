<?php
session_start();
include 'db/config.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

$restaurant_id = isset($_GET['restaurant_id']) ? mysqli_real_escape_string($conn, $_GET['restaurant_id']) : "";
$message = "";
$success_message = "";
$result = false;
$selected_outlet = null;
$menu_by_category = array();
$shared_menu_restaurant_id = 1;
$outlet_options = array(
    array(
        'restaurant_id' => 1,
        'restaurant_name' => 'Taste of India - Park Street Outlet',
        'location' => 'Park Street, Kolkata',
        'icon' => 'bi-shop-window'
    ),
    array(
        'restaurant_id' => 2,
        'restaurant_name' => 'Taste of India - Salt Lake Outlet',
        'location' => 'Salt Lake, Bidhannagar',
        'icon' => 'bi-building'
    ),
    array(
        'restaurant_id' => 3,
        'restaurant_name' => 'Taste of India - Gariahat Outlet',
        'location' => 'Gariahat, Ballygunge',
        'icon' => 'bi-geo-alt'
    )
);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    $item_id = mysqli_real_escape_string($conn, $_POST['item_id']);
    $item_name = mysqli_real_escape_string($conn, $_POST['item_name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $restaurant_id = mysqli_real_escape_string($conn, $_POST['restaurant_id']);
    $outlet_name = mysqli_real_escape_string($conn, $_POST['outlet_name']);

    $_SESSION['cart'][] = array(
        'item_id' => $item_id,
        'item_name' => $item_name,
        'item_type' => 'Regular',
        'price' => $price,
        'quantity' => 1,
        'restaurant_id' => $restaurant_id,
        'outlet_name' => $outlet_name
    );

    $success_message = "Item added to cart successfully.";
}

if ($restaurant_id != "") {
    $outlet_sql = "SELECT restaurant_id, restaurant_name FROM Restaurant WHERE restaurant_id = '$restaurant_id' LIMIT 1";
    $outlet_result = mysqli_query($conn, $outlet_sql);

    if ($outlet_result && mysqli_num_rows($outlet_result) > 0) {
        $selected_outlet = mysqli_fetch_assoc($outlet_result);
    }

    if ($selected_outlet) {
        $sql = "SELECT 
                    m.menu_item_id,
                    m.item_name,
                    c.category_name,
                    m.description,
                    m.price,
                    m.is_available
                FROM Menu_Item m
                INNER JOIN Category c ON m.category_id = c.category_id
                WHERE m.restaurant_id = '$shared_menu_restaurant_id'
                ORDER BY FIELD(c.category_name, 'Starters', 'Main Course', 'Breads', 'Rice & Biryani', 'Desserts', 'Beverages'), m.item_name";

        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $menu_by_category[$row['category_name']][] = $row;
            }
        }
    } else {
        $message = "Selected outlet was not found. Please choose an outlet again.";
    }
} else {
    $message = "";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu | Taste of India</title>
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
            <span class="eyebrow justify-content-center"><i class="bi bi-journal-richtext"></i> Explore outlet menu choices</span>
            <h1 class="page-title">Outlet Menu</h1>
            <p class="page-subtitle mx-auto">
                <?php if ($selected_outlet) { ?>
                    Browse the full Taste of India menu for <?php echo htmlspecialchars($selected_outlet['restaurant_name']); ?> and add available meals to your cart.
                <?php } else { ?>
                    Select one of our Taste of India outlets to explore the menu.
                <?php } ?>
            </p>
            <?php if ($selected_outlet) { ?>
                <div class="quick-actions justify-content-center mt-4">
                    <a href="menu.php" class="btn btn-outline-premium">
                        <i class="bi bi-arrow-repeat"></i>
                        <span>Change Outlet</span>
                    </a>
                </div>
            <?php } ?>
        </div>

        <?php if ($success_message != "") { ?>
            <div class="alert alert-success text-center">
                <?php echo $success_message; ?>
            </div>
        <?php } ?>

        <?php if ($message != "") { ?>
            <div class="alert alert-info text-center">
                <?php echo $message; ?>
            </div>
        <?php } ?>

        <?php if ($restaurant_id == "" || !$selected_outlet) { ?>
            <section class="course-filter-card">
                <div class="course-filter-heading">
                    <span class="section-label">Taste of India outlets</span>
                    <h2>Choose Your Outlet</h2>
                    <p>Select one of our Taste of India outlets to explore the menu.</p>
                </div>

                <div class="row g-4 listing-grid">
                    <?php foreach ($outlet_options as $outlet) { ?>
                        <div class="col-md-4">
                            <div class="card listing-card h-100">
                                <div class="card-body p-4 text-center">
                                    <span class="menu-icon-badge mx-auto mb-3">
                                        <i class="bi <?php echo $outlet['icon']; ?>"></i>
                                    </span>
                                    <span class="card-kicker mx-auto mb-3"><i class="bi bi-shop"></i> Outlet</span>
                                    <h4 class="card-title-strong"><?php echo htmlspecialchars($outlet['restaurant_name']); ?></h4>
                                    <p class="mb-4"><?php echo htmlspecialchars($outlet['location']); ?></p>
                                    <a href="menu.php?restaurant_id=<?php echo $outlet['restaurant_id']; ?>" class="btn btn-premium w-100">
                                        <i class="bi bi-journal-text"></i>
                                        <span>View Menu</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </section>
        <?php } ?>

        <?php if (!empty($menu_by_category)) { ?>
            <div class="course-filter-card">
                <div class="course-filter-heading">
                    <span class="section-label">Taste of India courses</span>
                    <h2>Choose a Course</h2>
                    <p>Jump straight to your favorite part of the menu.</p>
                </div>

                <div class="category-tabs">
                    <?php foreach ($menu_by_category as $category_name => $items) { ?>
                        <?php
                        $category_icon = "bi-stars";

                        if ($category_name == "Starters") {
                            $category_icon = "bi-fire";
                        } elseif ($category_name == "Main Course") {
                            $category_icon = "bi-egg-fried";
                        } elseif ($category_name == "Breads") {
                            $category_icon = "bi-circle";
                        } elseif ($category_name == "Rice & Biryani") {
                            $category_icon = "bi-basket2";
                        } elseif ($category_name == "Desserts") {
                            $category_icon = "bi-cake2";
                        } elseif ($category_name == "Beverages") {
                            $category_icon = "bi-cup-straw";
                        }
                        ?>
                        <a href="#<?php echo strtolower(str_replace(array(' ', '&'), array('-', 'and'), $category_name)); ?>" class="category-tab">
                            <i class="bi <?php echo $category_icon; ?>"></i>
                            <span class="category-tab-name"><?php echo htmlspecialchars($category_name); ?></span>
                            <span class="category-count"><?php echo count($items); ?></span>
                        </a>
                    <?php } ?>
                </div>
            </div>

            <?php foreach ($menu_by_category as $category_name => $items) { ?>
                <section class="menu-category-section" id="<?php echo strtolower(str_replace(array(' ', '&'), array('-', 'and'), $category_name)); ?>">
                    <div class="menu-category-heading">
                        <span class="section-label"><?php echo htmlspecialchars($category_name); ?></span>
                        <h2><?php echo htmlspecialchars($category_name); ?></h2>
                    </div>

                    <div class="row g-4 listing-grid">
                        <?php foreach ($items as $row) { ?>
                            <div class="col-md-6 col-xl-4">
                                <div class="card listing-card menu-card h-100">
                                    <div class="card-body">
                                        <div class="menu-card-top">
                                            <span class="menu-icon-badge"><i class="bi bi-stars"></i></span>
                                            <span class="card-kicker"><i class="bi bi-cup-hot"></i> <?php echo htmlspecialchars($row['category_name']); ?></span>
                                        </div>
                                        <h5 class="card-title-strong menu-item-title"><?php echo htmlspecialchars($row['item_name']); ?></h5>
                                        <div class="meta-list">
                                            <p><strong>Outlet:</strong> <?php echo htmlspecialchars($selected_outlet['restaurant_name']); ?></p>
                                            <p><strong>Description:</strong> <?php echo htmlspecialchars($row['description']); ?></p>
                                        </div>
                                        <div class="menu-card-actions">
                                            <span class="price-chip menu-price">Rs. <?php echo number_format($row['price'], 2); ?></span>
                                            <?php if ($row['is_available'] == 1) { ?>
                                                <span class="status-chip available">Available</span>
                                            <?php } else { ?>
                                                <span class="status-chip unavailable">Not Available</span>
                                            <?php } ?>
                                        </div>

                                        <?php if ($row['is_available'] == 1) { ?>
                                            <form method="POST" action="">
                                                <input type="hidden" name="item_id" value="<?php echo $row['menu_item_id']; ?>">
                                                <input type="hidden" name="item_name" value="<?php echo htmlspecialchars($row['item_name']); ?>">
                                                <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
                                                <input type="hidden" name="restaurant_id" value="<?php echo $restaurant_id; ?>">
                                                <input type="hidden" name="outlet_name" value="<?php echo htmlspecialchars($selected_outlet['restaurant_name']); ?>">
                                                <button type="submit" name="add_to_cart" class="btn btn-premium">
                                                    <i class="bi bi-cart-plus"></i>
                                                    <span>Add to Cart</span>
                                                </button>
                                            </form>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </section>
            <?php } ?>
            <?php } elseif ($restaurant_id != "") { ?>
                <div class="alert alert-warning text-center">
                    No menu items found.
                </div>
            <?php } ?>

        <?php if ($restaurant_id != "" && !$result) { ?>
            <div class="alert alert-danger mt-4 text-center">
                Error loading menu items.
            </div>
        <?php } ?>
    </div>

    <?php include 'customer_floating_cart.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

