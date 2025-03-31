$(document).ready(function () {
    // Thêm sản phẩm vào giỏ hàng
    $(document).on("click", ".add-to-cart", function (e) {
        e.preventDefault();

        let product_id = $(this).data("id");
        let quantityInput = $(this).closest(".product-item").find(".product-quantity");
        let quantity = quantityInput.length ? quantityInput.val() : 1; // Mặc định là 1 nếu không có input

        let token = $('meta[name="csrf-token"]').attr("content");

        $.ajax({
            url: "/cart/add",
            type: "POST",
            headers: { "X-CSRF-TOKEN": token },
            data: {
                _token: token,
                product_id: product_id,
                quantity: quantity,
            },
            success: function (response) {
                alert(response.message);
                $("#cart-count").text(response.cart_count);
            },
            error: function (xhr) {
                if (xhr.status === 401) {
                    alert("Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng");
                } else {
                    alert("Có lỗi xảy ra, vui lòng thử lại");
                }
            },
        });
    });


    $(document).on("click", ".btn-plus", function () {
        let input = $(this).closest("tr").find(".quantity-input");
        let quantity = parseInt(input.val()) + 1;
        input.val(quantity);
        updateCart($(this).data("id"), quantity);
    });


    $(document).on("click", ".btn-minus", function () {
        let input = $(this).closest("tr").find(".quantity-input");
        let quantity = Math.max(1, parseInt(input.val()) - 1); // Không cho số lượng < 1
        input.val(quantity);
        updateCart($(this).data("id"), quantity);
    });


    function updateCart(cartId, quantity) {
        let token = $('meta[name="csrf-token"]').attr("content");

        $.ajax({
            url: "/cart/update",
            type: "POST",
            headers: { "X-CSRF-TOKEN": token },
            data: {
                _token: token,
                id: cartId,
                quantity: quantity,
            },
            success: function (response) {
                if (response.success) {
                    location.reload();
                }
            },
            error: function () {
                alert("Có lỗi xảy ra!");
            },
        });
    }

    $(document).on("click", ".remove-item", function (e) {
        e.preventDefault();

        let cartId = $(this).data("id");
        let token = $('meta[name="csrf-token"]').attr("content");

        $.ajax({
            url: "/cart/remove",
            type: "POST",
            headers: { "X-CSRF-TOKEN": token },
            data: {
                _token: token,
                id: cartId,
            },
            success: function (response) {
                if (response.success) {
                    $("tr[data-row='" + cartId + "']").remove();
                    $("#cart-count").text(response.cart_count);
                }
            },
            error: function () {
                alert("Có lỗi xảy ra!");
            },
        });
    });
});
