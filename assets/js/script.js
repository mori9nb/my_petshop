$(document).ready(function(){

    $(".add-to-cart").click(function(){

        var btn = $(this);
        // ۱. پیدا کردن ID محصول (از ویژگی data-id که قبلاً توی HTML گذاشتیم)
        // اگه توی product.php دکمه کار نکرد، چک کن که دکمه کلاس add-to-cart داشته باشه
        // و اتریبیوت data-id="<?php echo $product['id']; ?>" رو هم داشته باشه.

        // نکته: برای اینکه توی صفحه product.php هم کار کنه، باید به دکمه اونجا هم data-id بدی.
        // فعلا فرض میکنیم توی صفحه اصلی هستیم.
        var id = btn.closest(".card").find("a").attr("href").split("=")[1];
        // یا روش تمیزتر: توی HTML به دکمه data-id بده.

        // بیا یه روش مطمئن‌تر بریم که همه جا کار کنه:
        // فرض میکنیم توی HTML دکمه این شکلیه: <button ... data-id="1">
        var productId = btn.data("id");

        if(!productId) {
            // اگه توی صفحه product.php بودیم و data-id نذاشته بودیم، از URL بگیریم
            const urlParams = new URLSearchParams(window.location.search);
            productId = urlParams.get('id');
        }

        // ۲. ارسال درخواست به PHP (آجاکس)
        $.post("add_to_cart.php", { product_id: productId }, function(data){

            // ۳. وقتی PHP جواب داد:
            $("#cart-count").text(data); // عدد سبد خرید رو آپدیت کن

            // انیمیشن دکمه
            btn.text("Added! ✅").removeClass("btn-primary").addClass("btn-success");
            setTimeout(function(){
                btn.text("Add to Cart 🛒").removeClass("btn-success").addClass("btn-primary");
            }, 1000);
        });

    });
});