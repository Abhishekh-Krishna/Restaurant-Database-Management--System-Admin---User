<?php
session_start();
include '../db/config.php';

$success_message = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT admin_id, full_name FROM Admin
            WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['admin_id'] = $row['admin_id'];
        $_SESSION['full_name'] = $row['full_name'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error_message = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Taste of India</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="admin-theme.css">
</head>
<body>
    <div class="container auth-layout">
        <div class="row justify-content-center w-100">
            <div class="col-md-7 col-lg-5">
                <div class="card auth-card">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <img src="../assets/logo.svg" alt="Taste of India" class="brand-logo mx-auto">
                        </div>
                        <span class="eyebrow justify-content-center d-flex"><i class="bi bi-shield-lock"></i> Admin access</span>
                        <h2 class="text-center auth-card-title">Admin Login</h2>
                        <p class="text-center auth-card-subtitle">
                            Sign in to manage Taste of India outlets, orders, payments, and subscriptions.
                        </p>

                        <?php if ($success_message != "") { ?>
                            <div class="alert alert-success"><?php echo $success_message; ?></div>
                        <?php } ?>

                        <?php if ($error_message != "") { ?>
                            <div class="alert alert-danger"><?php echo $error_message; ?></div>
                        <?php } ?>

                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-premium">
                                    <i class="bi bi-arrow-right-circle"></i>
                                    <span>Login</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
