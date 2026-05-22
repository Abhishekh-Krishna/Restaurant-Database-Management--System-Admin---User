<?php
session_start();
include 'db/config.php';

$sql = "SELECT restaurant_id, restaurant_name, owner_name, email, phone, address
        FROM Restaurant
        WHERE email IN (
            'parkstreet@tasteofindia.com',
            'saltlake@tasteofindia.com',
            'gariahat@tasteofindia.com'
        )
        ORDER BY restaurant_id ASC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Outlets | Taste of India</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="customer-theme.css">
</head>
<body>
    <?php include 'customer_navbar.php'; ?>

    <section class="container page-shell">
        <div class="page-hero text-center">
            <span class="eyebrow justify-content-center"><i class="bi bi-shop-window"></i> Choose your nearest outlet</span>
            <h1 class="page-title">Our Outlets</h1>
            <p class="page-subtitle mx-auto">Browse our outlet details and choose the best Taste of India location before viewing its menu.</p>
        </div>

        <div class="row g-4 listing-grid">
                <?php if ($result && mysqli_num_rows($result) > 0) { ?>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card listing-card h-100">
                                <div class="card-body p-4">
                                    <span class="card-kicker"><i class="bi bi-shop"></i> Outlet</span>
                                    <h4 class="card-title-strong"><?php echo htmlspecialchars($row['restaurant_name']); ?></h4>
                                    <div class="meta-list">
                                        <p><strong>Outlet Manager:</strong> <?php echo htmlspecialchars($row['owner_name']); ?></p>
                                        <p><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>
                                        <p><strong>Phone:</strong> <?php echo htmlspecialchars($row['phone']); ?></p>
                                        <p><strong>Address:</strong> <?php echo htmlspecialchars($row['address']); ?></p>
                                    </div>
                                    <a href="menu.php?restaurant_id=<?php echo $row['restaurant_id']; ?>" class="btn btn-premium">
                                        <i class="bi bi-journal-text"></i>
                                        <span>View Menu</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            No outlets found in the database.
                        </div>
                    </div>
                <?php } ?>
        </div>
    </section>

    <?php include 'customer_floating_cart.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

