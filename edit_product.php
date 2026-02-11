<?php
session_start();
include 'includes/db.php';

if ($_SESSION['role'] !== 'admin') header("Location: index.php");

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");
$row = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $sale_price = $_POST['sale_price'];
    $category = $_POST['category'];
    $description = $_POST['description'];

    // اگه عکس جدید آپلود کرد، عکس رو عوض کن، وگرنه همون قبلی بمونه
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "assets/images/" . $image);
        $sql = "UPDATE products SET name='$name', price='$price', sale_price='$sale_price', category='$category', description='$description', image='$image' WHERE id=$id";
    } else {
        $sql = "UPDATE products SET name='$name', price='$price', sale_price='$sale_price', category='$category', description='$description' WHERE id=$id";
    }

    mysqli_query($conn, $sql);
    header("Location: admin_panel.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-5">
<div class="container bg-white p-4 shadow rounded" style="max-width: 600px;">
    <h3>Edit Product ✏️</h3>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Product Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo $row['name']; ?>" required>
        </div>

        <div class="row">
            <div class="col">
                <label>Price ($)</label>
                <input type="number" name="price" class="form-control" value="<?php echo $row['price']; ?>" required>
            </div>
            <div class="col">
                <label class="text-danger">Sale Price ($)</label>
                <input type="number" name="sale_price" class="form-control border-danger" value="<?php echo $row['sale_price']; ?>">
                <small class="text-muted">Enter 0 to remove discount.</small>
            </div>
        </div>

        <div class="mb-3 mt-3"><label>Category</label><input type="text" name="category" class="form-control" value="<?php echo $row['category']; ?>" required></div>
        <div class="mb-3"><label>Description</label><textarea name="description" class="form-control"><?php echo $row['description']; ?></textarea></div>

        <div class="mb-3">
            <label>Change Image (Optional)</label>
            <input type="file" name="image" class="form-control">
            <img src="assets/images/<?php echo $row['image']; ?>" width="70" class="mt-2 rounded">
        </div>

        <button type="submit" class="btn btn-primary w-100">Update Product</button>
        <a href="admin_panel.php" class="btn btn-secondary w-100 mt-2">Cancel</a>
    </form>
</div>
</body>
</html>
