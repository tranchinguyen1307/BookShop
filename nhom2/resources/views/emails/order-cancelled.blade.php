<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Báo Hủy Đơn Hàng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
            padding: 20px;
        }

        h2 {
            color: #2c3e50;
        }

        .cancellation-info {
            background-color: #ffcccc;
            border-left: 4px solid red;
            padding: 10px;
            margin: 20px 0;
        }

        .footer {
            font-size: 0.9em;
            color: #777;
        }
    </style>
</head>

<body>
    <h2>Xin chào {{ $order->user->name }},</h2>

    <p>Chúng tôi xin thông báo rằng đơn hàng <strong>#{{ $order->order_code }}</strong> của bạn đã bị <span
            style="color:red;">hủy</span>.</p>

    <div class="cancellation-info">
        <p><strong>Lý do hủy đơn hàng (do quản trị viên):</strong></p>
        <p>{{ $cancellation_reason ?? 'Không có lý do' }}</p>
    </div>

    <p>Nếu bạn có bất kỳ thắc mắc nào, xin vui lòng liên hệ lại với chúng tôi để được hỗ trợ.</p>

    <p class="footer">Trân trọng,<br />Đội ngũ quản lý cửa hàng</p>
</body>

</html>