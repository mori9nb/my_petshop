<?php
// اگه سشن استارت نشده، استارتش کن (ساده و استاندارد)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// --- منطق ساده و نوب-پسند برای شمارش سبد خرید ---
$cart_count = 0;

// چک میکنیم اگه سبد خرید وجود داشت
if (isset($_SESSION['cart'])) {
    // چون سبد خریدمون فقط یه لیست ساده از ID هاست (مثلا: [1, 5, 2])
    // تابع count خودش میگه چند تا توشه. نیاز به حلقه پیچیده نیست.
    $cart_count = count($_SESSION['cart']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pet Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">🐶 LUNA Pet Shop</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
            </ul>

            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link position-relative" href="cart.php">
                        <i class="fas fa-shopping-cart"></i> Cart
                        <span class="badge bg-danger rounded-pill" id="cart-count">
                            <?php echo $cart_count; ?>
                        </span>
                    </a>
                </li>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item ms-3">
                        <span class="navbar-text text-white">Hello, <?php echo $_SESSION['username']; ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item ms-2"><a class="nav-link" href="login.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>