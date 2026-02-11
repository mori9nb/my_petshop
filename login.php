<?php
include 'includes/db.php';
include 'includes/header.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // جستجو بر اساس یوزرنیم (نه ایمیل)
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] === 'admin') {
                header("Location: admin_panel.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            $error = "wrong password!";
        }
    } else {
        $error = "username not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center justify-content-center" style="height: 100vh; background-color: #f8f9fa;">
<div class="card p-4 shadow-sm" style="width: 350px;">
    <h3 class="text-center mb-3">🔐 login</h3>
    <?php if($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <input type="text" name="username" class="form-control" placeholder="user name" required>
        </div>
        <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">login</button>
    </form>
    <div class="text-center mt-3">
        <a href="register.php" class="text-decoration-none">haven't registered</a>
    </div>
</div>
</body>
</html>