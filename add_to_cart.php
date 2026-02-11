<?php
session_start();

// ۱. گرفتن ID محصول از طرف جاوااسکریپت
if(isset($_POST['product_id'])) {

    $id = $_POST['product_id'];

    // ۲. اگه سبد خرید وجود نداشت، یکی بساز (یه آرایه خالی)
    if(!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // ۳. محصول رو بنداز توی سبد
    // (اینجا ساده‌ترین روش رو رفتیم: فقط ID رو ذخیره میکنیم)
    $_SESSION['cart'][] = $id;

    echo count($_SESSION['cart']); // تعداد کل آیتم‌ها رو برگردون به JS
}
?>
