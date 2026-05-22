<?php
session_start();
include 'db/config.php';

$success_message = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    $sql = "INSERT INTO Customer (full_name, email, password, phone, address)
            VALUES ('$full_name', '$email', '$password', '$phone', '$address')";

    if (mysqli_query($conn, $sql)) {
        $success_message = "Registration successful. Your account has been created.";
    } else {
        $error_message = "Registration failed: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Registration | Taste of India</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="customer-theme.css">
</head>
<body>
    <?php include 'customer_navbar.php'; ?>

    <div class="container auth-layout">
        <div class="row justify-content-center w-100">
            <div class="col-md-8 col-lg-6">
                <div class="card auth-card">
                    <div class="card-body p-4 p-md-5">
                        <span class="eyebrow justify-content-center d-flex"><i class="bi bi-person-plus"></i> Start ordering today</span>
                        <h2 class="text-center auth-card-title">Join Taste of India</h2>
                        <p class="text-center auth-card-subtitle">
                            Create your account to order food from your preferred outlet.
                        </p>

                        <?php if ($success_message != "") { ?>
                            <div class="alert alert-success"><?php echo $success_message; ?></div>
                        <?php } ?>

                        <?php if ($error_message != "") { ?>
                            <div class="alert alert-danger"><?php echo $error_message; ?></div>
                        <?php } ?>

                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="full_name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="full_name" name="full_name" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
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
                                    <i class="bi bi-check2-circle"></i>
                                    <span>Register</span>
                                </button>
                            </div>
                        </form>

                        <p class="auth-footer-note text-center mt-4 mb-0">Already have an account? <a href="login.php">Login here</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

