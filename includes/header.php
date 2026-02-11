<?php
// چک می‌کنیم اگه سشن استارت نشده، استارتش کنیم
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// محاسبه تعداد آیتم‌های سبد خرید (با سیستم ضد خطا)
$cart_count = 0;
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        // فقط در صورتی بشمار که آیتم واقعاً آرایه باشه و فیلد quantity داشته باشه
        if (is_array($item) && isset($item['quantity'])) {
            $cart_count += $item['quantity'];
        }
    }
} else {
    // اگه سبد خرید خراب بود یا وجود نداشت، ریستش کن که ارور نده
    $_SESSION['cart'] = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Pet Shop 🐾</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold text-warning" href="index.php">
            <i class="fas fa-paw"></i> My Pet Shop
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php#products-section">Products</a></li>
            </ul>
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item me-3">
                    <a class="nav-link position-relative" href="cart.php">
                        <i class="fas fa-shopping-cart fa-lg"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            <?php echo $cart_count; ?>
                        </span>
                    </a>
                </li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">
                            <?php echo $_SESSION['username']; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <?php if($_SESSION['role'] === 'admin'): ?>
                                <li><a class="dropdown-item" href="admin_panel.php">Admin Panel</a></li>
                            <?php endif; ?>
                            <li><a class="dropdown-item text-danger" href="logout.php">Logout</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link btn btn-sm btn-outline-light ms-2" href="login.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link btn btn-sm btn-warning text-dark ms-2" href="register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>