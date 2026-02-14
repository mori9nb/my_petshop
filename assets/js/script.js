$(document).ready(function() {

    // وقتی روی دکمه‌ای کلیک شد که کلاس add-to-cart داره
    $(".add-to-cart").click(function(e) {

        e.preventDefault(); // نذار صفحه رفرش بشه

        var btn = $(this); // دکمه‌ای که کلیک شده
        var productId = btn.data("id"); // آیدی رو مستقیم از دکمه بگیر

        // ارسال به PHP
        $.ajax({
            url: "add_to_cart.php",
            method: "POST",
            data: { product_id: productId }, // اسم این 'product_id' باید با فایل PHP یکی باشه
            success: function(response) {

                // 1. آپدیت کردن عدد قرمز بالای سبد خرید
                $("#cart-count").text(response);

                // 2. انیمیشن دکمه (سبز بشه)
                var oldText = btn.text();
                btn.text("Added! ✅").removeClass("btn-primary").addClass("btn-success");

                // بعد از 1 ثانیه برگرد به حالت اول
                setTimeout(function() {
                    btn.text(oldText).removeClass("btn-success").addClass("btn-primary");
                }, 1000);
            }
        });
    });

});