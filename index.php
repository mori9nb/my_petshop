<?php
include 'includes/db.php';
include "includes/header.php";
?>



<div class="hero-section mb-5">
    <div class="text-center animate-up">
        <h1 class="display-4 fw-bold">Happy Pets, Happy Life!</h1>
        <p class="lead">Everything your pet needs in one place.</p>
    </div>
</div>

<div class="container">

    <div class="section-title">
        <h3>🔥 Special Offers <small class="text-muted fs-6">Limited Time!</small></h3>
    </div>
    <div class="row mb-5">
        <?php
        // محصولاتی که sale_price بزرگتر از ۰ دارن
        $sql_sale = "SELECT * FROM products WHERE sale_price > 0 LIMIT 4";
        $result_sale = mysqli_query($conn, $sql_sale);

        if(mysqli_num_rows($result_sale) > 0) {
            while($row = mysqli_fetch_assoc($result_sale)) {
                ?>
                <div class="col-md-3 col-6 mb-3">
                    <div class="card h-100 border-danger">
                        <span class="badge bg-danger position-absolute top-0 end-0 m-2">SALE</span>

                        <a href="product.php?id=<?php echo $row['id']; ?>">
                            <img src="assets/images/<?php echo $row['image']; ?>" class="card-img-top p-3" alt="Product">
                        </a>
                        <div class="card-body text-center">
                            <h6 class="card-title"><?php echo $row['name']; ?></h6>

                            <div class="mb-2">
                                <small class="text-muted text-decoration-line-through">$<?php echo $row['price']; ?></small>
                                <span class="text-danger fw-bold fs-5">$<?php echo $row['sale_price']; ?></span>
                            </div>

                            <button class="btn btn-outline-danger btn-sm w-100 add-to-cart" data-id="<?php echo $row['id']; ?>">Add 🛒</button>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p class='text-muted'>No discounts at the moment.</p>";
        }
        ?>
    </div>

    <div class="section-title">
        <h3>🆕 New Arrivals <a href="#" class="float-end fs-6 text-decoration-none">View All</a></h3>
    </div>
    <div class="row mb-5">
        <?php
        // آخرین محصولات (بر اساس ID بزرگتر)
        $sql_new = "SELECT * FROM products ORDER BY id DESC LIMIT 4";
        $result_new = mysqli_query($conn, $sql_new);

        while($row = mysqli_fetch_assoc($result_new)) {
            ?>
            <div class="col-md-3 col-6 mb-3">
                <div class="card h-100">
                    <a href="product.php?id=<?php echo $row['id']; ?>">
                        <img src="assets/images/<?php echo $row['image']; ?>" class="card-img-top p-3" alt="Product">
                    </a>
                    <div class="card-body text-center">
                        <h6 class="card-title"><?php echo $row['name']; ?></h6>

                        <?php if($row['sale_price'] > 0): ?>
                            <span class="text-danger fw-bold">$<?php echo $row['sale_price']; ?></span>
                        <?php else: ?>
                            <span class="text-dark fw-bold">$<?php echo $row['price']; ?></span>
                        <?php endif; ?>

                        <button class="btn btn-primary btn-sm w-100 mt-2 add-to-cart" data-id="<?php echo $row['id']; ?>">Add 🛒</button>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <div class="section-title">
        <h3>📂 Shop by Category</h3>
    </div>
    <div class="row mb-5 text-center">
        <?php
        // گرفتن دسته‌بندی‌های یکتا
        $sql_cat = "SELECT DISTINCT category FROM products";
        $result_cat = mysqli_query($conn, $sql_cat);

        while($row = mysqli_fetch_assoc($result_cat)) {
            ?>
            <div class="col-md-3 col-6 mb-3">
                <div class="card category-card p-4 bg-white shadow-sm">
                    <h5 class="m-0 text-dark"><?php echo $row['category']; ?> 🐾</h5>
                </div>
            </div>
        <?php } ?>
    </div>

</div>

<footer class="bg-dark text-white text-center py-4 mt-5">
    <p>&copy; 2026 My Pet Shop. All rights reserved.</p>
</footer>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/script.js"></script>

</body>
</html>