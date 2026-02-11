<?php
include 'includes/db.php';

// امنیت: فقط ادمین راه میدیم
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// اگه دکمه حذف زده شد
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    mysqli_query($conn, "DELETE FROM products WHERE id=$id");
    header("Location: admin_panel.php"); // رفرش صفحه
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark px-4">
    <a class="navbar-brand" href="#">🔧 Admin Panel</a>
    <div>
        <a href="index.php" class="btn btn-outline-light btn-sm me-2">View Website</a>
        <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
    </div>
</nav>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Manage Products</h2>
        <a href="add_product.php" class="btn btn-success">+ Add New Product</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Sale Price (Discount)</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $sql = "SELECT * FROM products ORDER BY id DESC";
                $result = mysqli_query($conn, $sql);

                while ($row = mysqli_fetch_assoc($result)) {
                    // اگه تخفیف داشت، سبز نشون بده
                    $sale_style = ($row['sale_price'] > 0) ? "text-danger fw-bold" : "text-muted";
                    ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td>
                            <img src="assets/images/<?php echo $row['image']; ?>" width="50" height="50" style="object-fit: cover; border-radius: 5px;">
                        </td>
                        <td><?php echo $row['name']; ?></td>
                        <td>$<?php echo $row['price']; ?></td>
                        <td class="<?php echo $sale_style; ?>">
                            <?php echo ($row['sale_price'] > 0) ? "$" . $row['sale_price'] : "-"; ?>
                        </td>
                        <td><span class="badge bg-info text-dark"><?php echo $row['category']; ?></span></td>
                        <td>
                            <a href="edit_product.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                            <a href="admin_panel.php?delete_id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>