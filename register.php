<?php
include 'includes/db.php';
include 'includes/header.php'; // این فایل خودش بادی و استایل‌ها رو میاره

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // کلک دانشجویی: اگه اسم یوزر 'admin' بود، نقشش بشه ادمین
    $role = ($username === 'admin') ? 'admin' : 'user';

    // هش کردن رمز
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$hashed_password', '$role')";

    try {
        mysqli_query($conn, $sql);
        // استفاده از کلاس‌های بوت‌استرپ برای رنگ سبز پیام
        $message = "<span class='text-success'>✅ Registered successfully! <a href='login.php'>Login here</a></span>";
    } catch (mysqli_sql_exception $e) {
        // کد ۱۰۶۲ یعنی خطای تکراری بودن (Duplicate Entry)
        if ($e->getCode() == 1062) {
            $message = "<span class='text-danger'>❌ Username already exists! Try another one.</span>";
        } else {
            $message = "<span class='text-danger'>❌ Error: " . $e->getMessage() . "</span>";
        }
    }
}
?>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card p-4 shadow-sm" style="width: 350px;">
        <h3 class="text-center mb-3">📝 Sign Up</h3>

        <?php if($message): ?>
            <div class="alert alert-light border text-center">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Sign Up</button>
        </form>

        <div class="text-center mt-3">
            <a href="login.php" class="text-decoration-none">Already have an account? Login</a>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>