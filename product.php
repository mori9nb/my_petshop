<?php
include 'includes/db.php';

// ۱. چک میکنیم ببینیم ID توی آدرس هست؟ (مثلا product.php?id=5)
if(isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // ۲. کوئری میزنیم که فقط همون محصول رو بیاره
    $sql = "SELECT * FROM products WHERE id = $product_id";
    $result = mysqli_query($conn, $sql);
    $product = mysqli_fetch_assoc($result);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $product['name']; ?> 🐾</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">🐶 My Pet Shop</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Cart <span class="badge bg-light text-dark" id="cart-count">0</span></a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">

    <a href="index.php" class="btn btn-outline-secondary mb-3">← Back to Home</a>

    <div class="row">
        <div class="col-md-6">
            <img src="assets/images/<?php echo $product['image']; ?>" class="img-fluid rounded shadow" alt="Product Image">
        </div>

        <div class="col-md-6">
            <h1 class="fw-bold"><?php echo $product['name']; ?></h1>
            <hr>
            <h3 class="text-success my-3">$<?php echo $product['price']; ?></h3>

            <p class="lead"><?php echo $product['description']; ?></p>

            <p class="text-muted">Category: <span class="badge bg-info"><?php echo $product['category']; ?></span></p>

            <button class="btn btn-primary btn-lg w-100 mt-3 add-to-cart" data-id="<?php echo $row['id']; ?>">Add to Cart 🛒</button>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="assets/js/script.js"></script>

</body>
</html>