$(document).ready(function () {
    $('#reviewForm').on('submit', function (e) {
        e.preventDefault();
        let token = $('meta[name="csrf-token"]').attr("content");
        let formData = new FormData(this);

        $.ajax({
            url: "/review/add",
            method: 'POST',
            data: formData,
            headers: { "X-CSRF-TOKEN": token },
            processData: false,
            contentType: false,
            success: function (response) {
                Swal.fire({
                    title: "Thông báo",
                    text: response.message,
                    icon: "success",
                    confirmButtonText: "OK",
                });
                $('#reviewModal').modal('hide');
                $('#reviewForm')[0].reset();
                $('.open-review-modal[data-order-id="'+ response.order_id + '"][data-product-id="'+ response.product_id + '"]').hide();

            },
            error: function (xhr) {
                const errors = xhr.responseJSON.errors;
                $('#ratingError').text('');
                $('#messageError').text('');
                if (errors.rating) {
                    $('#ratingError').text(errors.rating[0]);
                }
                if (errors.message) {
                    $('#messageError').text(errors.message[0]);
                }
            }

        });
    });
});


$(document).ready(function () {
    $('.open-review-modal').on('click', function () {
        const orderId = $(this).data('order-id');
        const productId = $(this).data('product-id');

        $('#order_id').val(orderId);
        $('#product_id').val(productId);

        $('#rating').val(0);
        $('#ratingError').text('');
        $('#messageError').text('');
        $('#errorMessages').html('');
        $('#message').val('');
        $('#starRating .star').removeClass('selected');
    });
});

