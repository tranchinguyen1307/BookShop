$(document).ready(function () {
    $(".select-item").prop("checked", true);

    // Nếu tất cả sản phẩm đều được chọn thì cũng check "Chọn tất cả"
    $("#select-all").prop("checked", $(".select-item:checked").length === $(".select-item").length);

    // Chọn hoặc bỏ chọn tất cả sản phẩm
    $("#select-all").change(function () {
        $(".select-item").prop("checked", $(this).prop("checked"));
        updateCartTotal(); // Cập nhật tổng tiền khi thay đổi
    });

    // Khi bỏ chọn sản phẩm, nếu tất cả đều bỏ check thì bỏ check "Chọn tất cả"
    $(document).on("change", ".select-item", function () {
        $("#select-all").prop("checked", $(".select-item:checked").length === $(".select-item").length);
        updateCartTotal(); // Cập nhật tổng tiền khi thay đổi
    });
    // Thêm sản phẩm vào giỏ hàng
    $(document).on("click", ".add-to-cart", function (e) {
        e.preventDefault();

        let product_id = $(this).data("id");
        var quantityInput = $(this).closest('.product-detail').find('.product-quantity');
        let quantity = quantityInput.length ? quantityInput.val() : 1;
        let maxQuantity = parseInt(quantityInput.attr("max"));

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
                var updatedMaxQuantity = response.max_quantity;
                quantityInput.attr("max", updatedMaxQuantity);
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
                    var response = JSON.parse(xhr.responseText);
                    Swal.fire({
                        title: "Thông báo",
                        text: response.message,
                        icon: "warning",
                        confirmButtonText: "OK",
                    });
                }
            },
        });
    });

    // Tăng số lượng
    $(document).on("click", ".cart-plus", function () {
        let input = $(this).closest("tr").find(".quantity-input");
        let quantity = parseInt(input.val()) + 1;
        let maxQuantity = parseInt(input.attr("max"))
        if (quantity > maxQuantity) {
            input.val(maxQuantity);
            quantity = maxQuantity;
            Swal.fire({
                title: "Thông báo",
                text: "Số lượng không thể vượt quá " + maxQuantity,
                icon: "warning",
                confirmButtonText: "OK",
            });
        }
        input.val(quantity);
        let row = $(this).closest("tr");
        row.find(".select-item").prop("checked", true);
        updateCart($(this).data("id"), quantity, input);
    });

    // Giảm số lượng
    $(document).on("click", ".cart-minus", function () {
        let input = $(this).closest("tr").find(".quantity-input");
        let quantity = parseInt(input.val()) - 1;
        input.val(quantity);
        let row = $(this).closest("tr");
        row.find(".select-item").prop("checked", true);
        updateCart($(this).data("id"), quantity, input);
    });

    $(document).on("click", ".product-plus", function () {
        let input = $(this).closest('.product-detail').find('.product-quantity');
        let quantity = parseInt(input.val()) + 1;
        let maxQuantity = parseInt(input.attr("max"))
        if (quantity > maxQuantity) {
            input.val(maxQuantity);
            quantity = maxQuantity;
            Swal.fire({
                title: "Thông báo",
                text: "Số lượng không thể vượt quá " + maxQuantity,
                icon: "warning",
                confirmButtonText: "OK",
            });
        }
        input.val(quantity);
    });

    $(document).on("change", ".quantity-input", function () {
        let input = $(this);
        let quantity = parseInt(input.val()) || 0;
        let maxQuantity = parseInt(input.attr("max"))
        if (quantity > maxQuantity) {
            input.val(maxQuantity);
            quantity = maxQuantity;
            Swal.fire({
                title: "Thông báo",
                text: "Số lượng không thể vượt quá " + maxQuantity,
                icon: "warning",
                confirmButtonText: "OK",
            });
        }
        let cartId = input.data("id");
        let row = $(this).closest("tr");
        row.find(".select-item").prop("checked", true);
        updateCart($(this).data("id"), quantity, input);
    })

    // Cập nhật giỏ hàng
    function updateCart(cartId, quantity, input) {
        let token = $('meta[name="csrf-token"]').attr("content");
        if (quantity <= 0) {
            removeFromCart(cartId);
            return;
        }

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
                    $("#cart-count").text(response.cart_count);

                    // Cập nhật tổng tiền giỏ hàng
                    updateCartTotal();
                }
            },
            error: function () {
                Swal.fire({
                    title: "Thông báo",
                    text: "Có lỗi xảy ra khi cập nhật, vui lòng thử lại",
                    icon: "warning",
                    confirmButtonText: "OK",
                });
            },
        });
    }

    function updateCartTotal() {
        let totalCartPrice = 0;

        $(".select-item:checked").each(function () {
            let row = $(this).closest("tr");
            let totalText = row.find(".cart-item-total").text().replace(/\D/g, "");
            totalCartPrice += parseFloat(totalText);
        });

        $(".cart-total").text(totalCartPrice.toLocaleString() + "₫");
    }

    // Xóa sản phẩm khỏi giỏ hàng
    function removeFromCart(cartId) {
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
                Swal.fire({
                    title: "Thông báo",
                    text: "Có lỗi xảy ra, vui lòng thử lại",
                    icon: "warning",
                    confirmButtonText: "OK",
                });
            },
        });
    }

    $(document).on("click", ".remove-item", function (e) {
        e.preventDefault();
        let cartId = $(this).data("id");
        removeFromCart(cartId);
    });


});
