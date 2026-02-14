<?php
include 'includes/db.php';
include 'includes/header.php';

// ۱. امنیت: اگه کاربر لاگین نکرده، بره صفحه لاگین
if (!isset($_SESSION['user_id'])) {
    echo "<script>
            alert('Please login to continue checkout!'); 
            window.location.href='login.php';
          </script>";
    exit();
}

// ۲. امنیت: اگه سبد خرید خالیه، برگرده صفحه اصلی
if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    echo "<script>window.location.href='index.php';</script>";
    exit();
}

$message = "";

// ۳. محاسبه قیمت کل سبد خرید (برای نمایش و ثبت در دیتابیس)
$total_price = 0;
// چون سبد خریدمون فقط شامل ID هست، باید قیمت‌ها رو از دیتابیس بپرسیم
foreach ($_SESSION['cart'] as $product_id) {
    $sql_price = "SELECT price, sale_price FROM products WHERE id = $product_id";
    $result_price = mysqli_query($conn, $sql_price);
    $row_price = mysqli_fetch_assoc($result_price);

    // اگه تخفیف داشت، قیمت تخفیفی رو حساب کن
    if ($row_price['sale_price'] > 0) {
        $total_price += $row_price['sale_price'];
    } else {
        $total_price += $row_price['price'];
    }
}

// ۴. وقتی دکمه "Pay & Place Order" زده شد
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_id = $_SESSION['user_id'];
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    // الف) ثبت سفارش در جدول orders
    $sql_order = "INSERT INTO orders (user_id, total_price, address, phone) VALUES ('$user_id', '$total_price', '$address', '$phone')";

    if (mysqli_query($conn, $sql_order)) {
        // گرفتن ID سفارشی که همین الان ساخته شد
        $order_id = mysqli_insert_id($conn);

        // ب) ثبت تک‌تک محصولات در جدول order_items
        foreach ($_SESSION['cart'] as $product_id) {
            $sql_item = "INSERT INTO order_items (order_id, product_id) VALUES ('$order_id', '$product_id')";
            mysqli_query($conn, $sql_item);
        }

        // ج) خالی کردن سبد خرید (چون خرید انجام شد)
        unset($_SESSION['cart']);

        $message = "✅ Order placed successfully! Thank you.";
    } else {
        $message = "❌ Error: " . mysqli_error($conn);
    }
}
?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="fas fa-money-bill-wave"></i> Checkout</h4>
                </div>
                <div class="card-body">

                    <?php if($message): ?>
                        <div class="alert alert-success text-center">
                            <h3><?php echo $message; ?></h3>
                            <a href="index.php" class="btn btn-outline-success mt-3">Back to Home</a>
                        </div>
                    <?php else: ?>

                        <h5 class="text-center mb-4">
                            Total to Pay: <span class="text-success fw-bold">$<?php echo $total_price; ?></span>
                        </h5>

                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Delivery Address:</label>
                                <textarea name="address" class="form-control" rows="3" required placeholder="Enter your full address..."></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Phone Number:</label>
                                <input type="text" name="phone" class="form-control" required placeholder="0912...">
                            </div>

                            <hr>

                            <button type="submit" class="btn btn-success w-100 btn-lg">
                                Pay & Place Order 💳
                            </button>

                            <a href="cart.php" class="btn btn-secondary w-100 mt-2">Back to Cart</a>
                        </form>

                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>