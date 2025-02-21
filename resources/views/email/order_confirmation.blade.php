<!DOCTYPE html>
<html>
<head>
    <title>Xác nhận đơn hàng</title>
</head>
<body>
    <h2>Chào {{ $order['customer_name'] }},</h2>
    <p>Cảm ơn bạn đã đặt hàng tại Pickleball Shop!</p>
    <p><strong>Mã đơn hàng:</strong> {{ $order['order_id'] }}</p>
    <p><strong>Sản phẩm:</strong> {{ $order['product_name'] }}</p>
    <p><strong>Tổng tiền:</strong> {{ number_format($order['total_price'], 0, ',', '.') }} VND</p>
    <p>Chúng tôi sẽ liên hệ với bạn sớm nhất có thể.</p>
</body>
</html>
