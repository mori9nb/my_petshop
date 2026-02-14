<?php
include 'includes/db.php';
include 'includes/header.php';

// --- بخش جدید: لاجیک حذف آیتم ---
if(isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id'])) {

    $id_to_remove = $_GET['id'];

    // ۱. پیدا کردن جایگاه محصول توی آرایه سبد خرید
    $key = array_search($id_to_remove, $_SESSION['cart']);

    // ۲. اگه پیدا شد، حذفش کن
    if($key !== false) {
        unset($_SESSION['cart'][$key]);

        // ۳. آرایه رو مرتب کن (که سوراخ توی ایندکس‌ها نمونه)
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }

    // ۴. رفرش کردن صفحه (که ID از آدرس پاک بشه و دوباره حذف نکنه)
    header("Location: cart.php");
    exit();
}
?>

<div class="container mt-5">
    <h2>Your Shopping Cart 🛍️</h2>
    <hr>

    <table class="table table-bordered table-hover bg-white">
        <thead>
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Price with discount</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // چک میکنیم سبد خالی نباشه
        if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {

            $total_price = 0;

            // لیست IDها رو به رشته تبدیل میکنیم (مثلاً: 1,5,2)
            $ids = implode(',', $_SESSION['cart']);

            // محصولاتی که توی سبد هستن رو از دیتابیس میاریم
            $sql = "SELECT * FROM products WHERE id IN ($ids)";

            $result = mysqli_query($conn, $sql);

            while($row = mysqli_fetch_assoc($result)) {
                if ($row['sale_price'] != 0) {
                    $total_price += $row['sale_price'];
                }
                else $total_price += $row['price'];
                ?>
                <tr>
                    <td>
                        <img src="assets/images/<?php echo $row['image']; ?>" width="50" class="rounded me-2">
                        <?php echo $row['name']; ?>
                    </td>
                    <td>$<?php echo $row['price']; ?></td>
                    <td>$<?php if ($row['sale_price']){echo $row['sale_price'];} else echo $row['price']; ?></td>
                    <td><a href="cart.php?action=remove&id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">
                            Remove ❌
                        </a></td>
                </tr>
                <?php
            }
        } else {
            echo "<tr><td colspan='3' class='text-center'>Your cart is empty! 😢</td></tr>";
            $total_price = 0;
        }
        ?>
        </tbody>
    </table>

    <div class="text-end mt-4">
        <h3>Total Price: <span class="text-success">$<?php echo isset($total_price) ? $total_price : 0; ?></span></h3>

        <a href="checkout.php" class="btn btn-success btn-lg mt-2 ms-2">Checkout (Pay) 💳</a>
    </div>

</div>

</body>
</html>
