<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taste of India | Outlet Ordering</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="homepage.css">
</head>
<body>
    <?php include 'customer_navbar.php'; ?>

    <section class="hero-section">
        <div class="hero-glow hero-glow-one"></div>
        <div class="hero-glow hero-glow-two"></div>
        <div class="hero-pattern"></div>
        <div class="container">
            <div class="row align-items-center hero-row g-5">
                <div class="col-lg-6">
                    <div class="hero-copy">
                        <span class="eyebrow">Authentic Indian meals. Nearby outlets.</span>
                        <h1>Taste of India brings warm Indian favorites to every outlet near you.</h1>
                        <p class="hero-text">
                            Order from your nearest Taste of India outlet, explore signature dishes, and subscribe for free delivery benefits.
                        </p>
                        <div class="hero-actions">
                            <a href="restaurants.php" class="btn btn-hero-primary btn-lg">
                                <i class="bi bi-bag-check"></i>
                                <span>Order From an Outlet</span>
                            </a>
                            <a href="menu.php" class="btn btn-hero-secondary btn-lg">
                                <i class="bi bi-journal-text"></i>
                                <span>View Menu</span>
                            </a>
                        </div>
                        <div class="hero-metrics">
                            <div class="metric-card">
                                <strong>Fresh choices</strong>
                                <span>Browse outlet menus and favorite dishes in one place.</span>
                            </div>
                            <div class="metric-card">
                                <strong>Subscription benefits</strong>
                                <span>Enjoy free delivery benefits with an active plan.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-showcase">
                        <div class="showcase-panel main-panel">
                            <div class="showcase-badge">
                                <i class="bi bi-stars"></i>
                                Premium ordering experience
                            </div>
                            <h2>A modern Indian restaurant experience built around your nearest outlet.</h2>
                            <p>
                                Discover outlet menus, quick ordering, and subscription benefits inside one polished platform.
                            </p>
                            <div class="showcase-highlight">
                                <span class="highlight-pill">
                                    <i class="bi bi-clock-history"></i>
                                    Fast ordering
                                </span>
                                <span class="highlight-pill">
                                    <i class="bi bi-patch-check"></i>
                                    Trusted outlets
                                </span>
                                <span class="highlight-pill">
                                    <i class="bi bi-recycle"></i>
                                    Subscription benefits
                                </span>
                            </div>
                            <div class="mini-grid">
                                <div class="mini-card">
                                    <i class="bi bi-bag-heart-fill"></i>
                                    <div>
                                        <strong>Fast ordering flow</strong>
                                        <small>Simple browsing and checkout experience.</small>
                                    </div>
                                </div>
                                <div class="mini-card">
                                    <i class="bi bi-shop"></i>
                                    <div>
                                        <strong>Outlet selection</strong>
                                        <small>Choose the outlet nearest to you.</small>
                                    </div>
                                </div>
                                <div class="mini-card">
                                    <i class="bi bi-percent"></i>
                                    <div>
                                        <strong>Subscription benefits</strong>
                                        <small>Unlock delivery benefits with your plan.</small>
                                    </div>
                                </div>
                                <div class="mini-card">
                                    <i class="bi bi-shield-check"></i>
                                    <div>
                                        <strong>Simple management</strong>
                                        <small>Track orders, payments, and meal status.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="floating-note note-top">
                            <span class="note-icon"><i class="bi bi-fire"></i></span>
                            <div>
                                <strong>Popular today</strong>
                                <small>Hot meals and special offers</small>
                            </div>
                        </div>
                        <div class="floating-note note-bottom">
                            <span class="note-icon"><i class="bi bi-leaf-fill"></i></span>
                            <div>
                                <strong>Member benefits</strong>
                                <small>Subscribe for free delivery</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="feature-section py-5">
        <div class="container">
            <div class="section-heading text-center mb-5">
                <span class="section-label">Why choose our platform</span>
                <h2>Built for modern outlet ordering</h2>
                <p>Simple tools for customers, outlets, subscriptions, and order management, presented with a cleaner and more premium experience.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card h-100">
                        <div class="card-body p-4 p-xl-5">
                            <div class="feature-icon"><i class="bi bi-phone-fill"></i></div>
                            <h4 class="mb-3">Taste of India Online Ordering</h4>
                            <p class="mb-0">
                                Choose an outlet, browse our menu, and place food orders quickly through an easy-to-use online system.
                            </p>
                            <div class="feature-link">
                                <span>Order with confidence</span>
                                <i class="bi bi-arrow-up-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card h-100">
                        <div class="card-body p-4 p-xl-5">
                            <div class="feature-icon"><i class="bi bi-stars"></i></div>
                            <h4 class="mb-3">Subscription Benefits</h4>
                            <p class="mb-0">
                                Subscribe to enjoy account benefits like waived delivery fees on eligible orders.
                            </p>
                            <div class="feature-link">
                                <span>Unlock member benefits</span>
                                <i class="bi bi-arrow-up-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card h-100">
                        <div class="card-body p-4 p-xl-5">
                            <div class="feature-icon"><i class="bi bi-receipt-cutoff"></i></div>
                            <h4 class="mb-3">Easy Order and Payment Management</h4>
                            <p class="mb-0">
                                Keep track of customer orders, payment details, and order status in a clear and organized way.
                            </p>
                            <div class="feature-link">
                                <span>Clear and organized workflow</span>
                                <i class="bi bi-arrow-up-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-strip">
        <div class="container">
            <div class="cta-strip-inner">
                <div>
                    <span class="section-label">Start your experience</span>
                    <h3>Discover Taste of India meals, outlet offers, and smarter food choices today.</h3>
                </div>
                <div class="cta-strip-actions">
                    <a href="restaurants.php" class="btn btn-hero-primary">
                        <i class="bi bi-shop-window"></i>
                        <span>Explore Outlets</span>
                    </a>
                    <a href="menu.php" class="btn btn-hero-secondary">
                        <i class="bi bi-journal-text"></i>
                        <span>View Menu</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <footer class="site-footer text-center text-lg-start">
        <div class="container">
            <div class="row align-items-center gy-3">
                <div class="col-lg-8">
                    <h5>Taste of India</h5>
                    <p class="mb-0">A warm modern restaurant brand for outlet-based ordering, subscriptions, and simple account access.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <p class="mb-0">&copy; 2026 All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

