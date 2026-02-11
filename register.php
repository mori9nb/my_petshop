<?php
include 'includes/db.php';
include 'includes/header.php';
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // کلک: اگه اسم یوزر 'admin' بود، نقشش بشه ادمین
    $role = ($username === 'admin') ? 'admin' : 'user';

    // هش کردن رمز
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$hashed_password', '$role')";

    // --- تغییر مهم اینجاست ---
    try {
        mysqli_query($conn, $sql);
        $message = "✅ registered successfully <a href='login.php'>login</a>";
    } catch (mysqli_sql_exception $e) {
        // کد ۱۰۶۲ یعنی خطای تکراری بودن (Duplicate Entry)
        if ($e->getCode() == 1062) {
            $message = "❌ this username already exists!, choose another one!";
        } else {
            $message = "❌ unknown error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center justify-content-center" style="height: 100vh; background-color: #f8f9fa;">
<div class="card p-4 shadow-sm" style="width: 350px;">
    <h3 class="text-center mb-3">📝 sign up</h3>

    <?php if($message): ?>
        <div class="alert <?php echo (strpos($message, '✅') !== false) ? 'alert-success' : 'alert-danger'; ?>">
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
        <button type="submit" class="btn btn-success w-100">sign up</button>
    </form>
    <div class="text-center mt-3">
        <a href="login.php" class="text-decoration-none">you have an account? login</a>
    </div>
</div>
</body>
</html>