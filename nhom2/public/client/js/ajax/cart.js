$(document).ready(function () {
    // Thêm sản phẩm vào giỏ hàng
    $(document).on("click", ".add-to-cart", function (e) {
        e.preventDefault();

        let product_id = $(this).data("id");
        let quantityInput = $(this).closest(".product-item").find(".product-quantity");
        let quantity = quantityInput.length ? quantityInput.val() : 1;

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
                Swal.fire({
                    title: "Thông báo",
                    text: response.message,
                    icon: "success",
                    confirmButtonText: "OK",
                });
                
                $("#cart-count").text(response.cart_count);
            },
            error: function (xhr) {
                if (xhr.status === 401) {
                    Swal.fire({
                        title: "Thông báo",
                        text: "Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng",
                        icon: "warning",
                        confirmButtonText: "OK",
                    });
                } else {
                    Swal.fire({
                        title: "Thông báo",
                        text: "Có lỗi xảy ra, vui lòng thử lại",
                        icon: "warning",
                        confirmButtonText: "OK",
                    });
                }
            },
        });
    });

    // Tăng số lượng
    $(document).on("click", ".btn-plus", function () {
        let input = $(this).closest("tr").find(".quantity-input");
        let quantity = parseInt(input.val()) + 1;
        input.val(quantity);
        updateCart($(this).data("id"), quantity, input);
    });

    // Giảm số lượng
    $(document).on("click", ".btn-minus", function () {
        let input = $(this).closest("tr").find(".quantity-input");
        let quantity = Math.max(1, parseInt(input.val()) - 1);
        input.val(quantity);
        updateCart($(this).data("id"), quantity, input);
    });

    // Cập nhật giỏ hàng
    function updateCart(cartId, quantity, input) {
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
                    let row = input.closest("tr");

                    // Lấy giá sản phẩm từ cột giá (cột 3 trong bảng)
                    let priceText = row.find("td:nth-child(3)").text().replace(/\D/g, "");
                    let price = parseFloat(priceText);

                    // Cập nhật tổng tiền của sản phẩm
                    let totalPrice = price * quantity;
                    row.find(".cart-item-total").text(totalPrice.toLocaleString() + "₫");

                    // Cập nhật tổng tiền giỏ hàng
                    updateCartTotal();
                }
            },
            error: function () {
                alert("Có lỗi xảy ra!");
            },
        });
    }

    function updateCartTotal() {
        let totalCartPrice = 0;
        $(".cart-item-total").each(function () {
            totalCartPrice += parseFloat($(this).text().replace(/\D/g, ""));
        });
        $(".cart-total").text(totalCartPrice.toLocaleString() + "₫");
    }

    // Xóa sản phẩm khỏi giỏ hàng
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
                    updateCartTotal();
                    $("#cart-count").text(response.cart_count);
                }
            },
            error: function () {
                alert("Có lỗi xảy ra!");
            },
        });
    });
});
