<?php
include 'includes/db.php';
// اینجا هدر رو صدا میزنیم تا منو و استایل‌ها و سشن لود بشن
include 'includes/header.php';

// چک میکنیم آیدی محصول توی آدرس باشه
if(isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // امنیت: تبدیل به عدد (که کسی کد مخرب نذاره)
    $product_id = intval($product_id);

    $sql = "SELECT * FROM products WHERE id = $product_id";
    $result = mysqli_query($conn, $sql);
    $product = mysqli_fetch_assoc($result);
}
?>

<div class="container mt-5 mb-5">

    <a href="index.php" class="btn btn-outline-secondary mb-3">← Back to Home</a>

    <?php if($product): ?>
        <div class="row">
            <div class="col-md-6">
                <img src="assets/images/<?php echo $product['image']; ?>" class="img-fluid rounded shadow" alt="<?php echo $product['name']; ?>">
            </div>

            <div class="col-md-6">
                <h1 class="fw-bold"><?php echo $product['name']; ?></h1>
                <hr>

                <?php if($product['sale_price'] > 0): ?>
                    <h3 class="text-danger my-3">
                        $<?php echo $product['sale_price']; ?>
                        <small class="text-muted text-decoration-line-through fs-6">$<?php echo $product['price']; ?></small>
                    </h3>
                <?php else: ?>
                    <h3 class="text-success my-3">$<?php echo $product['price']; ?></h3>
                <?php endif; ?>

                <p class="lead"><?php echo $product['description']; ?></p>

                <p class="text-muted">Category: <span class="badge bg-info text-dark"><?php echo $product['category']; ?></span></p>

                <button class="btn btn-primary btn-lg w-100 mt-3 add-to-cart" data-id="<?php echo $product['id']; ?>">
                    Add to Cart 🛒
                </button>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-danger">Product not found!</div>
    <?php endif; ?>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/script.js"></script>

</body>
</html>