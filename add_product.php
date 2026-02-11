<?php
session_start();
include 'includes/db.php';

// امنیت
if ($_SESSION['role'] !== 'admin') header("Location: index.php");

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $sale_price = $_POST['sale_price']; // برای تخفیف
    $category = $_POST['category'];
    $description = $_POST['description'];

    // --- آپلود عکس ---
    $image = $_FILES['image']['name'];
    $target = "assets/images/" . basename($image);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        // ذخیره در دیتابیس
        $sql = "INSERT INTO products (name, price, sale_price, category, description, image) 
                VALUES ('$name', '$price', '$sale_price', '$category', '$description', '$image')";
        mysqli_query($conn, $sql);
        header("Location: admin_panel.php"); // برگرد به پنل
    } else {
        $msg = "آپلود عکس شکست خورد!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-5">
<div class="container bg-white p-4 shadow rounded" style="max-width: 600px;">
    <h3>Add New Product 📦</h3>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3"><label>Product Name</label><input type="text" name="name" class="form-control" required></div>

        <div class="row">
            <div class="col"><label>Price ($)</label><input type="number" name="price" class="form-control" required></div>
            <div class="col"><label>Sale Price ($) <small class="text-muted">(Optional)</small></label><input type="number" name="sale_price" class="form-control" value="0"></div>
        </div>

        <div class="mb-3 mt-3"><label>Category</label><input type="text" name="category" class="form-control" placeholder="e.g. Food, Toys..." required></div>
        <div class="mb-3"><label>Description</label><textarea name="description" class="form-control"></textarea></div>

        <div class="mb-3">
            <label>Image</label>
            <input type="file" name="image" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success w-100">Save Product</button>
        <a href="admin_panel.php" class="btn btn-secondary w-100 mt-2">Cancel</a>
    </form>
</div>
</body>
</html>